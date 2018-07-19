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
          <td id="pname">{{ $float->patient_name }}</td>

          <th>CCN Number</th>
          <td><input id="ccn_no" class="form-control" readonly="readonly" value="{{ $float->tpa_claim_reference_number }}">
            <a href="javascript:void(0)" class="btn btn-link" onclick="copyCCN();">Copy</a>
          </td>

          <th>Patient Age</th>
          <td>{{ $float->patient_age }}</td>

          <th>Patient Gender</th>
          <td>{{ $float->patient_gender }}</td>

          <th>URN</th>
          <td><span id="urn"> {{ $float->enr_urn }}</span></td>
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

<div class="col-md-12" style="margin-bottom: 10px;">
  <a href="javascript:void(0)" onclick="showPatientInfo( '{{ $float->tpa_claim_reference_number }}' )" class="btn btn-sm btn-primary"> <i class="fa fa-search" aria-hidden="true"></i> Search Patient Data</a>


  <a href="http://aaa-assam.in/PreAuthClaims/PreauthDocumentUpload.aspx?hf_caseNo={{ $float->tpa_claim_reference_number }}" class="btn btn-sm btn-danger" target="_blank"> <i class="fa fa-file-word-o" aria-hidden="true"></i> View Documents</a>  
</div>

 {!! Form::model($float_process, array('route' => ['claim.float_data.update', Crypt::encrypt($float_process->id)], 'id' => 'department_update', 'class' => 'form-horizontal row-border')) !!}

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

        <?php 
          $claim_requirement_id = $v->id;
          $check = DB::table('float_process_documents')->where('float_process_id', $float_process->id)->where('float_requirement_id', $claim_requirement_id)->first();

          $float_requirement_value  = 0;

          if($check) {
            $float_requirement_value = $check->float_requirement_value;
          }

        ?>

        <div class="row">
          <div class="col-md-5"><strong>{{ $v->name }}</strong> *</div>
            <div class="col-md-7">
              <div class="form-group">
                <div class="col-sm-12 col-md-12">
                  
                

                  <div class="custom-radios" >
                    <div>

                      <div>
                        <input type="radio" id="color-yes-{{$v->id}}" class="claim-req yup" type="radio" value="1" name="documents_{{$v->id}}" @if($float_requirement_value) checked="checked" @endif >
                        <label for="color-yes-{{$v->id}}">
                          <span>
                          </span>
                        </label> YES
                      

                   
                        <input type="radio" id="color-no-{{$v->id}}" class="claim-req nope" type="radio" value="0" name="documents_{{$v->id}}" @if(!$float_requirement_value) checked="checked" @endif>
                        <label for="color-no-{{$v->id}}">
                          <span>
                          </span>
                        </label> NO
                      </div>
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



        <?php 
            $can_be_processed['Yes']  = 'Yes';
            $can_be_processed['No']   = 'No';
          ?>

          <div class="form-group {{ $errors->has('total') ? 'has-error' : ''}}">
            <label class="col-md-12 control-label"><strong>Can Be Processed*</strong></label>
              <div class="col-md-2">
                {!! Form::select('can_be_processed', $can_be_processed, $float_process->can_be_processed, ['class' => 'form-control required', 'id' => 'can_be_processed', 'autocomplete' => 'off']) !!}
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


<div id="patientModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

            </div>
            <div class="modal-body">
              <p class="col-sm-12">
                Patient Name in Dashboard : <span id="dashboardPatientName"></span>
              </p>

              <p class="col-sm-12">
                Patient Name in Float  : <span id="floatPatientName"></span>
              </p>

              <hr>

              <p class="col-sm-12">
                CCN in Dashboard : <span id="dashboardCCN"></span>
              </p>

              <p class="col-sm-12">
                CCN in Float  : <span id="floatCCN"></span>
              </p>

              <hr>

              <p class="col-sm-12">
                URN in Dashboard : <span id="dashboardURN"></span>
              </p>

              <p class="col-sm-12">
                URN in Float  : <span id="floatURN"></span>
              </p>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
 
@endsection



@section('pageCss')

<style type="text/css">
.custom-radios div {
  display: inline-block;
}
.custom-radios input[type="radio"] {
  display: none;
}
.custom-radios input[type="radio"] + label {
  color: #333;
  font-family: Arial, sans-serif;
  font-size: 14px;
}
.custom-radios input[type="radio"] + label span {
  display: inline-block;
  width: 30px;
  height: 30px;
  margin: -1px 4px 0 0;
  vertical-align: middle;
  cursor: pointer;
  border-radius: 50%;
  border: 2px solid #FFFFFF;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.33);
  background-repeat: no-repeat;
  background-position: center;
  text-align: center;
  line-height: 34px;
}
.custom-radios input[type="radio"] + label span img {
  opacity: 0;
  transition: all .3s ease;
}

.custom-radios input[type="radio"].yup + label span {
  background-color: #666;
}

.custom-radios input[type="radio"].nope + label span {
  background-color: #666;
}


.custom-radios input[type="radio"]:checked + label span {
  opacity: 1;
  background-color: #90F25B;
  width: 30px;
  height: 30px;
  display: inline-block;

}


/** Radio Circle **/

.btn-circle {
  width: 30px;
  height: 30px;
  text-align: center;
  padding: 6px 0;
  font-size: 12px;
  line-height: 1.428571429;
  border-radius: 15px;
}
.btn-circle.btn-lg {
  width: 50px;
  height: 50px;
  padding: 13px 13px;
  font-size: 18px;
  line-height: 1.33;
  border-radius: 25px;
}
</style>
@stop

@section('pageJs')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
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


showPatientInfo = function(ccn_number) {
  var data = '';
  var url  = '';

  data += '&ccn='+ccn_number;

  url  += "{{ route('api_get_data') }}";

  $.blockUI();
  $.ajax({
    url : url,
    type : 'get',
    data : data,
    dataType : 'json',
    error : function(resp) { 
      $.unblockUI();
      //console.log(resp);
    },

    success : function(resp) {
      $.unblockUI();

      $('#dashboardPatientName').text('');
      $('#dashboardPatientName').text(resp.patient_name);

      $('#floatPatientName').text('');
      $('#floatPatientName').text($('#pname').text());

      //URN//
      $('#dashboardURN').text('');
      $('#dashboardURN').text(resp.urn);

      $('#floatURN').text('');
      $('#floatURN').text($('#urn').text());

      //CCN
      $('#dashboardCCN').text('');
      $('#dashboardCCN').text(resp.ccn);

      $('#floatCCN').text('');
      $('#floatCCN').text($('#ccn_no').val());

      console.log(resp);

      $('#patientModal').modal('show')
      
    }
  });
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
