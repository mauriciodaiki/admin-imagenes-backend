<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h2>Registro de Usuario</h2>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('register') ?>" method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Nombre completo</label>
            <input type="text" name="name" id="name" class="form-control" value="<?= old('name') ?>" required>
        </div>
        <div class="mb-3">
            <label for="login" class="form-label">Usuario</label>
            <input type="text" name="login" id="login" class="form-control" value="<?= old('login') ?>" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Registrarse</button>
        <a href="<?= base_url() ?>" class="btn btn-link">Iniciar sesión</a>
    </form>
</div>
</body>
</html>
