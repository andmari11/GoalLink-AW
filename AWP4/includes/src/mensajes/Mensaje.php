<?php

namespace es\ucm\fdi\aw\mensajes;

use es\ucm\fdi\aw\Aplicacion;

class Mensaje
{
    private $id;
    private $foro_id;
    private $usuario_id;
    private $text;
    private $fecha;
    private $hora;
    private $likes;

    public function __construct($id, $foro_id, $usuario_id, $text, $fecha, $hora, $likes)
    {
        $this->id = $id;
        $this->foro_id = $foro_id;
        $this->usuario_id = $usuario_id;
        $this->text = $text;
        $this->fecha = $fecha;
        $this->hora = $hora;
        $this->likes = $likes;
    }
    public static function compararFechasHora($a, $b){

        $aFechaHora = strtotime($a->getFecha() . ' ' . $a->getHora());
        $bFechaHora = strtotime($b->getFecha() . ' ' . $b->getHora());

        if ($bFechaHora == $aFechaHora) {
            return 0;
        }
        return ($aFechaHora > $bFechaHora) ? 1 : -1;
    }

    public static function insertarMensaje($foro_id, $usuario_id, $text, $fecha, $hora, $likes){

        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();        
        if ($conn->connect_error) {
            die("Error en la conexión a la base de datos: " . $conn->connect_error);
        }


        $text = $conn->real_escape_string($text);
        $fecha = $conn->real_escape_string($fecha);
        $hora = $conn->real_escape_string($hora);
        $likes = $conn->real_escape_string($likes);

        if ($conn->query("INSERT INTO mensaje (foro_id, usuario_id, text, fecha, hora, likes) 
              VALUES ('$foro_id', '$usuario_id', '$text', '$fecha', '$hora', '$likes')")) 
        {
            return true;
        } else {
            die ("Mensaje: " . $conn->error);
        }
    }

    public static function getMensajesForo($id){

        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        if ($conn->connect_error) {
            die("La conexión ha fallado" . $conn->connect_error);
        }


        $result = $conn->query("SELECT * FROM mensaje WHERE foro_id='$id'");
        if($result && $result->num_rows>0){

            while($array=$result->fetch_assoc()){

                $mensajes= new Mensaje($array["id"], $array["foro_id"], $array["usuario_id"],$array["text"], $array["fecha"], $array["hora"], $array["likes"]);
                $lista[]=$mensajes;
            }
            usort($lista, array('es\ucm\fdi\aw\mensajes\Mensaje', 'compararFechasHora'));

            return $lista;
            
            
        }
        return NULL;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getForoId()
    {
        return $this->foro_id;
    }

    public function getUsuarioId()
    {
        return $this->usuario_id;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function getHora()
    {
        return $this->hora;
    }

    public function getLikes()
    {
        return $this->likes;
    }
}
?>
