<?php
abstract class CACLBase {

    //Métodos a redefinir por las clases herederas
    abstract protected function anadirRole($nombre, $permisos=array());

    abstract protected function getCodRole($nombre);

    abstract protected function existeRole($codRole);

    abstract protected function getPermisosRole($codRole);

    abstract protected function anadirUsuario($nombre,$nick,$contrasena,$codRole);

    abstract protected function getCodUsuario($nick);

    abstract protected function existeUsuario($nick);

    abstract protected function esValido($nick, $contrasena);

    abstract protected function getPermiso($codUsuario,$numero);

    abstract protected function getPermisos($codUsuario);

    abstract protected function getNombre($codUsuario);

    abstract protected function getBorrado($codUsuario);

    abstract protected function getUsuarioRole($codUsuario);

    abstract protected function setNombre($codUsuario, $nombre);

    abstract protected function setContrasenia($codUsuario, $contra);

    abstract protected function setBorrado($codUsuario, $borrado);

    abstract protected function setUsuarioRole($codUsuario, $rol);

    abstract protected function dameUsuarios();

    abstract protected function dameRoles();
}
?>