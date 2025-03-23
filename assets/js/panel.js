/* Set the width of the sidebar to 250px and the left margin of the page content to 250px */
//is_sidebar_open is a flag for sidebar key usage
var is_sidebar_open = false;
var current_id_on_search_details = false;
const month_list = ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"];
const lic_list = ["-", "NMS", "NME", "AP", "DHE", "CS", "CAP", "ESS", "AV", "LE", "LM", "LP", "LD", "D", "INASISTENCIA"];
//Según documentación [0] es Domingo
const day_list = ["dom","lun","mar","mié","jue","vie","sab"];
const options = { weekday: 'short', year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' };
var current_date_on_search= [new Date().getFullYear().toString(), month_list[new Date().getMonth()]];
//Para saber cuáles son los elementos que están siendo resaltados
var z_index_elements = [];
var z_index_childs = [];
var show_marcas_reloj = false;
var notif_handler = 0;

//function initLiveTime (php_timestamp, span_element) {
  //span_element.innerHTML = printFullDateAndTime(new Date(php_timestamp));
  //php_timestamp += 1000;
  //setTimeout(function () {initLiveTime(php_timestamp, span_element);}, 1000);
//}

function addLeavingAuth (motivo, otro, descrip, h_out, h_return, will_return) {
  let data = new FormData();
  //Validación de los datos hecha con el botón
  //Si todos están ok}
  motivo_selected = false;
  for (i = 0; i < motivo.length; i++){
    (motivo[i].checked)? motivo_selected = motivo[i].value: {};
  }
  data.append('function','insert_auth');
  data.append('date', document.getElementById('auth_list_date').value);
  data.append('id_searched', current_id_on_search_details);
  data.append('motivo', motivo_selected);
  data.append('otro_motivo', (motivo_selected == "otros")? otro.value: '');
  data.append('descrip', descrip.value.trim().replace(/\s+/g,' '));
  data.append('h_out', h_out.value);
  data.append('h_return', h_return.value);
  //Lo paso negado, porque, si está habilitado, significa que no va a volver, osea, will_return=false
  data.append('will_return', !will_return.checked);
  fetch('tab_auth_salida_functions.php', {
    method: "POST",
    body: data
  }).then (function (response){
    if(response.ok){
      return response.text();
    } else {
      throw "Error en la llamada";
    }
  })
  .then (function(data){
    console.log(data);
    switch(data){
      case '1':{
        //Mostrar Notificación de éxito
        if(document.getElementById("add_upd_notif").style.animationName == "none" || document.getElementById("add_upd_notif").style.animationName == ""){
          document.getElementById("add_upd_notif").innerHTML = `<svg alignment-baseline="baseline" width="30" height="30" fill="#ffffff" class="bi bi-person-plus-fill" viewBox="8 0 16 16">
          <path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z"/>
          <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
          <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
          </svg>La autorización se<br>guardó exitosamente.`;
          document.getElementById("add_upd_notif").classList.remove("red");
          document.getElementById("add_upd_notif").classList.add("green");
          document.getElementById("add_upd_notif").style.animationName = "notif-up";
          setTimeout(function(){document.getElementById("add_upd_notif").style.animationName = "none";}, 5000);
        }
        break;
      }
      case '0':{
        //Mostrar Notificación falla en inserción
        if(document.getElementById("add_upd_notif").style.animationName == "none" || document.getElementById("add_upd_notif").style.animationName == ""){
          document.getElementById("add_upd_notif").innerHTML = `<svg alignment-baseline="baseline" width="30" height="30" fill="#ffffff" class="bi bi-person-plus-fill" viewBox="8 0 16 16">
          <path fill-rule="evenodd" d="M6.146 6.146a.5.5 0 0 1 .708 0L8 7.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 8l1.147 1.146a.5.5 0 0 1-.708.708L8 8.707 6.854 9.854a.5.5 0 0 1-.708-.708L7.293 8 6.146 6.854a.5.5 0 0 1 0-.708z"/>
          <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
          <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
          </svg>Esta autorización ya<br>existe.`;
          document.getElementById("add_upd_notif").classList.remove("green");
          document.getElementById("add_upd_notif").classList.add("red");
          document.getElementById("add_upd_notif").style.animationName = "notif-up";
          setTimeout(function(){document.getElementById("add_upd_notif").style.animationName = "none";}, 5000);
        }
        break;
      }
      case '-1':{
        //Mostrar Notificación falla en inserción
        if(document.getElementById("add_upd_notif").style.animationName == "none" || document.getElementById("add_upd_notif").style.animationName == ""){
          document.getElementById("add_upd_notif").innerHTML = `<svg alignment-baseline="baseline" width="30" height="30" fill="#ffffff" class="bi bi-person-plus-fill" viewBox="8 0 16 16">
          <path fill-rule="evenodd" d="M6.146 6.146a.5.5 0 0 1 .708 0L8 7.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 8l1.147 1.146a.5.5 0 0 1-.708.708L8 8.707 6.854 9.854a.5.5 0 0 1-.708-.708L7.293 8 6.146 6.854a.5.5 0 0 1 0-.708z"/>
          <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
          <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
          </svg>Revisa si los campos están<br>llenados correctamente.`;
          document.getElementById("add_upd_notif").classList.remove("green");
          document.getElementById("add_upd_notif").classList.add("red");
          document.getElementById("add_upd_notif").style.animationName = "notif-up";
          setTimeout(function(){document.getElementById("add_upd_notif").style.animationName = "none";}, 5000);
        }
        break;
      }
      default:{
        break;
      }
    }
    //Recarga la tabla actualizada
    current_id_on_search_details = false;
    loadAuthList(document.getElementById('tabla_autorizaciones'), fixedLocalTimezone((document.getElementById('auth_list_date') != null)? Date.parse(document.getElementById('auth_list_date').value): new Date()).getTime());
    closePrompt(document.querySelector('.floating-panel'));
  })
  .catch (function(error){
    console.log(error);
    //Mostrar notif de fallo de función
    if(document.getElementById("add_upd_notif").style.animationName == "none" || document.getElementById("add_upd_notif").style.animationName == ""){
      document.getElementById("add_upd_notif").innerHTML = `<svg alignment-baseline="baseline" width="30" height="30" fill="#ffffff" class="bi bi-person-plus-fill" viewBox="8 0 16 16">
      <path fill-rule="evenodd" d="M6.146 6.146a.5.5 0 0 1 .708 0L8 7.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 8l1.147 1.146a.5.5 0 0 1-.708.708L8 8.707 6.854 9.854a.5.5 0 0 1-.708-.708L7.293 8 6.146 6.854a.5.5 0 0 1 0-.708z"/>
      <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
      <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
      </svg>Hubo un error al guardar<br>la autorización.`;
      document.getElementById("add_upd_notif").classList.remove("green");
      document.getElementById("add_upd_notif").classList.add("red");
      document.getElementById("add_upd_notif").style.animationName = "notif-up";
      setTimeout(function(){document.getElementById("add_upd_notif").style.animationName = "none";}, 5000);
    }
  }); 
}

function deleteLeavingAuth (date, id, h_out) {
  let data = new FormData();
  //Validación de los datos hecha con el botón
  //Si todos están ok
  data.append('function','delete_auth');
  data.append('auth_date', date.value);
  data.append('id_searched', id.value);
  data.append('h_out', h_out.value);
  fetch('tab_auth_salida_functions.php', {
    method: "POST",
    body: data
  }).then (function (response){
    if(response.ok){
      return response.text();
    } else {
      throw "Error en la llamada";
    }
  })
  .then (function(data){
    switch(data){
      case '1':{
        //Mostrar Notificación de éxito de borrado
        if(document.getElementById("add_upd_notif").style.animationName == "none" || document.getElementById("add_upd_notif").style.animationName == ""){
          document.getElementById("add_upd_notif").innerHTML = `<svg alignment-baseline="baseline" width="30" height="30" fill="#ffffff" class="bi bi-person-plus-fill" viewBox="8 0 16 16">
            <path fill-rule="evenodd" d="M6.146 6.146a.5.5 0 0 1 .708 0L8 7.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 8l1.147 1.146a.5.5 0 0 1-.708.708L8 8.707 6.854 9.854a.5.5 0 0 1-.708-.708L7.293 8 6.146 6.854a.5.5 0 0 1 0-.708z"/>
            <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
            <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
          </svg>La autorización se<br>borró exitosamente.`;
          document.getElementById("add_upd_notif").classList.remove("red");
          document.getElementById("add_upd_notif").classList.add("green");
          document.getElementById("add_upd_notif").style.animationName = "notif-up";
          setTimeout(function(){document.getElementById("add_upd_notif").style.animationName = "none";}, 5000);
        }
        break;
      }
      case '0':{
        //Mostrar Notificación falla en delete. Ninguna fila fue alterada
        if(document.getElementById("add_upd_notif").style.animationName == "none" || document.getElementById("add_upd_notif").style.animationName == ""){
          document.getElementById("add_upd_notif").innerHTML = `<svg alignment-baseline="baseline" width="30" height="30" fill="#ffffff" class="bi bi-person-plus-fill" viewBox="8 0 16 16">
            <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z"/>
            <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z"/>
          </svg>No se borró ninguna autorización.<br>Puede que ya no exista`;
          document.getElementById("add_upd_notif").classList.remove("green");
          document.getElementById("add_upd_notif").classList.add("red");
          document.getElementById("add_upd_notif").style.animationName = "notif-up";
          setTimeout(function(){document.getElementById("add_upd_notif").style.animationName = "none";}, 5000);
        }
        break;
      }
      case '-1':{
        //Mostrar Notificación falla en inserción
        if(document.getElementById("add_upd_notif").style.animationName == "none" || document.getElementById("add_upd_notif").style.animationName == ""){
          document.getElementById("add_upd_notif").innerHTML = `<svg alignment-baseline="baseline" width="30" height="30" fill="#ffffff" class="bi bi-person-plus-fill" viewBox="8 0 16 16">
          <path d="M4.355.522a.5.5 0 0 1 .623.333l.291.956A4.979 4.979 0 0 1 8 1c1.007 0 1.946.298 2.731.811l.29-.956a.5.5 0 1 1 .957.29l-.41 1.352A4.985 4.985 0 0 1 13 6h.5a.5.5 0 0 0 .5-.5V5a.5.5 0 0 1 1 0v.5A1.5 1.5 0 0 1 13.5 7H13v1h1.5a.5.5 0 0 1 0 1H13v1h.5a1.5 1.5 0 0 1 1.5 1.5v.5a.5.5 0 1 1-1 0v-.5a.5.5 0 0 0-.5-.5H13a5 5 0 0 1-10 0h-.5a.5.5 0 0 0-.5.5v.5a.5.5 0 1 1-1 0v-.5A1.5 1.5 0 0 1 2.5 10H3V9H1.5a.5.5 0 0 1 0-1H3V7h-.5A1.5 1.5 0 0 1 1 5.5V5a.5.5 0 0 1 1 0v.5a.5.5 0 0 0 .5.5H3c0-1.364.547-2.601 1.432-3.503l-.41-1.352a.5.5 0 0 1 .333-.623zM4 7v4a4 4 0 0 0 3.5 3.97V7H4zm4.5 0v7.97A4 4 0 0 0 12 11V7H8.5zM12 6a3.989 3.989 0 0 0-1.334-2.982A3.983 3.983 0 0 0 8 2a3.983 3.983 0 0 0-2.667 1.018A3.989 3.989 0 0 0 4 6h8z"/>
          </svg>Datos inválidos. Recarga<br>la página.`;
          document.getElementById("add_upd_notif").classList.remove("green");
          document.getElementById("add_upd_notif").classList.add("red");
          document.getElementById("add_upd_notif").style.animationName = "notif-up";
          setTimeout(function(){document.getElementById("add_upd_notif").style.animationName = "none";}, 5000);
        }
        break;
      }
      default:{
        break;
      }
    }
    //Recarga la tabla actualizada
    loadAuthList(document.getElementById('tabla_autorizaciones'), fixedLocalTimezone((document.getElementById('auth_list_date') != null)? Date.parse(document.getElementById('auth_list_date').value): new Date()).getTime());
    closePrompt(document.querySelector('.floating-panel'));
  })
  .catch (function(error){
    console.log(error);
    //Mostrar notif de fallo de función
    if(document.getElementById("add_upd_notif").style.animationName == "none" || document.getElementById("add_upd_notif").style.animationName == ""){
      document.getElementById("add_upd_notif").innerHTML = `<svg alignment-baseline="baseline" width="30" height="30" fill="#ffffff" class="bi bi-person-plus-fill" viewBox="8 0 16 16">
      <path fill-rule="evenodd" d="M6.146 6.146a.5.5 0 0 1 .708 0L8 7.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 8l1.147 1.146a.5.5 0 0 1-.708.708L8 8.707 6.854 9.854a.5.5 0 0 1-.708-.708L7.293 8 6.146 6.854a.5.5 0 0 1 0-.708z"/>
      <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
      <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
      </svg>Hubo un error al guardar<br>la autorización.`;
      document.getElementById("add_upd_notif").classList.remove("green");
      document.getElementById("add_upd_notif").classList.add("red");
      document.getElementById("add_upd_notif").style.animationName = "notif-up";
      setTimeout(function(){document.getElementById("add_upd_notif").style.animationName = "none";}, 5000);
    }
  }); 
}

function restoreLeavingAuth (date, id, h_out) {
  let data = new FormData();
  //Validación de los datos hecha con el botón
  //Si todos están ok
  data.append('function','restore_auth');
  data.append('auth_date', date.value);
  data.append('id_searched', id.value);
  data.append('h_out', h_out.value);
  fetch('tab_auth_salida_functions.php', {
    method: "POST",
    body: data
  }).then (function (response){
    if(response.ok){
      return response.text();
    } else {
      throw "Error en la llamada";
    }
  })
  .then (function(data){
    switch(data){
      case '1':{
        //Mostrar Notificación de éxito de restaurado
        if(document.getElementById("add_upd_notif").style.animationName == "none" || document.getElementById("add_upd_notif").style.animationName == ""){
          document.getElementById("add_upd_notif").innerHTML = `<svg alignment-baseline="baseline" width="30" height="30" fill="#ffffff" class="bi bi-person-plus-fill" viewBox="8 0 16 16">
            <path fill-rule="evenodd" d="M10.854 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
            <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
            <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>          
          </svg>La autorización se<br>restauró exitosamente.`;
          document.getElementById("add_upd_notif").classList.remove("red");
          document.getElementById("add_upd_notif").classList.add("green");
          document.getElementById("add_upd_notif").style.animationName = "notif-up";
          setTimeout(function(){document.getElementById("add_upd_notif").style.animationName = "none";}, 5000);
        }
        break;
      }
      case '0':{
        //Mostrar Notificación falla en delete. Ninguna fila fue alterada
        if(document.getElementById("add_upd_notif").style.animationName == "none" || document.getElementById("add_upd_notif").style.animationName == ""){
          document.getElementById("add_upd_notif").innerHTML = `<svg alignment-baseline="baseline" width="30" height="30" fill="#ffffff" class="bi bi-person-plus-fill" viewBox="8 0 16 16">
            <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z"/>
            <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z"/>
          </svg>No se restauró ninguna autorización.<br>Puede que ya no exista`;
          document.getElementById("add_upd_notif").classList.remove("green");
          document.getElementById("add_upd_notif").classList.add("red");
          document.getElementById("add_upd_notif").style.animationName = "notif-up";
          setTimeout(function(){document.getElementById("add_upd_notif").style.animationName = "none";}, 5000);
        }
        break;
      }
      case '-1':{
        //Mostrar Notificación falla en inserción
        if(document.getElementById("add_upd_notif").style.animationName == "none" || document.getElementById("add_upd_notif").style.animationName == ""){
          document.getElementById("add_upd_notif").innerHTML = `<svg alignment-baseline="baseline" width="30" height="30" fill="#ffffff" class="bi bi-person-plus-fill" viewBox="8 0 16 16">
          <path d="M4.355.522a.5.5 0 0 1 .623.333l.291.956A4.979 4.979 0 0 1 8 1c1.007 0 1.946.298 2.731.811l.29-.956a.5.5 0 1 1 .957.29l-.41 1.352A4.985 4.985 0 0 1 13 6h.5a.5.5 0 0 0 .5-.5V5a.5.5 0 0 1 1 0v.5A1.5 1.5 0 0 1 13.5 7H13v1h1.5a.5.5 0 0 1 0 1H13v1h.5a1.5 1.5 0 0 1 1.5 1.5v.5a.5.5 0 1 1-1 0v-.5a.5.5 0 0 0-.5-.5H13a5 5 0 0 1-10 0h-.5a.5.5 0 0 0-.5.5v.5a.5.5 0 1 1-1 0v-.5A1.5 1.5 0 0 1 2.5 10H3V9H1.5a.5.5 0 0 1 0-1H3V7h-.5A1.5 1.5 0 0 1 1 5.5V5a.5.5 0 0 1 1 0v.5a.5.5 0 0 0 .5.5H3c0-1.364.547-2.601 1.432-3.503l-.41-1.352a.5.5 0 0 1 .333-.623zM4 7v4a4 4 0 0 0 3.5 3.97V7H4zm4.5 0v7.97A4 4 0 0 0 12 11V7H8.5zM12 6a3.989 3.989 0 0 0-1.334-2.982A3.983 3.983 0 0 0 8 2a3.983 3.983 0 0 0-2.667 1.018A3.989 3.989 0 0 0 4 6h8z"/>
          </svg>Datos inválidos. Recarga<br>la página.`;
          document.getElementById("add_upd_notif").classList.remove("green");
          document.getElementById("add_upd_notif").classList.add("red");
          document.getElementById("add_upd_notif").style.animationName = "notif-up";
          setTimeout(function(){document.getElementById("add_upd_notif").style.animationName = "none";}, 5000);
        }
        break;
      }
      default:{
        break;
      }
    }
    //Recarga la tabla actualizada
    loadAuthList(document.getElementById('tabla_autorizaciones'), fixedLocalTimezone((document.getElementById('auth_list_date') != null)? Date.parse(document.getElementById('auth_list_date').value): new Date()).getTime());
    closePrompt(document.querySelector('.floating-panel'));
  })
  .catch (function(error){
    console.log(error);
    //Mostrar notif de fallo de función
    if(document.getElementById("add_upd_notif").style.animationName == "none" || document.getElementById("add_upd_notif").style.animationName == ""){
      document.getElementById("add_upd_notif").innerHTML = `<svg alignment-baseline="baseline" width="30" height="30" fill="#ffffff" class="bi bi-person-plus-fill" viewBox="8 0 16 16">
      <path fill-rule="evenodd" d="M6.146 6.146a.5.5 0 0 1 .708 0L8 7.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 8l1.147 1.146a.5.5 0 0 1-.708.708L8 8.707 6.854 9.854a.5.5 0 0 1-.708-.708L7.293 8 6.146 6.854a.5.5 0 0 1 0-.708z"/>
      <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
      <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
      </svg>Hubo un error al guardar<br>la autorización.`;
      document.getElementById("add_upd_notif").classList.remove("green");
      document.getElementById("add_upd_notif").classList.add("red");
      document.getElementById("add_upd_notif").style.animationName = "notif-up";
      setTimeout(function(){document.getElementById("add_upd_notif").style.animationName = "none";}, 5000);
    }
  }); 
}


function updateLeavingAuth (date, person, h_out, h_return, will_return) {
  let data = new FormData();
  //Validación de los datos hecha con el botón
  //Si todos están ok
  data.append('function','update_auth');
  data.append('auth_date', date.getAttribute('timestamp'));
  data.append('id_searched', person.getAttribute('id_persona'));
  data.append('h_out', h_out.value);
  data.append('h_return', h_return.value);
  //Lo paso negado, porque, si está habilitado, significa que no va a volver, osea, will_return=false
  data.append('will_return', !will_return.checked);
  fetch('tab_auth_salida_functions.php', {
    method: "POST",
    body: data
  }).then (function (response){
    if(response.ok){
      return response.text();
    } else {
      throw "Error en la llamada";
    }
  })
  .then (function(data){
    console.log(data);
    switch(data){
      case '1':{
        //Mostrar Notificación de éxito
        if(document.getElementById("add_upd_notif").style.animationName == "none" || document.getElementById("add_upd_notif").style.animationName == ""){
          document.getElementById("add_upd_notif").innerHTML = `<svg alignment-baseline="baseline" width="30" height="30" fill="#ffffff" class="bi bi-person-plus-fill" viewBox="8 0 16 16">
          <path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z"/>
          <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
          <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
          </svg>La hora de retorno se<br>actualizó exitosamente.`;
          document.getElementById("add_upd_notif").classList.remove("red");
          document.getElementById("add_upd_notif").classList.add("green");
          document.getElementById("add_upd_notif").style.animationName = "notif-up";
          setTimeout(function(){document.getElementById("add_upd_notif").style.animationName = "none";}, 5000);
        }
        break;
      }
      case '0':{
        //Mostrar Notificación falla en inserción
        if(document.getElementById("add_upd_notif").style.animationName == "none" || document.getElementById("add_upd_notif").style.animationName == ""){
          document.getElementById("add_upd_notif").innerHTML = `<svg alignment-baseline="baseline" width="30" height="30" fill="#ffffff" class="bi bi-person-plus-fill" viewBox="8 0 16 16">
          <path fill-rule="evenodd" d="M6.146 6.146a.5.5 0 0 1 .708 0L8 7.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 8l1.147 1.146a.5.5 0 0 1-.708.708L8 8.707 6.854 9.854a.5.5 0 0 1-.708-.708L7.293 8 6.146 6.854a.5.5 0 0 1 0-.708z"/>
          <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
          <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
          </svg>Ya existe una hora de retorno<br>para esta autorización.`;
          document.getElementById("add_upd_notif").classList.remove("green");
          document.getElementById("add_upd_notif").classList.add("red");
          document.getElementById("add_upd_notif").style.animationName = "notif-up";
          setTimeout(function(){document.getElementById("add_upd_notif").style.animationName = "none";}, 5000);
        }
        break;
      }
      case '-1':{
        //Mostrar Notificación falla en inserción
        if(document.getElementById("add_upd_notif").style.animationName == "none" || document.getElementById("add_upd_notif").style.animationName == ""){
          document.getElementById("add_upd_notif").innerHTML = `<svg alignment-baseline="baseline" width="30" height="30" fill="#ffffff" class="bi bi-person-plus-fill" viewBox="8 0 16 16">
          <path fill-rule="evenodd" d="M6.146 6.146a.5.5 0 0 1 .708 0L8 7.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 8l1.147 1.146a.5.5 0 0 1-.708.708L8 8.707 6.854 9.854a.5.5 0 0 1-.708-.708L7.293 8 6.146 6.854a.5.5 0 0 1 0-.708z"/>
          <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
          <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
          </svg>Revisa si los campos están<br>llenados correctamente.`;
          document.getElementById("add_upd_notif").classList.remove("green");
          document.getElementById("add_upd_notif").classList.add("red");
          document.getElementById("add_upd_notif").style.animationName = "notif-up";
          setTimeout(function(){document.getElementById("add_upd_notif").style.animationName = "none";}, 5000);
        }
        break;
      }
      default:{
        break;
      }
    }
    //Recarga la tabla actualizada
    current_id_on_search_details = false;
    loadAuthList(document.getElementById('tabla_autorizaciones'), fixedLocalTimezone((document.getElementById('auth_list_date') != null)? Date.parse(document.getElementById('auth_list_date').value): new Date()).getTime());
    closePrompt(document.querySelector('.floating-panel'));
  })
  .catch (function(error){
    console.log(error);
    //Mostrar notif de fallo de función
    if(document.getElementById("add_upd_notif").style.animationName == "none" || document.getElementById("add_upd_notif").style.animationName == ""){
      document.getElementById("add_upd_notif").innerHTML = `<svg alignment-baseline="baseline" width="30" height="30" fill="#ffffff" class="bi bi-person-plus-fill" viewBox="8 0 16 16">
      <path fill-rule="evenodd" d="M6.146 6.146a.5.5 0 0 1 .708 0L8 7.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 8l1.147 1.146a.5.5 0 0 1-.708.708L8 8.707 6.854 9.854a.5.5 0 0 1-.708-.708L7.293 8 6.146 6.854a.5.5 0 0 1 0-.708z"/>
      <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
      <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
      </svg>Hubo un error al guardar<br>la autorización.`;
      document.getElementById("add_upd_notif").classList.remove("green");
      document.getElementById("add_upd_notif").classList.add("red");
      document.getElementById("add_upd_notif").style.animationName = "notif-up";
      setTimeout(function(){document.getElementById("add_upd_notif").style.animationName = "none";}, 5000);
    }
  });   
}

function printCurrentTime(){
  return ((new Date().getHours() > 9)? '':'0') + new Date().getHours() + ':' + ((new Date().getMinutes() > 9)? '':'0') + new Date().getMinutes();
}

//Para controlar el comportamiento del formulario del portero
function checkPorterForm(){
  //check_***=true significa que pasa el filtro correctamente, false significa que no
  //Si hay un id definido por la búsqueda o por actualización
  check_id =  current_id_on_search_details || (document.getElementById('r_name').getAttribute('id_persona') != null && ((document.getElementById('return_time').value != '' && (hourToMins(document.getElementById('return_time').value) > hourToMins(document.getElementById('leave_time').value))) || document.getElementById('will_return').checked == true));
  //radio: si hay un checked, Y es falso que(el checked sea otros y su input text esté vacío), entonces checkradius será true.
  check_radius = document.querySelectorAll('input[type=radio]:checked').length > 0 && !([...document.querySelectorAll('input[type=radio]')].pop().checked == true && document.getElementById('motivo_otros_value').value.trim().replace(/\s+/g,' ').length == 0);
  //El trim y limpiado de espacios se hará al pasarlo al server
  //document.getElementById('motivo_descrip').value = document.getElementById('motivo_descrip').value.trim().replace(/\s+/g,' ');
  check_textarea = document.getElementById('motivo_descrip').value.trim().replace(/\s+/g,' ').length > 0;
  check_h_salida = document.getElementById('leave_time').value != '' && document.getElementById('leave_time').value != '00:00';
  check_h_return = (document.getElementById('return_time').value != '' && document.getElementById('return_time').value != '00:00') || document.getElementById('will_return').checked == true;
  return_time = (document.getElementById('will_return').checked == true)? false: parseInt(document.getElementById('return_time').value.split(":")[0])*60 + parseInt(document.getElementById('return_time').value.split(":")[1]);
  leave_time = parseInt(document.getElementById('leave_time').value.split(":")[0])*60 + parseInt(document.getElementById('leave_time').value.split(":")[1]);
  check_h_dif = (((document.getElementById('will_return').checked == true)? 0: (return_time)) - (leave_time) * ((document.getElementById('will_return').checked == true)? -1: 1)) > 0;
  //Comportamiento del botón de Guardar
  //console.log(check_textarea);
  //console.log(check_h_salida);
  document.getElementById('save_auth').disabled = !(check_id && check_radius && check_textarea && check_h_salida);
  console.log(check_id);
  console.log(check_id && check_radius);
  console.log(check_id && check_radius && check_textarea);
  console.log(check_id && check_radius && check_textarea && check_h_salida);
}

//Comportamiento para que el botón de Añadir Autorización desaparezca
function addAuthBtnHandler (date_input, btn) {
  let session_lvl = new FormData();
  session_lvl.append('function', 'current_user_lvl');
  //Obtenemos los privilegios del usuario actual
  fetch('tab_auth_salida_functions.php', {
    method: "POST",
    body: session_lvl
  }).then (function (response){
    if(response.ok){
        return response.text();
    } else {
        throw "Error en la llamada";
    }
  })
  .then (function(session_lvl){
    switch(session_lvl){
      case '1': break;
      //case '3': {console.log(btn); btn.remove(); break;}
      default: {
        if(date_input.value == printDateYMD(new Date())) {
          btn.classList.remove('hide');
          btn.classList.add('show'); 
        } else {
          btn.classList.remove('show');
          btn.classList.add('hide');
        }
        break;
      }
    }
  })
  .catch (function(error){
      console.log(error);
  }); 
}

function initLiveTime (php_timestamp, target_class) {
  setTimeout(function () {initLiveTime(php_timestamp, target_class);}, 1000);
  let data = new FormData();
  data.append('function','live_timer');
  fetch('tab_auth_salida_functions.php', {
    method: "POST",
    body: data
  }).then (function (response){
    if(response.ok){
      return response.text();
    } else {
      throw "Error en la llamada";
    }
  })
  .then (function(data){
    for (i = 0; i < document.querySelectorAll(`span.${target_class}`).length; i++){
      document.querySelectorAll(`span.${target_class}`)[i].innerHTML = printFullDateAndTime(new Date(parseInt(data)));
    }
  })
  .catch (function(error){
    console.log(error);
  }); 
}

function showCalc(toggle){
  if (toggle.classList.contains("off")) {
    toggle.classList.remove("off");
    toggle.classList.add("on");
    document.getElementById("calc-body").style.width = "360px";
    document.getElementById("calc-body").style.height = "580px";
    for(i = 0; i < document.querySelectorAll(".calc-title, .calc-screen-up, .calc-screen, .calc-button").length; i++){
      document.querySelectorAll(".calc-title, .calc-screen-up, .calc-screen, .calc-button")[i].classList.remove("hide");
      document.querySelectorAll(".calc-title, .calc-screen-up, .calc-screen, .calc-button")[i].classList.add("show");
    }
  } else {
    for(i = 0; i < document.querySelectorAll(".calc-title, .calc-screen-up, .calc-screen, .calc-button").length; i++){
      document.querySelectorAll(".calc-title, .calc-screen-up, .calc-screen, .calc-button")[i].classList.remove("show");
      document.querySelectorAll(".calc-title, .calc-screen-up, .calc-screen, .calc-button")[i].classList.add("hide");
    }
    toggle.classList.remove("on");
    toggle.classList.add("off");
    document.getElementById("calc-body").style.width = "60px";
    document.getElementById("calc-body").style.height = "60px";
  }
}

function loadAdmUserList (table_body,flag) {
  let data = new FormData();
  if(typeof flag == 'undefined' || flag == true){
    //Si no se define, o se define como true, que se recupere la data de los habilitados
    data.append('function','user_data_query');
  } else {
    //Pero si se declara como false, que se recupere la data de los deshabilitados
    data.append('function','user_data_query_disabled');
  }
  fetch('tab_adm_functions.php', {
      method: "POST",
      body: data
  }).then (function (response){
      if(response.ok){
          return response.text();
      } else {
          throw "Error en la llamada";
      }
  }).then (function(data){
    //JSON.parse(data) transforma el objeto recibido de php, en un javascript object, listo para ser manipulado/recorrido
    data = JSON.parse(data);
    console.log(data);
    console.log(typeof flag == 'undefined');
    console.log(flag == true);
    if(typeof flag == 'undefined' || flag == true){
      loadTableData(data, table_body);
    } else {
      loadTableData(data, table_body, flag);
    }
  })
  .catch (function(error){
      console.log(error);
  });        
}

function loadAuthList (table_body, date_timestamp) {
  let data = new FormData();
  data.append('function','auth_table_query');
  if(date_timestamp != null) {data.append('date',date_timestamp);}
  fetch('tab_auth_salida_functions.php', {
      method: "POST",
      body: data
  }).then (function (response){
      if(response.ok){
          return response.text();
      } else {
          throw "Error en la llamada";
      }
  })
  .then (function(data){
    data = JSON.parse(data);
    table_body_html = '';
    if(data.length != 0) {
      //Si hay data, que la muestre en la tabla
      for(let auth_form of data) {
        table_body_html += `<tr id_persona="${auth_form['id_trabajador']}">`;
        for(var key in auth_form) {
          cell_value = '<td';
          switch(key){
            case 'h_retorno': {
              cell_value += `>${auth_form[key]}`;
              break;
            }
            case 'h_salida': case 'duracion': {
              cell_value += `>${auth_form[key]}`;
              break;
            }
            case 'creacion': case 'completado':{
              if(auth_form[key].length == 0){
                cell_value += `>`;
              }
               else {
                cell_value += `>${auth_form[key].split(",")[0] + "; " + printFullDateAndTime(new Date(auth_form[key].split(",")[1].slice(0, -3)))}`;
              }
              break;
            }
            case 'id_trabajador':{
              //Que se salte la celda
              continue;
            }
            case 'descripcion': {
              a = ((typeof date_timestamp == 'undefined')? new Date().getFullYear(): new Date(date_timestamp).getFullYear())== new Date().getFullYear();
              b = ((typeof date_timestamp == 'undefined')? new Date().getMonth(): new Date(date_timestamp).getMonth())== new Date().getMonth();
              c = ((typeof date_timestamp == 'undefined')? new Date().getDate(): new Date(date_timestamp).getDate())== new Date().getDate();
              //Si existe duración (es decir, la autorización está completa) OR (es un portero y no es hoy) OR es un usuario que solo puede ver (3), que muestre el botón de Ver. Sino, que no muestre nada 
              cell_value += ` descrip="${(auth_form[key] == null)? '': auth_form[key]}">${(auth_form['duracion'] != null || session_lvl == 3 || (session_lvl == 4 && !(a && b && c)))? `<button class="tabpanelbuttons small neutral" 
              onclick="promptAddUpdLeavingAuth(document.querySelector('.floating-panel'), this);"><div>
              <svg alignment-baseline="baseline" width="20" height="20" fill="#ffffff" class="bi bi-person-plus-fill" viewBox="2 0 16 16">
                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
              </svg>Ver más</div></button>`: ''}`;
              break;
            }
            case 'action': {
              cell_value += `${auth_form[key]}`; 
              break;
            }
            default: {
              cell_value += `>${(auth_form[key] == null)? '': auth_form[key]}`; 
              break;
            }
          }
          table_body_html += `${cell_value}</td>`;
        }
        //Si es el admin, que muestre la columna de eliminar
        // if(session_lvl == 1) {
        //   table_body_html += `<td eliminar>
        //     <button class="tabpanelbuttons small no" 
        //     onclick="promptDelLeavingAuth(document.querySelector('.floating-panel'), this);"><div>
        //     <svg alignment-baseline="baseline" width="20" height="20" fill="#ffffff" class="bi bi-person-plus-fill" viewBox="2 0 16 16">
        //       <path fill-rule="evenodd" d="M6.146 6.146a.5.5 0 0 1 .708 0L8 7.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 8l1.147 1.146a.5.5 0 0 1-.708.708L8 8.707 6.854 9.854a.5.5 0 0 1-.708-.708L7.293 8 6.146 6.854a.5.5 0 0 1 0-.708z"/>
        //       <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
        //       <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
        //     </svg>Deshabilitar</div></button>
        //   </td>`;
        // }  
        table_body_html += '</tr>';
      }
    } else {
      //Si no la hay, que muestre una celda del ancho de toda la tabla
      table_body_html = `<tr><td colspan=${document.querySelectorAll('#auth_list_table > thead > tr > th').length}>No hay autorizaciones registradas en este día</td></tr>`;
    }
    table_body.innerHTML = table_body_html;
  })
  .catch (function(error){
      console.log(error);
  });        
}

function checkMotivo (value) {
  //Hago un for inverso, para que primero haga check a OTROS, y luego, si encuentra algo distinto que encaja en las otras opciones, les de check.
  for(i = document.getElementsByName('motivo_radio').length - 1; i  >= 0; --i){
    switch(document.getElementsByName('motivo_radio')[i].value){
      case 'comis-serv':{
        if(value == 'COMISIÓN DE SERVICIO' || value == 'COMISION DE SERVICIO') {document.getElementsByName('motivo_radio')[i].checked = true; j = i;}
        break;
      }
      case 'motiv-pers':{
        if(value == 'MOTIVOS PARTICULARES') {document.getElementsByName('motivo_radio')[i].checked = true; j = i;}
        break;
      }
      case 'compe-horas':{
        if(value == 'COMPENSACIÓN DE HORAS' || value == 'COMPENSACION DE HORAS') {document.getElementsByName('motivo_radio')[i].checked = true; j = i;}
        break;
      }
      case 'enfer':{
        if(value == 'ENFERMEDAD') {document.getElementsByName('motivo_radio')[i].checked = true; j = i;}
        break;
      }
      case 'essalud':{
        if(value == 'ESSALUD') {document.getElementsByName('motivo_radio')[i].checked = true; j = i;}
        break;
      }
      case 'otros':{
        document.getElementsByName('motivo_radio')[i].checked = true; 
        j = i;
        break;
      }
    }
    document.getElementsByName('motivo_radio')[i].disabled = true;
  }
  //Si Otros es el radio activado, entonces llenar el input correspondiente a Otros
  if(document.getElementsByName('motivo_radio')[document.getElementsByName('motivo_radio').length - 1].checked == true) {
    document.getElementById('motivo_otros_value').value = value;
    document.getElementsByName('motivo_radio')[j].nextElementSibling.nextElementSibling.classList.add('bold');
  }
  document.getElementsByName('motivo_radio')[j].nextElementSibling.classList.add('bold');
}

//Función únicamente gráfica/visual
function validateNameInput(inputElement){
  if(current_id_on_search_details){ 
    inputElement.style.color = '#000000';
    inputElement.style.background = '#CCFF90';
    inputElement.style.borderColor = '#33691E';
  } else {
    inputElement.style.background = '#FF8A80';
    inputElement.style.borderColor = '#B71C1C';
  }
}

function validateNameInputRowReady(inputElement, valAttr){
  if(inputElement.hasAttribute(valAttr) && inputElement.getAttribute(valAttr) != '0'){ 
    inputElement.style.background = '#CCFF90';
    inputElement.style.borderColor = '#33691E';
  } else {
    inputElement.style.background = '#FF8A80';
    inputElement.style.borderColor = '#B71C1C';
  }
}

function promptAddUpdHojaAsis (panel, this_button, auth_info) {
  loadingAnimation(true);

  external_only_view = auth_info != null;
  if(external_only_view) {
    panel.style.zIndex = '20';
    document.getElementById('darkopacity_2').classList.remove('hide');
    document.getElementById('darkopacity_2').classList.add('show');
  }
  row = (this_button.parentNode.tagName == 'TD')? this_button.parentNode.parentNode : null;
  //Si se llamó a esta función desde una tabla, crear un array auxiliar con los datos a poner en el formulario de solo lectura
  if(row!=null){
    var aux_row = [];
    for (i = 0; i <= 6; i++){
      switch(i){
        case 6: aux_row[i] = row.childNodes[i].getAttribute('descrip'); break;
        default: aux_row[i] = row.childNodes[i].innerHTML; break;
      }
    }
    aux_row[7] = row.getAttribute('id_persona');
    //Asignar el array auxiliar a row. Ahora el formulario podraa leer los datos directamente de row[]
    row = aux_row;
  }
  //Si existe información de la autorización (si existe un tercer argumento -el cual es opcional-, entonces igualamos row a los valores de ese array que es el 3er argumento)
  if(auth_info != null){
    row = auth_info;
  }
  document.getElementById("darkopacity").classList.remove("hide");
  document.getElementById("darkopacity").classList.add("show");
  panel.classList.remove("hide");
  panel.classList.add("show");
  panel.style.marginTop = (panel.offsetHeight / -2) + 'px';

  loadingAnimation(false);
}

function promptAddUpdLeavingAuth (panel, this_button, auth_info) {
  loadingAnimation(true);

  external_only_view = auth_info != null;
  if(external_only_view) {
    panel.style.zIndex = '20';
    document.getElementById('darkopacity_2').classList.remove('hide');
    document.getElementById('darkopacity_2').classList.add('show');
  }
  row = (this_button != null && !external_only_view)? this_button.parentNode.parentNode : null;
  //Si se llamó a esta función desde una tabla, crear un array auxiliar con los datos a poner en el formulario de solo lectura
  if(row!=null){
    var aux_row = [];
    for (i = 0; i <= 6; i++){
      switch(i){
        case 6: aux_row[i] = row.childNodes[i].getAttribute('descrip'); break;
        default: aux_row[i] = row.childNodes[i].innerHTML; break;
      }
    }
    aux_row[7] = row.getAttribute('id_persona');
    //Asignar el array auxiliar a row. Ahora el formulario podraa leer los datos directamente de row[]
    row = aux_row;
  }
  //Si existe información de la autorización (si existe un tercer argumento -el cual es opcional-, entonces igualamos row a los valores de ese array que es el 3er argumento)
  if(auth_info != null){
    row = auth_info;
  }
  panel.innerHTML = `<form name="ins_upd_auth" method="POST">
  <h2>${(row==null)? 'Nueva Autorización': (external_only_view || row[4]!='' || this_button.parentNode.hasAttribute('descrip'))? 'AUTORIZACIÓN DE SALIDA' : 'Añadir Hora de Retorno'}</h2>
  <div id="tab_auth_form">
    <div>
      <span id="auth_date" 
        timestamp="${(document.getElementById('auth_list_date') != null)?(new Date(document.getElementById('auth_list_date').value)).valueOf() + new Date().getTimezoneOffset() * 60 * 1000 : new Date().valueOf()}">
        Fecha: ${(document.getElementById('auth_list_date') != null)? printFullDateAndTime(fixedLocalTimezone((new Date(document.getElementById('auth_list_date').value)).valueOf()), false): printFullDateAndTime(new Date(), false)}</span>
    </div>
    <div id="tab_auth_body">
      <div>
        <span>Nombre:</span>
        <div>
          <input id="r_name" name="r_name"  
            type="text"
            autocomplete="off"
            id="input_persona_horario"
            ${(row!=null)? `id_persona="${row[7]}"`:' '}
            onkeyup="livesearchWorkPerson(this, document.getElementById('resultados_busqueda_persona')); current_id_on_search_details = false; validateNameInput(this); onchange();"
            onfocusin="document.getElementById('darkopacity_2').classList.remove('hide'); 
            document.getElementById('darkopacity_2').classList.add('show');
            dropListFocusIn([this, document.getElementById('resultados_busqueda_persona')],1); livesearchWorkPerson(this, document.getElementById('resultados_busqueda_persona'));"
            onchange="checkPorterForm();"
            value="${(row!=null)? row[1]:''}" ${(row!=null || external_only_view)? 'disabled':''}/>
          <div class="area-floating-container" id="resultados_busqueda_persona"></div>
          <div id="darkopacity_2" class="hide" onclick="this.classList.remove('show'); this.classList.add('hide'); document.getElementById('resultados_busqueda_persona').innerHTML='';"></div>
        </div>
      </div>
      <div>
        <div>
          <span>Motivo:</span>
        </div>
        <div>
          <div><input type="radio" name="motivo_radio" value="comis-serv" onchange="document.getElementById('motivo_otros_value').disabled = !document.getElementById('motivo_otros_value').parentNode.childNodes[0].checked; checkPorterForm();">
          <label for="com-serv">Comisión de Servicio</label></div>
          <div><input type="radio" name="motivo_radio" value="motiv-pers" onchange="document.getElementById('motivo_otros_value').disabled = !document.getElementById('motivo_otros_value').parentNode.childNodes[0].checked; checkPorterForm();">
          <label for="motiv-pers">Motivos Particulares</label></div>
          <div><input type="radio" name="motivo_radio" value="compe-horas" onchange="document.getElementById('motivo_otros_value').disabled = !document.getElementById('motivo_otros_value').parentNode.childNodes[0].checked; checkPorterForm();">
          <label for="motiv-pers">Compensación Horas</label></div>
          <div><input type="radio" name="motivo_radio" value="enfer" onchange="document.getElementById('motivo_otros_value').disabled = !document.getElementById('motivo_otros_value').parentNode.childNodes[0].checked; checkPorterForm();">
          <label for="motiv-pers">Enfermedad</label></div>
          <div><input type="radio" name="motivo_radio" value="essalud" onchange="document.getElementById('motivo_otros_value').disabled = !document.getElementById('motivo_otros_value').parentNode.childNodes[0].checked; checkPorterForm();">
          <label for="motiv-pers">ESSALUD</label></div>
          <div><input type="radio" name="motivo_radio" value="otros" onchange="document.getElementById('motivo_otros_value').disabled = !document.getElementById('motivo_otros_value').parentNode.childNodes[0].checked; checkPorterForm();">
          <label for="motiv-pers">Otros (especificar)</label><input id="motivo_otros_value" type="text" maxlength="25" onchange="checkPorterForm();" onkeyup="this.onchange();" onfocus="this.onchange();" disabled></div>
        </div>
      </div>
      <div><textarea id="motivo_descrip" type="textarea" maxlength="250" 
        onchange="checkPorterForm();"
        onkeyup="this.onchange();"
        onkeydown="if(event.keyCode == 13){return false;}"
        onfocus="this.onchange();"
        value="" ${(row!=null || external_only_view)? 'disabled':''}>${(row!=null)? row[6]:''}</textarea>
      </div>
      <div>
        <div><span>Hora de Salida:</span></div>
        <div><input id="leave_time" type="time" class="small" onchange="checkPorterForm();"
        value="${(row!=null)? row[2]:''}" ${(row!=null || external_only_view)? 'disabled':''}></div>
        <div><button class="tabpanelbuttons neutral" onclick="document.getElementById('leave_time').value = printCurrentTime(); checkPorterForm(); return false;" ${(row!=null || external_only_view)? 'disabled':''}>Toca aquí para ingresar la hora actual</button></div>
      </div>
      <div>
        <div><span>Hora de Retorno:</span></div>
        <div><input id="return_time" type="time" class="small" onchange="checkPorterForm();"
        value="${(row!=null && (/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/g.test(row[3])))? row[3] : ''}" ${(row!=null && row[4] == '' && !(this_button.parentNode.hasAttribute('descrip')))? '':'disabled'}></div>
        <div><button id="return_time_btn" class="tabpanelbuttons neutral" onclick="document.getElementById('return_time').value = printCurrentTime(); checkPorterForm(); return false;" ${(!external_only_view && row!=null && row[4] == '' && !(this_button.parentNode.hasAttribute('descrip')))? '':'disabled'}>Toca aquí para ingresar la hora actual</button></div>
      </div>
      <div>
        <input 
          id="will_return" 
          type="checkbox"
          ${(row!=null)? 'onchange=\"document.getElementById(\'return_time\').disabled = !document.getElementById(\'return_time\').disabled; document.getElementById(\'return_time_btn\').disabled = !document.getElementById(\'return_time_btn\').disabled; document.getElementById(\'return_time\').value = \'\'; checkPorterForm();\"': ''}
          ${(row!=null && row[3] == 'SIN RETORNO')? 'checked':''} ${(external_only_view || (row!=null && (row[4] != '' || this_button.parentNode.hasAttribute('descrip'))))? 'disabled':''}>
        <span${(row!=null && row[3] == 'SIN RETORNO')? ' class=\'bold\'':''}>Sin retorno</span></div>
      <div>
        ${(row != null && row[4] != '')? `<div>Duración: <input type="text" class="small" value="${(external_only_view && !(/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/g.test(row[4])))? 'FALTA': (row[4].split(":")[0] + "h " + row[4].split(":")[1] + "m")}" disabled></div>`
        : `<button id="save_auth" class="tabpanelbuttons ok" 
        onclick="${(row == null)? `addLeavingAuth(document.getElementsByName('motivo_radio'), document.getElementById('motivo_otros_value'), document.getElementById('motivo_descrip'), document.getElementById('leave_time'), document.getElementById('return_time'), document.getElementById('will_return')); `
        : `updateLeavingAuth(document.getElementById('auth_date'), document.getElementById('r_name'), document.getElementById('leave_time'), document.getElementById('return_time'), document.getElementById('will_return')); `}return false;" disabled>
        Guardar Autorización</button>`}
        <button id="cancel_auth" class="tabpanelbuttons no" 
        onclick="closePrompt(document.querySelector('${(external_only_view)? '.floating-panel.second': '.floating-panel'}')); ${(!external_only_view)? 'current_id_on_search_details = false;' : ''} return false;">
        ${(row!=null && row[4]!='')? 'Cerrar': 'Cancelar'}</button>
      </div>
    </div>
  </div></form>`;
  console.log('Ver external');
  console.log(external_only_view);
  console.log(row);
  if(row!=null) {checkMotivo(row[5]);}
  if(!external_only_view){
    document.getElementById("darkopacity").classList.remove("hide");
    document.getElementById("darkopacity").classList.add("show");
  }
  panel.classList.remove("hide");
  panel.classList.add("show");
  panel.style.marginTop = (panel.offsetHeight / -2) + 'px';

  loadingAnimation(false);
}

