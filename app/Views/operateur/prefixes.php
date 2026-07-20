<?= view('layout/header', ['title' => 'Préfixes']) ?>
<div class="app-wrapper">
  <?= view('layout/sidebar_admin', ['active' => 'prefixes']) ?>
  <main class="main-content">
    <div class="topbar">
      <div class="topbar-title">Gestion des préfixes</div>
    </div>
    <div class="page-content">
      <?= view('layout/flash') ?>

      <div class="data-card">
        <div class="data-card-header"><h3>Ajouter un préfixe</h3></div>
        <form action="<?= base_url('operateur/prefixes/store') ?>" method="post" class="form-inline-row">
          <?= csrf_field() ?>
          <input type="text" name="valeur" placeholder="ex: 032, +261, 0202"
                 class="form-control" required />
          <button type="submit" class="btn-primary-custom">Ajouter</button>
        </form>
      </div>

      <div class="data-card">
        <div class="data-card-header"><h3>Préfixes configurés</h3></div>
        <?php if (empty($prefixes)) : ?>
          <div class="empty-state"><i class="bi bi-hash"></i><p>Aucun préfixe configuré.</p></div>
        <?php else : ?>
          <table class="table-custom">
            <thead><tr><th>Préfixe</th><th>Statut</th><th>Actions</th></tr></thead>
            <tbody>
              <?php foreach ($prefixes as $p) : ?>
                <tr>
                  <td class="td-name"><code><?= esc($p['valeur']) ?></code></td>
                  <td>
                    <?php if ($p['actif']) : ?>
                      <span class="badge-statut s-confirmee">Actif</span>
                    <?php else : ?>
                      <span class="badge-statut s-annulee">Inactif</span>
                    <?php endif; ?>
                  </td>
                  <td class="td-actions">
                    <form action="<?= base_url('operateur/prefixes/toggle/' . (int) $p['id']) ?>" method="post" class="d-inline">
                      <?= csrf_field() ?>
                      <button type="submit" class="btn-sm-custom btn-confirm">
                        <?= $p['actif'] ? 'Désactiver' : 'Activer' ?>
                      </button>
                    </form>
                    <form action="<?= base_url('operateur/prefixes/delete/' . (int) $p['id']) ?>" method="post" class="d-inline"
                          onsubmit="return confirm('Supprimer ce préfixe ?')">
                      <?= csrf_field() ?>
                      <button type="submit" class="btn-sm-custom btn-danger">Supprimer</button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php endif; ?>
      </div>

    </div>
  </main>
</div>
<?= view('layout/footer') ?>
