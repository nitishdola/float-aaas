@extends('claim.layout.default')

@section('main_content')
<div class="card">
  <div class="card-header">
    {{ $float->patient_name }}
    <small>Info</small>
  </div>
  <div class="card-body">
    <h5>Patient Info</h5>
    <table class="table table-bordered table-condensed">
        <tr>
          <th>Patient Name</th>
          <td>{{ $float->patient_name }}</td>

          <th>CCN Number</th>
          <td>{{ $float->tpa_claim_reference_number }}</td>

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


      <h5>Hospital Info</h5>
      <table class="table table-bordered table-condensed">
        <tr>
          <th>Hospital Name</th>
          <td>{{ $float->hospital_name }}</td>

          <th>Hospital Type</th>
          <td>{{ $float->hospital_type }}</td>

          <th>Hospital Email ID</th>
          <td>{{ $float->hospital_email_id }}</td>

          <th>Hospital Mobile Number</th>
          <td>{{ $float->hospital_mobile_number }}</td>

          <th>Hospital PAN</th>
          <td>{{ $float->hospital_pan_number }}</td>

          <th>Hospital Payee</th>
          <td>{{ $float->hospital_payee_name }}</td>

          <th>Payee Bank</th>
          <td>{{ $float->payee_bank_name }}</td>
        </tr>

        <tr>
          

          <th>Bank Address</th>
          <td>{{ $float->payee_branch_address }}</td>

          <th>Account Type</th>
          <td>{{ $float->payee_account_type }}</td>

          <th>A/C No.</th>
          <td>{{ $float->payee_bank_account_number }}</td>

          <th>IFSC Code</th>
          <td>{{ $float->payee_bank_ifsc_code }}</td>
        </tr>
      </table>

      <div class="col-md-1 pull-right">
        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal">
          <i class="fa fa-telegram" aria-hidden="true"></i> Inspect Float
        </button>
      </div>

  </div>
</div>


<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        
        <table class="table table-bordered table-responsive-sm table-sm">
          <thead>
            <tr>
              <th>Document Name</th>
              <th>Received</th>
              <th>Not Received</th>
            </tr>
          </thead>

          <tbody>
            @foreach(Helper::claimRequirements() as $k => $v)
            <tr>
              <td>{{ $v->name }}</td>
              <td>
                <div class="roundedTwo">
                  <input type="checkbox" name="checkboxG1" id="checkboxG1" class="css-checkbox" />
                  <label for="checkboxG1" class="css-label">Option 1</label>
                </div>
              </td>
              <td>
                <div class="roundedTwo">
                  <input type="checkbox" name="checkboxG1" id="checkboxG1" class="css-checkbox" />
                  <label for="checkboxG1" class="css-label">Option 1</label>
                </div>
              </td>
            </tr>  
            @endforeach
          </tbody>
        </table>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
@endsection



@section('pageCss')
<style type="text/css">

input[type=checkbox].css-checkbox {
  position:absolute; z-index:-1000; left:-1000px; overflow: hidden; clip: rect(0 0 0 0); height:1px; width:1px; margin:-1px; padding:0; border:0;
}

input[type=checkbox].css-checkbox + label.css-label {
  padding-left:15px;
  height:20px; 
  display:inline-block;
  line-height:20px;
  background-repeat:no-repeat;
  background-position: 0 0;
  font-size:20px;
  vertical-align:middle;
  cursor:pointer;

}

input[type=checkbox].css-checkbox:checked + label.css-label {
  background-position: 0 -50px;
}
label.css-label {
  background-image:url(http://csscheckbox.com/checkboxes/u/csscheckbox_6a85234bd18e936e19750515adec25ca.png);
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

</style>
@stop