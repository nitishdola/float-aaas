@extends('claim.layout.default')

@section('main_content')
<?php $count = 1; ?>


<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <strong>Search</strong>
      Form
    </div>
    <div class="card-body">
      {!! Form::open(array('route' => ['claim.float_data.view'], 'id' => 'float_data.view', 'method' => 'GET')) !!}
      <div class="form-group row">
        <label class="col-md-3 col-form-label" for="hf-email">Reference Number</label>
        <div class="col-md-9">
          <input type="text" id="tpa_claim_reference_number" value="{{ $request->tpa_claim_reference_number }}" name="tpa_claim_reference_number" class="form-control" placeholder="Claim Reference Number">
        </div>
      </div>
      <div class="form-group row">
        <label class="col-md-3 col-form-label" for="hf-password">Patient Name</label>
        <div class="col-md-9">
          <input type="text" id="patient_name" value="{{ $request->patient_name }}" name="patient_name" class="form-control" placeholder="Patient Name">
        </div>
      </div>
      <?php 
        $gender = [];
        $gender['MALE']   = 'MALE';
        $gender['FEMALE'] = 'FEMALE';
      ?>
      <div class="form-group row">
        <label class="col-md-3 col-form-label" for="hf-password">Patient Gender</label>
        <div class="col-md-9">
          {!! Form::select('patient_gender', $gender, $request->patient_gender, ['class' => 'form-control required', 'id' => 'patient_gender', 'placeholder' => 'Patient Gander', 'autocomplete' => 'off']) !!}
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-3 col-form-label" for="hf-password">Hospital Name</label>
        <div class="col-md-9">
          {!! Form::text('hospital_name', $request->hospital_name, ['class' => 'form-control required', 'id' => 'hospital_name', 'placeholder' => 'Hospital Name', 'autocomplete' => 'off']) !!}
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-3 col-form-label" for="hf-password">Date of Discharge From</label>
        <div class="col-md-2">
          {!! Form::text('date_of_discharge_from', $request->date_of_discharge_from, ['class' => 'form-control zdatepicker', 'id' => 'date_of_discharge_from', 'placeholder' => 'Discharge date from', 'autocomplete' => 'off']) !!}
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-3 col-form-label" for="hf-password">Date of Discharge To</label>
        <div class="col-md-2">
          {!! Form::text('date_of_discharge_to', $request->date_of_discharge_to, ['class' => 'form-control zdatepicker', 'id' => 'date_of_discharge_to', 'placeholder' => 'Discharge date to', 'autocomplete' => 'off']) !!}
        </div>
      </div>

      <?php 
        $all_float_nos[1] = 1;
        $all_float_nos[2] = 2;
        $all_float_nos[3] = 3;
        $all_float_nos[4] = 4;
        $all_float_nos[5] = 5;
        $all_float_nos[6] = 6;
        $all_float_nos[7] = 7;
        $all_float_nos[8] = 8;
        $all_float_nos[9] = 9;
        $all_float_nos[10] = 10;
      ?>
      <div class="form-group row">
        <label class="col-md-3 col-form-label" for="hf-password">Float Number</label>
        <div class="col-md-2">
          {!! Form::select('float_number', $all_float_nos, $request->float_number, ['class' => 'form-control', 'id' => 'float_number', 'placeholder' => 'Select Float', 'required' => true]) !!}
        </div>
      </div>


    </div>
    <div class="card-footer">
      <button type="submit" class="btn btn-sm btn-primary pull-right">
        <i class="fa fa-dot-circle-o"></i> SEARCH</button>
    </div>

    {!! Form::close() !!}
  </div>
</div>



    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          

          <div class="col-md-12">
            <strong>Floats</strong>
          View All
          @if(count($results))
          <span class="pull-right">
              <a class="btn btn-xs btn-primary" href="{{ route('claim.float_data.excel_download', ['tpa_claim_reference_number' => $request->tpa_claim_reference_number, 'patient_name' => $request->patient_name, 'patient_gender' => $request->patient_gender, 'hospital_name' => $request->hospital_name, 'date_of_discharge_from' => $request->date_of_discharge_from, 'date_of_discharge_to' => $request->date_of_discharge_to, 'float_number' => $request->float_number]) }}"> Export to Excel</a>
            </span>
            @endif
          </div>

        </div>
          <div class="card-body">
            @if(count($results))
            <table class="table table-bordered table-hover table-responsive">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Claim Referance Number</th>
                  <th>Patient Name</th>
                  <th>Hospital Name</th>
                  <th>Date of Admission</th>
                  <th>Date of Discharge</th>
                  <th>Package Code</th>
                  <th>Current Status</th>
                  <th>View Details</th>
                </tr>
              </thead>

              <tbody>
                @foreach($results as $k => $v)
                  <tr>
                    <td>{{ (($results->currentPage() - 1 ) * $results->perPage() ) + $count + $k }} </td>
                    
                    <td>{{ $v->tpa_claim_reference_number }}</td>
                    <td>{{ $v->patient_name }}</td>
                    <td>{{ $v->hospital_name }}</td>
                    <td>{{ $v->date_of_admission }}</td>
                    <td>{{ $v->date_of_discharge }}</td>
                    <td width="200">{{ trim( str_replace(',', ', ',$v->package_code)) }}</td>

                    <td>{{ ucwords(str_replace('_', ' ',$v->current_status)) }}</td>
                    
                    <td><a href="{{ route('claim.float_data.info', Crypt::encrypt($v->id)) }}" target="_blank" class="btn btn-sm btn-primary"> Details</a> <br><br>

                      <a href="{{ route('claim.float_data.edit', Crypt::encrypt($v->id)) }}" target="_blank" class="btn btn-sm btn-warning"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>

                  </tr>
                @endforeach
              </tbody>
            </table>

            <div class="pagination">
                    {!! $results->render() !!}
            </div>
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

$('#tpa_claim_reference_number').keyup(function() {
    this.value = this.value.toLocaleUpperCase();
});
</script>
@stop