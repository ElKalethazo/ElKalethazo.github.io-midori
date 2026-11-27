<?php
    $basePath = '../';
    require_once __DIR__ . '/../buscadorPorColor.php';

    $catalogos = [
        __DIR__ . '/../data/InterioresDeSol.JSON',
        __DIR__ . '/../data/InterioresDeSombra.JSON',
        __DIR__ . '/../data/ExterioresDeSol.JSON',
        __DIR__ . '/../data/ExterioresDeSombra.JSON'
    ];

    $buscador = new BuscadorPorColor($catalogos, $basePath);
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Por color - Midori</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@500;600&family=Cormorant+Garamond:ital,wght@1,500&family=Merienda:wght@500;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../styles.css">
    </head>

    <body>
        <?php include __DIR__ . '/../items/header.php'; ?>
        <main>
            <section class="contenido">
                <h2>Plantas por color</h2>
                <p>¡Escoge el color que buscas y revisa nuestras sugerencias!</p>
                
                <div class="container-color">
                    <input type="color" class="selector-color" id="colorPicker" value="#e63946">
                </div>

                <?php $buscador->renderizarParaFiltro(); ?>
            </section>
        </main>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const colorPicker = document.getElementById('colorPicker');
                const grid = document.getElementById('gridPlantasColor');
                const mensajeVacio = document.getElementById('mensajeSinResultados');
                const tarjetas = Array.from(grid.querySelectorAll('.tarjeta-planta'));

                function hexARgb(hex) {
                    hex = hex.replace('#', '').trim();
                    if (hex.length === 3) {
                        hex = hex.split('').map(c => c + c).join('');
                    }
                    return [
                        parseInt(hex.substring(0, 2), 16),
                        parseInt(hex.substring(2, 4), 16),
                        parseInt(hex.substring(4, 6), 16)
                    ];
                }

                function calcularDistancia(hex1, hex2) {
                    const [r1, g1, b1] = hexARgb(hex1);
                    const [r2, g2, b2] = hexARgb(hex2);
                    return Math.sqrt(
                        Math.pow(r1 - r2, 2) +
                        Math.pow(g1 - g2, 2) +
                        Math.pow(b1 - b2, 2)
                    );
                }

                function filtrarPorColor(tolerancia = 130) {
                    const hexUsuario = colorPicker.value;
                    const coincidentes = [];

                    tarjetas.forEach(tarjeta => {
                        const rawColores = tarjeta.getAttribute('data-colores');
                        if (!rawColores) {
                            tarjeta.style.display = 'none';
                            return;
                        }

                        const listaHex = rawColores.split(',');
                        let menorDistancia = 999;

                        listaHex.forEach(hexPlanta => {
                            const dist = calcularDistancia(hexUsuario, hexPlanta);
                            if (dist < menorDistancia) menorDistancia = dist;
                        });

                        if (menorDistancia <= tolerancia) {
                            coincidentes.push({ elemento: tarjeta, distancia: menorDistancia });
                        } else {
                            tarjeta.style.display = 'none';
                        }
                    });

                    // Ordena del tono más parecido al menos parecido y lo reacomoda en el grid
                    coincidentes.sort((a, b) => a.distancia - b.distancia);
                    coincidentes.forEach(item => {
                        item.elemento.style.display = 'flex';
                        grid.appendChild(item.elemento);
                    });

                    mensajeVacio.style.display = coincidentes.length === 0 ? 'block' : 'none';
                }

                // Se ejecuta al pulsar el botón y también en vivo al mover el selector
                colorPicker.addEventListener('input', () => filtrarPorColor(130));

                // Filtro inicial al cargar la página
                filtrarPorColor(130);
            });
        </script>
    </body>
</html>