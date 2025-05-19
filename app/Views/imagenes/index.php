<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Imágenes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .galeria img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .imagen-item {
            margin-bottom: 20px;
        }
    </style>
</head>
<body class="bg-light">

<div class="container py-5">

<?php if (session()->get('role') === 'admin'): ?>
    <a href="<?= base_url('admin/usuarios') ?>" class="btn btn-outline-dark mb-4 float-end">
        Panel de administración
    </a>
<?php endif; ?>

    <h2 class="mb-4">Administración de Imágenes</h2>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('imagenes/subir') ?>" method="post" enctype="multipart/form-data" class="mb-4">
        <div class="mb-3">
            <label for="imagen" class="form-label">Selecciona una imagen</label>
            <input type="file" name="imagen" id="imagen" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Subir imagen</button>
    </form>

    <div class="row galeria">
        <?php if (empty($imagenes)): ?>
            <p>No se han subido imágenes aún.</p>
        <?php else: ?>
            <?php foreach ($imagenes as $img): ?>
                <div class="col-md-3 imagen-item">
                    <div class="card shadow-sm">
                        <img src="/<?= $img['ruta_archivo'] ?>" class="card-img-top" alt="<?= $img['nombre_archivo'] ?>">
                        <div class="card-body text-center">
                            <p class="card-text"><strong>Archivo:</strong> <?= $img['nombre_archivo'] ?></p>
                            <p class="card-text text-muted" style="font-size: 0.85rem;">
                                <strong>Subida:</strong> <?= date('d/m/Y H:i', strtotime($img['fecha_subida'])) ?>
                            </p>

                            <?php
                                $esPropietario = $img['usuario_id'] == session()->get('user_id');
                                $esAdmin = session()->get('role') === 'admin';
                            ?>
                            <?php if ($esPropietario || $esAdmin): ?>
                                <form action="<?= base_url('imagenes/borrar/' . $img['id']) ?>" method="post" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta imagen?');">
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            <?php endif; ?>

                            <?php if ($esAdmin): ?>
                                <p class="card-text text-muted mt-2" style="font-size: 0.8rem;">
                                    <em>ID de usuario: <?= $img['usuario_id'] ?></em>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const fileInput = document.querySelector('input[type="file"]');
    if (!fileInput.files[0]) {
        e.preventDefault();
        alert('Selecciona una imagen');
    }
});
</script>


</body>
</html>
