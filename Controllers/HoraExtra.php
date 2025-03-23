<?php
class HoraExtra extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['usuario_autenticado']) || ($_SESSION['usuario_autenticado'] != "true")) {
            header('Location: ' . BASE_URL . 'admin');
            exit;
        }
    }
    public function index()
    {
        $data['title'] = 'Horas Extra';
        $data1 = "";

        $this->views->getView('Administracion', "HoraExtra", $data, $data1);
    }

    public function listar()
    {

        $id = $_POST['id'];
        $year = date("Y"); // Año actual
        $month = date("m"); // Mes actual
        $day = date("d"); // Día actual

        // Concatenar para obtener la fecha completa en formato YYYY-MM-DD
        $today = $year . '-' . $month . '-' . $day;

        $data = $this->model->listar($id, $today);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['posicion'] = $i + 1;
            // $data[$i]['diferencia'] =$data[$i]['diferencia'].' Horas';
            $desde = $data[$i]['fecha_desde'] . ' ' . $data[$i]['hora_desde'];
            $hasta = $data[$i]['fecha_desde'] . ' ' . $data[$i]['hora_hasta'];
            $data[$i]['desde'] = $desde;
            $data[$i]['hasta'] = $hasta;
        }

        $data2 = $this->model->calcularHoras($id, $today);
        // echo json_encode($data);
        $response = [
            'listaDatos' => $data,
            'horasExtraDisponibles' => $data2
        ];
        echo json_encode($response);
        die();
    }

    public function actualizar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $respuesta = ['msg' => 'Método no permitido. Solo se aceptan solicitudes POST.', 'icono' => 'error'];
            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
            die();
        }
        $id = $_POST['id'] ?? '';
        $id_trabajador = $_POST['trabajador_id'] ?? '';
        $fecha_inicio = $_POST['fecha_inicio'] ?? '';
        $hora_desde = $_POST['hora_desde'] ?? '';
        $hora_hasta = $_POST['hora_hasta'] ?? '';
        $tipo = $_POST['tipo'] ?? '';
        $estado = $_POST['estado'] ?? '';
        $tiempo = $_POST['tiempo_usable'] ?? '00:00';

        $min_tiempo = $_POST['min_tiempo'] ?? '';
        $max_tiempo = $_POST['max_tiempo'] ?? '';

        $error_message = '';
        $accion = $id ? 'editar' : 'crear';

        
        // id
        if (empty($id_trabajador)) {
            echo json_encode(["icono" => "error", "msg" => "Seleccione un Trabajador"]);
            exit;
        }
        // fecha inicio
        if (empty($fecha_inicio) || !DateTime::createFromFormat('Y-m-d', $fecha_inicio)) {
            $error_message .= '<b>Fecha</b> es requerida y debe estar en formato YYYY-MM-DD.<br>';
        }
        // hora desde
        if (empty($hora_desde) || !preg_match('/^([01][0-9]|2[0-3]):([0-5][0-9])$/', $hora_desde)) {
            $error_message .= '<b>Hora desde</b> es requerida.<br>';
        }
        // hora hasta
        if (empty($hora_hasta) || !preg_match('/^([01][0-9]|2[0-3]):([0-5][0-9])$/', $hora_hasta)) {
            $error_message .= '<b>Hora hasta</b> es requerida.<br>';
        }
        // hora no sea mayor
        if (!empty($hora_desde) && !empty($hora_hasta)) {
            $horaDesde = DateTime::createFromFormat('H:i', $hora_desde);
            $horaHasta = DateTime::createFromFormat('H:i', $hora_hasta);

            if ($horaDesde >= $horaHasta) {
                $error_message .= '<b>Hora desde</b> debe ser menor que <b>Hora hasta</b>.<br>';
            }
        }
        // validar tipo
        if (empty($tipo) || !in_array($tipo, ['aumentar', 'restar'])) {
            $error_message .= '<b>Tipo</b> es requerido.<br>';
        }
        // aumentar el tiempo 30 dias
        if (!empty($fecha_inicio)) {
            $fechaInicio = new DateTime($fecha_inicio);
            $minTiempoDateTime = new DateTime($min_tiempo);
            $maxTiempoDateTime = new DateTime($max_tiempo);

            if ($tipo == 'aumentar') {
                $fechaInicio->modify('+30 days');
                $fecha_hasta = $fechaInicio->format('Y-m-d');
            }
            if ($tipo == 'restar') {
                $fecha_hasta = $fecha_inicio;
                // $fechaTiempoStr = $fechaInicio->format('Y-m-d');
                // $minTiempoStr = $minTiempoDateTime->format('Y-m-d');
                // $maxTiempoStr = $maxTiempoDateTime->format('Y-m-d');

                if ($fechaInicio < $minTiempoDateTime || $fechaInicio > $maxTiempoDateTime) {
                    // $error_message .= $minTiempoStr.'<br>'.$maxTiempoStr.'<br>'.$fechaTiempoStr.'<b>Fecha</b> debe estar entre el rango de hora Extra.<br>';
                    $error_message .='la <b>Fecha</b> debe estar entre el rango de hora Extra.<br>';
                }
            }

           
        }
        if (!empty($hora_desde) && !empty($hora_hasta)) {
            $diferencia = $this->calcularDiferenciaHoras($hora_desde, $hora_hasta);
        
            // Convertir tiempo y diferencia a minutos
            $diferenciaMinutos = (int)substr($diferencia, 0, 2) * 60 + (int)substr($diferencia, 3, 2);
            $tiempoMinutos = (int)substr($tiempo, 0, 2) * 60 + (int)substr($tiempo, 3, 2);
        
            if (($tiempoMinutos < $diferenciaMinutos) && $accion =='crear' && $tipo=='restar'  ) {
                $error_message .= 
                // $tiempo.'H1 solo <br>'.
                // $tiempoMinutos.' H1 <br>'.
                // $diferenciaMinutos.' Diferencia <br>'.
                '<b>Tiempo usable</b> Insuficiente.';
            }
            // if(($tiempoMinutos < $diferenciaMinutos) && $accion =='editar' ){
            //     $data = $this->model->buscar($id);
            //     $data = $this->model->buscar($id);
            //     $diferenciaGuardada = $data['diferencia'];
            //     $diferenciaGuardadaMinutos = (int)substr($diferenciaGuardada, 0, 2) * 60 + (int)substr($diferenciaGuardada, 3, 2);
            //     // $data['fecha_desde'];
            //     // $data['hora_desde'];
            //     // $data['hora_hasta'];
            //     // $data['diferencia'];
            //     if($diferenciaMinutos > $diferenciaGuardadaMinutos){
            //     // if(($tiempoMinutos+$diferenciaGuardadaMinutos)>=$diferenciaMinutos){
            //         $error_message .= 
            //         $tiempoMinutos.'arriba <br>'.
            //         $diferenciaMinutos.'formulario <br>'.
            //         $diferenciaGuardadaMinutos.'por id<br>'.
            //         // $tiempoMinutos.'<br>'.
            //         // $diferenciaMinutos.'<br>'.
            //         '<b>Tiempo usable</b> no puede ser menor que la diferencia entre <b>Hora desde</b> y <b>Hora hasta</b>.';
            //     }
               
            // }
        }
       
        if (!empty($error_message)) {
            echo json_encode(["icono" => "error", "msg" => $error_message]);
            // echo json_encode($existencia);
            exit;
        }
      

        
        
        $respuesta = [
            'id' => $id,
            'fecha_inicio' => $fecha_inicio,
            'fecha_hasta' => $fecha_hasta,
            'hora_desde' => $hora_desde,
            'hora_hasta' => $hora_hasta,
            'diferencia' => $diferencia,
            'tipo' => $tipo,
            'estado' => $estado,
            'tiempo' => $tiempo,
            'accion' => $accion,
            'msg' => 'Operación exitosa', // Mensaje de éxito
            'icono' => 'success' // Icono de éxito
        ];
        $dia_completo = 0;
        if ($accion == 'crear') {
            $data = $this->model->agregar($tipo, $id_trabajador, $fecha_inicio, $fecha_hasta, $hora_desde, $hora_hasta, $diferencia, $dia_completo);
            if ($data > 0) {
                $respuesta = ['msg' => 'Registro Creado', 'icono' => 'success'];
                // $this->model->registrarlog($_SESSION['id'],'Crear','Boleta', $datos_log_json);
            } else {
                $respuesta = ['msg' => 'error al registrar', 'icono' => 'error'];
            }
        }
        if ($accion == 'editar') {
            $data = $this->model->editar($tipo, $id_trabajador, $fecha_inicio, $fecha_hasta, $hora_desde, $hora_hasta, $diferencia, $dia_completo, $estado, $id);

            if ($data > 0) {
                $respuesta = ['msg' => 'Registro Actualizado', 'icono' => 'success'];
                // $this->model->registrarlog($_SESSION['id'],'Crear','Boleta', $datos_log_json);
            } else {
                $respuesta = ['msg' => 'error al registrar', 'icono' => 'error'];
            }
        }




        // $respuesta = ['msg' => '.', 'icono' => 'error'];
        // header('Content-Type: application/json');
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        die();
    }

    function calcularDiferenciaHoras($horaDesde, $horaHasta)
    {
        // Crear objetos DateTime con las horas proporcionadas
        $inicio = new DateTime($horaDesde);
        $fin = new DateTime($horaHasta);

        // Calcular la diferencia
        $diferencia = $fin->diff($inicio);

        // Formatear la diferencia como HH:mm
        $horas = str_pad($diferencia->h, 2, '0', STR_PAD_LEFT);
        $minutos = str_pad($diferencia->i, 2, '0', STR_PAD_LEFT);

        return "$horas:$minutos";
    }

    public function editar($id)
    {

        if (is_numeric($id)) {
            $data = $this->model->buscar($id);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
