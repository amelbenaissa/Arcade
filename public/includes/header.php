<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * BASE_URL (racine du site) pour que les assets (CSS / images) fonctionnent
 * aussi bien sur /admin/* que sur les pages publiques.
 *
 * Exemples :
 *  - /index.php            => BASE_URL = ""
 *  - /admin/login.php      => BASE_URL = ""
 *  - /parc/index.php       => BASE_URL = "/parc"
 *  - /parc/admin/login.php => BASE_URL = "/parc"
 */
$script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
$dir = rtrim(dirname($script), '/');
if ($dir === '/') { $dir = ''; }
$BASE_URL = preg_replace('#/admin(/.*)?$#', '', $dir);

$pageTitle = $pageTitle ?? 'Accueil';

if (!headers_sent()) {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('Referrer-Policy: strict-origin-when-cross-origin');
}

function e(string $s): string { return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }

?><!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Arcade Galaxy — <?= e($pageTitle) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Arcade Galaxy — Parc indoor : arcade, VR, laser game, karting, et plus encore. Consultez formules, attractions et points fidélité.">
  <link rel="stylesheet" href="<?= e($BASE_URL) ?>/assets/css/style.css">
  <link rel="icon" type="image/x-icon" href="<?= e($BASE_URL) ?>/assets/img/favicon.ico">
</head>
<body>
<header class="site-header">
  <div class="logo-wrap">
    <a class="logo-link" href="<?= e($BASE_URL) ?>/index.php">
      <img class="logo" src="<?= e($BASE_URL) ?>/assets/img/logo_parc.png" alt="Logo Arcade Galaxy">
      <div class="logo-text">
        <span class="logo-title">Arcade Galaxy</span>
        <span class="logo-subtitle">Parc indoor</span>
      </div>
    </a>
  </div>

  <nav class="main-nav" aria-label="Navigation principale">
    <a class="nav-link" href="<?= e($BASE_URL) ?>/index.php">Accueil</a>
    <a class="nav-link" href="<?= e($BASE_URL) ?>/formules.php">Formules</a>
    <a class="nav-link" href="<?= e($BASE_URL) ?>/attractions.php">Attractions</a>
    <a class="nav-link" href="<?= e($BASE_URL) ?>/points.php">Points fidélité</a>
    <a class="nav-link nav-link-admin" href="<?= e($BASE_URL) ?>/admin/login.php">Espace employé</a>
  </nav>
</header>

<main class="main-content">
