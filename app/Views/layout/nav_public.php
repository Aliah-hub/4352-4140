<?php
$role = session()->get('role');
?>
<nav class="nav-public">
  <a href="<?= base_url('/') ?>" class="brand">Fit<span>Space</span></a>
  <div class="nav-links">
    <a href="<?= base_url('/') ?>">Creneaux</a>
    <?php if (! session()->get('user_id')) : ?>
      <a href="<?= base_url('login') ?>">Connexion</a>
      <a href="<?= base_url('register') ?>" class="btn-nav-primary">Creer un compte</a>
    <?php else : ?>
      <?php if ($role === 'admin') : ?>
        <a href="<?= base_url('admin/dashboard') ?>" class="btn-nav-primary">Espace admin</a>
      <?php else : ?>
        <a href="<?= base_url('client/dashboard') ?>" class="btn-nav-primary">Mon espace</a>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</nav>
