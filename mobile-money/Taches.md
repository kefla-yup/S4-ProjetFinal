# Taches.md

Suivi des travaux effectués par livraison.

Binôme : **3877** et **4179**

---

## IMPORTANT :  FAIRE "composer install" AVANT TOUT 

## Livraison v1

### Étudiant 3877 — Côté opérateur (back-office) + base de données

| Fichier / Classe | Description | Statut |
|---|---|---|
| `base.sql` | Script de création des tables (`operateurs`, `prefixes`, `types_operation`, `baremes`, `clients`, `transactions`), des vues (`v_gains_par_type`, `v_situation_clients`) et des données de démarrage (préfixes, types d'opération, barèmes, compte admin) | OK |
| `app/Config/Routes.php` | Déclaration de toutes les routes de l'application (client + opérateur) | OK |
| `app/Controllers/BaseController.php` | Contrôleur de base, chargement des helpers et de la session | OK |
| `app/Controllers/Operateur/AuthController.php` | Connexion / déconnexion opérateur (vérification identifiant + mot de passe hashé) | OK |
| `app/Controllers/Operateur/DashboardController.php` | Tableau de bord opérateur (nombre de clients, gains par type) | OK |
| `app/Controllers/Operateur/PrefixeController.php` | Configuration des préfixes valables de l'opérateur (ajout / suppression) | OK |
| `app/Controllers/Operateur/OperationController.php` | Gestion des types d'opération et des barèmes de frais par tranche de montant (ajout / suppression, modifiable) | OK |
| `app/Controllers/Operateur/SituationController.php` | Situation des gains via les frais (retrait, transfert) et situation des comptes clients | OK |
| `app/Models/OperateurModel.php` | Modèle du compte opérateur, vérification des identifiants | OK |
| `app/Models/PrefixeModel.php` | Modèle des préfixes, vérification de validité d'un numéro | OK |
| `app/Models/TypeOperationModel.php` | Modèle des types d'opération | OK |
| `app/Models/BaremeModel.php` | Modèle des barèmes de frais par tranche | OK |
| `app/Views/layout/operateur.php` | Gabarit Bootstrap commun à l'espace opérateur (menu, alertes) | OK |
| `app/Views/operateur/login.php` | Vue de connexion opérateur | OK |
| `app/Views/operateur/dashboard.php` | Vue du tableau de bord opérateur | OK |
| `app/Views/operateur/prefixes.php` | Vue de configuration des préfixes | OK |
| `app/Views/operateur/operations.php` | Vue des types d'opération et barèmes de frais | OK |
| `app/Views/operateur/situation_gains.php` | Vue de la situation des gains | OK |
| `app/Views/operateur/situation_clients.php` | Vue de la situation des comptes clients | OK |
| `install.sh` | Script d'installation automatique (squelette CI4 + assemblage du projet + base SQLite) | OK |

### Étudiant 4179 — Côté client + calcul des frais

| Fichier / Classe | Description | Statut |
|---|---|---|
| `app/Controllers/Client/AuthController.php` | Connexion automatique par numéro de téléphone, création automatique du compte client (pas d'inscription), vérification du préfixe | OK |
| `app/Controllers/Client/DashboardController.php` | Consultation du solde, dépôt, retrait, transfert, historique des opérations | OK |
| `app/Models/ClientModel.php` | Modèle client : recherche/création automatique, crédit et débit du solde | OK |
| `app/Models/TransactionModel.php` | Modèle des transactions : historique client, agrégation des gains par type | OK |
| `app/Helpers/frais_helper.php` | Fonctions `calculer_frais()` (recherche de la tranche de barème applicable) et `formater_ariary()` | OK |
| `app/Views/layout/client.php` | Gabarit Bootstrap commun à l'espace client (menu, alertes) | OK |
| `app/Views/client/login.php` | Vue de connexion client (numéro de téléphone) | OK |
| `app/Views/client/dashboard.php` | Vue du tableau de bord client (solde + dernières opérations) | OK |
| `app/Views/client/depot.php` | Vue du formulaire de dépôt | OK |
| `app/Views/client/retrait.php` | Vue du formulaire de retrait | OK |
| `app/Views/client/transfert.php` | Vue du formulaire de transfert | OK |
| `app/Views/client/historique.php` | Vue de l'historique complet des opérations du client | OK |
| `composer.json` / `.env` | Configuration du projet (dépendances, base SQLite) | OK |

---

## Livraison v2

### Étudiant 3877 — Côté opérateur : préfixes externes, commission, situations détaillées

| Fichier / Classe | Description | Statut |
|---|---|---|
| `base.sql` | Ajout de la colonne `type` (interne/externe) et `operateur_nom` sur `prefixes` ; table `parametres` (commission externe) ; colonnes `commission_externe`, `frais_retrait_inclus`, `destination_type`, `destinataire_telephone`, `lot_id` sur `transactions` ; vues `v_gains_detail` et `v_montants_a_envoyer` | OK |
| `app/Models/PrefixeModel.php` | Ajout de `estPrefixeInterneValide()`, `typeDestination()`, `operateurExterne()`, `trouverPrefixe()` pour distinguer préfixes internes / autres opérateurs | OK |
| `app/Models/ParametreModel.php` | Nouveau modèle clé/valeur pour la configuration de la commission externe (%) | OK |
| `app/Models/TransactionModel.php` | Ajout de `gainsDetail()` (gains séparés interne/externe) et `montantsAEnvoyer()` | OK |
| `app/Controllers/Operateur/PrefixeController.php` | Ajout / suppression des préfixes avec distinction interne / externe (avec nom de l'opérateur concurrent) | OK |
| `app/Controllers/Operateur/ParametreController.php` | Nouveau contrôleur : configuration du % de commission sur les transferts vers les autres opérateurs | OK |
| `app/Controllers/Operateur/SituationController.php` | Page "Situation gain" séparée opérateur / autres opérateurs ; nouvelle page "Situation des montants à envoyer à chaque opérateur" | OK |
| `app/Views/operateur/prefixes.php` | Vue mise à jour : formulaire avec choix interne/externe + nom opérateur, deux tableaux séparés | OK |
| `app/Views/operateur/parametres.php` | Nouvelle vue : configuration de la commission externe | OK |
| `app/Views/operateur/situation_gains.php` | Vue mise à jour : deux tableaux (notre opérateur / autres opérateurs) + total général | OK |
| `app/Views/operateur/situation_montants.php` | Nouvelle vue : montants à envoyer par opérateur externe | OK |
| `app/Views/layout/operateur.php` | Ajout des liens de menu "Paramètres" et "Montants à envoyer" | OK |
| `app/Views/operateur/dashboard.php` | Ajout des raccourcis vers les nouvelles pages | OK |
| `app/Config/Routes.php` | Ajout des routes `operateur/parametres`, `operateur/situation/montants-a-envoyer` | OK |

### Étudiant 4179 — Côté client : frais de retrait inclus, envoi multiple

| Fichier / Classe | Description | Statut |
|---|---|---|
| `app/Controllers/Client/AuthController.php` | Connexion limitée aux préfixes internes uniquement (`estPrefixeInterneValide`) | OK |
| `app/Controllers/Client/DashboardController.php` | Refonte du transfert : détection interne/externe, calcul de la commission externe, option "inclure frais de retrait lors de l'envoi" (`executerTransfert()` factorisé), nouvel envoi multiple (`transfertMultipleForm()` / `transfertMultiple()`) avec répartition équitable du montant entre plusieurs numéros | OK |
| `app/Helpers/frais_helper.php` | Ajout de `calculer_commission_externe()` | OK |
| `app/Views/client/transfert.php` | Ajout de la case à cocher "Inclure les frais de retrait du destinataire" | OK |
| `app/Views/client/transfert_multiple.php` | Nouvelle vue : envoi vers plusieurs numéros avec montant total réparti automatiquement | OK |
| `app/Views/client/dashboard.php` | Ajout du bouton "Envoi multiple" et prise en compte de la commission dans l'affichage des frais | OK |
| `app/Views/client/historique.php` | Affichage du badge "autre opérateur" et du détail des frais de retrait inclus | OK |

---
