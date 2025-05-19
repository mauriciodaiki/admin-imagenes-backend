<div class="container">
    <h2>Crear Nuevo Usuario</h2>
    
    <?php if(session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <?php foreach(session()->getFlashdata('errors') as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <form action="<?= base_url('user/store') ?>" method="post">
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="name" class="form-control" value="<?= old('name') ?>">
        </div>
        
        <div class="form-group">
            <label>Login</label>
            <input type="text" name="login" class="form-control" value="<?= old('login') ?>">
        </div>
        
        <div class="form-group">
            <label>Contraseña</label>
            <input type="password" name="password" class="form-control">
        </div>
        
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="<?= base_url('user') ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>