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

        $consulta = "INSERT INTO `acl_roles` (`cod_acl_role`, `nombre_rol`, `permiso1`, `permiso2`, `permiso3`, `permiso4`, `permiso5`, `permiso6`, `permiso7`, `permiso8`, `permiso9`, `permiso10`) ";
        $consulta .= "VALUES (NULL, '$nombre', '$permisos[0]', '$permisos[1]', '$permisos[2]', '$permisos[3]', '$permisos[4]', '$permisos[5]', '$permisos[6]', '$permisos[7]', '$permisos[8]', '$permisos[9]')";

        return $this->_sqli->crearConsulta($consulta);
    }

    public function getCodRole($nombre)
    {

        $consulta = "SELECT cod_acl_role from acl_roles where nombre_rol = '$nombre'";

        $resul = $this->_sqli->crearConsulta($consulta)->fila();

        return (is_null($resul) ? false : $resul["cod_acl_role"]);
    }

    public function existeRole($codRole)
    {
        $consulta = "SELECT * from `acl_roles` where cod_acl_role = '$codRole'";

        $resul = $this->_sqli->crearConsulta($consulta)->fila();

        if (is_null($resul))
            return false;

        return true;
    }

    public function getPermisosRole($codRole)
    {
        $consulta = "SELECT `permiso1`, `permiso2`, `permiso3`, `permiso4`, `permiso5`, `permiso6`, `permiso7`, `permiso8`, `permiso9`, `permiso10` FROM `acl_roles` WHERE cod__acl_role = $codRole";

        $resul = $this->_sqli->crearConsulta($consulta)->fila();

        return (is_null($resul) ? false : $resul);
    }


    //Funciones de usuario
    public function anadirUsuario($nick, $nombre, $contrasena, $codRole)
    {
        $consulta = "INSERT INTO  `acl_usuarios` (`nick`,`nombre`,`contrasenna`,`cod_acl_rol`) VALUES ('$nick', '$nombre', MD5('$contrasena'), $codRole)";
        return $this->_sqli->crearConsulta($consulta);
    }

    public function getCodUsuario($nick)
    {
        $consulta = "SELECT `cod_acl_usuario` FROM `acl_usuarios` WHERE `nick` = '$nick'";

        $resul = $this->_sqli->crearConsulta($consulta)->fila();

        return (is_null($resul) ? false : $resul["cod_acl_usuario"]);
    }

    public function existeUsuario($nick)
    {
        if ($this->getCodUsuario($nick) !== false)
            return true;

        return false;
    }

    public function esValido($nick, $contrasena)
    {
        $consulta = "SELECT * FROM `acl_usuarios` WHERE nick = '$nick' and contrasenna = MD5('$contrasena') and borrado = 0 ";

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
        $consulta = "SELECT `permiso1`, `permiso2`, `permiso3`, `permiso4`, `permiso5`, `permiso6`, `permiso7`, `permiso8`, `permiso9`, `permiso10` FROM `dfs_usuarios_roles` WHERE cod_acl_usuario = $codUsuario";

        $resul = $this->_sqli->crearConsulta($consulta)->fila();

        if (is_null($resul))
            return false;

        return $resul;
    }

    public function getNombre($codUsuario)
    {
        $consulta = "SELECT nombre FROM `acl_usuarios` WHERE cod_acl_usuario = $codUsuario";

        $resul = $this->_sqli->crearConsulta($consulta)->fila();

        if (is_null($resul))
            return false;

        return $resul["nombre"];
    }

    public function getBorrado($codUsuario)
    {
        $consulta = "SELECT borrado FROM `acl_usuarios` WHERE cod_acl_usuario = $codUsuario";

        $resul = $this->_sqli->crearConsulta($consulta)->fila();

        if (is_null($resul))
            return false;

        return $resul["borrado"];
    }

    public function getUsuarioRole($codUsuario)
    {
        $consulta = "SELECT `rol` FROM `dfs_usuarios_roles`  WHERE cod_acl_usuario = $codUsuario";

        $resul = $this->_sqli->crearConsulta($consulta)->fila();

        if (is_null($resul))
            return false;

        return $resul["rol"];
    }

    //Setters
    public function setNombre($codUsuario, $nombre)
    {
        $consulta = "UPDATE `acl_usuarios` SET `nombre` = '$nombre' WHERE `cod_acl_usuario` = '$codUsuario'";
        $this->_sqli->crearConsulta($consulta);
    }

    public function setContrasenia($codUsuario, $contra)
    {
        $consulta = "UPDATE `acl_usuarios` SET `contrasenna` = MD5('$contra') WHERE `cod_acl_usuario` = '$codUsuario'";
        $this->_sqli->crearConsulta($consulta);
    }

    public function setBorrado($codUsuario, $borrado)
    {
        $consulta = "UPDATE `acl_usuarios` SET `borrado` = '$borrado' WHERE `cod_acl_usuario` = '$codUsuario'";
        $this->_sqli->crearConsulta($consulta);
    }

    public function setUsuarioRole($codUsuario, $rol)
    {
        $consulta = "UPDATE `dfs_usuarios_roles` SET `cod_acl_rol` = '$rol' WHERE `cod_acl_usuario` = '$codUsuario'";
        $this->_sqli->crearConsulta($consulta);
    }


    //Arrays
    public function dameUsuarios()
    {
        $consulta = "SELECT `cod_acl_usuario`, `nick` from `acl_usuarios` ORDER BY `cod_acl_usuario`";

        $datos = $this->_sqli->crearConsulta($consulta);
        $res = [];

        while ($fila = $datos->filas())
            $res[$fila["cod_acl_usuario"]] = $fila["nick"];

        return $res;
    }

    public function dameRoles()
    {
        $consulta = "SELECT `cod_acl_role`, `nombre_rol` from `acl_roles` ORDER BY `cod_acl_role`";

        $datos = $this->_sqli->crearConsulta($consulta);
        $res = [];

        while ($fila = $datos->filas())
            $res[$fila["cod_acl_role"]] = $fila["nombre_rol"];

        return $res;
    }
}
?>