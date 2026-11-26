<!-- Llama la clase TarjeteroPlantas -->
<?php
    $basePath='../../';
    require_once __DIR__.'/../../TarjeteroPlantas.php';
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Interiores de Sombra - Midori</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@500;600&family=Cormorant+Garamond:ital,wght@1,500&family=Merienda:wght@500;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../../styles.css">
    </head>

    <body>
        <?php 
            include __DIR__.'../../items/header.php'; 
        ?>
        <main>
            <section class="contenido">
                <h2>Interiores de Sombra</h2>
                <p>Especies que se adaptan perfectamente a habitaciones o rincones con poca luz directa.</p>
                    <?php
                        $interiorSombra = new TarjeteroPlantas(__DIR__.'/../../data/InterioresDeSombra.JSON', $basePath);
                        $interiorSombra->renderizar();
                    ?>
            </section>
        </main>
    </body>
</html>