<div class="container">
    <h2>Editar Usuario</h2>
    
    <?php if(session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <?php foreach(session()->getFlashdata('errors') as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <form action="<?= base_url("user/update/{$user['id']}") ?>" method="post">
        <input type="hidden" name="id" value="<?= $user['id'] ?>">
        
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="name" class="form-control" value="<?= old('name', $user['name']) ?>">
        </div>
        
        <div class="form-group">
            <label>Login</label>
            <input type="text" name="login" class="form-control" value="<?= old('login', $user['login']) ?>">
        </div>
        
        <div class="form-group">
            <label>Nueva Contraseña (dejar en blanco para no cambiar)</label>
            <input type="password" name="password" class="form-control">
        </div>
        
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="<?= base_url('user') ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>