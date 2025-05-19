<div class="container">
    <h2>Registro de usuario</h2>
    <form action="<?= base_url('register') ?>" method="post">
    <?= csrf_field() ?>
            <label>Nombre completo</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Usuario</label>
            <input type="text" name="login" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Contraseña</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrarse</button>
    </form>
</div>