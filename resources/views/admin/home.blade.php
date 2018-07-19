@extends('admin.layout.master')

@section('main_content')
<div class="row">
  <div class="col-sm-6 col-lg-3">
    <div class="card text-white bg-primary">
      <div class="card-body pb-0">
        <div class="text-value">{{ $unique_floats }}</div>
        <div>Floats Uploaded</div>
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
        <div>Claims Paid</div>
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
        <div>Members online</div>
      </div>
      <div class="chart-wrapper mt-3 mx-3" style="height:70px;">
        <canvas id="card-chart4" class="chart" height="70"></canvas>
      </div>
    </div>
  </div>
  <!--/.col-->
</div>
@endsection
