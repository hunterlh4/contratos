<?php
class Boleta extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['usuario_autenticado']) || ($_SESSION['usuario_autenticado'] != "true")) {
            header('Location: ' . BASE_URL . 'admin');
            exit;
        }
        if ($_SESSION['nivel'] == 5) {
            header('Location: ' . BASE_URL . 'errors');
            exit;
        }
    }
    public function index()
    {
        if ($_SESSION['nivel'] !== 1 && $_SESSION['nivel'] !== 100) {
            header('Location: ' . BASE_URL . 'errors');
            exit;
        }
        $data['title'] = 'Boleta';
        $data1 = '';

        $this->views->getView('Administracion', "Boleta", $data, $data1);
    }

    public function Porteria()
    {
        if ($_SESSION['nivel'] !== 4 && $_SESSION['nivel'] !== 100) {
            header('Location: ' . BASE_URL . 'errors');
            exit;
        }
        $data['title'] = 'Porteria';
        $data1 = '';

        $this->views->getView('Administracion', "Boleta_Porteria", $data, $data1);
    }
    public function listar()
    {
        $parametro = $_POST['parametro'];
        // $parametro = 'dias';
        $data = $this->model->getBoletas($parametro);



        for ($i = 0; $i < count($data); $i++) {
            $numero = $data[$i]['numero'];
            if ($data[$i]['numero'] == null) {
                $numero = '0';
            }
            $data[$i]['posicion'] = $i + 1;

            $numero_formateado = str_pad($numero, 9, '0', STR_PAD_LEFT);
            $data[$i]['numero'] = $numero_formateado;


            $fecha_inicio = $data[$i]['fecha_inicio'];
            $fecha_fin = $data[$i]['fecha_fin'];
            $estado_tramite = $data[$i]['estado_tramite'];




            $fecha_inicio = date('d-m-Y', strtotime($fecha_inicio));
            $fecha_fin = date('d-m-Y', strtotime($fecha_fin));

            if ($fecha_inicio == $fecha_fin) {
                $data[$i]['fecha_nueva'] = $fecha_inicio;
            } else {
                $data[$i]['fecha_nueva'] = $fecha_inicio . '<br>' . $fecha_fin;
            }
            $data[$i]['fecha_inicio_formateada'] = $fecha_inicio;
            $data[$i]['fecha_fin_formateada'] = $fecha_fin;

            $data[$i]['accion'] = '<div class="d-flex">
                <button class="btn btn-info" type="button" onclick="view(' . $data[$i]['bid'] . ')"><i class="fas fa-eye"></i></button>
                </div>';
            if ($estado_tramite == 'Pendiente') {
                $data[$i]['accion'] = '<div class="d-flex">
                <button class="btn btn-primary" type="button" onclick="edit(' . $data[$i]['bid'] . ')"><i class="fas fa-edit"></i></button>
                </div>';
            }
            if ($estado_tramite == 'Aprobado') {
                $data[$i]['estado_tramite'] = '<span class="badge badge-success">Aprobado</span>';
            }
            if ($estado_tramite == 'Rechazado') {
                $data[$i]['estado_tramite'] = '<span class="badge badge-danger">Rechazado</span>';
            }
            if ($estado_tramite == 'Pendiente') {
                $data[$i]['estado_tramite'] = '<span class="badge badge-warning">Pendiente</span>';
            }
            if ($estado_tramite == 'Anulado') {
                $data[$i]['estado_tramite'] = '<span class="badge badge-light"> Anulado </span>';
            }



            // <button class="btn btn-danger" type="button" onclick="ViewUser(' . $data[$i]['usuario_id'] . ')"><i class="fas fa-eye"></i></button>
            // <button class="btn btn-danger" type="button" onclick="DeleteUser(' . $data[$i]['usuario_id'] . ')"><i class="fas fa-eye"></i></button>
            // colocar eliminar si es necesario
        }
        echo json_encode($data);
        die();
    }
    // adminsitrador
    public function registrar2()
    {


        if (isset($_POST['solicitante']) && isset($_POST['aprobador']) && isset($_POST['fecha_inicio']) && isset($_POST['fecha_fin'])  && isset($_POST['razon']) && isset($_POST['otra_razon'])) {

            $id = $_POST['id'];
            $solicitante = $_POST['solicitante'];
            $aprobador = $_POST['aprobador'];
            $fecha_inicio = $_POST['fecha_inicio'];
            $fecha_fin = $_POST['fecha_fin'];
            $tipo = $_POST['tipo'];
            // $salida = $_POST['hora_salida'];
            // $entrada = $_POST['hora_entrada'];
            $razon = $_POST['razon'];
            $razon_especifica = $_POST['otra_razon'];

            if (empty($solicitante) || empty($aprobador) || empty($fecha_inicio) || empty($fecha_fin) || empty($razon) || empty($razon_especifica)) {
                // if (empty($solicitante) || empty($aprobador) || empty($fecha_inicio) || empty($salida) || empty($entrada) || empty($razon) || empty($razon_especifica)) {
                $respuesta = ['msg' => 'todo los campos son requeridos', 'icono' => 'warning'];
            } else {
                $inicio_timestamp = strtotime($fecha_inicio);
                $fin_timestamp = strtotime($fecha_fin);
                if ($inicio_timestamp > $fin_timestamp) {
                    $respuesta = ['msg' => 'la fecha inicio no puede ser menor', 'icono' => 'warning'];
                } else {
                    $datos_log = [
                        "id" => $id,
                        "solicitante" => $solicitante,
                        "aprobador" => $aprobador,
                        "fecha_inicio" => $fecha_inicio,
                        "fecha_fin" => $fecha_fin,
                        // "salida" => $salida,
                        // "entrada" => $entrada,
                        "razon" => $razon,
                        "razon_especifica" => $razon_especifica,


                    ];
                    $datos_log_json = json_encode($datos_log);
                    $existencia = $this->model->verificarExistencia($fecha_inicio, $fecha_fin, $solicitante);
                    $valor = 0;
                    $dato = [];
                    $i = 0;
                    $id_temporal = '';

                    if (count($existencia) == 0 && $tipo == '2') {
                        // $valor = 0;                        
                    }
                    if (count($existencia) == 1 && $tipo == '2') {
                        $valor = 1;
                        $id_temporal = $existencia[0]['id'];
                    }
                    if (count($existencia) > 1 && $tipo == '2') {
                        foreach ($existencia as $elemento) {
                            $i++; // Mostrar cada elemento
                            $dato[$i] = $elemento['id'];
                        }
                        $valor = 2;
                    }


                    if (empty($id)) {
                        $estado_tramite = 'Pendiente';
                        // $data = $this->model->registrar($solicitante, $aprobador, $fecha_inicio, $fecha_fin, $salida, $entrada, $razon,$razon_especifica, $estado_tramite);

                        if ($tipo == '1') {
                            $data = $this->model->registrar($solicitante, $aprobador, $fecha_inicio, $fecha_fin, $razon, $razon_especifica, $estado_tramite, $tipo);
                            if ($data > 0) {
                                // $respuesta = ['msg' => $existencia, 'icono' => 'success'];
                                $respuesta = ['msg' => 'Boleta registrada', 'icono' => 'success'];

                                // $this->model->registrarlog($_SESSION['id'],'Crear','Boleta', $datos_log_json);
                            } else {
                                $respuesta = ['msg' => 'error al registrar', 'icono' => 'error'];
                            }
                        }

                        if ($tipo == '2' && $valor == 0) {
                            $data = $this->model->registrar($solicitante, $aprobador, $fecha_inicio, $fecha_fin, $razon, $razon_especifica, $estado_tramite, $tipo);
                            if ($data > 0) {
                                // $respuesta = ['msg' => $existencia, 'icono' => 'success'];
                                $respuesta = ['msg' => 'Boleta registrada', 'icono' => 'success'];

                                // $this->model->registrarlog($_SESSION['id'],'Crear','Boleta', $datos_log_json);
                            } else {
                                $respuesta = ['msg' => 'error al registrar', 'icono' => 'error'];
                            }
                        }
                        if ($tipo == '2' && $valor != 0) {
                            $respuesta = ['msg' => 'Escoja una fecha diferente', 'icono' => 'error'];
                        }
                        // $respuesta = ['msg' => 'modificar', 'icono' => 'success');
                    } else {
                        $result = $this->model->verificar($id);
                        if ($result['estado_tramite'] == 'Pendiente') {


                            if ($tipo == '1') {
                                $data = $this->model->modificar($solicitante, $aprobador, $fecha_inicio, $fecha_fin, $razon, $razon_especifica, $id);
                                if ($data > 0) {
                                    $respuesta = ['msg' => 'Boleta Actualizada', 'icono' => 'success'];
                                } else {
                                    $respuesta = ['msg' => 'error al Actualizar', 'icono' => 'error'];
                                }
                            }

                            if ($tipo == '2' && ($valor == 1 ||   $valor == 0)) {
                                if ($valor == 0) {
                                    $data = $this->model->modificar($solicitante, $aprobador, $fecha_inicio, $fecha_fin, $razon, $razon_especifica, $id);
                                    if ($data > 0) {
                                        $respuesta = ['msg' => 'Boleta Actualizada', 'icono' => 'success'];
                                        // $respuesta = ['msg' => 'Boleta Actualizada', 'icono' => 'success'];
                                        // $this->model->registrarlog($_SESSION['id'],'Actualizar','Boleta', $datos_log_json);
                                    } else {
                                        $respuesta = ['msg' => 'error al Actualizar', 'icono' => 'error'];
                                    }
                                }

                                if ($valor == 1) {
                                    if ($id == $id_temporal) {
                                        $data = $this->model->modificar($solicitante, $aprobador, $fecha_inicio, $fecha_fin, $razon, $razon_especifica, $id);
                                        if ($data > 0) {
                                            $respuesta = ['msg' => 'Boleta Actualizada', 'icono' => 'success'];
                                            // $respuesta = ['msg' => 'Boleta Actualizada', 'icono' => 'success'];
                                            // $this->model->registrarlog($_SESSION['id'],'Actualizar','Boleta', $datos_log_json);
                                        } else {
                                            $respuesta = ['msg' => 'error al Actualizar', 'icono' => 'error'];
                                        }
                                    } else {
                                        $respuesta = ['msg' => 'Escoja una fecha diferente', 'icono' => 'error'];
                                    }
                                }
                            }
                            if ($tipo == '2' && $valor == 2) {
                                $respuesta = ['msg' => 'ya existe una boleta', 'icono' => 'error'];
                            }
                        } else {
                            $respuesta = ['msg' => 'La Solicitud ya fue enviada, Espere su Respuesta', 'icono' => 'error'];
                        }
                    }
                }
            }
        } else {
            // Si no se recibieron todos los datos esperados, devuelve un mensaje de error

            $respuesta = ['msg' => 'error', 'icono' => 'error'];
        }

        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $respuesta = ['msg' => 'Método no permitido. Solo se aceptan solicitudes POST.', 'icono' => 'error'];
            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
            die();
        }

        $id = $_POST['id'] ?? '';
        $solicitante = $_POST['solicitante'] ?? '';
        $aprobador = $_POST['aprobador'] ?? '';
        $fecha_inicio = $_POST['fecha_inicio'] ?? '';
        $fecha_fin = $_POST['fecha_fin'] ?? '';
        $tipo = $_POST['tipo'] ?? '';
        $razon = $_POST['razon'] ?? '';
        $razon_especifica = $_POST['otra_razon'] ?? '';
        $hora_salida = $_POST['hora_salida'] ?? '';
        $hora_entrada = $_POST['hora_entrada'] ?? '';

        $error_message = '';
        // comision, compensacion, otros
        // tipo = 1 horas ,2 dias

        $accion = $id ? 'editar' : 'crear';

        if (empty($solicitante) || $solicitante == '') {
            $error_message .= "El <b>solicitante</b> es requerido.<br>";
        }
        if (empty($aprobador)) {
            $error_message .= "El <b>aprobador</b> es requerido.<br>";
        }
        if (empty($fecha_inicio)) {
            $error_message .= "La <b>fecha de inicio</b> es requerida.<br>";
        }
        if (empty($fecha_fin)) {
            $error_message .= "La <b>fecha de fin</b> es requerida.<br>";
        }
        if (empty($hora_salida) && $tipo == 1) {
            $error_message .= "La <b>Hora de Salida</b> es requerida.<br>";
        }
        if (empty($hora_entrada) && $tipo == 1) {
            $error_message .= "La <b>Hora de Entrada</b> es requerida.<br>";
        }
        if (empty($razon)) {
            $error_message .= "La <b>razón</b> es requerida.<br>";
        }
        $razones_requieren_motivo = ['CS', 'DHE', 'OTR'];
        if (in_array($razon, $razones_requieren_motivo) && empty($razon_especifica)) {
            $error_message .= "El <b>Motivo</b> es requerido.<br>";
        }
        // comision, compensacion, otros || cs, DHE , OTR

        $inicio_timestamp = strtotime($fecha_inicio);
        $fin_timestamp = strtotime($fecha_fin);
        if ($inicio_timestamp > $fin_timestamp) {
            $error_message .= "La <b>Fecha</b> no puede ser menor.<br>";
        }

        $salida_timestamp = strtotime($hora_salida);
        $retorno_timestamp = strtotime($hora_entrada);
        if ($salida_timestamp > $retorno_timestamp) {
            $error_message .= "La <b>Hora</b> no puede ser menor.<br>";
        }

        $valor = 0;
        $dato = [];
        $i = 0;
        $id_temporal = '';
        $existencia = '';
        if ($tipo == '1' && $solicitante) {
            $existencia = $this->model->verificarExistenciaHora($fecha_inicio, $hora_salida, $hora_entrada, $solicitante);

            if (count($existencia) == 1) {
                $valor = 1;
                $id_temporal = $existencia[0]['id'];
            }
            if (count($existencia) > 1) {
                foreach ($existencia as $elemento) {
                    $i++; // Mostrar cada elemento
                    $dato[$i] = $elemento['id'];
                }
                $valor = 2;
            }
        }
        if ($tipo == '2' && $solicitante) {
            $hora_salida = '00:00:00';
            $hora_entrada = '00:00:00';
            $existencia = $this->model->verificarExistenciaFecha($fecha_inicio, $fecha_fin, $solicitante);

            if (count($existencia) == 1) {
                $valor = 1;
                $id_temporal = $existencia[0]['id'];
            }
            if (count($existencia) > 1) {
                foreach ($existencia as $elemento) {
                    $i++; // Mostrar cada elemento
                    $dato[$i] = $elemento['id'];
                }
                $valor = 2;
            }
        }
        if ($accion == 'crear'  && $tipo == '2' && $valor != 0) {
            $error_message .= "La <b>Fecha</b> se encuentra en uso.<br>";
        }
        if ($accion == 'crear'  && $tipo == '1' && $valor != 0) {
            $error_message .= "La <b>Hora</b> se encuentra en uso.<br>";
        }


        if ($accion == 'editar' && $tipo == '2' && $valor > 0  && $id != $id_temporal) {
            $error_message .= "La <b>Fecha</b> se encuentra en uso.<br>";
        }
        if ($accion == 'editar' && $tipo == '1' && $valor > 0  && $id != $id_temporal) {
            $error_message .= "La <b>Hora</b> se encuentra en uso.<br>" . $id . 'id' . $id_temporal . 'valor' . $valor;
        }
        $inicio_completo = $fecha_inicio . ' ' . $hora_salida;
        $fin_completo = $fecha_fin . ' ' . $hora_entrada;
        $inicio_timestamp = strtotime($inicio_completo);
        $fin_timestamp = strtotime($fin_completo);
        $diferencia_segundos = $fin_timestamp - $inicio_timestamp;
        $horas = floor($diferencia_segundos / 3600);
        $minutos = floor(($diferencia_segundos % 3600) / 60);
        $segundos = $diferencia_segundos % 60;

        // Formatear la diferencia en formato HH:MM:SS
        $duracion = str_pad($horas, 2, '0', STR_PAD_LEFT) . ':' . str_pad($minutos, 2, '0', STR_PAD_LEFT) . ':' . str_pad($segundos, 2, '0', STR_PAD_LEFT);


        if (!empty($error_message)) {
            echo json_encode(["icono" => "error", "msg" => $error_message]);
            // echo json_encode($existencia);
            exit;
        }


        // sin errores
        $justificacion ='si';
        $estado_tramite = 'Aprobado';
        if ($accion == 'crear') {
            // $data = '';
            
            // if ($tipo == '1') {
            $data = $this->model->registrarAdmin(
                $solicitante,
                $aprobador,
                $hora_salida,
                $hora_entrada,
                $duracion,
                $fecha_inicio,
                $fecha_fin,
                $razon,
                $razon_especifica,
                $estado_tramite,
                $tipo,
               
            );
            if ($data > 0) {
                $respuesta = ['msg' => 'Boleta registrada', 'icono' => 'success'];
                // $this->model->registrarlog($_SESSION['id'],'Crear','Boleta', $datos_log_json);
            } else {
                $respuesta = ['msg' => 'error al registrar', 'icono' => 'error'];
            }
            $respuesta = ['msg' => 'Boleta registrada' . $id, 'icono' => 'success'];
            
          
        }
        if ($accion == 'editar') {

            $data = $this->model->modificarAdmin(
                $solicitante,
                $aprobador,
                $hora_salida,
                $hora_entrada,
                $duracion,
                $fecha_inicio,
                $fecha_fin,
                $razon,
                $razon_especifica,
                $estado_tramite,
                
                $id
            );
            if ($data > 0) {
                $respuesta = ['msg' => 'Boleta Actualizada', 'icono' => 'success'];
            } else {
                $respuesta = ['msg' => 'error al Actualizar', 'icono' => 'error'];
            }
        }

        if($tipo==1){
            if($accion=='crear'){
                $this->model->registrarJustificacionHoras($justificacion,$fecha_inicio,$solicitante);
            }
            if($accion=='editar'){
                $justificacion ='no';
                $this->model->registrarJustificacionHoras($justificacion,$fecha_inicio,$solicitante);
                $data = $this->model->obtenerBoletas($solicitante,$fecha_inicio);
                $valor = count($data);
                if($valor>0){
                    $justificacion='si';
                    $this->model->registrarJustificacionHoras($justificacion,$fecha_inicio,$solicitante);
                    
                }
               
            }
           
        }
        if($tipo==2){

        }
        
        echo json_encode($respuesta);
        exit;
    }
    // trabajador
    public function registrarme()
    {
        if (isset($_POST['aprobador']) && isset($_POST['fecha_inicio']) && isset($_POST['fecha_fin'])  && isset($_POST['razon']) && isset($_POST['otra_razon'])) {
            $id = $_SESSION['id'];
            $data = $this->model->getusuario($id);
            $solicitante = $data['trabajador_id'];


            $id = $_POST['id'];
            $tipo = $_POST['tipo'];

            $aprobador = $_POST['aprobador'];
            $fecha_inicio = $_POST['fecha_inicio'];
            $fecha_fin = $_POST['fecha_fin'];
            // $salida = $_POST['hora_salida'];
            // $entrada = $_POST['hora_entrada'];
            $razon = $_POST['razon'];
            $razon_especifica = $_POST['otra_razon'];
            // $respuesta = ['msg' => 'llego a pendiente'.$_POST['tipo'], 'icono' => 'success'];

            if (empty($solicitante) || empty($aprobador) || empty($fecha_inicio) || empty($fecha_fin) ||   empty($razon) || empty($razon_especifica)) {
                $respuesta = ['msg' => 'todo los campos son requeridos', 'icono' => 'warning'];
            } else {

                $inicio_timestamp = strtotime($fecha_inicio);
                $fin_timestamp = strtotime($fecha_fin);
                if ($inicio_timestamp > $fin_timestamp) {
                    $respuesta = ['msg' => 'la fecha inicio no puede ser menor', 'icono' => 'warning'];
                } else {
                    $datos_log = [
                        "id" => $id,
                        "solicitante" => $solicitante,
                        "aprobador" => $aprobador,
                        "fecha_inicio" => $fecha_inicio,
                        "fecha_fin" => $fecha_fin,
                        // "salida" => $salida,
                        // "entrada" => $entrada,
                        "razon" => $razon,
                        "razon_especifica" => $razon_especifica,

                    ];
                    $datos_log_json = json_encode($datos_log);
                    $existencia = $this->model->verificarExistencia($fecha_inicio, $fecha_fin, $solicitante);
                    $valor = 0;
                    $dato = [];
                    $i = 0;
                    $id_temporal = '';

                    if (count($existencia) == 0 && $tipo == '2') {
                        // $valor = 0;                        
                    }
                    if (count($existencia) == 1 && $tipo == '2') {
                        $valor = 1;
                        $id_temporal = $existencia[0]['id'];
                    }
                    if (count($existencia) > 1 && $tipo == '2') {
                        foreach ($existencia as $elemento) {
                            $i++; // Mostrar cada elemento
                            $dato[$i] = $elemento['id'];
                        }
                        $valor = 2;
                    }

                    if (empty($id)) {
                        $estado_tramite = 'Pendiente';


                        if ($tipo == '1') {
                            $data = $this->model->registrar($solicitante, $aprobador, $fecha_inicio, $fecha_fin, $razon, $razon_especifica, $estado_tramite, $tipo);
                            if ($data > 0) {
                                // $respuesta = ['msg' => $existencia, 'icono' => 'success'];
                                $respuesta = ['msg' => 'Boleta registrada', 'icono' => 'success'];

                                // $this->model->registrarlog($_SESSION['id'],'Crear','Boleta', $datos_log_json);
                            } else {
                                $respuesta = ['msg' => 'error al registrar', 'icono' => 'error'];
                            }
                        }

                        if ($tipo == '2' && $valor == 0) {
                            $data = $this->model->registrar($solicitante, $aprobador, $fecha_inicio, $fecha_fin, $razon, $razon_especifica, $estado_tramite, $tipo);
                            if ($data > 0) {
                                // $respuesta = ['msg' => $existencia, 'icono' => 'success'];
                                $respuesta = ['msg' => 'Boleta registrada', 'icono' => 'success'];

                                // $this->model->registrarlog($_SESSION['id'],'Crear','Boleta', $datos_log_json);
                            } else {
                                $respuesta = ['msg' => 'error al registrar', 'icono' => 'error'];
                            }
                        }
                        if ($tipo == '2' && $valor != 0) {
                            $respuesta = ['msg' => 'Escoja una fecha diferente', 'icono' => 'error'];
                        }
                        // $respuesta = ['msg' => 'modificar', 'icono' => 'success');
                    } else {
                        $result = $this->model->verificar($id);
                        if ($result['estado_tramite'] == 'Pendiente') {


                            if ($tipo == '1') {
                                $data = $this->model->modificar($solicitante, $aprobador, $fecha_inicio, $fecha_fin, $razon, $razon_especifica, $id);
                                if ($data > 0) {
                                    $respuesta = ['msg' => 'Boleta Actualizada', 'icono' => 'success'];
                                } else {
                                    $respuesta = ['msg' => 'error al Actualizar', 'icono' => 'error'];
                                }
                            }

                            if ($tipo == '2' && ($valor == 1 ||   $valor == 0)) {
                                if ($valor == 0) {
                                    $data = $this->model->modificar($solicitante, $aprobador, $fecha_inicio, $fecha_fin, $razon, $razon_especifica, $id);
                                    if ($data > 0) {
                                        $respuesta = ['msg' => 'Boleta Actualizada', 'icono' => 'success'];
                                        // $respuesta = ['msg' => 'Boleta Actualizada', 'icono' => 'success'];
                                        // $this->model->registrarlog($_SESSION['id'],'Actualizar','Boleta', $datos_log_json);
                                    } else {
                                        $respuesta = ['msg' => 'error al Actualizar', 'icono' => 'error'];
                                    }
                                }
                                if ($valor == 1) {
                                    if ($id == $id_temporal) {
                                        $data = $this->model->modificar($solicitante, $aprobador, $fecha_inicio, $fecha_fin, $razon, $razon_especifica, $id);
                                        if ($data > 0) {
                                            $respuesta = ['msg' => 'Boleta Actualizada', 'icono' => 'success'];
                                            // $respuesta = ['msg' => 'Boleta Actualizada', 'icono' => 'success'];
                                            // $this->model->registrarlog($_SESSION['id'],'Actualizar','Boleta', $datos_log_json);
                                        } else {
                                            $respuesta = ['msg' => 'error al Actualizar', 'icono' => 'error'];
                                        }
                                    } else {
                                        $respuesta = ['msg' => 'Escoja una fecha diferente', 'icono' => 'error'];
                                    }
                                }
                            }
                            if ($tipo == '2' && $valor == 2) {
                                $respuesta = ['msg' => 'ya existe una boleta', 'icono' => 'error'];
                            }
                        } else {
                            $respuesta = ['msg' => 'La Solicitud ya fue revisada', 'icono' => 'error'];
                        }
                    }
                }
            }
        } else {
            // Si no se recibieron todos los datos esperados, devuelve un mensaje de error

            $respuesta = ['msg' => 'error', 'icono' => 'error'];
        }

        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrarHora()
    {
        // if (isset($_POST['solicitante']) && isset($_POST['aprobador']) && isset($_POST['fecha_inicio']) && isset($_POST['fecha_fin']) && isset($_POST['hora_salida']) && isset($_POST['hora_entrada']) && isset($_POST['razon'])&& isset($_POST['otra_razon'])) {

        if ((isset($_POST['hora_salida']) || isset($_POST['hora_entrada'])) && isset($_POST['id'])) {
            $id = $_POST['id'];

            $salida = $_POST['hora_salida'];
            $retorno = $_POST['hora_entrada'];



            if (empty($salida) && empty($retorno)) {
                $respuesta = ['msg' => 'todo los campos son requeridos', 'icono' => 'warning'];
            } else {

                $inicio_timestamp = strtotime($salida);
                $fin_timestamp = strtotime($retorno);

                if (!empty($salida) && empty($retorno)) {
                    $result = $this->model->verificar($id);
                    if ($result['estado_tramite'] == 'Aprobado'  && empty($result['hora_salida'])) {

                        $data = $this->model->modificarSalida($salida, $id);
                        if ($data > 0) {
                            $respuesta = ['msg' => 'Boleta Actualizada', 'icono' => 'success'];
                            $datos_log = [
                                "id" => $id,
                                "salida" => $salida,
                                // "entrada" => $retorno,
                            ];
                            $datos_log_json = json_encode($datos_log);

                            // $this->model->registrarlog($_SESSION['id'],'Actualizar','Boleta', $datos_log_json);
                        } else {
                            $respuesta = ['msg' => 'error al Actualizar', 'icono' => 'error'];
                        }
                    } else {
                        $respuesta = ['msg' => 'La Solicitud fue rechazada', 'icono' => 'error'];
                    }
                }

                if (!empty($salida) && !empty($retorno)) {
                    $diferencia_segundos = $fin_timestamp - $inicio_timestamp;
                    if ($diferencia_segundos < 0) {
                        // Si la diferencia es negativa, significa que la hora de entrada es al día siguiente
                        $fin_timestamp = strtotime('+1 day', $fin_timestamp);
                        $diferencia_segundos = $fin_timestamp - $inicio_timestamp;
                    }
                    $horas = floor($diferencia_segundos / 3600);
                    $minutos = floor(($diferencia_segundos % 3600) / 60);
                    $diferencia = $horas . ':' . str_pad($minutos, 2, '0', STR_PAD_LEFT);

                    if ($inicio_timestamp > $fin_timestamp) {
                        $respuesta = ['msg' => 'la fecha salida no puede ser menor' . $salida . '-' . $retorno, 'icono' => 'warning'];
                    } else {
                        $result = $this->model->verificar($id);
                        if ($result['estado_tramite'] == 'Aprobado' && empty($result['hora_entrada'])) {
                            if (!empty($retorno)) {
                                $data = $this->model->modificarEntrada($retorno, $diferencia, $id);
                            }
                            if ($data > 0) {
                                $respuesta = ['msg' => 'Boleta Actualizada', 'icono' => 'success'];
                                $datos_log = [
                                    "id" => $id,
                                    "salida" => $salida,
                                    // "entrada" => $retorno,
                                ];
                                $datos_log_json = json_encode($datos_log);
                                // $this->model->registrarlog($_SESSION['id'],'Actualizar','Boleta', $datos_log_json);
                            } else {
                                $respuesta = ['msg' => 'error al Actualizar', 'icono' => 'error'];
                            }
                        } else {
                            $respuesta = ['msg' => 'La Solicitud fue rechazada', 'icono' => 'error'];
                        }
                    }
                }
            }
        } else {
            // Si no se recibieron todos los datos esperados, devuelve un mensaje de error

            $respuesta = ['msg' => 'error datos vacios', 'icono' => 'error'];
        }
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        die();
    }
    //eliminar user
    public function delete($id)
    {
    }
    //editar user
    public function edit($id)
    {
        if (is_numeric($id)) {
            $data = $this->model->getBoleta($id);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    //eliminar user
    public function buscarPorFecha()
    {
        if (isset($_POST['fecha']) && isset($_POST['trabajador_id'])) {
            $fecha = $_POST['fecha'];
            $trabajador_id = $_POST['trabajador_id'];

            // Llama al modelo para obtener los datos de asistencia
            $data = $this->model->getBoletaPorFecha($fecha, $trabajador_id);

            // Devuelve los datos como JSON
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        } else {
            // Si no se recibieron todos los datos esperados, devuelve un mensaje de error
            $respuesta = ['msg' => 'error', 'icono' => 'error'];
            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        }

        // Detiene la ejecución del script
        die();
    }

    public function buscarPorFechaSola()
    {
        if (isset($_POST['trabajador_id'])) {

            $trabajador_id = $_POST['trabajador_id'];

            // Llama al modelo para obtener los datos de asistencia
            $data = $this->model->getBoletaPorFechaSola($trabajador_id);

            // Devuelve los datos como JSON
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        } else {
            // Si no se recibieron todos los datos esperados, devuelve un mensaje de error
            $respuesta = ['msg' => 'error', 'icono' => 'error'];
            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        }

        // Detiene la ejecución del script
        die();
    }

    public function MisBoletas()
    {
        $data['title'] = 'Mis Boletas';
        $data1 = '';

        $this->views->getView('Administracion', "Boleta_Trabajador", $data, $data1);
    }


    public function listarMisBoletas()
    {
        $parametro = $_POST['parametro'];
        // $parametro = 'dias';


        $id = $_SESSION['id'];
        $data = $this->model->getusuario($id);
        $id = $data['trabajador_id'];
        $data = $this->model->getMisBoletas($id, $parametro);
        for ($i = 0; $i < count($data); $i++) {
            $numero = $data[$i]['numero'];
            if ($data[$i]['numero'] == null) {
                $numero = '0';
            }
            $numero_formateado = str_pad($numero, 9, '0', STR_PAD_LEFT);
            $data[$i]['numero'] = $numero_formateado;

            $data[$i]['posicion'] = $i + 1;
            $fecha_inicio = $data[$i]['fecha_inicio'];
            $fecha_fin = $data[$i]['fecha_fin'];
            $estado_tramite = $data[$i]['estado_tramite'];

            $fecha_inicio = date('d-m-Y', strtotime($fecha_inicio));
            $fecha_fin = date('d-m-Y', strtotime($fecha_fin));

            $data[$i]['fecha_inicio_formateada'] = $fecha_inicio;
            $data[$i]['fecha_fin_formateada'] = $fecha_fin;

            if ($fecha_inicio == $fecha_fin) {
                $data[$i]['fecha_nueva'] = $fecha_inicio;
            } else {
                $data[$i]['fecha_nueva'] = $fecha_inicio . '<br>' . $fecha_fin;
            }


            // $datonuevo = $data[$i]['bestado'];
            // if ($datonuevo == 'Activo') {
            //     $data[$i]['estado'] = "<div class='badge badge-info'>Activo</div>";
            // } else {
            //     $data[$i]['estado'] = "<div class='badge badge-danger'>Inactivo</div>";
            // }
            $data[$i]['accion'] = '<div class="d-flex">
                <button class="btn btn-info" type="button" onclick="view(' . $data[$i]['boleta_id'] . ')"><i class="fas fa-eye"></i></button>
                </div>';
            if ($estado_tramite == 'Pendiente') {
                $data[$i]['accion'] = '<div class="d-flex">
                <button class="btn btn-primary" type="button" onclick="edit(' . $data[$i]['boleta_id'] . ')"><i class="fas fa-edit"></i></button>
                </div>';
            }

            if ($estado_tramite == 'Aprobado') {
                $data[$i]['estado_tramite'] = '<span class="badge badge-success">Aprobado</span>';
            }
            if ($estado_tramite == 'Rechazado') {
                $data[$i]['estado_tramite'] = '<span class="badge badge-danger">Rechazado</span>';
            }
            if ($estado_tramite == 'Pendiente') {
                $data[$i]['estado_tramite'] = '<span class="badge badge-warning">Pendiente</span>';
            }
            if ($estado_tramite == 'Anulado') {
                $data[$i]['estado_tramite'] = '<span class="badge badge-light"> Anulado </span>';
            }


            // <button class="btn btn-danger" type="button" onclick="ViewUser(' . $data[$i]['usuario_id'] . ')"><i class="fas fa-eye"></i></button>
            // <button class="btn btn-danger" type="button" onclick="DeleteUser(' . $data[$i]['usuario_id'] . ')"><i class="fas fa-eye"></i></button>
            // colocar eliminar si es necesario
        }
        echo json_encode($data);
        die();
    }

    public function RevisarBoletas()
    {
        $data['title'] = 'Revisar Boletas';
        $data1 = '';

        $this->views->getView('Administracion', "Boleta_Revision", $data, $data1);
    }

    public function listarRevisionBoletas()
    {
        $parametro = $_POST['parametro'];
        $id = $_SESSION['id'];
        $data = $this->model->getusuario($id);
        $id = $data['trabajador_id'];
        $data = $this->model->getMisRevisiones($id, $parametro);

        for ($i = 0; $i < count($data); $i++) {
            $numero = $data[$i]['numero'];
            if ($data[$i]['numero'] == null) {
                $numero = '0';
            }
            $data[$i]['posicion'] = $i + 1;
            $numero_formateado = str_pad($numero, 9, '0', STR_PAD_LEFT);
            $data[$i]['numero'] = $numero_formateado;


            $fecha_inicio = $data[$i]['fecha_inicio'];
            $fecha_fin = $data[$i]['fecha_fin'];
            $estado_tramite = $data[$i]['estado_tramite'];

            $fecha_inicio = date('d-m-Y', strtotime($fecha_inicio));
            $fecha_fin = date('d-m-Y', strtotime($fecha_fin));

            $data[$i]['fecha_inicio_formateada'] = $fecha_inicio;
            $data[$i]['fecha_fin_formateada'] = $fecha_fin;

            if ($fecha_inicio == $fecha_fin) {
                $data[$i]['fecha_nueva'] = $fecha_inicio;
            } else {
                $data[$i]['fecha_nueva'] = $fecha_inicio . '<br>' . $fecha_fin;
            }


            $data[$i]['accion'] = '<div class="d-flex">
                <button class="btn btn-info" type="button" onclick="view(' . $data[$i]['boleta_id'] . ')"><i class="fas fa-eye"></i></button>
                </div>';

            if ($estado_tramite == 'Aprobado') {
                $data[$i]['estado_tramite'] = '<span class="badge badge-success">Aprobado</span>';
            }
            if ($estado_tramite == 'Rechazado') {
                $data[$i]['estado_tramite'] = '<span class="badge badge-danger">Rechazado</span>';
            }
            if ($estado_tramite == 'Pendiente') {
                $data[$i]['estado_tramite'] = '<span class="badge badge-warning">Pendiente</span>';
            }
            if ($estado_tramite == 'Anulado') {
                $data[$i]['estado_tramite'] = '<span class="badge badge-light"> Anulado </span>';
            }
        }

        echo json_encode($data);
        die();
    }

    public function listarPorteria()
    {
        $data = $this->model->getBoletasPorteria();
        for ($i = 0; $i < count($data); $i++) {
            $numero = $data[$i]['numero'];
            if ($data[$i]['numero'] == null) {
                $numero = '0';
            }
            $data[$i]['posicion'] = $i + 1;

            $numero_formateado = str_pad($numero, 9, '0', STR_PAD_LEFT);
            $data[$i]['numero'] = $numero_formateado;


            $fecha_inicio = $data[$i]['fecha_inicio'];
            $fecha_fin = $data[$i]['fecha_fin'];
            $estado_tramite = $data[$i]['estado_tramite'];

            $fecha_inicio = date('d-m-Y', strtotime($fecha_inicio));
            $fecha_fin = date('d-m-Y', strtotime($fecha_fin));

            if ($fecha_inicio == $fecha_fin) {
                $data[$i]['fecha_nueva'] = $fecha_inicio;
            } else {
                $data[$i]['fecha_nueva'] = $fecha_inicio . '<br>' . $fecha_fin;
            }


            $data[$i]['accion'] = '<div class="d-flex">
                <button class="btn btn-primary" type="button" onclick="edit(' . $data[$i]['bid'] . ')"><i class="fas fa-edit"></i></button>
                </div>';

            $entrada = $data[$i]['hora_salida'];
            $salida = $data[$i]['hora_entrada'];

            $data[$i]['estado_tramite'] = '<span class="badge badge-success">Completado</span>';
            if ($entrada == null && $salida == null) {
                $data[$i]['estado_tramite'] = '<span class="badge badge-warning">En Espera</span>';
            }
            if ($entrada != null && $salida == null) {
                $data[$i]['estado_tramite'] = '<span class="badge badge-info">En Proceso</span>';
            }


            // if ($estado_tramite == 'Aprobado') {

            // }

        }
        echo json_encode($data);
        die();
    }





    public function revisar()
    {

        if (isset($_POST['id']) || isset($_POST['accion']) || isset($_POST['observacion'])) {
            $id = $_POST['id'];
            $accion = $_POST['accion'];
            $observacion = $_POST['observacion'];
            $data = $this->model->getBoleta($id);

            if ($accion != 'Aprobado' && empty($observacion)) {
                $respuesta = ['msg' => 'Observacion Vacia', 'icono' => 'warning'];
            } else {
                if ($data['estado_tramite'] != 'Anulado') {
                    $data = $this->model->Revisar($id, $accion, $observacion);
                    if ($data > 0) {
                        if ($accion == 'Aprobado') {
                            $respuesta = ['msg' => 'Se ha Aprobado con exito', 'icono' => 'success'];
                        }
                        if ($accion == 'Rechazado') {
                            $respuesta = ['msg' => 'Se ha Rechazado con exito', 'icono' => 'success'];
                        }
                        if ($accion == 'Anulado') {
                            $respuesta = ['msg' => 'Se ha Anulado con exito', 'icono' => 'success'];
                        }
                    } else {
                        $respuesta = ['msg' => 'Se ha Producido un error', 'icono' => 'warning'];
                    }
                } else {
                    $respuesta = ['msg' => 'La boleta ya fue Anulada', 'icono' => 'warning'];
                }
            }
        } else {
            $respuesta = ['msg' => 'todo los campos son requeridos', 'icono' => 'warning'];
        }
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);

        die();
    }


    public function listarTrabajadoresPorCargoNivel()
    {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            if ($id == '0') {
                $nivel = '1';
                $data = $this->model->getTrabajadorCargo2($nivel);
            } else {
                $data = $this->model->getTrabajador($id);
                $cargo = $data['cargo_nombre'];
                $nivel = $data['cargo_nivel'];
                $data = $this->model->getTrabajadorCargo($cargo, $nivel);
                if (empty($data)) {
                    $nivel = intval($nivel) - 1;

                    $data = $this->model->getTrabajadorCargo2($nivel);
                }
            }
        } else {
            $nivel = '1';
            $data = $this->model->getTrabajadorCargo2($nivel);
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }


    public function MilistarTrabajadoresPorCargoNivel()
    {

        $id = $_SESSION['id'];
        $data = $this->model->getusuario($id);
        $id = $data['trabajador_id'];

        if ($id == '0') {
            $nivel = '1';
            $data = $this->model->getTrabajadorCargo2($nivel);
        } else {
            $data = $this->model->getTrabajador($id);
            $cargo = $data['cargo_nombre'];
            $nivel = $data['cargo_nivel'];
            $data = $this->model->getTrabajadorCargo($cargo, $nivel);
            if (empty($data)) {
                $nivel = intval($nivel) - 1;
                $data = $this->model->getTrabajadorCargo2($nivel);
            }
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
}
