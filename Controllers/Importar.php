<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

class Importar extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['usuario_autenticado']) || ($_SESSION['usuario_autenticado'] != "true")) {
            header('Location: ' . BASE_URL . 'admin');
            exit;
        }
        if ($_SESSION['nivel'] !== 1 &&  $_SESSION['nivel'] !== 100) {
            header('Location: ' . BASE_URL . 'errors');
            exit;
        }
    }
    public function index()
    {

        // ini_set('max_execution_time', '300'); // 300 segundos = 5 minutos
        // ini_set('memory_limit', '512M');
        // $max_execution_time = ini_get('max_execution_time');
        // $memory_limit = ini_get('memory_limit');
        $data['title'] = 'Importar';
        // $data1['tiempo']= $max_execution_time;
        // $data1['memoria'] =$memory_limit;
        $data1 = '';
        $this->views->getView('Administracion', "Importar", $data, $data1);
    }
    public function importar_trabajador_csv()
    {


        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['msg' => 'Método no permitido', 'icono' => 'error']);
            exit;
        }
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        if ($data === null) {
            http_response_code(400);
            echo json_encode(['msg' => 'Datos inválidos', 'icono' => 'error']);
            exit;
        }

        $aceptado = 0;
        $ignorado = 0;
        $modificado = 0;
        $total = count($data);
        $detalles = [];
        foreach ($data as $key => $registro) {
            $valido = true;

            $idUsuario = isset($registro['ID Usuario']) ? $registro['ID Usuario'] : '';
            $nombre = isset($registro['Nombre']) ? $registro['Nombre'] : '';
            $departamento = isset($registro['Departamento']) ? $registro['Departamento'] : '';
            // $fechaInicio = isset($registro['Fecha Inicio']) ? $registro['Fecha Inicio'] : '';
            // $fechaVencimiento = isset($registro['Fecha Vencimiento']) ? $registro['Fecha Vencimiento'] : '';

            if (strpos($departamento, 'DIRESA/') === 0) {
                $departamento = substr($departamento, 7); // Elimina 'DIRESA/' del inicio
            }

            $detalleRegistro = [
                'id' => $idUsuario,
                'nombre' => $nombre,
                'departamento' => $departamento,
                'aceptado' => '',
                'modificado' => '',
                'ignorado' => '',
                'error_agregar' => '',
                'error_modificar' => '',
            ];
            if (!empty($departamento)) {
                if (
                    strpos($departamento, 'PASIVOS') !== false ||
                    strpos($departamento, 'PROYECTOS') !== false ||
                    strpos($departamento, 'RED SALUD') !== false
                ) {
                    $valido = false;
                    $ignorado++;
                    $detalleRegistro['ignorado'] = true;
                    $departamento = '';
                }
            }

            if ($valido && $idUsuario) {
                $result = $this->model->getTrabajador($idUsuario);
                $modalidad_trabajo = 'Presencial';
                $institucion = $departamento;

                if (!empty($nombre)) {
                    $nombre = mb_convert_encoding($nombre, 'ISO-8859-1', 'UTF-8');
                    $nombre = str_replace('?', 'Ñ', $nombre);
                    $nombre = preg_replace('/\s+/', ' ', $nombre); // Eliminar espacios adicionales
                }

                if (empty($result)) {
                    $result = $this->model->registrarTrabajador($nombre, $idUsuario, $institucion, $modalidad_trabajo);
                    if ($result > 0) {
                        $aceptado++;
                        // $detalleRegistro['aceptado'] = true;
                    } else {
                        $ignorado++;
                        // $detalleRegistro['Ignorado'] = true;
                    }
                } else {
                    $trabajador_id = $result['tid'];
                    $result = $this->model->modificarTrabajador($nombre, $idUsuario, $institucion, $modalidad_trabajo, $trabajador_id);
                    if ($result > 0) {
                        $modificado++;
                        // $detalleRegistro['modificado'] = true;
                    } else {
                        $ignorado++;
                        // $detalleRegistro['error_modificar'] = true;
                    }
                }
            }
            // if ($detalleRegistro['aceptado'] || $detalleRegistro['modificado']) {
            //     $detalles[] = $detalleRegistro;
            // }
        }
        $respuesta = [
            'aceptado' => $aceptado,
            'modificado' => $modificado,
            'ignorado' => $ignorado,
            'total' => $total,
            // 'detalles' => $detalles, // Agrega el arreglo de detalles a la respuesta
        ];
        // echo json_encode($detalles);
        echo json_encode($respuesta);
    }

    public function importar_asistencia_csv()
    {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['msg' => 'Método no permitido', 'icono' => 'error']);
            exit;
        }
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        if ($data === null) {
            http_response_code(400);
            echo json_encode(['msg' => 'Datos inválidos', 'icono' => 'error']);
            exit;
        }
        $aceptado = 0;
        $ignorado = 0;
        $modificado = 0;
        $total = count($data);
        $registros = [];
        $posicion = 0;

        $festividades = $this->model->getAllfestividad();
        $festividadesArray = [];
        foreach ($festividades as $festividad) {
            $dia_festividad = str_pad($festividad['dia_inicio'], 2, '0', STR_PAD_LEFT);
            $mes_festividad = str_pad($festividad['mes_inicio'], 2, '0', STR_PAD_LEFT);
            $tipo = $festividad['tipo'];
            $clave = $dia_festividad . '-' . $mes_festividad;
            if (!isset($festividadesArray[$clave])) {
                $festividadesArray[$clave] = [];
            }
            $festividadesArray[$clave][] = $tipo;
        }

        foreach ($data as $key => $registro) {
            $posicion++;
            $valido = true;
            $departamento = isset($registro['Departamento']) ? $registro['Departamento'] : '';
            //  $this->model->registrarAsistencia(
            if (!empty($departamento)) {
                if (
                    strpos($departamento, 'DIRESA/PASIVOS') !== false ||
                    strpos($departamento, 'DIRESA/PROYECTOS') !== false ||
                    strpos($departamento, 'RED SALUD') !== false
                ) {
                    $valido = false;
                    $ignorado++;
                }
            }

            if ($valido) {
                $fecha_csv = isset($registro['Fecha']) ? $registro['Fecha'] : '';
                $nombre = isset($registro['Nombre Usuario']) ? $registro['Nombre Usuario'] : '';
                $timestamp = strtotime(str_replace('/', '-', $fecha_csv));
                $fecha_csv = date('Y-m-d', $timestamp);
                $fecha_cumpleaños_csv = date('m-d', $timestamp);

                $idUsuario_csv = isset($registro['ID']) ? $registro['ID'] : '';

                $trabajador = $this->model->getTrabajador($idUsuario_csv);
                $asistencias = $this->model->getAsistencia($idUsuario_csv, $fecha_csv);

                $registroHoras = [
                    isset($registro['Entrada - Salida 1']) ? $registro['Entrada - Salida 1'] : '00:00',
                    isset($registro['Entrada - Salida 2']) ? $registro['Entrada - Salida 2'] : '00:00',
                    isset($registro['Entrada - Salida 3']) ? $registro['Entrada - Salida 3'] : '00:00',
                    isset($registro['Entrada - Salida 4']) ? $registro['Entrada - Salida 4'] : '00:00',
                    isset($registro['Entrada - Salida 5']) ? $registro['Entrada - Salida 5'] : '00:00',
                    isset($registro['Entrada - Salida 6']) ? $registro['Entrada - Salida 6'] : '00:00',
                    isset($registro['Entrada - Salida 7']) ? $registro['Entrada - Salida 7'] : '00:00',
                    isset($registro['Entrada - Salida 8']) ? $registro['Entrada - Salida 8'] : '00:00'
                ];

                if ($asistencias) {
                    $asistencia_id = $asistencias['aid'];

                    $dbHoras = [
                        substr($asistencias['reloj_1'], 0, 5),
                        substr($asistencias['reloj_2'], 0, 5),
                        substr($asistencias['reloj_3'], 0, 5),
                        substr($asistencias['reloj_4'], 0, 5),
                        substr($asistencias['reloj_5'], 0, 5),
                        substr($asistencias['reloj_6'], 0, 5),
                        substr($asistencias['reloj_7'], 0, 5),
                        substr($asistencias['reloj_8'], 0, 5)
                    ];
                    $horasOrdenadas = $this->combinarYOrdenarHoras2($dbHoras, $registroHoras);
                } else {
                    $horasOrdenadas = $this->eliminarHorasRepetidas($registroHoras);
                    // Si no hay datos previos, usar las horas del registro directamente
                    // $horasOrdenadas = $registroHoras;
                }
                $ES_1_csv = $horasOrdenadas[0];
                $ES_2_csv = $horasOrdenadas[1];
                $ES_3_csv = $horasOrdenadas[2];
                $ES_4_csv = $horasOrdenadas[3];
                $ES_5_csv = $horasOrdenadas[4];
                $ES_6_csv = $horasOrdenadas[5];
                $ES_7_csv = $horasOrdenadas[6];
                $ES_8_csv = $horasOrdenadas[7];
                // DATOS PARA INSERTAR
                $licencia = '';
                $tardanza = '00:00';
                $tardanza_cantidad = 0;
                $es_festividad = false;
                $compensable = false;
                $es_honomastico = false;
                $entrada = '00:00';
                $salida = '00:00';
                $total_horario = '00:00';
                $total_entrada_salida_reloj = '00:00';

                // $result = $this->model->getAllfestividad();
                // $dia_csv = date('d', strtotime($fecha_csv));
                // $mes_csv = date('m', strtotime($fecha_csv));
                $dia_csv = str_pad(date('d', strtotime($fecha_csv)), 2, '0', STR_PAD_LEFT);
                $mes_csv = str_pad(date('m', strtotime($fecha_csv)), 2, '0', STR_PAD_LEFT);
                $clave_csv = $dia_csv . '-' . $mes_csv;
                if (isset($festividadesArray[$clave_csv])) {
                    if (in_array('feriado', $festividadesArray[$clave_csv])) {
                        $es_festividad = true;
                        $tipo_festividad = 'feriado';
                    } elseif (in_array('compensable', $festividadesArray[$clave_csv])) {
                        $es_festividad = true;
                        $tipo_festividad = 'compensable';
                    }
                }
                // for ($i = 0; $i < count($result); $i++) {

                //     // $dia = $result[$i]['dia_inicio'];
                //     $dia_festividad = str_pad($result[$i]['dia_inicio'], 2, '0', STR_PAD_LEFT);
                //     $mes_festividad = str_pad($result[$i]['mes_inicio'], 2, '0', STR_PAD_LEFT);
                //     if ($dia_csv == $dia_festividad && $mes_csv == $mes_festividad) {
                //         $es_festividad = true;
                //         break;
                //     }
                // }

                foreach ($horasOrdenadas as $hora) {
                    if ($hora !== '00:00') {
                        if ($entrada === '00:00') {
                            $entrada = $hora;
                        }
                        if ($hora !== $entrada) {
                            $salida = $hora;
                        }
                    }
                }


                if (empty($trabajador)) {
                    $ignorado++;
                }
                if ($trabajador) {
                    $trabajador_id = $trabajador['tid'];
                    $fecha_nacimiento_csv = isset($trabajador['fecha_nacimiento']) ? $trabajador['fecha_nacimiento'] : '3000-01-01';
                    // $timestamp = strtotime(str_replace('/', '-', $fecha_nacimiento));
                    $fecha_nacimiento = strtotime($fecha_nacimiento_csv);
                    // $mes_nacimiento = date('m', $fecha_nacimiento);
                    // $dia_nacimiento = date('d', $fecha_nacimiento);
                    $fecha_nacimiento = date('m-d', $fecha_nacimiento);

                    $hora_entrada_trabajador_formato = strtotime($trabajador['hora_entrada']);
                    $hora_salida_trabajador_formato = strtotime($trabajador['hora_salida']);

                    // $hora_entrada_trabajador = date('H:i', $hora_entrada_trabajador_formato);
                    // $hora_salida_trabajador = date('H:i', $hora_salida_trabajador_formato);

                    $entrada_trabajador_mas_6 = strtotime('+6 minutes', $hora_entrada_trabajador_formato);
                    $entrada_trabajador_mas_30 = strtotime('+31 minutes', $hora_entrada_trabajador_formato);

                    $entrada_trabajador_limite = strtotime('+5 minutes', $hora_entrada_trabajador_formato);

                    $entrada_timestamp = strtotime($entrada);
                    $salida_timestamp = strtotime($salida);
                    $diferencia_trabajador_segundos = $hora_salida_trabajador_formato - $hora_entrada_trabajador_formato;
                    $diferencia_entrada_salida_segundos = $salida_timestamp - $entrada_timestamp;

                    if ($ES_1_csv == '00:00') {
                        $licencia = 'SR';
                    }

                    if ($ES_1_csv !== '00:00') {

                        if ($salida == '00:00') {
                            $licencia = 'NMS';
                        }
                        if ($salida !== '00:00') {
                            if (strtotime($entrada) < $entrada_trabajador_mas_6) {
                                // Llegó menos de 6 minutos tarde  
                                $tardanza = '00:00';
                                $tardanza_cantidad = 0;
                            }
                            if (
                                strtotime($entrada) >= $entrada_trabajador_mas_6 &&
                                strtotime($entrada) < $entrada_trabajador_mas_30
                            ) {
                                // Llegó entre 6 y 30 minutos tarde
                                $tardanza_cantidad = 1;
                            }
                            if (strtotime($entrada) >= $entrada_trabajador_mas_30) {
                                // Llegó más de 30 minutos tarde
                                $tardanza_cantidad = 0;
                                $licencia = '+30';
                            }
                            if (strtotime($entrada) >= $hora_salida_trabajador_formato) {
                                $licencia = 'NME';
                            }

                            if (strtotime($entrada) < $entrada_trabajador_mas_30 && strtotime($salida) >= $hora_salida_trabajador_formato) {
                                $licencia = 'OK';
                                $total_horario = gmdate('H:i', $diferencia_trabajador_segundos);
                                $total_entrada_salida_reloj = gmdate('H:i', $diferencia_entrada_salida_segundos);
                            }
                            if (strtotime($entrada) < $entrada_trabajador_mas_30 && strtotime($salida) < $hora_salida_trabajador_formato) {
                                $licencia = 'NMS';
                            }
                        }
                    }
                    if ($ES_1_csv !== '00:00' && $licencia == 'OK' && ($entrada_timestamp >= $entrada_trabajador_mas_6 &&
                        $entrada_timestamp < $entrada_trabajador_mas_30)) {

                        $diferencia_tardanza = $entrada_timestamp - $entrada_trabajador_limite;
                        $tardanza = gmdate('H:i', $diferencia_tardanza);
                    }

                    if ($es_festividad == true && $ES_1_csv == '00:00') {
                        
                        if( $tipo_festividad == 'feriado'){
                            $licencia = 'FERIADO';
                        }
                        if( $tipo_festividad == 'compensable'){
                            $licencia ='COMPENSABLE';
                        }
                    }
                    if (($fecha_nacimiento == $fecha_cumpleaños_csv) && ($fecha_nacimiento_csv !== '3000-01-01')) {
                        $licencia = 'ONOMASTICO';
                    }
                    // if ($entrada == $salida && $licencia == 'NMS') {
                    // }

                    $result = $this->model->getAsistencia($idUsuario_csv, $fecha_csv);
                    $justificacion = '';
                    // $registros[] = [$result];
                    if (empty($asistencias)) {
                        // REGISTRO ASISTENCIA
                        $aceptado++;
                        $this->model->registrarAsistencia($trabajador_id, $licencia, $fecha_csv, $entrada, $salida, $tardanza, $tardanza_cantidad, $total_entrada_salida_reloj, $total_horario, $justificacion, $ES_1_csv, $ES_2_csv, $ES_3_csv, $ES_4_csv, $ES_5_csv, $ES_6_csv, $ES_7_csv, $ES_8_csv);
                    } else {
                        $asistencia_id = $result['aid'];
                        // ACTUALIZO ASISTENCIA
                        $modificado++;
                        $this->model->modificarAsistencia($trabajador_id, $licencia, $fecha_csv, $entrada, $salida, $tardanza, $tardanza_cantidad, $total_entrada_salida_reloj, $total_horario, $justificacion, $ES_1_csv, $ES_2_csv, $ES_3_csv, $ES_4_csv, $ES_5_csv, $ES_6_csv, $ES_7_csv, $ES_8_csv, $asistencia_id);
                    }

                    // $registros[] = [
                    //     // 'honomastico' => $fecha_nacimiento,
                    //     'honosmastico' => $fecha_nacimiento.'|'.$fecha_cumpleaños_csv,
                    //     'festividad' => $es_festividad,
                    //     'posicion' => $posicion,
                    //     'idUsuario_csv' => $idUsuario_csv,
                    //     'departamento' => $departamento,
                    //     'fecha_csv' => $fecha_csv,
                    //     'nombre' => $nombre,
                    //     'entrada' => $entrada,
                    //     'salida' => $salida,
                    //     'licencia' => $licencia,
                    //     'tardanza' => $tardanza,
                    //     'tardanza_cantidad' => $tardanza_cantidad,
                    //     'total' => $total_horario,
                    //     'total_reloj' => $total_entrada_salida_reloj,
                    //     'ES_1_csv' => $ES_1_csv,
                    //     'ES_2_csv' => $ES_2_csv,
                    //     'ES_3_csv' => $ES_3_csv,
                    //     'ES_4_csv' => $ES_4_csv,
                    //     'ES_5_csv' => $ES_5_csv,
                    //     'ES_6_csv' => $ES_6_csv,
                    //     'ES_7_csv' => $ES_7_csv,
                    //     'ES_8_csv' => $ES_8_csv,
                    // ];

                }
            }
        }

        $respuesta = ['aceptado' => $aceptado, 'modificado' => $modificado, 'ignorado' => $ignorado, 'total' => $total];
        echo json_encode($respuesta);
    }
    public function importar_asistencia_frontera()
    {


        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['msg' => 'Método no permitido', 'icono' => 'error']);
            exit;
        }
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        if ($data === null) {
            http_response_code(400);
            echo json_encode(['msg' => 'Datos inválidos', 'icono' => 'error']);
            exit;
        }

        $aceptado = 0;
        $ignorado = 0;
        $modificado = 0;
        $total = count($data);
        $registros = [];
        $posicion = 0;

        $festividades = $this->model->getAllfestividad();
        $festividadesArray = [];
        foreach ($festividades as $festividad) {
            $dia_festividad = str_pad($festividad['dia_inicio'], 2, '0', STR_PAD_LEFT);
            $mes_festividad = str_pad($festividad['mes_inicio'], 2, '0', STR_PAD_LEFT);
            $tipo = $festividad['tipo'];
            $clave = $dia_festividad . '-' . $mes_festividad;
            if (!isset($festividadesArray[$clave])) {
                $festividadesArray[$clave] = [];
            }
            $festividadesArray[$clave][] = $tipo;
        }

        foreach ($data as $key => $registro) {
            $posicion++;
            $valido = true;
            $accion = '';
            if (isset($registro['Fecha']) && isset($registro['Horas']) && isset($registro['Nro.'])) {
                $fecha = $registro['Fecha'];
                $timestamp = strtotime($fecha);
                $fecha_cumpleaños_csv = date('m-d', $timestamp);
                $telefono_id = $registro['Nro.'];
                $accion = 'crear';
                $registroHoras = [
                    isset($registro['Horas'][0]) ? $registro['Horas'][0] : '00:00:00',
                    isset($registro['Horas'][1]) ? $registro['Horas'][1] : '00:00:00',
                    isset($registro['Horas'][2]) ? $registro['Horas'][2] : '00:00:00',
                    isset($registro['Horas'][3]) ? $registro['Horas'][3] : '00:00:00',
                    isset($registro['Horas'][4]) ? $registro['Horas'][4] : '00:00:00',
                    isset($registro['Horas'][5]) ? $registro['Horas'][5] : '00:00:00',
                    isset($registro['Horas'][6]) ? $registro['Horas'][6] : '00:00:00',
                    isset($registro['Horas'][7]) ? $registro['Horas'][7] : '00:00:00'
                ];

                $result = $this->model->getAsistencia($telefono_id, $fecha);
                if (($result)) {
                    $asistencia_id = $result['aid'];
                    $accion = 'editar';
                    $dbHoras = [
                        $result['reloj_1'],
                        $result['reloj_2'],
                        $result['reloj_3'],
                        $result['reloj_4'],
                        $result['reloj_5'],
                        $result['reloj_6'],
                        $result['reloj_7'],
                        $result['reloj_8']
                    ];
                    $horasOrdenadas = $this->combinarYOrdenarHoras($dbHoras, $registroHoras);
                    $reloj_1 = $horasOrdenadas[0];
                    $reloj_2 = $horasOrdenadas[1];
                    $reloj_3 = $horasOrdenadas[2];
                    $reloj_4 = $horasOrdenadas[3];
                    $reloj_5 = $horasOrdenadas[4];
                    $reloj_6 = $horasOrdenadas[5];
                    $reloj_7 = $horasOrdenadas[6];
                    $reloj_8 = $horasOrdenadas[7];
                } else {
                    // Si no hay datos previos, usar las horas del registro directamente
                    $reloj_1 = $registroHoras[0];
                    $reloj_2 = $registroHoras[1];
                    $reloj_3 = $registroHoras[2];
                    $reloj_4 = $registroHoras[3];
                    $reloj_5 = $registroHoras[4];
                    $reloj_6 = $registroHoras[5];
                    $reloj_7 = $registroHoras[6];
                    $reloj_8 = $registroHoras[7];
                }

                $licencia = '';
                $tardanza = '00:00:00';
                $tardanza_cantidad = 0;
                $es_festividad = false;
                $es_honomastico = false;
                $entrada = '00:00:00';
                $salida = '00:00:00';
                $total_horario = '00:00:00';
                $total_entrada_salida_reloj = '00:00:00';

                $timestamp = strtotime($fecha);
                $fecha_csv = date('Y-m-d', $timestamp);

                // $result = $this->model->getAllfestividad();
                // $dia_csv = date('d', strtotime($fecha_csv));
                // $mes_csv = date('m', strtotime($fecha_csv));
                // for ($i = 0; $i < count($result); $i++) {

                //     // $dia = $result[$i]['dia_inicio'];
                //     $dia_festividad = str_pad($result[$i]['dia_inicio'], 2, '0', STR_PAD_LEFT);
                //     $mes_festividad = str_pad($result[$i]['mes_inicio'], 2, '0', STR_PAD_LEFT);
                //     if ($dia_csv == $dia_festividad && $mes_csv == $mes_festividad) {
                //         $es_festividad = true;
                //         break;
                //     }
                // }
                $dia_csv = str_pad(date('d', strtotime($fecha_csv)), 2, '0', STR_PAD_LEFT);
                $mes_csv = str_pad(date('m', strtotime($fecha_csv)), 2, '0', STR_PAD_LEFT);
                $clave_csv = $dia_csv . '-' . $mes_csv;
                if (isset($festividadesArray[$clave_csv])) {
                    if (in_array('feriado', $festividadesArray[$clave_csv])) {
                        $es_festividad = true;
                        $tipo_festividad = 'feriado';
                    } elseif (in_array('compensable', $festividadesArray[$clave_csv])) {
                        $es_festividad = true;
                        $tipo_festividad = 'compensable';
                    }
                }

                foreach ($horasOrdenadas as $hora) {
                    if ($hora !== '00:00:00') {
                        if ($entrada === '00:00:00') {
                            $entrada = $hora;
                        }
                        if ($hora !== $entrada) {
                            $salida = $hora;
                        }
                    }
                }

                $result = $this->model->getTrabajador($telefono_id);

                if (empty($result)) {
                    $ignorado++;
                }
                if ($result) {
                    $trabajador_id = $result['tid'];
                    $fecha_nacimiento_csv = isset($result['fecha_nacimiento']) ? $result['fecha_nacimiento'] : '3000-01-01';

                    $fecha_nacimiento = strtotime($fecha_nacimiento_csv);
                    $fecha_nacimiento = date('m-d', $fecha_nacimiento);

                    $hora_entrada_trabajador_formato = strtotime($result['hora_entrada']);
                    $hora_salida_trabajador_formato = strtotime($result['hora_salida']);
                    $entrada_trabajador_mas_6 = strtotime('+6 minutes', $hora_entrada_trabajador_formato);
                    $entrada_trabajador_mas_30 = strtotime('+31 minutes', $hora_entrada_trabajador_formato);

                    $entrada_trabajador_limite = strtotime('+5 minutes', $hora_entrada_trabajador_formato);

                    $entrada_timestamp = strtotime($entrada);
                    $salida_timestamp = strtotime($salida);
                    $diferencia_trabajador_segundos = $hora_salida_trabajador_formato - $hora_entrada_trabajador_formato;
                    $diferencia_entrada_salida_segundos = $salida_timestamp - $entrada_timestamp;

                    if ($reloj_1 == '00:00:00') {
                        $licencia = 'SR';
                    }

                    if ($reloj_1 !== '00:00:00') {

                        if ($salida == '00:00:00') {
                            $licencia = 'NMS';
                        }
                        if ($salida !== '00:00:00') {
                            if (strtotime($entrada) < $entrada_trabajador_mas_6) {
                                // Llegó menos de 6 minutos tarde  
                                $tardanza = '00:00:00';
                                $tardanza_cantidad = 0;
                            }
                            if (
                                strtotime($entrada) >= $entrada_trabajador_mas_6 &&
                                strtotime($entrada) < $entrada_trabajador_mas_30
                            ) {
                                // Llegó entre 6 y 30 minutos tarde
                                $tardanza_cantidad = 1;
                            }
                            if (strtotime($entrada) >= $entrada_trabajador_mas_30) {
                                // Llegó más de 30 minutos tarde
                                $tardanza_cantidad = 0;
                                $licencia = '+30';
                            }
                            if (strtotime($entrada) >= $hora_salida_trabajador_formato) {
                                $licencia = 'NME';
                            }

                            if (strtotime($entrada) < $entrada_trabajador_mas_30 && strtotime($salida) >= $hora_salida_trabajador_formato) {
                                $licencia = 'OK';
                                $total_horario = gmdate('H:i', $diferencia_trabajador_segundos);
                                $total_entrada_salida_reloj = gmdate('H:i', $diferencia_entrada_salida_segundos);
                            }
                            if (strtotime($entrada) < $entrada_trabajador_mas_30 && strtotime($salida) < $hora_salida_trabajador_formato) {
                                $licencia = 'NMS';
                            }
                        }
                    }
                    if ($reloj_1 !== '00:00' && $licencia == 'OK' && ($entrada_timestamp >= $entrada_trabajador_mas_6 &&
                        $entrada_timestamp < $entrada_trabajador_mas_30)) {

                        $diferencia_tardanza = $entrada_timestamp - $entrada_trabajador_limite;
                        $tardanza = gmdate('H:i', $diferencia_tardanza);
                    }

                    // if ($es_festividad == true  && $reloj_1 == '00:00:00') {
                    //     $licencia = 'FERIADO';
                    // }
                    if ($es_festividad == true && $reloj_1 == '00:00') {
                        
                        if( $tipo_festividad == 'feriado'){
                            $licencia = 'FERIADO';
                        }
                        if( $tipo_festividad == 'compensable'){
                            $licencia ='COMPENSABLE';
                        }
                    }
                    if (($fecha_nacimiento == $fecha_cumpleaños_csv) && ($fecha_nacimiento_csv !== '3000-01-01')) {
                        $licencia = 'ONOMASTICO';
                    }
                    if ($entrada == $salida && $licencia == 'NMS') {
                    }

                    $justificacion = '';
                    // $registros[] = [$result];
                    if ($accion == 'crear') {
                        // REGISTRO ASISTENCIA
                        $aceptado++;
                        $this->model->registrarAsistencia($trabajador_id, $licencia, $fecha, $entrada, $salida, $tardanza, $tardanza_cantidad, $total_entrada_salida_reloj, $total_horario, $justificacion, $reloj_1, $reloj_2, $reloj_3, $reloj_4, $reloj_5, $reloj_6, $reloj_7, $reloj_8);
                    }
                    if ($accion == 'editar') {

                        // ACTUALIZO ASISTENCIA
                        $modificado++;
                        $this->model->modificarAsistencia($trabajador_id, $licencia, $fecha, $entrada, $salida, $tardanza, $tardanza_cantidad, $total_entrada_salida_reloj, $total_horario, $justificacion, $reloj_1, $reloj_2, $reloj_3, $reloj_4, $reloj_5, $reloj_6, $reloj_7, $reloj_8, $asistencia_id);
                    }
                    $registros[] = [
                        'Fecha' => $fecha,
                        'trabajador_id' => $trabajador_id,
                        'Entrada' => $entrada,
                        'Salida' => $salida,
                        'Hora1' => $reloj_1,
                        'Hora2' => $reloj_2,
                        'Hora3' => $reloj_3,
                        'Hora4' => $reloj_4,
                        'Hora5' => $reloj_5,
                        'Hora6' => $reloj_6,
                        'Hora7' => $reloj_7,
                        'Hora8' => $reloj_8,
                        'licencia' => $licencia,
                        'total' => $total_horario,
                        'total_reloj' => $total_entrada_salida_reloj,
                        'tardanza' => $tardanza,
                        'tardanza_cantidad' => $tardanza_cantidad,
                        'Accion' => $accion,
                        // $dbHoras, $registroHoras
                    ];
                }
            }
        }

        $respuesta = ['aceptado' => $aceptado, 'modificado' => $modificado, 'ignorado' => $ignorado, 'total' => $total];
        // echo json_encode($registros);
        echo json_encode($respuesta);
    }

    public function importar_asistencia_samu()
    {


        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['msg' => 'Método no permitido', 'icono' => 'error']);
            exit;
        }
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        if ($data === null) {
            http_response_code(400);
            echo json_encode(['msg' => 'Datos inválidos', 'icono' => 'error']);
            exit;
        }

        $aceptado = 0;
        $ignorado = 0;
        $modificado = 0;
        $total = count($data);
        $registros = [];
        $posicion = 0;

        $festividades = $this->model->getAllfestividad();
        $festividadesArray = [];
        foreach ($festividades as $festividad) {
            $dia_festividad = str_pad($festividad['dia_inicio'], 2, '0', STR_PAD_LEFT);
            $mes_festividad = str_pad($festividad['mes_inicio'], 2, '0', STR_PAD_LEFT);
            $tipo = $festividad['tipo'];
            $clave = $dia_festividad . '-' . $mes_festividad;
            if (!isset($festividadesArray[$clave])) {
                $festividadesArray[$clave] = [];
            }
            $festividadesArray[$clave][] = $tipo;
        }


        foreach ($data as $key => $registro) {
            $posicion++;
            $valido = true;
            $accion = '';
            if (isset($registro['Fecha']) && isset($registro['Horas']) && isset($registro['nombre'])  && isset($registro['Nro.'])) {
                $fecha = $registro['Fecha'];
                $timestamp = strtotime($fecha);
                $fecha_cumpleaños_csv = date('m-d', $timestamp);
                $nombre = $registro['nombre'];
                $result_trabajador = $this->model->getTrabajadorPorNombre($nombre);
                if (empty($result_trabajador)) {
                    $dni = $registro['Nro.'];
                    $result_trabajador = $this->model->getTrabajadorPorDNI($dni);
                }


                $accion = 'crear';
                $registroHoras = [
                    isset($registro['Horas'][0]) ? $registro['Horas'][0] : '00:00:00',
                    isset($registro['Horas'][1]) ? $registro['Horas'][1] : '00:00:00',
                    isset($registro['Horas'][2]) ? $registro['Horas'][2] : '00:00:00',
                    isset($registro['Horas'][3]) ? $registro['Horas'][3] : '00:00:00',
                    isset($registro['Horas'][4]) ? $registro['Horas'][4] : '00:00:00',
                    isset($registro['Horas'][5]) ? $registro['Horas'][5] : '00:00:00',
                    isset($registro['Horas'][6]) ? $registro['Horas'][6] : '00:00:00',
                    isset($registro['Horas'][7]) ? $registro['Horas'][7] : '00:00:00'
                ];


                $result = $this->model->getAsistenciaPorId($result_trabajador['tid'], $fecha);
                if (($result)) {
                    $asistencia_id = $result['aid'];
                    $accion = 'editar';
                    $dbHoras = [
                        $result['reloj_1'],
                        $result['reloj_2'],
                        $result['reloj_3'],
                        $result['reloj_4'],
                        $result['reloj_5'],
                        $result['reloj_6'],
                        $result['reloj_7'],
                        $result['reloj_8']
                    ];
                    $horasOrdenadas = $this->combinarYOrdenarHoras($dbHoras, $registroHoras);
                } else {
                    // Si no hay datos previos, usar las horas del registro directamente
                    $horasOrdenadas = $registroHoras;
                }
                $reloj_1 = $horasOrdenadas[0];
                $reloj_2 = $horasOrdenadas[1];
                $reloj_3 = $horasOrdenadas[2];
                $reloj_4 = $horasOrdenadas[3];
                $reloj_5 = $horasOrdenadas[4];
                $reloj_6 = $horasOrdenadas[5];
                $reloj_7 = $horasOrdenadas[6];
                $reloj_8 = $horasOrdenadas[7];

                $licencia = '';
                $tardanza = '00:00:00';
                $tardanza_cantidad = 0;
                $es_festividad = false;
                $es_honomastico = false;
                $entrada = '00:00:00';
                $salida = '00:00:00';
                $total_horario = '00:00:00';
                $total_entrada_salida_reloj = '00:00:00';

                $timestamp = strtotime($fecha);
                $fecha_csv = date('Y-m-d', $timestamp);

                // $result = $this->model->getAllfestividad();
                // $dia_csv = date('d', strtotime($fecha_csv));
                // $mes_csv = date('m', strtotime($fecha_csv));
                // for ($i = 0; $i < count($result); $i++) {

                //     // $dia = $result[$i]['dia_inicio'];
                //     $dia_festividad = str_pad($result[$i]['dia_inicio'], 2, '0', STR_PAD_LEFT);
                //     $mes_festividad = str_pad($result[$i]['mes_inicio'], 2, '0', STR_PAD_LEFT);
                //     if ($dia_csv == $dia_festividad && $mes_csv == $mes_festividad) {
                //         $es_festividad = true;
                //         break;
                //     }
                // }
                $dia_csv = str_pad(date('d', strtotime($fecha_csv)), 2, '0', STR_PAD_LEFT);
                $mes_csv = str_pad(date('m', strtotime($fecha_csv)), 2, '0', STR_PAD_LEFT);
                $clave_csv = $dia_csv . '-' . $mes_csv;
                if (isset($festividadesArray[$clave_csv])) {
                    if (in_array('feriado', $festividadesArray[$clave_csv])) {
                        $es_festividad = true;
                        $tipo_festividad = 'feriado';
                    } elseif (in_array('compensable', $festividadesArray[$clave_csv])) {
                        $es_festividad = true;
                        $tipo_festividad = 'compensable';
                    }
                }

                foreach ($horasOrdenadas as $hora) {
                    if ($hora !== '00:00:00') {
                        if ($entrada === '00:00:00') {
                            $entrada = $hora;
                        }
                        if ($hora !== $entrada) {
                            $salida = $hora;
                        }
                    }
                }


                if (empty($result_trabajador)) {
                    $ignorado++;
                }
                if ($result_trabajador) {
                    $trabajador_id = $result_trabajador['tid'];
                    $fecha_nacimiento_csv = isset($result_trabajador['fecha_nacimiento']) ? $result_trabajador['fecha_nacimiento'] : '3000-01-01';

                    $fecha_nacimiento = strtotime($fecha_nacimiento_csv);
                    $fecha_nacimiento = date('m-d', $fecha_nacimiento);

                    $hora_entrada_trabajador_formato = strtotime($result_trabajador['hora_entrada']);
                    $hora_salida_trabajador_formato = strtotime($result_trabajador['hora_salida']);
                    $entrada_trabajador_mas_6 = strtotime('+6 minutes', $hora_entrada_trabajador_formato);
                    $entrada_trabajador_mas_30 = strtotime('+31 minutes', $hora_entrada_trabajador_formato);

                    $entrada_trabajador_limite = strtotime('+5 minutes', $hora_entrada_trabajador_formato);

                    $entrada_timestamp = strtotime($entrada);
                    $salida_timestamp = strtotime($salida);
                    $diferencia_trabajador_segundos = $hora_salida_trabajador_formato - $hora_entrada_trabajador_formato;
                    $diferencia_entrada_salida_segundos = $salida_timestamp - $entrada_timestamp;

                    if ($reloj_1 == '00:00:00') {
                        $licencia = 'SR';
                    }

                    if ($reloj_1 !== '00:00:00') {

                        if ($salida == '00:00:00') {
                            $licencia = 'NMS';
                        }
                        if ($salida !== '00:00:00') {
                            if (strtotime($entrada) < $entrada_trabajador_mas_6) {
                                // Llegó menos de 6 minutos tarde  
                                $tardanza = '00:00:00';
                                $tardanza_cantidad = 0;
                            }
                            if (
                                strtotime($entrada) >= $entrada_trabajador_mas_6 &&
                                strtotime($entrada) < $entrada_trabajador_mas_30
                            ) {
                                // Llegó entre 6 y 30 minutos tarde
                                $tardanza_cantidad = 1;
                            }
                            if (strtotime($entrada) >= $entrada_trabajador_mas_30) {
                                // Llegó más de 30 minutos tarde
                                $tardanza_cantidad = 0;
                                $licencia = '+30';
                            }
                            if (strtotime($entrada) >= $hora_salida_trabajador_formato) {
                                $licencia = 'NME';
                            }

                            if (strtotime($entrada) < $entrada_trabajador_mas_30 && strtotime($salida) >= $hora_salida_trabajador_formato) {
                                $licencia = 'OK';
                                $total_horario = gmdate('H:i', $diferencia_trabajador_segundos);
                                $total_entrada_salida_reloj = gmdate('H:i', $diferencia_entrada_salida_segundos);
                            }
                            if (strtotime($entrada) < $entrada_trabajador_mas_30 && strtotime($salida) < $hora_salida_trabajador_formato) {
                                $licencia = 'NMS';
                            }
                        }
                    }
                    if ($reloj_1 !== '00:00:00' && $licencia == 'OK' && ($entrada_timestamp >= $entrada_trabajador_mas_6 &&
                        $entrada_timestamp < $entrada_trabajador_mas_30)) {

                        $diferencia_tardanza = $entrada_timestamp - $entrada_trabajador_limite;
                        $tardanza = gmdate('H:i', $diferencia_tardanza);
                    }

                    // if ($es_festividad == true  && $reloj_1 == '00:00:00') {
                    //     $licencia = 'FERIADO';
                    // }
                    if ($es_festividad == true && $reloj_1 == '00:00:00') {
                        
                        if( $tipo_festividad == 'feriado'){
                            $licencia = 'FERIADO';
                        }
                        if( $tipo_festividad == 'compensable'){
                            $licencia ='COMPENSABLE';
                        }
                    }
                    if (($fecha_nacimiento == $fecha_cumpleaños_csv) && ($fecha_nacimiento_csv !== '3000-01-01')) {
                        $licencia = 'ONOMASTICO';
                    }
                    if ($entrada == $salida && $licencia == 'NMS') {
                    }

                    $justificacion = '';
                    // $registros[] = [$result];
                    if ($accion == 'crear') {
                        // REGISTRO ASISTENCIA
                        $aceptado++;
                        $this->model->registrarAsistencia($trabajador_id, $licencia, $fecha, $entrada, $salida, $tardanza, $tardanza_cantidad, $total_entrada_salida_reloj, $total_horario, $justificacion, $reloj_1, $reloj_2, $reloj_3, $reloj_4, $reloj_5, $reloj_6, $reloj_7, $reloj_8);
                    }
                    if ($accion == 'editar') {

                        // ACTUALIZO ASISTENCIA
                        $modificado++;
                        $this->model->modificarAsistencia($trabajador_id, $licencia, $fecha, $entrada, $salida, $tardanza, $tardanza_cantidad, $total_entrada_salida_reloj, $total_horario, $justificacion, $reloj_1, $reloj_2, $reloj_3, $reloj_4, $reloj_5, $reloj_6, $reloj_7, $reloj_8, $asistencia_id);
                    }
                    $registros[] = [
                        'nombre' => $nombre,
                        'Fecha' => $fecha,
                        'trabajador_id' => $trabajador_id,
                        'Entrada' => $entrada,
                        'Salida' => $salida,
                        'Hora1' => $reloj_1,
                        'Hora2' => $reloj_2,
                        'Hora3' => $reloj_3,
                        'Hora4' => $reloj_4,
                        'Hora5' => $reloj_5,
                        'Hora6' => $reloj_6,
                        'Hora7' => $reloj_7,
                        'Hora8' => $reloj_8,
                        'licencia' => $licencia,
                        'total' => $total_horario,
                        'total_reloj' => $total_entrada_salida_reloj,
                        'tardanza' => $tardanza,
                        'tardanza_cantidad' => $tardanza_cantidad,
                        'Accion' => $accion,
                        // $dbHoras, $registroHoras
                    ];
                }
            }
        }

        $respuesta = ['aceptado' => $aceptado, 'modificado' => $modificado, 'ignorado' => $ignorado, 'total' => $total];
        // echo json_encode($registros);
        echo json_encode($respuesta);
    }

    function compararEncabezados($encabezadoRecibido, $encabezadoEsperado)
    {
        // Convertir ambos encabezados a minúsculas y quitar espacios en blanco
        $encabezadoRecibido = array_map('strtolower', array_map('trim', $encabezadoRecibido));
        $encabezadoEsperado = array_map('strtolower', array_map('trim', $encabezadoEsperado));

        // Comparar los encabezados normalizados
        return array_diff($encabezadoRecibido, $encabezadoEsperado) === array_diff($encabezadoEsperado, $encabezadoRecibido);
    }

    public function validar_archivo()
    {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['msg' => 'Método no permitido', 'validado' => false]);
            exit;
        }

        $archivo = $_FILES['archivo']; // Obtener el archivo enviado
        $nombreArchivo = $archivo['name'];
        $tipoArchivo = $archivo['type'];

        // Validar que sea un archivo CSV o Excel
        $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
        if ($extension == 'xls') {
            echo json_encode(['msg' => 'Modifique el archivo a XLSX', 'validado' => false]);
            exit;
        }
        if (!in_array($extension, ['csv', 'xlsx'])) {
            echo json_encode(['msg' => 'Tipo de archivo no válido', 'validado' => false]);
            exit;
        }

        // Leer el encabezado del archivo enviado
        $encabezado = json_decode($_POST['encabezado'], true);
        // if($extension =='xls'){

        // }

        $tiposEncabezado = [
            'asistencia_csv' => ["Fecha", "ID", "Nombre Usuario", "Departamento", "Entrada - Salida 1", "Entrada - Salida 2", "Entrada - Salida 3", "Entrada - Salida 4", "Entrada - Salida 5", "Entrada - Salida 6", "Entrada - Salida 7", "Entrada - Salida 8", "Descanso", "Tiempo Trabajado"],
            'usuario_csv' => ["ID Usuario", "Nombre", "Departamento", "Correo", "Tel�fono", "Fecha Inicio", "Fecha Vencimiento", "Nivel Admin.", "Modo Autenticaci�n", "N�mero de Template", "Grupo de Acceso1", "Grupo de Acceso2", "Grupo de Acceso3", "Grupo de Acceso4", "N�mero Tarjeta", "Bypass", "Title", "Mobile", "Gender", "Date of Birth"],
            'frontera_samu_1' => ["Dpto.", "Nombre", "No.", "Fecha/Hora", "Locación ID", "ID Número", "VerificaCod", "No.tarjeta"],
            // 'frontera_samu_2' => ["AC No.", "Nombre", "Dpto.", "Fecha", "Hora"],
            // 'tipo5' => ["ColumnaA", "ColumnaB", "ColumnaC", "ColumnaD"],

        ];
        $tipoValidado = false;
        $tipoArchivoValidado = '';

        foreach ($tiposEncabezado as $tipo => $esperado) {
            // Comparar encabezados ignorando diferencias de codificación y mayúsculas/minúsculas
            if ($this->compararEncabezados($encabezado, $esperado)) {
                $tipoValidado = true;
                $tipoArchivoValidado = $tipo;
                break;
            }
        }

        $datosComparados = [
            'encabezado_recibido' => $encabezado,
            'encabezados_esperados' => $tiposEncabezado,
        ];

        if ($tipoArchivoValidado == 'frontera_samu_1' || $tipoArchivoValidado == 'frontera_samu_2') {
            $fila1 = json_decode($_POST['fila_1'], true);
            // $tipoValidado = false;
            $tipo_fila = '';
            if (in_array("FRONTERA", $fila1)) {
                $tipo_fila = 'FRONTERA';
            }
            if (in_array("SAMU2023", $fila1)) {
                $tipo_fila = 'SAMU2023';
            }
            if ($tipoArchivoValidado == 'frontera_samu_1' && $tipo_fila == 'FRONTERA') {

                $tipoArchivoValidado = 'frontera_1';
            }
            if ($tipoArchivoValidado == 'frontera_samu_2' && $tipo_fila == 'FRONTERA') {
                $tipoArchivoValidado = 'frontera_2';
                // Aquí puedes agregar la lógica específica para 'frontera_samu_1'
            }

            if ($tipoArchivoValidado == 'frontera_samu_1' && $tipo_fila == 'SAMU2023') {
                $tipoArchivoValidado = 'samu_1';
                // Aquí puedes agregar la lógica específica para 'frontera_samu_2'
            }
            if ($tipoArchivoValidado == 'frontera_samu_2' && $tipo_fila == 'SAMU2023') {
                $tipoArchivoValidado = 'samu_2';
                // Aquí puedes agregar la lógica específica para 'frontera_samu_2'
            }
        }


        if (!$tipoValidado) {
            // echo json_encode($tipoArchivoValidado);
            echo json_encode(['msg' => 'Encabezado no valido', 'validado' => false]);
            exit;
        }

        echo json_encode(['msg' => 'Archivo valido', 'validado' => true, 'tipo' => $tipoArchivoValidado,  'datos' => $encabezado]);
    }
    function combinarYOrdenarHoras($dbHoras, $registroHoras)
    {
        // Combinar ambas listas de horas
        $todasHoras = array_merge($dbHoras, $registroHoras);

        // Eliminar '00:00:00' y ordenar las horas
        $horasFiltradas = array_unique(array_filter($todasHoras, function ($hora) {
            return $hora != '00:00:00';
        }));
        sort($horasFiltradas);

        // Rellenar con '00:00:00' hasta completar 8 horas
        $horasOrdenadas = array_pad($horasFiltradas, 8, '00:00:00');

        return $horasOrdenadas;
    }

    function combinarYOrdenarHoras2($dbHoras, $registroHoras)
    {
        // Combinar y ordenar horas
        $todasHoras = array_merge($dbHoras, $registroHoras);

        // Eliminar '00:00:00' y ordenar las horas
        $horasFiltradas = array_unique(array_filter($todasHoras, function ($hora) {
            return $hora != '00:00';
        }));
        sort($horasFiltradas);

        // Rellenar con '00:00:00' hasta completar 8 horas
        $horasOrdenadas = array_pad($horasFiltradas, 8, '00:00');

        return $horasOrdenadas;
    }

    function eliminarHorasRepetidas($horas)
    {
        // Eliminar '00:00:00' y ordenar las horas
        $horasFiltradas = array_unique(array_filter($horas, function ($hora) {
            return $hora != '00:00';
        }));
        sort($horasFiltradas);

        // Obtener la cantidad de horas filtradas
        $cantidadHoras = count($horasFiltradas);

        // Rellenar con '00:00' hasta completar 8 horas si hay menos de 8 horas válidas
        $horasOrdenadas = array_pad($horasFiltradas, 8, '00:00');

        // Si todas las horas son '00:00', mantener el arreglo original de $horas
        if ($cantidadHoras === 0) {
            $horasOrdenadas = $horas;
        }

        return $horasOrdenadas;
    }
}
