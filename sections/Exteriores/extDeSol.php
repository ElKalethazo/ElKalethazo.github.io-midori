<?php
    //Llama la clase TarjeteroPlantas
    //Ruta para llegar a la raíz del sitio desde esta carpeta (dos niveles arriba)
    $basePath='../../';
    require_once __DIR__.'/../../TarjeteroPlantas.php';
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Exteriores de Sol - Midori</title>
        <!--Cargar los links de las fuentes a usar.-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@500;600&family=Cormorant+Garamond:ital,wght@1,500&family=Merienda:wght@500;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../../styles.css?v=4">
    </head>

    <body>
        <!--Invoca header.-->
        <?php 
            include __DIR__.'/../../items/header.php'; 
        ?>
        <main>
            <section class="contenido">
                <h2>Exteriores de Sol</h2>
                <p>Plantas resistentes preparadas para recibir sol directo en patios, balcones y jardines.</p>
                
                <!-- Crea el tarjetero con las plantas del archivo JSON de esta categoría y lo imprime -->
                <?php
                    $exteriorSol = new TarjeteroPlantas(__DIR__.'/../../data/ExterioresDeSol.JSON', $basePath);
                    $exteriorSol->renderizar();
                ?>
            </section>
        </main>

        <!--Invoca footer.-->
        <?php include __DIR__.'/../../items/footer.php'; ?>
    </body>
</html>
