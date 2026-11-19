<!-- items/header.php -->
<?php $basePath = $basePath ?? ''; ?>
<header class="header">
    <nav class="nav">
        <ul class="menu">
            <li><a href="<?= $basePath ?>index.php">Nosotros</a></li>
            
            <li class="has-submenu">
                <a href="#">Vivero</a>
                <ul class="sub-menu">
                    <li><a href="<?= $basePath ?>sections/porColor.php">Por color</a></li>
                    
                    <li class="has-submenu">
                        <a href="#" class="submenu-trigger">Interiores</a>
                        <ul class="sub-menu sub-menu-derecha">
                            <li><a href="<?= $basePath ?>sections/Interiores/intDeSol.php">De Sol</a></li>
                            <li><a href="<?= $basePath ?>sections/Interiores/intDeSombra.php">De sombra</a></li>
                        </ul>
                    </li>

                    <li class="has-submenu">
                        <a href="#" class="submenu-trigger">Exteriores</a>
                        <ul class="sub-menu sub-menu-derecha">
                            <li><a href="<?= $basePath ?>sections/Exteriores/extDeSol.php">De Sol</a></li>
                            <li><a href="<?= $basePath ?>sections/Exteriores/extDeSombra.php">De sombra</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li><a href="<?= $basePath ?>ubicacion.php">Ubicación</a></li>
            <li><a href="<?= $basePath ?>contacto.php">Contacto</a></li>
        </ul>
    </nav>
</header>