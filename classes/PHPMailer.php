<?php
class PHPMailer extends Database
{
    public $id_servicio;
    public $nombre_servicio;
    public $descripcion_servicio;
    public $duracion;
    public $precio;
    public $checked;

    public function __construct()
    {
        $this->id_servicio = ['id_servicio'];
        $this->nombre_servicio = ['nombre_servicio'];
        $this->descripcion_servicio = ['descripcion_servicio'];
        $this->duracion = ['duracion'];
        $this->precio = ['precio'];
        $this->checked = ['checked'];
    }

    public static function GetServicios()
    {
        $mbd = new Database();
        $ads = $mbd->prepare("SELECT * FROM servicios");
        $ads->execute();
        $servicios = $ads->fetchAll(PDO::FETCH_ASSOC);
        return $servicios;
    }
    public static function GetInfoFromServicioId($id)
    {
        $mbd = new Database();
        $ads = $mbd->prepare("SELECT * FROM servicios WHERE id_servicio = :id_servicio");
        $ads->bindParam(':id_servicio', $id, PDO::PARAM_STR);
        $ads->execute();
        $servicioInfo = $ads->fetch(PDO::FETCH_ASSOC);
        return $servicioInfo;
    }
}
