<?= view('layout/header', ['title' => 'Mon Épargne']) ?>
<div class="app-wrapper">
  <?= view('layout/sidebar_client', ['active' => 'epargne']) ?>
  <main class="main-content">
    <div class="topbar">
      <div class="topbar-title">Mon Épargne</div>
    </div>
    <div class="page-content">
      <?= view('layout/flash') ?>

      <div class="solde-card">
        <div class="solde-label"><i class="bi bi-piggy-bank"></i> Solde Épargné</div>
        <div class="solde-montant"><?= number_format((float) ($epargne['solde'] ?? 0), 0, ',', ' ') ?> Ar</div>
        <div class="solde-tel"><?= esc($client['telephone']) ?></div>
      </div>

      <div class="data-card" style="margin-top: 1.5rem;">
        <div class="data-card-header">
          <h3><i class="bi bi-gear"></i> Configuration de l'Épargne</h3>
        </div>
        <div style="padding: 1rem 1.5rem 1.5rem 1.5rem;">
            <form action="<?= base_url('client/epargne/action') ?>" method="post" style="display: flex; flex-direction: column; gap: 1.25rem;">
                <?= csrf_field() ?>
                <div class="form-group" style="margin: 0;">
                    <label style="display: block; margin-bottom: 0.5rem; font-size: 0.95rem; font-weight: 500; color: #495057;">Pourcentage (%)</label>
                    <input type="number" name="pourcentage" class="form-control" value="<?= esc($epargne['pourcentage'] ?? 0) ?>" min="0" max="100" step="1" required style="height: 2.5rem; max-width: 250px; text-align: center; font-size: 1rem;">
                </div>
                <div style="display: flex; gap: 1rem; max-width: 550px;">
                    <button type="submit" name="action_type" value="transferer" class="btn-primary-custom" style="flex: 1; height: 2.5rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem; font-size: 0.9rem; font-weight: 500;">
                        <i class="bi bi-box-arrow-in-right"></i> Transférer vers l'épargne
                    </button>
                    <button type="submit" name="action_type" value="retirer" class="btn-secondary-custom" style="flex: 1; height: 2.5rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem; font-size: 0.9rem; font-weight: 500;">
                        <i class="bi bi-box-arrow-right"></i> Retirer de l'épargne
                    </button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </main>
</div>
<?= view('layout/footer') ?>
