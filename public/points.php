<?php
$pageTitle = 'Points fidélité';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/includes/header.php';

$points = null;
$client = null;
$msg = null;
$msgType = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nom = trim($_POST['nom'] ?? '');
  $prenom = trim($_POST['prenom'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $naissance = trim($_POST['date_naissance'] ?? '');

  if ($nom === '' || $prenom === '' || $email === '' || $naissance === '') {
    $msg = "Merci de remplir tous les champs.";
    $msgType = 'error';
  } else {
    try {
      $sql = "SELECT p.nom, p.prenom, p.email, c.points_fidelite
              FROM Personne p
              JOIN Client c ON p.id_personne = c.id_client
              WHERE LOWER(p.nom)=LOWER(:nom)
                AND LOWER(p.prenom)=LOWER(:prenom)
                AND LOWER(p.email)=LOWER(:email)
                AND p.date_naissance=:dn";
      $st = $pdo->prepare($sql);
      $st->execute([
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':email' => $email,
        ':dn' => $naissance,
      ]);
      $client = $st->fetch();
      if ($client) {
        $points = (int)$client['points_fidelite'];
        $msgType = 'success';
      } else {
        $msg = "Aucun compte fidélité trouvé avec ces informations.";
        $msgType = 'error';
      }
    } catch (Throwable $e) {
      $msg = "Erreur lors de la récupération des points.";
      $msgType = 'error';
    }
  }
}

$rewards = [
  ['nom' => 'Bonus boisson', 'points' => 120],
  ['nom' => 'Accès Fast Track (1 attraction)', 'points' => 250],
  ['nom' => 'Réduction -10% sur une formule', 'points' => 400],
  ['nom' => 'Pass VIP (upgrade)', 'points' => 650],
];
?>

<section class="page-header">
  <h1>Consulter mes points</h1>
  <p>Renseignez vos informations pour consulter votre solde de points fidélité.</p>
</section>

<div class="form-wrap">
  <form method="post" class="card form-card" autocomplete="on">
    <div class="form-row">
      <label for="nom">Nom</label>
      <input id="nom" name="nom" type="text" required value="<?= e($_POST['nom'] ?? '') ?>">
    </div>
    <div class="form-row">
      <label for="prenom">Prénom</label>
      <input id="prenom" name="prenom" type="text" required value="<?= e($_POST['prenom'] ?? '') ?>">
    </div>
    <div class="form-row">
      <label for="email">Email</label>
      <input id="email" name="email" type="email" required value="<?= e($_POST['email'] ?? '') ?>">
    </div>
    <div class="form-row">
      <label for="date_naissance">Date de naissance</label>
      <input id="date_naissance" name="date_naissance" type="date" required value="<?= e($_POST['date_naissance'] ?? '') ?>">
    </div>
    <button class="btn btn-primary" type="submit">Afficher mes points</button>

    <p class="form-help">🔒 Vos données ne servent qu’à retrouver votre compte dans la base.</p>

    <?php if ($msg): ?>
      <p class="msg <?= $msgType === 'success' ? 'success' : 'error' ?>"><?= e($msg) ?></p>
    <?php endif; ?>
  </form>

  <?php if ($points !== null): ?>
    <section class="card" aria-label="Résultat points">
      <h2><?= e($client['prenom'] . ' ' . $client['nom']) ?></h2>
      <p>Solde actuel :</p>
      <div class="price"><?= (int)$points ?> points</div>
      <p class="muted">Les échanges se font au guichet. Barèmes recommandés :</p>

      <div class="cards-grid" style="margin-top:10px">
        <?php foreach ($rewards as $r): ?>
          <div class="card" style="box-shadow:none">
            <h3 style="margin:0 0 6px"><?= e($r['nom']) ?></h3>
            <p class="muted" style="margin:0"><?= (int)$r['points'] ?> points</p>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
