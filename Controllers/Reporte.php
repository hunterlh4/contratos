<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class Reporte extends Controller
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

        if ($_SESSION['nivel'] !== 1 &&  $_SESSION['nivel'] !== 100) {
            header('Location: ' . BASE_URL . 'errors');
            exit;
        }
        $data['title'] = 'Reporte General';
        $data1 = '';

        $this->views->getView('Administracion', "Reporte", $data, $data1);
    }
    public function Mensual()
    {
        if ($_SESSION['nivel'] !== 1 &&  $_SESSION['nivel'] !== 100) {
            header('Location: ' . BASE_URL . 'errors');
            exit;
        }
        $data['title'] = 'Reporte Mensual';
        $data1 = '';

        $this->views->getView('Administracion', "Reporte_Trabajador", $data, $data1);
    }

    public function Fechas()
    {
        if ($_SESSION['nivel'] !== 1 &&  $_SESSION['nivel'] !== 100) {
            header('Location: ' . BASE_URL . 'errors');
            exit;
        }
        $data['title'] = 'Reporte Entre dos Fechas';
        $data1 = '';

        $this->views->getView('Administracion', "Reporte_Direccion", $data, $data1);
    }

    public function Kardex()
    {
        if ($_SESSION['nivel'] !== 1 &&  $_SESSION['nivel'] !== 100) {
            header('Location: ' . BASE_URL . 'errors');
            exit;
        }
        $data['title'] = 'Reporte Kardex';
        $data1 = '';

        $this->views->getView('Administracion', "Reporte_Kardex", $data, $data1);
    }
    public function listar()
    {
        $data = $this->model->getReporteTrabajadorAll();

        echo json_encode($data);
        die();
    }

    public function borrar()
    {
        if (isset($_POST['filePath'])) {
            $filePath = $_POST['filePath'];
            // $filePath = filter_var($filePath, FILTER_SANITIZE_URL);

            $url =  './Uploads/Reportes/' . $filePath;
            if (file_exists($url)) {
                // Intentar eliminar el archivo
                if (unlink($url)) {
                    $respuesta = ['status' => 'success', 'message' => 'Archivo eliminado'];
                } else {
                    $respuesta = ['status' => 'error', 'message' => 'Error al eliminar el archivo'];
                }
            } else {
                $respuesta = ['status' => 'error', 'message' => 'Archivo no encontrado'];
            }
        } else {
            $respuesta = ['status' => 'error', 'message' => 'No se recibió el nombre del archivo'];
        }
        echo json_encode($respuesta);
    }


    public function generar_reporte_detallado()
    {
        // $respuesta =array();

        $data[] = [];
        $mensaje = '';
        if (isset($_POST['trabajador']) && isset($_POST['mes']) && isset($_POST['anio'])) {
            $trabajador = $_POST['trabajador'];
            $mes = $_POST['mes'];
            $anio = $_POST['anio'];
            $peticion = $this->exportarDetallado($trabajador, $mes, $anio);
            $filePath = $peticion['filepath'];
            $nombreArchivo = $peticion['nombreArchivo'];
            $mensaje = $peticion['mensaje'];

            if (empty($mensaje)) {
                $respuesta = ['msg' => 'agregado', 'icono' => 'success', 'archivo' => $filePath, 'nombre' => $nombreArchivo];
            } else {
                $respuesta = ['msg' =>  $mensaje, 'icono' => 'warning', 'archivo' => $filePath, 'nombre' => $nombreArchivo];
            }
        } else {
            $respuesta = ['msg' => 'falta de datos', 'icono' => 'error'];
        }
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function generar_reporte_general()
    {
        $data[] = [];
        $mensaje = '';
        if (isset($_POST['mes']) && isset($_POST['anio']) && isset($_POST['tipo'])) {
            $mes = $_POST['mes'];
            $anio = $_POST['anio'];
            $tipo = $_POST['tipo'];
            if ($tipo == 'general') {
                $peticion = $this->exportarGeneralLicencia($mes, $anio);
            }
            if ($tipo == 'tardanza') {
                $peticion = $this->exportarGeneralTardanza($mes, $anio);
            }

            $filePath = $peticion['filepath'];
            $nombreArchivo = $peticion['nombreArchivo'];
            $mensaje = $peticion['mensaje'];
            // $envio = $peticion['data'];
            if (empty($mensaje)) {
                $respuesta = ['msg' => 'agregado', 'icono' => 'success', 'archivo' => $filePath, 'nombre' => $nombreArchivo];
            } else {
                $respuesta = ['msg' =>  $mensaje, 'icono' => 'warning', 'archivo' => $filePath, 'nombre' => $nombreArchivo];
            }
        } else {
            $respuesta = ['msg' => 'falta de datos', 'icono' => 'error'];
        }
        // echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        echo json_encode($respuesta);
        die();
    }

    public function generar_kardex()
    {
        $data[] = [];
        $error_message = '';

        // Verifica si la solicitud es de tipo POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(["icono" => "error", "msg" => "Método de solicitud no permitido"]);
            exit;
        }
        $trabajador = $_POST['trabajador'] ?? '';
        $anio = $_POST['anio'] ?? '';
        $mes_inicio = $_POST['mes_inicio'] ?? '';
        $mes_fin = $_POST['mes_fin'] ?? '';

        if (empty($trabajador)) {
            $error_message .= "El campo 'trabajador' es obligatorio.<br>";
        }
        if (empty($anio)) {
            $error_message .= "El campo 'año' es obligatorio.<br>";
        }
        if (empty($mes_inicio)) {
            $error_message .= "El campo 'mes inicio' es obligatorio.<br>";
        }
        if (empty($mes_fin)) {
            $error_message .= "El campo 'mes fin' es obligatorio.<br>";
        }

        if (!empty($error_message)) {
            echo json_encode(["icono" => "error", "msg" => $error_message]);
            exit;
        }
        $peticion = $this->exportarKardex($trabajador, $anio, $mes_inicio, $mes_fin);
        // $filePath = $peticion['filepath'] ?? 'filepath';
        // $nombreArchivo = $peticion['nombreArchivo'] ?? 'nombrearchivo';
        // // $mensaje = $peticion['mensaje'] ?? 'mensaje';
        // $mensaje = $trabajador.'|'.$anio.'|'.$mes_inicio.'|'.$mes_fin;


        // $respuesta = ['msg' => $mensaje, 'icono' => 'error', 'archivo' => $filePath, 'nombre' => $nombreArchivo];

        echo json_encode($peticion);
    }
    // NUEVO
    public function exportarDetallado2($trabajador, $mes, $anio)
    {
        $mensaje = '';
        $cantidad = 0;
        $reporte = 0;
        $filePath = '';
        $fileName = '';
        $nombreArchivo = '';

        $nombre_mes = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $diasDeLaSemana = ['lun.', 'mar.', 'mié.', 'jue.', 'vie.', 'sáb.', 'dom.'];

        $nombreMes = $nombre_mes[$mes - 1];
        $reporte++;
        $cantidad++;
        $nombre = '';

        $total = 0;
        $total_real = 0;

        $data = $this->model->Reporte_Trabajador($trabajador, $mes, $anio);

        if ($data > 0) {
            // DATOS DEL TRABAJADOR
            // $datos_trabajador = $this->model->getTrabajador($trabajador, $mes, $anio);
            $datos_trabajador = $this->model->obtenerBoletas($trabajador, $mes, $anio);

            date_default_timezone_set("America/Lima");
            setlocale(LC_TIME, 'es_PE.UTF-8', 'esp');
            $horario_entrada = '';
            $horario_salida = '';
            $datos_trabajador_detalle = $this->model->obtenerHorarioDetalle($trabajador);
            $nombre = $datos_trabajador_detalle['trabajador_nombre'];
            $horario_entrada = $datos_trabajador_detalle['horario_entrada'];
            $horario_salida = $datos_trabajador_detalle['horario_salida'];

           
            $fecha_boletas = [];
            $fecha_actual = date('d-m-Y');
            $hora_actual = date('H:i:s');

            $inasistencia = 0;
            $tardanza = 0;
            $Cantidad_licencia = 0;

            $boleta = '';
            $dato_vacio = false;



            foreach ($datos_trabajador as $datos) {

                // $nombre = $datos['trabajador_nombre'];
                $fecha_str = date('d-m-Y', strtotime($datos['fecha']));
                array_push($fecha_boletas, $fecha_str);
                $Cantidad_licencia += intval($datos['total_motivos_particulares']);
                // $horario_entrada = $datos['horario_entrada'];
                // $horario_salida = $datos['horario_salida'];
            }
            $spread = new Spreadsheet();
            $sheet = $spread->getActiveSheet();

            $sheet->setCellValue('A1', 'CÁLCULO DE HORAS ' . strtoupper($nombreMes) . ' del ' . $anio);
            $sheet->mergeCells('A1:Q1');
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(18);
            $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

            $sheet->mergeCells('A2:Q2');

            $sheet->setCellValue('A3', 'Nombre:');
            $sheet->mergeCells('A3:C3');
            $sheet->getStyle('A3')->getFont()->setBold(true)->setSize(10);
            $sheet->getStyle('A3')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ff424242'); // Cambia 'FFFF0000' al color deseado
            $sheet->getStyle('A3')->getFont()->getColor()->setARGB(Color::COLOR_WHITE);

            $sheet->setCellValue('D3', $nombre);
            $sheet->mergeCells('D3:I3');
            $sheet->getStyle('D3')->getFont()->setBold(true)->setSize(10);
            $sheet->getStyle('D3')->getAlignment()->setHorizontal('center');


            $sheet->setCellValue('A4', 'Hora de Reporte:');
            $sheet->mergeCells('A4:C4');
            $sheet->getStyle('A4')->getFont()->setBold(true)->setSize(10);
            $sheet->getStyle('A4')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ff424242'); // Cambia 'FFFF0000' al color deseado
            $sheet->getStyle('A4')->getFont()->getColor()->setARGB(Color::COLOR_WHITE);

            $sheet->setCellValue('D4', "$hora_actual - $fecha_actual");
            $sheet->mergeCells('D4:I4');
            $sheet->getStyle('D4')->getFont()->setBold(true)->setSize(10);
            $sheet->getStyle('D4')->getAlignment()->setHorizontal('center');

            $sheet->setCellValue('A5', 'Horario:');
            $sheet->mergeCells('A5:C5');
            $sheet->getStyle('A5')->getFont()->setBold(true)->setSize(10);
            $sheet->getStyle('A5')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A5')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ff424242'); // Cambia 'FFFF0000' al color deseado
            $sheet->getStyle('A5')->getFont()->getColor()->setARGB(Color::COLOR_WHITE);

            $sheet->setCellValue('D5', "$horario_entrada - $horario_salida");
            $sheet->mergeCells('D5:I5');
            $sheet->getStyle('D5')->getFont()->setBold(true)->setSize(10);
            $sheet->getStyle('D5')->getAlignment()->setHorizontal('center');

            $sheet->mergeCells('A6:Q6');
            $sheet->mergeCells('J3:Q5');

            $headers = ['Día', 'Fecha', 'Entrada', 'Salida', '', 'R1', 'R2', 'R3', 'R4', 'R5', 'R6', 'R7', 'R8', 'Total', 'Total Real', 'Observación', 'Justificacion'];
            $sheet->fromArray($headers, NULL, 'A7');
            $sheet->getStyle('A7:Q7')->getFont()->setBold(true);
            $sheet->getStyle('A7:Q7')->getFont()->getColor()->setARGB(Color::COLOR_WHITE);
            $sheet->getStyle('A7:Q7')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ff5dade2');
            $sheet->getStyle('E7')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ffffffff');

            $row = 8; // Comienza en la fila 7
            foreach ($data as $datos) {
                $boleta = '';
                $Observacion = '';
                if ($datos['licencia'] == 'NMS') {
                    $Observacion = "No marco Salida";
                }
                if ($datos['licencia'] == 'FERIADO') {
                    $Observacion = "Feriado";
                }
                if ($datos['licencia'] == 'COMPENSABLE') {
                    $Observacion = "F. compensable";
                }
                if ($datos['licencia'] == 'NME') {
                    $Observacion = "No marco entrada";
                }
                if ($datos['licencia'] == '+30') {
                    $Observacion = "+30";
                }
                $inasistencia += intval($datos['inasistencia']);
                $tardanza += intval($datos['tardanza_cantidad']);

                list($horas, $minutos) = explode(':', $datos['total']);
                $segundos = ($horas * 3600) + ($minutos * 60);
                $total += $segundos;

                list($horas, $minutos) = explode(':', $datos['total_reloj']);
                $segundos = ($horas * 3600) + ($minutos * 60);
                $total_real += $segundos;

                $fecha  = $datos['fecha'];
                $fecha = date('d-m-Y', strtotime($fecha));
                $justificacion = '';
                if (in_array($fecha, $fecha_boletas)) {
                    $boleta = 'boleta';
                }
                if (strlen($datos['justificacion']) > 1) {
                    $justificacion .= $datos['justificacion'] . " ";
                }
                if (strlen($boleta) > 1) {
                    $justificacion .=  $boleta;
                }
                $dia = date("N", strtotime($fecha));

                $nombreDia = $diasDeLaSemana[$dia - 1];


                // $sheet->setCellValue('A'.$row, $datos['trabajador_nombre']);    
                $sheet->setCellValue('A' . $row, $nombreDia);

                if ($nombreDia == 'sáb.' || $nombreDia == 'dom.') {
                    $sheet->getStyle('A' . $row . ':Q' . $row)->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('FFD3D3D3'); // Color gris claro
                    $sheet->getStyle('E' . $row)->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('FFFFFFFF'); // Color gris claro
                }

                $sheet->setCellValue('B' . $row, $fecha);
                $sheet->setCellValue('C' . $row, $datos['entrada']);
                $sheet->setCellValue('D' . $row, $datos['salida']);
                $sheet->setCellValue('F' . $row, $datos['reloj_1']);
                $sheet->setCellValue('G' . $row, $datos['reloj_2']);
                $sheet->setCellValue('H' . $row, $datos['reloj_3']);
                $sheet->setCellValue('I' . $row, $datos['reloj_4']);
                $sheet->setCellValue('J' . $row, $datos['reloj_5']);
                $sheet->setCellValue('K' . $row, $datos['reloj_6']);
                $sheet->setCellValue('L' . $row, $datos['reloj_7']);
                $sheet->setCellValue('M' . $row, $datos['reloj_8']);
                $sheet->setCellValue('N' . $row, $datos['total']);
                $sheet->setCellValue('O' . $row, $datos['total_reloj']);
                $sheet->setCellValueExplicit('P' . $row, $Observacion, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                $sheet->setCellValue('Q' . $row, $justificacion);
                $row++;
            }
            foreach (range('A', 'Q') as $columnID) {
                $sheet->getColumnDimension($columnID)->setAutoSize(false);
            }
            $sheet->mergeCells('E7:E' . ($row - 1));

            $total_horas = floor($total / 3600); // Obtener las horas completas
            $total_minutos = floor(($total % 3600) / 60); // Obtener los minutos restantes
            if ($total_minutos == 0) {
                $total_minutos = '00';
            }
            $total = "$total_horas:$total_minutos";

            $total_real_horas = floor($total_real / 3600); // Obtener las horas completas
            $total_real_minutos = floor(($total_real % 3600) / 60); // Obtener los minutos restantes
            if ($total_real_minutos == 0) {
                $total_real_minutos = '00';
            }
            $total_real = "$total_real_horas:$total_real_minutos";

            // $sheet->mergeCells('A2:Q2');
            $sheet->mergeCells('A' . $row . ':Q' . $row);
            $row++;


            $sheet->mergeCells('A' . $row . ':O' . $row);
            $sheet->setCellValue('A' . $row, 'Total Horas:');
            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('P' . $row, $total);
            $sheet->setCellValue('Q' . $row, $total_real);
            // BORDE
            $sheet->getStyle('A1:Q' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

            $row++;
            // $sheet->mergeCells('A'. $row.':Q'. $row);
            // QUITAR POR MIENTRAS
            // $row++;
            // $sheet->mergeCells('A' . $row . ':E' . $row);
            // $sheet->setCellValue('A' . $row, 'Licencia por Enfermedad:');
            // $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal('right');
            // $sheet->setCellValue('F' . $row, $Cantidad_licencia);

            // $row++;
            // $sheet->mergeCells('A' . $row . ':E' . $row);
            // $sheet->setCellValue('A' . $row, 'Tardanzas:');
            // $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal('right');
            // $sheet->setCellValue('F' . $row, $tardanza);

            // $row++;
            // $sheet->mergeCells('A' . $row . ':E' . $row);
            // $sheet->setCellValue('A' . $row, 'Inasistencias:');
            // $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal('right');
            // $sheet->setCellValue('F' . $row, $inasistencia);
            // $sheet->getStyle('A' . ($row - 2) . ':F' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

            $sheet->getStyle('A7:Q' . $row)->getAlignment()->setHorizontal('center');
            $sheet->getStyle('A7:Q' . $row)->getFont()->setSize(11);
            $sheet->getStyle('A1:Q' . $row)->getFont()->setName('Arial');

            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(12);
            $sheet->getColumnDimension('C')->setWidth(8);
            $sheet->getColumnDimension('D')->setWidth(8);
            $sheet->getColumnDimension('E')->setWidth(1.4);
            $sheet->getColumnDimension('F')->setWidth(6);
            $sheet->getColumnDimension('G')->setWidth(6);
            $sheet->getColumnDimension('H')->setWidth(6);
            $sheet->getColumnDimension('I')->setWidth(6);
            $sheet->getColumnDimension('J')->setWidth(6);
            $sheet->getColumnDimension('K')->setWidth(6);
            $sheet->getColumnDimension('L')->setWidth(6);
            $sheet->getColumnDimension('M')->setWidth(6);
            $sheet->getColumnDimension('N')->setWidth(6);
            $sheet->getColumnDimension('O')->setWidth(9.57);
            $sheet->getColumnDimension('P')->setWidth(18.40);
            $sheet->getColumnDimension('Q')->setWidth(17);

            $nombre = str_replace(' ', '_', $nombre);

            $nombreArchivo = "Reporte_" . $nombreMes . "_$nombre.xlsx";
            $fileName = "Reporte_" . $nombreMes . "_$nombre.xlsx";

            // Crear un escritor para guardar el archivo
            $writer = new Xlsx($spread);

            // Especificar la ruta donde guardar el archivo
            $filePath = './Uploads/Reportes/' . $fileName;

            // Guardar el archivo
            $writer->save($filePath);
        }
        if ($data == 0) {
            $mensaje = "valor Vacio para Trabajador $trabajador Mes $mes año $anio";
        } else {

            for ($i = 0; $i < count($data); $i++) {
                // $datos[$i] = $data[$i];
                // $datos[$i] = $data[$i]['trabajador_nombre'];
                $cantidad++;
            }
        }
        return ['filepath' => $filePath, 'nombreArchivo' => $nombreArchivo, 'mensaje' => $mensaje];
    }
    // ANTIGUO
    public function exportarDetallado3($trabajador, $mes, $anio)
    {
        $mensaje = '';
        $cantidad = 0;
        $reporte = 0;
        $filePath = '';
        $fileName = '';
        $nombreArchivo = '';

        $nombre_mes = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $diasDeLaSemana = ['lun.', 'mar.', 'mié.', 'jue.', 'vie.', 'sáb.', 'dom.'];

        $nombreMes = $nombre_mes[$mes - 1];
        $reporte++;
        $cantidad++;
        $nombre = '';

        $total = 0;
        $total_real = 0;

        $data = $this->model->Reporte_Trabajador($trabajador, $mes, $anio);

        if ($data > 0) {
            // DATOS DEL TRABAJADOR
            $datos_trabajador = $this->model->getTrabajador($trabajador, $mes, $anio);

            date_default_timezone_set("America/Lima");
            setlocale(LC_TIME, 'es_PE.UTF-8', 'esp');
            $fecha_boletas = [];
            $fecha_actual = date('d-m-Y');
            $hora_actual = date('H:i:s');

            $inasistencia = 0;
            $tardanza = 0;
            $Cantidad_licencia = 0;
            $horario_entrada = '';
            $horario_salida = '';
            $boleta = '';


            if ($datos_trabajador > 0) {
                foreach ($datos_trabajador as $datos) {

                    $nombre = $datos['trabajador_nombre'];
                    $fecha_str = date('d-m-Y', strtotime($datos['fecha']));
                    array_push($fecha_boletas, $fecha_str);
                    $Cantidad_licencia += intval($datos['total_motivos_particulares']);
                    $horario_entrada = $datos['horario_entrada'];
                    $horario_salida = $datos['horario_salida'];
                }
                $spread = new Spreadsheet();
                $sheet = $spread->getActiveSheet();

                $sheet->setCellValue('A1', 'CÁLCULO DE HORAS ' . strtoupper($nombreMes) . ' del ' . $anio);
                $sheet->mergeCells('A1:Q1');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(18);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

                $sheet->mergeCells('A2:Q2');

                $sheet->setCellValue('A3', 'Nombre:');
                $sheet->mergeCells('A3:C3');
                $sheet->getStyle('A3')->getFont()->setBold(true)->setSize(10);
                $sheet->getStyle('A3')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ff424242'); // Cambia 'FFFF0000' al color deseado
                $sheet->getStyle('A3')->getFont()->getColor()->setARGB(Color::COLOR_WHITE);

                $sheet->setCellValue('D3', $nombre);
                $sheet->mergeCells('D3:I3');
                $sheet->getStyle('D3')->getFont()->setBold(true)->setSize(10);
                $sheet->getStyle('D3')->getAlignment()->setHorizontal('center');


                $sheet->setCellValue('A4', 'Hora de Reporte:');
                $sheet->mergeCells('A4:C4');
                $sheet->getStyle('A4')->getFont()->setBold(true)->setSize(10);
                $sheet->getStyle('A4')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ff424242'); // Cambia 'FFFF0000' al color deseado
                $sheet->getStyle('A4')->getFont()->getColor()->setARGB(Color::COLOR_WHITE);

                $sheet->setCellValue('D4', "$hora_actual - $fecha_actual");
                $sheet->mergeCells('D4:I4');
                $sheet->getStyle('D4')->getFont()->setBold(true)->setSize(10);
                $sheet->getStyle('D4')->getAlignment()->setHorizontal('center');

                $sheet->setCellValue('A5', 'Horario:');
                $sheet->mergeCells('A5:C5');
                $sheet->getStyle('A5')->getFont()->setBold(true)->setSize(10);
                $sheet->getStyle('A5')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A5')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ff424242'); // Cambia 'FFFF0000' al color deseado
                $sheet->getStyle('A5')->getFont()->getColor()->setARGB(Color::COLOR_WHITE);

                $sheet->setCellValue('D5', "$horario_entrada - $horario_salida");
                $sheet->mergeCells('D5:I5');
                $sheet->getStyle('D5')->getFont()->setBold(true)->setSize(10);
                $sheet->getStyle('D5')->getAlignment()->setHorizontal('center');

                $sheet->mergeCells('A6:Q6');
                $sheet->mergeCells('J3:Q5');

                $headers = ['Día', 'Fecha', 'Entrada', 'Salida', '', 'R1', 'R2', 'R3', 'R4', 'R5', 'R6', 'R7', 'R8', 'Total', 'Total Real', 'Observación', 'Justificacion'];
                $sheet->fromArray($headers, NULL, 'A7');
                $sheet->getStyle('A7:Q7')->getFont()->setBold(true);
                $sheet->getStyle('A7:Q7')->getFont()->getColor()->setARGB(Color::COLOR_WHITE);
                $sheet->getStyle('A7:Q7')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ff5dade2');
                $sheet->getStyle('E7')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ffffffff');

                $row = 8; // Comienza en la fila 7
                foreach ($data as $datos) {
                    $boleta = '';
                    $Observacion = '';
                    if ($datos['licencia'] == 'NMS') {
                        $Observacion = "No marco Salida";
                    }
                    if ($datos['licencia'] == 'FERIADO') {
                        $Observacion = "Feriado";
                    }
                    if ($datos['licencia'] == 'COMPENSABLE') {
                        $Observacion = "F. compensable";
                    }
                    if ($datos['licencia'] == 'NME') {
                        $Observacion = "No marco entrada";
                    }
                    if ($datos['licencia'] == '+30') {
                        $Observacion = "+30";
                    }
                    $inasistencia += intval($datos['inasistencia']);
                    $tardanza += intval($datos['tardanza_cantidad']);

                    list($horas, $minutos) = explode(':', $datos['total']);
                    $segundos = ($horas * 3600) + ($minutos * 60);
                    $total += $segundos;

                    list($horas, $minutos) = explode(':', $datos['total_reloj']);
                    $segundos = ($horas * 3600) + ($minutos * 60);
                    $total_real += $segundos;

                    $fecha  = $datos['fecha'];
                    $fecha = date('d-m-Y', strtotime($fecha));
                    $justificacion = '';
                    if (in_array($fecha, $fecha_boletas)) {
                        $boleta = 'boleta';
                    }
                    if (strlen($datos['justificacion']) > 1) {
                        $justificacion .= $datos['justificacion'] . " ";
                    }
                    if (strlen($boleta) > 1) {
                        $justificacion .=  $boleta;
                    }
                    $dia = date("N", strtotime($fecha));

                    $nombreDia = $diasDeLaSemana[$dia - 1];


                    // $sheet->setCellValue('A'.$row, $datos['trabajador_nombre']);    
                    $sheet->setCellValue('A' . $row, $nombreDia);

                    if ($nombreDia == 'sáb.' || $nombreDia == 'dom.') {
                        $sheet->getStyle('A' . $row . ':Q' . $row)->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('FFD3D3D3'); // Color gris claro
                        $sheet->getStyle('E' . $row)->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('FFFFFFFF'); // Color gris claro
                    }

                    $sheet->setCellValue('B' . $row, $fecha);
                    $sheet->setCellValue('C' . $row, $datos['entrada']);
                    $sheet->setCellValue('D' . $row, $datos['salida']);
                    $sheet->setCellValue('F' . $row, $datos['reloj_1']);
                    $sheet->setCellValue('G' . $row, $datos['reloj_2']);
                    $sheet->setCellValue('H' . $row, $datos['reloj_3']);
                    $sheet->setCellValue('I' . $row, $datos['reloj_4']);
                    $sheet->setCellValue('J' . $row, $datos['reloj_5']);
                    $sheet->setCellValue('K' . $row, $datos['reloj_6']);
                    $sheet->setCellValue('L' . $row, $datos['reloj_7']);
                    $sheet->setCellValue('M' . $row, $datos['reloj_8']);
                    $sheet->setCellValue('N' . $row, $datos['total']);
                    $sheet->setCellValue('O' . $row, $datos['total_reloj']);
                    $sheet->setCellValueExplicit('P' . $row, $Observacion, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    $sheet->setCellValue('Q' . $row, $justificacion);
                    $row++;
                }
                foreach (range('A', 'Q') as $columnID) {
                    $sheet->getColumnDimension($columnID)->setAutoSize(false);
                }
                $sheet->mergeCells('E7:E' . ($row - 1));

                $total_horas = floor($total / 3600); // Obtener las horas completas
                $total_minutos = floor(($total % 3600) / 60); // Obtener los minutos restantes
                if ($total_minutos == 0) {
                    $total_minutos = '00';
                }
                $total = "$total_horas:$total_minutos";

                $total_real_horas = floor($total_real / 3600); // Obtener las horas completas
                $total_real_minutos = floor(($total_real % 3600) / 60); // Obtener los minutos restantes
                if ($total_real_minutos == 0) {
                    $total_real_minutos = '00';
                }
                $total_real = "$total_real_horas:$total_real_minutos";

                // $sheet->mergeCells('A2:Q2');
                $sheet->mergeCells('A' . $row . ':Q' . $row);
                $row++;


                $sheet->mergeCells('A' . $row . ':O' . $row);
                $sheet->setCellValue('A' . $row, 'Total Horas:');
                $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal('center');
                $sheet->setCellValue('P' . $row, $total);
                $sheet->setCellValue('Q' . $row, $total_real);
                // BORDE
                $sheet->getStyle('A1:Q' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                $row++;
                // $sheet->mergeCells('A'. $row.':Q'. $row);
                // QUITAR POR MIENTRAS
                // $row++;
                // $sheet->mergeCells('A' . $row . ':E' . $row);
                // $sheet->setCellValue('A' . $row, 'Licencia por Enfermedad:');
                // $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal('right');
                // $sheet->setCellValue('F' . $row, $Cantidad_licencia);

                // $row++;
                // $sheet->mergeCells('A' . $row . ':E' . $row);
                // $sheet->setCellValue('A' . $row, 'Tardanzas:');
                // $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal('right');
                // $sheet->setCellValue('F' . $row, $tardanza);

                // $row++;
                // $sheet->mergeCells('A' . $row . ':E' . $row);
                // $sheet->setCellValue('A' . $row, 'Inasistencias:');
                // $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal('right');
                // $sheet->setCellValue('F' . $row, $inasistencia);
                // $sheet->getStyle('A' . ($row - 2) . ':F' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                $sheet->getStyle('A7:Q' . $row)->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A7:Q' . $row)->getFont()->setSize(11);
                $sheet->getStyle('A1:Q' . $row)->getFont()->setName('Arial');

                $sheet->getColumnDimension('A')->setWidth(5);
                $sheet->getColumnDimension('B')->setWidth(12);
                $sheet->getColumnDimension('C')->setWidth(8);
                $sheet->getColumnDimension('D')->setWidth(8);
                $sheet->getColumnDimension('E')->setWidth(1.4);
                $sheet->getColumnDimension('F')->setWidth(6);
                $sheet->getColumnDimension('G')->setWidth(6);
                $sheet->getColumnDimension('H')->setWidth(6);
                $sheet->getColumnDimension('I')->setWidth(6);
                $sheet->getColumnDimension('J')->setWidth(6);
                $sheet->getColumnDimension('K')->setWidth(6);
                $sheet->getColumnDimension('L')->setWidth(6);
                $sheet->getColumnDimension('M')->setWidth(6);
                $sheet->getColumnDimension('N')->setWidth(6);
                $sheet->getColumnDimension('O')->setWidth(9.57);
                $sheet->getColumnDimension('P')->setWidth(18.40);
                $sheet->getColumnDimension('Q')->setWidth(17);

                $nombre = str_replace(' ', '_', $nombre);

                $nombreArchivo = "Reporte_" . $nombreMes . "_$nombre.xlsx";
                $fileName = "Reporte_" . $nombreMes . "_$nombre.xlsx";

                // Crear un escritor para guardar el archivo
                $writer = new Xlsx($spread);

                // Especificar la ruta donde guardar el archivo
                $filePath = './Uploads/Reportes/' . $fileName;

                // Guardar el archivo
                $writer->save($filePath);
            }
        }
        if ($data == 0) {
            $mensaje = "valor Vacio para Trabajador $trabajador Mes $mes año $anio";
        } else {

            for ($i = 0; $i < count($data); $i++) {
                // $datos[$i] = $data[$i];
                // $datos[$i] = $data[$i]['trabajador_nombre'];
                $cantidad++;
            }
        }
        return ['filepath' => $filePath, 'nombreArchivo' => $nombreArchivo, 'mensaje' => $mensaje];

    }
    // FUNCIONA MULTI USO
    public function exportarDetallado($trabajador, $mes, $anio){
        $mensaje = '';
        $cantidad = 0;
        $reporte = 0;
        $filePath = '';
        $fileName = '';
        $nuevo_nombre = "";
        $nombreArchivo = '';

        $nombre_mes = [
            'Enero',
            'Febrero',
            'Marzo',
            'Abril',
            'Mayo',
            'Junio',
            'Julio',
            'Agosto',
            'Setiembre',
            'Octubre',
            'Noviembre',
            'Diciembre'

        ];
        $diasDeLaSemana = [
            'lun.',
            'mar.',
            'mié.',
            'jue.',
            'vie.',
            'sáb.',
            'dom.'
        ];

        $nombreMes = $nombre_mes[$mes - 1];
        $reporte++;
        $cantidad++;
        $nombre = '';

        $total = 0;
        $total_real = 0;

        $data = $this->model->Reporte_Trabajador($trabajador, $mes, $anio);

        if ($data > 0) {
            $datos_trabajador = $this->model->getTrabajador($trabajador, $mes, $anio);

            date_default_timezone_set("America/Lima");
            setlocale(LC_TIME, 'es_PE.UTF-8', 'esp');
            $fecha_boletas = [];
            $fecha_actual = date('d-m-Y');
            $hora_actual = date('H:i:s');

            $inasistencia = 0;
            $tardanza = 0;
            $Cantidad_licencia = 0;
            $horario_entrada = '';
            $horario_salida = '';
            $boleta = '';


            if ($datos_trabajador > 0) {
                foreach ($datos_trabajador as $datos) {

                    $nombre = $datos['trabajador_nombre'];
                    $fecha_str = date('d-m-Y', strtotime($datos['fecha']));
                    array_push($fecha_boletas, $fecha_str);
                    $Cantidad_licencia += intval($datos['total_motivos_particulares']);
                    $horario_entrada = $datos['horario_entrada'];
                    $horario_salida = $datos['horario_salida'];
                }
                $spread = new Spreadsheet();
                $sheet = $spread->getActiveSheet();

                $sheet->setCellValue('A1', 'CÁLCULO DE HORAS ' . strtoupper($nombreMes) . ' del ' . $anio);
                $sheet->mergeCells('A1:Q1');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(18);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

                $sheet->mergeCells('A2:Q2');

                $sheet->setCellValue('A3', 'Nombre:');
                $sheet->mergeCells('A3:C3');
                $sheet->getStyle('A3')->getFont()->setBold(true)->setSize(10);
                $sheet->getStyle('A3')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ff424242'); // Cambia 'FFFF0000' al color deseado
                $sheet->getStyle('A3')->getFont()->getColor()->setARGB(Color::COLOR_WHITE);

                $sheet->setCellValue('D3', $nombre);
                $sheet->mergeCells('D3:I3');
                $sheet->getStyle('D3')->getFont()->setBold(true)->setSize(10);
                $sheet->getStyle('D3')->getAlignment()->setHorizontal('center');


                $sheet->setCellValue('A4', 'Hora de Reporte:');
                $sheet->mergeCells('A4:C4');
                $sheet->getStyle('A4')->getFont()->setBold(true)->setSize(10);
                $sheet->getStyle('A4')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ff424242'); // Cambia 'FFFF0000' al color deseado
                $sheet->getStyle('A4')->getFont()->getColor()->setARGB(Color::COLOR_WHITE);

                $sheet->setCellValue('D4', "$hora_actual - $fecha_actual");
                $sheet->mergeCells('D4:I4');
                $sheet->getStyle('D4')->getFont()->setBold(true)->setSize(10);
                $sheet->getStyle('D4')->getAlignment()->setHorizontal('center');

                $sheet->setCellValue('A5', 'Horario:');
                $sheet->mergeCells('A5:C5');
                $sheet->getStyle('A5')->getFont()->setBold(true)->setSize(10);
                $sheet->getStyle('A5')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A5')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ff424242'); // Cambia 'FFFF0000' al color deseado
                $sheet->getStyle('A5')->getFont()->getColor()->setARGB(Color::COLOR_WHITE);

                $sheet->setCellValue('D5', "$horario_entrada - $horario_salida");
                $sheet->mergeCells('D5:I5');
                $sheet->getStyle('D5')->getFont()->setBold(true)->setSize(10);
                $sheet->getStyle('D5')->getAlignment()->setHorizontal('center');

                $sheet->mergeCells('A6:Q6');
                $sheet->mergeCells('J3:Q5');

                $headers = ['Día', 'Fecha', 'Entrada', 'Salida', '', 'R1', 'R2', 'R3', 'R4', 'R5', 'R6', 'R7', 'R8', 'Total', 'Total Real', 'Observación', 'Justificacion'];
                $sheet->fromArray($headers, NULL, 'A7');
                $sheet->getStyle('A7:Q7')->getFont()->setBold(true);
                $sheet->getStyle('A7:Q7')->getFont()->getColor()->setARGB(Color::COLOR_WHITE);
                $sheet->getStyle('A7:Q7')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ff5dade2');
                $sheet->getStyle('E7')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ffffffff');

                $row = 8; // Comienza en la fila 7
                foreach ($data as $datos) {
                    $boleta = '';
                    $Observacion = '';
                    if ($datos['licencia'] == 'NMS') {
                        $Observacion = "No marco Salida";
                    }
                    $inasistencia += intval($datos['inasistencia']);
                    $tardanza += intval($datos['tardanza_cantidad']);

                    list($horas, $minutos) = explode(':', $datos['total']);
                    $segundos = ($horas * 3600) + ($minutos * 60);
                    $total += $segundos;

                    list($horas, $minutos) = explode(':', $datos['total_reloj']);
                    $segundos = ($horas * 3600) + ($minutos * 60);
                    $total_real += $segundos;

                    $fecha  = $datos['fecha'];
                    $fecha = date('d-m-Y', strtotime($fecha));
                    $justificacion = '';
                    if (in_array($fecha, $fecha_boletas)) {
                        $boleta = 'boleta'; // Asigna la fecha a $boleta si coincide
                    }
                    if (strlen($datos['justificacion']) > 1) {
                        $justificacion .= $datos['justificacion'] . " ";
                    }
                    if (strlen($boleta) > 1) {
                        $justificacion .=  $boleta;
                    }
                    $dia = date("N", strtotime($fecha));

                    $nombreDia = $diasDeLaSemana[$dia - 1];


                    // $sheet->setCellValue('A'.$row, $datos['trabajador_nombre']);    
                    $sheet->setCellValue('A' . $row, $nombreDia);
                    $sheet->setCellValue('B' . $row, $fecha);
                    $sheet->setCellValue('C' . $row, $datos['entrada']);
                    $sheet->setCellValue('D' . $row, $datos['salida']);
                    $sheet->setCellValue('F' . $row, $datos['reloj_1']);
                    $sheet->setCellValue('G' . $row, $datos['reloj_2']);
                    $sheet->setCellValue('H' . $row, $datos['reloj_3']);
                    $sheet->setCellValue('I' . $row, $datos['reloj_4']);
                    $sheet->setCellValue('J' . $row, $datos['reloj_5']);
                    $sheet->setCellValue('K' . $row, $datos['reloj_6']);
                    $sheet->setCellValue('L' . $row, $datos['reloj_7']);
                    $sheet->setCellValue('M' . $row, $datos['reloj_8']);
                    $sheet->setCellValue('N' . $row, $datos['total']);
                    $sheet->setCellValue('O' . $row, $datos['total_reloj']);
                    $sheet->setCellValue('P' . $row, $Observacion);
                    $sheet->setCellValue('Q' . $row, $justificacion);
                    $row++;
                }
                foreach (range('A', 'Q') as $columnID) {
                    $sheet->getColumnDimension($columnID)->setAutoSize(false);
                }
                $sheet->mergeCells('E7:E' . ($row - 1));

                $total_horas = floor($total / 3600); // Obtener las horas completas
                $total_minutos = floor(($total % 3600) / 60); // Obtener los minutos restantes
                if ($total_minutos == 0) {
                    $total_minutos = '00';
                }
                $total = "$total_horas:$total_minutos";

                $total_real_horas = floor($total_real / 3600); // Obtener las horas completas
                $total_real_minutos = floor(($total_real % 3600) / 60); // Obtener los minutos restantes
                if ($total_real_minutos == 0) {
                    $total_real_minutos = '00';
                }
                $total_real = "$total_real_horas:$total_real_minutos";

                // $sheet->mergeCells('A2:Q2');
                $sheet->mergeCells('A' . $row . ':Q' . $row);
                $row++;


                $sheet->mergeCells('A' . $row . ':O' . $row);
                $sheet->setCellValue('A' . $row, 'Total Horas:');
                $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal('center');
                $sheet->setCellValue('P' . $row, $total);
                $sheet->setCellValue('Q' . $row, $total_real);
                $sheet->getStyle('A1:Q' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                $row++;
                // $sheet->mergeCells('A'. $row.':Q'. $row);
                $row++;
                $sheet->mergeCells('A' . $row . ':E' . $row);
                $sheet->setCellValue('A' . $row, 'Licencia por Enfermedad:');
                $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal('right');
                $sheet->setCellValue('F' . $row, $Cantidad_licencia);

                $row++;
                $sheet->mergeCells('A' . $row . ':E' . $row);
                $sheet->setCellValue('A' . $row, 'Tardanzas:');
                $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal('right');
                $sheet->setCellValue('F' . $row, $tardanza);

                $row++;
                $sheet->mergeCells('A' . $row . ':E' . $row);
                $sheet->setCellValue('A' . $row, 'Inasistencias:');
                $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal('right');
                $sheet->setCellValue('F' . $row, $inasistencia);

                $sheet->getStyle('A7:Q' . $row)->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A7:Q' . $row)->getFont()->setSize(11);

                $sheet->getStyle('A1:Q' . $row)->getFont()->setName('Arial');
                $sheet->getStyle('A' . ($row - 2) . ':F' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                $sheet->getColumnDimension('A')->setWidth(5);
                $sheet->getColumnDimension('B')->setWidth(12);
                $sheet->getColumnDimension('C')->setWidth(6);
                $sheet->getColumnDimension('D')->setWidth(6);
                $sheet->getColumnDimension('E')->setWidth(1.4);
                $sheet->getColumnDimension('F')->setWidth(6);
                $sheet->getColumnDimension('G')->setWidth(6);
                $sheet->getColumnDimension('H')->setWidth(6);
                $sheet->getColumnDimension('I')->setWidth(6);
                $sheet->getColumnDimension('J')->setWidth(6);
                $sheet->getColumnDimension('K')->setWidth(6);
                $sheet->getColumnDimension('L')->setWidth(6);
                $sheet->getColumnDimension('M')->setWidth(6);
                $sheet->getColumnDimension('N')->setWidth(6);
                $sheet->getColumnDimension('O')->setWidth(17.71);
                $sheet->getColumnDimension('P')->setWidth(18.40);
                $sheet->getColumnDimension('Q')->setWidth(17);

                $nombre = str_replace(' ', '_', $nombre);

                $nombreArchivo = "Reporte_" . $nombreMes . "_$nombre.xlsx";
                $fileName = "Reporte_" . $nombreMes . "_$nombre.xlsx";

                // Crear un escritor para guardar el archivo
                $writer = new Xlsx($spread);

                // Especificar la ruta donde guardar el archivo
                $filePath = './Uploads/Reportes/' . $fileName;

                // Guardar el archivo
                $writer->save($filePath);
            }
        }
        if ($data == 0) {
            $mensaje = "valor Vacio para Trabajador $trabajador Mes $mes año $anio";
        } else {

            for ($i = 0; $i < count($data); $i++) {
                // $datos[$i] = $data[$i];
                // $datos[$i] = $data[$i]['trabajador_nombre'];
                $cantidad++;
            }
        }
        return ['filepath' => $filePath, 'nombreArchivo' => $nombreArchivo, 'mensaje' => $mensaje];
    }


    public function exportarGeneralLicencia($mes, $anio)
    {
        $mensaje = '';
        $cantidad = 0;
        $reporte = 0;
        $filePath = '';
        $fileName = '';
        $nuevo_nombre = "";
        $nombreArchivo = '';

        $nombre_mes = [
            'Enero',
            'Febrero',
            'Marzo',
            'Abril',
            'Mayo',
            'Junio',
            'Julio',
            'Agosto',
            'Setiembre',
            'Octubre',
            'Noviembre',
            'Diciembre'

        ];
        $diasDeLaSemana = [
            'lun.',
            'mar.',
            'mié.',
            'jue.',
            'vie.',
            'sáb.',
            'dom.'
        ];

        $nombreMes = $nombre_mes[$mes - 1];

        $cantidad++;
        $nombre = '';

        $total = 0;
        $total_real = 0;

        $data = $this->model->reporteGeneralLicencia($mes, $anio);
        // if (empty($data)) {
        //     $mensaje = "valor Vacio  Mes $mes año $anio";
        // }
        // if ($data) {
        date_default_timezone_set("America/Lima");
        setlocale(LC_TIME, 'es_PE.UTF-8', 'esp');

        $fecha_actual = date('d-m-Y');
        $hora_actual = date('H:i:s');

        $spread = new Spreadsheet();
        $sheet = $spread->getActiveSheet();

        $sheet->setCellValue('A1', 'Reporte de Trabajadores ' . strtoupper($nombreMes) . ' del ' . $anio);
        $sheet->mergeCells('A1:Q1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(18);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

        $sheet->mergeCells('A2:Q2');

        // $sheet->setCellValue('A3', 'Nombre:');
        // $sheet->mergeCells('A3:C3');
        // $sheet->getStyle('A3')->getFont()->setBold(true)->setSize(10);
        // $sheet->getStyle('A3')->getAlignment()->setHorizontal('center');
        // $sheet->getStyle('A3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ff424242'); // Cambia 'FFFF0000' al color deseado
        // $sheet->getStyle('A3')->getFont()->getColor()->setARGB(Color::COLOR_WHITE);

        // $sheet->setCellValue('D3', $nombre);
        // $sheet->mergeCells('D3:I3');
        // $sheet->getStyle('D3')->getFont()->setBold(true)->setSize(10);
        // $sheet->getStyle('D3')->getAlignment()->setHorizontal('center');


        $sheet->setCellValue('A4', 'Hora de Reporte:');
        $sheet->mergeCells('A4:C4');
        $sheet->getStyle('A4')->getFont()->setBold(true)->setSize(10);
        $sheet->getStyle('A4')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ff424242'); // Cambia 'FFFF0000' al color deseado
        $sheet->getStyle('A4')->getFont()->getColor()->setARGB(Color::COLOR_WHITE);

        $sheet->mergeCells('A3:I3');
        $sheet->setCellValue('D4', "$hora_actual - $fecha_actual");
        $sheet->mergeCells('D4:I4');
        $sheet->getStyle('D4')->getFont()->setBold(true)->setSize(10);
        $sheet->getStyle('D4')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A5:I5');


        // $sheet->mergeCells('A6:AG6');
        $sheet->mergeCells('J3:AG5');

        $headers = ['Nombre', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'];
        $sheet->fromArray($headers, NULL, 'A6');
        $sheet->getStyle('A6:AG6')->getFont()->setBold(true);
        $sheet->getStyle('A6:AG6')->getFont()->getColor()->setARGB(Color::COLOR_WHITE);
        $sheet->getStyle('A6:AG6')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ff5dade2');
        // $sheet->getStyle('E7')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ffffffff');

        $row = 7; // Comienza en la fila 7

        if (!empty($data)) {
            foreach ($data as $registro) {
                $nombre = $registro['trabajador_nombre'];
                $detalle = $registro['detalles'];


                // Dividir los detalles por espacio para obtener cada día
                $detalles_separados = explode(' ', $detalle);

                $dias = [];

                foreach ($detalles_separados as $detalle) {
                    // Separar cada detalle por '_'
                    $detalle_partes = explode('_', $detalle);

                    if (count($detalle_partes) >= 2) {
                        $fecha_completa = $detalle_partes[0];
                        if ($detalle_partes[1] == 'HONOMASTICO') {
                            $detalle_partes[1] = 'HO';
                        }
                        if ($detalle_partes[1] == 'FERIADO') {
                            $detalle_partes[1] = 'FE';
                        }
                        $licencia = $detalle_partes[1];

                        // Formatear la fecha
                        $fecha_partes = explode('-', $fecha_completa);
                        if (count($fecha_partes) == 3) {
                            $dia = (int)$fecha_partes[2]; // Obtener el día como entero

                            // Crear el índice del día
                            $indice_dia = sprintf("%02d", $dia);

                            // Asignar la licencia al array de días
                            $dias[$indice_dia] = $licencia;
                        }
                    }
                }
                $sheet->setCellValue('A' . $row, $nombre);
                for ($i = 1; $i <= 31; $i++) {
                    $columna = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i + 1); // Usar la función correcta para obtener la letra de la columna
                    $indice_dia = sprintf("%02d", $i);
                    if (isset($dias[$indice_dia])) {
                        $sheet->setCellValue($columna . $row, $dias[$indice_dia]);
                    }
                }


                // for ($i = 1; $i <= 31; $i++) {
                //     $columna = chr(65 + $i); // 'B' para el día 01, 'C' para el día 02, etc.
                //     $indice_dia = sprintf("%02d", $i);
                //     if (isset($dias[$indice_dia])) {
                //         $sheet->setCellValue($columna . $row, $dias[$indice_dia]);
                //     }
                // }
                $row++;
            }
        }


        foreach (range('A', 'AG') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(false);
        }

        // $sheet->mergeCells('E7:E' . ($row - 1));
        // $sheet->mergeCells('A' . $row . ':Q' . $row);
        $row++;

        $sheet->getStyle('A6:AG' . $row)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A7:A' . $row)->getAlignment()->setHorizontal('left');
        $sheet->getStyle('A6:AG' . $row)->getFont()->setSize(11);

        $sheet->getStyle('A1:AG' . $row)->getFont()->setName('Arial');
        // $sheet->getStyle('A' . ($row - 2) . ':F' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // $sheet->getColumnDimension('A')->setWidth(35);
        // $sheet->getColumnDimension('B')->setWidth(6);
        // $sheet->getColumnDimension('C')->setWidth(6);
        // $sheet->getColumnDimension('D')->setWidth(6);
        // $sheet->getColumnDimension('E')->setWidth(6);
        // $sheet->getColumnDimension('F')->setWidth(6);
        // $sheet->getColumnDimension('G')->setWidth(6);
        // $sheet->getColumnDimension('H')->setWidth(6);
        // $sheet->getColumnDimension('I')->setWidth(6);
        // $sheet->getColumnDimension('J')->setWidth(6);
        // $sheet->getColumnDimension('K')->setWidth(6);
        // $sheet->getColumnDimension('L')->setWidth(6);
        // $sheet->getColumnDimension('M')->setWidth(6);
        // $sheet->getColumnDimension('N')->setWidth(6);
        // $sheet->getColumnDimension('O')->setWidth(6);
        // $sheet->getColumnDimension('P')->setWidth(6);
        // $sheet->getColumnDimension('Q')->setWidth(6);
        // $sheet->getColumnDimension('R')->setWidth(6);
        // $sheet->getColumnDimension('S')->setWidth(6);
        // $sheet->getColumnDimension('T')->setWidth(6);
        // $sheet->getColumnDimension('U')->setWidth(6);
        // $sheet->getColumnDimension('V')->setWidth(6);
        // $sheet->getColumnDimension('W')->setWidth(6);
        // $sheet->getColumnDimension('X')->setWidth(6);
        // $sheet->getColumnDimension('Y')->setWidth(6);
        // $sheet->getColumnDimension('Z')->setWidth(6);
        // $sheet->getColumnDimension('AA')->setWidth(6);
        // $sheet->getColumnDimension('AB')->setWidth(6);
        // $sheet->getColumnDimension('AC')->setWidth(6);
        // $sheet->getColumnDimension('AD')->setWidth(6);
        // $sheet->getColumnDimension('AE')->setWidth(6);
        // $sheet->getColumnDimension('AF')->setWidth(6);
        // $sheet->getColumnDimension('AG')->setWidth(6);
        foreach (range('A', 'AG') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        foreach (range('A', 'AG') as $columnID) {
            $currentWidth = $sheet->getColumnDimension($columnID)->getWidth();
            $extraWidth = 14; // Define el margen adicional que quieres agregar
            $sheet->getColumnDimension($columnID)->setWidth($currentWidth + $extraWidth);
        }

        // Ajustar la altura de las filas dinámicamente a partir de la fila 7
        $rowIterator = $sheet->getRowIterator(7); // Comienza desde la fila 7
        foreach ($rowIterator as $row) {
            $sheet->getRowDimension($row->getRowIndex())->setRowHeight(-1); // Ajusta automáticamente
        }
        $sheet->getColumnDimension('A')->setWidth(45);


        $nombreArchivo = "Reporte_General_Licencia_" . $anio . "_" . $nombreMes . ".xlsx";
        $fileName = $nombreArchivo;

        // Crear un escritor para guardar el archivo
        $writer = new Xlsx($spread);

        // Especificar la ruta donde guardar el archivo
        $filePath = './Uploads/Reportes/' . $fileName;

        // Guardar el archivo
        $writer->save($filePath);
        // }


        if ($data == 0) {
            $mensaje = "valor Vacio  Mes $mes año $anio";
        }

        return ['filepath' => $filePath, 'nombreArchivo' => $nombreArchivo, 'mensaje' => $mensaje];
    }

    public function exportarGeneralTardanza($mes, $anio)
    {
        $mensaje = '';
        $cantidad = 0;
        $reporte = 0;
        $filePath = '';
        $fileName = '';
        $nuevo_nombre = "";
        $nombreArchivo = '';

        $nombre_mes = [
            'Enero',
            'Febrero',
            'Marzo',
            'Abril',
            'Mayo',
            'Junio',
            'Julio',
            'Agosto',
            'Setiembre',
            'Octubre',
            'Noviembre',
            'Diciembre'

        ];
        $diasDeLaSemana = [
            'lun.',
            'mar.',
            'mié.',
            'jue.',
            'vie.',
            'sáb.',
            'dom.'
        ];

        $nombreMes = $nombre_mes[$mes - 1];

        $cantidad++;
        $nombre = '';

        $total = 0;
        $total_real = 0;

        $data = $this->model->reporteGeneralTardanza($mes, $anio);
        // if (empty($data)) {
        //     $mensaje = "valor Vacio  Mes $mes año $anio";
        // }
        // if ($data) {
        date_default_timezone_set("America/Lima");
        setlocale(LC_TIME, 'es_PE.UTF-8', 'esp');

        $fecha_actual = date('d-m-Y');
        $hora_actual = date('H:i:s');

        $spread = new Spreadsheet();
        $sheet = $spread->getActiveSheet();

        $sheet->setCellValue('A1', 'Reporte de Trabajadores ' . strtoupper($nombreMes) . ' del ' . $anio);
        $sheet->mergeCells('A1:Q1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(18);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

        $sheet->mergeCells('A2:Q2');

        // $sheet->setCellValue('A3', 'Nombre:');
        // $sheet->mergeCells('A3:C3');
        // $sheet->getStyle('A3')->getFont()->setBold(true)->setSize(10);
        // $sheet->getStyle('A3')->getAlignment()->setHorizontal('center');
        // $sheet->getStyle('A3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ff424242'); // Cambia 'FFFF0000' al color deseado
        // $sheet->getStyle('A3')->getFont()->getColor()->setARGB(Color::COLOR_WHITE);

        // $sheet->setCellValue('D3', $nombre);
        // $sheet->mergeCells('D3:I3');
        // $sheet->getStyle('D3')->getFont()->setBold(true)->setSize(10);
        // $sheet->getStyle('D3')->getAlignment()->setHorizontal('center');


        $sheet->setCellValue('A4', 'Hora de Reporte:');
        $sheet->mergeCells('A4:C4');
        $sheet->getStyle('A4')->getFont()->setBold(true)->setSize(10);
        $sheet->getStyle('A4')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ff424242'); // Cambia 'FFFF0000' al color deseado
        $sheet->getStyle('A4')->getFont()->getColor()->setARGB(Color::COLOR_WHITE);

        $sheet->mergeCells('A3:I3');
        $sheet->setCellValue('D4', "$hora_actual - $fecha_actual");
        $sheet->mergeCells('D4:I4');
        $sheet->getStyle('D4')->getFont()->setBold(true)->setSize(10);
        $sheet->getStyle('D4')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A5:I5');


        // $sheet->mergeCells('A6:AG6');
        $sheet->mergeCells('J3:AG5');

        $headers = ['Nombre', 'Total', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'];
        $sheet->fromArray($headers, NULL, 'A6');
        $sheet->getStyle('A6:AG6')->getFont()->setBold(true);
        $sheet->getStyle('A6:AG6')->getFont()->getColor()->setARGB(Color::COLOR_WHITE);
        $sheet->getStyle('A6:AG6')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ff5dade2');
        // $sheet->getStyle('E7')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('ffffffff');

        $row = 7; // Comienza en la fila 7
        // $envio []=[];
        if (!empty($data)) {
            foreach ($data as $registro) {
                $nombre = $registro['trabajador_nombre'];
                $tardanza = $registro['suma_tardanza'];
                $detalle = $registro['detalles'];
                // $envio []=$registro;


                // Dividir los detalles por espacio para obtener cada día
                $detalles_separados = explode(' ', $detalle);

                $dias = [];

                foreach ($detalles_separados as $detalle) {
                    // Separar cada detalle por '_'
                    $detalle_partes = explode('_', $detalle);

                    if (count($detalle_partes) >= 2) {
                        $fecha_completa = $detalle_partes[0];
                        if ($detalle_partes[1] == 'HONOMASTICO') {
                            $detalle_partes[1] = 'HO';
                        }
                        if ($detalle_partes[1] == 'FERIADO') {
                            $detalle_partes[1] = 'FE';
                        }
                        $licencia = $detalle_partes[1];

                        // Formatear la fecha
                        $fecha_partes = explode('-', $fecha_completa);
                        if (count($fecha_partes) == 3) {
                            $dia = (int)$fecha_partes[2]; // Obtener el día como entero

                            // Crear el índice del día
                            $indice_dia = sprintf("%02d", $dia);

                            // Asignar la licencia al array de días
                            $dias[$indice_dia] = $licencia;
                        }
                    }
                }
                $sheet->setCellValue('A' . $row, $nombre);
                $sheet->setCellValue('B' . $row, $tardanza);
                for ($i = 1; $i <= 31; $i++) {
                    $columna = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i + 2); // Usar la función correcta para obtener la letra de la columna
                    $indice_dia = sprintf("%02d", $i);                                            // este numero es la columna
                    if (isset($dias[$indice_dia])) {
                        $sheet->setCellValue($columna . $row, $dias[$indice_dia]);
                    }
                }


                // for ($i = 1; $i <= 31; $i++) {
                //     $columna = chr(65 + $i); // 'B' para el día 01, 'C' para el día 02, etc.
                //     $indice_dia = sprintf("%02d", $i);
                //     if (isset($dias[$indice_dia])) {
                //         $sheet->setCellValue($columna . $row, $dias[$indice_dia]);
                //     }
                // }
                $row++;
            }
        }


        foreach (range('A', 'AG') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(false);
        }

        // $sheet->mergeCells('E7:E' . ($row - 1));
        // $sheet->mergeCells('A' . $row . ':Q' . $row);
        $row++;

        $sheet->getStyle('A6:AG' . $row)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A7:A' . $row)->getAlignment()->setHorizontal('left');
        $sheet->getStyle('A6:AG' . $row)->getFont()->setSize(11);

        $sheet->getStyle('A1:AG' . $row)->getFont()->setName('Arial');
        // $sheet->getStyle('A' . ($row - 2) . ':F' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);


        foreach (range('A', 'AG') as $columnID) {
            $currentWidth = $sheet->getColumnDimension($columnID)->getWidth();
            $extraWidth = 14; // Define el margen adicional que quieres agregar
            $sheet->getColumnDimension($columnID)->setWidth($currentWidth + $extraWidth);
        }

        // Ajustar la altura de las filas dinámicamente a partir de la fila 7
        $rowIterator = $sheet->getRowIterator(7); // Comienza desde la fila 7
        foreach ($rowIterator as $row) {
            $sheet->getRowDimension($row->getRowIndex())->setRowHeight(-1); // Ajusta automáticamente
        }
        $sheet->getColumnDimension('A')->setWidth(46);



        $nombreArchivo = "Reporte_General_Tardanza_" . $anio . "_" . $nombreMes . ".xlsx";
        $fileName = $nombreArchivo;

        // Crear un escritor para guardar el archivo
        $writer = new Xlsx($spread);

        // Especificar la ruta donde guardar el archivo
        $filePath = './Uploads/Reportes/' . $fileName;

        // Guardar el archivo
        $writer->save($filePath);
        // }


        if ($data == 0) {
            $mensaje = "valor Vacio  Mes $mes año $anio";
        }

        return ['filepath' => $filePath, 'nombreArchivo' => $nombreArchivo, 'mensaje' => $mensaje, 'data' => ''];
    }

    public function exportarKardex($trabajador, $anio, $mes_inicio, $mes_fin)
    {
        $nombre_mes = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $diasDeLaSemana = ['lun.', 'mar.', 'mié.', 'jue.', 'vie.', 'sáb.', 'dom.'];

     
        $listaAsistencia = $this->model->obtenerLeyendaAsistencia($trabajador, $anio, $mes_inicio, $mes_fin);
        $listaBoleta = $this->model->obtenerBoletaLicenciaDuracion($trabajador, $anio, $mes_inicio, $mes_fin);
        $listaHoraExtra = $this->model->obtenerTotalHoraExtra($trabajador, $anio, $mes_inicio, $mes_fin);
        $listaTotalTardanza = $this->model->obtenerTotalTardanza($trabajador, $anio, $mes_inicio, $mes_fin);
        $listaTotalInasistenciaInjustificada = $this->model->obtenerTotalInasistenciaInjustificada($trabajador, $anio, $mes_inicio, $mes_fin);
        $listaPermisoLaboral = $this->model->obtenerTotalPermisoLaboral($trabajador, $anio, $mes_inicio, $mes_fin);
        $listaInasistenciaJustificada = $this->model->obtenerTotalInasistenciaJustificada($trabajador, $anio, $mes_inicio, $mes_fin);


        $resultado = [];
        foreach (range(0, 5) as $mes) {
            // $nombreMes = $nombre_mes[$mes - 1];
            $nombreMes = $listaHoraExtra[$mes]['mes'] ?? '';
            // 03 listaHoraExtra hora extra
            $HE_total_cantidad = $listaHoraExtra[$mes]['total_registros'] ?? '0';
            $HE_total_tiempo = $listaHoraExtra[$mes]['total_diferencia'] ?? '00:00';
            // 04 listaTotalTardanza tardanza
            $T_total_cantidad = $listaTotalTardanza[$mes]['total_registros'] ?? '0';
            $T_total_tiempo = $listaTotalTardanza[$mes]['total_tardanza'] ?? '00:00';
            // 05 listaTotalInasistenciaInjustificada inasistencia injustificada
            $II_NME = $listaTotalInasistenciaInjustificada[$mes]['total_nme'] ?? '0';
            $II_NMS = $listaTotalInasistenciaInjustificada[$mes]['total_nms'] ?? '0';
            $II_30 = $listaTotalInasistenciaInjustificada[$mes]['total_30'] ?? '0';
            $II_total = $listaTotalInasistenciaInjustificada[$mes]['total_general'] ?? '0';
            // 06 listaPermisoLaboral permisos laborales
            $PL_ap = $listaPermisoLaboral[$mes]['total_ap'] ?? '0';
            $PL_cs = $listaPermisoLaboral[$mes]['total_cs'] ?? '0';
            $PL_cap = $listaPermisoLaboral[$mes]['total_cap'] ?? '0';
            $PL_lmp = $listaPermisoLaboral[$mes]['total_lmlp'] ?? '0';
            $PL_cesp = $listaPermisoLaboral[$mes]['total_cesp'] ?? '0';
            $PL_dhe = $listaPermisoLaboral[$mes]['total_dhe'] ?? '0';
            $PL_ess = $listaPermisoLaboral[$mes]['total_ess'] ?? '0';
            $PL_otro = $listaPermisoLaboral[$mes]['total_otr'] ?? '0';
            $PL_general = $listaPermisoLaboral[$mes]['total_general'] ?? '0';
            // 07 listaInasistenciaJustificada inasistencia justificada
            $IJ_ap = $listaInasistenciaJustificada[$mes]['total_ap'] ?? '0';
            $IJ_av = $listaInasistenciaJustificada[$mes]['total_av'] ?? '0';
            $IJ_le = $listaInasistenciaJustificada[$mes]['total_le'] ?? '0';
            $IJ_lmp = $listaInasistenciaJustificada[$mes]['total_lmlp'] ?? '0';
            $IJ_v = $listaInasistenciaJustificada[$mes]['total_v'] ?? '0';
            $IJ_cesp = $listaInasistenciaJustificada[$mes]['total_cesp'] ?? '0';
            $IJ_d = $listaInasistenciaJustificada[$mes]['total_d'] ?? '0';
            $IJ_dhe = $listaInasistenciaJustificada[$mes]['total_dhe'] ?? '0';
            $IJ_cs = $listaInasistenciaJustificada[$mes]['total_cs'] ?? '0';
            $IJ_cap = $listaInasistenciaJustificada[$mes]['total_cap'] ?? '0';
            $IJ_lic = $listaInasistenciaJustificada[$mes]['total_lic_fg'] ?? '0'; // familiar grave
            $IJ_o = $listaInasistenciaJustificada[$mes]['total_ap'] ?? '0';
            $IJ_licgest = $listaInasistenciaJustificada[$mes]['total_lic_fg'] ?? '0';
            $IJ_total = $listaInasistenciaJustificada[$mes]['total_general'] ?? '0'; 
            // $resultado[$mes] = [
            $resultado[$nombre_mes[$nombreMes-1]] = [
                'Mes' => $nombre_mes[$nombreMes-1],
                // hora extra
                'HE_Cant' => $HE_total_cantidad,
                'HE_Total' => $HE_total_tiempo,
                // tardanza
                'T_Cant' => $T_total_cantidad,
                'T_Total' => $T_total_tiempo,
                // Inasistencia injustificada
                'II_NME' => $II_NME,
                'II_NMS' => $II_NMS,
                'II_30' => $II_30,
                'II_Total' => $II_total,
                // Permisos laborales
                'PL_AP' => $PL_ap,
                'PL_CS' => $PL_cs,
                'PL_CAP' => $PL_cap,
                'PL_LMP' => $PL_lmp,
                'PL_CESP' => $PL_cesp,
                'PL_DHE' => $PL_dhe,
                'PL_ESS' => $PL_ess,
                'PL_OTRO' => $PL_otro,
                'PL_General' => $PL_general,
                // Inasistencia justificada
                'IJ_AP' => $IJ_ap,
                'IJ_AV' => $IJ_av,
                'IJ_LE' => $IJ_le,
                'IJ_LMP' => $IJ_lmp,
                'IJ_V' => $IJ_v,
                'IJ_CESP' => $IJ_cesp,
                'IJ_D' => $IJ_d,
                'IJ_DHE' => $IJ_dhe,
                'IJ_CS' => $IJ_cs,
                'IJ_CAP' => $IJ_cap,
                'IJ_LIC' => $IJ_lic, // familiar grave
                'IJ_O' => $IJ_o,
                'IJ_LICGEST' => $IJ_licgest,
                'IJ_Total' => $IJ_total
                // '03 listaHoraExtra' => $listaHoraExtra[$mes] ?? [],
                // '04 listaTotalTardanza' => $listaTotalTardanza[$mes] ?? [],
                // '05 listaTotalInasistenciaInjustificada' => $listaTotalInasistenciaInjustificada[$mes] ?? [],
                // '06 listaPermisoLaboral' => $listaPermisoLaboral[$mes] ?? [],
                // '07 listaInasistenciaJustificada' => $listaInasistenciaJustificada[$mes] ?? []
            ];
        }
        // $resultado = [
        //     '01 listaAsistencia' => $listaAsistencia,
        //     '02 listaBoleta' => $listaBoleta,
        //     '03 listaHoraExtra' => $listaHoraExtra,
        //     '04 listaTotalTardanza' => $listaTotalTardanza,
        //     '05 listaTotalInasistenciaInjustificada' => $listaTotalInasistenciaInjustificada,
        //     '06 listaPermisoLaboral' => $listaPermisoLaboral,
        //     '07 listaInasistenciaJustificada' => $listaInasistenciaJustificada,
        // ];

        return $resultado;
    }
}
