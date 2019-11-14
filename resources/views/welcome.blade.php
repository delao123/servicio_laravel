@include('layouts/header')
    <body>
    <div>
    <!--   Creative Tim Branding   -->
    <a href="https://inba.gob.mx/">
    <div class="logo-container">
        <img src={{asset('/images/inbal_2019.png')}} width="15%">            
    </div>
    </a>
    <div id="consultaSello"> 
    <table id="consultaSe" class="table table-bordered">
            <thead>
                <tr>
                    <th>Material</th>
                    <th>Codigo Almacen</th>
                    <th>CUCOP</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Comentarios</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sellos as $sello)
                <tr>
                    <td>{{$sello->material}}</td>
                    <td>{{$sello->codigoAlmacen}}</td>
                    <td>{{$sello->cucop}}</td>
                    <td>{{$sello->cantidad}}</td>
                    <td>{{$sello->costoTotal}}</td>
                    <td>{{$sello->comentarios}}</td>
                    <td>{{$sello->Fecha}}</td>
                    <td><button type='button'  class='btn btn-warning btn-sm btn-round editar' data-toggle='modal' data-target='#selloModal' id="{{$sello->codigoAlmacen}}">
                        Editar</button></td>
                    <td><button type='button' id='{{$sello->codigoAlmacen}}' class='btn btn-danger btn-sm btn-round eliminar'>
                        Eliminar</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>                                      
    </div>
    <button type="button" id="modalButton" class="btn btn-info" data-toggle="modal" data-target="#selloModal">Agregar
    </button>
    <!-- ModalSello1 -->
    <div class="modal fade" id="selloModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <!--      Wizard container        -->
            <div class="wizard-container">
                <div class="card wizard-card" data-color="green" id="wizardProfile">
                    <form action="index.php" method="POST" id="selloFinal">
                        <div class="wizard-header">
                            <h3 class="wizard-title">
                               Sello de no existencia
                            </h3>
                            <h5>Realiza la busqueda de algún bien: <b>Papeleria</b> o <b>Herramienta</b></h5>
                        </div>
                        <div class="wizard-navigation">
                        <ul>
                            <li><a href="#catalogo" data-toggle="tab">Catálogo</a></li>
                            <li><a href="#caracteristicas" data-toggle="tab">Características</a></li>
                            <li><a href="#observaciones" data-toggle="tab">Observaciones</a></li>
                        </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane" id="catalogo">
                                <div class="row">
                                    <div class="col-sm-10 col-sm-offset-1">
                                        <div class="col-sm-6">
                                            <div class="choice papeleria" data-toggle="wizard-radio">
                                                <input type="radio" id="radioP" name="jobb" value="Design">
                                                <div class="icon">
                                                    <i class="fa fa-pencil"></i>
                                                </div>
                                                <h6>Papeleria</h6>
                                            </div>
                                        </div>                                        
                                        <div class="col-sm-6">
                                            <div class="choice herramienta" data-toggle="wizard-radio">
                                                <input type="radio" id="radioH" name="jobb" value="Develop">
                                                <div class="icon">
                                                    <i class="fa fa-laptop"></i>
                                                </div>
                                                <h6>Herramienta</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                <div class="col-sm-offset-2 col-sm-8 col-sm-offset-2">
                                        <div class="form-group">
                                            <label class="control-label" id="bien">Selecciona un bien:</label>
                                            <div id="materialHe">
                                            <select name="material" class="form-control material" id="league" data-style="btn-success" placeholder="Selecciona un material" required>
                                            <option value="0" selected="selected" disabled>Buscar un material</option>
                                            @foreach ($herramientas as $herramienta)
                                                <option value="{{$herramienta}}">{{$herramienta}}</option>
                                            @endforeach
                                            </select>
                                            </div>
                                            <div id="materialPa">
                                            <select name="material" class="form-control material" data-style="btn-success" placeholder="Selecciona un material" required>
                                            <option value="0" selected="selected" disabled>Buscar un material</option>
                                            @foreach ($papelerias as $papeleria)
                                                <option value="{{$papeleria}}">{{$papeleria}}</option>
                                            @endforeach
                                            </select>    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="caracteristicas">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h4 id='material_seleccionado' class="info-text"> Material seleccionado: </h4>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label" id="codigoLabel">Código de Almacen</label>
                                            <input type="hidden" id="transferInput">
                                            <input type='text' class='form-control is-focused' id="codigoAlmacen" name='codigoAlmacen' readonly required>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group label-floating">
                                            <label class="control-label" id="cucopLabel">CUCOP</label>
                                            <input type="text" name="cucop" id="cucop" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-7">
                                        <div class="form-group label-floating">
                                            <label class="control-label" id="partidaLabel">Partida Presupuestal</label>
                                            <input type="text" name="partidaPresupuestal" id="partidaPresupuestal" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group label-floating">
                                            <label class="control-label" id="unidadLabel">Unidad de Medida</label>
                                            <input type="hidden" id="transferInput">
                                            <input type="text" name="unidadMedida" id="unidadMedida" class="form-control" readonly required>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group label-floating">
                                            <label class="control-label" id="cantidadLabel">Cantidad</label>
                                            <input type="number" name="cantidad" id="cantidad" class="form-control" min="1" max="100" required>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-offset-2 col-sm-8 col-sm-offset-2">
                                        <table class="table" id="precios">
                                            <tr>
                                                <th>Costo Unitario</th>
                                                <th>Subtotal</th>
                                                <th>IVA</th>
                                                <th>Costo Total</th>
                                            </tr>
                                            <tr>
                                                <td class="text-default"><span id="costo">$0.00</span></td>
                                                <td><label id="subtotal" class="text-danger">$0.00</td>
                                                <td><label id="iva" class="text-danger">$0.00</label></td>
                                                <td><label id="total" class="text-danger">$0.00</label></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div> 
                            <div class="tab-pane" id="observaciones">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h4 id='material_seleccionado_obs' class="info-text"> Material seleccionado: </h4>
                                    </div>
                                    <div class="col-sm-offset-2 col-sm-8 col-sm-offset-2">
                                        <div class="md-form">
                                            <textarea name="comentario" id="comentarios" class="md-textarea form-control" rows="3" maxlength="250"></textarea>
                                            <label for="comentarios">Observaciones</label>
                                        </div>
                                        <label id="contador" class="text-success"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wizard-footer">
                            <div class="pull-right">
                                <input type='button' class='btn btn-next btn-fill btn-success btn-wd' name='next' value='Siguiente' />
                                <button type ="button" style="visibility: hidden" type="button" class="btn btn-finish btn-fill btn-success btn-wd" id="confirmar">Confirmar</button>
                                <button type="button" class='btn btn-finish  btn-success' id="terminar">Terminar</button> 
                            </div>
                            <div class="pull-left">
                                <input type='button' class='btn btn-previous btn-fill btn-default btn-wd' name='previous' id="anterior" value='Anterior' />
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>
            </div> <!-- wizard container -->
    </div>
    </div>
    <div class="footer">
            <button class="btn btn-info enviar" id="0001" data-toggle="modal" data-target="">Enviar</button>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="selloModalEnviar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Datos enviados</h4>
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
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table> 
              </div>
              <div class="modal-footer">
                <button class='btn btn-success' id="aceptarModal">Aceptar</button>
              </div>
            </div><!-- /.modal-content -->
          </div>
        </div> <!--end modal -->
@include('layouts/footer')