function promptHojaAsisInfo(panel, id_hoja) {
  loadingAnimation(true);
  
  panel.style.zIndex = '20';
  document.getElementById('darkopacity_2').classList.remove('hide');
  document.getElementById('darkopacity_2').classList.add('show');

  let data = new FormData();
  data.append('function','hoja_asis_id_table_query');
  data.append('id_trabajador', current_id_on_search_details);
  data.append('id_hoja_ver', id_hoja);
  fetch('tab_search_functions.php', {
    method: "POST",
    body: data
  }).then (function (response){
    if(response.ok){
        return response.text();
    } else {
        throw "Error en la llamada";
    }
  })
  .then (function(data){
    if(data){
      data = JSON.parse(data);
      console.log(data);
      document.getElementById('dir_ofi').value = data.encabezado_hoja.dir_ofi;
      document.getElementById('firma').value = data.encabezado_hoja.firmado_por;
      document.getElementById('hojas_asis_date').value = data.encabezado_hoja.fecha;
      filas_html = '';

      for(i = 0; i < data.filas_hoja.length; i++){
        filas_html += `<tr>`;
        for (var key in data.filas_hoja[i]){
          if(key != 'fecha_oculta') {
            if(data.filas_hoja[i].nombre == data.encabezado_hoja.nombre){
              //Si el nombre buscado es igual al nombre de la fila, que se resalte de color verde
              filas_html += `<td class="rev">${data.filas_hoja[i][key]}</td>`;
            } else {
              filas_html += `<td>${data.filas_hoja[i][key]}</td>`;
            }
          }
        }
        filas_html += `</tr>`;
      }
      document.getElementById('tabla_hojas_asis').innerHTML = filas_html;

      panel.classList.remove('hide');
      panel.classList.add('show');
      loadingAnimation(false);
    }
  })
  .catch (function(error){
      console.log(error);
  });
}

