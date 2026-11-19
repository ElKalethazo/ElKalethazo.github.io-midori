<!-- header.php -->
<?php $ruta = $ruta ?? ''; ?>
<header class="header">
    <nav class="nav">
        <ul class="menu">
            <li><a href="<?= $ruta ?>index.php">Nosotros</a></li>
            
            <li class="has-submenu">
                <a href="#">Vivero</a>
                <ul class="sub-menu">
                    <li><a href="<?= $ruta ?>sections/porColor.php">Por color</a></li>
                    
                    <li class="has-submenu">
                        <a href="#" class="submenu-trigger">Interiores</a>
                        <ul class="sub-menu sub-menu-derecha">
                            <li><a href="<?= $ruta ?>sections/Interiores/intDeSol.php">De Sol</a></li>
                            <li><a href="<?= $ruta ?>sections/Interiores/intDeSombra.php">De sombra</a></li>
                        </ul>
                    </li>

                    <li class="has-submenu">
                        <a href="#" class="submenu-trigger">Exteriores</a>
                        <ul class="sub-menu sub-menu-derecha">
                            <li><a href="<?= $ruta ?>sections/Exteriores/extDeSol.php">De Sol</a></li>
                            <li><a href="<?= $ruta ?>sections/Exteriores/extDeSombra.php">De sombra</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li><a href="<?= $ruta ?>ubicacion.php">Ubicación</a></li>
            <li><a href="<?= $ruta ?>contacto.php">Contacto</a></li>
        </ul>
    </nav>
</header>