<div class="row border-bottom"> <!--Inicio del 10grupo en la parte superior del cuerpo gris-->
<!--INICIA ENCABEZADO DEL CUERPO GRIS DE LA PAGÍNA-->
    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        @if (!Auth::guest())
            <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-danger " href="#"><i class="fa fa-bars"></i></a>
                        <a class="btn btn-danger minimalize-styl-2" href="#" title="Información" data-toggle="modal" data-target="#informacion_todo_pop"><i class="fa fa-info-circle"></i></a>
                        <a class="btn btn-danger minimalize-styl-2" href="#" title="Ayuda" data-toggle="modal" data-target="#ayuda_tutoriales_pop"><i class="fa fa-support"></i></a>
            </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out"></i> Cerrar Sesión
                    </a>
                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                    </form>
                </li>
            </ul>
         @endif
    </nav>
<!--FIN DEL ENCABEZADO DEL CUERPO GRIS DE LA PÁGINA-->
</div> <!--Fin del agrupado del la parte superior del cuerpo gris