@extends('admin.layout')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{route('AdminRouteNs.DummySlug.index')}}">DummyPluralName</a></li>
    <li class="breadcrumb-item active">Создание</li>
@endsection

@section('content')
    
    {!! Form::open(['route' => [ 'AdminRouteNs.DummySlug.store' ], 'method' => 'POST' ]) !!}
    
    <div class="row justify-content-md-center">
        
        <div class="col-8">
            
            <div class="card">
                
                <div class="card-body">
                    <span class="display-3 d-block mb-3 text-center">DummyName: создание</span>
    
                    {{--AttrForms--}}
    
                    <div class="text-center mb-3">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </div>
                
                </div>
            
            </div>
        
        </div>
    </div>
    
    {!! Form::close() !!}

@endsection

@section('scripts')

@endsection