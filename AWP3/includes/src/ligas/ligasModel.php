<?php
namespace es\ucm\fdi\aw\ligas;
use es\ucm\fdi\aw\Aplicacion;
class Liga
{
    private $nombre;
    private $logo;


    public function __construct($nombre, $logo=NULL)
    {
        $this->nombre=$nombre;
        $this->logo=$logo;

    }

    public static function listaLigas() {
        $app = Aplicacion::getInstance();
        $conn = $app->getConexionBd();
        if ($conn->connect_error){
            die("La conexión ha fallado" . $conn->connect_error);
        }

        $result = $conn->query("SELECT * FROM ligas");
        if($result && $result->num_rows>0){

            while($array=$result->fetch_assoc()){
                $liga= new Liga($array["nombre"], $array["logo"]);
                $lista[]=$liga;
            }

            return $lista;   
        }
        
        return NULL;
    }

    public function getNombre()
    {
        return $this->nombre;
    }
    public function getLogo()
    {
        return $this->logo;
    }
    
}


