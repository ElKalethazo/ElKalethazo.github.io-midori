<?php
//Clase reutilizable que construye "tarjetas" en HTML a partir de una lista de elementos guardada en un archivo JSON.
class TarjeteroPlantas {
    //Arreglo con los elementos (plantas) que se van a mostrar
    private $plantas = [];
    //Prefijo de ruta para llegar a la raíz del sitio desde la página que usa la clase (ej. '../../')
    private $basePath;
    
    //El constructor recibe la ruta del archivo de tipo JSON y carga los datos
    public function __construct($rutaJson, $basePath = ''){
        $this->basePath = $basePath;
        //Solo carga los datos si se indicó una ruta.
        //Las clases hijas pueden enviar '' para cargar sus propios datos.
        if($rutaJson !== ''){
            $this->plantas = $this->cargarJson($rutaJson);
        }
    }

    //Lee un archivo JSON y lo convierte en un arreglo de PHP.
    //Está separado del constructor para poder reutilizarlo en las clases hijas.
    protected function cargarJson($rutaJson){
        //Comprueba la existencia del archivo en la ruta dada.
        //De no ser así, manda una excepción
        if(!file_exists($rutaJson)){
            throw new RuntimeException("No se encontró el archivo JSON: {$rutaJson}");
        }
        //Empieza a leer el contenido del archivo JSON
        $contenido = file_get_contents($rutaJson);
        if($contenido === false){
            throw new RuntimeException("No se pudo leer el archivo JSON: {$rutaJson}");
        }
        //Elimina la marca BOM (caracteres invisibles al inicio) que algunos editores agregan y que impide leer el JSON
        $contenido = preg_replace('/^\xEF\xBB\xBF/', '', $contenido);

        //Convierte el texto JSON en un arreglo asociativo
        $datos = json_decode($contenido, true);
        //Si el JSON está mal escrito no se obtiene un arreglo, así que se avisa con un mensaje claro
        if(!is_array($datos)){
            throw new RuntimeException("El archivo JSON no es válido: {$rutaJson} (" . json_last_error_msg() . ")");
        }
        return $datos;
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
        
        //Recorre el arreglo para crear los trajeteros planta por planta con foreach
        foreach($this->plantas as $planta){
            echo $this->crearTarjeta($planta);
        }
        echo '</div>';
    }

    //Prepara un texto para mostrarlo de forma segura en HTML.
    //Si el dato no existe devuelve texto vacío, así se evitan avisos de "clave no definida".
    private function limpiar($valor){
        return htmlspecialchars((string)($valor ?? ''), ENT_QUOTES, 'UTF-8');
    }

    //Método para mostrar los colores disponibles de cada planta
    private function generarColores($colores){ 
        //Si no hay colores dentro del arreglo, no regresa nada.
        if (empty($colores))return '';

        //Reinicia los índices (0, 1, 2...) para poder acceder al primer color sin importar cómo vengan en el JSON
        $colores = array_values($colores);

        //Si tiene 1 color, solo muestra ese único color
        if(count($colores)==1){
            $c = $colores[0];
            $nombreColor = ucfirst($this->limpiar($c['nombre'] ?? ''));
            $hex = $this->limpiar($c['hex'] ?? '');

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
            $nombreColor = ucfirst($this->limpiar($c['nombre'] ?? ''));
            $hex = $this->limpiar($c['hex'] ?? '');
            
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
    //planta.
    //$atributosExtra permite a las clases hijas agregar atributos a la etiqueta <article>
    //(por ejemplo ' data-colores="..."'). Debe empezar con un espacio.
    protected function crearTarjeta($planta, $atributosExtra = '') {
        //Cada dato se limpia y, si falta en el JSON, queda vacío en lugar de provocar un error
        $id = $this->limpiar($planta['id'] ?? '');
        $nombre = $this->limpiar($planta['nombre'] ?? '');
        $cientifico = $this->limpiar($planta['nombre_cientifico'] ?? '');
        $imagen = $this->limpiar($this->basePath . ($planta['imagen'] ?? ''));
        $costo = $this->limpiar($planta['costo'] ?? '');
        $riego = $this->limpiar($planta['cuidados']['Riego'] ?? '');
        $sol = $this->limpiar($planta['cuidados']['Sol'] ?? '');
        
        // Generamos la sección de colores (único o sub-lista)
        $htmlColores = $this->generarColores($planta['colores'] ?? []);

        return <<<HTML
        <article class="tarjeta-planta" id="planta-{$id}"{$atributosExtra}>
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
//Nota: en archivos que solo contienen clases se omite la etiqueta de cierre de PHP,
//así se evita que espacios o saltos de línea al final se impriman por accidente.