function promptDelLeavingAuth(panel, this_button) {
  row = this_button.parentNode.parentNode;
  //Si recibe un row, entonces es modificar. Si no lo recibe, es añadir
  panel.classList.add("delete");
  panel.innerHTML = `<form name="del_auth" method="POST">
  <h3>¿Seguro que quiere eliminar la autorización de ${row.childNodes[1].innerHTML} del día ${printFullDateAndTime(fixedLocalTimezone((new Date(document.getElementById('auth_list_date').value)).valueOf()), false)} con hora de salida ${row.childNodes[2].innerHTML}?</h3>
  <input type="hidden" name="function" value="del_auth"/>
  <input type="hidden" id="auth_date" value="${document.getElementById('auth_list_date').value}"/>
  <input type="hidden" id="r_name" value="${row.getAttribute('id_persona')}"/>
  <input type="hidden" id="leave_time" value="${row.childNodes[2].innerHTML}"/>
  <div>
      <button class="tabpanelbuttons ok" onclick="deleteLeavingAuth(document.getElementById('auth_date'), document.getElementById('r_name'), document.getElementById('leave_time')); return false;">Sí</button>
      <button class="tabpanelbuttons no" onclick="closePrompt(document.querySelector('.floating-panel')); return false;">No</button>
  </div></form>`;
  document.getElementById("darkopacity").classList.remove("hide");
  document.getElementById("darkopacity").classList.add("show");
  panel.classList.remove("hide");
  panel.classList.add("show");
}

function promptResLeavingAuth(panel, this_button) {
  row = this_button.parentNode.parentNode;
  //Si recibe un row, entonces es modificar. Si no lo recibe, es añadir
  panel.classList.add("delete");
  panel.innerHTML = `<form name="res_auth" method="POST">
  <h3>¿Seguro que quiere restaurar la autorización de ${row.childNodes[1].innerHTML} del día ${printFullDateAndTime(fixedLocalTimezone((new Date(document.getElementById('auth_list_date').value)).valueOf()), false)} con hora de salida ${row.childNodes[2].innerHTML}?</h3>
  <input type="hidden" name="function" value="res_auth"/>
  <input type="hidden" id="auth_date" value="${document.getElementById('auth_list_date').value}"/>
  <input type="hidden" id="r_name" value="${row.getAttribute('id_persona')}"/>
  <input type="hidden" id="leave_time" value="${row.childNodes[2].innerHTML}"/>
  <div>
      <button class="tabpanelbuttons ok" onclick="restoreLeavingAuth(document.getElementById('auth_date'), document.getElementById('r_name'), document.getElementById('leave_time')); return false;">Sí</button>
      <button class="tabpanelbuttons no" onclick="closePrompt(document.querySelector('.floating-panel')); return false;">No</button>
  </div></form>`;
  document.getElementById("darkopacity").classList.remove("hide");
  document.getElementById("darkopacity").classList.add("show");
  panel.classList.remove("hide");
  panel.classList.add("show");
}

function promptCreateUpdateUser(panel, row) {
  loadingAnimation(true);

  //Si recibe un row, entonces es modificar. Si no lo recibe, es añadir
  panel.innerHTML = `<form name="add_upd_user" method="POST">
  <h2>${(row==null)? 'Nuevo Usuario': 'Modificar Usuario'}</h2>
  <input type="hidden" name="function" value="${(row==null)? 'add_user': 'upd_user'}"/>
  <div>
      <span>ID:</span>
      <input id="upd_id" name="upd_id" type="text" value="${(row!=null)? row.childNodes[0].innerHTML:'-'}" readonly/>
  </div>
  <div>
      <span>Usuario:</span>
      <input id="upd_user" name="upd_user" type="text" autocomplete="off" maxlength="20" value="${(row!=null)? row.childNodes[1].innerHTML:''}" ${(row!=null)? 'oldvalue="' + row.childNodes[1].innerHTML + '"':''}/>
      <hint id="wrong_user"></hint>
  </div>
  <div>
      <span>Nombres(s):</span>
      <input id="upd_name" name="upd_name" type="text" autocomplete="off" maxlength="20" value="${(row!=null)? row.childNodes[2].innerHTML:''}"/>
      <hint id="wrong_name"></hint>
  </div>
  <div>
      <span>Apellido(s):</span>
      <input id="upd_last" name="upd_last" type="text" autocomplete="off" maxlength="20" value="${(row!=null)? row.childNodes[3].innerHTML:''}"/>
      <hint id="wrong_last"></hint>
  </div>
  <div>
      <span>Contraseña:</span>
      <input id="upd_pass" name="upd_pass" type="password" autocomplete="off"${(row!=null)? ' placeholder="(Sin modificaciones)':''}"/>
      <hint id="wrong_pass"></hint>
  </div>
  <div>
      <span>Privilegios:</span>
      <select name="upd_lvl" id="upd_lvl">
          <option value="3"${(row!=null && row.childNodes[4].getAttribute("userlvl") == "3")? ' selected value':'-'}>Solo ver</option>
          <option value="2"${(row!=null && row.childNodes[4].getAttribute("userlvl") == "2")? ' selected value':'-'}>Ver y Editar</option>
          <option value="4"${(row!=null && row.childNodes[4].getAttribute("userlvl") == "4")? ' selected value':'-'}>Portería</option>
          <option value="1"${(row!=null && row.childNodes[4].getAttribute("userlvl") == "1")? ' selected value':'-'}>Administrador</option>
      </select>
      <button class="tabpanelbuttons ok" onclick="saveCreateUpdateUser(document.getElementById('upd_user'), document.getElementById('upd_name'), document.getElementById('upd_last'), document.getElementById('upd_pass'), document.getElementById('upd_id')); return false;">${(row!=null)?'Actualizar':'Crear Usuario'}</button>
      <button class="tabpanelbuttons no" onclick="closePrompt(document.querySelector('.floating-panel')); return false;">Cancelar</button>
  </div></form>`;
  document.getElementById("darkopacity").classList.remove("hide");
  document.getElementById("darkopacity").classList.add("show");
  panel.classList.remove("hide");
  panel.classList.add("show");
  
  loadingAnimation(false);
}

function promptDeleteUser(panel, row) {
  loadingAnimation(true);

  //Si recibe un row, entonces es modificar. Si no lo recibe, es añadir
  panel.classList.add("delete");
  panel.innerHTML = `<form name="del_user" method="POST">
  <h3>¿Seguro que quiere deshabilitar al usuario ${row.childNodes[2].innerHTML} // ${row.childNodes[1].innerHTML}?</h3>
  <input type="hidden" name="function" value="del_user"/>
  <input type="hidden" name="del_id" value="${row.childNodes[0].innerHTML}"/>
  <div>
      <button class="tabpanelbuttons ok" type="submit">Sí</button>
      <button class="tabpanelbuttons no" onclick="closePrompt(document.querySelector('.floating-panel')); return false;">No</button>
  </div></form>`;
  document.getElementById("darkopacity").classList.remove("hide");
  document.getElementById("darkopacity").classList.add("show");
  panel.classList.remove("hide");
  panel.classList.add("show");

  loadingAnimation(false);
}

function promptRestoreUser(panel, row) {
  loadingAnimation(true);

  //Si recibe un row, entonces es modificar. Si no lo recibe, es añadir
  panel.classList.add("delete");
  panel.innerHTML = `<form name="res_user" method="POST">
  <h3>¿Seguro que quiere restaurar a ${row.childNodes[2].innerHTML} // ${row.childNodes[1].innerHTML}?</h3>
  <input type="hidden" name="function" value="res_user"/>
  <input type="hidden" name="res_id" value="${row.childNodes[0].innerHTML}"/>
  <div>
      <button class="tabpanelbuttons ok" type="submit">Sí</button>
      <button class="tabpanelbuttons no" onclick="closePrompt(document.querySelector('.floating-panel')); return false;">No</button>
  </div></form>`;
  document.getElementById("darkopacity").classList.remove("hide");
  document.getElementById("darkopacity").classList.add("show");
  panel.classList.remove("hide");
  panel.classList.add("show");

  loadingAnimation(false);
}

function promptLeave(panel) {
  loadingAnimation(true);

  document.getElementById("darkopacity").classList.remove("hide");
  document.getElementById("darkopacity").classList.add("show");
  panel.classList.remove("hide");
  panel.classList.add("show");

  loadingAnimation(false);
}

function closePrompt (panel, deleteHTML) {
  panel.classList.remove("delete");
  if(document.getElementById("darkopacity_2") != null && document.getElementById("darkopacity_2").classList.contains("show")) {
    document.getElementById("darkopacity_2").classList.remove("show");
    document.getElementById("darkopacity_2").classList.add("hide")
  } else {
    document.getElementById("darkopacity").classList.remove("show");
    document.getElementById("darkopacity").classList.add("hide");
  }
  panel.classList.remove("show");
  panel.classList.add("hide");
  if(typeof deleteHTML === 'undefined' || deleteHTML == true) {panel.innerHTML='';}
}

function saveCreateUpdateUser (upd_user, upd_name, upd_last, upd_pass, upd_id) {
  msg_user = document.getElementById("wrong_user");
  msg_name = document.getElementById("wrong_name");
  msg_last = document.getElementById("wrong_last");
  msg_pass = document.getElementById("wrong_pass");
  msg_user.innerHTML = '';
  msg_name.innerHTML = '';
  msg_last.innerHTML = '';
  msg_pass.innerHTML = '';
  upd_user.value = upd_user.value.trim().replace(/\s+/g,' ');
  upd_name.value = upd_name.value.trim().replace(/\s+/g,' ');
  upd_last.value = upd_last.value.trim().replace(/\s+/g,' ');
  var flag = false;
  var position;
  if(upd_id.value == '-') {
    if(upd_pass.value == '') {msg_pass.innerHTML = '*Este campo no puede quedar vacío.'; msg_pass.classList.remove("green"); flag = true; position = 4;}
  }
  if(upd_pass.value.replace(/[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜ\u00f1\u00d1_0-9-]/g, '').length != 0) {msg_pass.innerHTML = '*Solo se permiten letras, números, "_" y "-".'; msg_pass.classList.remove("green"); flag = true; position = 4;}
  if(upd_last.value == '') {msg_last.innerHTML = '*Este campo no puede quedar vacío.'; msg_last.classList.remove("green"); flag = true; position = 3;}
  if(upd_last.value.replace(/[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜ\u00f1\u00d1 ]/g, '').length != 0) {msg_last.innerHTML = '*Solo se permiten letras y espacios.'; msg_last.classList.remove("green"); flag = true; position = 3;}
  if(upd_name.value == '') {msg_name.innerHTML = '*Este campo no puede quedar vacío.'; msg_name.classList.remove("green"); flag = true; position = 2;}
  if(upd_name.value.replace(/[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜ\u00f1\u00d1 ]/g, '').length != 0) {msg_name.innerHTML = '*Solo se permiten letras y espacios.'; msg_name.classList.remove("green"); flag = true; position = 2;}
  if(upd_user.value == '') {msg_user.innerHTML = '*Este campo no puede quedar vacío.'; msg_user.classList.remove("green"); flag = true; position = 1;}
  if(upd_user.value.replace(/[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜ\u00f1\u00d1_0-9-]/g, '').length != 0) {msg_user.innerHTML = '*Solo se permiten letras, números, "_" y "-".'; msg_user.classList.remove("green"); flag = true; position = 1;}
  
  //Check if user exists
  let data = new FormData();
  data.append('function','check_if_user_exists');
  data.append('upd_user', upd_user.value);
  fetch('tab_adm_functions.php', {
    method: "POST",
    body: data
  }).then (function (response){
      if(response.ok){
        return response.text();
      } else {
        throw "Error en la llamada";
      }
  })
  .then (function(data){
    upd_user.value = upd_user.value.trim().replace(/\s+/g,' ');
    if(data == '-1'){
      upd_user.value = '';
      flag = true;
    }
    
    if(data > 0 && upd_user.value.toLowerCase() != upd_user.getAttribute('oldvalue')) {
      document.getElementById("wrong_user").innerHTML = (msg_user.innerHTML == '')? '*El nombre de usuario ya existe.' : '';
      position = 1;
      flag = true;
    }
    if (flag) {
      //Flag es true cuando hubo un error. Finalizar la función haciendo los cambios estéticos (hints) y focus
      switch (position) {
        case 1: upd_user.focus(); break;
        case 2: upd_name.focus(); break;
        case 3: upd_last.focus(); break;
        case 4: upd_pass.focus(); break;
        default: break;
      }
      return;
    } else {
      //Flag es false cuando los inputs procedieron
      if(upd_id.value != '-') {
        //Update
        //console.log('Actualizar');
        document.add_upd_user.submit();
      } else {
        //Add
        //console.log('Añadir');
        document.add_upd_user.submit();
      }
    }
  })
  .catch (function(error){
      console.log(error);
  });
}

