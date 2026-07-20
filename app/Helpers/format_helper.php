<?php

if (! function_exists('formatDateFr')) {
    function formatDateFr(string $dateTime): string
    {
        $ts = strtotime($dateTime);
        if ($ts === false) {
            return $dateTime;
        }
        $jours = ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'];
        $mois  = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sept', 'Oct', 'Nov', 'Déc'];
        $j = $jours[(int) date('w', $ts)];
        $m = $mois[(int) date('n', $ts) - 1];
        return $j . ' ' . date('d', $ts) . ' ' . $m . ' · ' . date('H:i', $ts);
    }
}

if (! function_exists('badgeStatut')) {
    function badgeStatut(string $statut): string
    {
        $libelles = [
            'en_attente' => ['s-attente',   'En attente'],
            'confirmee'  => ['s-confirmee', 'Confirmée'],
            'annulee'    => ['s-annulee',   'Annulée'],
            'refusee'    => ['s-refusee',   'Refusée'],
        ];
        if (! isset($libelles[$statut])) {
            return '<span class="badge-statut s-annulee">' . esc($statut) . '</span>';
        }
        $classe = $libelles[$statut][0];
        $texte  = $libelles[$statut][1];
        return '<span class="badge-statut ' . $classe . '">' . $texte . '</span>';
    }
}

if (! function_exists('typeBadge')) {
    function typeBadge(string $type): string
    {
        $classe = 'type-' . $type;
        return '<span class="creneau-type ' . $classe . '"><i class="bi bi-tag-fill"></i>' . esc($type) . '</span>';
    }
}
