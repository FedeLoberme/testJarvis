<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Jarvis-BETA</title>
    <!-- Styles -->
  <!--   <link href="{{ asset('public/css/app.css') }}" rel="stylesheet"> -->
    <link rel="shortcut icon" href="{{ asset('public/img/logo1.png') }}" />
    <!-- -------------------------------------------------------------------- -->

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!--////////////////////////bootstrap/////////////////////////////////// -->

    <link rel="stylesheet" type="text/css" href="{{asset('public/table_ful/DataTables-1.10.21/css/dataTables.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('public/table_ful/AutoFill-2.3.5/css/autoFill.bootstrap4.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('public/table_ful/Buttons-1.6.3/css/buttons.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('public/table_ful/ColReorder-1.5.2/css/colReorder.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('public/table_ful/FixedHeader-3.1.7/css/fixedHeader.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('public/table_ful/KeyTable-2.5.2/css/keyTable.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('public/table_ful/RowReorder-1.2.7/css/rowReorder.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('public/table_ful/Scroller-2.0.2/css/scroller.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('public/table_ful/SearchPanes-1.1.1/css/searchPanes.bootstrap4.min.css')}}"/>

    <script src="https://cdn.rawgit.com/zenorocha/clipboard.js/v1.5.3/dist/clipboard.min.js"></script>


    <!-- Mainly scripts -->
    <link href="{{ asset('public/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/bootstrap/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('public/bootstrap/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('public/bootstrap/css/style.css') }}" rel="stylesheet">

    {{-- Wizard style --}}
    <link href="{{ asset('public/bootstrap/css/plugins/steps/jquery.steps.css') }}" rel="stylesheet">
    <link href="{{ asset('public/bootstrap/css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <!-- Toastr style -->
    <link href="{{ asset('public/bootstrap/css/plugins/toastr/toastr.min.css') }} " rel="stylesheet">
    <!-- Sweet alert style -->
    <link href="{{ asset('public/bootstrap/css/plugins/sweetalert/sweetalert.css') }} " rel="stylesheet">
    <!-- Gritter -->
    <link href="{{ asset('public/bootstrap/js/plugins/gritter/jquery.gritter.css') }} " rel="stylesheet">


    <link href="{{ asset('public/bootstrap/css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">

    <link href="{{ asset('public/bootstrap/css/plugins/select2/select2.min.css') }} " rel="stylesheet">

    <!-- ////////////////////////////////////////////////////////////// -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<div id="noty-holder"></div>
