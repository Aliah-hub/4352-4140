<?= view('layout/header', ['title' => 'Types d\'operations']) ?>
<div class="app-wrapper">
  <?= view('layout/sidebar_admin', ['active' => 'types']) ?>
  <main class="main-content">
    <div class="topbar">
      <div class="topbar-title">Types d'operations & Barèmes</div>
    </div>
    <div class="page-content">
      <?= view('layout/flash') ?>

      <div class="data-card">
        <div class="data-card-header"><h3>Ajouter un type d'operation</h3></div>
        <form action="<?= base_url('operateur/type-operations/store') ?>" method="post" class="form-inline-row">
          <?= csrf_field() ?>
          <input type="text" name="code"    placeholder="code (ex: depot)"   class="form-control" required />
          <input type="text" name="libelle" placeholder="Libelle (ex: Depôt)" class="form-control" required />
          <button type="submit" class="btn-primary-custom">Ajouter</button>
        </form>
      </div>

      <?php foreach ($types as $t) : ?>
        <div class="data-card">
          <div class="data-card-header">
            <h3><?= esc($t['libelle']) ?> <small class="td-muted">(<?= esc($t['code']) ?>)</small></h3>
            <div>
              <a href="<?= base_url('operateur/type-operations/' . (int) $t['id'] . '/baremes') ?>"
                 class="btn-secondary-custom"><i class="bi bi-table"></i> Gerer les baremes</a>
              <form action="<?= base_url('operateur/type-operations/delete/' . (int) $t['id']) ?>" method="post"
                    class="d-inline" onsubmit="return confirm('Supprimer ce type ?')">
                <?= csrf_field() ?>
                <button type="submit" class="btn-sm-custom btn-danger">Supprimer</button>
              </form>
            </div>
          </div>

          <?php if (empty($t['baremes'])) : ?>
            <p class="td-muted p-12">Aucun barème. <a href="<?= base_url('operateur/type-operations/' . (int) $t['id'] . '/baremes') ?>">Ajouter des tranches →</a></p>
          <?php else : ?>
            <table class="table-custom">
              <thead><tr><th>Montant min</th><th>Montant max</th><th>Frais (Ar)</th></tr></thead>
              <tbody>
                <?php foreach ($t['baremes'] as $b) : ?>
                  <tr>
                    <td><?= number_format((float) $b['montant_min'], 0, ',', ' ') ?> Ar</td>
                    <td><?= number_format((float) $b['montant_max'], 0, ',', ' ') ?> Ar</td>
                    <td><strong><?= number_format((float) $b['frais'], 0, ',', ' ') ?> Ar</strong></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>

      <?php if (empty($types)) : ?>
        <div class="empty-state"><i class="bi bi-sliders"></i><p>Aucun type d'operation.</p></div>
      <?php endif; ?>

    </div>
  </main>
</div>
<?= view('layout/footer') ?>
