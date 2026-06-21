<?php
require('fpdf/fpdf.php'); 
require_once('connection.php');

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

$pdf = new FPDF();
$pdf->AddPage();

// --- HEADER ---
// Image(archivo, x, y, ancho)
if(file_exists('../img/logo-ipn-guinda.png')) {
    $pdf->Image('../img/logo-ipn-guinda.png', 10, 10, 25); 
}
if(file_exists('../img/logoEscom.png')) {
    $pdf->Image('../img/logoEscom.png', 175, 10, 25); 
}

// Título
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, utf8_decode('Instituto Politécnico Nacional'), 0, 1, 'C');
$pdf->Cell(0, 10, utf8_decode('Escuela Superior de Cómputo'), 0, 1, 'C');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, utf8_decode('Acuse de Registro y Asignación de Examen'), 0, 1, 'C');
$pdf->Ln(10);

// --- DATOS DEL ALUMNO ---
$pdf->SetFont('Arial', '', 12);
// Función auxiliar para imprimir filas de datos
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

$pdf->Ln(10);

// --- DATOS DE ASIGNACIÓN (RESALTADOS) ---
// Cambiamos el color de texto a un Guinda IPN (RGB: 104, 36, 68) o Azul ESCOM
$pdf->SetTextColor(104, 36, 68); 
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, utf8_decode('Detalles de tu Examen Diagnóstico:'), 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 8, utf8_decode('Laboratorio Asignado:'), 0, 0);
$pdf->Cell(0, 8, utf8_decode($datos['laboratorio']), 0, 1);

$pdf->Cell(50, 8, utf8_decode('Horario:'), 0, 0);
$horarioTexto = $datos['hora_ini'] . ' hrs a ' . $datos['hora_fin'] . ' hrs';
$pdf->Cell(0, 8, utf8_decode($horarioTexto), 0, 1);

// Restaurar color a negro por si agregas más texto después
$pdf->SetTextColor(0, 0, 0); 
$pdf->Ln(15);

$pdf->SetFont('Arial', 'I', 10);
$pdf->MultiCell(0, 6, utf8_decode('Nota: Por favor, preséntate 10 minutos antes de tu horario asignado con una identificación oficial. Este documento es tu comprobante oficial de registro.'));

// Generar PDF y mostrarlo en el navegador
$pdf->Output('I', 'Acuse_Registro_'.$boleta.'.pdf');

// Cerrar conexión
mysqli_close($conexion);
?>