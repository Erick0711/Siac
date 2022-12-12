<?php
namespace App\Modelo;
use App\config\Alerta,
    App\config\Redireccion,
    App\config\Conexion,
    PDO;
class Usuario extends Conexion
{
    use Alerta,Redireccion;
    protected   
                $nombre,
                $apellido,
                $ci,
                $complemento_ci,
                $correo,
                $telefono,                  // AREGLAR LAS CLASES QUE SE EXTIENDEN PARA COLOCAR UN SOLO MODELO DE LIBS MODELO
                $usuario,
                $campo_usuario,
                $contrasenia,
                $contrasenia_hash,
                $rol;
                
    public function Usuario()
    {
        parent::__construct();
    }
    public function mostrar($tabla)
    {
        $sql = "SELECT * FROM $tabla";
        $sentencia = $this->conexion->prepare($sql);
        $sentencia->execute();
        $registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registros;
    }
    public function mostrarTabla($tabla,$tabla2,$tabla3)
    {
        $sql = "SELECT persona.*, rol.*, usuario.* FROM $tabla 
                INNER JOIN $tabla2 on persona.id = usuario.id_persona
                INNER JOIN $tabla3 on rol.id = usuario.id_rol;";
        $sentencia = $this->conexion->prepare($sql);
        $sentencia->execute();
        $registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $registros;
    }
    public function registrarUsuario($tabla, $tabla2,$nombre, $apellido, $ci, $complemento_ci, 
                                $correo, $telefono, $usuario, $contrasenia, $rol)
    {
        $sql = "INSERT INTO $tabla (`id`, `nombre`, `apellido`, `ci`, `complemento_ci`, `correo`, 
                            `telefono`, `estado`, `created_at`, `updated_at`) 
                            VALUES (NULL, '$nombre' , '$apellido', '$ci', '$complemento_ci', '$correo', '$telefono', '1', 
                            current_timestamp(), current_timestamp());";
        $sentencia = $this->conexion->prepare($sql);
        if($sentencia->execute()){
            $id_persona = $this->conexion->lastInsertId();
            $sql = "INSERT INTO $tabla2 (`id`, `id_persona`, `id_rol`, `usuario`, 
                                `contrasenia`, `estado`, `created_at`, `updated_at`) 
                                VALUES (NULL, '$id_persona', '$rol', '$usuario', '$contrasenia', '1', 
                                current_timestamp(), current_timestamp());";
            $sentencia = $this->conexion->prepare($sql);
            if($sentencia->execute()){
            $registros = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $registros;   
            }else{
                echo $this->alerta_fallo;
            }
        } 
    } 
    /********************************************** LOGIN ******************************************************/ 
    public function buscar($usuario, $contrasenia)
    {
        $sql = "SELECT usuario.usuario, usuario.contrasenia, rol.nombre_rol
                FROM usuario INNER JOIN rol ON rol.id = usuario.id_rol
                WHERE usuario.usuario = '$usuario'";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->execute();
            $registros = $sentencia->fetch(PDO::FETCH_ASSOC);
            $pass = $registros['contrasenia'];
            if(password_verify($contrasenia, $pass)){
                return $registros;
            }
    }
}
?>