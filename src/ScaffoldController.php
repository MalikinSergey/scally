<?php

namespace Mlsg\Scally;

use Illuminate\Routing\Controller as BaseController;

class ScaffoldController extends BaseController
{
    
    public function create()
    {
        return view('scally::scaffold.create');
    }
    
    public function getStubsPath()
    {
        if (config('scally.stubs_path')) {
            return config('scally.stubs_path');
        } else {
            return __DIR__ . "/../stubs";
        }
    }
    
    public function store()
    {
        $stubsPath = $this->getStubsPath();
        
        $data = request()->all();
        
        $data['model_variable_plural'] = '$' . $data['model_slug_plural'];
        
        $data['model_variable'] = '$' . $data['model_slug'];
        
        $attributes = request('attributes');
        
        $attributes = \Arr::where($attributes, function ($item) {
            
            return data_get($item, 'name');
        });
        
        $map = [
            
            'AdminViewNs' => config('scally.admin_view_namespace'),
            'AdminRouteNs' => config('scally.admin_route_namespace'),
            'DummyNamespaceControllersAdmin' => config('scally.controller_namespace'),
            'DummyNamespaceModel' => config('scally.model_namespace'),
            'DummyAppNamespace' => trim(app()->getNamespace(), "\\"),
            'DummyModel' => $data['model_class_name'],
            'DummyPluralModel' => \Str::plural($data['model_class_name']),
            'DummySlug' => $data['model_slug'],
            'DummyPluralSlug' => $data['model_slug_plural'],
            'DummyName' => $data['model_name'],
            'DummyPluralName' => $data['model_name_plural'],
            'dummyTitleKey' => data_get($data, 'model_title_key', 'name')
        
        ];
        
        # declare directories
        
        $scaffoldDir = config('scally.scaffold_path') . "/" . $data['model_slug'];
        $controllersDir = $scaffoldDir . "/" . config('scally.controllers_path');
        $modelsDir = $scaffoldDir . "/" . config('scally.models_path');
        $migrationsDir = $scaffoldDir . "/database/migrations";
        $langDir = $scaffoldDir . "/resources/lang/" . config('scally.locale');
        $viewsDir = $scaffoldDir . "/resources/views/" . config('scally.admin_view_namespace') . "/" . $data['model_slug_plural'];
        
        # create directories
        
        \File::makeDirectory($controllersDir, 0777, true, true);
        \File::makeDirectory($modelsDir, 0777, true, true);
        \File::makeDirectory($migrationsDir, 0777, true, true);
        \File::makeDirectory($langDir, 0777, true, true);
        \File::makeDirectory($viewsDir, 0777, true, true);
        
        # migration
        
        $migrationContent = $this->makeMigrationContent($attributes);
        
        $migrationContent = $this->createContent(
            $stubsPath . '/dummy_migration.php',
            $map + ['#DummyTableAttibutes' => $migrationContent]
        );
        
        $migrationName = date('Y_m_d_His',
                0) . "_create_" . \Str::snake(\Str::plural($data['model_class_name'])) . "_table.php";
        
        \File::put($migrationsDir . "/" . $migrationName, $migrationContent);
        
        # lang
        
        $langContent = $this->makeLang($attributes);
        
        $langContent = "<?php\n\nreturn " . $this->varEncode($langContent) . ";";
        
        \File::put($langDir . "/" . $data['model_slug_plural'] . ".php",
            $langContent
        );
        
        # model
        
        $fillableKeys = \Arr::where($attributes, function ($item) {
            return data_get($item, 'editable');
        });
        
        $fillableKeys = \Arr::pluck($fillableKeys, 'name');
        
        $modelMap = [
            '$fillable' => '$fillable = ' . $this->varEncode($fillableKeys, ['array.inline' => true]),
            '$timestamps' => '$timestamps = ' . (data_get($data, 'timestamps', true) ? 'true' : 'false'),
        ];
        
        $modelContent = $this->createContent(
            $stubsPath . '/DummyModel.php',
            $map + $modelMap
        );
        
        \File::put($modelsDir . "/" . $data['model_class_name'] . ".php",
            $modelContent
        );
        
        #
        $controllerMap = [
            'DummyController' => $data['model_class_name'] . "Controller",
            '$dummies' => $data['model_variable_plural'],
            '$dummy' => $data['model_variable'],
            '[RULES]' => $this->makeValidationArray($attributes)
        ];
        
        $controllerContent = $this->createContent(
            $stubsPath . '/DummyController.php',
            $map + $controllerMap
        );
        
        \File::put($controllersDir . "/" . $data['model_class_name'] . "Controller.php",
            $controllerContent
        );
        
        # attributes for views
        
        $forms = $this->makeViewsForms($attributes, $map);
        
        # views
        
        $viewsMap = [
            '$dummies' => $data['model_variable_plural'],
            '$dummy' => $data['model_variable'],
            '{{--AttrForms--}}' => $forms
        ];
        
        $indexViewContent = $this->createContent(
            $stubsPath . '/views/index.blade.php',
            $map + $viewsMap
        );
        
        \File::put($viewsDir . "/index.blade.php",
            $indexViewContent
        );
        $createViewContent = $this->createContent(
            $stubsPath . '/views/create.blade.php',
            $map + $viewsMap
        );
        
        \File::put($viewsDir . "/create.blade.php",
            $createViewContent
        );
        
        $editViewContent = $this->createContent(
            $stubsPath . '/views/edit.blade.php',
            $map + $viewsMap
        );
        
        \File::put($viewsDir . "/edit.blade.php",
            $editViewContent
        );
        
        #
        
        $routesLine = "Route::resource('{$data['model_slug']}', '{$data['model_class_name']}Controller');";
        
        return $routesLine;
    }
    
