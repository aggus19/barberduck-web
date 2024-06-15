<?php

class Token extends Database
{
    public static function GenerateToken()
    {
        $token = bin2hex(random_bytes(16));
        $token = substr($token, 0, 8) . '-' . substr($token, 8, 4) . '-' . substr($token, 12, 4) . '-' . substr($token, 16, 4) . '-' . substr($token, 20, 12);
        return $token;
    }
    public static function isValid($id_reserva, $token)
    {
        $mbd = new Database();

        // Preparar la consulta SQL para obtener el token de la reserva
        $stmt = $mbd->prepare("SELECT token FROM reservas WHERE id_reserva = :id_reserva");
        $stmt->bindParam(':id_reserva', $id_reserva, PDO::PARAM_INT);
        $stmt->execute();

        // Obtener el token de la reserva
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row && isset($row['token'])) {
            $db_token = $row['token'];

            // Verificar si los tokens coinciden
            if ($token === $db_token) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
