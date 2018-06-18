@extends('claim.layout.default')

@section('main_content')
<div class="card">
  <div class="alert @if($float_process->can_be_processed == 'Yes') alert-success @else alert-danger @endif" style="text-align: center;">

    @if($float_process->can_be_processed == 'Yes') <strong><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Can be processed</strong> @else <strong><i class="fa fa-thumbs-o-down" aria-hidden="true"></i> Can't be processed</strong> @endif

  </div>
  <div class="card-header">
    {{ $float->patient_name }} /{{ $float->tpa_claim_reference_number }}/ {{ $float->hospital_name }} 
  </div>
  <div class="card-body">
    <h5>Patient Info</h5>

    <table class="table table-bordered table-condensed">
        <tr>
          <th>Patient Name</th>
          <td>{{ $float->patient_name }}</td>

          <th>CCN Number</th>
          <td>{{ $float->tpa_claim_reference_number }}
          </td>

          <th>Patient Age</th>
          <td>{{ $float->patient_age }}</td>

          <th>Patient Gender</th>
          <td>{{ $float->patient_gender }}</td>

          <th>URN</th>
          <td>{{ $float->enr_urn }}</td>
        </tr>

        <tr>
          <th width="13%">Date of Admission</th>
          <td>{{ date('d-m-Y', strtotime($float->date_of_admission)) }}</td>

          <th width="13%">Date of Discharge</th>
          <td>{{ date('d-m-Y', strtotime($float->date_of_discharge)) }}</td>                

          <th>Claim Amount</th>
          <td>{{ $float->claim_amount_base }}</td>

          <th>Approved Amount</th>
          <td>{{ $float->approved_amount_base }}</td>
          
          <th>TDS Amount</th>
          <td>{{ $float->tds_amount }}</td>
        </tr>

        <tr>
          <th>Intimation Date</th>
          <td>{{ date('d-m-Y', strtotime($float->p_intimation_date)) }}</td>
        </tr>

      </table>

      <h5>Package Info</h5>
      <table class="table table-bordered table-condensed">
        <tr>
          <th>Package Code</th>
          <td>{{ $float->package_code }}</td>

          <th>Package Name</th>
          <td>{{ $float->package_name }}</td>

          <th>Diagnosis</th>
          <td>{{ $float->diagnosis }}</td>

          <th>URN</th>
          <td colspan="2">{{ $float->enr_urn }}</td>
        </tr>
      </table>
    </div>
</div>


<div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        Billing
      </div>
      <div class="card-body">
        <div class="form-group">
          <label class="col-md-12 control-label"><strong>Invoice/Bills From Hospital(Rs.) :</strong> &#8377; {{ $float_process->invoice_from_hospital }} </label>
        </div>
        <div class="form-group" >
          <label class="col-md-12 control-label"><strong>Amount as per Package Rate (Rs)</strong> : &#8377; {{ $float_process->invoice_from_hospital }}</label>
        </div>
        <div class="form-group">
          <label class="col-md-12 control-label"><strong>Implants/Stents (Rs)</strong> : &#8377; {{ $float_process->implants }}</label>
        </div>

        <div class="form-group {{ $errors->has('travelling_allowance') ? 'has-error' : ''}}">
          <label class="col-md-12 control-label"><strong>Travelling Allowance (Rs)</strong> : &#8377; {{ $float_process->travelling_allowance }}</label>
        </div>

        <div class="form-group">
          <label class="col-md-12 control-label"><strong>Total Amount=(Package rate +Implants/stents + TA) (Rs)</strong> : &#8377; {{ $float_process->total_amount }}</label>
        </div>

        <div class="form-group">
          <label class="col-md-12 control-label"><strong>Deduction (Rs)</strong> : &#8377; {{ $float_process->deduction }}</label>
        </div>
        <div class="form-group">
          <label class="col-md-12 control-label"><strong>TDS Amount 10% (Rs)</strong> : &#8377; {{ $float_process->tds_amount }}</label>
        </div>

        <div class="form-group">
          <label class="col-md-12 control-label"><strong>Amount on Billing (Rs) =Total Amount - (Deduction +TDS)</strong> : &#8377; {{ $float_process->amount_on_billing }}</label>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        Documents Received
      </div>
      <div class="card-body">

        @foreach($float_documents as $k => $v)
        <div class="row">
          <div class="col-md-7"><strong>{{ $v->float_requirement->name }}</strong> *</div>
          <div class="col-md-5">
            <div class="form-group">
              <div class="col-sm-7 col-md-7">
                <div class="input-group">
                  <div class="btn-group radio-group">
                      @if($v->float_requirement_value)
                        <label class="btn btn-success not-active btn-sm">Yes </label>
                      @endif

                      @if(!$v->float_requirement_value)
                        <label class="btn btn-danger not-active btn-sm">No</label>
                      @endif

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div> 
        @endforeach
      </div>
    </div>
  </div>

  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        Remarks
      </div>
      <div class="card-body">
         <div class="form-group">
            {!! $float_process->remarks !!}
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
