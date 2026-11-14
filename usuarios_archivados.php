<?php
require_once "conexion.php";
require_once "funciones.php";
requerirAdmin();

$stmt = $pdo->query("SELECT * FROM usuarios WHERE fecha_archivado IS NOT NULL ORDER BY fecha_archivado DESC");
$archivados = $stmt->fetchAll();

cabecera("Usuarios archivados");
?>
<h1>Usuarios archivados</h1>
<p><a href="admin_usuarios.php">Volver a usuarios activos</a></p>

<table>
    <tr>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>DNI</th>
        <th>Correo</th>
        <th>Archivado el</th>
        <th>Acción</th>
    </tr>
    <?php foreach ($archivados as $u): ?>
    <tr>
        <td><?php echo h($u['nombre']); ?></td>
        <td><?php echo h($u['apellido']); ?></td>
        <td><?php echo h($u['dni']); ?></td>
        <td><?php echo h($u['email']); ?></td>
        <td><?php echo h(date("d/m/Y H:i", strtotime($u['fecha_archivado']))); ?></td>
        <td>
            <form method="POST" action="reactivar_usuario.php">
                <input type="hidden" name="id" value="<?php echo (int)$u['id']; ?>">
                <input type="hidden" name="csrf" value="<?php echo h(tokenCSRF()); ?>">
                <button type="submit" class="boton chico">Reactivar</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php if (empty($archivados)): ?>
    <p>No hay usuarios archivados.</p>
<?php endif; ?>
<?php pie(); ?>
