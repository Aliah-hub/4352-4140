<?php
/**
 * Shared operator filter bar partial.
 * Pass: $filtre (current), $action (form action URL)
 */
?>
<div class="op-filter-bar">
  <a href="<?= $action ?>?operateur=Tous"
     class="op-filter-btn <?= $filtre === 'Tous' ? 'active' : '' ?>">
    <i class="bi bi-grid-3x3-gap"></i> Tous
  </a>
  <a href="<?= $action ?>?operateur=Yas"
     class="op-filter-btn yas <?= $filtre === 'Yas' ? 'active' : '' ?>">
    <span class="op-dot yas-dot"></span> Yas / MVola
  </a>
  <a href="<?= $action ?>?operateur=Airtel"
     class="op-filter-btn airtel <?= $filtre === 'Airtel' ? 'active' : '' ?>">
    <span class="op-dot airtel-dot"></span> Airtel Money
  </a>
  <a href="<?= $action ?>?operateur=Orange"
     class="op-filter-btn orange <?= $filtre === 'Orange' ? 'active' : '' ?>">
    <span class="op-dot orange-dot"></span> Orange Money
  </a>
</div>