//Cargar la tabla de administración de usuarios
function loadTableData(user_data,table_body,flag) {
  table_body_html = '';
  let data = new FormData();
  data.append('function','check_session_id');
  fetch('tab_adm_functions.php', {
    method: "POST",
    body: data
  }).then (function (response){
      if(response.ok){
        return response.text();
      } else {
        throw "Error en la llamada";
      }
  })
  .then (function(data){
    for(let user of user_data) {
      switch (user.user_level) {
        case '1': user.user_level = '1">Administrador'; break;
        case '2': user.user_level = '2">Ver y Editar'; break;
        case '3': user.user_level = '3">Solo ver'; break;
        case '4': user.user_level = '4">Portería'; break;
        default: user.user_level = '">No definido'; break;
      }
      //Si no se declara/especifica flag, o flag es true, entonces que los botones sean editar, eliminar
      if(typeof flag == 'undefined' || flag == true){
        html_buttons = `<button 
            id="td_edit_btn" 
            class="tabpanelbuttons small neutral show" 
            onclick="promptCreateUpdateUser(document.querySelector('.floating-panel'),this.parentNode.parentNode.parentNode)">Editar</button>
          <button 
            id="td_del_btn" 
            class="tabpanelbuttons small no show" 
            onclick="promptDeleteUser(document.querySelector('.floating-panel'),this.parentNode.parentNode.parentNode)">Deshabilitar</button>`;  
      } else {
        //Pero si se declara como false, que el único botón sea restaurar
        html_buttons = `<button 
          id="td_edit_btn" 
          class="tabpanelbuttons small neutral show" 
          onclick="promptRestoreUser(document.querySelector('.floating-panel'),this.parentNode.parentNode.parentNode)">Restaurar</button>`;
      }
      table_body_html += `<tr><td>${user.id_user}</td><td>${user.user}</td><td>${user.name}</td><td>${user.last_name}</td><td userlvl="${user.user_level}</td><td><div class="flex-justify-around">
            ${(user.id_user == 1 || user.id_user == data)? '': html_buttons}
            </div></td>
        <td>${(user.last_conn_1 != null && user.last_conn_1 != '-' && user.last_conn_1 != '')? printFullDateAndTime(new Date(user.last_conn_1.slice(0, -3))): '-'}</td>
        <td>${(user.last_conn_2 != null && user.last_conn_2 != '-' && user.last_conn_2 != '')? printFullDateAndTime(new Date(user.last_conn_2.slice(0, -3))): '-'}</td>
        <td>${(user.last_conn_3 != null && user.last_conn_3 != '-' && user.last_conn_3 != '')? printFullDateAndTime(new Date(user.last_conn_3.slice(0, -3))): '-'}</td>
        <td>${(user.last_conn_4 != null && user.last_conn_4 != '-' && user.last_conn_4 != '')? printFullDateAndTime(new Date(user.last_conn_4.slice(0, -3))): '-'}</td></tr>`
    }
    table_body.innerHTML = table_body_html;
  })
  .catch (function(error){
      console.log(error);
  });
}

function switchEditFields(elements) {
  for (i = 0; i < elements.length; i++) {
    elements[i].disabled = !(elements[i].disabled)
    if(elements[0].disabled == true) elements[i].value = '';
  }
  if(elements[0].disabled == true) elements[0].value = elements[0].getAttribute('oldvalue');
}

function resetEditFields(elements) {
  for (i = 0; i < elements.length; i++) {
    elements[i].value = elements[i].getAttribute("oldvalue");
  }
}

//Para configurar el comportamiento del botón submit
function switchSubmitButton(file_input, submit_btn, file_name_box, arr_radio){
  if (file_input.files.length == 0) {
    file_name_box.placeholder = 'archivo.csv';
    submit_btn.disabled = true;
  } else {
    var all_rad_false = true;
    file_name_box.placeholder = file_input.files[0].name;
    for (var i = 0; i < arr_radio.length; i++) {
      (arr_radio[i].checked == false)? {}: all_rad_false = false;
    }
    if(all_rad_false) {
      submit_btn.disabled = true;
    } else {
      submit_btn.disabled = false;
    }
  }
}
  
//Sidebar handler with Esc key
document.onkeydown = function(evt) {
  keyNav(evt);
}

/*Open sidebar setting the desired width*/
function openNav() {
  is_sidebar_open=true;
  document.getElementById("mySidebar").style.width = "275px";
  document.getElementById("main").style.marginLeft = "275px";  
}
  
/* Set the width of the sidebar to 0 and the left margin of the page content to 0 */
function closeNav() {
  is_sidebar_open=false;
  document.getElementById("mySidebar").style.width = "0";
  document.getElementById("main").style.marginLeft = "0";
} 

//Handle sidebar with esc key.
function keyNav (evt) {
  evt = evt || window.event;
  if (evt.keyCode == 27) {
    dynamicOpenCloseNav();
  }
}

function dynamicOpenCloseNav() {
  if(is_sidebar_open){closeNav();} else openNav();
}

function focusOutBar() {
  for (i=0; i<z_index_elements.length; i++) {
    document.getElementById(z_index_elements[i]).style.zIndex = "0";
  }
  for (i=0; i<z_index_childs.length; i++) {
    document.getElementById(z_index_childs[i]).style.display = "none";
  }
  document.getElementById("darkopacity").classList.remove("show");
  document.getElementById("darkopacity").classList.add("hide");
  //document.getElementById("resultados_busqueda").innerHTML = '';
  document.getElementById('resultados_busqueda').innerHTML = '';
  z_index_elements.length = 0;
  z_index_childs.length = 0;  
}


//Tab Handler on search results
function openTab(evt, tabName) {
  var i, tabcontent, tablinks;
  //Buscamos todos los contenedores de los tabs
  tabcontent = document.getElementsByClassName("tab-content-container");
  for (i = 0; i < tabcontent.length; i++) {
    //Los ocultamos
    tabcontent[i].style.display = "none";
  }
  //Buscamos todos los botones/tabs
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    //Y los desactivamos cambiando su clase de active a ""
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  //Buscamos el contenedor correspondiente al botón/tab seleccionado y lo hacemos visible
  document.getElementById(tabName).style.display = "flex";
  //Hacemos que el botón que apretamos se quede activo añadiendo active a su clase
  evt.currentTarget.className += " active";
}

//Search on Enter Press
function onEnter(event){
  if(event.keyCode === 13 && document.querySelectorAll('.search-drop-tabs').length > 0){
    document.querySelectorAll('.search-drop-tabs')[0].click();
    focusOutBar();
    document.activeElement.blur();
  }
}

//LiveSearch on tab_search.php
function livesearch(input_searchbox,search_results) {
  //Si el encabezado estaba activado para editar, lo cancelamos para poder realizar la búsqueda en vivo
  if(document.getElementById("resultado_nombre").tagName == 'INPUT' || document.getElementById("resultado_dni").tagName == 'INPUT' || document.getElementById("resultado_plh").tagName == 'INPUT') {
    resetFields(document.getElementsByClassName('search-details-being-edited'), [document.getElementById("edit_header_button"), document.getElementById("no_header_button"), document.getElementById("ok_header_button")]);
  }
  
  if(input_searchbox.value.length>0) {
    current_timestamp = new Date(current_date_on_search[0], month_list.indexOf(current_date_on_search[1]),1);
    let data = new FormData();
    data.append('data_sent',input_searchbox.value);
    data.append('date_received', current_timestamp.getTime());
    data.append('function', 'live_search');
    fetch('tab_search_functions.php', {
        method: "POST",
        body: data
    }).then (function (response){
        if(response.ok){
            return response.text();
        } else {
            throw "Error en la llamada";
        }
    })
    .then (function(data){
        search_results.innerHTML = data;
    })
    .catch (function(error){
        console.log(error);
    });

    //Mostrar los divs de resultados (quitarles el display: none)   
    document.getElementById("search-drop-results-container").style.display = "flex";

  } else {
    search_results.innerHTML = '';
    document.getElementById("search-drop-results-container").style.display = "none";
  }
}

//Click on results for more details, get bd data
function livesearch_show_details(id_trabajador,result_row,date, is_update) {
  //is_update es un argumento opcional, para indicar si la búsqueda está siendo llamada como producto de una actualización o edición de datos (y, por tanto, para
  //mostrar los cambios si estos son exitosos, se requiere hacer un refresh de la data mostrada)

  loadLastTimeUpdatedReloj();

  document.getElementById("darkopacity_above_all").classList.remove('hide');
  document.getElementById("darkopacity_above_all").classList.add('show');
  let data = new FormData();
  data.append('data_sent',id_trabajador);
  data.append('date_asistencia','@' + date/1000);
  data.append('function', 'search_details');
    fetch('tab_search_functions.php', {
      method: "POST",
      body: data
  }).then (function (response){
      if(response.ok){
          return response.text();
      } else {
          throw "Error en la llamada";
      }
  })
  .then (function(data){
    //JSON.parse(data) transforma el objeto recibido de php, en un javascript object, listo para ser manipulado/recorrido
    data = JSON.parse(data);
    console.log('LIVESEARCH Show Details');
    console.log(data);
    document.getElementById("profileChar").innerHTML = data.resultados_detalles.nombre[0];
    document.getElementById("resultado_nombre").innerHTML = data.resultados_detalles.nombre;
    document.getElementById("resultado_dni").innerHTML = data.resultados_detalles.dni;
    document.getElementById("resultado_id_b").innerHTML = data.resultados_detalles.id_trabajador;
    document.getElementById("resultado_tarjeta").innerHTML = data.resultados_detalles.nro_tarjeta;
    document.getElementById("resultado_biostar_grupo").innerHTML = data.resultados_detalles.biostar_grupo;
    document.getElementById("resultado_cargo").innerHTML = data.resultados_detalles.cargo;
    document.getElementById("resultado_area").innerHTML = data.resultados_detalles.nombre_area;
    document.getElementById("resultado_plh").innerHTML = data.resultados_detalles.plh;
    document.getElementById("resultado_estado").innerHTML = data.resultados_detalles.nombre_estado;

    //Actualizando los valores del resumen de horas 
    for (var i = 0; i < document.querySelectorAll('.total-h-mes').length; i++) {
      document.querySelectorAll('.total-h-mes')[i].innerHTML = (data.resultados_h_mensual)? "<span>H. presen.: " 
      + intervalToDays(data.resultados_h_mensual.total_h_mes) + " // " + data.resultados_h_mensual.total_h_mes.split(":")[0] + "h " + data.resultados_h_mensual.total_h_mes.split(":")[1] + "m</span><span>" 
      + ((data.resultados_h_mensual.acum_dif_mes.split(":")[0][0]=='-')? "Debe: " : "H. a favor: ")
      + data.resultados_h_mensual.acum_dif_mes.split(":")[0].replace('-','') + "h " + data.resultados_h_mensual.acum_dif_mes.split(":")[1] + "m</span><span>Tard.: " 
      + data.resultados_h_mensual.acum_tardanzas + " / Inasis.: " + data.resultados_h_mensual.acum_inasistencias + "</span>": "";
      if(data.resultados_h_mensual) {document.getElementById('marcas_reloj_switch').classList.remove('hide');} else{document.getElementById('marcas_reloj_switch').classList.add('hide');}
    }
    var date_selected = new Date(date);
    //current_id será false la primera vez que se cargue la página, así que updateTab no hará nada.
    current_id_on_search_details = data.resultados_detalles.id_trabajador;

    console.log('Primera Data');
    console.log(data);

    if(typeof is_update == 'undefined' || is_update == false){
      updateTabAsistencias(data.resultados_marcas_biostar, data.resultados_calculo_horas, date_selected);
    } else {
      updateTabAsistencias(data.resultados_marcas_biostar, data.resultados_calculo_horas, date_selected, is_update);
    }

    document.getElementById("darkopacity_above_all").classList.remove('show');
    document.getElementById("darkopacity_above_all").classList.add('hide');
  })
  .catch (function(error){
      console.log(error);
  });        
  
  //Estilo visual al dar clic en un resultado  
  results_list = document.getElementsByClassName("search-drop-tabs");
  for (i = 0; i < results_list.length; i++) {
    results_list[i].className = results_list[i].className.replace(" active", "");
  }
  (result_row)? result_row.className += " active" : {};
}   

function promptQuickDetailsOfDay(panel, iDay, sIdSelected){
  //Mostrar M1-8
  //Mostrar las Autorizaciones de existir
  //Mostrar entrada y salida
  date_timestamp = new Date(current_date_on_search[0], month_list.indexOf(current_date_on_search[1]), iDay).getTime();
  let data = new FormData();
  data.append('function','day_quick_details');
  data.append('id_sent',sIdSelected);
  data.append('date_sent',date_timestamp);
  fetch('tab_search_functions.php', {
    method: "POST",
    body: data
  }).then (function (response){
      if(response.ok){
        return response.text();
      } else {
        throw "Error en la llamada";
      }
  })
  .then (function(data){
    var debe_h = false;
    data = JSON.parse(data);
    console.log(data);
    autoriz_buttons_html = ''
    if(typeof data.autoriz_salida_h != 'undefined'){
      for(i = 0; i < data.autoriz_salida_h.length; i++){
        autoriz_buttons_html += `<button class="tabpanelbuttons neutral" 
        onclick="promptAddUpdLeavingAuth(document.querySelector('.floating-panel.second'), this, ['1',document.getElementById('resultado_nombre').innerHTML, '${data.autoriz_salida_h[i].h_salida}', '${data.autoriz_salida_h[i].h_retorno}', '${data.autoriz_salida_h[i].duracion}', '${data.autoriz_salida_h[i].motivo}', '${data.autoriz_salida_h[i].descripcion}']); 
        return false;"><div>
        <svg alignment-baseline="baseline" width="20" height="20" fill="#ffffff" class="bi bi-person-plus-fill" viewBox="2 0 16 16">
          <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
          <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
        </svg>Ver Autoriz. #${i+1}</div></button>`;
      }
    }

    if(typeof data.marcas_biostar == 'undefined'){
      var marca_1 = '--:--';
      var marca_2 = '--:--';
      var marca_3 = '--:--';
      var marca_4 = '--:--';
      var marca_5 = '--:--';
      var marca_6 = '--:--';
      var marca_7 = '--:--';
      var marca_8 = '--:--';
    } else {
      var marca_1 = data.marcas_biostar.marca_1;
      var marca_2 = data.marcas_biostar.marca_2;
      var marca_3 = data.marcas_biostar.marca_3;
      var marca_4 = data.marcas_biostar.marca_4;
      var marca_5 = data.marcas_biostar.marca_5;
      var marca_6 = data.marcas_biostar.marca_6;
      var marca_7 = data.marcas_biostar.marca_7;
      var marca_8 = data.marcas_biostar.marca_8;
      
    }
    console.log(data.calculo_horas.dif_h_diario[0]=='-');
    if(data.calculo_horas.dif_h_diario[0]=='-') debe_h = true;
    data.calculo_horas.dif_h_diario = data.calculo_horas.dif_h_diario.replace("-",'')
    panel.innerHTML = `<form name="quick_details_calc_h" id="quick_details_calc_h" method="POST">
      <h3>Detalles de la asistencia del ${printFullDateAndTime(fixedLocalTimezone(new Date(data.calculo_horas.fecha).getTime()),false)}</h3>
      <div id="quick_details_panel">
        <div>  
          <span>Fuente: ${data.calculo_horas.fuente}</span>
          <span>Entrada: ${data.calculo_horas.entrada}</span>
          <span>Salida: ${data.calculo_horas.salida}</span>
          <span>Total: ${(data.calculo_horas.total == '00:00')? 'Sin calcular': data.calculo_horas.total.split(":")[0] + 'h ' + data.calculo_horas.total.split(":")[1] + 'm'}</span>
          <span>Obs. Reloj: ${data.calculo_horas.marcas_obs}</span>
          <span>Licencia: ${data.calculo_horas.nombre_lic}</span>
          <span>Observación: ${data.calculo_horas.obs_lic}</span>
          <span>${(data.calculo_horas.total == '00:00')? 'Total de h. sin calcular': 'Trabajó ' + ((data.calculo_horas.dif_h_diario.split(":")[0] != '00')? data.calculo_horas.dif_h_diario.split(":")[0] + 'h ': '') + data.calculo_horas.dif_h_diario.split(":")[1] + 'm ' + ((debe_h)? 'menos': 'más')}</span>
          <span>Tardanzas del día: ${(data.calculo_horas.tardanzas == '-1')? 'INASISTENCIA': (data.calculo_horas.tardanzas == '0')? '': data.calculo_horas.tardanzas}</span>
        </div>
        <div>
          <span>Marcas del Reloj</span>
          <ol>
            <li>${marca_1}</li>
            <li>${marca_2}</li>
            <li>${marca_3}</li>
            <li>${marca_4}</li>
            <li>${marca_5}</li>
            <li>${marca_6}</li>
            <li>${marca_7}</li>
            <li>${marca_8}</li>
          </ol>
          ${autoriz_buttons_html} 
        </div>
      </div>
      <div>
          <button class="tabpanelbuttons ok" onclick="return false;" disabled>Guardar cambios</button>
          <button class="tabpanelbuttons no" onclick="closePrompt(document.querySelector('.floating-panel')); return false;">Cerrar</button>
      </div></form>`;
    document.getElementById("darkopacity").classList.remove("hide");
    document.getElementById("darkopacity").classList.add("show");
    panel.classList.remove("hide");
    panel.classList.add("show");
    console.log(panel.offsetHeight);
    panel.style.marginTop = (panel.offsetHeight / -2) + 'px';
  })
  .catch (function(error){
      console.log(error);
  });
}

