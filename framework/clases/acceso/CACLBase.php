<?php
abstract class CACLBase {

    //Métodos a redefinir por las clases herederas
    abstract protected function anadirRole($nombre, $permisos=array());

    abstract protected function getCodRole($nombre);

    abstract protected function existeRole($codRole);

    abstract protected function getPermisosRole($codRole);

    abstract protected function anadirUsuario($nif,$contrasena,$codRole);

    abstract protected function getCodUsuario($nif);

    abstract protected function existeUsuario($nif);

    abstract protected function esValido($nif, $contrasena);

    abstract protected function getPermiso($codUsuario,$numero);

    abstract protected function getPermisos($codUsuario);

    abstract protected function getBorrado($codUsuario);

    abstract protected function getUsuarioRole($codUsuario);

    abstract protected function setContrasenia($codUsuario, $contra);

    abstract protected function setBorrado($codUsuario, $borrado);

    abstract protected function setUsuarioRole($codUsuario, $rol);

    abstract protected function dameUsuarios();

    abstract protected function dameRoles();
}
?>