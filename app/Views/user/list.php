<div class="container">
    <h2>Listado de Usuarios</h2>
    
    <?php if(session()->get('success')): ?>
        <div class="alert alert-success">
            <?= session()->get('success') ?>
        </div>
    <?php endif; ?>
    
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= esc($user['name']) ?></td>
                <td><?= esc($user['login']) ?></td>
                <td>
                <a href="<?= base_url('user/edit/'.$user['id']) ?>" class="btn btn-sm btn-warning">Editar</a>
                <a href="<?= base_url('user/delete/'.$user['id']) ?>" class="btn btn-sm btn-danger">Eliminar</a>
            </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>