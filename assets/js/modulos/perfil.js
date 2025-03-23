
$(document).ready(function() {
     //Activar Edición
    $("#switch_editar").change(function (e) {
        
        $("#new_pass_1").prop("disabled", !this.checked);
        $("#new_pass_2").prop("disabled", !this.checked);
        $("#btn_cancelar").prop("disabled", !this.checked);
        $("#btn_guardar").prop("disabled", !this.checked);
        
    });
    
    //Validacion de campos
    //Validacion de Usuario

    //activar si es que se quiere cambiar nombre de usuarios
    // $("#usuario").keyup(function (){
    //     if($("#usuario").val() === ''){
    //         $("#usuario").addClass("is-invalid");
    //         $("#btn_guardar").prop("disabled", true);
    //         $("#valid_user").show();
    //     }else{
    //         $("#usuario").removeClass("is-invalid");
    //         $("#btn_guardar").prop("disabled", false);
    //         $("#valid_user").hide();
    //         $("#bandera").val(1);
    //     }
    // });
    
    //Validacion de Contraseñas
    $("#new_pass_1").keyup(function (){
        if($("#new_pass_1").val() === ''){
            $("#new_pass_2").removeClass("is-invalid");
            $("#new_pass_2").prop("disabled", true);
            $("#valid_contraseña").hide();
            $("#btn_guardar").prop("disabled", false);
            $("#bandera").val(1);
        }
        else{
            $("#new_pass_2").prop("disabled", false);
            if($("#new_pass_1").val() === $("#new_pass_2").val()){
                $("#new_pass_2").removeClass("is-invalid");
                $("#valid_contraseña").hide();
                $("#btn_guardar").prop("disabled", false);
                $("#bandera").val(2);
            }
            else{
                $("#new_pass_2").addClass("is-invalid");
                $("#valid_contraseña").show();
                $("#btn_guardar").prop("disabled", true);
            }
            
        }
    });
    
    $("#new_pass_2").keyup(function (){
        if($("#new_pass_1").val() === $("#new_pass_2").val()){
            $("#new_pass_2").removeClass("is-invalid");
            $("#valid_contraseña").hide();
            $("#btn_guardar").prop("disabled", false);
            $("#bandera").val(2);
        }
        else{
            $("#new_pass_2").addClass("is-invalid");
            $("#valid_contraseña").show();
            $("#btn_guardar").prop("disabled", true);
        }
    });
    // ANTIGUO MODELO
    // $('#formPerfil_actualizar').submit(function(e) {
    //     e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
        
    //     var data = $('#formPerfil_actualizar').serialize();
    //     // Imprime un mensaje en la consola cuando se envía el formulario
    //     // alert("Se ha enviado el formulario.");            
    //     $.ajax({
    //         url: "../controllers/crud_perfil.php",
    //         type: "POST",
    //         datatype:"json",    
    //         data: data,
    //         success: function(data) {
    //             alertify.success('Perfil Actualizado');
    //         },
    //         error: function(data){
    //             alertify.success('Error al actualizar perfil.');
    //         }
    //     });
        
    //     location.reload();
    // });
    // NUEVO MODELO
        //submit productos
       
    
         
        $('#btn_cancelar').click(function(){
            $('#formPerfil_actualizar').trigger("reset");
            $("#usuario").prop("disabled", true);
            $("#new_pass_1").prop("disabled", true);
            $("#new_pass_2").prop("disabled", true);
            $("#btn_cancelar").prop("disabled", true);
            $("#btn_guardar").prop("disabled", true);
        });
    
});

const frm = document.querySelector("#formPerfil_actualizar");
const btnAccion = document.querySelector("#btn_guardar");

document.addEventListener("DOMContentLoaded", function() {

    frm.addEventListener("submit", function(e) {
        e.preventDefault();
        let data = new FormData(this);
        const url = base_url + "Admin/actualizar";
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.send(data);
        http.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                if (res.icono == "success") {
                    frm.reset();
                    // tblProductos.ajax.reload();
                    // document.querySelector("#imagen").value = "";
                }
                alertas(res.msg, res.icono);
               
            }
        };
    });


});

function alertas(msg, icono) {
    Swal.fire("Aviso", msg.toUpperCase(), icono);
}
