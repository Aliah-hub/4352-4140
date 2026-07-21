<?= view('layout/header', ['title' => 'Faire une operation']) ?>
<div class="app-wrapper">
  <?= view('layout/sidebar_client', ['active' => 'operations']) ?>
  <main class="main-content">
    <div class="topbar">
      <div class="topbar-title">Faire une operation</div>
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
            <label>Type d'operation</label>
            <div class="type-buttons">
              <?php foreach ($types as $t) : ?>
                <label class="type-choice">
                  <input type="radio" name="type_code" value="<?= esc($t['code']) ?>"
                         <?= $typeParam === $t['code'] ? 'checked' : '' ?>
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
            <label>Numero(s) du destinataire (separes par une virgule pour envoi multiple)</label>
            <input type="text" name="destinataire" id="destinataire"
                   placeholder="ex: 0341234567, 0329876543" class="form-control" />
          </div>

          <div class="form-group d-none" id="groupe-frais-retrait" style="flex-direction: row; align-items: center; gap: 10px;">
            <input type="checkbox" name="inclure_frais_retrait" id="inclure_frais_retrait" value="1" style="width: 20px; height: 20px;" />
            <label for="inclure_frais_retrait" style="margin-bottom: 0; text-transform: none; color: var(--text-main);">Inclure les frais de retrait (le montant sera augmente pour couvrir les frais de retrait du destinataire)</label>
             <input type="checkbox" name="inclure_frais_retrait" id="inclure_frais_retrait" value="1" style="width: 20px; height: 20px;" />
          </div>

          <button type="submit" class="btn-primary-custom">Confirmer l'operation</button>
        </form>
      </div>

    </div>
  </main>
</div>

<script>
function onTypeChange(code) {
  var divDest = document.getElementById('groupe-destinataire');
  var divFrais = document.getElementById('groupe-frais-retrait');
  var input = document.getElementById('destinataire');
  var checkbox = document.getElementById('inclure_frais_retrait');

  if (code === 'transfert') {
    divDest.classList.remove('d-none');
    divFrais.classList.remove('d-none');
    input.required = true;
  } else {
    divDest.classList.add('d-none');
    divFrais.classList.add('d-none');
    input.required = false;
    input.value = '';
    checkbox.checked = false;
  }
}

window.addEventListener('DOMContentLoaded', function() {
  var checkedRadio = document.querySelector('input[name="type_code"]:checked');
  if (checkedRadio) {
    onTypeChange(checkedRadio.value);
  }
});
</script>

<?= view('layout/footer') ?>
