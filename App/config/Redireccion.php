<?php
namespace App\config;

trait Redireccion
{
    public  $rediccionarInicio = "<script> window.location.href =  '../vista/inicio.php';</script>",
            $redireccionarUsuario = "<script> window.location.href =  '../vista/usuario.php';</script>",
            $redireccionarLogin = "<script> window.location.href =  '../vista/login.php';</script>",
            $redireccionarGasto = "<script> window.location.href =  '../vista/gasto.php';</script>";
            
}

?>