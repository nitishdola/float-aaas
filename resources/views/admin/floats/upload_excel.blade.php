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
        <div class="form-group{{ $errors->has('float_file') ? ' has-error' : '' }}">
          <label class="col-md-4 control-label">Upload Excel</label>

          <div class="col-md-4">
              <input type="file" name="float_file">

              @if ($errors->has('float_file'))
                  <span class="help-block">
                      <strong>{{ $errors->first('float_file') }}</strong>
                  </span>
              @endif
          </div>
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
