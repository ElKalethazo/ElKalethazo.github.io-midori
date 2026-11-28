<?php
    //Ruta para llegar a la raíz del sitio. Está vacía porque esta página ya está en la raíz.
    $basePath = '';
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Contacto - Midori</title>
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
                <h2>Contáctanos</h2>
                <p>¿Tienes dudas sobre el cuidado de alguna planta o buscas una especie en particular? Escríbenos y con gusto te asesoramos.</p>
                
                <!-- Tarjeta con el logotipo y los datos de contacto -->
                <div class="contacto-tarjeta">
                    <img class="avatar" src="images/principal/Logo-midori.png" alt="Logotipo de Midori">

                    <div class="contacto-bloque">
                        <h4>Horario de atención</h4>
                        <p>Lunes a sábado de 9:00 a.m. a 6:00 p.m.</p>
                    </div>

                    <div class="contacto-bloque">
                        <h4>Medios de contacto</h4>
                        <p>
                            Correo: 
                            <a>contacto@midoricasabotanica.com</a>
                        </p>
                        <p>
                            Teléfono / WhatsApp: 
                            <a>+52 222 000 0000</a>
                        </p>
                    </div>
                </div>
            </section>
        </main>

        <!--Invoca footer.-->
        <?php include __DIR__ . '/items/footer.php'; ?>
    </body>
</html>
