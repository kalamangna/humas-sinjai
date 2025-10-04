<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container">
    <h1>User Details</h1>
    <div class="card">
        <div class="card-header">
            User #<?= $user['id'] ?>
        </div>
        <div class="card-body">
            <h5 class="card-title"><?= $user['name'] ?></h5>
            <p class="card-text">Email: <?= $user['email'] ?></p>
            <p class="card-text">Role: <?= $user['role'] ?></p>
            <a href="/admin/users/edit/<?= $user['id'] ?>" class="btn btn-primary">Edit</a>
            <a href="/admin/users" class="btn btn-secondary">Back to list</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
