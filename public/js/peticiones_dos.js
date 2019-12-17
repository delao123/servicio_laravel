var baseUrl = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port: '');

$('.solicitud').click(function(){
    var solicitud = $(this).attr("id");
    var centro_trabajo = $('tr').find("td:eq(1)").attr("id"); 
    $.ajax({
        method:"POST",
        data:{centro_trabajo: centro_trabajo, solicitud: solicitud },
        dataType:'json',
        success:function(response) {
            jQuery.each(response, function(i,data) {
                $("#envio").append("<td>" + data + "</td>");
            });
            $("tr").each(function() {
                $(this).find("td:eq(5)").append("$");
                });
            $('#envio td:last').after('<tr><td style="border: 1px solid Transparent!important;"></td><td style="border: 1px solid Transparent!important;"></td><td style="border: 1px solid Transparent!important;"></td><td style="border-bottom: 1px solid Transparent!important;"></td><td style="font-weight: 550;">Total: </td><td>' + '$' + response.suma + '</td></tr>');
            $("td").each(function(){
                $("#envio").html($("#envio").html().replace(",", "<br>"));
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
                $('#envio').find("tbody").remove();
              }); 
        },
        error:function(error){
            console.log(error);
        }
    })
});

setTimeout(function() {
    $("#nuevo_registro").fadeOut().empty();
  }, 3000);
