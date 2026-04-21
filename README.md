# FlowFix

FlowFix est une application web dédiée à l'amélioration continue au sein d'une équipe de travail. Elle permet à chaque membre d'exprimer les *irritants* rencontrés au quotidien (petits problèmes non bloquants mais qui nuisent à la performance et à l'engagement) et de les prioriser collectivement grâce à un système de vote par cycle.

## Concept

- Un utilisateur peut créer un ou plusieurs groupes de travail et y ajouter des membres.
- Chaque membre peut déposer des irritants sur son groupe.
- Le groupe fonctionne par cycles (durée et nombre d'irritants à traiter configurables).
- En début de cycle, les membres votent pour choisir les irritants à traiter.
- Un pilote est désigné aléatoirement pour proposer une solution, qui est ensuite validée par le groupe.

Trois rôles principaux : **Visiteur**, **Utilisateur**, **Administrateur**.
Des sous-rôles existent au sein d'un groupe : Membre, Auteur, Pilote, Modérateur.

## Stack technique

- **Back-end** : PHP 8 (sans framework), architecture MVCS (Model-View-Controller-Service), POO
- **Base de données** : MySQL, accès via PDO (requêtes préparées)
- **Front-end** : HTML, SASS (compilé en CSS), JavaScript vanilla
- **Serveur** : Apache (avec `mod_rewrite` activé)

## Prérequis

- PHP **8.0** ou supérieur (avec l'extension `pdo_mysql`)
- MySQL **8.0** ou supérieur (ou MariaDB équivalent)
- Apache **2.4** ou supérieur, avec `mod_rewrite` activé
- Un compilateur SASS si vous souhaitez modifier les styles (Dart Sass, Node.js, etc.)

Un environnement local type **XAMPP**, **WAMP** ou **MAMP**.

## Installation

1. **Cloner le dépôt** dans le répertoire web de votre serveur 

2. **Importer la base de données** via phpMyAdmin 

   Le fichier SQL crée la base `FLOWFIX` ainsi que toutes les tables nécessaires.

3. **Configurer la connexion à la base** dans un fichier .env :

   DB_NAME = 'FLOWFIX'
   DB_HOST = ''
   DB_USER = ''
   DB_PASSWORD = ''
   DB_PORT = ''

4. **Réécriture des URLs** (présence d'un `.htaccess` à la racine, `mod_rewrite` activé).

   RewriteEngine On
   RewriteCond %{REQUEST_FILENAME} !-f
   RewriteCond %{REQUEST_FILENAME} !-d
   RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]

5. Accéder à l'application depuis votre navigateur : `http://localhost/flowfix/`.

## Structure du projet

L'application suit une architecture **MVCS** :

- `Controllers/` — Réception des requêtes, orchestration des appels aux services et des vues
- `Services/` — Logique métier
- `Models/` — Accès aux données (requêtes SQL via PDO)
- `Views/` — Affichage (templates PHP)
- `Core/` — Classes de base (BaseController, BaseModel, BaseService, Routeur, etc.)

## Sécurité

- Hachage des mots de passe (`password_hash` / `password_verify`)
- Requêtes préparées PDO (protection contre les injections SQL)
- Échappement des sorties utilisateur (protection contre les failles XSS)
- Validation des données côté serveur

## Comptes de test

Après l'import de la base, des comptes de démonstration sont disponibles pour tester les différents rôles (utilisateur standard, modérateur de groupe, administrateur). Voir les données insérées dans le fichier SQL. Mot de passe : "motdepasse".

## Auteur

Projet réalisé dans le cadre de la certification **Développeur Web Full Stack (RNCP 37273)**.
