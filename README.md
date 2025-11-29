# Parc Indoor — Arcade Galaxy

## 🎮 Description
Système de gestion pour parc d'attractions indoor comprenant des zones de jeux (arcade, karting, laser game, VR) avec gestion des formules, points fidélité et interface administrateur.

## 📋 Contenu
- **Accueil** : Présentation du parc avec visuels et appel à l'action
- **Formules** : Liste des formules depuis la base de données
- **Attractions** : Liste des zones d'activités
- **Points fidélité** : Consultation des points par numéro client
- **Admin** (`/public/admin`) :
  - Authentification sécurisée
  - Tableau de bord
  - Recherche points client
  - Signalement d'incidents

## 🚀 Installation locale

### Prérequis
- PHP 7.4+
- PostgreSQL
- Serveur web (Apache/XAMPP)

### Étapes
1. Cloner le repository :
   ```bash
   git clone https://github.com/amelbenaissa/Arcade.git
   cd Arcade
   ```

2. Configurer la base de données :
   - Copier `public/config/db.php.example` vers `public/config/db.php`
   - Modifier les identifiants de connexion

3. Lancer le serveur local :
   - Placer le projet dans `htdocs/`
   - Accéder à `http://localhost/Arcade/public/`

## 🗄️ Base de données
Tables PostgreSQL requises : `Formule`, `Zone`, `Personne`, `Client`, `Employe`

Voir le fichier de configuration : `public/config/db.php.example`

## 📦 Déploiement
Consultez le guide détaillé dans `DEPLOIEMENT.md` pour mettre en ligne sur AlwaysData ou autre hébergeur.

## 🔒 Sécurité
- Mots de passe hachés avec `password_hash()`
- Protection des données sensibles via `.gitignore`
- Variables d'environnement supportées

## 📝 Notes
- Ventes **uniquement au guichet** (pas d'achat en ligne)
- Signalement d'incidents : `public/logs/incidents.log`
