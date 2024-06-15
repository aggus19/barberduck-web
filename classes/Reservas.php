<?php
class Reservas extends Database
{
    public $id_reserva;
    public $id_usuario;
    public $id_servicio;
    public $fecha_reservada;
    public $hora_reservada;
    public $reserva_creada;
    public $id_horario;
    public $confirmada;
    public $ip;


    public function __construct()
    {
        $this->id_reserva = ['id_reserva'];
        $this->id_usuario = ['id_usuario'];
        $this->id_servicio = ['id_servicio'];
        $this->fecha_reservada = ['fecha_reservada'];
        $this->hora_reservada = ['hora_reservada'];
        $this->reserva_creada = ['reserva_creada'];
        $this->id_horario = ['id_horario'];
        $this->confirmada = ['confirmada'];
        $this->ip = ['ip'];
    }

    public static function GetAllReservas()
    {
        $mbd = new Database();
        $ads = $mbd->prepare("SELECT * FROM reservas");
        $ads->execute();
        $reservas = $ads->fetchAll(PDO::FETCH_ASSOC);
        return $reservas;
    }

    public static function GetReservationConfirmed($id_horario)
    {
        $mbd = new Database();
        $ads = $mbd->prepare("SELECT confirmada FROM reservas WHERE id_horario = :id_horario");
        $ads->bindParam(':id_horario', $id_horario);
        $ads->execute();
        $confirmada = $ads->fetchColumn();
        if ($confirmada == '1') {
            return true;
        } else {
            return false;
        }
    }


    public static function GetConfirmadaStatus($id_reserva)
    {
        $mbd = new Database();
        $ads = $mbd->prepare("SELECT confirmada FROM reservas WHERE id_reserva = :id_reserva");
        $ads->bindParam(':id_reserva', $id_reserva);
        $ads->execute();
        $confirmada = $ads->fetchColumn();
        if ($confirmada == '1') {
            return '<a class="fw-semibold text-gray-600 text-hover-primary mt-2">Estado: </a> <span class="badge badge-light-success me-2">Confirmada</span>';
        } else {
            return '<span class="badge badge-light-danger me-2">Cancelada</span>';
        }
    }

    public static function InsertNew($id_usuario, $id_servicio, $fecha_reservada, $hora_reservada, $payment_method, $id_horario, $token, $confirmada, $ip)
    {
        $mbd = new Database();
        $ads = $mbd->prepare("INSERT INTO reservas (id_usuario, id_servicio, fecha_reservada, hora_reservada, reserva_creada, payment_method, id_horario, token, confirmada, ip) VALUES (:id_usuario, :id_servicio, :fecha_reservada, :hora_reservada, :reserva_creada, :payment_method, :id_horario, :token, :confirmada, :ip)");
        $reserva_creada = date('d/m/Y H:i');
        $ads->bindParam(':id_usuario', $id_usuario);
        $ads->bindParam(':id_servicio', $id_servicio);
        $ads->bindParam(':fecha_reservada', $fecha_reservada);
        $ads->bindParam(':hora_reservada', $hora_reservada);
        $ads->bindParam(':reserva_creada', $reserva_creada);
        $ads->bindParam(':payment_method', $payment_method);
        $ads->bindParam(':id_horario', $id_horario);
        $ads->bindParam(':token', $token);
        $ads->bindParam(':confirmada', $confirmada);
        $ads->bindParam(':ip', $ip);
        $ads->execute();
    }

    public static function DeleteReservationById($id_reserva)
    {
        $mbd = new Database();
        $ads = $mbd->prepare("DELETE FROM reservas WHERE id_reserva = :id_reserva");
        $ads->bindParam(':id_reserva', $id_reserva);
        $ads->execute();
    }

    public static function CancelReservationById($id_reserva)
    {
        $mbd = new Database();
        $ads = $mbd->prepare("UPDATE reservas SET confirmada = '0' WHERE id_reserva = :id_reserva");
        $ads->bindParam(':id_reserva', $id_reserva);
        $ads->execute();
    }

