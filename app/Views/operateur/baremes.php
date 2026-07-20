<?= view('layout/header', ['title' => 'Barèmes — ' . esc($type['libelle'])]) ?>
<div class="app-wrapper">
  <?= view('layout/sidebar_admin', ['active' => 'types']) ?>
  <main class="main-content">
    <div class="topbar">
      <div class="topbar-title">Barèmes : <?= esc($type['libelle']) ?></div>
    </div>
    <div class="page-content">
      <?= view('layout/flash') ?>

      <a href="<?= base_url('operateur/type-operations') ?>" class="btn-secondary-custom mb-16 d-inline-block">
        ← Retour aux types
      </a>



      <div class="data-card">
        <div class="data-card-header"><h3>Ajouter une tranche de frais</h3></div>
        <form action="<?= base_url('operateur/type-operations/' . (int) $type['id'] . '/baremes/store') ?>" method="post" class="form-inline-row">
          <?= csrf_field() ?>

          <div class="form-group">
            <label>Montant min (Ar)</label>
            <input type="number" name="montant_min" min="0" step="1" placeholder="ex: 100" class="form-control" required />
          </div>
          <div class="form-group">
            <label>Montant max (Ar)</label>
            <input type="number" name="montant_max" min="1" step="1" placeholder="ex: 1000" class="form-control" required />
          </div>
          <div class="form-group">
            <label>Frais (Ar)</label>
            <input type="number" name="frais" min="0" step="1" placeholder="ex: 50" class="form-control" required />
          </div>
          <button type="submit" class="btn-primary-custom align-end">Ajouter</button>
        </form>
      </div>

      <div class="data-card">
        <div class="data-card-header"><h3>Tranches configurées</h3></div>
        <?php if (empty($baremes)) : ?>
          <div class="empty-state"><i class="bi bi-table"></i><p>Aucune tranche.</p></div>
        <?php else : ?>
          <table class="table-custom">
            <thead>
              <tr>
                <th>Montant min</th><th>Montant max</th><th>Frais</th><th>Modifier</th><th>Supprimer</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($baremes as $b) : ?>
                <tr>
                  <form action="<?= base_url('operateur/type-operations/' . (int) $type['id'] . '/baremes/update/' . (int) $b['id']) ?>" method="post">
                    <?= csrf_field() ?>

                    <td><input type="number" name="montant_min" value="<?= (float) $b['montant_min'] ?>" class="form-control-sm w-110" /></td>
                    <td><input type="number" name="montant_max" value="<?= (float) $b['montant_max'] ?>" class="form-control-sm w-110" /></td>
                    <td><input type="number" name="frais"       value="<?= (float) $b['frais'] ?>"       class="form-control-sm w-90" /></td>
                    <td><button type="submit" class="btn-sm-custom btn-confirm">Sauvegarder</button></td>
                  </form>
                  <td>
                    <form action="<?= base_url('operateur/type-operations/' . (int) $type['id'] . '/baremes/delete/' . (int) $b['id']) ?>" method="post"
                          onsubmit="return confirm('Supprimer cette tranche ?')">
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
