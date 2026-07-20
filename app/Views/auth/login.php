<?= view('layout/header', ['title' => 'Connexion']) ?>

<div class="auth-page">
  <div class="auth-card">
    <div class="auth-logo">Mobi<span>Pay</span></div>
    <p class="auth-subtitle">Système Mobile Money</p>

    <?= view('layout/flash') ?>

    <div class="auth-tabs">
      <button class="tab-btn active" id="tab-client" onclick="showTab('client')">
        <i class="bi bi-phone"></i> Client
      </button>
      <button class="tab-btn" id="tab-operateur" onclick="showTab('operateur')">
        <i class="bi bi-shield-lock"></i> Opérateur
      </button>
    </div>

    <div id="form-client">
      <form action="<?= base_url('login/client') ?>" method="post">
        <?= csrf_field() ?>
        <div class="form-group">
          <label>Numéro de téléphone</label>
          <input type="text" name="telephone" id="telephone"
                 placeholder="ex: 0321234567"
                 value="<?= old('telephone') ?>"
                 class="form-control" autocomplete="off" />
          <small>Votre compte est créé automatiquement à la 1ère connexion.</small>
        </div>
        <button type="submit" class="btn-primary-custom">Se connecter</button>
      </form>
    </div>

    <div id="form-operateur" class="d-none">
      <form action="<?= base_url('login/operateur') ?>" method="post" id="form-op">
        <?= csrf_field() ?>
        
        <p style="color: var(--muted); text-align: center; margin-bottom: 20px;">Accès direct pour l'administrateur</p>

        <button type="submit" class="btn-primary-custom" style="width: 100%;">Accéder au tableau de bord</button>
      </form>
    </div>
  </div>
</div>



<script>
function showTab(tab) {
  var clientForm = document.getElementById('form-client');
  var opForm = document.getElementById('form-operateur');

  if (tab === 'client') {
    clientForm.classList.remove('d-none');
    opForm.classList.add('d-none');
  } else {
    clientForm.classList.add('d-none');
    opForm.classList.remove('d-none');
  }

  document.getElementById('tab-client').classList.toggle('active', tab === 'client');
  document.getElementById('tab-operateur').classList.toggle('active', tab === 'operateur');
}

</script>

<?= view('layout/footer') ?>
