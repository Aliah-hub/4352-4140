<?= view('layout/header', ['title' => 'Dashboard Operateur']) ?>
<div class="app-wrapper">
  <?= view('layout/sidebar_admin', ['active' => 'dashboard']) ?>
  <main class="main-content">
    <div class="topbar">
      <div class="topbar-title">Dashboard</div>
    </div>
    <div class="page-content">
      <?= view('layout/flash') ?>
      


      <div class="metrics-row">
        <div class="metric-card">
          <div class="metric-icon green"><i class="bi bi-people"></i></div>
          <div class="metric-value"><?= (int) $stats['total_clients'] ?></div>
          <div class="metric-label">Clients</div>
        </div>
        <div class="metric-card">
          <div class="metric-icon blue"><i class="bi bi-arrow-left-right"></i></div>
          <div class="metric-value"><?= (int) $stats['total_operations'] ?></div>
          <div class="metric-label">Operations</div>
        </div>
        <div class="metric-card">
          <div class="metric-icon yellow"><i class="bi bi-cash-coin"></i></div>
          <div class="metric-value"><?= number_format((float) $stats['total_gains'], 0, ',', ' ') ?> Ar</div>
          <div class="metric-label">Gains collectes</div>
        </div>
      </div>

      <div class="data-card">
        <div class="data-card-header">
          <h3>10 dernières operations</h3>
        </div>
        <?php if (empty($dernieres)) : ?>
          <div class="empty-state"><i class="bi bi-inbox"></i><p>Aucune operation.</p></div>
        <?php else : ?>
          <table class="table-custom">
            <thead>
              <tr><th>Client</th><th>Type</th><th>Montant</th><th>Frais</th><th>Date</th></tr>
            </thead>
            <tbody>
              <?php foreach ($dernieres as $op) : ?>
                <tr>
                  <td class="td-name"><?= esc($op['client_telephone']) ?></td>
                  <td><span class="badge-type"><?= esc($op['type_libelle']) ?></span></td>
                  <td class="td-montant"><?= number_format((float) $op['montant'], 0, ',', ' ') ?> Ar</td>
                  <td class="td-muted"><?= number_format((float) $op['frais'], 0, ',', ' ') ?> Ar</td>
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
