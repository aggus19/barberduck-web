<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
   header('HTTP/1.1 405 Method Not Allowed');
   header('Allow: POST');
   exit;
}

// Incluir las clases
require_once '../classes/Database.php';
require_once '../classes/Reservas.php';
require_once '../classes/Horarios.php';
require_once '../classes/User.php';
require_once '../classes/Token.php';
require_once '../classes/IP.php';
require_once '../classes/Servicios.php';

require '../vendor/autoload.php';

$reserva = new Reservas();
$horarios = new Horarios();
$Token = new Token();
$user = new User();
$ip = new IP();

// Obtener los valores del formulario
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['correo'];
$telefono = $_POST['telefono'];
$servicio = $_POST['servicio'];
$metodo_pago = $_POST['metodo_pago'];
$horario = $_POST['horario'];
$token = $_POST['token'];

try {
   $fechaActual = date("d/m/Y H:i");
   $servicioData = Servicios::GetInfoFromServicioId($servicio);
   $nombreServicio = $servicioData['nombre_servicio'];
   $precioServicio = $servicioData['precio'];

   $ipUser = $ip->GetIP();
   $horarioData = $horarios->GetInfoFromDay($horario);
   $hora_reservada = $horarioData['hora_inicio'] . ' - ' . $horarioData['hora_fin'];

   $fecha = date("d/m/Y", strtotime($horarioData['fecha']));

   $diaFormateado = date("d/m", strtotime($fecha));

   $horaInicioFormateado = date("H:i", strtotime($horarioData['hora_inicio']));

   if ($metodo_pago == "Debito") {
      $metodo_pago = "Tarjeta de Debito";
      //$imagen = "https://afagundez.shop/img/debito.png";
      $costoFinal = $precioServicio + 10;
   } else 	if ($metodo_pago == "Efectivo") {
      $metodo_pago = "En efectivo";
      //$imagen = "https://afagundez.shop/img/efectivo.png";
      $costoFinal = $precioServicio;
   }

   // Definir $userInfo como un arreglo vacío
   $userInfo = [];

   // Verificar si el usuario ya existe
   $userInfo = $user->GetInfoByTelefono($telefono);
   if (!$userInfo) {
      // Si el usuario no existe, crear uno nuevo
      $user->CreateNewUser($nombre, $apellido, $email, $telefono);

      // Obtener la información del usuario recién creado
      $userInfo = $user->GetInfoByTelefono($telefono);
   }

   // Continuar con el resto del código, sabiendo que $userInfo siempre existe
   // Llamada a la función InsertNew() para agregar datos a la base de datos
   $sentencia = $reserva->InsertNew($userInfo['id_usuario'], $servicio, $fecha, $hora_reservada, $metodo_pago, $horario, $token, '1', $ipUser);

   // Obtener la última reserva del usuario
   $ultima_reserva = $reserva->GetLastReservationByUserId($userInfo['id_usuario']);
   $id_ultima_reserva = $ultima_reserva['id_reserva'];

   // Redirigir al usuario a una página de confirmación
   header('Location: confirmacion?id_reserva=' . $id_ultima_reserva . '&token=' . $token);
} catch (PDOException $e) {
   echo '[Procesar] Ha surgido un error y no se puede insertar en la base de datos. (' . $e->getMessage() . ')';
   exit;
}
