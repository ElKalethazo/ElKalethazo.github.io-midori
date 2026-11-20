<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Interiores de Sol - Midori</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@500;600&family=Cormorant+Garamond:ital,wght@1,500&family=Merienda:wght@500;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../../styles.css">
    </head>

    <body>
        <?php 
            $basePath = '../../';
            include '../../items/header.php'; 
        ?>
        <main>
            <section class="contenido">
                <h2>Interiores de Sol</h2>
                <p>Plantas ideales para espacios dentro de casa con mucha luz natural cerca de una ventana.</p>

                <div class="tarjetero">
                    <div class="tarjeta-planta">
                        <img src="../../images/ficus.jpg" alt="Ficus Lyrata">
                        <h4>Ficus Lyrata</h4>
                        <p>Necesita luz brillante indirecta o sol suave de la mañana. Riego moderado cuando seque la capa superior.</p>
                    </div>

                    <div class="tarjeta-planta">
                        <img src="../../images/sansevieria.jpg" alt="Sansevieria">
                        <h4>Sansevieria</h4>
                        <p>Muy resistente y tolerante al sol filtrado. Requiere poco riego y purifica el aire.</p>
                    </div>

                    <div class="tarjeta-planta">
                        <img src="../../images/ave.jpg" alt="Ave del Paraíso">
                        <h4>Ave del Paraíso</h4>
                        <p>De hojas grandes y tropicales, prospera junto a ventanales bien iluminados.</p>
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>