<?= view('layout/header', ['title' => 'Historique']) ?>
<div class="app-wrapper">
  <?= view('layout/sidebar_client', ['active' => 'historique']) ?>
  <main class="main-content">
    <div class="topbar">
      <div class="topbar-title">Historique des opérations</div>
    </div>
    <div class="page-content">
      <?= view('layout/flash') ?>

      <div class="solde-mini">
        Solde actuel : <strong><?= number_format((float) $client['solde'], 0, ',', ' ') ?> Ar</strong>
      </div>

      <div class="data-card">
        <?php if (empty($operations)) : ?>
          <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <p>Aucune opération pour le moment.</p>
          </div>
        <?php else : ?>
          <table class="table-custom">
            <thead>
              <tr>
                <th>#</th>
                <th>Type</th>
                <th>Montant</th>
                <th>Frais</th>
                <th>Solde avant</th>
                <th>Solde après</th>
                <th>Détails</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($operations as $op) : ?>
                <?php
                  $isReception = isset($op['description']) && strpos($op['description'], 'Réception de') === 0;
                ?>
                <tr>
                  <td class="td-muted"><?= (int) $op['id'] ?></td>
                  <td>
                    <?php if ($isReception) : ?>
                      <span class="badge-type badge-reception"><i class="bi bi-arrow-down-circle-fill"></i> Réception</span>
                    <?php else : ?>
                      <span class="badge-type"><?= esc($op['type_libelle']) ?></span>
                    <?php endif; ?>
                  </td>
                  <td class="td-montant"><?= number_format((float) $op['montant'], 0, ',', ' ') ?> Ar</td>
                  <td class="td-muted"><?= number_format((float) $op['frais'], 0, ',', ' ') ?> Ar</td>
                  <td class="td-muted"><?= number_format((float) $op['solde_avant'], 0, ',', ' ') ?> Ar</td>
                  <td><?= number_format((float) $op['solde_apres'], 0, ',', ' ') ?> Ar</td>
                  <td class="td-muted">
                    <?php if ($isReception) : ?>
                      <span class="reception-label">De&nbsp;<?= esc($op['destinataire']) ?></span>
                    <?php elseif ($op['destinataire']) : ?>
                      → <?= esc($op['destinataire']) ?>
                    <?php else : ?>
                      —
                    <?php endif; ?>
                  </td>
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
