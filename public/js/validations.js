$(document).ready(function () {
  $('.material').hide();
});

$(document).on('click','.papeleria',function(){
    $('#bien').text('Papeleria');
    $('#materialHe').hide();
    $('#materialPa').attr('style','visibility:visible');
    $('select').selectize({
          sortField: 'text'
      });
         
});

$(document).on('click','.herramienta',function(){
    $('#bien').text('Herramienta');
    $('#materialPa').hide();
    $('#materialHe').attr('style','visibility:visible');
    $('select').selectize({
      sortField: 'text'
  });        
});

var max_chars = 250;
$('#max').html(max_chars);

$('#comentarios').keyup(function() {
    var chars = $(this).val().length;
    var diff = max_chars - chars;
    $('#contador').html('<p>Caracteres disponibles: <strong>'+diff+'</strong></p>');

    if(diff <= 0)
      $('#contador').removeClass('text-success').addClass('text-danger');

    else
      $('#contador').removeClass('text-danger').addClass('text-success');
});

var cuentaTabla = document.querySelectorAll('#consultaSe tbody tr').length;
if (cuentaTabla == 0){
  $('#pop').removeClass('success');
  $('#pop').popover('destroy');
}else{
  var last = $('#consultaSe tr:last').addClass("success");
  $('#consultaSe tr:last').attr('id', 'pop');
  $('#pop').popover({
    placement : 'bottom',
    html : true,
    trigger : 'show', 
    content: "Se ha agregado un nuevo registro"
  });
  $('#pop').popover('show');
  setTimeout(function() {
    $('#pop').popover('hide');
  }, 1000);
}

$('#selloModal').on('hidden.bs.modal', function (e) {
  location.reload();
})



//Refresh index page cuando se pulsa el boton back del navegador
if(!!window.performance && window.performance.navigation.type === 2)
{
    window.location.reload();
}



