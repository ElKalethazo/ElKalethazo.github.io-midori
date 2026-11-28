<?php
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
        parent::__construct('', $basePath);

        //Bucle foreach que recorre cada elemento del JSON y lo almacena en el array
        foreach ($rutasJson as $ruta) {
            if (file_exists($ruta)) {
                $contenido = file_get_contents($ruta);
                $datos = json_decode($contenido, true) ?? [];
                $this->todasLasPlantas = array_merge($this->todasLasPlantas, $datos);
            }
        }
    }
    
    //
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
            $attrColores = htmlspecialchars(implode(',', $hexes));

            // Obtenemos el HTML original de la tarjeta e inyectamos data-colores
            $tarjetaHtml = $this->crearTarjeta($planta);
            $tarjetaHtml = preg_replace(
                '/^<article class="tarjeta-planta"/',
                '<article class="tarjeta-planta" data-colores="' . $attrColores . '"',
                trim($tarjetaHtml)
            );

            echo $tarjetaHtml;
        }
        echo '</div>';
        echo '<p id="mensajeSinResultados" style="display:none;">No encontramos plantas con un tono muy parecido. Intenta con otro matiz.</p>';
    }
}
?>