    public static function ReactivateReservationById($id_reserva)
    {
        $mbd = new Database();
        $ads = $mbd->prepare("UPDATE reservas SET confirmada = 1 WHERE id_reserva = :id_reserva");
        $ads->bindParam(':id_reserva', $id_reserva);
        $ads->execute();
    }

    public static function GetReservasPorMes($mes)
    {
        $mbd = new Database();
        $ads = $mbd->prepare("SELECT * FROM reservas WHERE MONTH(fecha_reservada) = :mes");
        $ads->bindParam(':mes', $mes);
        $ads->execute();
        $reservas = $ads->fetchAll(PDO::FETCH_ASSOC);
        return $reservas;
    }


    public static function GetLastReservationByUserId($id_usuario)
    {
        $mbd = new Database();

        // Preparar la consulta SQL
        $stmt = $mbd->prepare("SELECT * FROM reservas WHERE id_usuario = :id_usuario ORDER BY id_reserva DESC LIMIT 1");

        // Asignar el valor a los parámetros de la consulta
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

        // Ejecutar la consulta
        if (!$stmt->execute()) {
            throw new PDOException("Error al ejecutar la consulta.");
        }

        // Obtener la reserva
        $reserva = $stmt->fetch(PDO::FETCH_ASSOC);

        return $reserva;
    }

    public static function GetLastReservationTokenByUserId($id_usuario)
    {
        $mbd = new Database();
        $stmt = $mbd->prepare("SELECT token FROM reservas WHERE id_usuario = :id_usuario ORDER BY id_reserva DESC LIMIT 1");
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        if (!$stmt->execute()) {
            throw new PDOException("Error al ejecutar la consulta.");
        }
        $token = $stmt->fetchColumn();
        return $token;
    }

    public function GetInfoById($id_reserva)
    {
        $mbd = new Database();
        $stmt = $mbd->prepare("SELECT * FROM reservas WHERE id_reserva = :id_reserva");
        $stmt->bindParam(':id_reserva', $id_reserva, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function CheckReservation($id_horario)
    {
        $mbd = new Database();
        $ads = $mbd->prepare("SELECT * FROM reservas WHERE id_horario = :id_horario AND confirmada = 1");
        $ads->bindParam(':id_horario', $id_horario);
        $ads->execute();
        $reservas = $ads->fetchAll(PDO::FETCH_ASSOC);
        // Si hay al menos una reserva para el horario actual, retornar true
        return count($reservas) > 0;
    }

    public static function GetReservasByDate($fecha)
    {
        $mbd = new Database();
        $ads = $mbd->prepare("SELECT hora_reservada, id_horario, confirmada FROM reservas WHERE fecha_reservada = :fecha");
        $ads->bindParam(':fecha', $fecha, PDO::PARAM_STR);
        $ads->execute();
        $reservas = $ads->fetchAll(PDO::FETCH_COLUMN);
        return $reservas;
    }
    // Obtener las reservas del dia de hoy y la fecha de fecha_reservada que me devuelva el dia y mes. Y despues, la hora reservada sin los ultimos 3 caracteres. Por ejemplo, si la hora reservada es 12:00:00, que me devuelva 12:00
    public static function GetReservasToday()
    {
        $mbd = new Database();
        $ads = $mbd->prepare("SELECT id_reserva, id_usuario, id_servicio, hora_reservada, id_horario, payment_method, confirmada, token, DATE_FORMAT(fecha_reservada, '%d/%m') as fecha_reservada FROM reservas WHERE fecha_reservada = CURDATE()");
        $ads->execute();
        $reservas = $ads->fetchAll(PDO::FETCH_ASSOC);
        foreach ($reservas as $key => $reserva) {
            if ($reserva['confirmada'] == '1') {
                $reservas[$key]['confirmada'] = "<span class='text-success fw-bold'>Confirmada</span>";
            } else {
                $reservas[$key]['confirmada'] = "<span class='text-danger'>Cancelada</span>";
            }
        }
        return $reservas;
    }
}
