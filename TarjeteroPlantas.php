<?php
class TarjeteroPlantas {
    private $plantas = [];
    
    //El constructor recibe la ruta del archivo de tipo JSON y carga los datos
    public function __construct($rutaJson){
        //Comprueba la existencia del archivo en la ruta dada.
        //De no ser así, manda una excepción
        if(file_exists($rutaJson)){
            //Empieza a leer el contenido del archivo JSON
            $contenido = file_get_contents($rutaJson);
            $this->plantas = json_decode($contenido,true)?? [];
        } else {
            echo "<p class='error'>Error: No se encontró el archivo $rutaJson</p>";
        }
    }

    //Método principal para imprimir todo el contenedor de las tarjetas
    
    public function renderizar(){
        //Comprueba que haya elementos en el arreglo
        //De no ser así, manda mensaje que no hay plantas disponibles.
        if(empty($this->plantas)){ 
            echo "<p>No hay plantas disponibles en esta categoría.</p>";
            return;
        }
        //Empieza a llenar el tarjetero con la información del JSON
        //en este caso el arreglo que ahora contiene las plantas.
        echo '<div class="tarjetero-grid">';
        
        foreach($this->plantas as $planta){
            echo $this->crearTarjeta($planta);
        }
        echo '</div>';
    }

    //Método para mostrar lso colores disponibles de cada planta
    private function generarColores($colores){ 
        //Si no hay colores dentro del arreglo, no regresa nada.
        if (empty($colores))return '';

        //Si tiene 1 color, solo muestra ese único color
        if(count($colores)==1){
            $c = $colores[0];
            $nombreColor = ucfirst(htmlspecialchars($c['nombre']));
            $hex = htmlspecialchars($c['hex']);

            return "
                <span class='color-label'>Tono:</span>
                <div class='color-unico'>
                    <span class='muestra-hex' style='background-color: {$hex};'></span>
                    <span>{$nombreColor}</span>
                </div>
                ";
        }

        //Si tiene más de un color, se arman las muestras visuales y una sub lista
        $muestras = '';
        $itemsLista = '';

        foreach ($colores as $c) {
            $nombreColor = ucfirst(htmlspecialchars($c['nombre']));
            $hex = htmlspecialchars($c['hex']);
            
            $muestras .= "<span class='muestra-hex' style='background-color: {$hex};' title='{$nombreColor}'></span>";
            $itemsLista .= "<li><span class='muestra-hex-mini' style='background-color: {$hex};'></span> {$nombreColor}</li>";
        }

        return <<<HTML
        <details class="sublista-colores">
            <summary>
                <span>Colores disponibles:</span>
                <div class="grupo-muestras">{$muestras}</div>
            </summary>
            <ul class="lista-tonos">
                {$itemsLista}
            </ul>
        </details>
        HTML;

    }
            

    
    //Construcción del HTML individual de cada tarjetero de cada
    //planta
    private function crearTarjeta($planta) {
        $nombre = htmlspecialchars($planta['nombre']);
        $cientifico = htmlspecialchars($planta['nombre_cientifico']);
        $imagen = htmlspecialchars($planta['imagen']);
        $costo = htmlspecialchars($planta['costo']);
        $riego = htmlspecialchars($planta['cuidados']['Riego']);
        $sol = htmlspecialchars($planta['cuidados']['Sol']);
        
        // Generamos la sección de colores (único o sub-lista)
        $htmlColores = $this->generarColores($planta['colores']);

        return <<<HTML
        <article class="tarjeta-planta" id="planta-{$planta['id']}">
            <div class="tarjeta-img-contenedor">
                <img src="{$imagen}" alt="{$nombre}" loading="lazy">
                <span class="tarjeta-costo">{$costo}</span>
            </div>
            
            <div class="tarjeta-cuerpo">
                <h3 class="tarjeta-titulo">{$nombre}</h3>
                <p class="tarjeta-cientifico"><em>{$cientifico}</em></p>
                
                <div class="tarjeta-cuidados">
                    <p><strong>Riego:</strong> {$riego}</p>
                    <p><strong>Sol:</strong> {$sol}</p>
                </div>

                <div class="tarjeta-colores">
                    {$htmlColores}
                </div>
            </div>
        </article>
        HTML;
    }
        
}   

?>