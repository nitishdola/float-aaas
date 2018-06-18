@extends('admin.layout.login')

@section('content')
@section('content')

 <form class="form-auth-small" role="form" method="POST" action="{{ url('/admin/login') }}">
                        {{ csrf_field() }}
    <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
        <label for="signin-email" class="control-label sr-only">Username</label>
        <input type="text" name="username" id="username" class="form-control"  placeholder="Username">
        @if ($errors->has('username'))
          <span class="help-block">
              <strong>{{ $errors->first('username') }}</strong>
          </span>
        @endif
    </div>
    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <label for="signin-password" class="control-label sr-only">Password</label>
        <input type="password" name="password" class="form-control" id="password" placeholder="Password">
        @if ($errors->has('password'))
          <span class="help-block">
              <strong>{{ $errors->first('password') }}</strong>
          </span>
        @endif
    </div>
    
    <button type="submit" class="btn btn-primary btn-lg btn-block" name="S1" value="Login">LOGIN</button>
    <div class="bottom">
        @if(Session::has('message'))
        <div class="row">
           <div class="col-lg-12">
                 <div class="alert {{ Session::get('alert-class', 'alert-info') }}">
                       <button type="button" class="close" data-dismiss="alert">×</button>
                       {!! Session::get('message') !!}
                 </div>
              </div>
        </div>
        @endif

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</form>
@endsection
