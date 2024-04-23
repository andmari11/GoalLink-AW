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
    private $ruta_imagen;
    private $imagen;


    public function __construct($id, $titulo, $descripcion, $fecha, $favoritos, $destacado, $imagen=null)
    {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->fecha = $fecha;
        $this->favoritos = $favoritos;
        $this->destacado = $destacado;
        $this->ruta_imagen = $imagen;
        if($imagen!=null and file_exists($imagen)){
            $this->imagen = file_get_contents($imagen);
        }  

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
            $foro = new Foro($array["id"], $array["titulo"], $array["descripcion"], $array["fecha"], $array["favoritos"], $array["destacado"], $array["imagen"]);
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

                $foro= new Foro($array["id"], $array["titulo"], $array["descripcion"], $array["fecha"], $array["favoritos"], $array["destacado"],  $array["imagen"]);
                $lista[]=$foro;
            }
            usort($lista, array('es\ucm\fdi\aw\foros\Foro', 'compararFechas'));

            return $lista;
            
            
        }
        return NULL;
    }

    public static function listaFavoritos($usuarioId) {

        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        if ($conn->connect_error) {
            die("La conexión ha fallado" . $conn->connect_error);
        }


        $result = $conn->query("SELECT foro_id FROM favoritos_foro WHERE usuario_id ={$app->getUsuarioID()}");
        if($result && $result->num_rows>0){

            while($array=$result->fetch_assoc()){

                $foro= self::getForoById($array['foro_id']);;
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

    public static function insertarForo($titulo, $descripcion, $fecha, $favoritos, $destacado, $imagen=null)
    {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        if ($conn->connect_error) {
            die("La conexión ha fallado: " . $conn->connect_error);
        }
        if($imagen!=null){
            $ruta_destino = "img/foros/" . basename($imagen["name"]);
            if(!move_uploaded_file($imagen["tmp_name"], $ruta_destino)){
                die(error_get_last()['message']);
            }
        }

        $stmt = $conn->prepare("INSERT INTO foro (titulo, descripcion, fecha, favoritos, destacado, imagen) VALUES ('$titulo', '$descripcion', '$fecha', '$favoritos', '$destacado', '$ruta_destino')");

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

        $foro=self::getForoById($foroId);
        if($foro){
            $mensajes=Mensaje::getMensajesForo($foroId);
            if($mensajes){
                foreach($mensajes as $mensaje){
                    Mensaje::eliminarMensaje($mensaje->getId());
                }
            }


            if (file_exists($foro->ruta_imagen)) {
                unlink($foro->ruta_imagen);
            }

            $conn->query("DELETE FROM mensaje WHERE foro_id = $foroId");

            $stmt = $conn->prepare("DELETE FROM foro WHERE id = ?");
            $stmt->bind_param("i", $foroId);
        }
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
                $foro = new Foro($row["id"], $row["titulo"], $row["descripcion"], $row["fecha"], $row["favoritos"], $row["destacado"],  $row["imagen"]);
                $lista[] = $foro;
            }
        }

        return $lista;
    }

    public static function updateForo($id, $titulo, $descripcion, $destacado, $imagen=null)
{
    $app = Aplicacion::getInstance();
    $conn = $app->getConexionBd();

    $foro=self::getForoById($id);
    if($foro){
        if($imagen["tmp_name"]!=NULL){
            if (file_exists($foro->getRutaImagen())) {
                unlink($foro->getRutaImagen());
            }
    
            $ruta_destino = "img/foros/" . basename($imagen["name"]);
            if(!move_uploaded_file($imagen["tmp_name"], $ruta_destino)){
                die(error_get_last()['message']);
            }
            $query = sprintf("UPDATE foro SET titulo = '%s', descripcion = '%s', destacado = %d, imagen='%s' WHERE id = %d",
            $conn->real_escape_string($titulo),
            $conn->real_escape_string($descripcion),
            $destacado,
            $conn->real_escape_string($ruta_destino),
            $id);
        }else{
            
            $query = sprintf("UPDATE foro SET titulo = '%s', descripcion = '%s', destacado = %d WHERE id = %d",
            $conn->real_escape_string($titulo),
            $conn->real_escape_string($descripcion),
            $destacado,
            $id);

        }


        return $conn->query($query);

    }
    
    return false;
}

    public function getMensajes($admin=false){

       
        return Mensaje::getMensajesForo($this->id, $admin);
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
    public function getImagen() {
        return $this->imagen;
    }

    public function getRutaImagen() {
        return $this->ruta_imagen;
    }
}
