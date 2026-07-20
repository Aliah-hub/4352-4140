<?php
$nav = isset($active) ? $active : '';
$nom = (string) session()->get('operateur_nom');
$initiale = strtoupper(substr($nom, 0, 1));
?>
<aside class="sidebar">
  <div class="sidebar-logo">Mobi<span>Pay</span></div>
  <div class="sidebar-section">Opérateur</div>
  <ul class="sidebar-nav">
    <li><a href="<?= base_url('operateur/dashboard') ?>" class="<?= $nav === 'dashboard' ? 'active' : '' ?>"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
    <li><a href="<?= base_url('operateur/prefixes') ?>" class="<?= $nav === 'prefixes' ? 'active' : '' ?>"><i class="bi bi-hash"></i> Préfixes</a></li>
    <li><a href="<?= base_url('operateur/type-operations') ?>" class="<?= $nav === 'types' ? 'active' : '' ?>"><i class="bi bi-sliders"></i> Types & Barèmes</a></li>
    <li><a href="<?= base_url('operateur/gains') ?>" class="<?= $nav === 'gains' ? 'active' : '' ?>"><i class="bi bi-graph-up-arrow"></i> Gains</a></li>
    <li><a href="<?= base_url('operateur/clients') ?>" class="<?= $nav === 'clients' ? 'active' : '' ?>"><i class="bi bi-people"></i> Comptes clients</a></li>
  </ul>

  <div class="sidebar-footer">
    <div class="sidebar-user">
      <div class="avatar"><?= esc($initiale) ?></div>
      <div class="user-info">
        <div class="name"><?= esc($nom) ?></div>
        <div class="role">Opérateur</div>
      </div>
    </div>
    <a href="<?= base_url('logout') ?>" class="logout-link">
      <i class="bi bi-box-arrow-right"></i> Déconnexion
    </a>
  </div>
</aside>
