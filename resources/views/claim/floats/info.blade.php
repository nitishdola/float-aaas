@extends('claim.layout.default')

@section('main_content')
<div class="card">
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
          <td><input id="ccn_no" class="form-control" readonly="readonly" value="{{ $float->tpa_claim_reference_number }}">
            <a href="javascript:void(0)" class="btn btn-link" onclick="copyCCN();">Copy</a>
          </td>

          <th>Patient Age</th>
          <td>{{ $float->patient_age }}</td>

          <th>Patient Gender</th>
          <td>{{ $float->patient_gender }}</td>

          <th>URN</th>
          <td>{{ $float->enr_urn }}</td>
        </tr>

        <tr>
          <th>Date of Admission</th>
          <td>{{ date('d-m-Y', strtotime($float->date_of_admission)) }}</td>

          <th>Date of Discharge</th>
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

<div class="col-md-12">

    <a href="http://aaa-assam.in/FOLLOWUP/SEARCHPATIANTREGISTATION.ASPX?ROLE=IC&STATUS=179" class="btn btn-sm btn-danger" target="_blank"> <i class="fa fa-search" aria-hidden="true"></i> Search Patient Data</a>

    <a href="http://aaa-assam.in/PreAuthClaims/PreauthDocumentUpload.aspx?hf_caseNo={{ $float->tpa_claim_reference_number }}" class="btn btn-sm btn-danger" target="_blank"> <i class="fa fa-file-word-o" aria-hidden="true"></i> View Documents</a> 

</div>


