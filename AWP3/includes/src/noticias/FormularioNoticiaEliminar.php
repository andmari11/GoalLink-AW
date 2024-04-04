<?php

namespace es\ucm\fdi\aw\noticias;

use es\ucm\fdi\aw\Aplicacion;
use es\ucm\fdi\aw\Formulario;

class FormularionoticiaEliminar extends Formulario
{
    public function __construct($noticia) {
        parent::__construct('formnoticiaEliminar', [
            'urlRedireccion' => Aplicacion::getInstance()->resuelve('/admin.php')]);
        $this->noticia=$noticia;
    }
    private $noticia;

    protected function generaCamposFormulario(&$datos)
    {
        $camposFormulario = <<<EOS
        <form action="procesarEliminarNoticia.php" method="post"> 
        <input type="hidden" name="id_noticia" value="$this->noticia">

            <button class="enlace" type="submit">$this->noticia  🗑️</button>
        EOS;
        return $camposFormulario;
    }

    /**
     * Procesa los datos del formulario.
     */
    protected function procesaFormulario(&$datos)
    {
        $app = Aplicacion::getInstance();

        $username= htmlspecialchars(trim(strip_tags($datos["id_noticia"])));
        if(($app->usuarioLogueado()) && ($app->esAdmin() or $app->esEditor())){


            if(Noticia::eliminarNoticia($username)){

                echo <<<EOS
                <h2>noticia eliminado: {$username} </h2>
                <b>Volver al <a href="admin.php">panel de administración</a>
                EOS;

                return true;
            }
            else {
        
                echo <<<EOS
                <h2>noticia no eliminado: {$username} </h2>
                <b>Volver al <a href="admin.php">panel de administración</a></b>
                EOS;
            }
        
        }
        else{
        
                
            echo <<<EOS
            <h2>Acceso denegado </h2>
            EOS;
        
        }
    }
}

