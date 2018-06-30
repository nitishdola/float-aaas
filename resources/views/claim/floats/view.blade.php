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

{!! Form::open(array('route' => ['claim.floats.process', $float->id], 'id' => 'floats.process', 'class' => '', 'onsubmit' => 'return validateFloatForm()' )) !!}


<div class="row">
  <div class="col-sm-4">
    <div class="card" id="billing_card">
      <div class="card-header">
        Billing
      </div>
      <div class="card-body">
        <div class="form-group {{ $errors->has('invoice_from_hospital') ? 'has-error' : ''}}">
          <label class="col-md-12 control-label"><strong>Invoice/Bills From Hospital(Rs.)*</strong></label>
            <div class="col-md-12">
              {!! Form::number('invoice_from_hospital', null, ['class' => 'form-control required', 'id' => 'bill_amount_from_hospital', 'placeholder' => 'Invoice/Bills From Hospital(Rs.)', 'autocomplete' => 'off', 'step' => '0.01', 'data-validation' => 'length alphanumeric']) !!}
            </div>
          {!! $errors->first('invoice_from_hospital', '<span class="help-inline">:message</span>') !!}
        </div>
        <div class="form-group {{ $errors->has('amount_as_per_package') ? 'has-error' : ''}}" >
          <label class="col-md-12 control-label"><strong>Amount as per Package Rate (Rs)*</strong></label>
            <div class="col-md-12">
              {!! Form::number('amount_as_per_package', null, ['class' => 'form-control required', 'id' => 'amount_as_per_package', 'placeholder' => 'Amount as per Package Rate (Rs)', 'autocomplete' => 'off', 'step' => '0.01']) !!}
            </div>
          {!! $errors->first('amount_as_per_package', '<span class="help-inline">:message</span>') !!}
        </div>
        <div class="form-group {{ $errors->has('implants') ? 'has-error' : ''}}">
          <label class="col-md-12 control-label"><strong>Implants/Stents (Rs)*</strong></label>
            <div class="col-md-12">
              {!! Form::number('implants', null, ['class' => 'form-control required', 'id' => 'implants', 'placeholder' => 'Implants/Stents (Rs)', 'autocomplete' => 'off', 'step' => '0.01']) !!}
            </div>
          {!! $errors->first('implants', '<span class="help-inline">:message</span>') !!}
        </div>

        <div class="form-group {{ $errors->has('travelling_allowance') ? 'has-error' : ''}}">
          <label class="col-md-12 control-label"><strong>Travelling Allowance (Rs)*</strong></label>
            <div class="col-md-12">
              {!! Form::number('travelling_allowance', null, ['class' => 'form-control required', 'id' => 'travelling_allowance', 'placeholder' => 'Travelling Allowance (Rs)', 'autocomplete' => 'off', 'step' => '0.01']) !!}
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
              {!! Form::number('total_amount', null, ['class' => 'form-control required', 'id' => 'total', 'placeholder' => 'Total Amount(Rs)', 'autocomplete' => 'off', 'step' => '0.01']) !!}
            </div>
          {!! $errors->first('total', '<span class="help-inline">:message</span>') !!}
        </div>

        <div class="form-group {{ $errors->has('deduction') ? 'has-error' : ''}}">
          <label class="col-md-12 control-label"><strong>Deduction (Rs)*</strong></label>
            <div class="col-md-12">
              {!! Form::number('deduction', null, ['class' => 'form-control required', 'id' => 'deduction', 'placeholder' => 'Deduction (Rs)', 'autocomplete' => 'off', 'step' => '0.01']) !!}
            </div>
          {!! $errors->first('deduction', '<span class="help-inline">:message</span>') !!}
        </div>
        <div class="form-group {{ $errors->has('tds_amount') ? 'has-error' : ''}}">
          <label class="col-md-12 control-label"><strong>TDS Amount 10% (Rs)*</strong></label>
            <div class="col-md-12">
              {!! Form::number('tds_amount', null, ['class' => 'form-control required', 'id' => 'tds', 'placeholder' => 'TDS Amount (Rs)', 'autocomplete' => 'off','step' => '0.01']) !!}
            </div>
          {!! $errors->first('tds_amount', '<span class="help-inline">:message</span>') !!}
        </div>

        <div class="form-group {{ $errors->has('amount_on_billing') ? 'has-error' : ''}}">
          <label class="col-md-12 control-label"><strong>Amount on Billing (Rs) =Total Amount - (Deduction +TDS)*</strong></label>
            <div class="col-md-12">
              {!! Form::number('amount_on_billing', null, ['class' => 'form-control required', 'id' => 'amount_on_billing', 'placeholder' => 'Billing Amount', 'autocomplete' => 'off', 'step' => '0.01']) !!}
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
                     <label class="btn btn-primary not-active">Yes <input class="claim-req" type="radio" value="1" name="documents_{{$v->id}}"></label>
                     <label class="btn btn-primary not-active">No <input class="claim-req" type="radio" value="0" name="documents_{{$v->id}}"></label>
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

  <div class="col-sm-12" id="reamrksSect">
    <div class="card">
      <div class="card-header">
        Remarks
      </div>
      <div class="card-body">
         <div class="form-group {{ $errors->has('remarks') ? 'has-error' : ''}}">
            <div class="col-md-12">
              {!! Form::textarea('remarks', null, ['class' => 'form-control required', 'id' => 'remarks', 'placeholder' => 'Remarks', 'rows' => 4]) !!}
            </div>
          {!! $errors->first('remarks', '<span class="help-inline">:message</span>') !!}
        </div>


        <div class="form-group" style="margin-top:100px;" id="canBePro"> 
            <label class="col-md-5 control-label"><strong>Can Be Processed ?*</strong></label>
            <div class="col-md-7">
                <div class="toggle-radio">
                  <input type="radio" class="can-be-pro" name="can_be_processed" id="yes" value="Yes" checked>
                  <input type="radio" class="can-be-pro" name="can_be_processed" id="no" value="No">
                  <div class="switch">
                    <label for="yes">Yes</label>
                    <label for="no">No</label>
                    <span></span>
                  </div>
                </div>
            </div>
          {!! $errors->first('can_be_processed', '<span class="help-inline">:message</span>') !!}
        </div>

        <div class="form-group pull-right">
            <button type="submit" class="btn btn-success"><i class="fa fa-telegram" aria-hidden="true"></i> SUBMIT</button>
        </div>
      </div>
    </div>
  </div>
