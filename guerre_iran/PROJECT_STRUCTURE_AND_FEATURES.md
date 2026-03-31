# Structure et fonctionnalités du projet Guerre en Iran

## 1. Objectif global
Application web PHP simple avec séparation Front Office (visiteurs) et Back Office (administrateur), déployée via Docker Compose avec une base MySQL partagée.

## 2. Arborescence principale
```
create_admin.php
schema.sql
docker-compose.yml
admin/
  dashboard.php
  login.php
  logout.php
  articles/
    ajouter.php
    liste.php
    modifier.php
  includes/
    config.php
    database.php
    fonctions.php
front/
  index.php
  article.php
  robots.txt
  sitemap.xml
  css/style.css
  js/main.js
  includes/
    config.php
    database.php
    fonctions.php
docker/
  Dockerfile-BO
  Dockerfile-FO
  vhost-bo.conf
  vhost-fo.conf
docs/
  PROJECT_STRUCTURE.md
  README.md
  SETUP_GUIDE.md
  DEVELOPMENT_NOTES.md
```

## 3. Description des composants
- `front/` : site public
  - `index.php` : page d’accueil, liste des articles
  - `article.php` : détail d’un article
  - `robots.txt`, `sitemap.xml` : SEO
  - `css/`, `js/` : styles et scripts publics
  - `includes/` : configuration, connexion base de données en lecture seule, fonctions utilitaires

- `admin/` : interface de gestion
  - `login.php` / `logout.php` : authentification admin
  - `dashboard.php` : tableau de bord admin
  - `articles/` : CRUD articles (liste, ajout, modification)
  - `includes/` : configuration, base de données écriture/lecture, fonctions admin

- `docker/` : Dockerisation
  - Dockerfile-FO / Dockerfile-BO
  - vhost-fo.conf / vhost-bo.conf

- `docker-compose.yml` : orchestration des conteneurs (front, back, mysql)
- `schema.sql` : schéma de base de données
- `create_admin.php` : script de génération de mot de passe hashé pour utilisateur admin

## 4. Fonctionnalités principales
1. Architecture FO/BO séparée (code et conteneurs distincts)
2. Authentification admin avec stockage sécurisé du mot de passe (`password_hash`)
3. Gestion d’articles (CRUD) côté admin
4. Affichage d’articles côté public
5. Système de configuration localisé par zone (front/admin)
6. Connexion DB centralisée mais permissions distinctes (front lecture seule, admin CRUD)
7. Docker Compose pour exécution locale simplifiée
8. SEO (robots, sitemap)

## 5. Base de données
Tables attendues :
- `users` (admin)
- `categories` (facultatif pour catégories d’articles)
- `articles` (titre, contenu, date, catégorie…)

## 6. URLs de déploiement local (par défaut)
- Front Office : `http://localhost:8090`
- Back Office : `http://localhost:8091/login.php`
- MySQL : `localhost:3306`

---

> Remarque : le fichier `docs/PROJECT_STRUCTURE.md` existant contient déjà un descriptif très proche et peut être utilisé comme source unique.