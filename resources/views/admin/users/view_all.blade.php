@extends('admin.layout.master')

@section('main_content')

<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <strong>Users</strong>
      View All
    </div>
      <div class="card-body">
        @if(count($users))
        <table class="table table-bordered table-hover table-condensed">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Username</th>
            </tr>
          </thead>

          <tbody>
            @foreach($users as $k => $v)
              <tr>
                <td>{{ $k+1}} </td>
                <td>{{ $v->name }}</td>
                <td>{{ $v->username }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
        @else
        <div class="alert alert-warning">
          <h3>No Users Found !</h3>
        </div>
        @endif

        <a class="btn btn-xs btn-primary" route="{{ route('admin.user.create') }}" href="{{ route('admin.user.create') }}"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Users</a>

      </div>
  </div>
</div>

@endsection
