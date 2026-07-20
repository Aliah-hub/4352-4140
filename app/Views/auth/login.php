<?= view('layout/header', ['title' => 'Connexion']) ?>

<div class="auth-page">
  <div class="auth-card">
    <div class="auth-logo">Mobi<span>Pay</span></div>
    <p class="auth-subtitle">Système Mobile Money — Madagascar</p>

    <?= view('layout/flash') ?>

    <div class="auth-tabs">
      <button class="tab-btn active" id="tab-client" onclick="showTab('client')">
        <i class="bi bi-phone"></i> Client
      </button>
      <button class="tab-btn" id="tab-operateur" onclick="showTab('operateur')">
        <i class="bi bi-shield-lock"></i> Opérateur
      </button>
    </div>

    <!-- Formulaire client : numéro de téléphone -->
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
        <input type="hidden" name="operateur_nom" id="operateur_nom_hidden" value="" />

        <div class="form-group">
          <label>Choisir l'opérateur</label>

          <div class="custom-select-wrapper">
            <div class="custom-select-trigger" id="custom-trigger">
              <span class="trigger-placeholder">-- Sélectionner un opérateur --</span>
            </div>
            <div class="custom-select-options" id="custom-options">
              <div class="custom-option" data-value="Airtel" onclick="selectOperateur(this)">
                <img src="<?= base_url('images/airtel.jpeg') ?>" alt="Airtel" />
                <div class="op-info">
                  <span class="op-name">Airtel Money</span>
                  <span class="op-prefix">se connecter à Airtel</span>
                </div>
              </div>
              <div class="custom-option" data-value="Orange" onclick="selectOperateur(this)">
                <img src="<?= base_url('images/orange.jpeg') ?>" alt="Orange" />
                <div class="op-info">
                  <span class="op-name">Orange Money</span>
                  <span class="op-prefix">se connecter à Orange</span>
                </div>
              </div>
              <div class="custom-option" data-value="Yas" onclick="selectOperateur(this)">
                <img src="<?= base_url('images/yas.jpeg') ?>" alt="Yas" />
                <div class="op-info">
                  <span class="op-name">Yas / MVola</span>
                  <span class="op-prefix">se connecter à Yas</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <button type="submit" class="btn-primary-custom" id="btn-op" disabled>Accéder au tableau de bord</button>
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

document.getElementById('custom-trigger').addEventListener('click', function() {
  var opts = document.getElementById('custom-options');
  opts.classList.toggle('open');
  this.classList.toggle('open');
});

document.addEventListener('click', function(e) {
  if (!e.target.closest('.custom-select-wrapper')) {
    document.getElementById('custom-options').classList.remove('open');
    document.getElementById('custom-trigger').classList.remove('open');
  }
});

function selectOperateur(el) {
  var value  = el.getAttribute('data-value');
  var img    = el.querySelector('img').src;
  var name   = el.querySelector('.op-name').textContent;
  var prefix = el.querySelector('.op-prefix').textContent;

  document.getElementById('operateur_nom_hidden').value = value;

  var trigger = document.getElementById('custom-trigger');
  trigger.innerHTML =
    '<img src="' + img + '" alt="' + value + '" class="custom-trigger-img" />' +
    '<div class="custom-trigger-info">' +
      '<span class="trigger-name">' + name + '</span>' +
      '<span class="trigger-prefix">' + prefix + '</span>' +
    '</div>';

  document.getElementById('custom-options').classList.remove('open');
  trigger.classList.remove('open');
  document.getElementById('btn-op').disabled = false;
}
</script>

<?= view('layout/footer') ?>
