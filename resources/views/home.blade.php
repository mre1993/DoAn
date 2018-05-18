@extends('layouts.app')
@section('content')
<div id="sidebar" class="col-md-2">
    <ul>
        <li class="active"><a href="/home"><i class="fa fa-home"></i> <span>Dashboard</span></a> </li>
        <li> <a href="/user"><i class="fa fa-user-circle"></i> <span>Tài Khoản</span></a> </li>
        <li> <a href="widgets.html"><i class="fa fa-inbox"></i> <span>Widgets</span></a> </li>
        <li><a href="tables.html"><i class="fa fa-th"></i> <span>Tables</span></a></li>
        <li><a href="grid.html"><i class="fa fa-fullscreen"></i> <span>Full width</span></a></li>
        <li class="submenu"> <a href="#"><i class="fa fa-th-list"></i> <span>Forms</span> <span class="label label-important">3</span></a>
            <ul>
                <li><a href="form-common.html">Basic Form</a></li>
                <li><a href="form-validation.html">Form with Validation</a></li>
                <li><a href="form-wizard.html">Form with Wizard</a></li>
            </ul>
        </li>
        <li><a href="buttons.html"><i class="fa fa-tint"></i> <span>Buttons &amp; icons</span></a></li>
        <li><a href="interface.html"><i class="fa fa-pencil"></i> <span>Eelements</span></a></li>
        <li class="submenu"> <a href="#"><i class="fa fa-file"></i> <span>Addons</span> <span class="label label-important">5</span></a>
            <ul>
                <li><a href="index2.html">Dashboard2</a></li>
                <li><a href="gallery.html">Gallery</a></li>
                <li><a href="calendar.html">Calendar</a></li>
                <li><a href="invoice.html">Invoice</a></li>
                <li><a href="chat.html">Chat option</a></li>
            </ul>
        </li>
        <li class="submenu"> <a href="#"><i class="fa fa-info-sign"></i> <span>Error</span> <span class="label label-important">4</span></a>
            <ul>
                <li><a href="error403.html">Error 403</a></li>
                <li><a href="error404.html">Error 404</a></li>
                <li><a href="error405.html">Error 405</a></li>
                <li><a href="error500.html">Error 500</a></li>
            </ul>
        </li>
    </ul>
</div>
@yield('right-content')
@stop
