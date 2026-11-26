<?php
require_once __DIR__ . '/TarjeteroPlantas.php';

class BuscadorPorColor extends TarjeteroPlantas {
    private $todasLasPlantas = [];

    public function __construct(array $rutasJson, $basePath = '') {
        parent::__construct('', $basePath);

        foreach ($rutasJson as $ruta) {
            if (file_exists($ruta)) {
                $contenido = file_get_contents($ruta);
                $datos = json_decode($contenido, true) ?? [];
                $this->todasLasPlantas = array_merge($this->todasLasPlantas, $datos);
            }
        }
    }

    public function renderizarParaFiltro() {
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