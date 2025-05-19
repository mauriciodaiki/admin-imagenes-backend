<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <?php if (session()->has('login_error')): ?>
                <div class="alert alert-danger"><?= session('login_error') ?></div>
            <?php endif; ?>
            
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>Iniciar Sesión</h4>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('login') ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label for="login" class="form-label">Usuario</label>
                            <input type="text" class="form-control" name="login" id="login" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" name="password" id="password" required>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" name="remember" id="remember">
                            <label class="form-check-label" for="remember">Recordar sesión</label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Ingresar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>