var baseUrl = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port: '');
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('.material').change(function(){
    $('#cantidad').val("0");
    $('#subtotal').text("$0.00");
    $('#iva').text("$0.00");
    $('#total').text("$0.00");
    
    var material = $(this).val();      
    $('#material_seleccionado').text(material);     
    $('#material_seleccionado_obs').text(material);
    $.ajax({
          type:'POST',
          data: {material: material},
          dataType: 'json',
          success:function(response){
              console.log(response);
              $("#codigoAlmacen").val(response.clave);
              $("#unidadMedida").val(response.unidadMedida);
              $('#costo').text("$" + response.costo);
              
              $(document).on('change keyup','#cantidad',function(){
              var costo =  response.costo;
              var subtotal = costo*$('#cantidad').val();
              var iva = (costo*$('#cantidad').val()*0.16);
              var total = subtotal + iva;
              $('#subtotal').text('$'+subtotal.toFixed(2));        
              $('#iva').text('$'+iva.toFixed(2));        
              $('#total').text('$'+total.toFixed(2));        
          });
          },
          error: function(xml, error){
          }
      });  
    });

$('#terminar').click(function(){

        var material = $('#material_seleccionado').text();
        var tipo = $('#bien').text(); 
        var codigoAlmacen = $('#codigoAlmacen').val();
        var cucop = $('#cucop').val();
        var partidaPresupuestal = $('#partidaPresupuestal').val();
        var unidadMedida = $('#unidadMedida').val();
        var cantidad = $('#cantidad').val();
        var costo = $('#costo').text();
        var subtotal = $('#subtotal').text();
        var iva = $('#iva').text();
        var total = $('#total').text();
        var comentarios = $('#comentarios').val();
        var centroTrabajo = $('.enviar').attr("id");
        var faseUrl = '/SelloNoExistenciaLaravel/public/faseFinal';
        var regisUrl = '/SelloNoExistenciaLaravel/public/check';
        $.ajax({
			url: baseUrl + regisUrl,
			method:"POST",
			data:{material:material },
			success:function(data) {
                if(data == "Ocupado"){
                    swal("Material existente", "Este material ya ha sido registrado, favor de editarlo", "error").then(function(){
                        location.reload();
                    });
                }else{
                    swal("Registro guardado", "Su peticion ha sido guardada", "success").then(function(){
                        location.reload();
                    });
                    $.ajax({
                        type:'POST',
                        url: baseUrl + faseUrl,
                        data: {material: material, tipo: tipo, codigoAlmacen: codigoAlmacen,
                            cucop: cucop, partidaPresupuestal: partidaPresupuestal,
                            unidadMedida: unidadMedida, cantidad: cantidad, costo: costo,
                            subtotal: subtotal, iva: iva, total: total, comentarios: comentarios, centroTrabajo:centroTrabajo
                        },
                        dataType: 'json',
                        success:function(response){      
                            },
                        error: function(xml, error){
                            swal("Error", error, "error");
                        }
                    }); 
                }
			}
        });            
    });
       
