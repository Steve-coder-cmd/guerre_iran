-- Données d'exemple pour le projet Guerre en Iran
-- Insérer ces données après avoir créé la base de données avec schema.sql

USE guerre_iran;

-- Insertion des catégories d'exemple
INSERT INTO categories (nom, slug, description) VALUES
('Politique', 'politique', 'Analyses politiques du conflit'),
('Militaire', 'militaire', 'Développements militaires et stratégiques'),
('Économique', 'economique', 'Impacts économiques du conflit'),
('Humanitaire', 'humanitaire', 'Situations humanitaires et aide internationale');

-- Insertion des articles d'exemple
INSERT INTO articles (titre, slug, contenu, image, image_alt, categorie_id, meta_title, meta_description, meta_keywords, views, status, created_at) VALUES
-- Articles Politique
('Évolution des négociations diplomatiques', 'evolution-negociations-diplomatiques', 'Les négociations internationales concernant le conflit en Iran ont connu des avancées significatives ces dernières semaines. Les parties prenantes ont convenu d\'une trêve temporaire permettant la livraison d\'aide humanitaire dans les zones affectées. Les diplomates soulignent l\'importance du dialogue multilatéral pour parvenir à une résolution pacifique.', 'nego.jpg', 'Négociations diplomatiques', 1, 'Négociations diplomatiques - Guerre en Iran', 'Suivez l\'évolution des négociations diplomatiques dans le conflit iranien', 'iran, diplomatie, négociations, conflit', 150, 'published', '2024-03-01 10:00:00'),

('Impact sur les alliances régionales', 'impact-alliances-regionales', 'Le conflit a profondément modifié le paysage des alliances au Moyen-Orient. Plusieurs pays voisins ont renforcé leurs partenariats stratégiques, tandis que d\'autres ont adopté une position de neutralité prudente. Les analystes observent une reconfiguration des équilibres régionaux qui pourrait avoir des conséquences à long terme.', 'alliances.jpg', 'Carte des alliances régionales', 1, 'Alliances régionales - Conflit Iran', 'Analyse des changements dans les alliances régionales dues au conflit', 'iran, alliances, moyen-orient, diplomatie', 200, 'published', '2024-03-05 14:30:00'),

-- Articles Militaire
('Développements sur le front nord', 'developpements-front-nord', 'Les forces militaires ont enregistré des mouvements stratégiques importants sur le front nord. Les opérations de reconnaissance ont permis d\'identifier de nouvelles positions défensives. Les experts militaires soulignent l\'importance de la logistique dans le maintien des lignes de front.', 'front.jpg', 'Vue du front nord', 2, 'Front nord - Développements militaires', 'Derniers développements militaires sur le front nord du conflit', 'iran, militaire, front, stratégie', 300, 'published', '2024-03-03 09:15:00'),

('Modernisation des équipements', 'modernisation-equipements', 'Le conflit a accéléré les programmes de modernisation militaire. De nouveaux équipements ont été déployés, améliorant la capacité opérationnelle des forces engagées. Les analystes notent une évolution rapide des technologies utilisées sur le terrain.', 'equipements.jpg', 'Équipements militaires modernes', 2, 'Modernisation militaire - Iran', 'Évolution des équipements militaires dans le conflit iranien', 'iran, militaire, équipements, technologie', 180, 'published', '2024-03-07 16:45:00'),

-- Articles Économique
('Conséquences sur le commerce international', 'consequences-commerce-international', 'Le conflit a perturbé les routes commerciales traditionnelles, affectant les échanges internationaux. Les prix des matières premières ont fluctué de manière significative. Les économistes prévoient une période d\'instabilité prolongée sur les marchés mondiaux.', 'commerce.jpg', 'Graphique du commerce international', 3, 'Commerce international - Impact économique', 'Conséquences économiques du conflit sur le commerce mondial', 'iran, économie, commerce, marchés', 120, 'published', '2024-03-02 11:20:00'),

('Mesures de soutien économique', 'mesures-soutien-economique', 'Les gouvernements ont annoncé diverses mesures de soutien pour atténuer l\'impact économique du conflit. Des programmes d\'aide directe aux populations affectées et des subventions aux secteurs clés ont été mis en place. L\'efficacité de ces mesures reste à évaluer dans les prochains mois.', 'soutien.jpg', 'Aide économique distribuée', 3, 'Soutien économique - Conflit Iran', 'Mesures gouvernementales de soutien économique face au conflit', 'iran, économie, aide, gouvernement', 95, 'published', '2024-03-08 13:10:00'),

-- Articles Humanitaire
('Opérations de secours en cours', 'operations-secours-cours', 'Les organisations humanitaires intensifient leurs opérations de secours dans les zones les plus touchées. La distribution de nourriture, d\'eau et de médicaments se poursuit malgré les difficultés logistiques. Plus de 50 000 personnes ont bénéficié de l\'aide d\'urgence cette semaine.', 'secours.jpg', 'Équipes de secours en action', 4, 'Opérations de secours - Iran', 'Activités humanitaires en cours dans les zones de conflit', 'iran, humanitaire, secours, aide', 250, 'published', '2024-03-04 08:00:00'),

('Situation des populations déplacées', 'situation-populations-deplacees', 'Le nombre de personnes déplacées internes continue d\'augmenter. Les camps temporaires peinent à faire face à l\'afflux croissant. Les ONG appellent à une mobilisation internationale accrue pour répondre aux besoins essentiels des populations vulnérables.', 'deplaces.jpg', 'Camp de déplacés', 4, 'Populations déplacées - Crise humanitaire', 'Situation critique des populations déplacées en Iran', 'iran, humanitaire, déplacés, crise', 175, 'published', '2024-03-06 12:30:00'),

-- Articles en brouillon (exemples)
('Analyse des sanctions internationales', 'analyse-sanctions-internationales', 'Les sanctions économiques imposées ont eu des effets contrastés sur l\'économie locale. Alors que certains secteurs ont souffert, d\'autres ont développé des stratégies d\'adaptation. Cette analyse examine les impacts à moyen et long terme.', NULL, NULL, 3, 'Sanctions internationales - Analyse', 'Étude des effets des sanctions sur l\'économie iranienne', 'iran, sanctions, économie, analyse', 0, 'draft', '2024-03-09 10:00:00'),

('Témoignages de journalistes sur le terrain', 'temoignages-journalistes-terrain', 'Des journalistes indépendants partagent leurs expériences du conflit. Leurs témoignages offrent un regard unique sur la réalité quotidienne des populations affectées. Ces récits soulignent l\'importance du journalisme de terrain dans la compréhension des crises.', 'journalistes.jpg', 'Journalistes sur le terrain', 4, 'Témoignages journalistes - Iran', 'Récits de journalistes couvrant le conflit iranien', 'iran, journalisme, témoignages, conflit', 0, 'draft', '2024-03-10 15:20:00');