<html>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}" />

    
    <title>LaravelProduct - @yield('title')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('public/assets/plugins/fontawesome-free/css/all.min.css') }}" >
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ url('public/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ url('public/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ url('public/assets/plugins/jqvmap/jqvmap.min.css') }}">
      <!-- DataTables -->
    <link rel="stylesheet" href="{{ url('public/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('public/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('public/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('public/assets/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ url('public/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{url('public/assets/plugins/datepicker/datepicker3.css')}}">
    <link rel="stylesheet" href="{{ url('public/assets/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ url('public/assets/plugins/summernote/summernote-bs4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ url('public/assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ url('public/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="{{ url('public/assets/plugins/dropzone/min/dropzone.min.css') }} ">
    @yield('style')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @yield('navbar')       
        @yield('sidebar')
        <div class="content-wrapper">
            @yield('content')
        </div>
        @yield('footer')
    </div>
    <script src="{{ url('public/assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ url('public/assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
    $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ url('public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ url('public/assets/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ url('public/assets/plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ url('public/assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ url('public/assets/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ url('public/assets/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ url('public/assets/plugins/moment/moment.min.js')}}"></script>
    <script src="{{ url('public/assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ url('public/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ url('public/assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ url('public/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('public/assets/dist/js/adminlte.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ url('public/assets/dist/js/demo.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <!-- <script src="{{ url('public/assets/dist/js/pages/dashboard.js') }}"></script> -->

    <!-- DataTables  & Plugins -->
    <script src="{{ url('public/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('public/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ url('public/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ url('public/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ url('public/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ url('public/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ url('public/assets/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ url('public/assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ url('public/assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ url('public/assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ url('public/assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ url('public/assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ url('public/assets/plugins/select2/js/select2.full.min.js')}}"></script>
    
    @yield('script')
</body>
</html>