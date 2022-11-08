<!--INICIO DEL MENÚ -->
<style>
    table > * {
        text-transform: uppercase!important;
    }
</style>
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">

            <li class="nav-header">
                <!--Cuadro de menú con la imagen -->
                <div class="dropdown profile-element">
                    <span>
                        <img alt="image" class="img-circle" style="width:94px; height:94px;" src="{{ asset('public/img/logo1.png') }}" />
                        <!-- <img alt="image" class="img-circle" style="width:94px; height:94px;" src="{{ Auth::user()->url_img }}" /> -->
                    </span>

                    <span class="clear">
                        <span class="text-muted text-xs block">
                            <strong class="font-bold">
                                {{ Auth::user()->name.' '.Auth::user()->last_name }}
                            </strong>
                        </span>
                        <span class="text-muted text-xs block">{{ Auth::user()->profile->name}}</span>
                        <span class="badge" id="clear_server_status"></span>
                    </span>
                </div>
                <div class="logo-element">
                    JARVIS
                </div>
            </li>

            <li>
                <!--HOME-->
                <a href="{{ url('/home') }}"><i class="fa fa-home"></i>
                    <span class="nav-label">Inicio</span>
                </a>
            </li>
            @if(session('authori')['Modelo'] != 0)
            <li>
                <!--MENU DE APLICACION-->
                <a><i class="fa fa-codepen"></i>
                    <span class="nav-label">
                        Modelado
                    </span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                    @if(session('authori')['Modelo'] != 0)
                    <li>
                        <a href="{{ url('ver/inventario') }}">
                            <i class="fa fa-magic"></i> Modelado de Equipo
                        </a>
                    </li>
                    <!--<li><a href="{{ url('ver/inventario') }}"><img class="iconos svg" src="{{ asset('public/icono/ja-model-design.svg') }}"/> Modelado de Equipo</a></li>-->
                    @endif
                    @if(session('authori')['Puerto'] != 0)
                    <li>
                        <a href="{{ url('ver/puerto') }}">
                            <img class="iconos svg" src="{{ asset('public/icono/ja-board-white.svg') }}" /> Modelo de Placa
                        </a>
                    </li>
                    @endif
                    <!-- @if(session('authori')['Uplin'] != 0)
                        <li><a href="{{ url('ver/uplink') }}"><i class="fa fa-trello"></i> Uplink</a></li>
                    @endif -->
                </ul>
            </li>
            @endif

            <li>
                <!--MENU DE INVENTARIO-->
                <a href="#"><i class="fa fa-cog"></i>
                    <span class="nav-label">
                        Inventario
                    </span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                    @if(session('authori')['LanSwitch'] != 0 || session('authori')['Anillo'] != 0 || session('authori')['AGG'] != 0)
                        <li>
                            <a>
                                <i class="fa fa-ravelry"></i> Red Metro
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-third-level collapse">
                                @if(session('authori')['LanSwitch'] != 0)
                                    <li>
                                        <a href="{{ url('ver/lanswitch') }}">
                                            <img class="iconos svg" src="{{ asset('public/icono/ja-ls.svg') }}" /> Lanswitch
                                        </a>
                                    </li>
                                @endif
                                @if(session('authori')['Anillo'] != 0)
                                    <li>
                                        <a href="{{ url('ver/anillo') }}">
                                            <img class="fa iconos svg" src="{{ asset('public/icono/ja-ring.svg') }}" /> Anillo
                                        </a>
                                    </li>
                                @endif
                                @if(session('authori')['AGG'] != 0)
                                    <li>
                                        <a href="{{ url('ver/AGG') }}">
                                            <img class="iconos svg" src="{{ asset('public/icono/ja-ag.svg') }}" /> Agregadores
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <a href="{{ url('ver/importar/anillo') }}" title="Ver Anillos">
                                        <i class="fa fa-file-excel-o"></i> Planilla Anillos
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if(session('authori')['Clientes'] != 0 || session('authori')['Servivio'] != 0 || session('authori')['Direccion'] != 0)
                        <li>
                            <a>
                                <i class="fa fa-address-book"></i> Administrativo
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-third-level collapse">
                                @if(session('authori')['Clientes'] != 0)
                                    <li>
                                        <a href="{{ url('ver/cliente') }}">
                                            <i class="fa fa-drivers-license-o"></i> Clientes
                                        </a>
                                    </li>
                                @endif
                                @if(session('authori')['Servivio'] != 0)
                                    <li>
                                        <a href="{{ url('ver/servicio') }}" title="Ver Servicio">
                                            <img class="iconos svg" src="{{ asset('public/icono/ja-service.svg') }}" /> Servicios
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <a href="{{ url('ver/stock') }}">
                                        <i class="fa fa-database"></i> Stock Producto
                                    </a>
                                </li>
                                @if(session('authori')['Direccion'] != 0)
                                    <li>
                                        <a href="{{ url('ver/direccion') }}">
                                            <i class="fa fa-map-marker"></i> Direcciones
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if(session('authori')['RADIO'] != 0)
                        <li>
                            <a>
                                <i class="fa fa-weibo"></i> Radio
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-third-level collapse">
                                <li>
                                    <a href="{{ url('ver/RADIO') }}" title="Ver Admin Radio">
                                        <i class="fa fa-slideshare"></i>Admin Radio <span class="label label-info pull-right" style="width: 40px; padding: 2px;">NUEVO</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('ver/RADIO/ENLACE') }}" title="Ver Admin Radio">
                                        <i class="fa fa-slideshare"></i>Radio Enlace
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if(session('authori')['Nodo'] != 0)
                        <li>
                            <a href="{{ url('ver/nodo') }}">
                                <img class="fa iconos svg" src="{{ asset('public/icono/ja-node.svg') }}" /> Nodos
                            </a>
                        </li>
                    @endif

                   <!--  @if(session('authori')['CPE'] !=0 && session('authori')['AGG'] !=0 && session('authori')['PE'] !=0)
                        <li><a href="{{ url('ver/equipo') }}"> <i class="fa fa-slideshare"></i>Inventario</a></li>
                    @endif -->
                    @if(session('authori')['CPE'] != 0)
                        <li>
                            <a href="{{ url('ver/CPE') }}">
                                <img class="iconos svg" src="{{ asset('public/icono/ja-rt.svg') }}" /> Router
                            </a>
                        </li>
                    @endif
                    @if(session('authori')['APN'] != 0)
                        <li>
                            <a href="{{ url('ver/apn') }}" title="Ver APN">
                                <img class="iconos svg" src="{{ asset('public/icono/ja-service.svg') }}" /> APN
                            </a>
                        </li>
                    @endif
                    {{-- @if(session('authori')['LINK'] != 0)
                        <li>
                            <a href="{{ url('ver/link') }}" title="Ver Link">
                                <i class="fa fa-list-ul"></i> Link
                            </a>
                        </li>
                    @endif --}}
                </ul>
            </li>
            @if(session('authori')['PE'] != 0 || session('authori')['Pei'] != 0 || session('authori')['Dm'] != 0 || session('authori')['CADENA'] != 0 || session('authori')['SAR'] != 0)
                <li>
                    <!--MENU DE INVENTARIO-->
                    <a href="#"><i class="fa fa-cogs"></i>
                        <span class="nav-label">
                            Agregación IP
                        </span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        @if(session('authori')['PE'] != 0)
                            <li>
                                <a href="{{ url('ver/PE') }}" title="Ver Admin PE">
                                    <i class="fa fa-slideshare"></i>Admin PE
                                </a>
                            </li>
                        @endif
                        @if(session('authori')['Pei'] != 0)
                            <li>
                                <a href="{{ url('ver/PEI') }}" title="Ver Admin PEI">
                                    <i class="fa fa-slideshare"></i>Admin PEI
                                </a>
                            </li>
                        @endif
                        @if(session('authori')['Dm'] != 0)
                            <li>
                                <a href="{{ url('ver/DM') }}" title="Ver Admin DM">
                                    <i class="fa fa-slideshare"></i>Admin DM
                                </a>
                            </li>
                        @endif
                        @if(session('authori')['SAR'] != 0)
                            <li>
                                <a href="{{ url('ver/SAR') }}" title="Ver Admin SAR">
                                    <i class="fa fa-slideshare"></i>Admin SAR
                                </a>
                            </li>
                        @endif
                        @if(session('authori')['CADENA'] != 0)
                            <li>
                                <a href="{{ url('ver/cadena') }}" title="Ver Cadena de AGG">
                                    <img class="fa iconos svg" src="{{ asset('public/icono/ja-ring.svg') }}" /> Cadena AGG <span class="label label-info pull-right" style="
                                    width: 40px;
                                    padding: 2px;">NUEVO</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if(session('authori')['Reservas'] != 0 || session('authori')['Uplink_ipran'] != 0)
            {{-- {{dd(session('authori'))}} --}}
            <li>
                <!--MENU DE ADMIN CELDA-->
                <a>
                    <i class="fa fa-forumbee"></i>
                    <span class="nav-label">Admin Celda</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse">
                    @if(session('authori')['Uplink_ipran'] != 0)
                    <li>
                        <a href="{{ url('ver/link/celda') }}">
                            <i class="fa fa-unlink" title="Link (Uplink Celda)"></i>Link (Uplink)
                        </a>
                    </li>
                    @endif
                    {{-- Agregar permisos para ver reservas --}}
                    @if(session('authori')['Reservas'] != 0)
                        <li>
                            <a href="{{ url('ver/reserva') }}" title="Ver Reservas">
                                <i class="fa fa-ticket"></i> <span>Reserva </span><span class="label label-info pull-right">NUEVO</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
            @endif
            @if(session('authori')['Vlan_Rangos'] != 0 || session('authori')['Frontera'] != 0|| session('authori')['Asociacion_Agg'] != 0)
            <li>
                <!--MENU DE VLANN ADMINS-->
                <a>
                    <i class="fab fa-vuejs"></i>
                    <span class="nav-label">Admin VLAN</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse">
                    @if(session('authori')['Vlan_Rangos'] != 0)
                    <li>
                        <a href="{{ url('ver/vlan') }}">
                            <i class="fab fa-hive" title="Link (Uplink Celda)"></i>Vlan<span class="label label-info pull-right">NUEVO</span>
                        </a>
                    </li>
                    @endif
                    @if(session('authori')['Frontera'] != 0)
                    <li>
                        <a href="{{ url('ver/frontera') }}">
                            <i class="fas fa-kaaba" title="Link (Uplink Celda)"></i>Fronteras<span class="label label-info pull-right">BETA</span>
                        </a>
                    </li>
                    @endif
                    @if(session('authori')['Asociacion_Agg'] != 0)
                    <li>
                        <a href="{{ url('ver/asociacion/agg') }}">
                            <i class="fa fa-slideshare" title="Asociaci&oacute;n de Agregadores"></i>Asociaci&oacute;n AGG<span class="label label-info pull-right">NUEVO</span>
                        </a>
                    </li>
                    @endif
                        <li>
                            <a href="{{ url('ver/servicios') }}">
                                <img class="iconos svg" src="http://localhost/public/icono/ja-service.svg"> Asignación de Servicios<span class="label label-info pull-right">NUEVO</span>
                            </a>
                        </li>
                </ul>
            </li>
            @endif
            @if(session('authori')['Usuarios'] != 0 || session('authori')['Perfil'] != 0 || session('authori')['Historial'] != 0 || session('authori')['Importar'] != 0)
            <li>
                <!--MENU DE ADMINISTRADOR-->
                <a>
                    <i class="fa fa-sliders"></i>
                    <span class="nav-label">Administrador</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse">
                    @if(session('authori')['Usuarios'] != 0)
                    <li>
                        <a href="{{ url('ver/usuario') }}">
                            <i class="fa fa-user" title="Usuarios"></i> Usuarios
                        </a>
                    </li>
                    @endif
                    @if(session('authori')['Perfil'] != 0)
                    <li>
                        <a href="{{ url('ver/perfil') }}">
                            <i class="fa fa-male" title="Perfil"></i> Perfil
                        </a>
                    </li>
                    @endif
                    <!-- SUBMENU IMPORTAR EXCEL -->
                    @if(session('authori')['Importar'] != 0)
                    <li>
                        <a>
                            <i class="fa fa-file-archive-o" title="Importar"></i> Importar
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-third-level collapse">
                            <li>
                                <a href="{{ url('ver/importar/agregadores') }}">
                                    <i class="fa fa-file-excel-o" title="Importar Agregadores"></i> Agregadores
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('ver/importar/stock') }}">
                                    <i class="fa fa-file-excel-o" title="Importar Stock SAP"></i> Stock SAP
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('ver/importar/module') }}">
                                    <i class="fa fa-file-excel-o" title="Ver Modulos"></i> Modulos
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    <!-- FIN SUBMENU IMPORTAR EXCEL -->
                    @if(session('authori')['Historial'] != 0)
                    <li>
                        <a href="{{ url('historial/usuario') }}">
                            <i class="fa fa-history" title="Historial"></i> Historial
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif
            @if(session('authori')['Lista'] != 0)
            <li>
                <!--MENU DE LISTA-->
                <a href="#"><i class="fa fa-list-ol"></i>
                    <span class="nav-label">Listas</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ url('lista/equipo') }}">
                            <i class="fa fa-list-ul"></i> Equipos
                        </a></li>
                    <li>
                        <a href="{{ url('lista/marca') }}">
                            <i class="fa fa-list-ul"></i> Marcas
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('lista/banda') }}">
                            <i class="fa fa-list-ul"></i> Bandas
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('lista/radio') }}">
                            <i class="fa fa-list-ul"></i> Radios
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('lista/alimentacion') }}">
                            <i class="fa fa-list-ul"></i> Alimentaciones
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('lista/puerto') }}">
                            <i class="fa fa-list-ul"></i> Puertos
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('lista/conector') }}">
                            <i class="fa fa-list-ul"></i> Conectores
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('lista/etiqueta') }}">
                            <i class="fa fa-list-ul"></i> Etiquetas
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('lista/placa') }}">
                            <i class="fa fa-list-ul"></i> Modelos de Placas
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('lista/estado') }}">
                            <i class="fa fa-list-ul"></i> Estado IP
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('lista/pais') }}">
                            <i class="fa fa-list-ul"></i> Pais y Provincia
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('lista/baja') }}">
                            <i class="fa fa-list-ul"></i> Bajas de Servicio
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('lista/tipo/servicio') }}">
                            <i class="fa fa-list-ul"></i> Tipo de servicio
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('lista/tipo/localizacion') }}">
                            <i class="fa fa-list-ul"></i> Tipo de localización
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('lista/tipo/link') }}">
                            <i class="fa fa-list-ul"></i> Tipo de link
                        </a>
                    </li>

                </ul>
            </li>
            @endif
            @if(session('authori')['Ledzite'] != 0)
            <li>
                <!--MENU DE JARVIS SITIOS-->
                <a>
                    <i class="fas fa-book-reader"></i>
                    <span class="nav-label">Sitios Jarvis</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse">
                    @if(session('authori')['Ledzite'] != 0)
                    <li>
                        <a href="{{ url('ver/ledzite') }}">
                            <i class="fa fa-linode" title="Ledzite"></i>Ledzite<span class="label label-info pull-right">NUEVO</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif
            @if(session('authori')['ip'] != 0)
            <li>
                <!-- Admin ip-->
                <a href="#">
                    <i class="fa fa-map-marker"></i>
                    <span class="nav-label">Admin IP</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ url('ver/rama') }}">
                            <i class="fa fa-pagelines"></i> Ramas
                        </a>
                    </li>
                    @if(session('authori')['ip'] >= 10)
                        <li>
                            <a href="{{ url('ver/grupo') }}">
                                <i class="fa fa-group"></i> Grupo de usuarios
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('ver/permiso') }}">
                                <i class="fa fa-unlock"></i> Permisos Especial
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('ver/stock/IP') }}">
                                <i class="fa fa-database"></i> Stock IP
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
            @endif
        </ul>
    </div>
</nav>
<!--FIN DEL MENÚ