function promptChangesHistory(panel, iDay, sIdSelected){
  //Mostrar M1-8
  //Mostrar las Autorizaciones de existir
  //Mostrar entrada y salida
  date_timestamp = new Date(current_date_on_search[0], month_list.indexOf(current_date_on_search[1]), iDay).getTime();
  let data = new FormData();
  data.append('function','day_change_history');
  data.append('id_sent',sIdSelected);
  data.append('date_sent',date_timestamp);
  fetch('tab_search_functions.php', {
    method: "POST",
    body: data
  }).then (function (response){
      if(response.ok){
        return response.text();
      } else {
        throw "Error en la llamada";
      }
  })
  .then (function(data){
    var debe_h = false;
    data = JSON.parse(data);
    console.log(data);
    autoriz_buttons_html = ''
    if(typeof data.autoriz_salida_h != 'undefined'){
      for(i = 0; i < data.autoriz_salida_h.length; i++){
        autoriz_buttons_html += `<button class="tabpanelbuttons neutral" 
        onclick="promptAddUpdLeavingAuth(document.querySelector('.floating-panel.second'), this, ['1',document.getElementById('resultado_nombre').innerHTML, '${data.autoriz_salida_h[i].h_salida}', '${data.autoriz_salida_h[i].h_retorno}', '${data.autoriz_salida_h[i].duracion}', '${data.autoriz_salida_h[i].motivo}', '${data.autoriz_salida_h[i].descripcion}']); 
        return false;"><div>
        <svg alignment-baseline="baseline" width="20" height="20" fill="#ffffff" class="bi bi-person-plus-fill" viewBox="2 0 16 16">
          <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
          <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
        </svg>Ver Autoriz. #${i+1}</div></button>`;
      }
    }
    
    if(data.calculo_horas.dif_h_diario[0]=='-') debe_h = true;
    data.calculo_horas.dif_h_diario = data.calculo_horas.dif_h_diario.replace("-",'')
    panel.innerHTML = `<form name="quick_details_calc_h" id="quick_details_calc_h" method="POST">
      <h3>Detalles de la asistencia del ${printFullDateAndTime(fixedLocalTimezone(new Date(data.calculo_horas.fecha).getTime()),false)}</h3>
      <div id="quick_details_panel">
        <div>  
          <span>Entrada: ${data.calculo_horas.entrada}</span>
          <span>Salida: ${data.calculo_horas.salida}</span>
          <span>Total: ${(data.calculo_horas.total == '00:00')? 'Sin calcular': data.calculo_horas.total.split(":")[0] + 'h ' + data.calculo_horas.total.split(":")[1] + 'm'}</span>
          <span>Obs. Reloj: ${data.calculo_horas.observacion}</span>
          <span>Licencia: ${lic_list[data.calculo_horas.id_lic]}</span>
          <span>Observación: ${data.calculo_horas.obs_lic}</span>
          <span>${(data.calculo_horas.total == '00:00')? 'Sin calcular': 'Trabajó ' + ((data.calculo_horas.dif_h_diario.split(":")[0] != '00')? data.calculo_horas.dif_h_diario.split(":")[0] + 'h ': '') + data.calculo_horas.dif_h_diario.split(":")[1] + 'm ' + ((debe_h)? 'menos': 'más')}</span>
          <span>Tardanzas del día: ${(data.calculo_horas.tardanzas == '-1')? 'INASISTENCIA': (data.calculo_horas.tardanzas == '0')? '': data.calculo_horas.tardanzas}</span>
        </div>
        <div>
          <span>Marcas del Reloj</span>
          <ol>
            <li>${data.marcas_biostar.marca_1}</li>
            <li>${data.marcas_biostar.marca_2}</li>
            <li>${data.marcas_biostar.marca_3}</li>
            <li>${data.marcas_biostar.marca_4}</li>
            <li>${data.marcas_biostar.marca_5}</li>
            <li>${data.marcas_biostar.marca_6}</li>
            <li>${data.marcas_biostar.marca_7}</li>
            <li>${data.marcas_biostar.marca_8}</li>
          </ol>
          ${autoriz_buttons_html} 
        </div>
        
      </div>
      <div>
          <button class="tabpanelbuttons ok" onclick="return false;" disabled>Guardar cambios</button>
          <button class="tabpanelbuttons no" onclick="closePrompt(document.querySelector('.floating-panel')); return false;">Cerrar</button>
      </div></form>`;
    document.getElementById("darkopacity").classList.remove("hide");
    document.getElementById("darkopacity").classList.add("show");
    panel.classList.remove("hide");
    panel.classList.add("show");
    console.log(panel.offsetHeight);
    panel.style.marginTop = (panel.offsetHeight / -2) + 'px';
  })
  .catch (function(error){
      console.log(error);
  });
}

//Inicialmente era: marcas_biostar, calculo horas, fecha seleccionada
//Ahora es: Calculo horas, fecha seleccionada
function updateTabAsistencias (resultados_asistencias,resultados_calculo_horas,selected_date, is_update){
    //Revisar privilegios
    let data = new FormData();
    data.append('function','current_user_lvl');
    fetch('tab_search_functions.php', {
      method: "POST",
      body: data
    }).then (function (response){
        if(response.ok){
          return response.text();
        } else {
          throw "Error en la llamada";
        }
    })
    .then (function(data){
      //Habilitamos el botón de editar si es que es la primera búsqueda y existen privilegios de Administrador, o Ver y Editar
      if(document.getElementById('edit_header_button').disabled == true && data <= 2) {
        document.getElementById('edit_header_button').disabled = false;
        document.getElementById('edit_header_button').classList.remove("hide");
      }

     
      if(typeof resultados_calculo_horas != 'undefined' && Array.isArray(resultados_calculo_horas) && resultados_calculo_horas.length){
        //Encapsulo todo el HTML de la tabla de asistencias, en table_html.
        var table_resumen_html = '<thead><tr>';
        var table_calculo_html = `<thead>
        <tr>
          <th>Día</th>
          <th>Fecha</th>
          <th>Entrada</th>
          <th>Salida</th>
          <th>Total</th>
          <th>Reglam.<br>de<br>Tard.</th>
          <th>Estado<br>de<br>Reloj</th>
          <th>Lic.</th>
          <th>Mod.</th> 
          <th>Comentarios</th>  
          <th>Hojas<br>de<br>Asis.</th>  
          <th>Autoriz.<br>de<br>Salida</th>  
          <th>Fuente</th>
          <th class="actions">Acción</th>
          <th>Historial</th>
          <th class ="col-marcas ${(show_marcas_reloj)? '': 'hide'}">M1</th>
          <th class ="col-marcas ${(show_marcas_reloj)? '': 'hide'}">M2</th>
          <th class ="col-marcas ${(show_marcas_reloj)? '': 'hide'}">M3</th>
          <th class ="col-marcas ${(show_marcas_reloj)? '': 'hide'}">M4</th>
          <th class ="col-marcas ${(show_marcas_reloj)? '': 'hide'}">M5</th>
          <th class ="col-marcas ${(show_marcas_reloj)? '': 'hide'}">M6</th>
          <th class ="col-marcas ${(show_marcas_reloj)? '': 'hide'}">M7</th>
          <th class ="col-marcas ${(show_marcas_reloj)? '': 'hide'}">M8</th>
        </tr></thead>`;
        for (var i = 0; i < resultados_calculo_horas.length; i++) {
          table_resumen_html += '<th class="small">' + resultados_calculo_horas[i].fecha.split("-")[0] + '</th>';
          //table_calculo_html += '<th>' + resultados_calculo_horas[i].fecha.slice(8,10) + '</th>';
        }
        table_calculo_html += '<tbody>';
        table_resumen_html += '</tr></thead><tr>';
        table_resumen_second_row = '<tr>';
        for (i = 0; i < resultados_calculo_horas.length; i++) {
          flag_ok_sr = true;
          table_calculo_html += '<tr';
          var row_html = '';
          var cell_class = '';
          var cell_class_aux = '';
          var aux_val = '';
          //Obtenemos la fecha de cada fila, pero llega en -5, así que la convertimos en timestamp, la arreglamos, y la volvemos fecha de nuevo
          queried_date = fixedLocalTimezone(new Date(resultados_calculo_horas[i].fecha).getTime());
          
          switch (resultados_calculo_horas[i].marcas_obs) {
            case 'NME': cell_class = ' nme'; flag_ok_sr = false; break;
            case 'NMS': cell_class = ' nms'; flag_ok_sr = false; break;
            case 'SR': cell_class = ' sr'; break;
            //case 'OJO': cell_class = 'ojo'; resultados_calculo_horas[j][key] = '!!!'; break;
            case 'REQUIERE REVISIÓN': cell_class = ' ojo'; flag_ok_sr = false; break;
            case 'REV': cell_class = ' rev'; flag_ok_sr = false; break;
            default: break;
          }
          //Dado que ya no uso REV, tengo que usar este flag con Edición manual en fuente
          if(resultados_calculo_horas[i].fuente == 'Edición manual') {cell_class = ' rev'; flag_ok_sr = false;}
          if(resultados_calculo_horas[i].fuente == 'Edición manual' && resultados_calculo_horas[i].marcas_obs == "REQUIERE REVISIÓN") {resultados_calculo_horas[i].marcas_obs = "REV";}

          cell_class_aux = cell_class;

          switch (fixedLocalTimezone(new Date(resultados_calculo_horas[i].fecha).getTime()).getDay()) {
            case 0: case 6: cell_class += ' weekend'; break;
            default: break;
          }  
          table_calculo_html += ' class = "normal' + ((cell_class == '')? '">': '' + cell_class + '">');

          //var has_been_modified = (resultados_calculo_horas[i].last_modif_1 != null && typeof resultados_calculo_horas[i].last_modif_1 != null);

          for (var key in resultados_calculo_horas[i]) {
            //Un reset de la clase
            cell_class = cell_class_aux;
            switch (key) {
              case 'fecha': cell_class += ' day'; break;
              case 'day_of_week': cell_class += ' day'; break;
              case 'entrada': cell_class += (resultados_calculo_horas[i].tar_ina != '-' || resultados_calculo_horas[i].tar_ina.length == 0)? ' late"': '"'; break;
              case 'marca_1': case 'marca_2': case 'marca_3': case 'marca_4': 
              case 'marca_5': case 'marca_6': case 'marca_7': case 'marca_8': {
                cell_class += ` col-marcas ${(show_marcas_reloj)? '': 'hide'}`;
                break;
              }
              case 'fecha_oculta': continue;
              default: break;
            }
            row_html += `<td onmouseover="highlightRow(this)" onmouseout="outHighlightRow(this)" class="${cell_class}" col="${resultados_calculo_horas[i].fecha.split("-")[0]}">${resultados_calculo_horas[i][key]}\t</td>`;
          }

          //Update a horas de trabajo resumidas
          aux_val = resultados_calculo_horas[i].total.split(":");
          
          table_resumen_html += '<td onclick="promptQuickDetailsOfDay(document.querySelector(\'.floating-panel\'), parseInt(this.getAttribute(\'col\')), current_id_on_search_details);" class="' + cell_class_aux + '" col="' + resultados_calculo_horas[i].fecha.split("-")[0] + '">' + resultados_calculo_horas[i].total + '\t' + '</td>';
          table_resumen_second_row += '<td class="' + cell_class_aux + ((resultados_calculo_horas[i].tar_ina != '-' || resultados_calculo_horas[i].tar_ina.length == 0)? ' late': '') + '" col="' + resultados_calculo_horas[i].fecha.split("-")[0] + '">T: ' + ((resultados_calculo_horas[i].tar_ina != 'INASISTENCIA')? resultados_calculo_horas[i].tar_ina: 'In.') + '\t' + '</td>';
          table_calculo_html += row_html + '</tr>';    

        } 

        table_resumen_html += '</tr>' + table_resumen_second_row + '</tr></tbody>';
        table_calculo_html += '</tbody>'; 
        //Ahora vacio table_html en la tabla_asistencias
        document.getElementById("tabla_calculo_horas").innerHTML = table_calculo_html;
        document.getElementById("tabla_resumen").innerHTML = table_resumen_html;
        //Defino el valor del botón de fecha de acuerdo a la fecha establecida
        const month_descriptions = ["enero de ", "febrero de ", "marzo de ", "abril de ", "mayo de ", "junio de ", "julio de ", "agosto de ", "septiembre de ", "octubre de ", "noviembre de ", "diciembre de "];
        //document.getElementById("month_table_to_display").innerHTML = month_descriptions[selected_date.getMonth()] + selected_date.getFullYear();
    
        for (var i = 0; i < document.querySelectorAll('.date-btn-selector').length; i++) {
          document.querySelectorAll('.date-btn-selector')[i].innerHTML = month_descriptions[selected_date.getMonth()] + selected_date.getFullYear();
        }
        showAndHideOnResults(true);
      } else {
        //document.getElementById("tab_asistencias_body").style.display = "none";
        document.getElementById("tabla_calculo_horas").innerHTML = '';
        document.getElementById("tabla_resumen").innerHTML = '';
        showAndHideOnResults(false);
      }
      generateSlider(document.querySelectorAll("#tabla_resumen > tbody > tr:first-child > td").length,document.getElementById("slider-distance"));

      if(typeof is_update == 'undefined' || is_update == false){
      } else {
        loadingAnimation(false);
      }
    })
    .catch (function(error){
        console.log(error);
    });
}

function showAndHideOnResults(result) {
  if(result == true) {
    var display = ["none", "block"];
  } else {
    var display = ["block", "none"];
  }
 
  var to_hide = document.getElementsByClassName("no-results")
  for (i = 0; i < to_hide.length; i++) {
    to_hide[i].style.display = display[0];
  }
  var to_show = document.getElementsByClassName("on-results")
  for (i = 0; i < to_hide.length; i++) {
    to_show[i].style.display = display[1];
  }  
}

function generateSlider(max, div_to_fill){
  slider_html = `
      <div>
          <div inverse-left style="width:100%;"></div>
          <div inverse-right style="width:100%;"></div>
          <div range style="left:0%;right:0%;"></div>
          <span thumb style="left:0%;"></span>
          <span thumb style="left:100%;"></span>
          <div sign style="left:0%;">
          <span id="start_value">1</span>
          </div>
          <div sign style="left:100%;">
          <span id="end_value">${max}</span>
          </div>
      </div>
      <input id="slider_start" type="range" tabindex="0" value="1" max="${max}" min="1" step="1" oninput="
      this.value=Math.min(this.value,this.parentNode.childNodes[5].value-1);
      var value=(100/(parseInt(this.max)-parseInt(this.min)))*parseInt(this.value)-(100/(parseInt(this.max)-parseInt(this.min)))*parseInt(this.min);
      var children = this.parentNode.childNodes[1].childNodes;
      children[1].style.width=value+'%';
      children[5].style.left=value+'%';
      children[7].style.left=value+'%';children[11].style.left=value+'%';
      children[11].childNodes[1].innerHTML=this.value;" />
      
      <input id="slider_end" type="range" tabindex="0" value="${max}" max="${max}" min="1" step="1" oninput="
      this.value=Math.max(this.value,this.parentNode.childNodes[3].value-(-1));
      var value=(100/(parseInt(this.max)-parseInt(this.min)))*parseInt(this.value)-(100/(parseInt(this.max)-parseInt(this.min)))*parseInt(this.min);
      var children = this.parentNode.childNodes[1].childNodes;
      children[3].style.width=(100-value)+'%';
      children[5].style.right=(100-value)+'%';
      children[9].style.left=value+'%';children[13].style.left=value+'%';
      children[13].childNodes[1].innerHTML=this.value;" />`
  div_to_fill.innerHTML = slider_html;
}

function copyTable(table,start_cell,end_cell){
	if (document.createRange && window.getSelection) {
		aux = document.createRange();
    text_to_copy = '';
    td_childs = document.querySelectorAll(`#${table.id} > tbody >tr:first-child > td`);
    console.log(td_childs);
    for (i = start_cell - 1; i < end_cell; i++){
      if((i + 1 < end_cell)) {
        console.log(td_childs[i]);
        text_to_copy += td_childs[i].innerHTML;
      } else {
        text_to_copy += td_childs[i].innerHTML.replace('\t','');
      }
    }
    //Creamos un elemento para poner el texto allí
    aux_el = document.createElement('textarea');
    aux_el.value = text_to_copy;
    //Lo ocultamos
    aux_el.style.opacity = "0";
    document.body.appendChild(aux_el);
    //Lo seleccionamos
    aux_el.select();
    //Lo copiamos
    document.execCommand('copy');
    //Eliminamos el elemento creado
    document.body.removeChild(aux_el);
    //Quitar la selección
    document.getSelection().removeAllRanges();
    document.getSelection().addRange(document.createRange());
    //Si el hint ya se está mostrando y la tabla está vacía, no mostrar ninguna animación.
    if (document.getElementById("clipboard-hint").style.animationName != "hint-up" && table.innerHTML != '') {
      document.getElementById("clipboard-hint").style.animationName = "hint-up";
      setTimeout(function(){ document.getElementById("clipboard-hint").style.animationName = "none"; }, 2000);
    }
	}
}

function invalidHour(){
  //Si el hint ya se está mostrando, no mostrar ninguna animación.
  if (document.getElementById("save-td-hint").style.animationName != "hint-up") {
    document.getElementById("save-td-hint").style.animationName = "hint-up";
    setTimeout(function(){ document.getElementById("save-td-hint").style.animationName = "none"; }, 2000);
  }    
}

//Arreglar la hora. Recibe timestamp y devuelve Date
function fixedLocalTimezone (date) {
  //console.log(new Date(date + new Date().getTimezoneOffset() * 60 * 1000));
  return (new Date(date + new Date().getTimezoneOffset() * 60 * 1000));
}

//Fn para el focus al cuadro de fecha. 1er argumento es el array de elementos para mostrar. El 2do argumento es cuantos de los primeros elementos
//serán los que siempre se muestran en pantalla, es decir, aquellos a los que no les haremos dislpay : ""
function dropListFocusIn(dropListElementsArray,i) {
  for (j=0; j<i; j++) {
    dropListElementsArray[j].style.zIndex = (document.getElementById('darkopacity_2') == null)? "10" : "20";
    z_index_elements.push(dropListElementsArray[j].id);
  }
  for (j; j<dropListElementsArray.length; j++) {
    dropListElementsArray[j].style.zIndex = (document.getElementById('darkopacity_2') == null)? "10" : "20";
    z_index_elements.push(dropListElementsArray[j].id);
    dropListElementsArray[j].style.display = "flex";
    z_index_childs.push(dropListElementsArray[j].id);
  }
  document.getElementById("darkopacity").classList.remove("hide");
  document.getElementById("darkopacity").classList.add("show");
}

//No es necesario un focusOut porque al dar clic en la capa de opacidad, esta llama a focusOut;

//Botones de meses. Update será para darle clic al mes y año
function updateMonthTable(month, year){
  const month_descriptions = ["enero de ", "febrero de ", "marzo de ", "abril de ", "mayo de ", "junio de ", "julio de ", "agosto de ", "septiembre de ", "octubre de ", "noviembre de ", "diciembre de "];
  //document.getElementById("month_table_to_display").innerHTML = month_descriptions[month_list.indexOf(month)] + year;
  for (var i = 0; i < document.querySelectorAll('.date-btn-selector').length; i++) {
    document.querySelectorAll('.date-btn-selector')[i].innerHTML = month_descriptions[month_list.indexOf(month)] + year;
  }

  //Actualizar el innerHTML = año de todos los cuadros desplegables

  for (var i = 0; i < document.querySelectorAll('.date-floating-year-middle').length; i++) {
    document.querySelectorAll('.date-floating-year-middle')[i].innerHTML = year;
  }

  //Si no se ha buscado nada aún, que no mande búsqueda (current id será false al cargar la web)
  if (current_id_on_search_details) {
    livesearch_show_details(current_id_on_search_details,false,new Date(year,month_list.indexOf(month),1));
  }

  month_buttons = document.getElementsByClassName("date-floating-tab-buttons");
  for (i = 0; i < month_buttons.length; i++) {
    month_buttons[i].className = month_buttons[i].className.replace(" active", "");
    if (month_buttons[i].getAttribute("tag") == month) month_buttons[i].className += " active";
  }
  current_date_on_search[0] = year;
  current_date_on_search[1] = month;
}

//Comportamiento de los botones de subir o bajar año
function changeYear(arrow,year) {
  year.innerHTML = parseInt(year.innerHTML) + ((arrow.getAttribute("tag")==">")? ((parseInt(year.innerHTML) < new Date().getFullYear())? 1 : 0) : ((parseInt(year.innerHTML) > 2005)? (-1) : 0));
  updateMonthTable(current_date_on_search[1], year.innerHTML);
}


//Obtener el mes y año presentes para mostrar en display por default. Aunque podría configurarse por defecto en live search details
function initializeMonthTable() {
  updateMonthTable(current_date_on_search[1],current_date_on_search[0]);
}

function livesearchWorkAreas(input_searchbox,search_results) {
  if(input_searchbox.value.length>0) {
    let data = new FormData();
    data.append('data_sent',input_searchbox.value);
    fetch('tab_rules_area_live.php', {
        method: "POST",
        body: data
    }).then (function (response){
        if(response.ok){
            return response.text();
        } else {
            throw "Error en la llamada";
        }
    })
    .then (function(data){
        search_results.innerHTML = data;
    })
    .catch (function(error){
        console.log(error);
    }); 
    search_results.style.display = "flex";
  } else {
    search_results.innerHTML = '';
    search_results.style.display = "none";
  }
}

