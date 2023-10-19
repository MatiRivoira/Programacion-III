<?php
require_once __DIR__ . '/vendor/autoload.php';
include_once "./clases/autoDB.php";

use RivoiraMatias\autoBD;


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Crea un objeto mPDF
    $mpdf = new \Mpdf\Mpdf();

    // Configuración del encabezado y pie de página
    $mpdf->SetHeader('{PAGENO}');
    $mpdf->SetFooter(date('Y-m-d'));

    // Agregar una página
    $mpdf->AddPage();

    // Encabezado
    $mpdf->WriteHTML('<h1>Listado de Autos</h1>');

    // Cuerpo - Obtén la información de los autos y sus imágenes
    // Puedes usar una consulta a tu base de datos o cargarlos desde un archivo, dependiendo de tu implementación.

    $autos = autoBD::traer();

    // Genera una tabla HTML con la información de los autos
    $html = '<table border="1">';
    $html .= '<tr><th>Patente</th><th>Marca</th><th>Color</th><th>Precio</th><th>Foto</th></tr>';
    foreach ($autos as $auto) {
        $html .= '<tr>';
        $html .= '<td>' . $auto->patente . '</td>';
        $html .= '<td>' . $auto->marca . '</td>';
        $html .= '<td>' . $auto->color . '</td>';
        $html .= '<td>' . $auto->precio . '</td>';
        $html .= '<td><img src="' . $auto->pathFoto . '" alt="Foto" width="100"></td>';
        $html .= '</tr>';
    }
    $html .= '</table>';

    $mpdf->WriteHTML($html);
    
    // Generar el PDF
    $mpdf->Output();
}