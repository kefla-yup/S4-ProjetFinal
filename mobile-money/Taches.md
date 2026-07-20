# Taches.md

Suivi des travaux effectués par livraison.

Binôme : **3877** et **4179**

---

Faire avant tout : "composer install" dans terminal 

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
