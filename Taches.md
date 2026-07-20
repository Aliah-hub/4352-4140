V1
Phase 1 
(ok) [4352 + 4140] Creer le projet CodeIgniter 4 avec Composer et verifier que la page d'accueil s'affiche. 
(ok) [4352 + 4140] Mettre en place Git : depôt local, premier commit, depôt distant (GitHub). 
(ok) [4352 + 4140] Se repartir les rôles : 4140 : partie Client, 4352 : partie Operateur/Admin. 

Phase 2
(ok) [4352] Lister toutes les informations à stocker (client, operateur, prefixes, types d'operation, barèmes, operations). 
(ok) [4140] Dessiner le schema de la base de donnees (tables + liens entre elles). 
(ok) [4352] Creer la migration CreatePrefixes. 
(ok) [4140] Creer la migration CreateTypeOperations. 
(ok) [4352] Creer la migration CreateBaremes (avec colonne operateur_nom pour separer les frais par operateur). 
(ok) [4140] Creer la migration CreateClients. 
(ok) [4352] Creer la migration CreateOperations (avec champ description pour les receptions). 
(ok) [4140] Creer la migration CreateOperateur. 
(ok) [4352] Lancer toutes les migrations et verifier dans la base que les tables sont correctes. 
(ok) [4140] Creer le seeder avec les donnees de test (clients fictifs : Alice 032..., Bob 033...). 
(ok) [4352] Inserer les vrais barèmes (Airtel, Orange, Yas) dans base.sql — retrait et transfert. 


Phase 3
(ok) [4140] Creer le formulaire de connexion client (par numero de telephone, sans mot de passe). 
(ok) [4352] Creer le formulaire de connexion operateur avec liste deroulante (Airtel, Orange, Yas) et logos. 
(ok) [4352] Creer le contrôleur AuthController : connexion client auto-creation, connexion operateur par selection. 
(ok) [4140] Creer le filtre qui protège l'espace client (bloque si non connecte). 
(ok) [4352] Creer le filtre qui protège l'espace operateur (bloque si non connecte). 
(ok) [4140] Creer la deconnexion et verifier qu'on ne peut plus revenir en arrière sur les pages protegees. 


Phase 4 
(ok) [4352] Tableau de bord operateur : affiche uniquement les clients de l'operateur connecte (par prefixe). 
(ok) [4352] Formulaire et liste pour gerer les prefixes (ajouter, activer/desactiver, supprimer). 
(ok) [4352] Formulaire et liste pour gerer les types d'operation (ajouter, supprimer). 
(ok) [4352] Gestion des barèmes filtree par operateur : l'ajout enregistre automatiquement l'operateur connecte. 
(ok) [4352] Affichage des barèmes filtres : chaque operateur ne voit que ses propres tranches de frais. 
(ok) [4352] Remplir les vrais barèmes (grilles MVola/Yas, Orange, Airtel) — retrait et transfert. 
(ok) [4352] Page des gains (calcul du total des frais collectes). 
(ok) [4352] Liste des clients filtree : Yas : 034/038, Orange : 032/037, Airtel : 033/035. 
(ok) [4352] Page detail d'un client (solde + historique complet). 
(ok) [4352] Logo de l'operateur affiche dans la navbar selon la session (images airtel.jpeg, orange.jpeg, yas.jpeg). 


Phase 5 
(ok) [4140] Tableau de bord client : affiche solde et 5 dernières operations. 
(ok) [4140] Logo dynamique dans la barre laterale selon le prefixe du client connecte (vraie image operateur). 
(ok) [4140] Formulaire d'operation : choix type (depôt/retrait/transfert), montant, numero destinataire si transfert. 
(ok) [4140] Calcul automatique des frais selon l'operateur du client (par prefixe) et le barème correspondant. 
(ok) [4140] Gestion des erreurs : solde insuffisant, montant invalide, numero invalide, transfert à soi-même. 
(ok) [4140] Lors d'un transfert : enregistrement d'une ligne "Reception" dans l'historique du destinataire. 
(ok) [4140] Page historique : badge vert "Reception" distinct + affichage de l'expediteur (De : 034XXXXXXX). 
(ok) [4140] Texte et curseur toujours blancs dans les champs de saisie sur fond sombre (CSS). 


Phase 6 
(ok) [4140 + 4352] Deplacer tout le CSS inline des vues vers le fichier unique public/css/app.css. 
(ok) [4140] Tester tout le parcours client de bout en bout (connexion : depôt : retrait : transfert : historique : deconnexion).
(ok) [4352] Tester tout le parcours operateur de bout en bout (connexion : prefixes : types : barèmes : gains : clients).
(ok) [4140] Tester les cas limites côte client (montant à 0, montant negatif, montant à la limite exacte d'un palier).
(ok) [4352] Tester les cas limites côte operateur (palier avec un trou, deux paliers qui se chevauchent).
(ok) [4352] Supprimer la base de donnees, relancer ./lancer.sh, et confirmer que tout redemarre sans erreur.
(ok) [4140] Nettoyer le projet (fichiers de test/logs inutiles).


V2 
Phase 1
(ok) [4352] Base de données : Ajouter plus de données de test (transferts, retraits, dépôts) dans la base et dans base.sql pour mieux simuler l'activité.
(ok) [4352] Authentification Opérateur : Simplifier le login pour n'avoir qu'une seule connexion (un simple bouton "Accéder au dashboard" sans liste déroulante).

Phase 2
(ok) [4352] Configuration : Ajouter une option pour configurer le % de commission en plus pour les transferts vers les autres opérateurs.
(ok) [4352] Dashboard Opérateur : Fusionner l'affichage sur un seul dashboard et ajouter un filtre dynamique pour voir les clients par opérateur (Options : Tous, Yas, Airtel, Orange).

Phase 3 
(ok) [4352] Comptabilité : Sur la page “Situation gain via les différents frais”, séparer clairement les gains "opérateur" (Yas) et "autres opérateurs".
(ok) [4352] Comptabilité : Afficher la situation des montants à envoyer à chaque opérateur (Airtel, Orange, Yas).

Phase 4 
(ok) [4140] Opération Client : Ajouter l'option "inclure frais de retrait" lors d'un transfert (le montant sera augmenté pour couvrir les frais).
(ok) [4140] Opération Client : Permettre l'envoi multiple vers plusieurs numéros simultanément (en divisant le montant total pour chaque destinataire).

Phase 5
(ok) [4140] Dashboard Client : Ajout de raccourcis dynamiques (paramètres URL) sur les boutons d'actions rapides (Depôt, Retrait, Transfert).
(ok) [4140] Formulaire d'Operation : Creation d'un script JavaScript pour pre-selectionner automatiquement les champs selon le bouton clique sur le dashboard.
