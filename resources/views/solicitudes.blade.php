@include('layouts/header')
<body>
    <div>
    <a href="https://inba.gob.mx/">
    <div class="logo-container">
        <img src="images/inbal_2019.png" width="15%">            
    </div>
    </a>
    <div class="alert alert-success" id="nuevo_registro" style="width: 545px;">
    <p>Se ha creado una solicitud con el registro:
    <?php
    $centro_trabajo = $_GET['centro_trabajo'];
    $date = date("y");
    $connection = mysqli_connect('localhost', 'root', '', 'sellonogarantia');
    $query = "SELECT id_solicitud,fecha FROM `solicitud`";
    $result = mysqli_query($connection,$query);
    while($row = mysqli_fetch_assoc($result)){
        $solicitud = $row['id_solicitud'];
        $fecha = $row['fecha'];
    }
    $solicitud = $centro_trabajo ."-" . $solicitud . "-" . $date;
    echo "<strong>$solicitud</strong> el dia" . " " . "<strong>$fecha</strong>"; 
    ?>
    </p>    
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
    <?php
    $centro_trabajo = $_GET['centro_trabajo'];
    $connection = mysqli_connect('localhost', 'root', '', 'sellonogarantia');
    $mostrar_datos_query = "SELECT * FROM `solicitud` WHERE centroTrabajo='$centro_trabajo'";
    $result = mysqli_query($connection, $mostrar_datos_query);
    $date = date("y");
    while($row = mysqli_fetch_assoc($result)){
        $solicitud = $centro_trabajo ."-" . $row['id_solicitud'] . "-" . $date;
        $num_solicitud = $row['id_solicitud'];
        $fecha = $row['fecha'];
        $status = $row['status'];
        echo "<tr><td class='solicitud' id='$num_solicitud'>$solicitud</td><td id='$centro_trabajo'>$fecha</td>" . 
        "<td><select class='form-control'><option value='pendiente'>Pendiente</option><option value='cancelado'>Cancelado</option><option value='recibido'>Recibido</option></select></td></tr>";
        echo "<script src='assets/js/jquery-2.2.4.min.js' type='text/javascript'></script>";
        echo "<script>var arr = $('#solicitud tr');".
        "$.each(arr, function(i, item) {".
            "var currIndex = $('#solicitud tr').eq(i);".
            "var matchText = currIndex.children('td').first().text();".
            "$(this).nextAll().each(function(i, inItem) {".
                "if(matchText===$(this).children('td').first().text()) {".
                    "$(this).remove();".
                "}".
            "});".
         "}); </script>";
    }
    ?>
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
@include('layouts/footer')