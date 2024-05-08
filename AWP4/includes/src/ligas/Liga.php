<?php
namespace es\ucm\fdi\aw\ligas;
use es\ucm\fdi\aw\noticias\Noticia;
use es\ucm\fdi\aw\Aplicacion;

class Liga
{
    private $nombre;
    private $logo;
    private $ruta_logo;

    public function __construct($nombre, $logo = NULL)
    {
        $this->nombre = $nombre;
        $this->ruta_logo=$logo;
        if($logo!=null and file_exists($logo)){

            $this->logo = file_get_contents($logo);
        }
        if ($this->logo === FALSE) {
            die("Error al leer el archivo de imagen.");
        }
    }

    public static function listaLigas()
    {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        if ($conn->connect_error) {
            die("La conexión ha fallado" . $conn->connect_error);
        }

        $result = $conn->query("SELECT * FROM ligas");
        if ($result && $result->num_rows > 0) {
            $lista = array(); // Inicializamos el array de ligas
            while ($array = $result->fetch_assoc()) {

                $liga = new Liga($array["nombre"], $array["logo"]);
                $lista[] = $liga;
            }
            return $lista;
        }

        return NULL;
    }

    public static function getLigaByName($liga){
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        if ($conn->connect_error) {
            die("Error en la conexión a la base de datos: " . $conn->connect_error);
        }
        $result = $conn->query("SELECT nombre, logo FROM ligas WHERE nombre = '$liga'");
        if ($result->num_rows > 0) {
            // Si hay resultados, devolvemos el logo de la liga
            $row = $result->fetch_assoc();
            return new Liga($row['nombre'], $row['logo']);
        }  
            // Si no hay resultados, devolvemos null o algún valor por defecto
            return null;
        
    }

    public static function LogoLiga($nombre)
    {

        $liga= self::getLigaByName($nombre);
        if(!$liga){
            return null;
        }

        return $liga->getLogo();
    }
    public function getRutaImg()
    {
        return $this->ruta_logo;
    }
    public function getNombre()
    {
        return $this->nombre;
    }

    public function getLogo()
    {
        return $this->logo;
    }

    // Método para eliminar una liga
    public static function delete($nombreLiga)
    {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        if ($conn->connect_error) {
            die("Error en la conexión a la base de datos: " . $conn->connect_error);
        }
        $liga=self::getLigaByName($nombreLiga);
        if (file_exists($liga->getRutaImg())) {
            unlink($liga->getRutaImg());
        }

        Noticia::deleteListaLigas($nombreLiga);

        $sql = "DELETE FROM ligas WHERE nombre = '$nombreLiga'";
        $result = $conn->query($sql);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public static function add($nombre, $logo = NULL)
    {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        if ($conn->connect_error) {
            die("Error en la conexión a la base de datos: " . $conn->connect_error);
        }

        $ruta_destino = "img/ligas/" . basename($logo["name"]);

        if(!move_uploaded_file($logo["tmp_name"], $ruta_destino)){
            die(error_get_last()['message']);
        }

        $nombreLiga = htmlspecialchars(trim(strip_tags($nombre))); 
        $sql = "INSERT INTO ligas (nombre, logo) VALUES ('$nombreLiga', '$ruta_destino')";
        $result = $conn->query($sql);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
?>