    public function makeValidationArray($attributes)
    {
        
        $rules = [];
        
        foreach ($attributes as $attribute) {
            
            if (!data_get($attribute, 'editable')) {
                continue;
            }
            
            $rule = '';
            
            if (data_get($attribute, 'editable') && !data_get($attribute, 'nullable')) {
                $rule .= 'required';
            }
            
            $rules[$attribute['name']] = $rule;
        }
        
        return $this->varEncode($rules, ['array.inline' => true], true);
    }
    
    public function makeViewsForms($attributes, $map)
    {
        $fields = [];
        
        foreach ($attributes as $attribute) {
            
            if (!data_get($attribute, 'editable')) {
                continue;
            }
            
            $attrMap = [
                'AttrTitle' => $attribute['title'],
                'AttrName' => $attribute['name'],
                'AttrPluralName' => \Str::plural($attribute['name']),
            ];
            
            $viewDummy = $this->getStubsPath() . '/views/types/' . $attribute['type'] . '.blade.php';
            
            $fields[] = $this->createContent($viewDummy, $map + $attrMap);
        }
        
        $fields = join("\n\n", $fields);
        
        return $fields;
    }
    
    public function makeLang($attributes)
    {
        $data = [
            
            'attributes' => []
        
        ];
        foreach ($attributes as $attribute) {
            
            if (!data_get($attribute, 'title')) {
                continue;
            }
            
            $data['attributes'][data_get($attribute, 'name')] = data_get($attribute, 'title');
            
            if ($attribute['type'] === 'variants') {
                $data[\Str::plural($attribute['name'])] = ['one' => 'Edit this list in resources lang file'];
            }
        }
        
        return $data;
    }
    
    public function makeMigrationContent($attributes)
    {
        
        $lines = [];
        
        $lines[] = '$table->increments(\'id\');';
        $lines[] = '$table->timestamps();';
        
        foreach ($attributes as $attribute) {
            
            
            $code = '$table->';
            
            $code .= config("dummy_scaffold.attribute_types.{$attribute['type']}.blueprint");
            
            $code .= "('{$attribute['name']}')";
            
            if (data_get($attribute, 'nullable')) {
                $code .= '->nullable()';
            }
            
            if (filled(data_get($attribute, 'default'))) {
                $code .= "->default('{$attribute['default']}')";
            }
            $code .= ";";
            
            $lines[] = $code;
        }
        
        $lines = join("\n            ", $lines);
        
        return $lines;
    }
    
    public function createContent($path, $map)
    {
        
        $content = \File::get($path);
        
        $content = str_replace(array_keys($map), array_values($map), $content);
        
        return $content;
    }
    
    public function varEncode($var, $options = [], $forceInline = false)
    {
        
        $defaultOptions = ['array.inline' => false, 'string.escape' => false];
        
        $encoder = new \Riimu\Kit\PHPEncoder\PHPEncoder();
        
        $string = $encoder->encode($var, $options + $defaultOptions);
        
        if ($forceInline) {
            $string = preg_replace("#\s+#", " ", $string);
        }
        
        return $string;
    }
    
    /**
     * Run PHP Cs Fixer on scaffold files
     *
     * @param $files
     */
    public function runCsFixerOnFiles($files)
    {
        
        foreach ($files as $file) {
            
            if (substr($file, -10, 10) == '.blade.php') {
                continue;
            }
            
            $file = escapeshellarg($file);
            
            $options = '--using-cache=no --rules=@Symfony,@PSR2,@PSR1';
            
            $command = 'vendor' . DIRECTORY_SEPARATOR . 'bin' . DIRECTORY_SEPARATOR . 'php-cs-fixer';
            
            `$command fix $file $options 2>&1`;
        }
    }
}
