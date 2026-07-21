<?= view('layout/header', ['title' => 'Client — ' . esc($client['telephone'])]) ?>
<div class="app-wrapper">
  <?= view('layout/sidebar_admin', ['active' => 'clients']) ?>
  <main class="main-content">
    <div class="topbar">
      <div class="topbar-title">Detail client : <?= esc($client['telephone']) ?></div>
    </div>
    <div class="page-content">
      <?= view('layout/flash') ?>

      <a href="<?= base_url('operateur/clients') ?>" class="btn-secondary-custom mb-16 d-inline-block">
        ← Retour aux clients
      </a>

      <div class="solde-card">
        <div class="solde-label"><i class="bi bi-wallet2"></i> Solde du client</div>
        <div class="solde-montant"><?= number_format((float) $client['solde'], 0, ',', ' ') ?> Ar</div>
        <div class="solde-tel"><?= esc($client['telephone']) ?></div>
      </div>

      <div class="data-card">
        <div class="data-card-header"><h3>Historique des operations</h3></div>
        <?php if (empty($operations)) : ?>
          <div class="empty-state"><i class="bi bi-inbox"></i><p>Aucune operation.</p></div>
        <?php else : ?>
          <table class="table-custom">
            <thead>
              <tr><th>Type</th><th>Montant</th><th>Frais</th><th>Solde avant</th><th>Solde apres</th><th>Destinataire</th><th>Date</th></tr>
            </thead>
            <tbody>
              <?php foreach ($operations as $op) : ?>
                <tr>
                  <td><span class="badge-type"><?= esc($op['type_libelle']) ?></span></td>
                  <td class="td-montant"><?= number_format((float) $op['montant'], 0, ',', ' ') ?> Ar</td>
                  <td class="td-muted"><?= number_format((float) $op['frais'], 0, ',', ' ') ?> Ar</td>
                  <td class="td-muted"><?= number_format((float) $op['solde_avant'], 0, ',', ' ') ?> Ar</td>
                  <td><?= number_format((float) $op['solde_apres'], 0, ',', ' ') ?> Ar</td>
                  <td class="td-muted"><?= $op['destinataire'] ? esc($op['destinataire']) : '—' ?></td>
                  <td class="td-muted"><?= esc($op['created_at']) ?></td>
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
