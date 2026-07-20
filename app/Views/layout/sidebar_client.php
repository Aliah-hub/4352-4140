<?php
$nav       = isset($active) ? $active : '';
$telephone = (string) session()->get('client_telephone');
$initiale  = strtoupper(substr($telephone, -1));
?>
<aside class="sidebar">
<?php
    $cleanTel = str_replace('+261', '0', $telephone);
    $prefix = substr($cleanTel, 0, 3);
    
    $logoHtml = 'Mobi<span>Pay</span>';
    if (in_array($prefix, ['033', '035'])) {
        $logoHtml = '<img src="' . base_url('images/airtel.jpeg') . '" alt="Airtel Money" class="sidebar-logo-img" />';
    } elseif (in_array($prefix, ['032', '037'])) {
        $logoHtml = '<img src="' . base_url('images/orange.jpeg') . '" alt="Orange Money" class="sidebar-logo-img" />';
    } elseif (in_array($prefix, ['034', '038'])) {
        $logoHtml = '<img src="' . base_url('images/yas.jpeg') . '" alt="Yas" class="sidebar-logo-img" />';
    }
?>
  <div class="sidebar-logo"><?= $logoHtml ?></div>
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