function livesearchWorkPerson(input_searchbox,search_results) {
  if(input_searchbox.value.length>0) {
    var url = window.location.pathname;
    var filename = url.substring(url.lastIndexOf('/')+1);
    let data = new FormData();
    //Evaluamos el comportamiento de esta función dependiendo desde donde ha sido llamadoa
    switch(filename){
      case 'tab_rules.php': {
        fetch_path = 'tab_rules_person_live.php';
        break;
      }
      case 'tab_auth_salida.php': {
        fetch_path = 'tab_auth_salida_functions.php';
        data.append('function', 'live_search');
        break;
      }
      case 'tab_hoja_asis.php': {
        fetch_path = 'tab_hoja_asis_functions.php';
        data.append('function', 'live_search');
        break;
      }
      case 'tab_hoja_asis_nueva_hoja.php': {
        fetch_path = 'tab_hoja_asis_functions.php';
        if(input_searchbox.getAttribute('id') == 'row_name') {
          data.append('function', 'live_search_rows');
        } else {
          data.append('function', 'live_search');
        }
        break;
      }
      default: {
        fetch_path = ''; break;
      }
    }
    data.append('data_sent',input_searchbox.value);
    fetch(fetch_path, {
        method: "POST",
        body: data
    }).then (function (response){
        if(response.ok){
            return response.text();
        } else {
            throw "Error en la llamada";
        }
    })
    .then (function(data){
        search_results.innerHTML = data;
    })
    .catch (function(error){
        console.log(error);
    });  
    search_results.style.display = "flex";
  } else {
    search_results.innerHTML = '';
    search_results.style.display = "none";
  }
}


//My current approach on this is, conseguir todos los valores iterando los hijos del contenedor de tags
function deleteTag(tag_box) {
  //En caso de querer quitar de un array global la variable a remover 
  //var to_remove = tag_box.parentElement.getAttribute("id_area");
  tag_box.parentElement.remove();
}

//Dos argumentos: el elemento mismo, y el contenedor a donde añadirá los tags
function addTag(choice, container, type_of_tag) {
  var children = container.children;
  var flag = false;
  for (var i = 0; i < children.length; i++) {
    if (choice.getAttribute(type_of_tag) == children[i].getAttribute(type_of_tag)) {
      flag = true;
    }
  }
  (!flag)? container.innerHTML += "<div class='caja-etiqueta' " + type_of_tag + "='" + choice.getAttribute(type_of_tag) + "'><span>" + choice.innerHTML 
    + "</span><div class='vertical-divisor'></div><div class='delete_tag' onclick='deleteTag(this);'><div class='cross--45'><div class='cross-45'></div></div></div></div>": {};
}

function clearTags(container) {
  container.innerHTML = '';
}

function highlightCol(cell) {
  //getAttribute obtiene el valor en col, pero en forma de texto
  col = cell.getAttribute('col');
  collection = document.querySelectorAll('[col="' + col + '"]');
  for (var i = 0; i < collection.length; i++) {
    //Si la celda pertenece a la misma tabla, que no aplique ningún estilo.
    if(cell.parentElement.parentElement != collection[i].parentElement.parentElement) {
      current_class = cell.classList[0];
      //if(typeof cell.classList[0]!='undefined') {
      collection[i].classList.add("js-td-hightlight");
    }
  }
}

function highlightRow(cell) {
  //getAttribute obtiene el valor en col, pero en forma de texto
  col = cell.getAttribute('col');
  collection = document.querySelectorAll('[col="' + col + '"]');
  for (var i = 0; i < collection.length; i++) {
    //Si la celda pertenece a la misma tabla, que no aplique ningún estilo.

    current_class = cell.classList[0];
    //if(typeof cell.classList[0]!='undefined') {
    collection[i].classList.add("js-td-hightlight");

  }
}

function outHighlightCol(cell) {
  //getAttribute obtiene el valor en col, pero en forma de texto
  col = cell.getAttribute('col');
  collection = document.querySelectorAll('[col="' + col + '"]');
  for (var i = 0; i < collection.length; i++) {
    //Si la celda pertenece a la misma tabla, que no aplique ningún estilo.
    if(cell.parentElement.parentElement != collection[i].parentElement.parentElement) {
      current_class = cell.classList[0];
      //if(typeof cell.classList[0]!='undefined') {
      collection[i].classList.remove("js-td-hightlight");
    }
  }
}

function outHighlightRow(cell) {
  //getAttribute obtiene el valor en col, pero en forma de texto
  col = cell.getAttribute('col');
  collection = document.querySelectorAll('[col="' + col + '"]');
  for (var i = 0; i < collection.length; i++) {
    current_class = cell.classList[0];
    //if(typeof cell.classList[0]!='undefined') {
    collection[i].classList.remove("js-td-hightlight");
  }
}

//Para hacer la información editable

//Cambiará cada elemento a un input
function spanSwitch(spanElement) {
  let txt = spanElement.innerText;
  let id = spanElement.id;
  let parent = spanElement.parentElement;
  spanElement.remove();
  //id para mantener el id, value para mostrar el texto a editar, being-edited para poder seleccionarlo, oldvalue para recuperar el valor en caso de revertir.
  parent.innerHTML += `<input id='${id}' value='${txt}' class="search-details-being-edited" oldvalue="${txt}"/>`;
  //spanElement.focus();
}

function spanReset(spanElement) {
  let txt = spanElement.getAttribute('oldvalue');
  let id = spanElement.id;
  let parent = spanElement.parentElement;
  spanElement.remove();
  parent.innerHTML += `<span id='${id}' class="editable"> ${txt} </span>`;
}

function spanSave(spanElement) {
  let txt = spanElement.value;
  let id = spanElement.id;
  let parent = spanElement.parentElement;
  spanElement.remove();
  parent.innerHTML += `<span id='${id}' class="editable"> ${txt} </span>`;
}

function editableFields(elements, buttons) {
  if(!current_id_on_search_details) return;

  //for loop en reversa porque al hacer un remove(); a cada elemento, acortamos la lista y, por tanto, la iteración
  for (var i = elements.length -1; i  >= 0; --i) {
    spanSwitch(elements[i]);
  }
  document.getElementById("resultado_nombre").classList.add("wide");
  buttons[0].classList.remove("show");
  buttons[0].classList.add("hide");
  buttons[1].classList.remove("hide");
  buttons[1].classList.add("show");
  buttons[2].classList.remove("hide");
  buttons[2].classList.add("show");
}

function resetFields(elements, buttons) {
  for (var i = elements.length -1; i  >= 0; --i) {
    spanReset(elements[i]);
  }
  buttons[1].classList.remove("show");
  buttons[1].classList.add("hide");
  buttons[2].classList.remove("show");
  buttons[2].classList.add("hide");
  buttons[0].classList.remove("hide");
  buttons[0].classList.add("show");
}

function saveFields(elements, buttons) {
  for (var i = elements.length -1; i  >= 0; --i) {
    switch(elements[i].id){
      case 'resultado_nombre': upd_name = elements[i].value; break;
      case 'resultado_dni': upd_dni = elements[i].value; break;
      case 'resultado_cargo': upd_cargo = elements[i].value; break;
      case 'resultado_area': upd_area = elements[i].value; break;
      case 'resultado_nivel': upd_nivel = elements[i].value; break;
      case 'resultado_plh': upd_plh = elements[i].value; break;
      default: break;
    }
  }
  let data = new FormData();
  data.append('upd_name_t', upd_name);
  data.append('upd_dni_t', upd_dni);
  //data.append('upd_area_t', upd_area);
  //data.append('upd_nivel_t', upd_nivel);
  data.append("upd_plh_t", upd_plh);
  data.append("upd_id_t", current_id_on_search_details);
  data.append('function', 'update_trabajadores_info');
  fetch('tab_search_functions.php', {
    method: "POST",
    body: data
  }).then (function (response){
    if(response.ok){
        return response.text();
    } else {
      throw "Error en la llamada";
    }
  })
  .then (function(data){
    if(data) {
      //Successful UPDATE query
      for (var i = elements.length -1; i  >= 0; --i) {
        spanSave(elements[i]);
      }
      document.getElementById("profileChar").innerHTML = data;
      buttons[0].classList.remove("hide");
      buttons[0].classList.add("show");
      buttons[1].classList.remove("show");
      buttons[1].classList.add("hide");
      buttons[2].classList.remove("show");
      buttons[2].classList.add("hide");
    }
  })
  .catch (function(error){
    console.log("La inserción no se realizó con éxito")
  });
}

//El \t es para mantener la compatibilidad de copiado/pegado de tablas en excel
function tdSwitchTimeInput(cell) {
  let txt = cell.innerHTML.replace('\t','');
  cell.innerHTML = `<input type="time" value="${txt}" class="td-being-edited" oldvalue="${txt}"/>`;
}

function tdSwitchTextInput(cell) {
  let txt = cell.innerHTML.replace('\t','');
  cell.innerHTML = `<textarea class="resizable-v" oldvalue="${txt}"/>`;
  cell.childNodes[0].value = txt;
}

function tdReset(cell) {
  let txt = cell.childNodes[0].getAttribute('oldvalue');
  cell.innerHTML = `${txt}\t`;
}

function tdSaveSelect(cell) {
  cell.innerHTML = `${cell.childNodes[0].options[cell.childNodes[0].selectedIndex].text }\t`;
}

function tdSave(cell) {
  let txt = cell.childNodes[0].value;
  cell.innerHTML = `${txt}\t`;
}

//cell es la celda o campo (elemento) a alterar. col es para definir qué valores irán en el droplist
function tdSwitchDropList(cell, col) {
  let txt = cell.innerHTML.replace('\t','');
  aux_html = '<select name="lic_options" class="td-being-edited" oldvalue="' + txt + '">';
  let data = new FormData();
  switch(col){
    case 'lic': {
      data.append('function', 'get_licenses');
      fetch('tab_search_functions.php', {
        method: "POST",
        body: data
      }).then (function (response){
        if(response.ok){
            return response.text();
        } else {
          throw "Error en la llamada";
        }
      })
      .then (function(data){
        data = JSON.parse(data);
        if(data) {
          //Successful SELECT query
          for (var i = 0; i < data.length; i++) {
            aux_html += '<option value="' + i + '">' + data[i].abrev_lic + '</option>';
          }
          aux_html += '</select>\t';
          cell.innerHTML = aux_html;   
          cell.childNodes[0].options[(lic_list.indexOf(txt) == -1)? 0: lic_list.indexOf(txt)].selected = 'selected';
        }
      })
      .catch (function(error){
        console.log("No hay licencias que mostrar")
      });
      break;
    }
    //En desarrollo: Modalidad
    case 'mod': {
      data.append('function', 'get_modal');
      fetch('tab_search_functions.php', {
        method: "POST",
        body: data
      }).then (function (response){
        if(response.ok){
            return response.text();
        } else {
          throw "Error en la llamada";
        }
      })
      .then (function(data){
        data = JSON.parse(data);
        if(data) {
          //Successful SELECT query
          for (var i = 0; i < data.length; i++) {
            aux_html += '<option value="' + i + '">' + data[i].abrev_modalidad + '</option>';
          }
          aux_html += '</select>\t';
          cell.innerHTML = aux_html;   
          cell.childNodes[0].options[(lic_list.indexOf(txt) == -1)? 0: lic_list.indexOf(txt)].selected = 'selected';
        }
      })
      .catch (function(error){
        console.log("No hay licencias que mostrar")
      });
      break;
    }
    default: break;
  }   
}

function tdSaveDropList(cell) {
  let txt = cell.childNodes[0].value + '\t';
  cell.innerHTML = txt;
}

function tableEdit(this_button, buttons) {
  loadingAnimation(true);

  row = this_button.parentNode.parentNode.parentNode;
  
  tdSwitchTimeInput(row.childNodes[2]);
  tdSwitchTimeInput(row.childNodes[3]);
  
  //Aqií dentro de Swith Drop List Lic Mod, llamo a loadingAnimation(false);
  tdSwitchDropListLicMod(row.childNodes[7], row.childNodes[8]);

  //tdSwitchDropList(row.childNodes[7], 'lic');
  //tdSwitchDropList(row.childNodes[8], 'mod');
  
  tdSwitchTextInput(row.childNodes[9]);
  //tdSwitchTextInput(row.childNodes[10]);
  this_button.classList.remove("show");
  this_button.classList.add("hide");
  buttons[0].classList.remove("hide");
  buttons[0].classList.add("show");
  buttons[1].classList.remove("hide");
  buttons[1].classList.add("show");
}

function tdSwitchDropListLicMod(cell_lic, cell_mod) {
  let txt = cell_lic.innerHTML.replace('\t','');
  aux_html = '<select name="lic_options" class="td-being-edited" oldvalue="' + txt + '">';
  var queried_lic_list = [];
  var queried_mod_list = [];
  //Empezamos con conseguir los datos de licencias
  let data = new FormData();
  data.append('function', 'get_licenses');
  fetch('tab_search_functions.php', {
    method: "POST",
    body: data
  }).then (function (response){
    if(response.ok){
        return response.text();
    } else {
      throw "Error en la llamada";
    }
  })
  .then (function(data){
    data = JSON.parse(data);
    console.log(data);
    if(data) {
      //Successful SELECT query para licencias. Entonces, procedemos a buscar modalidades
      let data_mod = new FormData();
      let txt_mod = cell_mod.innerHTML.replace('\t','');
      aux_html_mod = '<select name="lic_options" class="td-being-edited" oldvalue="' + txt_mod + '">';
      data_mod.append('function', 'get_modal');
      fetch('tab_search_functions.php', {
        method: "POST",
        body: data_mod
      }).then (function (response){
        if(response.ok){
            return response.text();
        } else {
          throw "Error en la llamada";
        }
      })
      .then (function(data_mod){
        data_mod = JSON.parse(data_mod);
        console.log(data_mod);
        if(data_mod) {
          //Successful SELECT query para modalidades. Entonces, procedemos a hacer los cambios en el front

          //La Lista de Licencias
          for (var i = 0; i < data.length; i++) {
            aux_html += '<option value="' + i + '">' + data[i].abrev_lic + '</option>';
            queried_lic_list.push(data[i].abrev_lic);
          }
          aux_html += '</select>\t';
          cell_lic.innerHTML = aux_html;   
          cell_lic.childNodes[0].options[(queried_lic_list.indexOf(txt) == -1)? 0: queried_lic_list.indexOf(txt)].selected = 'selected';

          //La Lista de Modalidades
          for (var i = 0; i < data_mod.length; i++) {
            aux_html_mod += '<option value="' + i + '">' + data_mod[i].abrev_modalidad + '</option>';
            queried_mod_list.push(data_mod[i].abrev_modalidad);
          }
          aux_html_mod += '</select>\t';
          cell_mod.innerHTML = aux_html_mod;   
          cell_mod.childNodes[0].options[(queried_mod_list.indexOf(txt_mod) == -1)? 0: queried_mod_list.indexOf(txt_mod)].selected = 'selected';
          
          loadingAnimation(false);
        }
      })
      .catch (function(error){
        console.log("No hay modalidades que mostrar");
      });
    }
  })
  .catch (function(error){
    console.log("No hay licencias que mostrar");
  });
}

function tableReset(this_button, buttons) {
  row = this_button.parentNode.parentNode.parentNode;

  tdReset(row.childNodes[2]); // Columna Entrada
  tdReset(row.childNodes[3]); // Columna Salida
  tdReset(row.childNodes[7]); // Columna Licencia
  tdReset(row.childNodes[8]); // Columna Modalidad
  tdReset(row.childNodes[9]); // Columna Comentario
  //tdReset(row.childNodes[10]);
  this_button.classList.remove("show");
  this_button.classList.add("hide");
  buttons[0].classList.remove("hide");
  buttons[0].classList.add("show");
  buttons[1].classList.remove("show");
  buttons[1].classList.add("hide");
}

function tableSave(this_button, buttons, total_div, small_table) {
  var success = false;
  //This button es el botón que invoca tableSave. Con este botón podremos saber en qué fila hemos hecho clic, y acceder a las celdas que se supone
  //están en proceso de edición y guardado.
  //Buttons es un array de los otros dos botones alternativos (El de deshacer, y el de Editar). Se requiere para poder definir si se ocultan/muestran
  //Total_div es el div que contiene el total de horas trabajadas en el mes. Se requiere para poder cambiar su valor si este se ve alterado
  /*Aquí primero va la inserción, y ver si se manda o no*/
  row = this_button.parentNode.parentNode.parentNode;
  total_cell = row.childNodes[4];
  date_parts = row.childNodes[1].innerHTML.replace('\t','').split("-");
  var date = new Date(date_parts[2], date_parts[1] - 1, date_parts[0]).getTime();
  //Obtenemos la fecha en milisegundos, aparentemente con el +5 necesario por la zona horaria local
  //Control IF para poner los valores en 00:00 si es que seleccionamos inasistencia
  if(row.childNodes[7].childNodes[0].options[row.childNodes[7].childNodes[0].selectedIndex].text == 'I') {
    row.childNodes[2].childNodes[0].value = "00:00";
    row.childNodes[3].childNodes[0].value = "00:00";
  }

  //Control if para poder revisar si se ingresó una fecha válida
  if ((row.childNodes[2].childNodes[0].value == "00:00" || row.childNodes[3].childNodes[0].value == "00:00" 
  || row.childNodes[2].childNodes[0].value == "" || row.childNodes[3].childNodes[0].value == ""
  || (parseInt(row.childNodes[3].childNodes[0].value.split(":")[0])*60 + parseInt(row.childNodes[3].childNodes[0].value.split(":")[1]) 
  - parseInt(row.childNodes[2].childNodes[0].value.split(":")[0])*60 - parseInt(row.childNodes[2].childNodes[0].value.split(":")[1])) <= 0) && row.childNodes[7].childNodes[0].options[row.childNodes[7].childNodes[0].selectedIndex].text != 'I') {
    //Mensajito de que se ingrese una fecha válida
    invalidHour();
  } else {
    try {
      loadingAnimation(true);
      insertListaAsistencia(
        date, 
        current_id_on_search_details, 
        row.childNodes[2].childNodes[0].value, 
        row.childNodes[3].childNodes[0].value, 
        row.childNodes[7].childNodes[0].value, 
        row.childNodes[8].childNodes[0].value, 
        row.childNodes[9].childNodes[0].value, 
        total_div, 
        total_cell, 
        small_table);


      // tdSave(row.childNodes[2]);
      // tdSave(row.childNodes[3]);
      // tdSaveSelect(row.childNodes[7]);
      // tdSaveSelect(row.childNodes[8]);
      // tdSave(row.childNodes[9]);
      // //Temporal
      // row.childNodes[12].innerHTML = 'Edición manual';
      // //Antiguamente esto era observaciones
      // //row.childNodes[5].innerHTML = 'REV';
      // for (var i = 0; i < row.childNodes.length; i++) {
      //   row.childNodes[i].classList.add("rev");
      // }
      // this_button.classList.remove("show");
      // this_button.classList.add("hide");
      // buttons[0].classList.remove("hide");
      // buttons[0].classList.add("show");
      // buttons[1].classList.remove("show");
      // buttons[1].classList.add("hide");

      //Recarga la tabla (por ahora aún no)
      success = true;
    } catch {
      console.log("La inserción no se realizó con éxito")
    }

    // if(success){
    //   //Si la actualización de datos fue un éxito, entonces actualizar también el total de horas, y el contador de tardanzas
    //   total_en_mins = (parseInt(row.childNodes[3].innerHTML.split(':')[0])*60 + parseInt(row.childNodes[3].innerHTML.split(':')[1]))
    //     - (parseInt(row.childNodes[2].innerHTML.split(':')[0])*60 + parseInt(row.childNodes[2].innerHTML.split(':')[1]))
    //   horas = Math.floor(total_en_mins / 60);
    //   minutos = total_en_mins - horas * 60;
    //   //Actualizamos el total de horas trabajadas
    //   row.childNodes[4].innerHTML = 
    //     ((horas < 10)? '0': '') + String(horas) + ':' + ((minutos < 10)? '0': '') + String(minutos);
      
    //   //Obtenemos el dia correspondiente
    //   columna = row.childNodes[4].getAttribute('col');
    //   //Actualizamos el total de horas trabajadas también en la tabla resumen, usando como referencia el día obtenido
    //   document.querySelector('#tabla_resumen > tbody > tr > td[col="' + columna + '"]').innerHTML = ((horas < 10)? '0': '') + String(horas) + ':' + ((minutos < 10)? '0': '') + String(minutos);
    // }
    //console.log('reloaded');
    //livesearch_show_details(current_id_on_search_details,false,new Date(current_date_on_search[0], month_list.indexOf(current_date_on_search[1]),1).getTime());
  }
  
}

function checkSearchDetailsChangeLog(clickeable_cell){
  //Limpiar la celda del \t
  date = clickeable_cell.parentNode.childNodes[1].innerHTML.replace('\t', '');
  console.log('PK Fecha');
  console.log(date.split("-")[2] + '-' + date.split("-")[1] + '-' + date.split("-")[0]);
  console.log('PK id_trabajador');
  console.log(current_id_on_search_details);
  let data = new FormData();
  data.append('id_sent', current_id_on_search_details);
  data.append('date_sent', date);
  data.append('function', 'historial_cambios');
  fetch('tab_search_functions.php', {
    method: "POST",
    body: data
  }).then (function (response){
    if(response.ok){
        return response.text();
    } else {
      throw "Error en la llamada";
    }
  })
  .then (function(data){
    
  })
  .catch (function(error){
    console.log(error);
  });
}

