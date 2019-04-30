<div class="form-group">
    {!! Form::label('AttrName', 'AttrTitle') !!}
    {!! Form::select('AttrName', trans('DummyPluralSlug.AttrPluralName'), old('AttrName'), ['class' => 'form-control', 'placeholder' => 'AttrTitle']) !!}
</div>