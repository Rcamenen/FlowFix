-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : sam. 18 avr. 2026 à 23:13
-- Version du serveur : 9.6.0
-- Version de PHP : 8.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `FLOWFIX`
--

-- --------------------------------------------------------

--
-- Structure de la table `ADMINS`
--

CREATE TABLE `ADMINS` (
  `id` int NOT NULL,
  `registered_at` datetime NOT NULL,
  `email` varchar(320) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ADMINS`
--

INSERT INTO `ADMINS` (`id`, `registered_at`, `email`, `firstname`, `lastname`, `username`, `password_hash`) VALUES
(1, '2026-04-18 22:13:18', 'admin@test.com', 'Chuck', 'Norris', 'Nono', '$2y$12$nOAmFk8k2MBWsK.14mOyyuSbg6qJsfpFo4rOX4C/.zouTShJw.QDe');

-- --------------------------------------------------------

--
-- Structure de la table `CYCLES`
--

CREATE TABLE `CYCLES` (
  `id` int NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `max_active_treatments` int NOT NULL,
  `treatments_voting_delay` int NOT NULL,
  `team_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `CYCLES`
--

INSERT INTO `CYCLES` (`id`, `start_date`, `end_date`, `max_active_treatments`, `treatments_voting_delay`, `team_id`) VALUES
(1, '2026-04-02 09:00:00', '2026-04-16 09:00:00', 3, 3, 1),
(2, '2026-04-04 09:00:00', '2026-04-19 01:32:27', 2, 4, 2),
(3, '2026-04-06 09:00:00', '2026-04-13 09:00:00', 4, 2, 3),
(4, '2026-04-01 09:00:00', '2026-04-19 06:00:00', 1, 5, 4),
(5, '2026-04-08 09:00:00', '2026-04-18 09:00:00', 3, 3, 5),
(6, '2026-04-05 09:00:00', '2026-04-19 00:33:46', 2, 4, 6),
(7, '2026-04-14 09:00:00', '2026-04-19 09:00:00', 4, 2, 7),
(8, '2026-04-03 09:00:00', '2026-04-20 00:33:53', 1, 5, 8),
(9, '2026-04-10 09:00:00', '2026-04-19 00:05:00', 3, 3, 9),
(10, '2026-04-09 09:00:00', '2026-04-19 09:00:00', 2, 2, 10),
(11, '2026-04-18 22:30:42', '2026-05-02 22:30:42', 3, 3, 1),
(13, '2026-04-18 22:53:44', '2026-04-28 22:53:44', 3, 3, 5);

-- --------------------------------------------------------

--
-- Structure de la table `FRICTIONS`
--

CREATE TABLE `FRICTIONS` (
  `id` int NOT NULL,
  `created_at` datetime NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(2000) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `author_id` int NOT NULL,
  `team_id` int NOT NULL,
  `status_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `FRICTIONS`
--

INSERT INTO `FRICTIONS` (`id`, `created_at`, `title`, `description`, `updated_at`, `author_id`, `team_id`, `status_id`) VALUES(1, '2026-04-08 08:10:00', 'Réunions trop longues', 'Les réunions hebdomadaires durent souvent 2h sans ordre du jour clair.', NULL, 1, 1, 1),
(1, '2026-04-08 08:10:00', 'Réunions trop longues', 'Les réunions hebdomadaires durent souvent 2h sans ordre du jour clair.', NULL, 1, 1, 1),
(2, '2026-04-08 09:30:00', 'Manque de documentation des procédures', 'Aucune procédure interne n\'est formalisée, ce qui ralentit les nouvelles recrues.', NULL, 11, 1, 1),
(3, '2026-04-08 14:00:00', 'Outils de suivi non uniformisés', 'Chaque membre utilise un outil différent (Trello, Notion, Excel).', NULL, 12, 1, 1),
(4, '2026-04-09 08:45:00', 'Délais de validation trop longs', 'Les validations de livrables prennent plus d\'une semaine en moyenne.', NULL, 13, 1, 1),
(5, '2026-04-09 10:20:00', 'Absence de rituels d\'équipe', 'Pas de stand-up quotidien, la coordination est difficile.', NULL, 1, 1, 1),
(6, '2026-04-09 14:30:00', 'Doublons dans les tâches assignées', 'Plusieurs membres travaillent parfois sur la même tâche sans le savoir.', NULL, 11, 1, 1),
(7, '2026-04-10 09:00:00', 'Pas de rétrospective post-projet', 'Aucune rétrospective n\'est organisée en fin de projet.', NULL, 12, 1, 1),
(8, '2026-04-10 11:15:00', 'Onboarding insuffisant', 'Les nouvelles recrues sont livrées à elles-mêmes les premières semaines.', NULL, 13, 1, 1),
(9, '2026-04-10 15:00:00', 'Communication inter-équipes inexistante', 'Les équipes ne se parlent pas, créant des dépendances non gérées.', NULL, 1, 1, 1),
(10, '2026-04-11 08:30:00', 'Surcharge d\'emails internes', 'Les échanges par email noient les informations importantes.', NULL, 11, 1, 1),
(11, '2026-04-11 10:00:00', 'Manque de visibilité sur les priorités', 'Les membres ne savent pas quelles tâches prioriser en cas de surcharge.', NULL, 12, 1, 1),
(12, '2026-04-11 14:20:00', 'Absence de KPIs d\'équipe', 'Aucun indicateur ne permet de mesurer la performance collective.', NULL, 13, 1, 1),
(13, '2026-04-12 09:10:00', 'Processus d\'approbation budgétaire bloquant', 'Toute dépense même minime nécessite 3 niveaux de validation.', NULL, 1, 1, 1),
(14, '2026-04-12 11:30:00', 'Répartition inégale de la charge de travail', 'Certains membres sont surchargés pendant que d\'autres sont sous-utilisés.', NULL, 11, 1, 1),
(15, '2026-04-12 16:00:00', 'Manque de formation aux outils internes', 'Les outils sont mal maîtrisés faute de formation initiale.', NULL, 12, 1, 1),
(16, '2026-04-13 09:00:00', 'Pas de gestion des risques projet', 'Les risques projet ne sont jamais anticipés ni documentés.', NULL, 13, 1, 1),
(17, '2026-04-13 11:45:00', 'Feedbacks trop rares entre collègues', 'Les retours constructifs sont quasi absents du quotidien.', NULL, 1, 1, 1),
(18, '2026-04-13 15:00:00', 'Archivage des fichiers désorganisé', 'Le stockage cloud est un chaos, impossible de retrouver les anciens documents.', NULL, 11, 1, 1),
(19, '2026-04-14 08:30:00', 'Réunions sans compte-rendu', 'Les décisions prises en réunion ne sont jamais consignées.', NULL, 12, 1, 1),
(20, '2026-04-14 10:00:00', 'Processus de recrutement interne trop lent', 'Les postes ouverts restent vacants plusieurs mois faute de process rapide.', NULL, 13, 1, 1),
(21, '2026-04-14 14:30:00', 'Rôles et responsabilités flous', 'Les périmètres de chacun ne sont pas définis, ce qui génère des conflits.', NULL, 1, 1, 1),
(22, '2026-04-15 09:20:00', 'Absence de plan de continuité d\'activité', 'Aucun backup n\'est prévu si un membre clé est absent.', NULL, 11, 1, 1),
(23, '2026-04-15 11:00:00', 'Indicateurs de suivi projet absents', 'Impossible de savoir si un projet est en retard sans demander directement.', NULL, 12, 1, 1),
(24, '2026-04-16 08:45:00', 'Temps de réponse aux demandes internes trop long', 'Les demandes inter-services prennent plus de 48h à être traitées.', NULL, 13, 1, 1),
(25, '2026-04-17 09:00:00', 'Absence de tableau de bord de suivi global', 'Aucune vue synthétique des projets en cours n\'existe.', NULL, 1, 1, 1),
(26, '2026-04-08 08:15:00', 'Navigation trop complexe', 'Les utilisateurs se perdent après la 3ème page, le taux d\'abandon est élevé.', NULL, 2, 2, 1),
(27, '2026-04-08 10:00:00', 'Temps de chargement trop lent', 'Le temps moyen de chargement dépasse 4 secondes sur mobile.', NULL, 14, 2, 1),
(28, '2026-04-08 14:30:00', 'Formulaires trop longs', 'Les formulaires d\'inscription comptent plus de 20 champs obligatoires.', NULL, 15, 2, 1),
(29, '2026-04-09 09:00:00', 'Messages d\'erreur incompréhensibles', 'Les erreurs affichées ne donnent aucune information utile à l\'utilisateur.', NULL, 16, 2, 1),
(30, '2026-04-09 11:00:00', 'Interface non adaptée au mobile', 'La version mobile ne s\'adapte pas correctement aux petits écrans.', NULL, 2, 2, 1),
(31, '2026-04-09 15:00:00', 'Absence de mode sombre', 'Les utilisateurs réclament un mode sombre depuis plusieurs mois.', NULL, 14, 2, 1),
(32, '2026-04-10 09:30:00', 'Accessibilité non respectée', 'L\'application n\'est pas conforme WCAG 2.1, excluant les utilisateurs handicapés.', NULL, 15, 2, 1),
(33, '2026-04-10 11:00:00', 'Onboarding utilisateur absent', 'Aucun tutoriel ni guide n\'accueille les nouveaux utilisateurs.', NULL, 16, 2, 1),
(34, '2026-04-10 16:00:00', 'Notifications push trop intrusives', 'Les notifications sont trop fréquentes et mal ciblées.', NULL, 2, 2, 1),
(35, '2026-04-11 09:00:00', 'Pas de personnalisation du tableau de bord', 'L\'utilisateur ne peut pas configurer son espace personnel.', NULL, 14, 2, 1),
(36, '2026-04-11 10:30:00', 'Recherche interne peu pertinente', 'Les résultats de recherche ne correspondent pas aux attentes des utilisateurs.', NULL, 15, 2, 1),
(37, '2026-04-11 14:00:00', 'Manque de feedback visuel sur les actions', 'L\'utilisateur ne sait pas si son action a bien été prise en compte.', NULL, 16, 2, 1),
(38, '2026-04-12 08:45:00', 'Processus de paiement trop long', 'Le tunnel d\'achat comporte trop d\'étapes, générant de l\'abandon.', NULL, 2, 2, 1),
(39, '2026-04-12 10:15:00', 'Absence de confirmation par email', 'Aucun email de confirmation n\'est envoyé après une action importante.', NULL, 14, 2, 1),
(40, '2026-04-12 15:30:00', 'Cohérence visuelle insuffisante', 'Les composants UI varient d\'une page à l\'autre sans logique.', NULL, 15, 2, 1),
(41, '2026-04-13 09:30:00', 'Gestion des sessions trop agressive', 'Les utilisateurs sont déconnectés trop souvent, perdant leur travail en cours.', NULL, 16, 2, 1),
(42, '2026-04-13 11:00:00', 'Pas de sauvegarde automatique des formulaires', 'En cas de fermeture accidentelle, toutes les données saisies sont perdues.', NULL, 2, 2, 1),
(43, '2026-04-13 15:30:00', 'Images non optimisées', 'Les images haute résolution alourdissent inutilement les pages.', NULL, 14, 2, 1),
(44, '2026-04-14 09:00:00', 'Fil d\'Ariane absent', 'L\'utilisateur ne sait pas où il se trouve dans l\'arborescence.', NULL, 15, 2, 1),
(45, '2026-04-14 11:30:00', 'Pas de gestion des préférences utilisateur', 'Les préférences ne sont pas sauvegardées entre deux sessions.', NULL, 16, 2, 1),
(46, '2026-04-14 15:00:00', 'Icônes sans libellé', 'Les icônes de l\'interface ne sont pas accompagnées de texte explicatif.', NULL, 2, 2, 1),
(47, '2026-04-15 09:00:00', 'Absence de page d\'aide contextuelle', 'Aucune aide n\'est disponible directement depuis les pages complexes.', NULL, 14, 2, 1),
(48, '2026-04-15 11:30:00', 'Couleurs non contrastées', 'Le contraste texte/fond est insuffisant pour les utilisateurs malvoyants.', NULL, 15, 2, 1),
(49, '2026-04-16 09:00:00', 'Pas de raccourcis clavier', 'Les utilisateurs avancés ne peuvent pas naviguer efficacement au clavier.', NULL, 16, 2, 1),
(50, '2026-04-17 10:00:00', 'Absence de responsive sur tablette', 'L\'interface n\'est pas adaptée aux écrans de taille intermédiaire.', NULL, 2, 2, 1),
(51, '2026-04-08 08:20:00', 'Dette technique non priorisée', 'La dette technique s\'accumule sans jamais être planifiée dans les sprints.', NULL, 3, 3, 1),
(52, '2026-04-08 10:10:00', 'Absence de revues de code systématiques', 'Les pull requests sont mergées sans review, générant des régressions fréquentes.', NULL, 17, 3, 1),
(53, '2026-04-08 14:45:00', 'Pas de standards de codage définis', 'Chaque développeur code selon ses propres conventions, rendant la lecture difficile.', NULL, 18, 3, 1),
(54, '2026-04-09 09:15:00', 'Couverture de tests insuffisante', 'Moins de 30% du code est couvert par des tests automatisés.', NULL, 19, 3, 1),
(55, '2026-04-09 11:30:00', 'Déploiements manuels et risqués', 'Les mises en production se font manuellement, générant des erreurs fréquentes.', NULL, 3, 3, 1),
(56, '2026-04-09 15:30:00', 'Environnements de dev non reproductibles', 'Les développeurs n\'ont pas le même environnement local, causant des bugs difficiles.', NULL, 17, 3, 1),
(57, '2026-04-10 09:45:00', 'Logs applicatifs inexploitables', 'Les logs sont trop verbeux et non structurés, rendant le débogage difficile.', NULL, 18, 3, 1),
(58, '2026-04-10 11:30:00', 'Pas de monitoring en production', 'Aucune alerte n\'est configurée en cas de panne ou de dégradation des performances.', NULL, 19, 3, 1),
(59, '2026-04-10 16:30:00', 'Dépendances obsolètes non mises à jour', 'Plusieurs librairies utilisées ont des vulnérabilités connues non corrigées.', NULL, 3, 3, 1),
(60, '2026-04-11 09:15:00', 'Pas de documentation technique', 'Le code n\'est pas documenté, rendant la maintenance complexe.', NULL, 17, 3, 1),
(61, '2026-04-11 11:00:00', 'Architecture monolithique difficile à faire évoluer', 'Le monolithe rend impossible l\'évolution indépendante des modules.', NULL, 18, 3, 1),
(62, '2026-04-11 15:00:00', 'Absence de pipeline CI/CD', 'Aucune intégration continue n\'est en place, les tests sont lancés manuellement.', NULL, 19, 3, 1),
(63, '2026-04-12 09:30:00', 'Gestion des secrets non sécurisée', 'Les clés API et mots de passe sont stockés en clair dans le code source.', NULL, 3, 3, 1),
(64, '2026-04-12 11:45:00', 'Base de données non indexée correctement', 'Certaines requêtes SQL critiques n\'utilisent pas d\'index, causant des lenteurs.', NULL, 17, 3, 1),
(65, '2026-04-12 16:15:00', 'Pas de gestion des erreurs centralisée', 'Les erreurs sont gérées de façon disparate dans chaque module.', NULL, 18, 3, 1),
(66, '2026-04-13 09:45:00', 'Rollback de déploiement impossible', 'En cas d\'incident, il n\'existe pas de procédure de retour arrière fiable.', NULL, 19, 3, 1),
(67, '2026-04-13 12:00:00', 'Pas de revue de sécurité du code', 'Aucun audit de sécurité applicative n\'a jamais été réalisé.', NULL, 3, 3, 1),
(68, '2026-04-13 16:00:00', 'Versionning des APIs absent', 'Les APIs ne sont pas versionnées, les changements cassent les intégrations clientes.', NULL, 17, 3, 1),
(69, '2026-04-14 09:15:00', 'Temps de build trop long', 'Le build complet du projet prend plus de 20 minutes, ralentissant les itérations.', NULL, 18, 3, 1),
(70, '2026-04-14 11:45:00', 'Pas de stratégie de cache', 'Aucune stratégie de cache n\'est définie, surchargeant inutilement la base de données.', NULL, 19, 3, 1),
(71, '2026-04-14 15:30:00', 'Migrations de base de données non automatisées', 'Les migrations sont appliquées manuellement, risquant des désynchronisations.', NULL, 3, 3, 1),
(72, '2026-04-15 09:30:00', 'Couplage fort entre les modules', 'Les modules sont trop dépendants les uns des autres, rendant les tests difficiles.', NULL, 17, 3, 1),
(73, '2026-04-15 11:30:00', 'Pas de tests de charge', 'L\'application n\'a jamais été testée sous forte charge utilisateur.', NULL, 18, 3, 1),
(74, '2026-04-16 09:15:00', 'Absence de revue d\'architecture régulière', 'L\'architecture technique n\'est jamais remise en question ni optimisée.', NULL, 19, 3, 1),
(75, '2026-04-17 09:30:00', 'Pas de contrat d\'interface entre équipes', 'Les équipes frontend et backend n\'ont pas de contrat API formel.', NULL, 3, 3, 1),
(76, '2026-04-08 08:25:00', 'Stratégie de contenu inexistante', 'Aucune ligne éditoriale n\'est définie pour les réseaux sociaux.', NULL, 4, 4, 1),
(77, '2026-04-08 10:20:00', 'Pas de calendrier marketing', 'Les campagnes sont lancées sans planification, créant des doublons et des vides.', NULL, 20, 4, 1),
(78, '2026-04-08 15:00:00', 'Budget publicitaire mal réparti', 'Les investissements publicitaires ne sont pas alignés sur les canaux les plus rentables.', NULL, 21, 4, 1),
(79, '2026-04-09 09:30:00', 'Absence de reporting des campagnes', 'Aucun indicateur de performance des campagnes n\'est suivi régulièrement.', NULL, 22, 4, 1),
(80, '2026-04-09 11:45:00', 'Branding incohérent sur les supports', 'Le logo, les couleurs et les polices varient selon les supports de communication.', NULL, 4, 4, 1),
(81, '2026-04-09 16:00:00', 'Pas de stratégie SEO', 'Le site web n\'est pas optimisé pour les moteurs de recherche.', NULL, 20, 4, 1),
(82, '2026-04-10 10:00:00', 'Aucune segmentation de la base clients', 'Tous les clients reçoivent les mêmes communications sans personnalisation.', NULL, 21, 4, 1),
(83, '2026-04-10 12:00:00', 'Taux d\'ouverture des emailings très faible', 'Moins de 10% des emails marketing sont ouverts par les destinataires.', NULL, 22, 4, 1),
(84, '2026-04-10 17:00:00', 'Pas de tests A/B sur les campagnes', 'Les créatifs ne sont jamais testés avant déploiement massif.', NULL, 4, 4, 1),
(85, '2026-04-11 09:30:00', 'Réseaux sociaux non animés régulièrement', 'Les comptes officiels ne sont mis à jour que de façon irrégulière.', NULL, 20, 4, 1),
(86, '2026-04-11 11:15:00', 'Absence de gestion de la e-réputation', 'Aucun suivi des avis clients en ligne n\'est réalisé.', NULL, 21, 4, 1),
(87, '2026-04-11 15:30:00', 'Pas de page de destination dédiée aux campagnes', 'Les publicités redirigent vers la homepage au lieu d\'une landing page optimisée.', NULL, 22, 4, 1),
(88, '2026-04-12 09:45:00', 'Partenariats influenceurs non suivis', 'Les collaborations avec des influenceurs n\'ont aucun suivi de ROI.', NULL, 4, 4, 1),
(89, '2026-04-12 12:00:00', 'Visuels créatifs obsolètes', 'Les visuels utilisés dans les campagnes datent de plus d\'un an.', NULL, 20, 4, 1),
(90, '2026-04-12 16:30:00', 'Pas de stratégie de contenu vidéo', 'Aucune vidéo promotionnelle n\'est produite alors que le format est très demandé.', NULL, 21, 4, 1),
(91, '2026-04-13 10:00:00', 'Site web non mis à jour', 'Les actualités et offres du site ne sont pas maintenues à jour.', NULL, 22, 4, 1),
(92, '2026-04-13 12:15:00', 'Absence de stratégie de fidélisation', 'Aucun programme de fidélité ni de relance client n\'est en place.', NULL, 4, 4, 1),
(93, '2026-04-13 16:30:00', 'Tunnel de conversion non optimisé', 'Le parcours d\'achat présente de nombreux points de friction non identifiés.', NULL, 20, 4, 1),
(94, '2026-04-14 09:30:00', 'Pas de veille concurrentielle', 'L\'équipe n\'analyse pas les stratégies marketing des concurrents.', NULL, 21, 4, 1),
(95, '2026-04-14 12:00:00', 'Outil CRM sous-exploité', 'Le CRM est utilisé uniquement comme carnet d\'adresses, sans automatisation.', NULL, 22, 4, 1),
(96, '2026-04-14 16:00:00', 'Newsletter sans stratégie de contenu', 'La newsletter est envoyée sans cohérence ni objectif éditorial défini.', NULL, 4, 4, 1),
(97, '2026-04-15 10:00:00', 'Pas de stratégie de marketing automation', 'Aucun scénario automatisé n\'est configuré pour nurturer les prospects.', NULL, 20, 4, 1),
(98, '2026-04-15 12:00:00', 'Absence de charte graphique formalisée', 'Les prestataires externes ne disposent d\'aucun guide de style à respecter.', NULL, 21, 4, 1),
(99, '2026-04-16 09:30:00', 'Mesure du ROI marketing inexistante', 'Impossible de calculer le retour sur investissement des actions menées.', NULL, 22, 4, 1),
(100, '2026-04-17 10:00:00', 'Pas de stratégie de contenu pour le blog', 'Le blog de l\'entreprise est abandonné depuis plusieurs mois.', NULL, 4, 4, 1),
(101, '2026-04-08 08:30:00', 'Temps de réponse support trop long', 'Les tickets clients restent sans réponse plus de 48h en moyenne.', NULL, 5, 5, 1),
(102, '2026-04-08 10:30:00', 'Pas de base de connaissances client', 'Aucun FAQ ni documentation self-service n\'est disponible pour les utilisateurs.', NULL, 23, 5, 1),
(103, '2026-04-08 15:15:00', 'Outil de ticketing inadapté', 'L\'outil actuel ne permet pas de prioriser ni de catégoriser les demandes.', NULL, 24, 5, 1),
(104, '2026-04-09 09:45:00', 'Absence de SLA définis', 'Aucun niveau de service n\'est contractualisé avec les clients.', NULL, 25, 5, 1),
(105, '2026-04-09 12:00:00', 'Pas de suivi de la satisfaction client', 'Aucun indicateur CSAT ni NPS n\'est mesuré régulièrement.', NULL, 5, 5, 1),
(106, '2026-04-09 16:15:00', 'Manque de formation des agents support', 'Les agents n\'ont pas accès à une formation continue sur les produits.', NULL, 23, 5, 1),
(107, '2026-04-10 10:15:00', 'Absence de canal de support en temps réel', 'Aucun chat en direct ni support téléphonique n\'est proposé aux clients.', NULL, 24, 5, 1),
(108, '2026-04-10 12:15:00', 'Escalades mal gérées', 'Les tickets complexes ne sont pas escaladés correctement vers les équipes techniques.', NULL, 25, 5, 1),
(109, '2026-04-10 17:15:00', 'Pas de rapport hebdomadaire des tickets', 'Aucune synthèse des demandes récurrentes n\'est partagée avec les équipes produit.', NULL, 5, 5, 1),
(110, '2026-04-11 09:45:00', 'Réponses support non personnalisées', 'Les réponses sont des copier-coller génériques sans adaptation au contexte client.', NULL, 23, 5, 1),
(111, '2026-04-11 11:30:00', 'Délai de résolution des bugs trop long', 'Les bugs signalés par les clients prennent plus de 2 semaines à être corrigés.', NULL, 24, 5, 1),
(112, '2026-04-11 15:45:00', 'Pas de suivi des tickets après résolution', 'Aucun contrôle n\'est effectué pour vérifier que le client est satisfait.', NULL, 25, 5, 1),
(113, '2026-04-12 10:00:00', 'Absence de gestion des clients VIP', 'Les clients stratégiques ne bénéficient d\'aucun traitement prioritaire.', NULL, 5, 5, 1),
(114, '2026-04-12 12:15:00', 'Support multilingue inexistant', 'Aucun agent ne parle d\'autres langues que le français.', NULL, 23, 5, 1),
(115, '2026-04-12 16:45:00', 'Historique client non centralisé', 'Les agents ne voient pas l\'historique complet des échanges avec un client.', NULL, 24, 5, 1),
(116, '2026-04-13 10:15:00', 'Trop de canaux de contact non coordonnés', 'Email, téléphone et chat ne sont pas intégrés dans un outil unique.', NULL, 25, 5, 1),
(117, '2026-04-13 12:30:00', 'Pas de chatbot pour les questions fréquentes', 'Les agents perdent du temps à répondre aux mêmes questions basiques.', NULL, 5, 5, 1),
(118, '2026-04-13 16:45:00', 'Indicateurs de performance support absents', 'Aucun tableau de bord ne suit les performances individuelles des agents.', NULL, 23, 5, 1),
(119, '2026-04-14 09:45:00', 'Pas de processus d\'amélioration continue', 'Les retours clients ne sont jamais analysés pour améliorer les processus.', NULL, 24, 5, 1),
(120, '2026-04-14 12:15:00', 'Formulaire de contact difficile à trouver', 'Les clients peinent à trouver le moyen de contacter le support.', NULL, 25, 5, 1),
(121, '2026-04-14 16:15:00', 'Pas de documentation interne pour les agents', 'Les agents n\'ont pas de procédures internes pour traiter les cas complexes.', NULL, 5, 5, 1),
(122, '2026-04-15 10:15:00', 'Absence de gestion des réclamations formalisée', 'Aucun processus dédié n\'existe pour traiter les réclamations officielles.', NULL, 23, 5, 1),
(123, '2026-04-15 12:15:00', 'Horaires de support trop restreints', 'Le support n\'est disponible que 5j/7 de 9h à 17h.', NULL, 24, 5, 1),
(124, '2026-04-16 09:45:00', 'Pas de retour d\'expérience après incident', 'Aucun post-mortem n\'est réalisé après un incident majeur impactant les clients.', NULL, 25, 5, 1),
(125, '2026-04-17 10:15:00', 'Absence de portail client self-service', 'Les clients ne peuvent pas suivre l\'état de leurs tickets en autonomie.', NULL, 5, 5, 1),
(126, '2026-04-08 08:35:00', 'Pas de roadmap produit long terme', 'L\'équipe R&D travaille sans vision à 6 mois, rendant la priorisation impossible.', NULL, 6, 6, 1),
(127, '2026-04-08 10:40:00', 'Idées innovations non capitalisées', 'Les idées des collaborateurs ne sont jamais collectées ni évaluées.', NULL, 26, 6, 1),
(128, '2026-04-08 15:30:00', 'Pas de veille technologique organisée', 'Aucune veille sur les nouvelles technologies n\'est formalisée dans l\'équipe.', NULL, 27, 6, 1),
(129, '2026-04-09 10:00:00', 'Prototypes jamais testés avec de vrais users', 'Les nouvelles fonctionnalités sont développées sans validation utilisateur préalable.', NULL, 28, 6, 1),
(130, '2026-04-09 12:15:00', 'Absence de processus de validation des idées', 'N\'importe quelle idée peut entrer en développement sans critère de sélection.', NULL, 6, 6, 1),
(131, '2026-04-09 16:30:00', 'Découpage des user stories trop grossier', 'Les user stories sont trop larges pour être développées en un seul sprint.', NULL, 26, 6, 1),
(132, '2026-04-10 10:30:00', 'Pas de benchmark concurrentiel régulier', 'L\'équipe ne compare jamais ses solutions à celles des concurrents.', NULL, 27, 6, 1),
(133, '2026-04-10 12:30:00', 'Collaboration UX/Dev insuffisante', 'Les designers et développeurs travaillent en silos sans synchronisation.', NULL, 28, 6, 1),
(134, '2026-04-10 17:30:00', 'Absence de critères d\'acceptance clairs', 'Les fonctionnalités sont livrées sans définition précise de ce qui est attendu.', NULL, 6, 6, 1),
(135, '2026-04-11 10:00:00', 'Pas de gestion du backlog produit', 'Le backlog n\'est jamais trié ni priorisé, il grossit sans fin.', NULL, 26, 6, 1),
(136, '2026-04-11 11:45:00', 'Délai time-to-market trop long', 'Les nouvelles fonctionnalités mettent en moyenne 6 mois à être mises en production.', NULL, 27, 6, 1),
(137, '2026-04-11 16:00:00', 'Pas de KPIs d\'adoption des nouvelles features', 'Aucun suivi de l\'utilisation des nouvelles fonctionnalités n\'est réalisé.', NULL, 28, 6, 1),
(138, '2026-04-12 10:15:00', 'Documentation fonctionnelle absente', 'Les spécifications des features ne sont jamais rédigées ni archivées.', NULL, 6, 6, 1),
(139, '2026-04-12 12:30:00', 'Pas de phase de discovery structurée', 'Les problèmes utilisateurs ne sont pas investigués avant de partir en conception.', NULL, 26, 6, 1),
(140, '2026-04-12 17:00:00', 'Manque de communication sur les nouvelles fonctionnalités', 'Les nouvelles features ne sont pas communiquées aux utilisateurs.', NULL, 27, 6, 1),
(141, '2026-04-13 10:30:00', 'Absence de gestion des dépendances inter-équipes', 'Les dépendances entre équipes ne sont pas identifiées en amont.', NULL, 28, 6, 1),
(142, '2026-04-13 12:45:00', 'Pas de revue des fonctionnalités inutilisées', 'Des features coûteuses en maintenance ne sont jamais désactivées.', NULL, 6, 6, 1),
(143, '2026-04-13 17:00:00', 'Pas de stratégie de test bêta', 'Aucun programme de bêta testeurs n\'existe pour valider les innovations.', NULL, 26, 6, 1),
(144, '2026-04-14 10:00:00', 'Absence de product market fit mesuré', 'L\'adéquation produit/marché n\'est jamais évaluée de façon structurée.', NULL, 27, 6, 1),
(145, '2026-04-14 12:30:00', 'Trop de features développées simultanément', 'L\'équipe se disperse sur trop de sujets en parallèle.', NULL, 28, 6, 1),
(146, '2026-04-14 16:30:00', 'Pas de rituel de démonstration des features', 'Les nouvelles fonctionnalités ne sont jamais démontrées aux parties prenantes.', NULL, 6, 6, 1),
(147, '2026-04-15 10:30:00', 'Pas de gestion des feedbacks produit', 'Les retours utilisateurs ne sont pas collectés ni analysés de façon structurée.', NULL, 26, 6, 1),
(148, '2026-04-15 12:30:00', 'Vision produit non partagée', 'Tous les membres de l\'équipe n\'ont pas la même compréhension de la vision produit.', NULL, 27, 6, 1),
(149, '2026-04-16 10:00:00', 'Absence de roadmap technique alignée sur le produit', 'La roadmap technique ne reflète pas les priorités produit.', NULL, 28, 6, 1),
(150, '2026-04-17 10:30:00', 'Pas de processus de dépréciation des features', 'Aucune procédure n\'existe pour retirer proprement une fonctionnalité obsolète.', NULL, 6, 6, 1),
(151, '2026-04-08 08:40:00', 'Gestion des stocks manuelle', 'Le suivi des stocks est réalisé sur des fichiers Excel non partagés.', NULL, 7, 7, 1),
(152, '2026-04-08 10:50:00', 'Pas de suivi des délais fournisseurs', 'Les délais de livraison des fournisseurs ne sont pas tracés.', NULL, 29, 7, 1),
(153, '2026-04-08 15:45:00', 'Processus de commande non automatisé', 'Les commandes fournisseurs sont passées manuellement sans règle de réapprovisionnement.', NULL, 30, 7, 1),
(154, '2026-04-09 10:15:00', 'Absence de traçabilité des livraisons', 'Impossible de savoir où en est une commande une fois passée.', NULL, 31, 7, 1),
(155, '2026-04-09 12:30:00', 'Pas d\'optimisation des tournées de livraison', 'Les tournées ne sont pas optimisées, générant des coûts logistiques inutiles.', NULL, 7, 7, 1),
(156, '2026-04-09 16:45:00', 'Taux de retour non analysé', 'Les retours produits ne sont pas analysés pour en identifier les causes.', NULL, 29, 7, 1),
(157, '2026-04-10 10:45:00', 'Entrepôt désorganisé', 'La disposition des produits en entrepôt ne suit aucune logique de préparation.', NULL, 30, 7, 1),
(158, '2026-04-10 12:45:00', 'Délais de préparation des commandes trop longs', 'La préparation d\'une commande prend en moyenne 3 fois plus de temps que la norme.', NULL, 31, 7, 1),
(159, '2026-04-10 17:45:00', 'Pas de gestion des pics d\'activité', 'L\'équipe n\'est pas dimensionnée pour absorber les périodes de forte demande.', NULL, 7, 7, 1),
(160, '2026-04-11 10:15:00', 'Indicateurs de performance logistique absents', 'Aucun KPI ne mesure les performances de l\'équipe opérations.', NULL, 29, 7, 1),
(161, '2026-04-11 12:00:00', 'Transporteurs non évalués régulièrement', 'La qualité de service des transporteurs n\'est jamais évaluée.', NULL, 30, 7, 1),
(162, '2026-04-11 16:15:00', 'Pas de plan de contingence fournisseur', 'Aucun fournisseur de secours n\'est identifié en cas de défaillance.', NULL, 31, 7, 1),
(163, '2026-04-12 10:30:00', 'Emballages non standardisés', 'Les produits sont emballés différemment selon les opérateurs, causant des casses.', NULL, 7, 7, 1),
(164, '2026-04-12 12:45:00', 'Absence de politique de retours claire', 'Les clients ne savent pas comment retourner un produit défectueux.', NULL, 29, 7, 1),
(165, '2026-04-12 17:15:00', 'Pas de mutualisation des livraisons', 'Chaque commande est expédiée séparément, même pour un même client.', NULL, 30, 7, 1),
(166, '2026-04-13 10:45:00', 'Coûts de transport non négociés', 'Les tarifs transporteurs n\'ont pas été renégociés depuis plus de 2 ans.', NULL, 31, 7, 1),
(167, '2026-04-13 13:00:00', 'Mauvaise gestion des retours en entrepôt', 'Les produits retournés encombrent l\'entrepôt sans traitement clair.', NULL, 7, 7, 1),
(168, '2026-04-13 17:15:00', 'Étiquetage des produits non conforme', 'Certains produits ne respectent pas les normes d\'étiquetage en vigueur.', NULL, 29, 7, 1),
(169, '2026-04-14 10:15:00', 'Absence de système de scan en entrepôt', 'Les mouvements de stock ne sont pas scannés, générant des erreurs d\'inventaire.', NULL, 30, 7, 1),
(170, '2026-04-14 12:45:00', 'Non-conformités fournisseurs non traitées', 'Les produits livrés hors conformité ne font l\'objet d\'aucune procédure de retour.', NULL, 31, 7, 1),
(171, '2026-04-14 16:45:00', 'Pas de tableau de bord logistique temps réel', 'Aucune vue en temps réel sur l\'état des expéditions n\'est disponible.', NULL, 7, 7, 1),
(172, '2026-04-15 10:45:00', 'Formation des opérateurs insuffisante', 'Les nouveaux opérateurs ne reçoivent pas de formation aux procédures logistiques.', NULL, 29, 7, 1),
(173, '2026-04-15 12:45:00', 'Pas de politique de développement durable', 'Aucune démarche eco-responsable n\'est engagée dans les opérations logistiques.', NULL, 30, 7, 1),
(174, '2026-04-16 10:15:00', 'Ruptures de stock fréquentes', 'Des ruptures de stock régulières impactent la satisfaction des clients.', NULL, 31, 7, 1),
(175, '2026-04-17 10:45:00', 'Pas d\'audit logistique annuel', 'Aucun audit externe ne vient évaluer la performance de la chaîne logistique.', NULL, 7, 7, 1),
(176, '2026-04-08 08:45:00', 'Données non centralisées', 'Les données sont réparties dans plusieurs outils sans source de vérité unique.', NULL, 8, 8, 1),
(177, '2026-04-08 11:00:00', 'Pas de gouvernance des données', 'Aucune politique de qualité ni de cycle de vie des données n\'est définie.', NULL, 32, 8, 1),
(178, '2026-04-08 16:00:00', 'Rapports produits manuellement', 'Les rapports hebdomadaires sont construits manuellement sous Excel, source d\'erreurs.', NULL, 33, 8, 1),
(179, '2026-04-09 10:30:00', 'Absence de catalogue de données', 'Les équipes ne savent pas quelles données existent ni comment y accéder.', NULL, 34, 8, 1),
(180, '2026-04-09 12:45:00', 'KPIs non alignés entre les équipes', 'Chaque équipe utilise des définitions différentes pour les mêmes indicateurs.', NULL, 8, 8, 1),
(181, '2026-04-09 17:00:00', 'Pas de pipeline de données automatisé', 'Les flux de données entre systèmes sont déclenchés manuellement.', NULL, 32, 8, 1),
(182, '2026-04-10 11:00:00', 'Absence de modèle de données commun', 'Les données clients sont stockées différemment selon les outils utilisés.', NULL, 33, 8, 1),
(183, '2026-04-10 13:00:00', 'Pas de contrôle qualité des données', 'Les données sont intégrées sans validation préalable, polluant les analyses.', NULL, 34, 8, 1),
(184, '2026-04-10 18:00:00', 'Accès aux données trop restrictifs', 'Les équipes métier ne peuvent pas accéder aux données dont elles ont besoin.', NULL, 8, 8, 1),
(185, '2026-04-11 10:30:00', 'Absence de documentation des datasets', 'Les jeux de données ne sont pas documentés, rendant leur réutilisation difficile.', NULL, 32, 8, 1),
(186, '2026-04-11 12:15:00', 'Pas de stratégie de rétention des données', 'Aucune règle ne définit combien de temps les données doivent être conservées.', NULL, 33, 8, 1),
(187, '2026-04-11 16:30:00', 'Outils analytiques sous-utilisés', 'Les licences d\'outils BI sont payées mais l\'adoption reste marginale.', NULL, 34, 8, 1),
(188, '2026-04-12 10:45:00', 'Pas d\'alerte sur anomalie de données', 'Aucun système ne détecte automatiquement les données aberrantes ou manquantes.', NULL, 8, 8, 1),
(189, '2026-04-12 13:00:00', 'Silos de données entre départements', 'Les départements ne partagent pas leurs données entre eux.', NULL, 32, 8, 1),
(190, '2026-04-12 17:30:00', 'Absence de formation à la data literacy', 'Les équipes métier ne savent pas lire ni interpréter les rapports analytiques.', NULL, 33, 8, 1),
(191, '2026-04-13 11:00:00', 'Pas de gestion des accès aux données sensibles', 'Les données personnelles clients ne sont pas protégées par des droits d\'accès.', NULL, 34, 8, 1),
(192, '2026-04-13 13:15:00', 'Duplication massive des données', 'Les mêmes données sont stockées plusieurs fois dans des systèmes différents.', NULL, 8, 8, 1),
(193, '2026-04-13 17:30:00', 'Pas de stratégie de données en temps réel', 'Toutes les analyses sont basées sur des données J-1 au minimum.', NULL, 32, 8, 1),
(194, '2026-04-14 10:30:00', 'Absence de data warehouse', 'Il n\'existe pas d\'entrepôt de données centralisé pour les analyses croisées.', NULL, 33, 8, 1),
(195, '2026-04-14 13:00:00', 'Tableaux de bord trop complexes', 'Les dashboards contiennent trop d\'indicateurs et sont illisibles pour les managers.', NULL, 34, 8, 1),
(196, '2026-04-14 17:00:00', 'Pas de processus de demande d\'analyse', 'Aucun processus formel n\'existe pour soumettre une demande d\'analyse à l\'équipe.', NULL, 8, 8, 1),
(197, '2026-04-15 11:00:00', 'Absence de modèles prédictifs', 'Aucun modèle de machine learning n\'est utilisé pour anticiper les tendances.', NULL, 32, 8, 1),
(198, '2026-04-15 13:00:00', 'Pas de conformité RGPD sur les données', 'Le traitement des données personnelles n\'est pas conforme aux exigences RGPD.', NULL, 33, 8, 1),
(199, '2026-04-16 10:30:00', 'Résultats d\'analyses jamais partagés', 'Les insights produits par l\'équipe data ne sont pas diffusés aux équipes métier.', NULL, 34, 8, 1),
(200, '2026-04-17 11:00:00', 'Pas de roadmap data', 'L\'équipe data n\'a pas de feuille de route alignée sur les besoins de l\'entreprise.', NULL, 8, 8, 1),
(201, '2026-04-08 08:50:00', 'Politique de mots de passe trop permissive', 'Les utilisateurs peuvent utiliser des mots de passe trop simples.', NULL, 9, 9, 1),
(202, '2026-04-08 11:10:00', 'Pas de MFA sur les accès critiques', 'L\'authentification à double facteur n\'est pas imposée sur les systèmes sensibles.', NULL, 35, 9, 1),
(203, '2026-04-08 16:15:00', 'Habilitations non révisées régulièrement', 'Les droits d\'accès des collaborateurs ne sont pas audités ni mis à jour.', NULL, 36, 9, 1),
(204, '2026-04-09 10:45:00', 'Absence de plan de réponse aux incidents', 'Aucune procédure n\'est définie en cas de cyberattaque ou de fuite de données.', NULL, 37, 9, 1),
(205, '2026-04-09 13:00:00', 'Sauvegardes non testées régulièrement', 'Les sauvegardes existent mais ne sont jamais testées pour valider leur restauration.', NULL, 9, 9, 1),
(206, '2026-04-09 17:15:00', 'Pas de chiffrement des données sensibles', 'Les données sensibles en base et en transit ne sont pas toutes chiffrées.', NULL, 35, 9, 1),
(207, '2026-04-10 11:15:00', 'Journaux d\'audit non analysés', 'Les logs de sécurité ne sont pas examinés régulièrement.', NULL, 36, 9, 1),
(208, '2026-04-10 13:15:00', 'Absence de segmentation réseau', 'Le réseau interne n\'est pas segmenté, permettant une propagation facile des attaques.', NULL, 37, 9, 1),
(209, '2026-04-10 18:15:00', 'Mises à jour de sécurité non appliquées', 'Les patches de sécurité ne sont pas déployés dans les délais recommandés.', NULL, 9, 9, 1),
(210, '2026-04-11 10:45:00', 'Pas de sensibilisation sécurité des employés', 'Aucune formation au phishing ni aux bonnes pratiques de sécurité n\'est dispensée.', NULL, 35, 9, 1),
(211, '2026-04-11 12:30:00', 'Absence de politique BYOD', 'Les appareils personnels accèdent aux ressources internes sans contrôle.', NULL, 36, 9, 1),
(212, '2026-04-11 16:45:00', 'Pas de gestion des vulnérabilités', 'Aucun scan de vulnérabilité régulier n\'est réalisé sur les systèmes.', NULL, 37, 9, 1),
(213, '2026-04-12 11:00:00', 'Accès distants non sécurisés', 'Le télétravail se fait sans VPN ni solution de sécurisation des accès.', NULL, 9, 9, 1),
(214, '2026-04-12 13:15:00', 'Pas de politique de classification des données', 'Les données ne sont pas classifiées par niveau de sensibilité.', NULL, 35, 9, 1),
(215, '2026-04-12 17:45:00', 'Absence de tests de pénétration', 'Aucun pentest n\'a jamais été réalisé pour évaluer la résistance aux attaques.', NULL, 36, 9, 1),
(216, '2026-04-13 11:15:00', 'Pas de gestion des identités et accès unifiée', 'Chaque système gère ses propres accès sans IAM centralisé.', NULL, 37, 9, 1),
(217, '2026-04-13 13:30:00', 'Comptes de service non sécurisés', 'Les comptes techniques ont des mots de passe statiques jamais renouvelés.', NULL, 9, 9, 1),
(218, '2026-04-13 17:45:00', 'Pas de DLP pour prévenir les fuites de données', 'Aucun outil de prévention des pertes de données n\'est en place.', NULL, 35, 9, 1),
(219, '2026-04-14 10:45:00', 'Absence de conformité ISO 27001', 'L\'organisation ne suit pas les exigences de la norme ISO 27001.', NULL, 36, 9, 1),
(220, '2026-04-14 13:15:00', 'Pas de procédure de gestion des tiers', 'Les prestataires externes accèdent aux systèmes sans évaluation de sécurité.', NULL, 37, 9, 1),
(221, '2026-04-14 17:15:00', 'Absence de politique de clean desk', 'Les documents sensibles sont laissés visibles sur les bureaux sans règle.', NULL, 9, 9, 1),
(222, '2026-04-15 11:15:00', 'Pas de révocation rapide des accès sortants', 'Les accès des collaborateurs quittant l\'entreprise ne sont pas révoqués immédiatement.', NULL, 35, 9, 1),
(223, '2026-04-15 13:15:00', 'Surveillance insuffisante des accès privilégiés', 'Les comptes administrateurs ne font l\'objet d\'aucune surveillance renforcée.', NULL, 36, 9, 1),
(224, '2026-04-16 10:45:00', 'Pas de plan de continuité informatique', 'Aucun plan de reprise d\'activité informatique n\'est formalisé.', NULL, 37, 9, 1),
(225, '2026-04-17 11:15:00', 'Absence de registre des actifs informatiques', 'Les équipements et logiciels utilisés ne sont pas inventoriés.', NULL, 9, 9, 1),
(226, '2026-04-08 08:55:00', 'Pas de design system', 'Aucun design system n\'existe, les composants sont recréés à chaque projet.', NULL, 10, 10, 1),
(227, '2026-04-08 11:20:00', 'Processus de validation créative trop long', 'Les validations de maquettes impliquent trop de parties prenantes.', NULL, 38, 10, 1),
(228, '2026-04-08 16:30:00', 'Identité visuelle non déclinée sur tous les supports', 'La charte graphique n\'est pas appliquée de façon cohérente.', NULL, 39, 10, 1),
(229, '2026-04-09 11:00:00', 'Pas de bibliothèque de composants partagés', 'Chaque designer recrée les mêmes composants sans mutualisation.', NULL, 40, 10, 1),
(230, '2026-04-09 13:15:00', 'Absence de guide de motion design', 'Les animations et transitions ne suivent aucune règle commune.', NULL, 10, 10, 1),
(231, '2026-04-09 17:30:00', 'Formats de fichiers non standardisés', 'Les sources graphiques sont livrées dans des formats différents selon les designers.', NULL, 38, 10, 1),
(232, '2026-04-10 11:30:00', 'Pas de collaboration avec les équipes produit', 'Les designers ne sont impliqués qu\'en fin de processus, trop tard.', NULL, 39, 10, 1),
(233, '2026-04-10 13:30:00', 'Iconographie incohérente', 'Des styles d\'icônes différents sont utilisés sur la même interface.', NULL, 40, 10, 1),
(234, '2026-04-10 18:30:00', 'Pas de versioning des fichiers de design', 'Les fichiers de design ne sont pas versionnés, causant des pertes de travail.', NULL, 10, 10, 1),
(235, '2026-04-11 11:00:00', 'Typographie non harmonisée', 'Plusieurs polices d\'écriture coexistent sans règle de hiérarchie claire.', NULL, 38, 10, 1),
(236, '2026-04-11 12:45:00', 'Absence de tests utilisateurs sur les maquettes', 'Les maquettes ne sont jamais soumises à des tests utilisateurs avant développement.', NULL, 39, 10, 1),
(237, '2026-04-11 17:00:00', 'Palette de couleurs trop étendue', 'Trop de couleurs différentes sont utilisées, nuisant à la cohérence visuelle.', NULL, 40, 10, 1),
(238, '2026-04-12 11:15:00', 'Pas de revue design avant livraison', 'Les livrables design ne font l\'objet d\'aucune revue qualité avant envoi.', NULL, 10, 10, 1),
(239, '2026-04-12 13:30:00', 'Assets graphiques non optimisés pour le web', 'Les images et SVG ne sont pas optimisés, alourdissant les interfaces.', NULL, 38, 10, 1),
(240, '2026-04-12 17:45:00', 'Absence de documentation design', 'Les choix de design ne sont jamais documentés ni justifiés.', NULL, 39, 10, 1),
(241, '2026-04-13 11:30:00', 'Pas de processus de refonte UI planifié', 'L\'interface vieillit sans qu\'aucune refonte ne soit planifiée.', NULL, 40, 10, 1),
(242, '2026-04-13 13:45:00', 'Illustrations non cohérentes avec le ton', 'Le style des illustrations ne correspond pas à la personnalité de la marque.', NULL, 10, 10, 1),
(243, '2026-04-13 18:00:00', 'Pas de gabarit pour les présentations', 'Chaque membre crée ses slides depuis zéro sans template officiel.', NULL, 38, 10, 1),
(244, '2026-04-14 11:00:00', 'Outils de design non uniformisés', 'L\'équipe utilise Figma, Sketch et Adobe XD simultanément sans standard.', NULL, 39, 10, 1),
(245, '2026-04-14 13:30:00', 'Pas de règles pour les états d\'interface', 'Les états hover, focus, disabled ne sont pas définis dans la charte.', NULL, 40, 10, 1),
(246, '2026-04-14 17:30:00', 'Responsive design non pris en compte', 'Les maquettes ne sont déclinées que pour desktop, ignorant mobile et tablette.', NULL, 10, 10, 1),
(247, '2026-04-15 11:30:00', 'Pas de suivi des tendances design', 'L\'équipe ne se tient pas informée des évolutions du design digital.', NULL, 38, 10, 1),
(248, '2026-04-15 13:30:00', 'Absence de principes d\'UX writing', 'Les textes de l\'interface ne suivent aucune règle de rédaction UX.', NULL, 39, 10, 1),
(249, '2026-04-16 11:00:00', 'Pas de collaboration avec le marketing', 'Les créations du pôle design ne sont pas alignées avec les campagnes marketing.', NULL, 40, 10, 1),
(250, '2026-04-17 11:30:00', 'Absence de KPIs de qualité design', 'Aucun indicateur ne mesure la qualité ni l\'impact des livrables design.', NULL, 10, 10, 1);

-- --------------------------------------------------------

--
-- Structure de la table `FRICTION_STATUS`
--

CREATE TABLE `FRICTION_STATUS` (
  `id` int NOT NULL,
  `label` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `FRICTION_STATUS`
--

INSERT INTO `FRICTION_STATUS` (`id`, `label`) VALUES
(1, 'Non traité'),
(2, 'En cours'),
(3, 'En vote'),
(4, 'Clos');

-- --------------------------------------------------------

--
-- Structure de la table `FRICTION_VOTES`
--

CREATE TABLE `FRICTION_VOTES` (
  `id` int NOT NULL,
  `vote` tinyint(1) NOT NULL,
  `voted_at` datetime NOT NULL,
  `cycle_id` int NOT NULL,
  `friction_id` int NOT NULL,
  `member_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `FRICTION_VOTES`
--

INSERT INTO `FRICTION_VOTES` (`id`, `vote`, `voted_at`, `cycle_id`, `friction_id`, `member_id`) VALUES
(1, 1, '2026-04-18 22:34:46', 12, 49, 2),
(2, 1, '2026-04-18 22:35:52', 12, 50, 2),
(3, 1, '2026-04-18 22:52:06', 2, 50, 2),
(4, 1, '2026-04-18 22:52:17', 2, 45, 2),
(5, 1, '2026-04-18 22:53:54', 13, 125, 23);

-- --------------------------------------------------------

--
-- Structure de la table `INVITATIONS`
--

CREATE TABLE `INVITATIONS` (
  `id` int NOT NULL,
  `created_at` datetime NOT NULL,
  `responded_at` datetime DEFAULT NULL,
  `user_id` int NOT NULL,
  `team_id` int NOT NULL,
  `status_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `INVITATIONS_STATUS`
--

CREATE TABLE `INVITATIONS_STATUS` (
  `id` int NOT NULL,
  `label` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `SOLUTION_VOTES`
--

CREATE TABLE `SOLUTION_VOTES` (
  `id` int NOT NULL,
  `vote` tinyint(1) NOT NULL,
  `voted_at` datetime NOT NULL,
  `treatment_id` int NOT NULL,
  `member_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `TEAMS`
--

CREATE TABLE `TEAMS` (
  `id` int NOT NULL,
  `created_at` datetime NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(2000) DEFAULT NULL,
  `max_treatments_cycle_preset` int NOT NULL,
  `cycle_duration_preset` int NOT NULL,
  `treatment_voting_delay_preset` int NOT NULL,
  `creator_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `TEAMS`
--

INSERT INTO `TEAMS` (`id`, `created_at`, `name`, `description`, `max_treatments_cycle_preset`, `cycle_duration_preset`, `treatment_voting_delay_preset`, `creator_id`) VALUES
(1, '2026-04-02 09:00:00', 'Team Alpha', 'Équipe dédiée à l\'optimisation des processus internes.', 3, 14, 3, 1),
(2, '2026-04-03 11:00:00', 'Team Beta', 'Équipe produit axée sur l\'expérience utilisateur.', 2, 21, 4, 2),
(3, '2026-04-04 10:00:00', 'Team Gamma', 'Équipe technique chargée de la dette logicielle.', 4, 7, 2, 3),
(4, '2026-04-05 15:00:00', 'Team Delta', 'Équipe marketing et communication digitale.', 1, 30, 5, 4),
(5, '2026-04-07 12:00:00', 'Team Epsilon', 'Équipe support client et satisfaction.', 3, 10, 3, 5),
(6, '2026-04-09 17:00:00', 'Team Zeta', 'Équipe R&D et innovation produit.', 2, 28, 4, 6),
(7, '2026-04-11 09:30:00', 'Team Eta', 'Équipe opérations et logistique.', 4, 5, 2, 7),
(8, '2026-04-13 14:00:00', 'Team Theta', 'Équipe data et analytique.', 1, 21, 5, 8),
(9, '2026-04-15 18:00:00', 'Team Iota', 'Équipe sécurité et conformité.', 3, 14, 3, 9),
(10, '2026-04-17 10:00:00', 'Team Kappa', 'Équipe design et identité visuelle.', 2, 10, 2, 10);

-- --------------------------------------------------------

--
-- Structure de la table `TEAM_MEMBERS`
--

CREATE TABLE `TEAM_MEMBERS` (
  `id` int NOT NULL,
  `joined_at` datetime NOT NULL,
  `promoted_at` datetime DEFAULT NULL,
  `team_id` int NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `TEAM_MEMBERS`
--

INSERT INTO `TEAM_MEMBERS` (`id`, `joined_at`, `promoted_at`, `team_id`, `user_id`) VALUES
(1, '2026-04-02 09:00:00', '2026-04-02 09:00:00', 1, 1),
(2, '2026-04-03 11:00:00', '2026-04-03 11:00:00', 2, 2),
(3, '2026-04-04 10:00:00', '2026-04-04 10:00:00', 3, 3),
(4, '2026-04-05 15:00:00', '2026-04-05 15:00:00', 4, 4),
(5, '2026-04-07 12:00:00', '2026-04-07 12:00:00', 5, 5),
(6, '2026-04-09 17:00:00', '2026-04-09 17:00:00', 6, 6),
(7, '2026-04-11 09:30:00', '2026-04-11 09:30:00', 7, 7),
(8, '2026-04-13 14:00:00', '2026-04-13 14:00:00', 8, 8),
(9, '2026-04-15 18:00:00', '2026-04-15 18:00:00', 9, 9),
(10, '2026-04-17 10:00:00', '2026-04-17 10:00:00', 10, 10),
(11, '2026-04-03 10:00:00', NULL, 1, 11),
(12, '2026-04-04 14:00:00', NULL, 1, 12),
(13, '2026-04-06 09:30:00', NULL, 1, 13),
(14, '2026-04-04 11:00:00', NULL, 2, 14),
(15, '2026-04-05 15:00:00', NULL, 2, 15),
(16, '2026-04-07 08:45:00', NULL, 2, 16),
(17, '2026-04-05 09:00:00', NULL, 3, 17),
(18, '2026-04-06 16:00:00', NULL, 3, 18),
(19, '2026-04-08 10:00:00', NULL, 3, 19),
(20, '2026-04-06 13:00:00', NULL, 4, 20),
(21, '2026-04-07 17:00:00', NULL, 4, 21),
(22, '2026-04-09 09:00:00', NULL, 4, 22),
(23, '2026-04-08 08:30:00', NULL, 5, 23),
(24, '2026-04-09 14:00:00', NULL, 5, 24),
(25, '2026-04-10 11:00:00', NULL, 5, 25),
(26, '2026-04-10 09:00:00', NULL, 6, 26),
(27, '2026-04-11 15:30:00', NULL, 6, 27),
(28, '2026-04-12 08:00:00', NULL, 6, 28),
(29, '2026-04-12 10:00:00', NULL, 7, 29),
(30, '2026-04-13 13:00:00', NULL, 7, 30),
(31, '2026-04-14 09:30:00', NULL, 7, 31),
(32, '2026-04-14 11:00:00', NULL, 8, 32),
(33, '2026-04-15 16:00:00', NULL, 8, 33),
(34, '2026-04-16 08:30:00', NULL, 8, 0),
(35, '2026-04-16 10:00:00', NULL, 9, 35),
(36, '2026-04-17 14:00:00', NULL, 9, 36),
(37, '2026-04-17 17:30:00', NULL, 9, 37),
(38, '2026-04-17 12:00:00', NULL, 10, 38),
(39, '2026-04-18 09:00:00', NULL, 10, 39),
(40, '2026-04-18 11:30:00', NULL, 10, 40);

-- --------------------------------------------------------

--
-- Structure de la table `TREATMENTS`
--

CREATE TABLE `TREATMENTS` (
  `id` int NOT NULL,
  `solution` varchar(2000) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `pilot_id` int NOT NULL,
  `status_id` int NOT NULL,
  `cycle_id` int NOT NULL,
  `friction_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `TREATMENT_STATUS`
--

CREATE TABLE `TREATMENT_STATUS` (
  `id` int NOT NULL,
  `label` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `TREATMENT_STATUS`
--

INSERT INTO `TREATMENT_STATUS` (`id`, `label`) VALUES
(1, '-'),
(2, 'En cours'),
(3, 'À valider'),
(4, 'Validé'),
(5, 'Non validé');

-- --------------------------------------------------------

--
-- Structure de la table `USERS`
--

CREATE TABLE `USERS` (
  `id` int NOT NULL,
  `registered_at` datetime NOT NULL,
  `email` varchar(320) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `USERS`
--

INSERT INTO `USERS` (`id`, `registered_at`, `email`, `firstname`, `lastname`, `username`, `password_hash`) VALUES
(0, '2026-04-18 22:04:29', 'ghost@test.com', 'Ghost', 'Ghost', 'Un ancien collaborateur', '$2y$12$G7SXeiXCVouok91xdjDiCOnB8cjRylbEmU2h0UG6T/Xf.74q.BW5O'),
(1, '2026-04-18 22:04:29', 'jdupont@test.com', 'Jean', 'Dupont', 'JDup', '$2y$12$1Jy0yak2vxWT9cYhgSOB7ey5geHgS/h5gKuJGluTptdP8FOELt1A6'),
(2, '2026-04-18 22:05:43', 'cmartin@test.com', 'Clara', 'Martin', 'Cmartin', '$2y$12$tuTd5GjtesZEGqvdnTEliezPZ/mczZcJvp9Fvd2F2p5c0g6DpCb2e'),
(3, '2026-04-18 22:06:06', 'lbernard@test.com', 'Lucas', 'Bernard', 'LuluBernard', '$2y$12$0Z7ejt6GrydiJzbGyohIYeiusLUsa6/L1kMQcGzEBk27/c9jRRNKm'),
(4, '2026-04-18 22:06:36', 'epetit@test.com', 'Emma', 'Petit', 'EPetit', '$2y$12$5RUZyRjoSPsSoy0Cvp495Oaztjishz0lVtpNBMZRZRW1ee/9beYgq'),
(5, '2026-04-18 22:06:59', 'hrobert@test.com', 'Hugo', 'Robert', 'HR', '$2y$12$QnMMS4geVEDo.8tLiPqzDOapqlsBGrimjkZsAjwqFP5sbWAUxjbGK'),
(6, '2026-04-18 22:07:20', 'lrichard@test.com', 'Léa', 'Richard', 'LRichard', '$2y$12$3volf3iJslhDCypOWNPrGO9.zqCt6dD4vp4hb1zPXWlscEFojEk6m'),
(7, '2026-04-18 22:07:40', 'ndurand@test.com', 'Nathan', 'Durand', 'Ndurand', '$2y$12$TLNxXTeJVD8zwvFh3XuoQu1ek8bzDTPiXJOMELN0knsbPcgu9KzUO'),
(8, '2026-04-18 22:08:04', 'cmoreau@test.com', 'Chloé', 'Moreau', 'CMoreau', '$2y$12$nOAmFk8k2MBWsK.14mOyyuSbg6qJsfpFo4rOX4C/.zouTShJw.QDe'),
(9, '2026-04-18 22:08:34', 'lsimon@test.com', 'Louis', 'Simon', 'LSimon', '$2y$12$ZeaZnKcbDt2GOrTNeA/ikOWUrXPCQlytEfzeHiBCMABsL5Cj1fJhe'),
(10, '2026-04-18 22:09:07', 'ilaurent@test.com', 'Inès', 'Laurent', 'ILaurent', '$2y$12$hkq/WRPInDp023Uw9CRwleiiUYl48zIr2s9KeZvA5RZDn95U0wM8u'),
(11, '2026-04-18 22:12:15', 'ghost@test.com', 'ghost', 'ghost', 'ghost', '$2y$12$nOAmFk8k2MBWsK.14mOyyuSbg6qJsfpFo4rOX4C/.zouTShJw.QDe'),
(12, '2026-04-02 07:12:00', 'marc.dubois@mail.com', 'Marc', 'Dubois', 'marc_d', '$2b$12$q81FSIQaYmwNf4Gu57gw4OEryhg4gb2ET94TMOsEuLxtOEfe6Evqa'),
(13, '2026-04-02 08:45:00', 'sophie.laurent@mail.com', 'Sophie', 'Laurent', 'sophie_l', '$2b$12$q81FSIQaYmwNf4Gu57gw4OEryhg4gb2ET94TMOsEuLxtOEfe6Evqa'),
(14, '2026-04-03 09:30:00', 'thomas.garnier@mail.com', 'Thomas', 'Garnier', 'thomas_g', '$2b$12$q81FSIQaYmwNf4Gu57gw4OEryhg4gb2ET94TMOsEuLxtOEfe6Evqa'),
(15, '2026-04-03 11:20:00', 'laura.rousseau@mail.com', 'Laura', 'Rousseau', 'laura_r', '$2b$12$q81FSIQaYmwNf4Gu57gw4OEryhg4gb2ET94TMOsEuLxtOEfe6Evqa'),
(16, '2026-04-04 08:00:00', 'pierre.faure@mail.com', 'Pierre', 'Faure', 'pierre_f', '$2b$12$q81FSIQaYmwNf4Gu57gw4OEryhg4gb2ET94TMOsEuLxtOEfe6Evqa'),
(17, '2026-04-04 13:15:00', 'amelie.blanc@mail.com', 'Amélie', 'Blanc', 'amelie_b', '$2b$12$q81FSIQaYmwNf4Gu57gw4OEryhg4gb2ET94TMOsEuLxtOEfe6Evqa'),
(18, '2026-04-05 10:05:00', 'nicolas.robin@mail.com', 'Nicolas', 'Robin', 'nicolas_r', '$2b$12$q81FSIQaYmwNf4Gu57gw4OEryhg4gb2ET94TMOsEuLxtOEfe6Evqa'),
(19, '2026-04-05 14:50:00', 'chloe.morin@mail.com', 'Chloé', 'Morin', 'chloe_m', '$2b$12$q81FSIQaYmwNf4Gu57gw4OEryhg4gb2ET94TMOsEuLxtOEfe6Evqa'),
(20, '2026-04-06 09:00:00', 'antoine.chevalier@mail.com', 'Antoine', 'Chevalier', 'antoine_c', '$2b$12$q81FSIQaYmwNf4Gu57gw4OEryhg4gb2ET94TMOsEuLxtOEfe6Evqa'),
(21, '2026-04-06 16:30:00', 'lucie.fontaine@mail.com', 'Lucie', 'Fontaine', 'lucie_f', '$2b$12$q81FSIQaYmwNf4Gu57gw4OEryhg4gb2ET94TMOsEuLxtOEfe6Evqa'),
(22, '2026-04-07 08:20:00', 'romain.girard@mail.com', 'Romain', 'Girard', 'romain_g', '$2b$12$q81FSIQaYmwNf4Gu57gw4OEryhg4gb2ET94TMOsEuLxtOEfe6Evqa'),
(23, '2026-04-07 10:40:00', 'manon.bonnet@mail.com', 'Manon', 'Bonnet', 'manon_b', '$2b$12$q81FSIQaYmwNf4Gu57gw4OEryhg4gb2ET94TMOsEuLxtOEfe6Evqa'),
(24, '2026-04-08 09:10:00', 'kevin.mercier@mail.com', 'Kevin', 'Mercier', 'kevin_m', '$2b$12$q81FSIQaYmwNf4Gu57gw4OEryhg4gb2ET94TMOsEuLxtOEfe6Evqa'),
(25, '2026-04-08 15:00:00', 'pauline.dupuis@mail.com', 'Pauline', 'Dupuis', 'pauline_d', '$2b$12$q81FSIQaYmwNf4Gu57gw4OEryhg4gb2ET94TMOsEuLxtOEfe6Evqa'),
(26, '2026-04-09 07:55:00', 'vincent.lemaire@mail.com', 'Vincent', 'Lemaire', 'vincent_l', '$2b$12$q81FSIQaYmwNf4Gu57gw4OEryhg4gb2ET94TMOsEuLxtOEfe6Evqa'),
(27, '2026-04-09 12:25:00', 'julie.renard@mail.com', 'Julie', 'Renard', 'julie_r', '$2b$12$q81FSIQaYmwNf4Gu57gw4OEryhg4gb2ET94TMOsEuLxtOEfe6Evqa'),
(28, '2026-04-10 08:35:00', 'maxime.gerard@mail.com', 'Maxime', 'Gérard', 'maxime_g', '$2b$12$q81FSIQaYmwNf4Gu57gw4OEryhg4gb2ET94TMOsEuLxtOEfe6Evqa'),
(29, '2026-04-10 17:05:00', 'camille.perrin@mail.com', 'Camille', 'Perrin', 'camille_p', '$2b$12$q81FSIQaYmwNf4Gu57gw4OEryhg4gb2ET94TMOsEuLxtOEfe6Evqa'),
(30, '2026-04-11 09:15:00', 'alexis.moulin@mail.com', 'Alexis', 'Moulin', 'alexis_m', '$2b$12$q81FSIQaYmwNf4Gu57gw4OEryhg4gb2ET94TMOsEuLxtOEfe6Evqa'),
(31, '2026-04-11 14:45:00', 'elodie.henry@mail.com', 'Élodie', 'Henry', 'elodie_h', '$2b$12$q81FSIQaYmwNf4Gu57gw4OEryhg4gb2ET94TMOsEuLxtOEfe6Evqa'),
(32, '2026-04-12 08:10:00', 'sebastien.colin@mail.com', 'Sébastien', 'Colin', 'sebastien_c', '$2b$12$q81FSIQaYmwNf4Gu57gw4OEryhg4gb2ET94TMOsEuLxtOEfe6Evqa'),
(33, '2026-04-12 11:30:00', 'marine.brunet@mail.com', 'Marine', 'Brunet', 'marine_b', '$2b$12$q81FSIQaYmwNf4Gu57gw4OEryhg4gb2ET94TMOsEuLxtOEfe6Evqa'),
(35, '2026-04-13 16:20:00', 'sarah.martinez@mail.com', 'Sarah', 'Martinez', 'sarah_m', '$2b$12$q81FSIQaYmwNf4Gu57gw4OEryhg4gb2ET94TMOsEuLxtOEfe6Evqa'),
(36, '2026-04-14 08:40:00', 'guillaume.david@mail.com', 'Guillaume', 'David', 'guillaume_d', '$2b$12$q81FSIQaYmwNf4Gu57gw4OEryhg4gb2ET94TMOsEuLxtOEfe6Evqa'),
(37, '2026-04-14 13:00:00', 'aurore.bertrand@mail.com', 'Aurore', 'Bertrand', 'aurore_b', '$2b$12$q81FSIQaYmwNf4Gu57gw4OEryhg4gb2ET94TMOsEuLxtOEfe6Evqa'),
(38, '2026-04-15 09:20:00', 'florian.robert@mail.com', 'Florian', 'Robert', 'florian_r', '$2b$12$q81FSIQaYmwNf4Gu57gw4OEryhg4gb2ET94TMOsEuLxtOEfe6Evqa'),
(39, '2026-04-16 10:10:00', 'estelle.richard@mail.com', 'Estelle', 'Richard', 'estelle_r', '$2b$12$q81FSIQaYmwNf4Gu57gw4OEryhg4gb2ET94TMOsEuLxtOEfe6Evqa'),
(40, '2026-04-17 08:30:00', 'baptiste.durand@mail.com', 'Baptiste', 'Durand', 'baptiste_d', '$2b$12$q81FSIQaYmwNf4Gu57gw4OEryhg4gb2ET94TMOsEuLxtOEfe6Evqa'),
(41, '2026-04-18 11:00:00', 'noemie.lefevre@mail.com', 'Noémie', 'Lefèvre', 'noemie_l', '$2b$12$q81FSIQaYmwNf4Gu57gw4OEryhg4gb2ET94TMOsEuLxtOEfe6Evqa');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `ADMINS`
--
ALTER TABLE `ADMINS`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `CYCLES`
--
ALTER TABLE `CYCLES`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team_id` (`team_id`);

--
-- Index pour la table `FRICTIONS`
--
ALTER TABLE `FRICTIONS`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`author_id`),
  ADD KEY `team_id` (`team_id`),
  ADD KEY `status_id` (`status_id`);

--
-- Index pour la table `FRICTION_STATUS`
--
ALTER TABLE `FRICTION_STATUS`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `FRICTION_VOTES`
--
ALTER TABLE `FRICTION_VOTES`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cycle_id` (`cycle_id`),
  ADD KEY `friction_id` (`friction_id`),
  ADD KEY `member_id` (`member_id`);

--
-- Index pour la table `INVITATIONS`
--
ALTER TABLE `INVITATIONS`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `team_id` (`team_id`),
  ADD KEY `status_id` (`status_id`);

--
-- Index pour la table `INVITATIONS_STATUS`
--
ALTER TABLE `INVITATIONS_STATUS`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `SOLUTION_VOTES`
--
ALTER TABLE `SOLUTION_VOTES`
  ADD PRIMARY KEY (`id`),
  ADD KEY `treatment_id` (`treatment_id`),
  ADD KEY `member_id` (`member_id`);

--
-- Index pour la table `TEAMS`
--
ALTER TABLE `TEAMS`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `user_id` (`creator_id`);

--
-- Index pour la table `TEAM_MEMBERS`
--
ALTER TABLE `TEAM_MEMBERS`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team_id` (`team_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `TREATMENTS`
--
ALTER TABLE `TREATMENTS`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`pilot_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `cycle_id` (`cycle_id`),
  ADD KEY `friction_id` (`friction_id`);

--
-- Index pour la table `TREATMENT_STATUS`
--
ALTER TABLE `TREATMENT_STATUS`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `USERS`
--
ALTER TABLE `USERS`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `ADMINS`
--
ALTER TABLE `ADMINS`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `CYCLES`
--
ALTER TABLE `CYCLES`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `FRICTIONS`
--
ALTER TABLE `FRICTIONS`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT pour la table `FRICTION_STATUS`
--
ALTER TABLE `FRICTION_STATUS`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `FRICTION_VOTES`
--
ALTER TABLE `FRICTION_VOTES`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `INVITATIONS`
--
ALTER TABLE `INVITATIONS`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `INVITATIONS_STATUS`
--
ALTER TABLE `INVITATIONS_STATUS`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `SOLUTION_VOTES`
--
ALTER TABLE `SOLUTION_VOTES`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `TEAMS`
--
ALTER TABLE `TEAMS`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `TEAM_MEMBERS`
--
ALTER TABLE `TEAM_MEMBERS`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT pour la table `TREATMENTS`
--
ALTER TABLE `TREATMENTS`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `TREATMENT_STATUS`
--
ALTER TABLE `TREATMENT_STATUS`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `USERS`
--
ALTER TABLE `USERS`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
