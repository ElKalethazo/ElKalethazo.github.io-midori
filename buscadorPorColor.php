<?php
require_once __DIR__ . '/TarjeteroPlantas.php';

class BuscadorPorColor extends TarjeteroPlantas {
    private $todasLasPlantas = [];

    // Recibe un arreglo con las rutas de todos tus JSON (Exteriores e Interiores)
    public function __construct(array $rutasJson, $basePath = '') {
        // Llamamos al constructor padre con vacío para manejar nosotros múltiples JSON
        parent::__construct('', $basePath);

        foreach ($rutasJson as $ruta) {
            if (file_exists($ruta)) {
                $contenido = file_get_contents($ruta);
                $datos = json_decode($contenido, true) ?? [];
                // Unimos todas las plantas en un solo catálogo general
                $this->todasLasPlantas = array_merge($this->todasLasPlantas, $datos);
            }
        }
    }

    // Convierte un código HEX (#RRGGBB) a un arreglo [R, G, B]
    private function hexARgb($hex) {
        $hex = ltrim(trim($hex), '#');
        if (strlen($hex) === 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }
        return [
            hexdec(substr($hex, 0, 2)),
            hexdec(substr($hex, 2, 2)),
            hexdec(substr($hex, 4, 2))
        ];
    }

    // Calcula qué tan parecidos son dos colores (0 = idénticos, 441 = opuestos)
    private function calcularDistanciaColor($hex1, $hex2) {
        [$r1, $g1, $b1] = $this->hexARgb($hex1);
        [$r2, $g2, $b2] = $this->hexARgb($hex2);

        return sqrt(
            pow($r1 - $r2, 2) +
            pow($g1 - $g2, 2) +
            pow($b1 - $b2, 2)
        );
    }

    /**
     * Filtra y ordena las plantas cuyo color sea más parecido al seleccionado.
     * $tolerancia: rango de parecido (120 es ideal para agrupar tonos de un mismo color)
     */
    public function buscarYRenderizar($hexUsuario, $tolerancia = 120) {
        $resultados = [];

        foreach ($this->todasLasPlantas as $planta) {
            if (empty($planta['colores'])) continue;

            $menorDistancia = 999;
            $tonoMasCercano = '';

            // Revisamos todos los tonos que tiene esa planta en el JSON
            foreach ($planta['colores'] as $colorPlanta) {
                if (empty($colorPlanta['hex'])) continue;

                $distancia = $this->calcularDistanciaColor($hexUsuario, $colorPlanta['hex']);
                if ($distancia < $menorDistancia) {
                    $menorDistancia = $distancia;
                    $tonoMasCercano = $colorPlanta['nombre'];
                }
            }

            // Si el tono más cercano entra dentro de la tolerancia, guardamos la planta
            if ($menorDistancia <= $tolerancia) {
                $planta['_distancia'] = $menorDistancia;
                $planta['_tono_coincidente'] = $tonoMasCercano;
                $resultados[] = $planta;
            }
        }

        // Ordenamos los resultados del tono MÁS parecido al menos parecido
        usort($resultados, function($a, $b) {
            return $a['_distancia'] <=> $b['_distancia'];
        });

        // Si no hubo coincidencias dentro de la tolerancia
        if (empty($resultados)) {
            echo "<p>No encontramos plantas con un tono muy parecido a <strong>" . htmlspecialchars($hexUsuario) . "</strong>. Intenta con otro matiz.</p>";
            return;
        }

        // Reutilizamos el método crearTarjeta() de TarjeteroPlantas
        echo '<div class="tarjetero-grid">';
        foreach ($resultados as $planta) {
            echo $this->crearTarjeta($planta);
        }
        echo '</div>';
    }
}
?>