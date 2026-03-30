# Résumé du Projet : Guerre en Iran

## Description du Projet
Ce projet est un site web d'information dédié à l'actualité et aux analyses sur la guerre en Iran. Il permet de publier et consulter des articles d'information, organisés par catégories, avec une interface d'administration pour gérer le contenu.

## Structure du Projet

```
guerre_iran-main/
├── create_admin.php          # Script pour créer le hash du mot de passe admin
├── robots.txt                # Configuration pour les robots des moteurs de recherche
├── schema.sql                # Schéma de la base de données MySQL
├── sitemap.xml               # Plan du site pour le référencement
├── admin/                    # Interface d'administration
│   ├── login.php             # Page de connexion admin
│   └── articles/
│       └── ajouter.php       # Page pour ajouter un nouvel article
├── docker/                   # Configuration Docker
│   ├── docker-compose.yml    # Orchestration des services (PHP + MySQL)
│   ├── Dockerfile            # Image Docker pour l'application PHP
│   └── vhost.conf            # Configuration Apache
├── includes/                 # Fichiers inclus (classes et fonctions)
│   ├── config.php            # Configuration générale du site
│   ├── database.php          # Classe de connexion et requêtes base de données
│   └── fonctions.php         # Fonctions utilitaires (non lues dans ce résumé)
└── public/                   # Dossier public accessible via le web
    ├── admin.php             # Page admin publique (?)
    ├── article.php           # Page d'affichage d'un article
    ├── index.php             # Page d'accueil avec liste des articles
    └── admin/                # Duplication ou sous-dossier admin
        └── login.php         # Connexion admin (duplication ?)
```

## Fonctionnalités Principales

### Front-End (Côté Utilisateur)
- **Page d'accueil** : Affiche les derniers articles publiés (10 par défaut), avec navigation par catégories.
- **Affichage des articles** : Pages individuelles pour chaque article, avec titre, contenu, image, métadonnées SEO, et compteur de vues.
- **Navigation par catégories** : Menu permettant de filtrer les articles par catégorie.
- **Optimisation SEO** : Métadonnées (title, description, keywords) pour chaque page et article.

### Back-End (Administration)
- **Authentification** : Système de connexion pour les administrateurs et éditeurs.
- **Dashboard** : Tableau de bord avec statistiques et articles récents.
- **Gestion des articles** : Ajouter, modifier, supprimer des articles avec :
  - Titre, contenu, image (upload avec validation de format : JPG, PNG, WebP, SVG).
  - Catégorie associée.
  - Métadonnées SEO personnalisées.
  - Statut (brouillon ou publié).
  - Pagination et filtres dans la liste.
- **Gestion des catégories** : Organisation des articles par catégories.
- **Gestion des utilisateurs** : Comptes admin et éditeur (rôles définis).

### Base de Données
- **Tables principales** :
  - `categories` : Catégories d'articles (nom, slug, description).
  - `articles` : Articles avec contenu, image, métadonnées, vues, statut.
  - `users` : Utilisateurs du back-office (admin par défaut : username 'admin', password 'admin123' hashé).
- **Relations** : Articles liés aux catégories via clé étrangère.

