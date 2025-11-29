<?php
$pageTitle = 'Accueil';
require_once __DIR__ . '/includes/header.php';
?>

<section class="hero">
  <div class="hero-card">
    <h1 class="hero-title">Bienvenue à Arcade Galaxy</h1>
    <p class="hero-sub">Arcade, VR, laser game, karting indoor… une expérience immersive et sécurisée pour tous.</p>
    <div style="display:flex; gap:10px; flex-wrap:wrap">
      <a class="btn btn-primary" href="<?= e($BASE_URL) ?>/formules.php">Voir les formules</a>
      <a class="btn btn-secondary" href="<?= e($BASE_URL) ?>/attractions.php">Explorer les attractions</a>
    </div>

    <div class="hero-badges" aria-label="Informations clés">
      <span class="badge">Vente au guichet</span>
      <span class="badge">Soirées à thème</span>
      <span class="badge">Fast Track</span>
      <span class="badge">Anniversaires</span>
    </div>
  </div>

  <div class="hero-gallery" aria-label="Photos du parc">
    <div class="hero-photo one" role="img" aria-label="Espace arcade"></div>
    <div class="hero-photo two" role="img" aria-label="Laser game"></div>
    <div class="hero-photo three" role="img" aria-label="Karting indoor"></div>
  </div>
</section>

<section class="section-5w" id="5w">
  <h2 class="section-title">Les 5W du parc</h2>
  <div class="cards-grid">
    <article class="card">
      <h3>Qui ?</h3>
      <p>Familles, étudiants, groupes d’amis, entreprises : chacun trouve sa dose de fun.</p>
    </article>
    <article class="card">
      <h3>Quoi ?</h3>
      <p>Arcade rétro & moderne, VR arena, laser game, karting indoor, zone chill & snack.</p>
    </article>
    <article class="card">
      <h3>Quand ?</h3>
      <p>Ouvert 7j/7. Créneaux privatisables pour événement, team building et anniversaires.</p>
    </article>
    <article class="card">
      <h3>Où ?</h3>
      <p>Accès facile en transports. Parking gratuit. Indications sur place et au guichet.</p>
    </article>
    <article class="card">
      <h3>Pourquoi ?</h3>
      <p>Une immersion “parc” avec une navigation claire, et des infos utiles avant la visite.</p>
    </article>
  </div>
</section>

<section class="section-highlight" aria-label="Mise en avant">
  <h2>Fast Track & Pass VIP</h2>
  <p class="muted">Gagne du temps sur certaines attractions avec des options Fast Track / VIP (selon formule).</p>
  <a class="btn btn-link" href="<?= e($BASE_URL) ?>/points.php">Consulter mes points fidélité →</a>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
