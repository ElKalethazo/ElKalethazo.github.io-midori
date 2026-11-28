<?php
    //Ruta para llegar a la raíz del sitio. Está vacía porque esta página ya está en la raíz.
    $basePath = '';
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ubicación - Midori</title>
        <!--Cargar los links de las fuentes a usar.-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@500;600&family=Cormorant+Garamond:ital,wght@1,500&family=Merienda:wght@500;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="styles.css?v=4">
    </head>

    <body>
        <!--Invoca header.-->
        <?php include __DIR__ . '/items/header.php'; ?>
        <main>
            <section class="contenido">
                <h2>Nuestra ubicación</h2>
                <p>Visítanos en nuestro vivero y conoce de cerca todas nuestras especies de interior, exterior y colección por color.</p>

                <!-- Mapa incrustado de Google Maps (la clase "maps" le da su tamaño y estilo desde styles.css) -->
                <iframe class="maps" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3771.480086434056!2d-98.30417412520829!3d19.04261838215524!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85cfc7d1627fe033%3A0x8f88234fa92114da!2sJard%C3%ADn%20Etnobot%C3%A1nico%20Francisco%20Pel%C3%A1ez%20Roldan!5e0!3m2!1ses-419!2smx!4v1795705750652!5m2!1ses-419!2smx" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin" title="Mapa de ubicación de Midori"></iframe>
                
                <h4>Horario de visitas</h4>
                <p>Lunes a sábado de 9:00 a.m. a 6:00 p.m.</p>
            </section>
        </main>

        <!--Invoca footer.-->
        <?php include __DIR__ . '/items/footer.php'; ?>
    </body>
</html>
