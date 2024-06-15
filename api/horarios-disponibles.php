<?php
// include_once '../includes/classes.php';
require_once '../classes/Database.php';
require_once '../classes/Reservas.php';
require_once '../classes/Horarios.php';

$horarios = new Horarios();
$reservas = new Reservas();

// Verificar que la solicitud proviene de tu sitio web
if (!isset($_SERVER['HTTP_REFERER']) || parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) !== $_SERVER['HTTP_HOST']) {
    $error = ['message' => 'Acceso no autorizado.'];
    http_response_code(403);
    header('Content-Type: application/json');
    echo json_encode($error);
    exit;
}

// Obtener el día seleccionado por el usuario
$dia = $_GET['dia'] ?? $_POST['dia'] ?? die(json_encode(['message' => 'Debe proporcionar un día.']));

// Comprobar si se proporcionó el día
if (!$dia) {
    $error = ['message' => 'Debe proporcionar un día.'];
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode($error);
    exit;
}

// Obtener la fecha correspondiente al día seleccionado
$fecha = date('Y-m-d', strtotime("next $dia"));

// Obtener los horarios disponibles para ese día
$horariosDisponibles = array_filter($horarios->GetNextScheduleByNameDay($dia), function ($horario) use ($reservas) {
    return !$reservas->CheckReservation($horario['id_horario']);
});

// Generar las opciones HTML para el segundo select con los horarios disponibles
$options = '<option value="">Seleccione un horario</option>';
foreach ($horariosDisponibles as $horario) {
    $optionValue = $horario['id_horario'];
    $optionText = $horario['hora_inicio'] . ' - ' . $horario['hora_fin'];
    $options .= "<option value=\"$optionValue\">$optionText</option>";
}

// Crear un objeto JSON con los horarios disponibles, la fecha y las opciones HTML
$response = [
    'horarios' => $horariosDisponibles,
    'fecha' => date('d-m', strtotime($fecha)),
    'options' => $options,
];

// Devolver la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);