</div>

{!! Form::close() !!}
      
@endsection



@section('pageCss')

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
.switch {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 150px;
    height: 50px;
    text-align: center;
    margin: -30px 0 0 -75px;
    background: #00bc9c;
    transition: all 0.2s ease;
    border-radius: 25px;
  }
  .switch span {
    position: absolute;
    width: 20px;
    height: 4px;
    top: 50%;
    left: 50%;
    margin: -2px 0px 0px -4px;
    background: #fff;
    display: block;
    transform: rotate(-45deg);
    transition: all 0.2s ease;
  }
  .switch span:after {
    content: "";
    display: block;
    position: absolute;
    width: 4px;
    height: 12px;
    margin-top: -8px;
    background: #fff;
    transition: all 0.2s ease;
  }
  input[type=radio] {
    display: none;
  }
  .switch label {
    cursor: pointer;
    color: rgba(0,0,0,0.2);
    width: 60px;
    line-height: 50px;
    transition: all 0.2s ease;
  }
  label[for=yes] {
    position: absolute;
    left: 0px;
    height: 20px;
  }
  label[for=no] {
    position: absolute;
    right: 0px;
  }
  #no:checked ~ .switch {
    background: #eb4f37;
  }
  #no:checked ~ .switch span {
    background: #fff;
    margin-left: -8px;
  }
  #no:checked ~ .switch span:after {
    background: #fff;
    height: 20px;
    margin-top: -8px;
    margin-left: 8px;
  }
  #yes:checked ~ .switch label[for=yes] {
    color: #fff;
  }
  #no:checked ~ .switch label[for=no] {
    color: #fff;
  }
textarea:hover, 
input:hover, 
textarea:active, 
input:active, 
textarea:focus, 
input:focus,
button:focus,
button:active,
button:hover,
label:focus,
.btn:active,
.btn.active
{
    outline:0px !important;
    -webkit-appearance:none;
}
</style>
@stop

@section('pageJs')

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

