Phase 1 — Initialisation du projet
[4352 + 4140] Créer le projet CodeIgniter 4 avec Composer et vérifier que la page d'accueil s'affiche. 
[4352 + 4140] Mettre en place Git : dépôt local, premier commit, dépôt distant (GitHub). 
[4352 + 4140] Se répartir les rôles : 4140 → partie Client, 4352 → partie Opérateur/Admin. 


Phase 2 — Base de données
[4352] Lister toutes les informations à stocker (client, opérateur, préfixes, types d'opération, barèmes, opérations). 
[4140] Dessiner le schéma de la base de données (tables + liens entre elles). 
[4352] Créer la migration CreatePrefixes. 
[4140] Créer la migration CreateTypeOperations. 
[4352] Créer la migration CreateBaremes (avec colonne operateur_nom pour séparer les frais par opérateur). 
[4140] Créer la migration CreateClients. 
[4352] Créer la migration CreateOperations (avec champ description pour les réceptions). 
[4140] Créer la migration CreateOperateur. 
[4352] Lancer toutes les migrations et vérifier dans la base que les tables sont correctes. 
[4140] Créer le seeder avec les données de test (clients fictifs : Alice 032..., Bob 033...). 
[4352] Insérer les vrais barèmes (Airtel, Orange, Yas) dans base.sql — retrait et transfert. 


Phase 3 — Authentification
[4140] Créer le formulaire de connexion client (par numéro de téléphone, sans mot de passe). 
[4352] Créer le formulaire de connexion opérateur avec liste déroulante (Airtel, Orange, Yas) et logos. 
[4352] Créer le contrôleur AuthController : connexion client auto-création, connexion opérateur par sélection. 
[4140] Créer le filtre qui protège l'espace client (bloque si non connecté). 
[4352] Créer le filtre qui protège l'espace opérateur (bloque si non connecté). 
[4140] Créer la déconnexion et vérifier qu'on ne peut plus revenir en arrière sur les pages protégées. 


Phase 4 — Espace Opérateur
[4352] Tableau de bord opérateur : affiche uniquement les clients de l'opérateur connecté (par préfixe). 
[4352] Formulaire et liste pour gérer les préfixes (ajouter, activer/désactiver, supprimer). 
[4352] Formulaire et liste pour gérer les types d'opération (ajouter, supprimer). 
[4352] Gestion des barèmes filtrée par opérateur : l'ajout enregistre automatiquement l'opérateur connecté. 
[4352] Affichage des barèmes filtrés : chaque opérateur ne voit que ses propres tranches de frais. 
[4352] Remplir les vrais barèmes (grilles MVola/Yas, Orange, Airtel) — retrait et transfert. 
[4352] Page des gains (calcul du total des frais collectés). 
[4352] Liste des clients filtrée : Yas → 034/038, Orange → 032/037, Airtel → 033/035. 
[4352] Page détail d'un client (solde + historique complet). 
[4352] Logo de l'opérateur affiché dans la navbar selon la session (images airtel.jpeg, orange.jpeg, yas.jpeg). 


Phase 5 — Espace Client
[4140] Tableau de bord client : affiche solde et 5 dernières opérations. 
[4140] Logo dynamique dans la barre latérale selon le préfixe du client connecté (vraie image opérateur). 
[4140] Formulaire d'opération : choix type (dépôt/retrait/transfert), montant, numéro destinataire si transfert. 
[4140] Calcul automatique des frais selon l'opérateur du client (par préfixe) et le barème correspondant. 
[4140] Gestion des erreurs : solde insuffisant, montant invalide, numéro invalide, transfert à soi-même. 
[4140] Lors d'un transfert : enregistrement d'une ligne "Réception" dans l'historique du destinataire. 
[4140] Page historique : badge vert "Réception" distinct + affichage de l'expéditeur (De : 034XXXXXXX). 
[4140] Texte et curseur toujours blancs dans les champs de saisie sur fond sombre (CSS). 


Phase 6 — Qualité & Tests
[4140 + 4352] Déplacer tout le CSS inline des vues vers le fichier unique public/css/app.css. 
[4140] Tester tout le parcours client de bout en bout (connexion → dépôt → retrait → transfert → historique → déconnexion).
[4352] Tester tout le parcours opérateur de bout en bout (connexion → préfixes → types → barèmes → gains → clients).
[4140] Tester les cas limites côté client (montant à 0, montant négatif, montant à la limite exacte d'un palier).
[4352] Tester les cas limites côté opérateur (palier avec un trou, deux paliers qui se chevauchent).
[4352] Supprimer la base de données, relancer ./lancer.sh, et confirmer que tout redémarre sans erreur.
[4140] Nettoyer le projet (fichiers de test/logs inutiles).


