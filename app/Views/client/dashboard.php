<?= view('layout/header', ['title' => 'Mon compte']) ?>
<div class="app-wrapper">
  <?= view('layout/sidebar_client', ['active' => 'dashboard']) ?>
  <main class="main-content">
    <div class="topbar">
      <div class="topbar-title">Mon compte</div>
    </div>
    <div class="page-content">
      <?= view('layout/flash') ?>

      <div class="solde-card">
        <div class="solde-label"><i class="bi bi-wallet2"></i> Solde disponible</div>
        <div class="solde-montant"><?= number_format((float) $client['solde'], 0, ',', ' ') ?> Ar</div>
        <div class="solde-tel"><?= esc($client['telephone']) ?></div>
      </div>

      <div class="actions-rapides">
        <a href="<?= base_url('client/operations') ?>?type=depot" class="action-card depot">
          <i class="bi bi-arrow-down-circle"></i>
          <span>Dépôt</span>
        </a>
        <a href="<?= base_url('client/operations') ?>?type=retrait" class="action-card retrait">
          <i class="bi bi-arrow-up-circle"></i>
          <span>Retrait</span>
        </a>
        <a href="<?= base_url('client/operations') ?>?type=transfert" class="action-card transfert">
          <i class="bi bi-send"></i>
          <span>Transfert</span>
        </a>
        <a href="<?= base_url('client/historique') ?>" class="action-card historique">
          <i class="bi bi-clock-history"></i>
          <span>Historique</span>
        </a>
      </div>

      <div class="data-card">
        <div class="data-card-header">
          <h3>Dernières opérations</h3>
          <a href="<?= base_url('client/historique') ?>" class="btn-secondary-custom">Tout voir</a>
        </div>
        <?php if (empty($dernieres)) : ?>
          <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <p>Aucune opération pour le moment.</p>
          </div>
        <?php else : ?>
          <table class="table-custom">
            <thead>
              <tr>
                <th>Type</th>
                <th>Montant</th>
                <th>Frais</th>
                <th>Solde après</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($dernieres as $op) : ?>
                <tr>
                  <td><span class="badge-type <?= esc($op['type_libelle']) ?>"><?= esc($op['type_libelle']) ?></span></td>
                  <td class="td-montant"><?= number_format((float) $op['montant'], 0, ',', ' ') ?> Ar</td>
                  <td class="td-muted"><?= number_format((float) $op['frais'], 0, ',', ' ') ?> Ar</td>
                  <td><?= number_format((float) $op['solde_apres'], 0, ',', ' ') ?> Ar</td>
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
