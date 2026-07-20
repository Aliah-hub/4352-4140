<?php
$nav       = isset($active) ? $active : '';
$telephone = (string) session()->get('client_telephone');
$initiale  = strtoupper(substr($telephone, -1));
?>
<aside class="sidebar">
  <div class="sidebar-logo">Bien<span>venue</span></div>
  <div class="sidebar-section">Mon compte</div>
  <ul class="sidebar-nav">
    <li><a href="<?= base_url('client/dashboard') ?>" class="<?= $nav === 'dashboard' ? 'active' : '' ?>"><i class="bi bi-house"></i> Accueil</a></li>
    <li><a href="<?= base_url('client/operations') ?>" class="<?= $nav === 'operations' ? 'active' : '' ?>"><i class="bi bi-send"></i> Faire une opération</a></li>
    <li><a href="<?= base_url('client/historique') ?>" class="<?= $nav === 'historique' ? 'active' : '' ?>"><i class="bi bi-clock-history"></i> Historique</a></li>
  </ul>

  <div class="sidebar-footer">
    <div class="sidebar-user">
      <div class="avatar"><?= esc($initiale) ?></div>
      <div class="user-info">
        <div class="name"><?= esc($telephone) ?></div>
        <div class="role">Client</div>
      </div>
    </div>
    <a href="<?= base_url('logout') ?>" class="logout-link">
      <i class="bi bi-box-arrow-right"></i> Déconnexion
    </a>
  </div>
</aside>
