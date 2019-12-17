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
<!-- CSS Files -->

<link href={{asset("/css/bootstrap.min.css")}} rel="stylesheet" />
<link href={{asset("/css/material-bootstrap-wizard.css")}} rel="stylesheet" />
<link href={{asset("/css/sello.css")}} rel="stylesheet" />
<!-- include the style -->

<link rel="stylesheet" href={{url("https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css")}} integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

</head>
    <body>
    <div>
    <!--   Creative Tim Branding   -->
    <a href={{url("https://inba.gob.mx/")}}>
    <div class="logo-container">
        <img src={{url("images/inbal_2019.png")}} width="15%">            
    </div>
    </a>
    <div class="alert alert-success" id="nuevo_registro" style="width: 545px;">
        <p> Se ha creado una solicitud con el registro: 
        <strong>{{$solicitud}}</strong> el dia <strong>{{$fecha}}</strong ></p>
    </div>
    <table class="table table-bordered table-hover table-responsive" id="solicitud">
        <thead>
            <tr>
                <th>Solicitud</th>
                <th>Fecha</th>
                <th>Status</th>     
            </tr>
        </thead>
        <tbody>
            <script src={{url('/js/jquery-2.2.4.min.js')}} type='text/javascript'></script>
            @foreach($solicitudes as $solicitud)
            <tr>
            <td class='solicitud' id='{{$solicitud->id_solicitud}}'>{{$centro_trabajo}}-{{$solicitud->id_solicitud}}-{{$date}}</td><td id={{$centro_trabajo}}>{{$solicitud->created_at}}</td> 
                <td><select class='form-control'><option value='pendiente'>Pendiente</option><option value='cancelado'>Cancelado</option><option value='recibido'>Recibido</option></select></td>
            </tr>
            <script>var arr = $('#solicitud tr');
            $.each(arr, function(i, item) {
                var currIndex = $('#solicitud tr').eq(i);
                var matchText = currIndex.children('td').first().text();
                $(this).nextAll().each(function(i, inItem) {
                    if(matchText===$(this).children('td').first().text()) {
                        $(this).remove();
                    }
                    });
                }); 
            </script>
            @endforeach
        </tbody>
        </table>
        <!-- Modal -->
        <div class="modal fade" id="selloModalEnviar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Consulta</h4>
          </div>
          <div class="modal-body">
          <table id="envio" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Centro de trabajo</th>
                        <th>Numero de Solicitud</th>
                        <th>Materiales</th>
                        <th>Codigo</th>
                        <th>Cantidad</th>
                        <th>Costo</th>
                    </tr>
                </thead>
            </table> 
          </div>
          <div class="modal-footer">
            <button class='btn btn-success' id="aceptarModal" data-dismiss="modal">Aceptar</button>
          </div>
        </div><!-- /.modal-content -->
      </div>
    </div> <!--end modal -->
</body>
<!--   Core JS Files   -->
<script src={{asset("/js/jquery-2.2.4.min.js")}} type="text/javascript"></script>
<script src={{asset("/js/bootstrap.min.js")}} type="text/javascript"></script>
<script src={{asset("/js/jquery.bootstrap.js")}} type="text/javascript"></script>
<script src={{url("https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js")}} integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<script src={{url("https://unpkg.com/sweetalert/dist/sweetalert.min.js")}}></script>


<!--  Plugin for the Wizard -->
<script src={{asset("/js/material-bootstrap-wizard.js")}}></script>

    <!--  More information about jquery.validate here: http://jqueryvalidation.org/ -->
<script src={{asset("/js/jquery.validate.min.js")}}></script>
<script src={{asset("/js/validations.js")}} type="text/javascript"></script>
<script src={{asset("/js/peticiones.js")}} type="text/javascript"></script>
<script src={{asset("/js/peticiones_dos.js")}} type="text/javascript"></script>

</html>