validateFloatForm = function() {


  bill_amount_from_hospital = $('#bill_amount_from_hospital').val();
  amount_as_per_package     = $('#amount_as_per_package').val();
  implants                  = $('#implants').val();
  travelling_allowance      = $('#travelling_allowance').val();
  deduction                 = $('#deduction').val();

  total_amount              = $('#total_amount').val();
  tds_amount                = $('#tds_amount').val();
  amount_on_billing         = $('#amount_on_billing').val();

  remarks                   = $('#remarks').val();

  claimRequirementRadios    = $(':radio[class="claim-req"]:checked').length;

  canBeProcessed            = $(':radio[class="can-be-pro"]:checked').length;


  if(bill_amount_from_hospital == '') {
    alert('Bill amount from hospital is missing !'+bill_amount_from_hospital);
    $(window).scrollTop($('#billing_card').offset().top);
    $('#bill_amount_from_hospital').focus();
    return false;
  }

  if(amount_as_per_package == '') {
    alert('Amount as per package is missing !');
    $(window).scrollTop($('#billing_card').offset().top);
    $('#amount_as_per_package').focus();
    return false;
  }

  if(implants == '') {
    alert('Implants is missing !');
    $(window).scrollTop($('#billing_card').offset().top);
    $('#implants').focus();
    return false;
  }

  if(travelling_allowance == '') {
    alert('Travel Allowance is missing !');
    $(window).scrollTop($('#billing_card').offset().top);
    $('#travelling_allowance').focus();
    return false;
  }

  if(deduction == '') {
    alert('Deduction is missing !');
    $(window).scrollTop($('#billing_card').offset().top);
    $('#deduction').focus();
    return false;
  }

  if(total_amount == '') {
    alert('Total Amount is missing !');
    $(window).scrollTop($('#billing_card').offset().top);
    $('#total_amount').focus();
    return false;
  }


  if(tds_amount == '') {
    alert('TDS Amount is missing !');
    $(window).scrollTop($('#billing_card').offset().top);
    $('#tds_amount').focus();
    return false;
  }


  if(amount_on_billing == '') {
    alert('Amount on Billing is missing !');
    $(window).scrollTop($('#billing_card').offset().top);
    $('#amount_on_billing').focus();
    return false;
  }


  if(remarks == '') {
    alert('Remarks is missing !');
    $(window).scrollTop($('#reamrksSect').offset().top);
    $('#remarks').focus();
    return false;
  }

  if(claimRequirementRadios != {{ count( Helper::claimRequirements() ) }} ) {
    alert('All documents selection is mendatory !');
    $(window).scrollTop($('#billing_card').offset().top);
    return false;
  }

  if(canBeProcessed != 1) {
    alert('Please select if claim can be processed or not !');
    $(window).scrollTop($('#canBePro').offset().top);
    return false;
  }


  return true;
  
}

calculateTotal = function() {
  

  bill_amount_from_hospital = $('#bill_amount_from_hospital').val();
  amount_as_per_package     = $('#amount_as_per_package').val();
  implants                  = $('#implants').val();
  travelling_allowance      = $('#travelling_allowance').val();
  deduction                 = $('#deduction').val();

  total_amount              = $('#total_amount').val();
  tds_amount                = $('#tds_amount').val();
  amount_on_billing         = $('#amount_on_billing').val();

  if(bill_amount_from_hospital == '') {
    bill_amount_from_hospital = 0;
  }
  if(amount_as_per_package == '') {
    amount_as_per_package = 0;
  }
  if(implants == '') {
    implants = 0;
  }
  if(travelling_allowance == '') {
    travelling_allowance = 0;
  }
  if(deduction == '') {
    deduction = 0;
  }
  var totalBill = parseInt(amount_as_per_package)+parseInt(implants)+parseInt(travelling_allowance);
  $('#total').val(totalBill);
  tds = parseFloat((0.1*totalBill));
  tds = tds.toFixed(2);
  $('#tds').val(tds);
  $('#amount_on_billing').val(totalBill - parseInt(deduction) - tds);
}
$(function() {
    //$('#remarks').summernote({ height: 200 });
    // Input radio-group visual controls
    $('.radio-group label').on('click', function(){
        $(this).removeClass('not-active').siblings().addClass('not-active');
    });
    $('#amount_as_per_package').keyup(function(){
      var bill_amount_from_hospital = $('#bill_amount_from_hospital').val();
      if(bill_amount_from_hospital != '') {
        if(bill_amount_from_hospital != $(this).val()) {
          $('#amount_as_per_package').css( 'border', "1px solid red")
        }else{
          $('#amount_as_per_package').css( 'border', "1px solid #ccc")
        }
      }
    });
    $('#amount_as_per_package,#implants,#travelling_allowance,#deduction').keyup(function(){ 
      calculateTotal();
    });
    $('form').on('focus', 'input[type=number]', function (e) {
      $(this).on('mousewheel.disableScroll', function (e) {
        e.preventDefault()
      })
    })
    $('form').on('blur', 'input[type=number]', function (e) {
      $(this).off('mousewheel.disableScroll')
    })
})


</script>
@stop
