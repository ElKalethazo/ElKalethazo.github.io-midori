<?php
//Carga la clase base de la que hereda esta clase
require_once __DIR__ . '/TarjeteroPlantas.php';
//Clase encargada de buscar el color ingresado por la barra crómatica y lo relaciona con los colores existentes,
//mostrando a su vez la tarjeta de cada planta
class BuscadorPorColor extends TarjeteroPlantas {
    //Hereda las funciones de TarjeteroPlantas para "imprimir" sus resultados, mostrando
    //todo el tarjetero

    //Arreglo que almacena a todas las plantas en los JSON
    private $todasLasPlantas = [];

    //Construye el arreglo todasLasPlantas y los rellena con la información del JSON
    public function __construct(array $rutasJson, $basePath = '') {
        //Llama al constructor de la clase padre sin ruta: los datos se cargan aquí abajo, desde varios archivos
        parent::__construct('', $basePath);

        //Bucle foreach que recorre cada elemento del JSON y lo almacena en el array
        foreach ($rutasJson as $ruta) {
            //cargarJson (heredado) lee el archivo y avisa con un error claro si falta o está mal escrito
            $datos = $this->cargarJson($ruta);
            //Une las plantas de este archivo con las que ya estaban guardadas
            $this->todasLasPlantas = array_merge($this->todasLasPlantas, $datos);
        }
    }
    
    //Imprime todas las tarjetas del catálogo en un solo contenedor, listas para que el filtro
    //de JavaScript las muestre, oculte y ordene según el color elegido.
    public function renderizarParaFiltro() {
        //Si el arreglo está vacío, devuelve una alerta notificandolo.
        if (empty($this->todasLasPlantas)) {
            echo "<p>No hay plantas disponibles en el catálogo.</p>";
            return;
        }

        echo '<div class="tarjetero-grid" id="gridPlantasColor">';
        foreach ($this->todasLasPlantas as $planta) {
            // Extraemos todos los códigos hex de la planta separados por coma
            $hexes = [];
            if (!empty($planta['colores'])) {
                foreach ($planta['colores'] as $c) {
                    if (!empty($c['hex'])) {
                        $hexes[] = trim($c['hex']);
                    }
                }
            }
            $attrColores = htmlspecialchars(implode(',', $hexes), ENT_QUOTES, 'UTF-8');

            // Obtenemos el HTML original de la tarjeta e inyectamos data-colores
            // (se envía como atributo extra para que la tarjeta lo incluya en su etiqueta <article>)
            echo $this->crearTarjeta($planta, ' data-colores="' . $attrColores . '"');
        }
        echo '</div>';
        //Mensaje que el filtro de JavaScript muestra cuando ninguna planta coincide con el color
        echo '<p id="mensajeSinResultados" style="display:none;">No encontramos plantas con un tono muy parecido. Intenta con otro matiz.</p>';
    }
}
//Nota: se omite la etiqueta de cierre de PHP para evitar salidas accidentales al final del archivo.
