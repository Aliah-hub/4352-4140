<?= view('layout/header', ['title' => 'Faire une opération']) ?>
<div class="app-wrapper">
  <?= view('layout/sidebar_client', ['active' => 'operations']) ?>
  <main class="main-content">
    <div class="topbar">
      <div class="topbar-title">Faire une opération</div>
    </div>
    <div class="page-content">
      <?= view('layout/flash') ?>

      <div class="solde-mini">
        Solde actuel : <strong><?= number_format((float) $client['solde'], 0, ',', ' ') ?> Ar</strong>
      </div>

      <div class="data-card">
        <form action="<?= base_url('client/operations') ?>" method="post" id="form-operation">
          <?= csrf_field() ?>

          <div class="form-group">
            <label>Type d'opération</label>
            <div class="type-buttons">
              <?php foreach ($types as $t) : ?>
                <label class="type-choice">
                  <input type="radio" name="type_code" value="<?= esc($t['code']) ?>"
                         onchange="onTypeChange('<?= esc($t['code']) ?>')" required />
                  <span>
                    <?php if ($t['code'] === 'depot') : ?>
                      <i class="bi bi-arrow-down-circle"></i>
                    <?php elseif ($t['code'] === 'retrait') : ?>
                      <i class="bi bi-arrow-up-circle"></i>
                    <?php else : ?>
                      <i class="bi bi-send"></i>
                    <?php endif; ?>
                    <?= esc($t['libelle']) ?>
                  </span>
                </label>
              <?php endforeach; ?>
            </div>
          </div>

          <div class="form-group">
            <label>Montant (Ar)</label>
            <input type="number" name="montant" id="montant" min="100" step="1"
                   placeholder="ex: 50000" class="form-control" required />
          </div>

          <div class="form-group d-none" id="groupe-destinataire">
            <label>Numéro du destinataire</label>
            <input type="text" name="destinataire" id="destinataire"
                   placeholder="ex: 0341234567" class="form-control" />
          </div>

          <button type="submit" class="btn-primary-custom">Confirmer l'opération</button>
        </form>
      </div>

    </div>
  </main>
</div>

<script>
function onTypeChange(code) {
  var div = document.getElementById('groupe-destinataire');
  var input = document.getElementById('destinataire');
  if (code === 'transfert') {
    div.classList.remove('d-none');
    input.required = true;
  } else {
    div.classList.add('d-none');
    input.required = false;
    input.value = '';
  }
}
</script>

<?= view('layout/footer') ?>