function loadHojasAsis (table_body, name_searched, date_timestamp_1, date_timestamp_2) {
  let data = new FormData();
  data.append('function','hojas_asis_table_query');
  data.append('date_timestamp_1', (date_timestamp_1.value=='')? 0: fixedLocalTimezone(new Date(date_timestamp_1.value).getTime()).getTime());
  data.append('date_timestamp_2', (date_timestamp_2.value=='')? 0: fixedLocalTimezone(new Date(date_timestamp_2.value).getTime()).getTime());
  data.append('name_searched',name_searched.value);
  fetch('tab_hoja_asis_functions.php', {
      method: "POST",
      body: data
  }).then (function (response){
      if(response.ok){
          return response.text();
      } else {
          throw "Error en la llamada";
      }
  })
  .then (function(data){
    data = JSON.parse(data);
    table_body_html = '';
    if(data.length != 0) {
      //Si hay data, que la muestre en la tabla
      for(i = 0; i < data.length; i++) {
        table_body_html += `<tr id_hoja="${data[i].id_hoja}">`;
        for (var key in data[i]) {
          switch(key){
            case 'id_hoja': continue;
            case 'fecha': table_body_html += `<td>${data[i][key].split('-')[2] + '-' + data[i][key].split('-')[1] + '-' + data[i][key].split('-')[0]}</td>`; break;
            default: table_body_html += `<td>${data[i][key]}</td>`; break;
          }
          // if(key == 'id_hoja') {continue;}
          // table_body_html += `<td>${data[i][key]}</td>`;
        }
        table_body_html += `</tr>`;
      }
    } else {
      //Si no la hay, que muestre una celda del ancho de toda la tabla
      table_body_html = `<tr><td colspan=${document.querySelectorAll('#auth_list_table > thead > tr > th').length}>No hay hojas de asistencia que cumplan con los criterios de búsqueda</td></tr>`;
    }
    table_body.innerHTML = table_body_html;
  })
  .catch (function(error){
    console.log(error);
  });        
}


function insertListaAsistencia(la_date, la_id, la_in, la_out, id_lic, id_modalidad, comentarios, total_mes_div, total_day_cell, small_table) {
  //Smalltable es tabla resumen
  let data = new FormData();
  data.append('date_sent', la_date);
  data.append('id_sent', la_id);
  data.append('entrada_sent', la_in);
  data.append('salida_sent', la_out);
  data.append('id_lic_sent', id_lic);
  data.append('id_modalidad_sent', id_modalidad);
  data.append('comentarios_sent', comentarios);
  data.append('function', 'calculo_h_upd');
  fetch('tab_search_functions.php', {
    method: "POST",
    body: data
  }).then (function (response){
    if(response.ok){
        return response.text();
    } else {
      throw "Error en la llamada";
    }
  })
  .then (function(data){
    data = JSON.parse(data);
    // console.log(data);
    // console.log(small_table);
    // console.log(id_lic);
    // console.log(id_modalidad);
    // total_mes_div.innerHTML = "<span>Horas presenciales (1d=8h): " + intervalToDays(data.calc_h_actualizado.total_h_mes) + "</span><span>" 
    // + ((data.calc_h_actualizado.acum_dif_mes.split(":")[0][0]=='-')? "Debe: " : "Trabajo extra: ")
    // + data.calc_h_actualizado.acum_dif_mes.split(":")[0].replace('-','') + "h " + data.calc_h_actualizado.acum_dif_mes.split(":")[1] + "m</span><span>Tard.: " 
    // + data.calc_h_actualizado.acum_tardanzas + " / Inasis.: " + data.calc_h_actualizado.acum_inasistencias + "</span>";
    // total_day_cell.innerHTML = data.total_h_dia_actualizado.total.split(":")[0] + ":" + data.total_h_dia_actualizado.total.split(":")[1];
    // small_table.childNodes[1].childNodes[0].childNodes[new Date(la_date).getDate()-1].innerHTML = total_day_cell.innerHTML;
    // //Actualizaremos los datos del Last modif
    // //El índice 14 es la columna de Historial (de cambios)
    // if(typeof total_day_cell.parentNode.childNodes[14].childNodes[1] == 'undefined') {
    //   total_day_cell.parentNode.childNodes[14].innerHTML = data.last_modif_who.split(",")[0] + '; ' + printFullDateAndTime(new Date(data.last_modif_who.split(",")[1].slice(0, -3)));
    // }




    //Recargamos los resultados
    //Convertimos la fecha de búsqueda actual en timestamp, para poder mandarlo como argumento
    date_tmstmp = new Date(current_date_on_search[0] + '-' + (month_list.indexOf(current_date_on_search[1]) + 1) + '-01')*1 + 5*60*60*1000;
    livesearch_show_details(current_id_on_search_details,document.getElementById(String(current_id_on_search_details)),date_tmstmp, true);
    
  })
  .catch (function(error){
    console.log(error);
  });
}

function intervalToDays(str_interval) {
  var hours = parseInt(str_interval.split(":")[0]);
  var mins = parseInt(str_interval.split(":")[1]);
  var days = Math.trunc(hours/8);
  hours = hours - days * 8;
  return (((days>=10)? days: "0" + days) + "d " + ((hours>=10)? hours: "0" + hours) + "h " + ((mins>=10)? mins: "0" + mins) + "m");
}

function printDateDMY(date) {
  return (((date.getDate()>=10)? date.getDate(): "0" + date.getDate()) + "-"
  +  (((date.getMonth() + 1)>=10)? (date.getMonth() + 1): "0" + (date.getMonth() + 1)) + "-"
  + (date.getFullYear()));
}

function printDateYMD(date) {
  return (date.getFullYear()) + "-" 
  + (((date.getMonth() + 1)>=10)? (date.getMonth() + 1): "0" + (date.getMonth() + 1)) + "-" 
  + ((date.getDate()>=10)? date.getDate(): "0" + date.getDate());
}

function printFullDateAndTime (full_date, with_time) {
  //full_date es un Date
  //with_time es opcional, un booleano
  //Por defecto
  var day = day_list[full_date.getDay()];
  var date = full_date.getDate();
  var month = month_list[full_date.getMonth()] + '.';
  year = full_date.getFullYear();
  if(with_time == null || with_time){
    hours = ((full_date.getHours()<10)? '0': '') + full_date.getHours();
    mins = ((full_date.getMinutes()<10)? '0': '') + full_date.getMinutes();
    secs = ((full_date.getSeconds()<10)? '0': '') + full_date.getSeconds();
  }
  //Retorna string
  return day + ', ' + date + ' de ' + month + ' de ' + year + ((with_time == null || with_time)? ', ' + hours + ':' + mins + ':' + secs: '');
}

function hourToMins (hhmm){
  return parseInt(hhmm.split(":")[0])*60 + parseInt(hhmm.split(":")[1]);
}

function addNewRow (tableBody, row_date, row_name, row_comment, row_entrada, row_salida) {
  console.log(tableBody);
  if(tableBody.childNodes[0].childNodes.length == 1 || tableBody.childNodes[0].childNodes.length == 0) {
    tableBody.innerHTML = '';
  }
  num_rows++;
  tableBody.innerHTML += `<tr>
      <td><input type="date" name="fecha[]" value="${row_date.value}" onchange="validateListaAsisRow(this, document.getElementById('guardar_hoja_asis'));" ready="1" readonly></td>
      <td><input type="text" name="comentario[]" value="${row_comment.value}" onchange="validateListaAsisRow(this, document.getElementById('guardar_hoja_asis'));" ready="1" readonly></td>
      <td>
        <input type="text" name="trabajador[]" id="name_input_${num_rows}" value="${row_name.value}" ready="${row_name.getAttribute('valid')}" readonly>
      </td>
      <td><input type="time" name="entrada[]" value="${row_entrada.value}" ready="1" readonly></td>
      <td><input type="time" name="salida[]" value="${row_salida.value}" ready="1" readonly></td>
      <td>
        <div class="flex-justify-around">
          <button id="td_del_btn" class="tabpanelbuttons small no show" onclick="deleteNewRow(this, document.getElementById('guardar_hoja_asis'));">Eliminar</button>    
        </div>
      </td>
    </tr>`;
  for(i = 0; i< document.querySelectorAll('[type=date]').length; i++){
    document.querySelectorAll('[type=date]')[i].setAttribute('max', printDateYMD(new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate())));
  }
}

function deleteNewRow (cell, btnSave) {
  parentTableBody = cell.parentNode.parentNode.parentNode.parentNode;
  if(parentTableBody.childNodes.length == 1) {
    parentTableBody.innerHTML = '<td colspan="6">No hay nadie en lista.</td>';
  }
  cell.parentNode.parentNode.parentNode.remove();
  validateGuardarHoja(btnSave);
}

function validateListaAsisRow(inputEl,btnSave) {
  switch(inputEl.getAttribute('type')){
    case 'date': {
      inputEl.setAttribute('ready', (inputEl.value == '')? '0': '1');
      break;
    }
    case 'text': {
      //Si cambia es porque le han escrito encima, asi que falso.
      //La única forma de que sea verdadero, es que hayan seleccionado un nombre y no se haya hecho absolutamente nada más
      if(inputEl.getAttribute('name') == 'trabajador[]') {inputEl.setAttribute('ready', '0');}
      if(inputEl.getAttribute('name') == 'dir_ofi[]' && inputEl.value == '') {
        inputEl.setAttribute('ready', '0');
      } else {
        inputEl.setAttribute('ready','1');
      }
      break;
    }
    case 'time': {
      if (inputEl.value != '') {
        inputEl_mins = parseInt(inputEl.value.split(":")[0]) * 60 + parseInt(inputEl.value.split(":")[1]);
        switch(inputEl.getAttribute('name')) {
          case 'entrada[]': {
            salida = inputEl.parentNode.nextElementSibling.childNodes[0];
            if(salida != '') {
              salida_mins = parseInt(salida.value.split(":")[0]) * 60 + parseInt(salida.value.split(":")[1]);
              if (inputEl_mins < salida_mins) {
                inputEl.setAttribute('ready','1');
                salida.setAttribute('ready','1');
              } else {
                inputEl.setAttribute('ready','0');
                salida.setAttribute('ready','0');
              }
            } else {
              inputEl.setAttribute('ready','0');
              salida.setAttribute('ready','0');
              break;
            }
            break;
          }
          case 'salida[]': {
            entrada = inputEl.parentNode.previousElementSibling.childNodes[0];
            if(entrada != ''){
              entrada_mins = parseInt(entrada.value.split(":")[0]) * 60 + parseInt(entrada.value.split(":")[1]);
              if (entrada_mins < inputEl_mins) {
                inputEl.setAttribute('ready','1');
                entrada.setAttribute('ready','1');
              } else {
                inputEl.setAttribute('ready','0');
                entrada.setAttribute('ready','0');
              }
            } else {
              inputEl.setAttribute('ready','0');
              entrada.setAttribute('ready','0');
              break;
            }
            break;
          }
        }
      } else {
        inputEl.setAttribute('ready','0');
      }
      break;
    }
    default: inputEl.setAttribute('ready','0'); break;
  }
  validateGuardarHoja(btnSave);
}

function validateGuardarHoja(btnSave){
  console.log((document.querySelectorAll('[ready="0"]').length));
  console.log(btnSave);
  btnSave.disabled = document.querySelectorAll('[ready]').length == 0 || document.querySelectorAll('[ready="0"]').length != 0 || document.querySelector('#tabla_hojas_asis > tr > td').getAttribute('colspan') > 1;
}

function generateMonthReportCalcH(this_button) {
  this_button.nextElementSibling.value = current_id_on_search_details;
  this_button.nextElementSibling.nextElementSibling.value = current_date_on_search[0];
  this_button.nextElementSibling.nextElementSibling.nextElementSibling.value = String(month_list.indexOf(current_date_on_search[1]) + 1);
  this_button.parentNode.submit();
}

function hourDiff(h1, h2){
  return (h1.value.split(':')[0]*60 + h1.value.split(':')[1] - (h2.value.split(':')[0]*60 + h2.value.split(':')[1])) > 0;
}

function validateAddPerson(table_body, input_date, input_name, input_comment, input_entrada, input_salida, date_error, name_error, comment_error, entrada_error, salida_error){
  error_flag = false;
  if (input_date.value == ''){date_error.innerHTML = '*Selecciona una fecha válida.'; error_flag = true;} else {date_error.innerHTML = '';}
  if (input_name.getAttribute('valid') == '0'){name_error.innerHTML = '*Selecciona una persona correcta.'; error_flag = true;} else {name_error.innerHTML = '';}
  if (input_comment.getAttribute('valid') == '0'){comment_error.innerHTML = '*Solo puedes usar letras.'; error_flag = true;} else {comment_error.innerHTML = '';}
  if (input_entrada.value == ''){entrada_error.innerHTML = '*Selecciona una hora válida.'; error_flag = true;} else {entrada_error.innerHTML = '';}
  if (input_salida.value == ''){salida_error.innerHTML = '*Selecciona una hora válida.'; error_flag = true;} else {salida_error.innerHTML = '';}
  if (input_entrada.value != '' && input_salida.value != '') {
    if (hourToMins(input_salida.value) - hourToMins(input_entrada.value) <= 0) {
      entrada_error.innerHTML = '*La hora de entrada no puede ser mayor o igual a la hora de salida..';
      salida_error.innerHTML = '*La hora de salida no puede ser menor o igual a la hora de entrada.';
      error_flag = true;
    }
  }
  console.log(error_flag);
  if (!error_flag) {
    console.log('Todos los datos son válidos. Añadir nueva fila.');
    addNewRow(table_body, input_date, input_name, input_comment, input_entrada, input_salida);
    closePrompt(document.querySelector('.floating-panel'), false);
    //Limpiamos los input del modal luego de insertar una fila
    input_date.value = ''; input_date.setAttribute('valid','0');
    input_name.value = ''; input_name.setAttribute('valid','0'); input_name.style = '';
    input_comment.value = ''; input_comment.setAttribute('valid','1');
    input_entrada.value = ''; input_entrada.setAttribute('valid','0');
    input_salida.value = ''; input_salida.setAttribute('valid','0');
    validateGuardarHoja(document.getElementById('guardar_hoja_asis'));
  }
} 

function insertHojaAsis(){
  var error_flag = false;
  if(document.getElementById('dir_ofi').value == '') {
    document.getElementById('dir_ofi').nextElementSibling.innerHTML = 'Ingresa un nombre de Dirección u Oficina válido.';
    error_flag = true;
  } else {
    document.getElementById('dir_ofi').nextElementSibling.innerHTML = '';
  }
  if(current_id_on_search_details) {
    document.getElementById('firma').nextElementSibling.innerHTML = '';
  } else {
    document.getElementById('firma').nextElementSibling.innerHTML = 'Ingresa un nombre válido.';
    error_flag = true;
  }
  if(document.getElementById('hojas_asis_date').value == '') {
    document.getElementById('hojas_asis_date').nextElementSibling.innerHTML = 'Ingresa una fecha válida.';
    error_flag = true;
  } else {
    document.getElementById('hojas_asis_date').nextElementSibling.innerHTML = '';
  }

  if(!error_flag){
    var row_date = [];
    var row_name = [];
    var row_comment = [];
    var row_entrada = [];
    var row_salida = [];
    let data = new FormData();
    for(i = 0; i < document.getElementsByName('fecha[]').length; i++) {
      row_date.push(document.getElementsByName('fecha[]')[i].value);
      row_name.push(document.getElementsByName('trabajador[]')[i].getAttribute('ready'));
      row_comment.push(document.getElementsByName('comentario[]')[i].value);
      row_entrada.push(document.getElementsByName('entrada[]')[i].value);
      row_salida.push(document.getElementsByName('salida[]')[i].value);
      console.log(row_date[i]);
      console.log(row_name[i]);
      console.log(row_comment[i]);
      console.log(row_entrada[i]);
      console.log(row_salida[i]);
    }
    data.append('function','insert_new_hoja_asis');
    data.append('row_date', JSON.stringify(row_date));
    data.append('row_name', JSON.stringify(row_name));
    data.append('row_comentario', JSON.stringify(row_comment));
    data.append('row_entrada', JSON.stringify(row_entrada));
    data.append('row_salida', JSON.stringify(row_salida));
    data.append('firma',current_id_on_search_details);
    data.append('fecha', document.getElementById('hojas_asis_date').value);
    data.append('dir_ofi', document.getElementById('dir_ofi').value);
    data.append('cerrado', (document.getElementById('hojas_asis_cerrado').checked)? 'f': 't');
    fetch('tab_hoja_asis_functions.php', {
      method: "POST",
      body: data
    }).then (function (response){
        if(response.ok){
          return response.text();
        } else {
          throw "Error en la llamada";
        }
    })
    .then (function(data){
      if(data == '1') {
        console.log('Success');
        document.getElementById("darkopacity").classList.remove("hide");
        document.getElementById("darkopacity").classList.add("show");
        document.querySelector('.floating-panel.result').classList.remove("hide");
        document.querySelector('.floating-panel.result').classList.add("show");
        document.querySelector('.floating-panel.result > h3').innerHTML = '¡Se registró la Hoja de Asistencias exitosamente!';
        document.querySelector('.floating-panel.result > div > button').setAttribute('onclick', "window.location.href='./tab_hoja_asis.php'; return false;");
        document.querySelector('.floating-panel.result').style.marginTop = (document.querySelector('.floating-panel.result').offsetHeight / -2) + 'px';
        document.querySelector('#darkopacity').setAttribute('onclick','');
      } else {
        console.log('Something happened');
        document.getElementById("darkopacity").classList.remove("hide");
        document.getElementById("darkopacity").classList.add("show");
        document.querySelector('.floating-panel.result').classList.remove("hide");
        document.querySelector('.floating-panel.result').classList.add("show");
        document.querySelector('.floating-panel.result > h3').innerHTML = '¡Hubo un error al registrar la Hoja de Asistencias!'
        document.querySelector('.floating-panel.result > div > button').setAttribute('onclick', "closePrompt(document.querySelector('.floating-panel.result'), false); return false;");
        document.querySelector('.floating-panel.result').style.marginTop = (document.querySelector('.floating-panel.result').offsetHeight / -2) + 'px';
        document.querySelector('#darkopacity').setAttribute('onclick','');
      }
    })
    .catch (function(error){
        console.log(error);
    }); 
  }

  
}

function verHojaAsis(this_button){
  //Conseguimos el ID de la hoja desde el row padre
  document.querySelector('#id_hoja_ver').value = this_button.parentNode.parentNode.getAttribute('id_hoja');
  //Hacemos submit en el form invisible, para ir con POST a la página de ver hoja
  console.log(document.querySelector('#id_hoja_ver').parentNode);
  document.querySelector('#id_hoja_ver').parentNode.submit();
}

function selectOnClick(element){
  row = element.parentNode.parentNode;
  if(document.getElementById(element.getAttribute('for')).checked){
    row.classList.remove("selected");
    if(element.hasAttribute('unchktxt')) {element.innerHTML = element.getAttribute('unchktxt');}
  } else {
    if(!row.classList.contains("selected")) {row.classList.add("selected");}
    if(element.hasAttribute('chktxt')) {element.innerHTML = element.getAttribute('chktxt');}
  }
}

