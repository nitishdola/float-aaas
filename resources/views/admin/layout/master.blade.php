<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="AAAS - TA System">
    <meta name="author" content="Nitish Dolakasharia">
    <meta name="keyword" content="AAAS - TA System">
    <title>AAAS - Float Admin</title>
    <!-- Icons-->
    <link href="{{ asset('assets/node_modules/flag-icon-css/css/flag-icon.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/node_modules/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/node_modules/simple-line-icons/css/simple-line-icons.css') }}" rel="stylesheet">
    <!-- Main styles for this application-->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/pace-progress/css/pace.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.16/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Zebra_datepicker/1.9.10/css/bootstrap/zebra_datepicker.min.css">
    <style>
      .fa-heartbeat {
        color: #F10202;
      }
    </style>
    @yield('pageCss')

  </head>
  <body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
    <header class="app-header navbar">
      @include('admin.layout.common.header')
    </header>
    <div class="app-body">
      <main class="main" style="margin-left:0;">
        
        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row" style="margin-top: 20px;">

              @if(Session::has('message'))
              <div class="row">
                 <div class="col-lg-12">
                       <div class="alert {{ Session::get('alert-class', 'alert-info') }}">
                             <button type="button" class="close" data-dismiss="alert">×</button>
                             {!! Session::get('message') !!}
                       </div>
                    </div>
              </div>
              @endif

              @if ($errors->any())
                      {!! implode('', $errors->all('<div class="btn btn-danger">:message</div>')) !!}
              @endif
            
              @yield('main_content')
              <!--/.col-->
            </div>
            <!--/.row-->
          </div>

        </div>
      </main>
    </div>

    <footer class="app-footer" style="margin:0;">
      @include('admin.layout.common.footer')
    </footer>
    <!-- Bootstrap and necessary plugins-->
    <script src="{{ asset('assets/node_modules/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/node_modules/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('assets/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/node_modules/pace-progress/pace.min.js') }}"></script>
    <script src="{{ asset('assets/node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/node_modules/@coreui/coreui/dist/js/coreui.min.js') }}"></script>
    <!-- Plugins and scripts required by this view-->
    <script src="node_modules/chart.js/dist/Chart.min.js') }}"></script>
    <script src="node_modules/@coreui/coreui-plugin-chartjs-custom-tooltips/dist/js/custom-tooltips.min.js') }}"></script>
 
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.16/datatables.min.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Zebra_datepicker/1.9.10/zebra_datepicker.min.js"></script>

    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
      $(document).ready(function() {
          $('#dataTable').DataTable({
            "bPaginate" : false,
            "bInfo" : false
          });

          $('input.datepicker').Zebra_DatePicker({
            format : 'Y-m-d'
          });

      } );
    </script>
    @yield('pageJs')
  </body>
</html>