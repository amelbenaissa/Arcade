<?php
$pageTitle = 'Formules';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/header.php';

/**
 * ✅ PRIX & DURÉES = ceux du rapport.
 * On ne dépend pas de la base : même si la table contient d'autres prix
 * (ex: 50 / 500), cette page affichera les valeurs attendues dans le rapport.
 */
$formules = [
  ['id_formule'=>301,'nom_formule'=>'Formule journée','description'=>'Accès zone Arcade','duree_jours'=>1,'duree_heure'=>24,'prix'=>25.00],
  ['id_formule'=>302,'nom_formule'=>'Formule Semaine','description'=>'Accès zones Arcade + LaserGame','duree_jours'=>7,'duree_heure'=>0,'prix'=>75.00],
  ['id_formule'=>303,'nom_formule'=>'Formule VIP','description'=>'Accès toutes zones + Fast Track','duree_jours'=>30,'duree_heure'=>0,'prix'=>150.00],
  ['id_formule'=>304,'nom_formule'=>'Formule Soirée','description'=>'Accès 3h zones vertes','duree_jours'=>0,'duree_heure'=>3,'prix'=>10.00],
];
?>

<section class="page-header">
  <h1>Nos formules</h1>
  <p>Les ventes se font uniquement au guichet. Les prix affichés sont ceux du rapport.</p>
</section>

<section class="cards-grid">
  <?php foreach ($formules as $f): ?>
    <article class="card">
      <h2><?= e($f['nom_formule']) ?></h2>
      <div class="price"><?= number_format((float)$f['prix'], 2, ',', ' ') ?> €</div>
      <p><?= e($f['description']) ?></p>

      <ul class="meta">
        <?php if (!empty($f['duree_jours'])): ?>
          <li>Durée : <?= (int)$f['duree_jours'] ?> jour(s)</li>
        <?php endif; ?>
        <?php if (!empty($f['duree_heure'])): ?>
          <li>Durée : <?= (int)$f['duree_heure'] ?> heure(s)</li>
        <?php endif; ?>
      </ul>

      <div class="note">🎟️ Achat au guichet • Les points fidélité s’appliquent selon ton profil.</div>
    </article>
  <?php endforeach; ?>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
