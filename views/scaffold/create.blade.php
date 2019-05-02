<!doctype html>
<html lang="en">
<head>
    <title>
        Generator
    </title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@4/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://unpkg.com/lodash/lodash.min.js"></script>
    <script src="https://unpkg.com/pluralize/pluralize.js"></script>
    
    <script type="text/javascript">
      $(function () {

        $('[name=model_class_name]').on('keyup', function (e) {
          e.preventDefault()

          var modelClassName = $(this).val()
          $('[name=model_slug]').val(_.lowerCase(modelClassName))
          $('[name=model_table]').val(pluralize.plural(_.lowerCase(modelClassName)))
          $('[name=model_slug_plural]').val(pluralize.plural(_.lowerCase(modelClassName)))
          $('[name=model_name]').val(modelClassName)
          $('[name=model_name_plural]').val(pluralize.plural(modelClassName))

        })

        $('.attribute_name').on('keyup', function (e) {
          e.preventDefault()
          $(this).parents('tr').find('.attribute_title').val(_.capitalize($(this).val()))
        })

      })
    </script>
    
    @yield('scripts')

</head>
<body>

<div class="container-fluid">
    
    <div class="row">
        
        <div class="col">
            
            <h1>Scaffold</h1>
            
            <form method="post" action="{{route("scally.scaffold.store")}}">
                
                
                <div class="row">
                    
                    <div class="col-3">
                        <div class="form-group ">
                            {!! Form::label('model_class_name', 'Model class name (e.g. Article)') !!}
                            {!! Form::text('model_class_name', old('model_class_name'), ['class' => 'form-control', 'placeholder' => 'Model class name']) !!}
                        </div>
    
                        <div class="form-group  ">
                            {!! Form::label('model_table', 'Model table') !!}
                            {!! Form::text('model_table', old('model_table'), ['class' => 'form-control', 'placeholder' => 'Model table']) !!}
                        </div>
    
                        <div class="form-group ">
                            {!! Form::label('model_slug', 'Model slug (e.g. article )') !!}
                            {!! Form::text('model_slug', old('model_slug'), ['class' => 'form-control', 'placeholder' => 'Model slug']) !!}
                        </div>
    
                        <div class="form-group ">
                            {!! Form::label('model_slug_plural', 'Model slug plural (e.g. articles)' ) !!}
                            {!! Form::text('model_slug_plural', old('model_slug_plural'), ['class' => 'form-control', 'placeholder' => 'Model slug plural']) !!}
                        </div>
    
                        <div class="form-group ">
                            {!! Form::label('model_name', 'Model name for views (e.g. Article)') !!}
                            {!! Form::text('model_name', old('model_name'), ['class' => 'form-control', 'placeholder' => 'Model name']) !!}
                        </div>
    
                        <div class="form-group ">
                            {!! Form::label('model_name_plural', 'Model plural name (e.g. Articles)') !!}
                            {!! Form::text('model_name_plural', old('model_name_plural'), ['class' => 'form-control', 'placeholder' => 'Model plural name']) !!}
                        </div>


                    </div>
                    <div class="col-9">
    
                        <table class="table     table-bordered">
                            <thead class="thead-dark">
                        <tr>
                                <th>Name (table, model attribute)</th>
                                <th>Title (in views, etc.)</th>
                                <th>Type (table & view)</th>
                                <th style="max-width: 200px">Default</th>
                                <th>Is nullable</th>
                                <th>Is editable</th>
        
                            </tr>
        
                            </thead>
                            @for($i=0;$i<12;$i++)
                                <tr>
                
                                    <td>
                    
                                        <input type="text" class="form-control attribute_name" name="attributes[{{$i}}][name]">
                
                                    </td>
                
                                    <td>
                    
                                        <input type="text" class="form-control attribute_title" name="attributes[{{$i}}][title]">
                
                                    </td>
                
                                    <td>
                    
                                        <select name="attributes[{{$i}}][type]" class="form-control">
                        
                                            @foreach(config('scally.attribute_types') as $key => $data)
                                                <option value="{{$key}}">{{data_get($data, 'name')}}</option>
                                            @endforeach
                    
                                        </select>
                
                                    </td>
                
                                    <td style="width: 200px">
                    
                                        <input type="text" class="form-control input-s" name="attributes[{{$i}}][default]">
                
                                    </td>
                
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" id="attributes{{$i}}nullable" name="attributes[{{$i}}][nullable]" value="1" checked>
                                            <label for="attributes{{$i}}nullable">nullable</label>
                                        </div>
                                    </td>
                
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" id="attributes{{$i}}editable" name="attributes[{{$i}}][editable]" value="1" checked>
                                            <label for="attributes{{$i}}editable">editable</label>
                                        </div>
                                    </td>
            
                                </tr>
                            @endfor
                        </table>
                        
                    </div>
                    
                    
                </div>
          
                
                
                
                <button type="submit" class="btn btn-primary">Create scaffold</button>
            
            </form>
        
        </div>
    
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://unpkg.com/bootstrap@4/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>

<script src="https://cdn.ckeditor.com/4.8.0/standard/ckeditor.js"></script>

<script type="text/javascript">

  $('btn-danger').on('click', function (e) {

    if (!confirm('Подтвердите действие')) {
      e.preventDefault()
    } else {
      //
    }

  })

  })

</script>

@yield('scripts')

</body>
</html>