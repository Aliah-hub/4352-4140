<?= view('layout/header', ['title' => 'Configuration']) ?>
<div class="app-wrapper">
  <?= view('layout/sidebar_admin', ['active' => 'config']) ?>
  <main class="main-content">
    <div class="topbar">
      <div class="topbar-title">Configuration Système</div>
    </div>
    <div class="page-content">
      <?= view('layout/flash') ?>

      <div class="data-card">
        <div class="data-card-header">
          <h3>Paramètres globaux</h3>
        </div>
        <div style="padding: 24px;">
          <?php foreach ($configs as $c) : ?>
            <form action="<?= base_url('operateur/config/update') ?>" method="post" style="display: flex; gap: 16px; align-items: flex-end; margin-bottom: 24px;">
              <?= csrf_field() ?>
              <input type="hidden" name="id" value="<?= $c['id'] ?>">
              
              <div class="form-group" style="flex: 1; margin-bottom: 0;">
                <label><?= esc($c['description']) ?></label>
                <input type="text" name="valeur" value="<?= esc($c['valeur']) ?>" class="form-control" required>
              </div>
              
              <button type="submit" class="btn-primary-custom">Enregistrer</button>
            </form>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </main>
</div>
<?= view('layout/footer') ?>
