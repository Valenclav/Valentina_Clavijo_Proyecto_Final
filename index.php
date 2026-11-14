<?php
require_once "funciones.php";
cabecera("Cartelera");
    
$peliculas = [
    [ "codigo" => "scary_movie",
        "titulo" => "Scary Movie",
        "genero" => "Comedia / Terror",
        "horario" => "18:00 - 20:15",
        "sala" => "Sala 1",
        "precio" => 4500,
        "sinopsis" => "Cindy, Brenda, Shorty y Ray vuelven a enfrentarse a un nuevo asesino enmascarado.",
        "imagen" => "scary-movie.jpg"
    ],
    ["codigo" => "spiderman",
        "titulo" => "Spider-Man: Brand New Day",
        "genero" => "Acción / Aventura / Ciencia ficción",
        "horario" => "15:30 - 17:10",
        "sala" => "Sala 2",
        "precio" => 3800,
        "sinopsis" => "Peter Parker combate el crimen en una ciudad donde nadie recuerda quién es.",
        "imagen" => "spider-man.jpg"
    ],
    ["codigo" => "toy_story",
        "titulo" => "Toy Story 5",
        "genero" => "Animación / Aventura / Comedia",
        "horario" => "21:00 - 23:25",
        "sala" => "Sala 3",
        "precio" => 5200,
        "sinopsis" => "Los juguetes enfrentan un nuevo desafío cuando una tablet llamada Lilypad llega a la vida de Bonnie.",
        "imagen" => "toy-story-5.jpg"
    ],
    [ "codigo" => "diablo_prada",
        "titulo" => "El diablo viste de Prada 2",
        "genero" => "Comedia / Drama",
        "horario" => "19:15 - 21:00",
        "sala" => "Sala 1",
        "precio" => 4500,
        "sinopsis" => "Miranda, Andy, Emily y Nigel regresan al mundo de la moda y a la revista Runway.",
        "imagen" => "diablo-viste-prada-2.jpg"
    ]
];

?>
<h1>Cartelera de hoy</h1>
<p class="intro">Elegi tu pelicula, saca tu entrada online y disfruta la funcion.</p>

<div class="grilla">

<?php foreach ($peliculas as $p): ?>

    <div class="tarjeta">

        <img src="imagenes/<?php echo h($p['imagen']); ?>"
             alt="Póster de <?php echo h($p['titulo']); ?>"
             class="poster">
         <h2><?php echo h($p['titulo']); ?></h2><p class="sinopsis">
            <?php echo h($p['sinopsis']); ?></p>
        <p><strong>Género:</strong> <?php echo h($p['genero']); ?></p>
        <p><strong>Horario:</strong> <?php echo h($p['horario']); ?></p>
        <p><strong>Sala:</strong> <?php echo h($p['sala']); ?></p>
        <p class="precio">
            $<?php echo number_format($p['precio'], 0, ',', '.'); ?> </p>
               <div class="botones-pelicula">
    <?php if (isset($_SESSION['usuario_id'])): ?>
       <a href="comprar.php?tipo=pelicula&producto=<?php echo h($p['codigo']); ?>" class="btn-comprar">Comprar entradas
        </a>
          <?php else: ?>
      <a href="login.php" class="btn-comprar">
            Ingresá para comprar
        </a>
      <?php endif; ?>
      </div>
    </div>
<?php endforeach; ?>

</div>
<section class="preventa">
    <h2>Próximos estrenos - Preventa</h2>
    <p class="intro">¡Reservá tus entradas antes del estreno!</p>

    <div class="grilla">

        <div class="tarjeta">
            <img src="imagenes/avengers-doomsday.jpg" alt="Avengers Doomsday" class="poster">
            <h2>Avengers: Doomsday</h2>
            <p>Estreno: 18 de diciembre de 2026</p>
            <p class="precio">Comprar en preventa</p>
        </div>

        <div class="tarjeta">
            <img src="imagenes/duna-tres.jpg" alt="Duna Parte Tres" class="poster">
            <h2>Duna: Parte Tres</h2>
            <p>Próximamente en cines</p>
            <p class="precio">Comprar en preventa</p>
        </div>

        <div class="tarjeta">
            <img src="imagenes/juegos-del-hambre.jpg" alt="Los juegos del hambre" class="poster">
            <h2>Los juegos del hambre: Amanecer en la cosecha</h2>
            <p>Próximamente en cines</p>
            <p class="precio">Comprar en preventa</p>
        </div>
        <div class="tarjeta">
       <img src="imagenes/godzilla-minus-zero.jpg" alt="Godzilla Minus Zero" class="poster">
        <h2>Godzilla Minus Zero</h2>
        <p>Estreno: 5 de noviembre de 2026</p>
         <p class="precio">Comprar en preventa</p>
    </div>
</div>
</section>
<?php if (!isset($_SESSION['usuario_id'])): ?>

    <div class="acceso">
    <div class="acceso-texto">
    <h2>¡Viví la experiencia CineCentro!</h2>
    <p>Ingresá con tu cuenta o registrate para acceder a CineCentro</p>
    </div>
     <div class="acceso-botones">
            <a href="login.php" class="boton">Ingresar</a>
            <a href="registro.php" class="boton boton-secundario">Crear cuenta</a>
        </div>
        </div>

<?php endif; ?>
<?php pie(); ?>


