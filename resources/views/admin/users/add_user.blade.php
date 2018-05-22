@extends('admin.layout.master')

@section('main_content')

<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <strong>Users</strong>
      Add
    </div>
    {!! Form::open(array('route' => 'admin.user.save', 'id' => 'admin.user.save', 'class' => 'form-horizontal row-border')) !!}
      <div class="card-body">
        @include('admin.users._form')
      </div>
      <div class="card-footer">
        <button type="submit" class="btn btn-sm btn-primary">
          <i class="fa fa-dot-circle-o"></i> Submit</button>
        <button type="reset" class="btn btn-sm btn-danger">
          <i class="fa fa-ban"></i> Reset</button>
      </div>
    {!! Form::close() !!}
  </div>
</div>

@endsection
