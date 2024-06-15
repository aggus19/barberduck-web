<?php
class Horarios extends Database
{
    public $id_horario;
    public $dia_semana;
    public $hora_inicio;
    public $hora_fin;
    public $fecha;
    public $abierto;


    public function __construct()
    {
        $this->id_horario = ['id_horario'];
        $this->dia_semana = ['dia_semana'];
        $this->hora_inicio = ['hora_inicio'];
        $this->hora_fin = ['hora_fin'];
        $this->fecha = ['fecha'];
        $this->abierto = ['abierto'];
    }

    public static function GetAllHorarios()
    {
        $mbd = new Database();
        $ads = $mbd->prepare("SELECT * FROM horarios");
        $ads->execute();
        $uInfo = $ads->fetchAll();
        return $uInfo[0];
    }

    public static function GetInfoFromDay($id_horario)
    {
        $mbd = new Database();
        $ads = $mbd->prepare("SELECT * FROM horarios WHERE id_horario = :id_horario");
        $ads->bindParam(':id_horario', $id_horario);
        $ads->execute();
        $uInfo = $ads->fetchAll();
        return $uInfo[0];
    }

    public static function GetNextSchedule()
    {
        $mbd = new Database();
        $ads = $mbd->prepare("
            SELECT 
                horarios.id_horario,
                horarios.dia_semana, 
                REPLACE(DATE_FORMAT(horarios.fecha, '%d-%m'), '-', '/') AS dia_mes, 
                SUBSTR(horarios.hora_inicio, 1, 5) AS hora_inicio, 
                SUBSTR(horarios.hora_fin, 1, 5) AS hora_fin, 
                RIGHT(DATE_FORMAT(horarios.fecha, '%Y'), 2) AS anio 
            FROM horarios 
            LEFT JOIN reservas ON horarios.id_horario = reservas.id_horario AND reservas.fecha_reservada = CURDATE() 
            WHERE horarios.fecha >= CURDATE() AND horarios.fecha <= CURDATE() + INTERVAL 7 DAY 
            ORDER BY horarios.fecha, horarios.hora_inicio");
        $ads->execute();
        $horarios = $ads->fetchAll();

        // Obtener los horarios reservados para el día actual
        $reservas = Reservas::GetReservasByDate(date('Y-m-d'));

        // Recorrer los horarios y agregar el atributo "disabled" a aquellos que ya tienen una reserva
        foreach ($horarios as &$horario) {
            if (in_array($horario['hora_inicio'], $reservas)) {
                $horario['disabled'] = true;
            } else {
                $horario['disabled'] = false;
            }
        }

        return $horarios;
    }

    public function getHorarioByDia($dia)
    {
        $mbd = new Database();
        $stmt = $mbd->prepare("SELECT * FROM horarios WHERE dia_semana = :dia");
        $stmt->bindParam(':dia', $dia);
        $stmt->execute();
        $horarios = $stmt->fetchAll();
        return $horarios;
    }

    public function getHorarioById($id)
    {
        $mbd = new Database();
        $stmt = $mbd->prepare("SELECT * FROM horarios WHERE id_horario = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $horarios = $stmt->fetchAll();
        return $horarios;
    }

    public function getHorarioByFecha($fecha)
    {
        $mbd = new Database();
        $stmt = $mbd->prepare("SELECT * FROM horarios WHERE fecha = :fecha");
        $stmt->bindParam(':fecha', $fecha);
        $stmt->execute();
        $horarios = $stmt->fetchAll();
        return $horarios;
    }

    public static function GetNextScheduleByNameDay($dia)
    {
        $mbd = new Database();
        $ads = $mbd->prepare("
        SELECT 
            horarios.id_horario,
            horarios.dia_semana, 
            REPLACE(DATE_FORMAT(horarios.fecha, '%d-%m'), '-', '/') AS dia_mes, 
            SUBSTR(horarios.hora_inicio, 1, 5) AS hora_inicio, 
            SUBSTR(horarios.hora_fin, 1, 5) AS hora_fin, 
            RIGHT(DATE_FORMAT(horarios.fecha, '%Y'), 2) AS anio 
        FROM horarios 
        LEFT JOIN reservas ON horarios.id_horario = reservas.id_horario AND reservas.fecha_reservada = CURDATE() 
        WHERE horarios.dia_semana = :dia AND horarios.fecha >= CURDATE() AND horarios.fecha <= CURDATE() + INTERVAL 7 DAY 
        ORDER BY horarios.fecha, horarios.hora_inicio");
        $ads->bindParam(':dia', $dia);
        $ads->execute();
        $horarios = $ads->fetchAll();

        // Obtener los horarios reservados para el día actual
        $reservas = Reservas::GetReservasByDate(date('Y-m-d'));

        // Recorrer los horarios y agregar el atributo "disabled" a aquellos que ya tienen una reserva
        foreach ($horarios as &$horario) {
            if (in_array($horario['hora_inicio'], $reservas)) {
                $horario['disabled'] = true;
            } else {
                $horario['disabled'] = false;
            }
        }

        return $horarios;
    }
}
