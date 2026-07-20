<?= view('layout/header', ['title' => 'Comptes clients']) ?>
<div class="app-wrapper">
  <?= view('layout/sidebar_admin', ['active' => 'clients']) ?>
  <main class="main-content">
    <div class="topbar">
      <div class="topbar-title">Comptes clients</div>
    </div>
    <div class="page-content">
      <?= view('layout/flash') ?>



      <div class="data-card">
        <?php if (empty($clients)) : ?>
          <div class="empty-state"><i class="bi bi-people"></i><p>Aucun client enregistre.</p></div>
        <?php else : ?>
          <table class="table-custom">
            <thead>
              <tr><th>#</th><th>Telephone</th><th>Solde</th><th>Statut</th><th>Cree le</th><th>Detail</th></tr>
            </thead>
            <tbody>
              <?php foreach ($clients as $c) : ?>
                <tr>
                  <td class="td-muted"><?= (int) $c['id'] ?></td>
                  <td class="td-name"><?= esc($c['telephone']) ?></td>
                  <td class="td-montant"><?= number_format((float) $c['solde'], 0, ',', ' ') ?> Ar</td>
                  <td>
                    <?php if ($c['actif']) : ?>
                      <span class="badge-statut s-confirmee">Actif</span>
                    <?php else : ?>
                      <span class="badge-statut s-annulee">Inactif</span>
                    <?php endif; ?>
                  </td>
                  <td class="td-muted"><?= esc($c['created_at']) ?></td>
                  <td>
                    <a href="<?= base_url('operateur/clients/' . (int) $c['id']) ?>"
                       class="btn-sm-custom btn-confirm">Voir</a>
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
