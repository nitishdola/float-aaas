@extends('claim.layout.default')

@section('main_content')
<div class="card">
  <div class="card-header">
    <?php $str = 'cc+YmFzZTY0IGVuY29kZWQgc3RyaW5n'; ?>
    <small>Aad <?php echo base64_decode($str); ?></small>
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
  </div>
</div>
@endsection