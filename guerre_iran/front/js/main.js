// ========================================
// SCRIPT PRINCIPAL - SITE GUERRE EN IRAN
// Interactions modernes et UX améliorée
// ========================================

document.addEventListener('DOMContentLoaded', function() {

    // ========================================
    // ANIMATIONS AU SCROLL
    // ========================================

    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Animation des cartes d'articles
    document.querySelectorAll('.article-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1), transform 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
        observer.observe(card);
    });

    // Animation du contenu principal
    document.querySelectorAll('.content-area, .sidebar').forEach(element => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(20px)';
        element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(element);
    });

    // ========================================
    // GESTION DES IMAGES
    // ========================================

    // Lazy loading des images
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }

    // Gestion des erreurs d'images
    document.querySelectorAll('img').forEach(img => {
        img.addEventListener('error', function() {
            // Créer un placeholder SVG
            this.src = 'data:image/svg+xml;base64,' + btoa(`
                <svg width="400" height="200" xmlns="http://www.w3.org/2000/svg">
                    <rect width="100%" height="100%" fill="#f8f8f8"/>
                    <text x="50%" y="50%" text-anchor="middle" dy=".3em" fill="#999" font-family="sans-serif" font-size="16">Image non disponible</text>
                </svg>
            `);
            this.alt = 'Image non disponible';
        });
    });

    // ========================================
    // NAVIGATION ET SCROLL
    // ========================================

    // Smooth scroll pour les ancres
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href !== '#') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    const headerOffset = 100;
                    const elementPosition = target.offsetTop;
                    const offsetPosition = elementPosition - headerOffset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });

    // Sticky header avec effet de réduction
    let lastScrollTop = 0;
    const header = document.querySelector('header');

    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        if (scrollTop > lastScrollTop && scrollTop > 100) {
            // Scroll down - réduire header
            header.style.transform = 'translateY(-10px)';
            header.style.boxShadow = '0 2px 20px rgba(0,0,0,0.1)';
        } else {
            // Scroll up - restaurer header
            header.style.transform = 'translateY(0)';
        }

        lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
    });

    // ========================================
    // INTERACTIONS UTILISATEUR
    // ========================================

    // Effet hover amélioré sur les liens de navigation
    document.querySelectorAll('.nav-list a').forEach(link => {
        link.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });

        link.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Animation des boutons "Lire la suite"
    document.querySelectorAll('.read-more').forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(5px)';
        });

        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });

    // ========================================
    // ACCESSIBILITÉ
    // ========================================

    // Gestion du focus pour la navigation clavier
    document.querySelectorAll('a, button').forEach(element => {
        element.addEventListener('focus', function() {
            this.style.outline = '2px solid #c8102e';
            this.style.outlineOffset = '2px';
        });

        element.addEventListener('blur', function() {
            this.style.outline = '';
            this.style.outlineOffset = '';
        });
    });

    // ========================================
    // PERFORMANCE
    // ========================================

    // Préchargement des pages au hover (pour navigation rapide)
    let preloadTimeout;
    document.querySelectorAll('a[href]').forEach(link => {
        link.addEventListener('mouseenter', function() {
            const href = this.href;
            if (href && !href.includes('#') && !href.includes('javascript:')) {
                preloadTimeout = setTimeout(() => {
                    const linkPreload = document.createElement('link');
                    linkPreload.rel = 'prefetch';
                    linkPreload.href = href;
                    document.head.appendChild(linkPreload);
                }, 100);
            }
        });

        link.addEventListener('mouseleave', function() {
            clearTimeout(preloadTimeout);
        });
    });

    // ========================================
    // RESPONSIVE
    // ========================================

    // Gestion du menu mobile (si ajouté plus tard)
    function handleResize() {
        const width = window.innerWidth;

        if (width <= 768) {
            // Ajustements pour mobile
            document.querySelectorAll('.article-card').forEach(card => {
                card.style.marginBottom = '1rem';
            });
        } else {
            // Ajustements pour desktop
            document.querySelectorAll('.article-card').forEach(card => {
                card.style.marginBottom = '0';
            });
        }
    }

    window.addEventListener('resize', handleResize);
    handleResize(); // Appel initial

    // ========================================
    // ANALYTICS (si nécessaire)
    // ========================================

    // Tracking des clics sur les articles
    document.querySelectorAll('.article-title a').forEach(link => {
        link.addEventListener('click', function() {
            // Peut être étendu pour Google Analytics ou autre
            console.log('Article clicked:', this.href);
        });
    });

});
    document.querySelectorAll('.confirm-action').forEach(link => {
        link.addEventListener('click', function(e) {
            if (!confirm('Êtes-vous sûr de vouloir effectuer cette action ?')) {
                e.preventDefault();
            }
        });
    });
});