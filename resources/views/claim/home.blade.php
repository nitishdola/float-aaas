@extends('claim.layout.default')

@section('main_content')

<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <strong>Floats</strong>
          View All
        </div>
          <div class="card-body">
            @if(count($results))
            <table class="table table-bordered table-hover table-responsive" id="dataTable">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Claim Referance Number</th>
                  <th>Patient Name</th>
                  <th>Hospital Name</th>
                  <th>Date of Admission</th>
                  <th>Date of Discharge</th>
                  <th width="20%">Package Code</th>
                  <th>Current Status</th>
                  <th>View Details</th>
                </tr>
              </thead>

              <tbody>
                @foreach($results as $k => $v)
                  <tr>
                    <td>{{ $k+1}} </td>
                    
                    <td>{{ $v->tpa_claim_reference_number }}</td>
                    <td>{{ $v->patient_name }}</td>
                    <td>{{ $v->hospital->name }}</td>
                    <td>{{ $v->date_of_admission }}</td>
                    <td>{{ $v->date_of_discharge }}</td>
                    <td>{{ str_replace(',', ' , ', $v->package_code) }}</td>

                    <td>{{ ucwords(str_replace('_', ' ',$v->current_status)) }}</td>
                    
                    <td><a href="{{ route('claim.floats.view_info', Crypt::encrypt($v->id)) }}" target="_blank" class="btn btn-sm btn-primary"> View Details</a>
                  </tr>
                @endforeach
              </tbody>
            </table>
            @else
            <div class="alert alert-warning">
              <h3>No Floats Found !</h3>
            </div>
            @endif
          </div>
      </div>
    </div>
</div>

@endsection

@section('pageJs')
<script>
$('#chkParent').click(function() {
      var isChecked = $(this).prop("checked");
      $('#dataTable tr:has(td)').find('input[type="checkbox"]').prop('checked', isChecked);
  });

  $('#dataTable tr:has(td)').find('input[type="checkbox"]').click(function() {
      var isChecked = $(this).prop("checked");
      var isHeaderChecked = $("#chkParent").prop("checked");
      if (isChecked == false && isHeaderChecked)
          $("#chkParent").prop('checked', isChecked);
      else {
          $('#dataTable tr:has(td)').find('input[type="checkbox"]').each(function() {
              if ($(this).prop("checked") == false)
                  isChecked = false;
          });
          $("#chkParent").prop('checked', isChecked);
      }
  });
</script>
@endsection
