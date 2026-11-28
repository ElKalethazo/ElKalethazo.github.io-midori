<?php
    //Empieza a cargar todos los recursos necesarios de JSON
    //Ruta para llegar a la raíz del sitio desde esta carpeta (un nivel arriba)
    $basePath = '../';
    require_once __DIR__ . '/../buscadorPorColor.php';

    //Lista de los archivos JSON (catálogos) que se combinan en una sola búsqueda
    $catalogos = [
        __DIR__ . '/../data/InterioresDeSol.JSON',
        __DIR__ . '/../data/InterioresDeSombra.JSON',
        __DIR__ . '/../data/ExterioresDeSol.JSON',
        __DIR__ . '/../data/ExterioresDeSombra.JSON'
    ];

    //Invoca el objeto que funcionará como filtro.
    $buscador = new BuscadorPorColor($catalogos, $basePath);
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Por color - Midori</title>
        <!--Cargar los links de las fuentes a usar.-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@500;600&family=Cormorant+Garamond:ital,wght@1,500&family=Merienda:wght@500;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../styles.css?v=4">
    </head>

    <body>
        <!--Invoca header.-->
        <?php include __DIR__ . '/../items/header.php'; ?>
        <main>
            <section class="contenido">
                <h2>Plantas por color</h2>
                <p>¡Escoge el color que buscas y revisa nuestras sugerencias!</p>
                
                <!-- Selector de color: al cambiarlo, el script de abajo filtra las tarjetas -->
                <div class="container-color">
                    <input type="color" class="selector-color" id="colorPicker" value="#e63946">
                </div>

                <!-- Imprime todas las tarjetas del catálogo (el script decide cuáles se muestran) -->
                <?php $buscador->renderizarParaFiltro(); ?>
            </section>
        </main>

        <!--Invoca footer.-->
        <?php include __DIR__ . '/../items/footer.php'; ?>

        <script>
            //Añade el eventlistener para llamar a la clase
            //(espera a que la página termine de cargar para poder encontrar los elementos)
            document.addEventListener('DOMContentLoaded', () => {
                const colorPicker = document.getElementById('colorPicker');//Reacciona al mismo tiempo que se modifica el color del selector
                const grid = document.getElementById('gridPlantasColor');
                const mensajeVacio = document.getElementById('mensajeSinResultados');

                //Si el catálogo está vacío PHP no imprime el contenedor de tarjetas;
                //en ese caso se detiene aquí para evitar errores de JavaScript.
                if (!colorPicker || !grid || !mensajeVacio) return;

                const tarjetas = Array.from(grid.querySelectorAll('.tarjeta-planta'));

                //Convierte un color en formato hexadecimal a un arreglo RGB
                function hexARgb(hex) {
                    //Quita el símbolo # y los espacios
                    hex = hex.replace('#', '').trim();
                    //Si el código es corto (ej. "f00"), lo expande a su forma completa ("ff0000")
                    if (hex.length === 3) {
                        hex = hex.split('').map(c => c + c).join('');
                    }
                    //Cada par de letras representa rojo, verde y azul; se pasan de base 16 a número
                    return [
                        parseInt(hex.substring(0, 2), 16),
                        parseInt(hex.substring(2, 4), 16),
                        parseInt(hex.substring(4, 6), 16)
                    ];
                }

                //Calcula qué tan parecidos son los dos colores mediante su distancia
                //Al acercarse a 0, determina que los dos colores son casi identicos
                function calcularDistancia(hex1, hex2) {
                    const [r1, g1, b1] = hexARgb(hex1);
                    const [r2, g2, b2] = hexARgb(hex2);
                    //Distancia entre dos puntos en el espacio de color RGB (fórmula de distancia euclidiana)
                    return Math.sqrt(
                        Math.pow(r1 - r2, 2) +
                        Math.pow(g1 - g2, 2) +
                        Math.pow(b1 - b2, 2)
                    );
                }

                /*Filtra y ordena las tarjetas de plantas según su similitud con el color seleccionado. */
                function filtrarPorColor(tolerancia = 130) {
                    //Obtiene el color seleccionado
                    const hexUsuario = colorPicker.value;
                    //Arreglo temporal para guardar las tarjetas que pasen en el filtro jumto
                    //con su puntaje
                    const coincidentes = [];

                    tarjetas.forEach(tarjeta => {
                        //Lee unicamente los colores de data-colors 
                        const rawColores = tarjeta.getAttribute('data-colores');
                        //Si la tarjeta no tiene colores asignados, se oculta y pasa a la siguiente
                        if (!rawColores) {
                            tarjeta.style.display = 'none';
                            return;
                        }

                        //Separa los distintos codigos que una planta puede tener
                        const listaHex = rawColores.split(','); 
                        let menorDistancia = 999;
                        //Compara el color del usuario contra cada color de la planta y guarda la menor diferencia
                        listaHex.forEach(hexPlanta => {
                            const dist = calcularDistancia(hexUsuario, hexPlanta);
                            if (dist < menorDistancia) menorDistancia = dist;
                        });

                        //Si el color más cercano de la planta entra en el margen de tolerancia, se guarda
                        if (menorDistancia <= tolerancia) {
                            coincidentes.push({ elemento: tarjeta, distancia: menorDistancia });
                        } else {
                            //Sino, se oculta la tarjeta
                            tarjeta.style.display = 'none';
                        }
                    });

                    // Ordena del tono más parecido al menos parecido y lo reacomoda en el grid
                    coincidentes.sort((a, b) => a.distancia - b.distancia);
                    coincidentes.forEach(item => {
                        item.elemento.style.display = 'flex';
                        grid.appendChild(item.elemento);
                    });

                    //Muestra el aviso de "sin resultados" solo cuando ninguna planta coincidió
                    mensajeVacio.style.display = coincidentes.length === 0 ? 'block' : 'none';
                }

                // Se ejecuta en vivo al mover el selector
                colorPicker.addEventListener('input', () => filtrarPorColor(130));

                // Filtro inicial al cargar la página
                filtrarPorColor(130);
            });
        </script>
    </body>
</html>
