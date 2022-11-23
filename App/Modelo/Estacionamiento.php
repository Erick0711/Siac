<?php
namespace App\Modelo;
use App\config\Conexion,
    App\config\Alerta,
    App\config\Redireccion,
    PDO;
class Estacionamiento extends Conexion
{
    use Alerta,Redireccion;
    protected   $estacionamiento,  
                $numeroEstacionamiento,
                $idPabellon;

    public function Estacionamiento()
    {
        parent::__construct();
    }
    public function mostrarTabla($tabla, $tabla2)
    {
        $sql = "SELECT pabellon.id, pabellon.numero_pabellon, estacionamiento.id 
                as estacionamiento_id, estacionamiento.numero_estacionamiento, estacionamiento.estado 
                FROM $tabla INNER JOIN $tabla2 ON pabellon.id = estacionamiento.id_pabellon ";
        $sentencia = $this->conexion->prepare($sql);
        $sentencia->execute();
        $registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registros;
    }
    public function registrarEstacionamiento($tabla, $numeroPabellon, $numeroEstaciomiento)
    {
        $sql = "INSERT INTO $tabla (`id`, `id_pabellon`, `numero_estacionamiento`, `estado`, `created_at`, `updated_at`) 
                VALUES (NULL, '$numeroPabellon', '$numeroEstaciomiento','1', current_timestamp(), current_timestamp())";
        $sentencia = $this->conexion->prepare($sql);
        $sentencia->execute();
        $registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registros;
    }
    public function actualizarEstacionamiento($tabla, $idPabellon ,$numeroEstaciomiento, $id)
    {
        $sql = "UPDATE $tabla SET `id_pabellon` = '$idPabellon', `numero_estacionamiento` = '$numeroEstaciomiento' 
                WHERE `estacionamiento`.`id` = $id";
        $sentencia = $this->conexion->prepare($sql);
        $sentencia->execute();
        $registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registros;
    }
    public function eliminarEstacionamiento($tabla, $idEstacionamiento){
        $sql = "UPDATE $tabla SET estado=0 WHERE id=$idEstacionamiento";
        $sentencia = $this->conexion->prepare($sql);
        $sentencia->execute();
        $registros = $sentencia->fetch(PDO::FETCH_LAZY);
        return $registros;
    }
}
?>