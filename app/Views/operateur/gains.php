<?= view('layout/header', ['title' => 'Gains']) ?>
<div class="app-wrapper">
  <?= view('layout/sidebar_admin', ['active' => 'gains']) ?>
  <main class="main-content">
    <div class="topbar">
      <div class="topbar-title">Situation des gains</div>
    </div>
    <div class="page-content">
      <?= view('layout/flash') ?>

      <div class="solde-card">
        <div class="solde-label"><i class="bi bi-cash-coin"></i> 
          Total des frais collectes
        </div>
        <div class="solde-montant"><?= number_format((float) $gainTotal, 0, ',', ' ') ?> Ar</div>
      </div>

      <div class="metrics-row">
        <div class="metric-card">
          <div class="metric-icon blue"><i class="bi bi-diagram-2"></i></div>
          <div class="metric-value"><?= number_format((float) $gainsInterne, 0, ',', ' ') ?> Ar</div>
          <div class="metric-label">Gains en interne (Même operateur)</div>
        </div>
        <div class="metric-card">
          <div class="metric-icon yellow"><i class="bi bi-globe"></i></div>
          <div class="metric-value"><?= number_format((float) $gainsExterne, 0, ',', ' ') ?> Ar</div>
          <div class="metric-label">Gains inter-operateur</div>
        </div>
      </div>

      <div class="data-card">
        <div class="data-card-header"><h3>Gains par type d'operation</h3></div>
        <?php if (empty($gainsParType)) : ?>
          <div class="empty-state"><i class="bi bi-inbox"></i><p>Aucun gain enregistre.</p></div>
        <?php else : ?>
          <table class="table-custom">
            <thead>
              <tr><th>Type d'operation</th><th>Nombre d'operations</th><th>Total frais collectes</th></tr>
            </thead>
            <tbody>
              <?php foreach ($gainsParType as $g) : ?>
                <tr>
                  <td class="td-name"><?= esc($g['libelle']) ?></td>
                  <td><?= (int) $g['nb'] ?></td>
                  <td class="td-montant"><strong><?= number_format((float) $g['total_frais'], 0, ',', ' ') ?> Ar</strong></td>
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
