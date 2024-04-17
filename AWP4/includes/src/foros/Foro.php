<?php
namespace es\ucm\fdi\aw\foros;
use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\mensajes\Mensaje;

class Foro
{
    private $id;
    private $titulo;
    private $descripcion;
    private $fecha;
    private $favoritos;
    private $destacado;
    private $mensajes;


    public function __construct($id, $titulo, $descripcion, $fecha, $favoritos, $destacado)
    {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->fecha = $fecha;
        $this->favoritos = $favoritos;
        $this->destacado = $destacado;
    }

    public static function compararFechas($a, $b) {
        $aFecha=strtotime($a->getFecha());
        $bFecha=strtotime($b->getFecha());

        if ($bFecha==$aFecha) {
            return 0;
        }
        return ($aFecha > $bFecha) ? -1 : 1;
    }

    public static function getForoById($id) {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        if ($conn->connect_error) {
            die("La conexión ha fallado" . $conn->connect_error);
        }
    
        $stmt = $conn->prepare("SELECT * FROM foro WHERE id = ?");
        $stmt->bind_param("i", $id); 

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $array = $result->fetch_assoc();
            $foro = new Foro($array["id"], $array["titulo"], $array["descripcion"], $array["fecha"], $array["favoritos"], $array["destacado"]);
            return $foro;
        } else {

            return NULL;
        }
    }
    

    public static function listaDestacados($n) {

        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        if ($conn->connect_error) {
            die("La conexión ha fallado" . $conn->connect_error);
        }


        $result = $conn->query("SELECT * FROM foro WHERE destacado>=$n");
        if($result && $result->num_rows>0){

            while($array=$result->fetch_assoc()){

                $foro= new Foro($array["id"], $array["titulo"], $array["descripcion"], $array["fecha"], $array["favoritos"], $array["destacado"]);
                $lista[]=$foro;
            }
            usort($lista, array('es\ucm\fdi\aw\foros\Foro', 'compararFechas'));

            return $lista;
            
            
        }
        return NULL;
    }

    public function setFavorito($usuarioId){


        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        if ($conn->connect_error) {
            die("La conexión ha fallado" . $conn->connect_error);
        }

        $result = $conn->query("SELECT * FROM favoritos_foro WHERE usuario_id = {$app->getUsuarioID()} AND foro_id = $this->id");

        if ($result && $result->num_rows > 0) {
            $this->favoritos -= 1;
            $conn->query("DELETE FROM favoritos_foro WHERE usuario_id = {$app->getUsuarioID()} AND foro_id = $this->id");

        } else {
            $this->favoritos+=1;
            $conn->query("INSERT INTO favoritos_foro (usuario_id, foro_id) VALUES ({$app->getUsuarioID()}, $this->id)");
        }


        $result=($conn->query("UPDATE foro SET favoritos='$this->favoritos' WHERE id = '$this->id'"));
        return $result;
    }

    public static function insertarForo($titulo, $descripcion, $fecha, $favoritos, $destacado)
    {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        if ($conn->connect_error) {
            die("La conexión ha fallado: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO foro (titulo, descripcion, fecha, favoritos, destacado) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssii", $titulo, $descripcion, $fecha, $favoritos, $destacado);

        if ($stmt->execute()) {
            return $stmt->insert_id; // Devuelve el ID del nuevo foro insertado
        } else {
            return false;
        }
    }

    public static function eliminarForo($foroId)
    {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        if ($conn->connect_error) {
            die("La conexión ha fallado: " . $conn->connect_error);
        }
        $mensajes=Mensaje::getMensajesForo($foroId);

        foreach($mensajes as $mensaje){
            Mensaje::eliminarMensaje($mensaje->getId());
        }

        $conn->query("DELETE FROM mensaje WHERE foro_id = $foroId");

        $stmt = $conn->prepare("DELETE FROM foro WHERE id = ?");
        $stmt->bind_param("i", $foroId);

        return $stmt->execute();
    }

    public static function listaForos()
    {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        if ($conn->connect_error) {
            die("La conexión ha fallado: " . $conn->connect_error);
        }

        $lista = array();
        $result = $conn->query("SELECT * FROM foro");
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $foro = new Foro($row["id"], $row["titulo"], $row["descripcion"], $row["fecha"], $row["favoritos"], $row["destacado"]);
                $lista[] = $foro;
            }
        }

        return $lista;
    }

    public static function updateForo($id, $titulo, $descripcion, $destacado)
{
    $app = Aplicacion::getInstance();
    $conn = $app->getConexionBd();
    
    $query = sprintf("UPDATE foro SET titulo = '%s', descripcion = '%s', destacado = %d WHERE id = %d",
        $conn->real_escape_string($titulo),
        $conn->real_escape_string($descripcion),
        $destacado,
        $id);

    return $conn->query($query);
}

    public function getMensajes(){

       
        return Mensaje::getMensajesForo($this->id);;
    }


    public function getId()
    {
        return $this->id;
    }

    public function getTitulo()
    {
        return $this->titulo;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function getfavoritos()
    {
        return $this->favoritos;
    }

    public function getDestacado()
    {
        return $this->destacado;
    }

    public function getMensajesNum(){
        
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        if ($conn->connect_error) {
            die("La conexión ha fallado" . $conn->connect_error);
        }

        $result=$conn->query("SELECT COUNT(*) FROM mensaje WHERE foro_id='$this->id'");

        if($result){

            $ret = $result->fetch_row();
            return $ret[0];
        }

        return 0;
    }
}