{!! Form::open(array('route' => ['claim.floats.process', $float->id], 'id' => 'floats.process', 'class' => '')) !!}
<div class="row">
  <div class="col-sm-4">
    <div class="card">
      <div class="card-header">
        Billing
      </div>
      <div class="card-body">
        <div class="form-group {{ $errors->has('bill_amount_from_hospital') ? 'has-error' : ''}}">
          <label class="col-md-12 control-label"><strong>Invoice/Bills From Hospital(Rs.)*</strong></label>
            <div class="col-md-12">
              {!! Form::number('bill_amount_from_hospital', null, ['class' => 'form-control required', 'id' => 'bill_amount_from_hospital', 'placeholder' => 'Invoice/Bills From Hospital(Rs.)', 'autocomplete' => 'off', 'required' => 'true', 'step' => '0.01']) !!}
            </div>
          {!! $errors->first('bill_amount_from_hospital', '<span class="help-inline">:message</span>') !!}
        </div>
        <div class="form-group {{ $errors->has('amount_as_per_package') ? 'has-error' : ''}}">
          <label class="col-md-12 control-label"><strong>Amount as per Package Rate (Rs)*</strong></label>
            <div class="col-md-12">
              {!! Form::number('amount_as_per_package', null, ['class' => 'form-control required', 'id' => 'amount_as_per_package', 'placeholder' => 'Amount as per Package Rate (Rs)', 'autocomplete' => 'off', 'required' => 'true']) !!}
            </div>
          {!! $errors->first('amount_as_per_package', '<span class="help-inline">:message</span>') !!}
        </div>
        <div class="form-group {{ $errors->has('implants') ? 'has-error' : ''}}">
          <label class="col-md-12 control-label"><strong>Implants/Stents (Rs)*</strong></label>
            <div class="col-md-12">
              {!! Form::number('implants', null, ['class' => 'form-control required', 'id' => 'implants', 'placeholder' => 'Implants/Stents (Rs)', 'autocomplete' => 'off', 'required' => 'true']) !!}
            </div>
          {!! $errors->first('implants', '<span class="help-inline">:message</span>') !!}
        </div>

        <div class="form-group {{ $errors->has('travelling_allowance') ? 'has-error' : ''}}">
          <label class="col-md-12 control-label"><strong>Travelling Allowance (Rs)*</strong></label>
            <div class="col-md-12">
              {!! Form::number('travelling_allowance', null, ['class' => 'form-control required', 'id' => 'travelling_allowance', 'placeholder' => 'Travelling Allowance (Rs)', 'autocomplete' => 'off', 'required' => 'true']) !!}
            </div>
          {!! $errors->first('travelling_allowance', '<span class="help-inline">:message</span>') !!}
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
              {!! Form::number('total', null, ['class' => 'form-control required', 'id' => 'total', 'placeholder' => 'Total Amount(Rs)', 'autocomplete' => 'off', 'required' => 'true']) !!}
            </div>
          {!! $errors->first('total', '<span class="help-inline">:message</span>') !!}
        </div>

        <div class="form-group {{ $errors->has('deduction') ? 'has-error' : ''}}">
          <label class="col-md-12 control-label"><strong>Deduction (Rs)*</strong></label>
            <div class="col-md-12">
              {!! Form::number('deduction', null, ['class' => 'form-control required', 'id' => 'deduction', 'placeholder' => 'Deduction (Rs)', 'autocomplete' => 'off', 'required' => 'true']) !!}
            </div>
          {!! $errors->first('deduction', '<span class="help-inline">:message</span>') !!}
        </div>
        <div class="form-group {{ $errors->has('tds') ? 'has-error' : ''}}">
          <label class="col-md-12 control-label"><strong>TDS Amount 10% (Rs)*</strong></label>
            <div class="col-md-12">
              {!! Form::number('tds', null, ['class' => 'form-control required', 'id' => 'tds', 'placeholder' => 'TDS Amount (Rs)', 'autocomplete' => 'off', 'required' => 'true']) !!}
            </div>
          {!! $errors->first('tds', '<span class="help-inline">:message</span>') !!}
        </div>

        <div class="form-group {{ $errors->has('amount_on_billing') ? 'has-error' : ''}}">
          <label class="col-md-12 control-label"><strong>Amount on Billing (Rs) =Total Amount - (Deduction +TDS)*</strong></label>
            <div class="col-md-12">
              {!! Form::number('amount_on_billing', null, ['class' => 'form-control required', 'id' => 'amount_on_billing', 'placeholder' => 'Billing Amount', 'autocomplete' => 'off', 'required' => 'true']) !!}
            </div>
          {!! $errors->first('amount_on_billing', '<span class="help-inline">:message</span>') !!}
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
                     <label class="btn btn-primary not-active">Yes <input type="radio" value="Yes" name="documents_{{$v->id}}" required="required"></label>
                     <label class="btn btn-primary not-active">No <input type="radio" value="No" name="documents_{{$v->id}}"></label>
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
              {!! Form::textarea('remarks', null, ['class' => 'form-control required', 'id' => 'remarks', 'placeholder' => 'Remarks', 'rows' => 4, 'required' => 'true']) !!}
            </div>
          {!! $errors->first('remarks', '<span class="help-inline">:message</span>') !!}
        </div>
      </div>
    </div>
  </div>
</div>

{!! Form::close() !!}
      
@endsection



@section('pageCss')

<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">

<style type="text/css">
.radio-group label {
   overflow: hidden;
} .radio-group input {
    /* This is on purpose for accessibility. Using display: hidden is evil.
    This makes things keyboard friendly right out tha box! */
   height: 1px;
   width: 1px;
   position: absolute;
   top: -20px;
} .radio-group .not-active  {
   color: #3276b1;
   background-color: #fff;
}

.modal.modal-wide .modal-dialog {
  width: 90%;
}
.modal-wide .modal-body {
  overflow-y: auto;
}

#tallModal .modal-body p { margin-bottom: 900px }
</style>
@stop

@section('pageJs')

<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>

<script>

copyCCN = function() {
  /* Get the text field */
  var copyText = $('#ccn_no');

  /* Select the text field */
  copyText.select();

  /* Copy the text inside the text field */
  document.execCommand("copy");

  /* Alert the copied text */
  alert("Copied the text: " + copyText.val());
}

$(function() {


    $('#remarks').summernote({ height: 200 });

    $(".modal-wide").on("show.bs.modal", function() {
      var height = $(window).height() - 200;
      $(this).find(".modal-body").css("max-height", height);
    });

    // Input radio-group visual controls
    $('.radio-group label').on('click', function(){
        $(this).removeClass('not-active').siblings().addClass('not-active');
    });
})
</script>
@stop