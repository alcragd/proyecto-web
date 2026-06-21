<?php
require('fpdf/fpdf.php'); 
require_once('connection.php');

class PDF extends FPDF {
    function Header() {
        if(file_exists('../img/logo-ipn-guinda.png')) {
            $this->Image('../img/logo-ipn-guinda.png', 10, 8, 25); 
        }
        if(file_exists('../img/logoEscom.png')) {
            $this->Image('../img/logoEscom.png', 168, 13, 35); 
        }
        
        $this->SetFont('times', 'B', 16);
        $this->SetTextColor(91,18,55);
        $this->Cell(0, 10, utf8_decode('Instituto Politécnico Nacional'), 0, 1, 'C');
        $this->SetTextColor(52,50,84);
        $this->Cell(0, 10, utf8_decode('Escuela Superior de Cómputo'), 0, 1, 'C');
        $this->Ln(5);
        $this->SetFont('times', 'B', 14);
        $this->SetTextColor(0,0,0);
        $this->Cell(0, 10, utf8_decode('Acuse de Registro y Asignación de Examen'), 0, 1, 'C');
        $this->Ln(20);
    }

    function Footer() {
        $this->SetY(-25);
        $this->SetFont('times', 'I', 10);
        $this->SetTextColor(0,0,0);
        $this->MultiCell(0, 6, utf8_decode('Nota: Por favor, preséntate 10 minutos antes de tu horario asignado con una identificación oficial. Este documento es tu comprobante oficial de registro.'));

        $this->SetY(-15);
        $this->SetFont('times','b','8');
        $this->SetTextColor(0,0,0);
        $this->Cell(0,15,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
    }
}

if(!isset($_GET['boleta']) || empty($_GET['boleta'])){
    die("Error: No se especificó una boleta.");
}

$boleta = $_GET['boleta'];

$query = "
    SELECT 
        a.boleta, a.nombre, a.pat, a.mat, a.fecha_nac, a.gen, a.curp, a.ent_pro, a.tel, a.esc_pro, a.prom,
        l.nombre AS laboratorio,
        h.hora_ini, h.hora_fin
    FROM alumnos a
    INNER JOIN asignacion_examen ae ON a.boleta = ae.boleta
    INNER JOIN laboratorio l ON ae.id_lab = l.id_lab
    INNER JOIN horarios h ON ae.id_horario = h.id_horario
    WHERE a.boleta = ?
";

$stmt = mysqli_prepare($conexion, $query);
mysqli_stmt_bind_param($stmt, "s", $boleta);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($resultado) === 0){
    die("Error: No se encontró información para esta boleta.");
}

$datos = mysqli_fetch_assoc($resultado);

$pdf = new PDF();
$pdf->AddPage();

$pdf->AliasNBPages();

// --- DATOS DEL ALUMNO ---
$pdf->SetFont('Arial', '', 12);
function imprimirFila($pdf, $etiqueta, $valor) {
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(50, 8, utf8_decode($etiqueta), 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 8, utf8_decode($valor), 0, 1);
}

$nombreCompleto = $datos['nombre'] . ' ' . $datos['pat'] . ' ' . $datos['mat'];

imprimirFila($pdf, 'Boleta:', $datos['boleta']);
imprimirFila($pdf, 'Nombre:', $nombreCompleto);
imprimirFila($pdf, 'CURP:', $datos['curp']);
imprimirFila($pdf, 'Fecha de Nac.:', $datos['fecha_nac']);
imprimirFila($pdf, 'Género:', $datos['gen']);
imprimirFila($pdf, 'Teléfono:', $datos['tel']);
imprimirFila($pdf, 'Entidad:', $datos['ent_pro']);
imprimirFila($pdf, 'Esc. Procedencia:', $datos['esc_pro']);
imprimirFila($pdf, 'Promedio:', $datos['prom']);

$pdf->Ln(20);

// --- DATOS DE ASIGNACIÓN ---
$pdf->SetTextColor(52,50,84);
$pdf->SetFont('times', 'B', 14);
$pdf->Cell(0, 10, utf8_decode('Detalles de tu Examen Diagnóstico:'), 0, 1, 'L');

// Definir colores y fuente para la tabla
$pdf->SetFillColor(220, 220, 220); 
$pdf->SetTextColor(0, 0, 0);       
$pdf->SetFont('Arial', 'B', 12);
$pdf->Ln(5); 

// Encabezados de la tabla
$pdf->Cell(95, 10, utf8_decode('Laboratorio'), 1, 0, 'C', true);
$pdf->Cell(95, 10, utf8_decode('Horario'), 1, 1, 'C', true);

// Contenido de la tabla
$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(91,18,55);
$pdf->Cell(95, 10, utf8_decode($datos['laboratorio']), 1, 0, 'C');
$horarioTexto = $datos['hora_ini'] . ' a ' . $datos['hora_fin'] . ' hrs';
$pdf->Cell(95, 10, utf8_decode($horarioTexto), 1, 1, 'C');


$pdf->Output('D', 'Acuse_Registro_'.$boleta.'.pdf');

mysqli_close($conexion);
?>