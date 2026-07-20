<?php
$session = session();
?>
<?php if ($session->getFlashdata('success')) : ?>
  <div class="flash-message flash-success">
    <i class="bi bi-check-circle-fill"></i> <?= esc($session->getFlashdata('success')) ?>
  </div>
<?php endif; ?>
<?php if ($session->getFlashdata('error')) : ?>
  <div class="flash-message flash-error">
    <i class="bi bi-exclamation-triangle-fill"></i> <?= esc($session->getFlashdata('error')) ?>
  </div>
<?php endif; ?>
<?php
$errors = $session->getFlashdata('errors');
if (is_array($errors)) : ?>
  <div class="flash-message flash-error">
    <i class="bi bi-exclamation-triangle-fill"></i>
    <ul class="flash-list">
      <?php foreach ($errors as $err) : ?>
        <li><?= esc($err) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>
