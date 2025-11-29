# Guide de déploiement - Parc Indoor

## 📋 Prérequis
- Compte AlwaysData actif
- Base de données PostgreSQL créée
- Client FTP (FileZilla) ou accès SSH

## 🚀 Étapes de déploiement

### 1. Préparer la base de données
```sql
-- Vérifiez que votre base contient les tables nécessaires :
-- Formule, Zone, Personne, Client, Employe, etc.
```

### 2. Upload des fichiers

**Via FTP :**
- Hôte : `ftp-benaissa.alwaysdata.net`
- User : `benaissa`
- Uploadez tout le contenu de `/public` vers `/www/`

**Via SSH :**
```bash
scp -r public/* benaissa@ssh-benaissa.alwaysdata.net:www/
```

### 3. Configuration du site AlwaysData

1. Connexion : https://admin.alwaysdata.com
2. Menu **Web > Sites**
3. Ajouter un site :
   - Type : PHP 8.x
   - Racine : `/www/`
   - Adresses : votre-domaine.alwaysdata.net

### 4. Variables d'environnement (optionnel)

Dans AlwaysData admin > **Environment > Variables d'environnement** :
```
DB_HOST=postgresql-benaissa.alwaysdata.net
DB_PORT=5432
DB_NAME=benaissa_arcade_syst
DB_USER=benaissa
DB_PASS=votre_mot_de_passe
```

### 5. Permissions des dossiers

Assurez-vous que le dossier `logs/` est accessible en écriture :
```bash
chmod 755 logs/
```

### 6. Premier accès admin

1. Accédez à : `https://votre-domaine.alwaysdata.net/admin/first_login.php`
2. Configurez le mot de passe de l'administrateur
3. Connectez-vous via : `https://votre-domaine.alwaysdata.net/admin/login.php`

## 🔒 Sécurité

- [ ] Changez le mot de passe de la base de données dans `config/db.php`
- [ ] Supprimez ou protégez `first_login.php` après la première utilisation
- [ ] Vérifiez que `.htaccess` protège bien le dossier `/admin`
- [ ] Activez HTTPS dans la configuration AlwaysData

## 📁 Structure en ligne

```
/www/
├── index.php
├── formules.php
├── attractions.php
├── points.php
├── admin/
│   ├── login.php
│   ├── dashboard.php
│   └── first_login.php
├── config/
│   └── db.php
├── assets/
│   ├── css/
│   ├── js/
│   └── img/
├── includes/
└── logs/
```

## 🌐 URLs

- **Site public** : https://benaissa.alwaysdata.net/
- **Admin** : https://benaissa.alwaysdata.net/admin/
- **PhpPgAdmin** : Disponible dans l'admin AlwaysData

## ❓ Problèmes courants

### Erreur de connexion DB
- Vérifiez les identifiants dans `config/db.php`
- Testez la connexion via PhpPgAdmin dans AlwaysData

### Pages non trouvées (404)
- Vérifiez que la racine du site pointe vers `/www/`
- Assurez-vous que tous les fichiers sont uploadés

### Erreur 500
- Vérifiez les permissions des fichiers
- Consultez les logs dans AlwaysData admin > **Logs > Logs web**
