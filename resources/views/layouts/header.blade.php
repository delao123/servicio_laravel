<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title>Otorgamiento de Sello de No Existencia</title>
<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
<meta name="viewport" content="width=device-width" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<!--     Fonts and icons     -->
<link rel="stylesheet" type="text/css" href={{url("https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons")}} />
<link rel="stylesheet" href={{url("https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css")}} />
<link href={{url("https://fonts.googleapis.com/icon?family=Material+Icons")}} rel="stylesheet">
<!-- CSS Files -->
<link href={{asset("/css/bootstrap.min.css")}} rel="stylesheet" />
<link href={{asset("/css/material-bootstrap-wizard.css")}} rel="stylesheet" />
<link href={{asset("/css/sello.css")}} rel="stylesheet" />

<!-- include the style -->
<link rel="stylesheet" href={{url("https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css")}} integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
</head>
    <body>
<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href=" {{ route('dashboard') }}"><img id="logo" src="{{ asset("/images/inbal_2019.png") }}" width="15%"></a>           
        </div>
      
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <h3 style="padding-left: 4rem;">Bienvenido {{ auth()->user()->name }}</h3>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <div>
                    <form method="POST" action="{{route('logout')}}">
                    {{ csrf_field() }}
                        <button class="btn btn-sm btn-danger" style="margin-top: 21px;">Cerrar Sesión</button>
                    </form>
                </div>
            </ul>
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </nav>
