@extends('admin.layout.master')

@section('pageCss')
<style>
.fa-ambulance { color: #FF0707; }
.fa-university { color: #3C09FC; }
</style>
@stop


@section('main_content')
<div class="row">
  <div class="col-sm-6 col-lg-3">
    <div class="card text-white bg-primary">
      <div class="card-body pb-0">
        <div class="text-value">{{ $float_number }}</div>
        <div>Floats Received</div>
      </div>
      <div class="chart-wrapper mt-3 mx-3" style="height:70px;">
        <canvas id="card-chart1" class="chart" height="70"></canvas>
      </div>
    </div>
  </div>
  <!--/.col-->
  <div class="col-sm-6 col-lg-3">
    <div class="card text-white bg-info">
      <div class="card-body pb-0">
        <button type="button" class="btn btn-transparent p-0 float-right">
          <i class="icon-location-pin"></i>
        </button>
        <div class="text-value">{{ $float_processed }}</div>
        <div>Claims Processed</div>
      </div>
      <div class="chart-wrapper mt-3 mx-3" style="height:70px;">
        <canvas id="card-chart2" class="chart" height="70"></canvas>
      </div>
    </div>
  </div>
  <!--/.col-->
  <div class="col-sm-6 col-lg-3">
    <div class="card text-white bg-warning">
      <div class="card-body pb-0">
        <div class="text-value">9.823</div>
        <div>Processing</div>
      </div>
      <div class="chart-wrapper mt-3" style="height:70px;">
        <canvas id="card-chart3" class="chart" height="70"></canvas>
      </div>
    </div>
  </div>
  <!--/.col-->
  <div class="col-sm-6 col-lg-3">
    <div class="card text-white bg-danger">
      <div class="card-body pb-0">
        <div class="text-value">9.823</div>
        <div>Pending </div>
      </div>
      <div class="chart-wrapper mt-3 mx-3" style="height:70px;">
        <canvas id="card-chart4" class="chart" height="70"></canvas>
      </div>
    </div>
  </div>
  <!--/.col-->
</div>
<div class="animated fadeIn">

  <ul class="nav nav-tabs">
     <li><a href="#medical_colleges" class="nav-link active" data-toggle="tab"><i class="fa fa-university" aria-hidden="true"></i> <strong>Medical Colleges</strong></a></li>
     <li><a href="#private_hospitals" class="nav-link" data-toggle="tab"><i class="fa fa-ambulance" aria-hidden="true"></i> <strong>Private Hospitals</strong></a></li>
  </ul>

  <div class="tab-content">
     <div class="tab-pane active" id="medical_colleges">
        <div class="card">
          <div class="card-header  alert alert-success">
            <h4>Claims and Payments : Medical Colleges</h4>
          </div>

          <div class="card-body">
             <table class="table table-hover table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Hospital Name</th>
                  <th>Number of Claims</th>
                  <th>Amount Paid</th>
                  <th>Pending</th>
                  <th>Total</th>
                  <th>View</th>
                </tr>
              </thead>

              <tbody class="hsopital-body">
                <?php $all_claims = $paid = $unpaid = $total = 0; ?>
                @foreach($medical_colleges as $k => $v)

                <?php 
                  $all_claims +=  Helper::getAllClaims($v->id); 
                  $paid       += Helper::getAllPaidClaims($v->id);
                  $unpaid     += Helper::getAllUnpaidClaims($v->id);
                  $total      += Helper::getAllPaidClaims($v->id) + Helper::getAllUnpaidClaims($v->id); 
                ?>
                  <tr>
                    <td>
                      {{ $k+1 }}
                    </td>

                    <td>{{ $v->name }}</td>

                    <td>{{ Helper::getAllClaims($v->id) }}</td>

                    <td>{{ Helper::getAllPaidClaims($v->id) }}</td>

                    <td>{{ Helper::getAllUnpaidClaims($v->id) }}</td>

                    <td>{{ Helper::getAllPaidClaims($v->id) + Helper::getAllUnpaidClaims($v->id) }}</td>

                    <td><a href="#" class="btn btn-xs btn-info">View</a></td>

                  </tr>
                @endforeach
              </tbody>

              <tfoot>
                <tr>
                  <th colspan="2">Total</th>
                  <th> {{ $all_claims }} </th>
                  <th> {{ Helper::twoDecimalPlaces($paid) }} </th>
                  <th> {{ Helper::twoDecimalPlaces($unpaid) }} </th>
                  <th> {{ Helper::twoDecimalPlaces($total) }} </th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
     </div>
     <div class="tab-pane" id="private_hospitals">
       <div class="card col-md-12">
          <div class="card-header  alert alert-warning">
            <h4>Claims and Payments : Private Hospitals</h4>
          </div>

          <div class="card-body">
             <table class="table table-hover table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Hospital Name</th>
                  <th>Number of Claims</th>
                  <th>Amount Paid</th>
                  <th>Pending</th>
                  <th>Total</th>
                  <th>View</th>
                </tr>
              </thead>

              <tbody class="hsopital-body">
                <?php $all_claims = $paid = $unpaid = $total = 0; ?>
                @foreach($private_hospitals as $k => $v)

                <?php 
                  $all_claims +=  Helper::getAllClaims($v->id); 
                  $paid       += Helper::getAllPaidClaims($v->id);
                  $unpaid     += Helper::getAllUnpaidClaims($v->id);
                  $total      += Helper::getAllPaidClaims($v->id) + Helper::getAllUnpaidClaims($v->id); 
                ?>
                  <tr>
                    <td>
                      {{ $k+1 }}
                    </td>

                    <td>{{ $v->name }}</td>

                    <td>{{ Helper::getAllClaims($v->id) }}</td>

                    <td>{{ Helper::getAllPaidClaims($v->id) }}</td>

                    <td>{{ Helper::getAllUnpaidClaims($v->id) }}</td>

                    <td>{{ Helper::getAllPaidClaims($v->id) + Helper::getAllUnpaidClaims($v->id) }}</td>

                    <td><a href="#" class="btn btn-xs btn-info">View</a></td>

                  </tr>
                @endforeach
              </tbody>

              <tfoot>
                <tr>
                  <th colspan="2">Total</th>
                  <th> {{ $all_claims }} </th>
                  <th> {{ Helper::twoDecimalPlaces($paid) }} </th>
                  <th> {{ Helper::twoDecimalPlaces($unpaid) }} </th>
                  <th> {{ Helper::twoDecimalPlaces($total) }} </th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
     </div>
  </div>
</div>

@endsection
