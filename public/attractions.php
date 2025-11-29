<?php
$pageTitle = 'Attractions';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/header.php';

function risk_tag_class(string $risk): string {
  $r = mb_strtolower(trim($risk));
  return match ($r) {
    'faible' => 'faible',
    'moyen' => 'moyen',
    'eleve', 'élevé' => 'eleve',
    'critique' => 'critique',
    default => 'moyen',
  };
}

/**
 * ✅ Liste selon le rapport (zones 11 à 14).
 */
$zones = [
  ['id_zone'=>11,'nom_zone'=>'Arcade','description'=>'Jeux et simulateurs','capacite_max'=>80,'niveau_risque'=>'faible','image'=>'arcade.png'],
  ['id_zone'=>12,'nom_zone'=>'LaserGame','description'=>'Combat laser en équipe','capacite_max'=>40,'niveau_risque'=>'moyen','image'=>'laser.png'],
  ['id_zone'=>13,'nom_zone'=>'VR Arena','description'=>'Réalité virtuelle','capacite_max'=>30,'niveau_risque'=>'élevé','image'=>'vr.png'],
  ['id_zone'=>14,'nom_zone'=>'Karting','description'=>'Circuit intérieur','capacite_max'=>25,'niveau_risque'=>'critique','image'=>'karting.png'],
];

?>

<section class="page-header">
  <h1>Attractions & zones</h1>
  <p>Les attractions du parc (selon le rapport). Pour les consignes, voir sur place.</p>
</section>

<section class="cards-grid">
  <?php foreach ($zones as $z): ?>
    <?php $tag = risk_tag_class($z['niveau_risque'] ?? 'moyen'); ?>
    <article class="card">
      <div style="border-radius:14px; overflow:hidden; border:1px solid rgba(255,255,255,.10); margin-bottom:10px">
        <img src="<?= e($BASE_URL) ?>/assets/img/<?= e($z['image']) ?>" alt="<?= e($z['nom_zone']) ?>" style="width:100%; display:block">
      </div>

      <h2><?= e($z['nom_zone']) ?></h2>
      <p><?= e($z['description']) ?></p>

      <ul class="meta">
        <li>Capacité max : <?= (int)($z['capacite_max'] ?? 0) ?> personnes</li>
        <li>Niveau : <span class="tag <?= e($tag) ?>"><?= e(ucfirst($z['niveau_risque'] ?? 'Moyen')) ?></span></li>
      </ul>
    </article>
  <?php endforeach; ?>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
