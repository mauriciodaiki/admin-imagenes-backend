<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h2 class="mb-4">Panel de Administración de Usuarios</h2>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Login</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $u): ?>
                <tr>
                    <td><?= $u['id'] ?></td>
                    <td><?= esc($u['login']) ?></td>
                    <td><?= esc($u['role']) ?></td>
                    <td>
                        <?php if ($u['role'] !== 'admin'): ?>
                            <a href="<?= base_url('admin/eliminar/' . $u['id']) ?>" 
                               class="btn btn-sm btn-danger" 
                               onclick="return confirm('¿Estás seguro de que quieres eliminar este usuario?');">
                                Eliminar
                            </a>
                        <?php else: ?>
                            <span class="text-muted">Admin</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="<?= base_url('imagenes') ?>" class="btn btn-secondary mt-3">Volver a galería</a>
</div>
</body>
</html>
