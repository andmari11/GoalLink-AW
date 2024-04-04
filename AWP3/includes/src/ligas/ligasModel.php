<?php
namespace es\ucm\fdi\aw\ligas;

use es\ucm\fdi\aw\Aplicacion;

class Liga
{
    private $nombre;
    private $logo;

    public function __construct($nombre, $logo = NULL)
    {
        $this->nombre = $nombre;
        $this->logo = $logo;
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

    public static function LogoLiga($liga)
    {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        if ($conn->connect_error) {
            die("Error en la conexión a la base de datos: " . $conn->connect_error);
        }

        $result = $conn->query("SELECT logo FROM ligas WHERE nombre = '$liga'");

        if ($result->num_rows > 0) {
            // Si hay resultados, devolvemos el logo de la liga
            $row = $result->fetch_assoc();
            return $row['logo'];
        } else {
            // Si no hay resultados, devolvemos null o algún valor por defecto
            return null;
        }
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

        $nombreLiga = $conn->real_escape_string($nombre); 
        $sql = "INSERT INTO ligas (nombre, logo) VALUES ('$nombreLiga', '$logo')";
        $result = $conn->query($sql);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
?>
