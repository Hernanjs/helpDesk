function init(){
    $("#ticket_form").on("submit",function(e){
       guardaryeditar(e);
    });

  
}

$(document).ready(function() {
    $('#ticket_descrip').summernote({
        height: 150,
        lang:"es-ES",

        
    });
    $.post("../../controller/categoria.php?op=combo",function(data, status){
        $('#cat_id').html(data);
    });



});

function guardaryeditar(e){
    
        e.preventDefault();
        var formData = new FormData($("#ticket_form")[0]);
        if($('#ticket_descrip').summernote('isEmpty') || $('ticket_titulo').val()==''){
            swal("Advertencia!","Campos vacios","warning");   
    
        }else{
        $.ajax({
            url:"../../controller/ticket.php?op=insert",
            type:"POST",
            data:formData,
            contentType:false,
            processData:false,
            success:function(datos){
                console.log(datos);
                $('#ticket_titulo').val('');
                $('#ticket_descrip').summernote('reset');
                swal("Correcto!","Registro Exitoso","success");
            }
        });
    }
   
}

init();