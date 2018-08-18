@extends('admin.layout.master')

@section('main_content')

<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <strong>Floats</strong>
      View All
    </div>
      <div class="card-body">
        @if(count($all_float_numbers))
        
        <table class="table table-bordered table-hover table-responsive">
          <thead>
            <tr>
              <th>#</th>
              <th>Float Number</th>
              <th>Float Date</th>
              <th>Total Cases</th>
              <th>Total Processed Cases</th>
          </thead>

          <tbody>
            @foreach($all_float_numbers as $k => $v)
              <tr>
                <td>{{ $k+1}} </td>
                
                <td>{{ $v->name }}</td>
                <td>{{ date('d-m-Y', strtotime($v->float_date)) }}</td>
                <td> {{ count($v->floats) }}</td>
                <?php 
                $processed = DB::table('floats')->where('status',1)->where('current_status', 'float_processed_by_claims_coordinator')->count();
                ?>
                <td>{{ $processed }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
        </div>
        @else
        <div class="alert alert-warning">
          <h3>No Floats Found !</h3>
        </div>
        @endif

      </div>
  </div>
</div>

@endsection