function loadListaHojaAsis() {
  table_body_html = '';
  let data = new FormData();
  data.append('function','load_hoja_asis');
  fetch('tab_hoja_asis_functions.php', {
    method: "POST",
    body: data
  }).then (function (response){
      if(response.ok){
        return response.text();
      } else {
        throw "Error en la llamada";
      }
  })
  .then (function(data){
    for(let row of user_data) {
      switch (user.user_level) {
        case '1': user.user_level = '1">Administrador'; break;
        case '2': user.user_level = '2">Ver y Editar'; break;
        case '3': user.user_level = '3">Solo ver'; break;
        case '4': user.user_level = '4">Portería'; break;
        default: user.user_level = '">No definido'; break;
      }
      html_buttons = `<button id="td_edit_btn" class="tabpanelbuttons small neutral show" onclick="promptCreateUpdateUser(document.querySelector('.floating-panel'),this.parentNode.parentNode.parentNode)">Editar</button>
      <button id="td_del_btn" class="tabpanelbuttons small no show" onclick="promptDeleteUser(document.querySelector('.floating-panel'),this.parentNode.parentNode.parentNode)">Eliminar</button>`;
      table_body_html += `<tr><td>${user.id_user}</td><td>${user.user}</td><td>${user.name}</td><td>${user.last_name}</td><td userlvl="${user.user_level}</td><td><div class="flex-justify-around">
            ${(user.id_user == 1 || user.id_user == data)? '': html_buttons}
            </div></td>
        <td>${(user.last_conn_1 != null)? printFullDateAndTime(new Date(user.last_conn_1.slice(0, -3))): '-'}</td>
        <td>${(user.last_conn_2 != null)? printFullDateAndTime(new Date(user.last_conn_2.slice(0, -3))): '-'}</td>
        <td>${(user.last_conn_3 != null)? printFullDateAndTime(new Date(user.last_conn_3.slice(0, -3))): '-'}</td>
        <td>${(user.last_conn_4 != null)? printFullDateAndTime(new Date(user.last_conn_4.slice(0, -3))): '-'}</td></tr>`
    }
    table_body.innerHTML = table_body_html;
  })
  .catch (function(error){
      console.log(error);
  });
}

function changeListaHojaAsisRowState(this_input) {
  let data = new FormData();
   data.append('function', 'change_row_status');
   data.append('id_trabajador', this_input.parentNode.parentNode.getAttribute('id'));
   data.append('habilitado', (this_input.checked)? 't': 'f');
   data.append('id_hoja', this_input.parentNode.parentNode.parentNode.getAttribute('hoja'));
   fetch('tab_hoja_asis_functions.php', {
    method: "POST",
    body: data
  }).then (function (response){
      if(response.ok){
        return response.text();
      } else {
        throw "Error en la llamada";
      }
  })
  .then (function(data){
    console.log(data);
    switch(data) {
      case 't': console.log('Cambio a True'); this_input.checked = true; break;
      case 'f': console.log('Cambio a False'); this_input.checked = false; break;
      default: console.log('Error al obtener estado de la fila'); break;
    }
  })
  .catch (function(error){
      console.log(error);
  });
}

function changeHojaState(this_input) {
  let data = new FormData();
  data.append('function', 'change_hoja_status');
  data.append('cerrado', (this_input.checked)? 't': 'f');
  data.append('id_hoja', document.querySelector('#tabla_hojas_asis').getAttribute('hoja'));
  fetch('tab_hoja_asis_functions.php', {
    method: "POST",
    body: data
  }).then (function (response){
      if(response.ok){
        return response.text();
      } else {
        throw "Error en la llamada";
      }
  })
  .then (function(data){
    console.log(data);
    switch(data) {
      case 't': console.log('Cambio estado Hoja a True'); this_input.checked = true; break;
      case 'f': console.log('Cambio estado Hoja a False'); this_input.checked = false; break;
      default: console.log('Error al obtener estado de la Hoja de Asistencia'); break;
    }
  })
  .catch (function(error){
      console.log(error);
  });
}

function verificarInsertarNuevoHorario(f_inf, f_sup, h_inf, h_sup, tag){
  //Inicialización de span de validación y bandera de error
  error_flag = false;
  f_inf.parentNode.nextElementSibling.innerHTML = '';
  f_sup.parentNode.nextElementSibling.innerHTML = '';
  h_inf.parentNode.nextElementSibling.innerHTML = '';
  h_sup.parentNode.nextElementSibling.innerHTML = '';
  tag.nextElementSibling.innerHTML = '';

  //Iniciamos la validación
  let data = new FormData();
  data.append('function', 'verificar_fechas_horario');
  data.append('f_inf', f_inf.value);
  data.append('f_sup', f_sup.value);
  fetch('tab_rules_functions.php', {
    method: "POST",
    body: data
  }).then (function (response){
      if(response.ok){
        return response.text();
      } else {
        throw "Error en la llamada";
      }
  })
  .then (function(data){
    console.log(data);
    data = JSON.parse(data);
    switch(data.error_state) {
      //Case -1: No hay fechas colocadas aún
      case -1: {
        if(f_inf.value == '') {error_flag = true; f_inf.parentNode.nextElementSibling.innerHTML = '¡No puedes dejar esta fecha vacía!';}
        if(f_sup.value == '') {error_flag = true; f_sup.parentNode.nextElementSibling.innerHTML = '¡No puedes dejar esta fecha vacía!';}
        break;
      }
      //Case 0: Existe una superposición de fechas
      case 0: {
        error_flag = true;
        f_inf.parentNode.nextElementSibling.innerHTML = data.mensaje;
        break;
      }
      default: console.log('Éxito'); break;
    }

    //Verificamos la validez de las horas
    //hourDiff devuelve true si la diferencia de horas es mayor a 0. Devuelve false si es menor o igual a 0
    if(h_inf.value != '' && h_sup.value != '' && !hourDiff(h_sup, h_inf)) {
      error_flag = true;
      h_inf.parentNode.nextElementSibling.innerHTML = 'Error: Las horas seleccionadas no son válidas';
    } else {
      if(h_inf.value == '') {error_flag = true; h_inf.parentNode.nextElementSibling.innerHTML = '¡No puedes dejar esta hora vacía!';}
      if(h_sup.value == '') {error_flag = true; h_sup.parentNode.nextElementSibling.innerHTML = '¡No puedes dejar esta hora vacía!';}
    }

    //La etiqueta debe tener contenido
    //if(tag.value == '') {error_flag = true; tag.nextElementSibling.innerHTML = '¡No puedes dejar la etiqueta vacía!';}
    //Limpiamos los espacios de exceso en tag
    tag.value = tag.value.trim().replace(/\s+/g,' ');
    if(tag.value == '') {error_flag = true; tag.nextElementSibling.innerHTML = '¡No puedes dejar la etiqueta vacía!';}
    if(tag.value.replace(/[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜ\u00f1\u00d1_0-9- ]/g, '').length != 0) {error_flag = true; tag.nextElementSibling.innerHTML = 'Solo se permiten letras, números, "_" y "-"';}

    //Si error_flag es false, la validación fue exitosa, entonces se procede a insertar.
    if(!error_flag){
      console.log('Procedemos a la inserción');
      let data_2 = new FormData();
      data_2.append('function', 'insertar_nuevo_horario');
      data_2.append('f_inf', f_inf.value);
      data_2.append('f_sup', f_sup.value);
      data_2.append('h_inf', h_inf.value);
      data_2.append('h_sup', h_sup.value);
      data_2.append('tag', tag.value);
      fetch('tab_rules_functions.php', {
        method: "POST",
        body: data_2
      }).then (function (response){
          if(response.ok){
            return response.text();
          } else {
            throw "Error en la llamada";
          }
      })
      .then (function(data_2){
        console.log(data_2);
        switch(data_2) {
          default: console.log('Error: No se realizaron cambios.'); break;
          case '1': {
            console.log('Actualizar la tabla');
            //Reiniciamos los valores de búsqueda
            document.querySelector('#tag_searcher').value = '';
            document.querySelector('#search_f_inf').value = '';
            document.querySelector('#search_f_sup').value = '';
            //Y recargamos la tabla de resultados
            loadTablaHorarios(
              document.getElementById('tabla_horarios'), 
              document.getElementById('tag_searcher'), 
              document.getElementById('search_f_inf'), 
              document.getElementById('search_f_sup'));

            //Ahora cerramos el modal
            closePrompt(document.querySelector('.floating-panel.big'), false); 

            //Ocultamos el botón de Añadir horario
            document.querySelector('.tabpanelbuttons.add').classList.add('hide');

            //Ahora notificamos del resultado al usuario
            //Este if ayudará a manejar la situación de si ya existe una notificación mostrándose
            if(!document.querySelector('.notification-down-left.update').classList.contains('hide')) {
              document.querySelector('.notification-down-left.update').classList.add('hide');
              document.querySelector('.notification-down-left.update').classList.remove('animate');
            }

            document.querySelector('.notification-down-left.green').classList.add('animate');
            document.querySelector('.notification-down-left.green').classList.remove('hide');
            setTimeout(function () {
              document.querySelector('.notification-down-left.green').classList.remove('animate');
              document.querySelector('.notification-down-left.green').classList.add('hide');}, 5000);
            break;
          }
        }
      })
      .catch (function(error){
          console.log(error);
      });

    }

  })
  .catch (function(error){
      console.log(error);
  });
}

function verificarActualizarNuevoHorario(f_inf, f_sup, h_inf, h_sup, tag, chk_hab, this_button){
  //Inicialización de span de validación y bandera de error
  error_flag = false;
  f_inf.parentNode.nextElementSibling.innerHTML = '';
  f_sup.parentNode.nextElementSibling.innerHTML = '';
  h_inf.parentNode.nextElementSibling.innerHTML = '';
  h_sup.parentNode.nextElementSibling.innerHTML = '';
  tag.nextElementSibling.innerHTML = '';

  //Iniciamos la validación
  console.log(this_button.getAttribute('id_horario'));
  let data = new FormData();
  data.append('function', 'verificar_fechas_horario');
  data.append('f_inf', f_inf.value);
  data.append('f_sup', f_sup.value);
  data.append('id_horario', this_button.getAttribute('id_horario'));
  fetch('tab_rules_functions.php', {
    method: "POST",
    body: data
  }).then (function (response){
      if(response.ok){
        return response.text();
      } else {
        throw "Error en la llamada";
      }
  })
  .then (function(data){
    console.log(data);
    data = JSON.parse(data);
    switch(data.error_state) {
      //Case -1: No hay fechas colocadas aún
      case -1: {
        if(f_inf.value == '') {error_flag = true; f_inf.parentNode.nextElementSibling.innerHTML = '¡No puedes dejar esta fecha vacía!';}
        if(f_sup.value == '') {error_flag = true; f_sup.parentNode.nextElementSibling.innerHTML = '¡No puedes dejar esta fecha vacía!';}
        break;
      }
      //Case 0: Existe una superposición de fechas
      case 0: {
        error_flag = true;
        f_inf.parentNode.nextElementSibling.innerHTML = data.mensaje;
        break;
      }
      default: console.log('Éxito'); break;
    }

    //Verificamos la validez de las horas
    //hourDiff devuelve true si la diferencia de horas es mayor a 0. Devuelve false si es menor o igual a 0
    if(h_inf.value != '' && h_sup.value != '' && !hourDiff(h_sup, h_inf)) {
      error_flag = true;
      h_inf.parentNode.nextElementSibling.innerHTML = 'Error: Las horas seleccionadas no son válidas';
    } else {
      if(h_inf.value == '') {error_flag = true; h_inf.parentNode.nextElementSibling.innerHTML = '¡No puedes dejar esta hora vacía!';}
      if(h_sup.value == '') {error_flag = true; h_sup.parentNode.nextElementSibling.innerHTML = '¡No puedes dejar esta hora vacía!';}
    }

    //La etiqueta debe tener contenido
    //if(tag.value == '') {error_flag = true; tag.nextElementSibling.innerHTML = '¡No puedes dejar la etiqueta vacía!';}
    //Limpiamos los espacios de exceso en tag
    tag.value = tag.value.trim().replace(/\s+/g,' ');
    if(tag.value == '') {error_flag = true; tag.nextElementSibling.innerHTML = '¡No puedes dejar la etiqueta vacía!';}
    if(tag.value.replace(/[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜ\u00f1\u00d1_0-9- ]/g, '').length != 0) {error_flag = true; tag.nextElementSibling.innerHTML = 'Solo se permiten letras, números, "_" y "-"';}

    //Si error_flag es false, la validación fue exitosa, entonces se procede a ACTUALIZAR.
    if(!error_flag){
      console.log('Procedemos a la inserción');
      let data_2 = new FormData();
      data_2.append('function', 'actualizar_nuevo_horario');
      data_2.append('f_inf', f_inf.value);
      data_2.append('f_sup', f_sup.value);
      data_2.append('h_inf', h_inf.value);
      data_2.append('h_sup', h_sup.value);
      data_2.append('tag', tag.value);
      data_2.append('chk_hab', (chk_hab.checked)? 't': 'f');
      data_2.append('id_horario', this_button.getAttribute('id_horario'));
      fetch('tab_rules_functions.php', {
        method: "POST",
        body: data_2
      }).then (function (response){
          if(response.ok){
            return response.text();
          } else {
            throw "Error en la llamada";
          }
      })
      .then (function(data_2){
        switch(data_2) {
          default: console.log('Error: No se realizaron cambios.'); break;
          case '1': {
            console.log('Actualizar la tabla');
            //Reiniciamos los valores de búsqueda
            document.querySelector('#tag_searcher').value = '';
            document.querySelector('#search_f_inf').value = '';
            document.querySelector('#search_f_sup').value = '';
            //Y recargamos la tabla de resultados
            loadTablaHorarios(
              document.getElementById('tabla_horarios'), 
              document.getElementById('tag_searcher'), 
              document.getElementById('search_f_inf'), 
              document.getElementById('search_f_sup'));

            //Ahora cerramos el modal
            closePrompt(document.querySelector('.floating-panel.big'), false); 

            //Ocultamos el botón de Actualizar horario
            document.querySelector('.tabpanelbuttons.update').classList.add('hide');
            document.querySelector('.tabpanelbuttons.update').removeAttribute('id_horario');


            

            //Ahora notificamos del resultado al usuario

            //Según la documentación, remove de una clase inexistente no causa error
            document.querySelector('.notification-down-left.update').classList.remove('animate');
            //Según la documentación, añadir una clase ya existente causa que esta orden se ignore
            document.querySelector('.notification-down-left.update').classList.add('hide');

            //Incrementamos el manejador de notificaciones global en 1 (estado inicial = 0)
            notif_handler++;
            //Ahora igualamos el manejador de notificaciones local al global actual
            let local_notif_handler = notif_handler;

            console.log('Esta función se ejecuta inmediatamente: ' + notif_handler);
            console.log('Esta función se ejecuta inmediatamente LOCAL: ' + local_notif_handler);
            
            //Primero, programamos la notificación para que desaparezca
            setTimeout(function () {
              //Si no se ha lanzado ninguna notificación nueva o seguida dentro de los próximos 5 segundos, local_notif será igual a notif global
              //Pero si se ha lanzado una o más notificaciones entonces local_notif no será igual a notif global, pues el global se incrementa cada vez que se va a lanzar una notificación
              //Entonces, si en 5 segundos después de incrementar el global, este no se ha vuelto a incrementar, local notif será igual a notif global, y, por tanto, removera animate y añadirá hide
              //Pero, si en los 5 segundos el global ha cambiado, es porque hay más de una notificación activa, entonces, que esta función no ocasione que quite la notificación antes de tiempo.
              console.log('Esta función se ejecuta en 5 segundos: ' + notif_handler);
              console.log('Esta función se ejecuta en 5 segundos LOCAL: ' + local_notif_handler);
              if(local_notif_handler == notif_handler) {
                document.querySelector('.notification-down-left.update').classList.remove('animate');
                document.querySelector('.notification-down-left.update').classList.add('hide');
              }
            }, 5000);
            
            document.querySelector('.notification-down-left.update').classList.add('animate');
            document.querySelector('.notification-down-left.update').classList.remove('hide');
            break;
          }
        }
      })
      .catch (function(error){
          console.log(error);
      });

    }

  })
  .catch (function(error){
      console.log(error);
  });
}

function loadTablaHorarios (table_body, tag_searched, f_inf, f_sup) {
  let data = new FormData();
  data.append('function','tabla_busqueda_horario');
  data.append('f_inf', f_inf.value);
  data.append('f_sup', f_sup.value);
  data.append('tag_searched',tag_searched.value);
  fetch('tab_rules_functions.php', {
      method: "POST",
      body: data
  }).then (function (response){
      if(response.ok){
          return response.text();
      } else {
          throw "Error en la llamada";
      }
  })
  .then (function(data){
    data = JSON.parse(data);
    table_body_html = '';
    if(data.length != 0) {
      //Si hay data, que la muestre en la tabla
      for(i = 0; i < data.length; i++) {
        table_body_html += `<tr id_horario="${data[i].id_horario}">`;
        for (var key in data[i]) {
          switch(key){
            case 'id_horario': case 'habilitado': continue; break;
            case 'inicio_periodo': case 'fin_periodo': table_body_html += `<td>${data[i][key].split('-')[2] + '-' + data[i][key].split('-')[1] + '-' + data[i][key].split('-')[0]}</td>`; break;
            default: table_body_html += `<td>${data[i][key]}</td>`; break;
          }
        }
        table_body_html += `</tr>`;
      }
    } else {
      //Si no la hay, que muestre una celda del ancho de toda la tabla
      table_body_html = `<tr><td colspan=${document.querySelectorAll('#lista_horarios > thead > tr > th').length}>No se encontraron resultados</td></tr>`;
    }
    table_body.innerHTML = table_body_html;
  })
  .catch (function(error){
    console.log(error);
  });        
}

function promptAddHorario(panel) {
  //Animación de carga
  loadingAnimation(true);
  
  for(i = 0; i < document.querySelectorAll('.validation-error').length; i++) {
    document.querySelectorAll('.validation-error')[i].innerHTML = '';
  }

  document.getElementById("darkopacity").classList.remove("hide");
  document.getElementById("darkopacity").classList.add("show");

  document.getElementById('tag_horario').value = '';
  document.getElementById('fecha_inf').value = '';
  document.getElementById('fecha_sup').value = '';
  document.getElementById('hora_inf').value = '';
  document.getElementById('hora_sup').value = '';
  document.getElementById('chk_habilitado').checked = true;
  document.getElementById('chk_habilitado').disabled = true;

  panel.classList.remove("hide");
  panel.style.marginTop = (panel.offsetHeight / -2) + 'px';

  //Quitamos animación de carga
  loadingAnimation(false);
}

function promptUpdHorario (panel, this_button){
  //Animación de carga
  loadingAnimation(true);

  for(i = 0; i < document.querySelectorAll('.validation-error').length; i++) {
    document.querySelectorAll('.validation-error')[i].innerHTML = '';
  } 

  //Conseguimos el id horario de la fila del botón
  id_horario = this_button.parentNode.parentNode.getAttribute('id_horario');
  let data = new FormData();
  data.append('function','informacion_horario');
  data.append('id_horario', id_horario);
  fetch('tab_rules_functions.php', {
      method: "POST",
      body: data
  }).then (function (response){
      if(response.ok){
          return response.text();
      } else {
          throw "Error en la llamada";
      }
  })
  .then (function(data){
    data = JSON.parse(data);
    console.log(data);
    table_body_html = '';
    for (var key in data) {
      console.log(key);
      console.log(data[key]);
      switch(key){
        case 'etiqueta': {
          document.getElementById('tag_horario').value = data[key];
          break;
        }
        case 'f_ini': {
          document.getElementById('fecha_inf').value = data[key];
          break;
        }
        case 'f_fin': {
          document.getElementById('fecha_sup').value = data[key];
          break;
        }
        case 'h_ini': {
          document.getElementById('hora_inf').value = data[key];
          break;
        }
        case 'h_fin': {
          document.getElementById('hora_sup').value = data[key];
          break;
        }
        case 'chk_habilitado': {
          document.getElementById('chk_habilitado').checked = (data[key] == 't')? true: false;
          break;
        }
        default: break;
      }
    }

    //Una vez cargada la información recuperada del servidor, hacemos visible el panel/modal
    document.getElementById("darkopacity").classList.remove("hide");
    document.getElementById("darkopacity").classList.add("show");
    
    document.getElementById('chk_habilitado').disabled = false;
  
    panel.classList.remove("hide");
    panel.style.marginTop = (panel.offsetHeight / -2) + 'px';

    //Quitamos animación de carga
    loadingAnimation(false);
  })
  .catch (function(error){
    console.log(error);
  });        
}

function loadingAnimation(action){
  //Si action es true, la animación aparecerá, si es falso, desaparecerá
  if(action){
    document.getElementById('darkopacity_above_all').classList.remove('hide');
    document.getElementById('darkopacity_above_all').classList.add('show');
  } else {
    document.getElementById('darkopacity_above_all').classList.remove('show');
    document.getElementById('darkopacity_above_all').classList.add('hide');
  }
}

function loadLastTimeUpdatedReloj() {
  let data = new FormData();
  data.append('function','get_last_timestamp_updated_biostar');
  fetch('tab_search_functions.php', {
      method: "POST",
      body: data
  }).then (function (response){
      if(response.ok){
          return response.text();
      } else {
          throw "Error en la llamada";
      }
  })
  .then (function(data){
    console.log(data);
    document.querySelector('.biostar-last-update').innerHTML = `Última actualización del reloj:<br>${data}`;
  })
  .catch (function(error){
    console.log(error);
  });
  
}