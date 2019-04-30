<?php

namespace DummyNamespaceControllersAdmin;

use DummyAppNamespace\DummyModel;
use DummyAppNamespace\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DummyController extends Controller
{
    
    public function index(Request $request)
    {
        $dummies = DummyModel::all();
        
        return view('AdminViewNs.DummyPluralSlug.index', ['DummyPluralSlug' => $dummies]);
    }
    
    public function create()
    {
        return view('AdminViewNs.DummyPluralSlug.create', []);
    }
    
    public function store(Request $request)
    {
        //$this->validate(
        //    $request,
        //    [RULES],
        //    [],
        //    trans('DummyPluralSlug.attributes')
        //);
        
        $dummy = new DummyModel();
        
        /** @type DummyModel $dummy */
        
        $dummy->fill($request->all());
        
        $dummy->save();
        
        return redirect()->route("AdminRouteNs.DummyPluralSlug.index")->withMessage('common.success');
    }
    
    public function show(Request $request, $id)
    {
        $dummy = DummyModel::find($id);
        
        /** @type DummyModel $dummy */
        
        return view('AdminViewNs.DummyPluralSlug.show', ['DummySlug' => $dummy]);
    }
    
    public function edit($id)
    {
        $dummy = DummyModel::find($id);
        
        /** @type DummyModel $dummy */
        
        return view('AdminViewNs.DummyPluralSlug.edit', ['DummySlug' => $dummy]);
    }
    
    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [RULES],
            [],
            trans('DummyPluralSlug.attributes')
        );
        
        $dummy = DummyModel::find($id);
        
        /** @type DummyModel $dummy */
        
        $dummy->fill(request()->all());
        
        $dummy->save();
        
        return redirect()->route("AdminRouteNs.DummyPluralSlug.edit", $dummy->id)->withMessage('common.success');
    }
    
    public function destroy(Request $request, $id)
    {
        $dummy = DummyModel::find($id);
        
        /** @type DummyModel $dummy */
        
        $dummy->delete();
        
        return redirect()->route("AdminRouteNs.DummyPluralSlug.index")->withMessage('common.success');
    }
    
}
