@extends('admin.layout')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{route('AdminRouteNs.DummySlug.index')}}">DummyPluralName</a></li>
@endsection

@section('content')
    
    
    {{--top--}}
    
    <div class="display-4 text-center mb-3">DummyPluralName</div>
    
    <div class="text-center mb-3">
        <a href="{{route('AdminRouteNs.DummySlug.create')}}" class="btn btn-success">Добавить</a>
    </div>
    
    {{--/top--}}
    
    
    <table class="table table-striped table-bordered">
        
        <tr class="head">
            <th>Название</th>
            <th>Действия</th>
        </tr>
        
        @foreach($dummies as $dummy)
            
            <tr>
                
                <td>{{$dummy->dummyTitleKey}}</td>
                
                <td>
                    <a href="{{route('AdminRouteNs.DummySlug.edit', $dummy)}}" class="btn btn-sm btn-primary">редактировать</a>
                    {!! Form::open(['route' => [ 'AdminRouteNs.DummySlug.destroy', $dummy->id], 'method' => 'delete', 'style' => 'display:inline-block'  ]) !!}
                    {!! Form::submit('удалить', ['class' => 'btn btn-danger btn-sm']) !!}
                    {!! Form::close() !!}
                </td>
            
            </tr>
        @endforeach
    
    </table>

@endsection

@section('scripts')

@endsection