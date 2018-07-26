@extends('admin.layout.master')

@section('main_content')

<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <strong>Floats</strong>
      View All
    </div>
      <div class="card-body">
        @if(count($results))
        {!! Form::open(array('route' => 'admin.assign_float', 'id' => 'admin.assign_float', 'class' => 'form-horizontal row-border')) !!}
        <table class="table table-bordered table-hover table-responsive" id="dataTable">
          <thead>
            <tr>
              <th>#</th>
              <th>
                <input type="checkbox" id="chkParent"> Check All
              </th>
              <th>Claim Referance Number</th>
              <th>Patient Name</th>
              <th>Hospital Name</th>
              <th>Date of Admission</th>
              <th>Date of Discharge</th>
              <th>Package Code</th>
              <th>Current Status</th>
              <th>Assigned To</th>
            </tr>
          </thead>

          <tbody>
            @foreach($results as $k => $v)
              <tr>
                <td>{{ $k+1}} </td>
                <td>
                  @if($v->assigned_to)
                  
                  @else
                <input type="checkbox" name="assign_float_ids[]" value="{{ $v->id }}"> Assign
                  @endif
                </td>
                <td>{{ $v->tpa_claim_reference_number }}</td>
                <td>{{ $v->patient_name }}</td>
                <td>{{ $v->hospital_name }}</td>
                <td>{{ $v->date_of_admission }}</td>
                <td>{{ $v->date_of_discharge }}</td>
                <td>{{ $v->package_code }}</td>

                <td>{{ ucwords(str_replace('_', ' ',$v->current_status)) }}</td>
                <th>
                  @if($v->assigned_to)
                  <strong>{{ $v->claims_coordinator['name'] }}</strong>
                  @else
                  <a href="" class="btn btn-danger btn-sm disabled"> <i class="fa fa-location-arrow" aria-hidden="true"></i> Not Yet <br> Assigned </a>
                  @endif
                </th>
              </tr>
            @endforeach
          </tbody>
        </table>

        <div class="card-footer">

          <div class="form-group {{ $errors->has('userID') ? 'has-error' : ''}}">
            {!! Form::label('select_user', '', array('class' => 'col-md-3 control-label')) !!}
            <div class="col-md-4">
              {!! Form::select('claim_id', $claim_coordinators, null, ['class' => 'form-control required', 'id' => 'claim_id', 'placeholder' => 'Select Claim Coordinator', 'required' => 'true']) !!}
            </div>
            {!! $errors->first('claim_id', '<span class="help-inline">:message</span>') !!}
          </div>


          <button type="submit" class="btn btn-sm btn-primary">
            <i class="fa fa-dot-circle-o"></i> Assign</button>
        </div>

        {!! Form::close() !!}
        @else
        <div class="alert alert-warning">
          <h3>No Floats Found !</h3>
        </div>
        @endif

        

      </div>
  </div>
</div>

@endsection


@section('pageJs')
<script>
$("#chkParent").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
});
</script>
@stop
