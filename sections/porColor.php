<?php
    $basePath = '../';
    require_once __DIR__ . '/../BuscadorPorColor.php';

    // Capturamos el color enviado por el usuario (por defecto un verde/rosa inicial)
    $colorSeleccionado = $_GET['color'] ?? '#e63946';

    // Cargamos todos los catálogos JSON disponibles
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
                
                <form method="GET" action="" class="container-color">
                    <input type="color" name="color" class="selector-color" id="colorPicker" value="<?php echo htmlspecialchars($colorSeleccionado); ?>">
                    <button type="submit" class="btn-buscar-color">Buscar tono</button>
                </form>

                <?php
                    // Renderiza las tarjetas más parecidas al color elegido
                    $buscador->buscarYRenderizar($colorSeleccionado, 130);
                ?>
            </section>
        </main>
    </body>
</html>