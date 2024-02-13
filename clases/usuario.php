<?php
class Usuario {
    public $nombre;
    public $imagen;

    public function __construct($nombre, $imagen) {
        $this->nombre = $nombre;
        $this->imagen = $imagen;
    }
}
?>