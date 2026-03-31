# Site Guerre en Iran - Version Professionnelle

## Vue d'ensemble

Site d'information sur la guerre en Iran avec architecture Front Office / Back Office séparée, conçu pour publication grand public avec un design professionnel inspiré de Le Monde.

## Fonctionnalités

### Front Office (Public)
- **Design moderne** : Layout responsive inspiré de la presse professionnelle
- **Articles** : Affichage en grille avec métadonnées complètes
- **SEO optimisé** : Meta tags, structured data, sitemap
- **Performance** : Animations au scroll, lazy loading, préchargement
- **Accessibilité** : Navigation clavier, contrastes élevés

### Back Office (Administration)
- **Interface cohérente** : Bootstrap personnalisé avec thème professionnel
- **Gestion d'articles** : CRUD complet avec upload d'images
- **Dashboard** : Statistiques et actions rapides
- **Sécurité** : Authentification, CSRF protection

## Architecture Technique

### Technologies
- **Backend** : PHP 8+ avec PDO
- **Base de données** : MySQL/MariaDB
- **Frontend** : HTML5, CSS3 (variables CSS), JavaScript ES6+
- **Admin** : Bootstrap 5 personnalisé
- **Conteneurisation** : Docker Compose

### Structure des fichiers
```
guerre_iran/
├── front/                 # Site public
│   ├── css/style.css     # Design professionnel FO
│   ├── js/main.js        # Interactions modernes
│   ├── index.php         # Page d'accueil
│   └── article.php       # Détail d'article
├── admin/                # Interface admin
│   ├── css/admin.css     # Thème admin cohérent
│   ├── dashboard.php     # Tableau de bord
│   └── articles/         # Gestion articles
├── docker/               # Configuration Docker
└── docs/                 # Documentation
```

## Design System

### Palette de couleurs
- **Primaire foncé** : `#1a1a1a` (titres, texte principal)
- **Rouge accent** : `#c8102e` (liens, boutons, catégories)
- **Texte clair** : `#666666` (métadonnées)
- **Fond clair** : `#f8f8f8` (arrière-plan)

### Typographie
- **Titres** : Times New Roman / Georgia (serif)
- **Corps** : Helvetica Neue / Arial (sans-serif)
- **Monospace** : Courier New (code)

### Composants clés
- **Header sticky** avec navigation horizontale
- **Articles en grille** responsive
- **Sidebar** avec catégories
- **Footer** minimal
- **Cartes** avec hover effects

## Installation et déploiement

### Prérequis
- Docker & Docker Compose
- PHP 8.0+
- MySQL 8.0+

### Démarrage rapide
```bash
# Cloner le projet
git clone <repository-url>
cd guerre_iran-separate_admin

# Lancer les conteneurs
docker-compose up -d

# Initialiser la base de données
docker exec -it guerre_iran_mysql mysql -u root -p < schema.sql

# Injecter des données de test
# Exécuter les INSERT SQL depuis les données de test
```

### URLs d'accès
- **Front Office** : http://localhost:8090
- **Back Office** : http://localhost:8091/login.php
- **Base de données** : localhost:3306

### Compte admin par défaut
- **Utilisateur** : admin
- **Mot de passe** : admin123

## Développement

### Structure CSS
Le design utilise des variables CSS pour faciliter la maintenance :
```css
:root {
    --primary-dark: #1a1a1a;
    --primary-red: #c8102e;
    /* ... autres variables */
}
```

### Responsive Design
- **Desktop** : > 1024px - Layout 2 colonnes
- **Tablet** : 768-1024px - Layout ajusté
- **Mobile** : < 768px - Layout single colonne

### Performance
- **Lazy loading** des images
- **Préchargement** des pages au hover
- **Animations optimisées** avec `prefers-reduced-motion`
- **Compression** activée dans `.htaccess`

## SEO et accessibilité

### SEO
- Meta titles et descriptions dynamiques
- Structured data (JSON-LD) pour articles
- URLs SEO-friendly avec slugs
- Sitemap.xml et robots.txt

### Accessibilité
- Navigation clavier complète
- Contrastes de couleurs élevés
- Labels et attributs ARIA
- Focus visible
- Support `prefers-reduced-motion`

## Sécurité

### Mesures implémentées
- **Authentification** avec hash sécurisé (password_hash)
- **Protection CSRF** sur les formulaires
- **Validation** des entrées utilisateur
- **Upload sécurisé** avec vérification de type
- **Sessions PHP** sécurisées

### Bonnes pratiques
- Séparation FO/BO avec conteneurs distincts
- Permissions base de données différenciées
- Sanitisation des données
- Logs d'erreurs

## Contribution

### Guidelines de développement
1. Respecter la structure CSS (variables, BEM-like)
2. Maintenir la cohérence FO/BO
3. Tester sur tous les breakpoints
4. Valider l'accessibilité
5. Documenter les changements

### Outils recommandés
- **CSS** : Variables natives, Flexbox/Grid
- **JS** : Vanilla ES6+, Intersection Observer
- **PHP** : PDO préparé, fonctions utilitaires
- **Docker** : Multi-stage builds

## Licence

Tous droits réservés - Site d'information sur la guerre en Iran.

---

*Design professionnel créé pour publication grand public, inspiré des standards de la presse en ligne.*
- 🛡️ Security best practices

## Documentation

- [**Project Structure**](PROJECT_STRUCTURE.md) - Complete directory overview
- [**Setup Guide**](SETUP_GUIDE.md) - Installation and configuration
- [**Development Notes**](DEVELOPMENT_NOTES.md) - Technical details and decisions

## Requirements

- Docker Desktop
- Git (optional)

## Development

### Front Office Development
```bash
# Edit files in front/ directory
# Changes auto-reload
# URL: http://localhost:8090
```

### Back Office Development
```bash
# Edit files in admin/ directory  
# Changes auto-reload
# URL: http://localhost:8091
```

## Commands

```bash
# Start services
docker-compose up -d

# Stop services
docker-compose down

# View logs
docker-compose logs -f

# Rebuild containers
docker-compose up --build -d
```

## Security

- 🔐 Password hashing with bcrypt
- 🛡️ SQL injection prevention
- 🔒 XSS protection
- 🚫 CSRF protection
- 👤 Role-based access control

## Database

- **Host**: localhost:3306
- **Database**: guerre_iran
- **User**: root
- **Password**: password

## Contributing

1. Fork the repository
2. Create feature branch
3. Make changes
4. Test thoroughly
5. Submit pull request

## License

[Your License Here]

---

**Built with ❤️ using Docker, PHP, and MySQL**
