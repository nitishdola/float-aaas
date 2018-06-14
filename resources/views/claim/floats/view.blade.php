@extends('claim.layout.default')

@section('main_content')
<div class="card">
  <div class="card-header">
    {{ $float->patient_name }} /{{ $float->tpa_claim_reference_number }}/ {{ $float->hospital_name }} 
  </div>
  <div class="card-body">
    <h5>Patient Info</h5>

    <div class="row">
      
    </div>

    <table class="table table-bordered table-condensed">
        <tr>
          <th>Patient Name</th>
          <td>{{ $float_process->float->patient_name }}</td>

          <th>CCN Number</th>
          <td><input id="ccn_no" class="form-control" readonly="readonly" value="{{ $float->tpa_claim_reference_number }}">
            <a href="javascript:void(0)" class="btn btn-link" onclick="copyCCN();">Copy</a>
          </td>

          <th>Patient Age</th>
          <td>{{ $float_process->float->patient_age }}</td>

          <th>Patient Gender</th>
          <td>{{ $float_process->float->patient_gender }}</td>

          <th>URN</th>
          <td>{{ $float_process->float->enr_urn }}</td>
        </tr>

        <tr>
          <th width="13%">Date of Admission</th>
          <td>{{ date('d-m-Y', strtotime($float_process->float->date_of_admission)) }}</td>

          <th width="13%">Date of Discharge</th>
          <td>{{ date('d-m-Y', strtotime($$float_process->loat->date_of_discharge)) }}</td>                

          <th>Claim Amount</th>
          <td>{{ $float_process->float->claim_amount_base }}</td>

          <th>Approved Amount</th>
          <td>{{ $float_process->float->approved_amount_base }}</td>
          
          <th>TDS Amount</th>
          <td>{{ $float_process->float->tds_amount }}</td>
        </tr>

        <tr>
          <th>Intimation Date</th>
          <td>{{ date('d-m-Y', strtotime($float_process->float->p_intimation_date)) }}</td>
        </tr>

      </table>

      <h5>Package Info</h5>
      <table class="table table-bordered table-condensed">
        <tr>
          <th>Package Code</th>
          <td>{{ $float_process->float->package_code }}</td>

          <th>Package Name</th>
          <td>{{ $float_process->float->package_name }}</td>

          <th>Diagnosis</th>
          <td>{{ $float_process->float->diagnosis }}</td>

          <th>URN</th>
          <td colspan="2">{{ $float_process->float->enr_urn }}</td>
        </tr>
      </table>
    </div>
</div>

<div class="col-md-12">
    <a href="http://aaa-assam.in/FOLLOWUP/SEARCHPATIANTREGISTATION.ASPX?ROLE=IC&STATUS=179" class="btn btn-sm btn-danger" target="_blank"> <i class="fa fa-search" aria-hidden="true"></i> Search Patient Data</a>
    <a href="http://aaa-assam.in/PreAuthClaims/PreauthDocumentUpload.aspx?hf_caseNo={{ $float->tpa_claim_reference_number }}" class="btn btn-sm btn-danger" target="_blank"> <i class="fa fa-file-word-o" aria-hidden="true"></i> View Documents</a> 
</div>


<div class="row">
  <div class="col-sm-4">
    <div class="card">
      <div class="card-header">
        Billing
      </div>
      <div class="card-body">
        <div class="form-group {{ $errors->has('invoice_from_hospital') ? 'has-error' : ''}}">
          <label class="col-md-12 control-label"><strong>Invoice/Bills From Hospital(Rs.)*</strong></label>
            <div class="col-md-12">
              {{ $float_process->invoice_from_hospital }}
            </div>
        </div>
        <div class="form-group {{ $errors->has('amount_as_per_package') ? 'has-error' : ''}}" >
          <label class="col-md-12 control-label"><strong>Amount as per Package Rate (Rs)*</strong></label>
            <div class="col-md-12">
              {{ $float_process->amount_as_per_package }}
            </div>
        </div>
        <div class="form-group {{ $errors->has('implants') ? 'has-error' : ''}}">
          <label class="col-md-12 control-label"><strong>Implants/Stents (Rs)*</strong></label>
            <div class="col-md-12">
              {{ $float_process->implants }}
            </div>
        </div>

        <div class="form-group {{ $errors->has('travelling_allowance') ? 'has-error' : ''}}">
          <label class="col-md-12 control-label"><strong>Travelling Allowance (Rs)*</strong></label>
            <div class="col-md-12">
              {{ $float_process->travelling_allowance }}
            </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="card">
      <div class="card-header">
        TA/Deduction/TDS
      </div>
      <div class="card-body">
        
         <div class="form-group {{ $errors->has('total') ? 'has-error' : ''}}">
          <label class="col-md-12 control-label"><strong>Total Amount=(Package rate +Implants/stents + TA) (Rs)*</strong></label>
            <div class="col-md-12">
              {{ $float_process->total_amount }}
            </div>
        </div>

        <div class="form-group {{ $errors->has('deduction') ? 'has-error' : ''}}">
          <label class="col-md-12 control-label"><strong>Deduction (Rs)*</strong></label>
            <div class="col-md-12">
              {{ $float_process->deduction }}
            </div>
        </div>
        <div class="form-group {{ $errors->has('tds_amount') ? 'has-error' : ''}}">
          <label class="col-md-12 control-label"><strong>TDS Amount 10% (Rs)*</strong></label>
            <div class="col-md-12">
              {{ $float_process->tds_amount }}
            </div>
        </div>

        <div class="form-group {{ $errors->has('amount_on_billing') ? 'has-error' : ''}}">
          <label class="col-md-12 control-label"><strong>Amount on Billing (Rs) =Total Amount - (Deduction +TDS)*</strong></label>
            <div class="col-md-12">
              {{ $float_process->amount_on_billing }}
            </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="card">
      <div class="card-header">
        Documents Received
      </div>
      <div class="card-body">

        @foreach(Helper::claimRequirements() as $k => $v)
        <div class="row">
          <div class="col-md-7"><strong>{{ $v->name }}</strong> *</div>
          <div class="col-md-5">
            <div class="form-group">
              <div class="col-sm-7 col-md-7">
                <div class="input-group">
                  <div class="btn-group radio-group">
                     <label class="btn btn-primary not-active">Yes <input type="radio" value="1" name="documents_{{$v->id}}" required="required"></label>
                     <label class="btn btn-primary not-active">No <input type="radio" value="0" name="documents_{{$v->id}}"></label>
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
         <div class="form-group {{ $errors->has('remarks') ? 'has-error' : ''}}">
            <div class="col-md-12">
              {!! $float_process->remarks !!}
            </div>
        </div>


        <div class="form-group" style="margin-top:100px;">
            <label class="col-md-5 control-label"><strong>Can Be Processed ?*</strong></label>
            <div class="col-md-7">
                {{ $float_process->can_pe_processed }}

            </div>
        </div>
      </div>
    </div>
  </div>
</div>

      
@endsection
