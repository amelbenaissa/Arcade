# Parc Indoor — Arcade Galaxy (version améliorée)

## Contenu
- Accueil : 5W + visuels + CTA
- Formules : liste depuis la table `Formule`
- Attractions : liste depuis la table `Zone`
- Points fidélité : client -> affiche `points_fidelite` (jointure `Personne` + `Client`)
- Admin (`/public/admin`) :
  - login
  - first_login (hachage du mot de passe)
  - dashboard (recherche points client + signalement incident)

## Installation (XAMPP / Local)
1. Copier le dossier `parc_indoor_improved` où vous voulez (ex: `C:/xampp/htdocs/`).
2. Ouvrir dans navigateur :
   - `http://localhost/parc_indoor_improved/public/index.php`

## Base de données
- Modifiez `public/config/db.php` (ou définissez les variables d'environnement DB_HOST/DB_NAME/DB_USER/DB_PASS).
- Tables attendues (selon votre rapport) : `Formule`, `Zone`, `Personne`, `Client`, `Employe`.

## Notes
- Les ventes sont indiquées comme **uniquement au guichet** (pas d'achat en ligne).
- Le signalement d'incident écrit dans `public/logs/incidents.log` (facile à remplacer par une table SQL).