## Design et Interface
Le site utilise **Bootstrap 5.3.0** pour une interface responsive et moderne adaptée au grand public :
- **Layout responsive** : Colonnes adaptatives pour desktop et mobile
- **Cartes d'articles** : Design en cartes avec images, titres et extraits
- **Navigation** : Menu horizontal avec catégories
- **Couleurs** : Palette bleue professionnelle (#1e3c72, #2a5298)
- **Animations** : Transitions fluides et effets hover
- **Typographie** : Police moderne (Segoe UI) avec hiérarchie claire

Les styles personnalisés sont dans `public/css/style.css`, complétant Bootstrap pour un look cohérent.

### JavaScript
- **Interactions** : Animations au scroll, gestion d'erreurs d'images, smooth scroll (dans `public/js/main.js`)

## Optimisation SEO
Le projet inclut une optimisation SEO complète :
- **URLs propres** : Réécriture d'URLs via `.htaccess` (ex: `/article/titre` au lieu de `article.php?slug=titre`)
- **Métadonnées dynamiques** : Title, description, keywords personnalisés par page
- **Schema.org** : Données structurées JSON-LD pour les articles
- **Headers de sécurité** : X-Content-Type-Options, X-Frame-Options, etc.
- **Compression GZIP** : Réduction de la taille des fichiers
- **Cache navigateur** : Expiration optimisée pour les ressources statiques
- **Protection hotlink** : Prévention du vol d'images
- **Redirections 301** : Gestion des URLs avec/sans trailing slash

### Structure des Pages
- **Accueil** : Grille d'articles avec sidebar des catégories et bouton d'accès à l'administration
- **Article** : Mise en page centrée avec métadonnées et image
- **Admin** : Formulaire de connexion stylisé
- **Dashboard Admin** : Statistiques et gestion rapide
- **Liste Articles** : Interface complète avec pagination, filtres et recherche
- **Modifier Article** : Édition complète avec gestion d'image
- **Supprimer Article** : Confirmation de suppression sécurisée
- **Pages d'erreur** : 404 et 403 avec design cohérent

## URLs d'Administration
- `/admin/login` : Connexion administrateur
- `/admin/dashboard` : Tableau de bord principal
- `/admin/articles` : Liste des articles avec pagination et filtres
- `/admin/articles/ajouter` : Ajouter un nouvel article
- `/admin/articles/modifier/{id}` : Modifier un article existant
- `/admin/articles/supprimer/{id}` : Supprimer un article
- `/admin/logout` : Déconnexion

Toutes les URLs sont optimisées SEO avec des règles de réécriture dans `.htaccess`.
1. **Prérequis** : Docker et Docker Compose installés.
2. **Lancement** :
   ```bash
   cd docker
   docker-compose up -d
   ```
3. **Accès** :
   - Site : http://localhost:8090
   - Admin : http://localhost:8090/admin (login : admin / admin123)
3. **Administration** : Accédez à `/admin/login` avec les identifiants `admin` / `admin123`
5. **Images** : Les images placeholder SVG sont incluses dans `public/images/` pour les articles d'exemple.
5. **Arrêt** : `docker-compose down`

## Images et Médias
Le projet inclut des images placeholder SVG pour tous les articles d'exemple :
- `nego.svg` : Négociations diplomatiques
- `alliances.svg` : Carte des alliances régionales
- `front.svg` : Vue du front nord
- `equipements.svg` : Équipements militaires modernes
- `commerce.svg` : Graphique du commerce international
- `soutien.svg` : Aide économique distribuée
- `secours.svg` : Équipes de secours en action
- `deplaces.svg` : Camp de déplacés
- `journalistes.svg` : Journalistes sur le terrain

Ces images sont stockées dans `public/images/` et sont des SVG vectoriels légers qui s'affichent correctement dans les navigateurs.
- Le projet utilise une architecture MVC légère avec séparation des préoccupations (config, DB, fonctions).
- L'interface admin semble basique, probablement à compléter avec des pages de modification/suppression d'articles.
- Il y a une duplication apparente des dossiers/fichiers admin (dans /admin et /public/admin).
- Le mot de passe admin par défaut est 'admin123', hashé dans le schéma SQL.
- Le site est configuré pour le français (lang="fr").

## Améliorations Possibles
- Ajouter des pages de modification et suppression d'articles.
- Implémenter une pagination pour la liste des articles.
- Ajouter des commentaires ou un système de notation.
- Sécuriser davantage l'upload d'images.
- Intégrer un système de cache pour les performances.</content>
<parameter name="filePath">c:\Users\WINDOWS 11\Documents\S6\Mr Rojo\guerre_iran-main\README.md