$('.eliminar').click(function(e){
    var codigoAlmacen = $(this).attr("id");
    swal({
        title: "Eliminar registro",
        text: "Seguro que desea eliminar este regristro del material?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          swal({
            title:"Eliminado",
            text:"El registro del material ha sido eliminado",
            icon: "success",
          }).then(function(){
              location.reload();
          });
          $.ajax({
            method:"POST",
            data:{codigoAlmacen:codigoAlmacen },
            success:function(data) {  
            }
        });
        } else {
          swal({
            title:"Cancelado",
            text:"Volviendo a la pagina principal",
            icon: "info",
          });
        }
      });
});
$('.editar').click(function(){
    //Remueve el dropdownlist
    $('.material').remove()
    //Recargar la pàgina al teclear escape(para corregir el bug del modal)
    $(document).on('keyup', function(e) {
        if (e.keyCode === 27) { 
           location.reload();
        }
   });
   //Captura el id del boton para enviar una consulta a la base de datos
    var data = $(this).attr("id");
    $("#terminar").remove();
    $('#confirmar').attr('style','visibility:visible')
    console.log(data);
    $.ajax({
        type:'POST',         
          data: {data: data},
          dataType: 'json',
          success:function(response){
              console.log(response);
              if(response.tipo == "Papeleria"){
                $('#radioP').click();
                $('.herramienta').remove();
                $('#materialPa').text(response.material)
              }else{
                  $('#radioH').click();
                  $('.papeleria').remove();
                  $('#materialHe').text(response.material)
              }
              $('#material_seleccionado').text(response.material);
              $('#material_seleccionado_obs').text(response.material);
              $("#codigoAlmacen").val(response.codigoAlmacen);
              $('#cucop').val(response.cucop);
              $('#partidaPresupuestal').val(response.partidaPre);  
              $("#unidadMedida").val(response.unidadMedida);
              $('#cantidad').val(response.cantidad);
              $('#costo').text("$" + response.costo); 
              $('#subtotal').text(response.subtotal);
              $('#iva').text(response.iva);
              $('#total').text(response.total);
              $('#comentarios').text(response.comentarios);

              $(document).on('change keyup','#cantidad',function(){
                var costo = response.costo;
                var subtotal = costo*$('#cantidad').val();
                var iva = (costo*$('#cantidad').val()*0.16);
                var total = subtotal + iva;
                $('#subtotal').text('$'+subtotal.toFixed(2));        
                $('#iva').text('$'+iva.toFixed(2));        
                $('#total').text('$'+total.toFixed(2));        
            });
          },
          error: function(xml, error){
              console.log(error);
              swal("Error", error, "error");
          }
        });
    $('#confirmar').click(function(e){
        swal({
            title:"Actualizado",
            text:"Registro actualizado",
            icon: "success",
          }).then(function(){
              location.reload();
          });
        var material = $('#material_seleccionado').text();
        var codigoAlmacen = $('#codigoAlmacen').val();
        var cucop = $('#cucop').val();
        var partidaPresupuestal = $('#partidaPresupuestal').val();
        var unidadMedida = $('#unidadMedida').val();
        var cantidad = $('#cantidad').val();
        var costo = $('#costo').text();
        var subtotal = $('#subtotal').text();
        var iva = $('#iva').text();
        var total = $('#total').text();
        var comentarios = $('#comentarios').val();
        var editUrl = '/SelloNoExistenciaLaravel/public/editFinal'
            $.ajax({
                type:'POST',
                url: baseUrl + editUrl,
                data: {material: material, codigoAlmacen: codigoAlmacen,
                    cucop: cucop, partidaPresupuestal: partidaPresupuestal,
                    unidadMedida: unidadMedida, cantidad: cantidad, costo: costo,
                    subtotal: subtotal, iva: iva, total: total, comentarios: comentarios
                },
                dataType: 'json',
                success:function(response){       
                    },
                error: function(xml, error){
                    console.log(error);
                }
            });
    });

  });

//Envio de datos a databases en tablas contador y soicitud
$(".enviar").click(function(){
    var cuentaTabla = document.querySelectorAll('#consultaSe tbody tr').length;
    if(cuentaTabla == 0){
        swal("Error", "No existen registros en la tabla", "error");
    } else{
        var centroTrabajo = $(this).attr("id");
        swal({
            title: "Envio de datos",
            text: "Al enviar los registros éstos dejaran de visualizarse en la tabla," + 
            "por lo que no se podran hacer más cambios. Desea continuar?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((envio) => {
              if (envio){
                $.ajax({
                    method:"POST",
                    data:{centroTrabajo:centroTrabajo },
                    dataType:'json',
                    success:function(response) {
                        jQuery.each(response, function(i,data) {
                            $("#envio").append("<td>" + data + "</td>");
                        });
                        $('#envio td:last').after('<tr><td style="border: 1px solid Transparent!important;"></td><td style="border: 1px solid Transparent!important;"></td><td style="border: 1px solid Transparent!important;"></td><td style="border-bottom: 1px solid Transparent!important;"></td><td style="font-weight: 550;">Total: </td><td>' + '$' + response.suma + '</td></tr>');
                        $("td").each(function(){
                            $("#envio").html($("#envio").html().replace(",", ""));
                            });
                        $("tr").each(function() {
                            $(this).find("td:eq(6)").remove();
                            });
                        $("tr").each(function() {
                            $(this).find("td:eq(5)").attr('style','text-align:end');
                            });
                        $('#envio').find('td:eq(2)').attr('style','font-size:x-small');    
                        $('#selloModalEnviar').modal('show');
                        $('#selloModalEnviar').on('hidden.bs.modal', function (e) {
                            swal({
                                title:"Enviado",
                                text:"Los datos han sido enviados",
                                icon: "success",
                                }).then(function(){
                                    location.reload();
                                });
                            }); 
                        $('#aceptarModal').click(function(e){
                            //Enviar a una segunda pagina donde se muestra una tabla con el numero de solicitud, fecha y status,     
                            document.location.href = 'solicitudes.php' + '?centro_trabajo='+ centroTrabajo;
                        });
                    },
                error:function(error){
                    console.log(error);
                }
            });
            } else {
              swal({
                title:"Cancelado",
                text:"Volviendo a la pagina principal",
                icon: "info",
              });
            }
        });
    }
});


