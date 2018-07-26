@extends('admin.layout.master')

@section('main_content')

<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <strong>Floats</strong>
      Upload
    </div>
    {!! Form::open(array('route' => 'admin.floats.save', 'id' => 'admin.floats.save', 'class' => 'form-horizontal row-border', 'files' => true)) !!}
      <div class="card-body">

          <div class="col-md-12">
              <div class="form-group {{ $errors->has('float_file') ? 'has-error' : ''}}">
                {!! Form::label('excel', '', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-9">
                  <input type="file" name="float_file">
                </div>
              </div>

              <div class="form-group {{ $errors->has('float_date') ? 'has-error' : ''}}">
                {!! Form::label('float_date', '', array('class' => 'col-md-3 control-label')) !!}
                <div class="col-md-5">
                  {!! Form::text('float_date', null, ['class' => 'form-control datepicker', 'id' => 'float_date', 'placeholder' => 'Float Receive Date', 'autocomplete' => 'off', 'required' => 'true']) !!}
                </div>
                {!! $errors->first('float_date', '<span class="help-inline">:message</span>') !!}
              </div>

              @if ($errors->has('float_file'))
                  <span class="help-block">
                      <strong>{{ $errors->first('float_file') }}</strong>
                  </span>
              @endif
       
        </div>
      </div>
      <div class="card-footer">
        <button type="submit" class="btn btn-sm btn-primary">
          <i class="fa fa-dot-circle-o"></i> Upload</button>
        <button type="reset" class="btn btn-sm btn-danger">
          <i class="fa fa-ban"></i> Reset</button>
      </div>
    {!! Form::close() !!}
  </div>
</div>

@endsection
