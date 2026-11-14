<?php
require_once "funciones.php";
cabecera("Candy");?>

<h1>Candy CineCentro</h1>
<p class="intro">Disfrutá tus películas con nuestros productos y combos.</p>

<div class="grilla">

    <div class="tarjeta">
        <img src="imagenes/pochoclos.jpg?v=2" alt="Pochoclos"  class="poster candy-img">
        <h2>Pochoclos</h2>
        <p>Clásicos pochoclos salados.</p>
        <p class="precio">$5.000</p>
        <?php if (isset($_SESSION['usuario_id'])): ?>
        <a href="comprar.php?tipo=candy&producto=pochoclos" class="boton">Comprar</a>
       <?php else: ?>
      <a href="login.php" class="boton">Ingresá para comprar</a>
      <?php endif; ?>
    </div>

    <div class="tarjeta">
        <img src="imagenes/vasos-coleccionables.jpg" alt="Vasos coleccionables" class="poster candy-img">
        <h2>Vasos coleccionables</h2>
        <p>Vasos especiales para los amantes del cine.</p>
        <p class="precio">$3.000</p>
        <?php if (isset($_SESSION['usuario_id'])): ?>
        <a href="comprar.php?tipo=candy&producto=vasos" class="boton">Comprar</a>
         <?php else: ?>
          <a href="login.php" class="boton">Ingresá para comprar</a>
           <?php endif; ?>
    </div>

    <div class="tarjeta">
        <img src="imagenes/nachos.jpg" alt="Nachos" class="poster candy-img">
        <h2>Nachos</h2>
        <p>Nachos crocantes con salsa de queso.</p>
        <p class="precio">$4.500</p>
        <?php if (isset($_SESSION['usuario_id'])): ?>
         <a href="comprar.php?tipo=candy&producto=nachos" class="boton">Comprar</a>
        <?php else: ?>
        <a href="login.php" class="boton">Ingresá para comprar</a>
        <?php endif; ?>
    </div>

    <div class="tarjeta">
        <img src="imagenes/combo.jpg" alt="Combo de cine"class="poster candy-img">
        <h2>Combo clásico</h2>
        <p>Pochoclos grandes y dos gaseosas.</p>
        <p class="precio">$10.000</p>
        <?php if (isset($_SESSION['usuario_id'])): ?>
       <a href="comprar.php?tipo=candy&producto=combo" class="boton">Comprar</a>
        <?php else: ?>
        <a href="login.php" class="boton">Ingresá para comprar</a>
        <?php endif; ?>
      </div>

</div>
<?php pie(); ?>