<body id="body">
   <div id="wrapper">
        <!--INICIO DEL MENÚ -->
        @if (!Auth::guest())
            @include('layouts.menu')
        @endif
        <!--FIN DEL MENÚ-->
        <!--EL CUERPO GRIS DE LA PAGINA INICIA AQUÍ -->
        <div id="page-wrapper" class="gray-bg">

        <!--INICIA ENCABEZADO DEL CUERPO GRIS DE LA PAGÍNA-->
            @include('layouts.navegation')
        <!--FIN DEL ENCABEZADO DEL CUERPO GRIS DE LA PÁGINA-->

        <!-- inicio del Contenido-->
        <div class="row wrapper border-bottom white-bg page-heading">
            <h2></h2>
            <ol class="breadcrumb">
                <li class="active">
                    <a href="{{ url('/home') }}"><strong>INICIO</strong></a>
                </li>

            @yield('content')
        <!-- fin del Contenido-->

        <!--AQUI INICIA PIE DE PAGINA -->
            @include('popInformacion')
            @include('layouts.tutorial')
            @include('layouts.footer')
        </div>

        <!--AQUI FINALIZA EL PIE DE LA PAGINA-->
    </div>
    <div class="loader-wrapper">
        <!--<div class="sk-spinner sk-spinner-wave">
            <div class="sk-rect1"></div>
            <div class="sk-rect2"></div>
            <div class="sk-rect3"></div>
            <div class="sk-rect4"></div>
            <div class="sk-rect5"></div>
        </div>-->
     <span class="loader"><span class="loader-inner"></span></span>
    </div>

    <!-- Scripts -->
    <!-- <script src="{{ asset('public/js/app.js') }}"></script> -->
    <script src="https://kit.fontawesome.com/6bca988241.js" crossorigin="anonymous"></script>
    <script src="{{ asset('public/bootstrap/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('public/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/bootstrap/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('public/bootstrap/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('public/bootstrap/js/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('public/bootstrap/js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('public/bootstrap/js/plugins/flot/jquery.flot.spline.js') }}"></script>
    <script src="{{ asset('public/bootstrap/js/plugins/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('public/bootstrap/js/plugins/flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('public/bootstrap/js/plugins/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('public/bootstrap/js/demo/peity-demo.js') }}"></script>
    <script src="{{ asset('public/bootstrap/js/inspinia.js') }}"></script>
    <script src="{{ asset('public/bootstrap/js/plugins/pace/pace.min.js') }}"></script>
    <script src="{{ asset('public/bootstrap/js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/bootstrap/js/plugins/gritter/jquery.gritter.min.js') }}"></script>
    <script src="{{ asset('public/bootstrap/js/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('public/bootstrap/js/demo/sparkline-demo.js') }}"></script>
    <script src="{{ asset('public/bootstrap/js/plugins/chartJs/Chart.min.js') }}"></script>
    <script src="{{ asset('public/bootstrap/js/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('public/bootstrap/js/plugins/dropzone/dropzone.js')}}"></script>
    <script src="{{ asset('public/bootstrap/js/plugins/chosen/chosen.jquery.js')}}"></script>

    <script src="{{ asset('public/bootstrap/js/plugins/sweetalert/sweetalert.min.js')}}"></script>
    <script src="{{ asset('public/bootstrap/js/plugins/clipboard/clipboard.min.js')}}"></script>

       <!-- constantes -->
       <script src="{{asset('public/js/constants.js')}}"></script>
       <!-- constantes -->
    <script src="{{ asset('public/js/jarvis.js') }}"></script>
    <script src="{{ asset('public/js/jarvis_funtion.js') }}"></script>
    <script src="{{ asset('public/js/jarvis_alta.js') }}"></script>
    <script src="{{ asset('public/js/jarvis_list_ajax.js') }}"></script>




    <!-- Jquery Steps -->
    <script src="{{ asset('public/bootstrap/js/plugins/steps/jquery.steps.js') }}"></script>
    <!-- Jquery Validate -->
    <script src="{{ asset('public/bootstrap/js/plugins/validate/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/table_ful/JSZip-2.5.0/jszip.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/table_ful/pdfmake-0.1.36/pdfmake.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/table_ful/pdfmake-0.1.36/vfs_fonts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/table_ful/DataTables-1.10.21/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/table_ful/DataTables-1.10.21/js/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/table_ful/AutoFill-2.3.5/js/dataTables.autoFill.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/table_ful/AutoFill-2.3.5/js/autoFill.bootstrap4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/table_ful/Buttons-1.6.3/js/dataTables.buttons.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/table_ful/Buttons-1.6.3/js/buttons.bootstrap4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/table_ful/Buttons-1.6.3/js/buttons.colVis.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/table_ful/Buttons-1.6.3/js/buttons.flash.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/table_ful/Buttons-1.6.3/js/buttons.html5.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/table_ful/Buttons-1.6.3/js/buttons.print.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/table_ful/ColReorder-1.5.2/js/dataTables.colReorder.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/table_ful/FixedHeader-3.1.7/js/dataTables.fixedHeader.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/table_ful/KeyTable-2.5.2/js/dataTables.keyTable.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/table_ful/RowReorder-1.2.7/js/dataTables.rowReorder.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/table_ful/Scroller-2.0.2/js/dataTables.scroller.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/table_ful/SearchPanes-1.1.1/js/dataTables.searchPanes.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/table_ful/SearchPanes-1.1.1/js/searchPanes.bootstrap4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/jarvis_wizard.js') }}"></script>

    <script src="{{ asset('public/bootstrap/js/plugins/select2/select2.full.min.js') }}"></script>
    <script>
        @if(Session::has('message'))
            var type="{{Session::get('alert-type','info')}}"
            switch(type){
                case 'info':
                    toastr.info("{{ Session::get('message') }}");
                break;
                case 'success':
                    toastr.success("{{ Session::get('message') }}");
                break;
                case 'warning':
                    toastr.warning("{{ Session::get('message') }}");
                break;
                case 'error':
                    toastr.error("{{ Session::get('message') }}");
                break;
            }
        @endif
    </script>

       <style>
           .swal2-popup{
               font-size: 2rem!important;
           }
       </style>

    <script>
        $(window).on("load",function(){
          $(".loader-wrapper").fadeOut("slow");
        });
    </script>
       <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>



   @yield('script')
</body>
</html>
