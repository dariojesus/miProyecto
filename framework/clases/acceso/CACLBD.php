<?php
class CACLBD extends CACLBase
{

    private $_sqli;

    public function __construct($servidor,$usuario,$contrasena,$nombreBD)
    {
        $this->_sqli = new CBaseDatos($servidor,$usuario,$contrasena,$nombreBD);
    }

    //Funciones de roles
    public function anadirRole($nombre, $permisos = array())
    {

        if (sizeof($permisos) < 10) {
            do {
                $permisos[] = false;
            } while (sizeof($permisos) < 10);
        }

        $consulta = "INSERT INTO `roles` (`nombre_rol`, `permiso1`, `permiso2`, `permiso3`, `permiso4`, `permiso5`, `permiso6`, `permiso7`, `permiso8`, `permiso9`, `permiso10`) ";
        $consulta .= "VALUES ('$nombre', '$permisos[0]', '$permisos[1]', '$permisos[2]', '$permisos[3]', '$permisos[4]', '$permisos[5]', '$permisos[6]', '$permisos[7]', '$permisos[8]', '$permisos[9]')";

        return $this->_sqli->crearConsulta($consulta);
    }

    public function getCodRole($nombre)
    {

        $consulta = "SELECT cod_rol from roles where nombre_rol = '$nombre'";

        $resul = $this->_sqli->crearConsulta($consulta)->fila();

        return (is_null($resul) ? false : $resul["cod_rol"]);
    }

    public function existeRole($codRole)
    {
        $consulta = "SELECT * from `roles` where cod_rol = '$codRole'";

        $resul = $this->_sqli->crearConsulta($consulta)->fila();

        if (is_null($resul))
            return false;

        return true;
    }

    public function getPermisosRole($codRole)
    {
        $consulta = "SELECT `permiso1`, `permiso2`, `permiso3`, `permiso4`, `permiso5`, `permiso6`, `permiso7`, `permiso8`, `permiso9`, `permiso10` FROM `roles` WHERE cod_rol = $codRole";

        $resul = $this->_sqli->crearConsulta($consulta)->fila();

        return (is_null($resul) ? false : $resul);
    }


    //Funciones de usuario
    public function anadirUsuario($nif, $contrasena, $codRole)
    {
        $consulta = "INSERT INTO  `usuarios` (`nif`,`contrasenna`,`cod_rol`) VALUES ('$nif',MD5('$contrasena'), $codRole)";
        return $this->_sqli->crearConsulta($consulta);
    }

    public function getCodUsuario($nif)
    {
        $consulta = "SELECT `cod_usuario` FROM `usuarios` WHERE `nif` = '$nif'";

        $resul = $this->_sqli->crearConsulta($consulta)->fila();

        return (is_null($resul) ? false : $resul["cod_usuario"]);
    }

    public function existeUsuario($nif)
    {
        if ($this->getCodUsuario($nif) !== false)
            return true;

        return false;
    }

    public function esValido($nif, $contrasena)
    {
        $consulta = "SELECT * FROM `usuarios` WHERE nif = '$nif' and contrasenna = MD5('$contrasena') and borrado = 0 ";

        $resul = $this->_sqli->crearConsulta($consulta)->fila();

        if (is_null($resul))
            return false;

        return true;
    }


    //Getters
    public function getPermiso($codUsuario, $numero)
    {

        $resul = $this->getPermisos($codUsuario);

        if ($resul === false)
            return false;

        return $resul[$numero - 1] == 1;
    }

    public function getPermisos($codUsuario)
    {
        $consulta = "SELECT `permiso1`, `permiso2`, `permiso3`, `permiso4`, `permiso5`, `permiso6`, `permiso7`, `permiso8`, `permiso9`, `permiso10` FROM `usuarios_roles` WHERE cod_usuario = $codUsuario";

        $resul = $this->_sqli->crearConsulta($consulta)->fila();

        if (is_null($resul))
            return false;

        return $resul;
    }

    
    public function getBorrado($codUsuario)
    {
        $consulta = "SELECT borrado FROM `usuarios` WHERE cod_usuario = $codUsuario";

        $resul = $this->_sqli->crearConsulta($consulta)->fila();

        if (is_null($resul))
            return false;

        return $resul["borrado"];
    }

    public function getUsuarioRole($codUsuario)
    {
        $consulta = "SELECT `nombre_rol` FROM `usuarios_roles`  WHERE cod_usuario = $codUsuario";

        $resul = $this->_sqli->crearConsulta($consulta)->fila();

        if (is_null($resul))
            return false;

        return $resul["nombre_rol"];
    }

    //Setters
    public function setContrasenia($codUsuario, $contra)
    {
        $consulta = "UPDATE `usuarios` SET `contrasenna` = MD5('$contra') WHERE `cod_usuario` = '$codUsuario'";
        $this->_sqli->crearConsulta($consulta);
    }

    public function setBorrado($codUsuario, $borrado)
    {
        $consulta = "UPDATE `usuarios` SET `borrado` = '$borrado' WHERE `cod_usuario` = '$codUsuario'";
        $this->_sqli->crearConsulta($consulta);
    }

    public function setUsuarioRole($codUsuario, $rol)
    {
        $consulta = "UPDATE `usuarios_roles` SET `cod_rol` = '$rol' WHERE `cod_usuario` = '$codUsuario'";
        $this->_sqli->crearConsulta($consulta);
    }


    //Arrays
    public function dameUsuarios()
    {
        $consulta = "SELECT `cod_usuario`, `nif` from `usuarios` ORDER BY `cod_usuario`";

        $datos = $this->_sqli->crearConsulta($consulta);
        $res = [];

        while ($fila = $datos->filas())
            $res[$fila["cod_usuario"]] = $fila["nif"];

        return $res;
    }

    public function dameRoles()
    {
        $consulta = "SELECT `cod_rol`, `nombre_rol` from `roles` ORDER BY `cod_rol`";

        $datos = $this->_sqli->crearConsulta($consulta);
        $res = [];

        while ($fila = $datos->filas())
            $res[$fila["cod_rol"]] = $fila["nombre_rol"];

        return $res;
    }
}
?>