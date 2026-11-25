<!-- Llama la clase TarjeteroPlantas -->
<?php require_once 'TarjeteroPlantas';?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Exteriores de Sol - Midori</title>
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
                <h2>Exteriores de Sol</h2>
                <p>Plantas resistentes preparadas para recibir sol directo en patios, balcones y jardines.</p>
                
                    <?php
                        $exteriorSol = new TarjeteroPlantas('data/ExterioresDeSol.JSON');
                        $exteriorSol->renderizar();
                    ?>
            </section>
        </main>
    </body>
</html>