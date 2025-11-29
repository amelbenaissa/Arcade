<?php
$pageTitle = 'Dashboard';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/header.php';

if (empty($_SESSION['employe_id'])) {
  header("Location: {$BASE_URL}/admin/login.php");
  exit;
}

$clientRow = null;
$searchMsg = null;
$incidentMsg = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'search_points') {
  $email = trim($_POST['email_client'] ?? '');
  if ($email === '') {
    $searchMsg = "Veuillez saisir un email client.";
  } else {
    try {
      $sql = "SELECT p.nom, p.prenom, p.email, c.points_fidelite
              FROM Personne p
              JOIN Client c ON p.id_personne = c.id_client
              WHERE LOWER(p.email)=LOWER(:email)";
      $st = $pdo->prepare($sql);
      $st->execute([':email' => $email]);
      $clientRow = $st->fetch();
      if (!$clientRow) $searchMsg = "Aucun client trouvé.";
    } catch (Throwable $e) {
      $searchMsg = "Erreur lors de la recherche.";
    }
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'incident') {
  $txt = trim($_POST['incident'] ?? '');
  if ($txt === '') {
    $incidentMsg = "Veuillez décrire l'incident.";
  } else {
    $line = date('Y-m-d H:i:s') . " | employe_id=" . (int)$_SESSION['employe_id'] . " | " . $txt . PHP_EOL;
    @file_put_contents(__DIR__ . '/../logs/incidents.log', $line, FILE_APPEND);
    $incidentMsg = "Incident enregistré ✅";
  }
}
?>

<section class="page-header">
  <h1>Tableau de bord</h1>
  <p>Connecté en tant que <strong><?= e($_SESSION['employe_login'] ?? '') ?></strong> — rôle : <?= e($_SESSION['employe_role'] ?? 'employe') ?></p>
</section>

<div class="cards-grid">
  <section class="card">
    <h2>Consulter points client</h2>
    <form method="post">
      <input type="hidden" name="action" value="search_points">
      <div class="form-row">
        <label for="email_client">Email client</label>
        <input id="email_client" name="email_client" type="email" required>
      </div>
      <button class="btn btn-primary" type="submit">Rechercher</button>
    </form>

    <?php if ($searchMsg): ?>
      <p class="msg <?= $clientRow ? 'success' : 'error' ?>"><?= e($searchMsg) ?></p>
    <?php endif; ?>

    <?php if ($clientRow): ?>
      <div class="hr"></div>
      <h3><?= e($clientRow['prenom'] . ' ' . $clientRow['nom']) ?></h3>
      <p class="muted"><?= e($clientRow['email']) ?></p>
      <div class="price"><?= (int)$clientRow['points_fidelite'] ?> points</div>
    <?php endif; ?>
  </section>

  <section class="card">
    <h2>Signaler un incident</h2>
    <form method="post">
      <input type="hidden" name="action" value="incident">
      <div class="form-row">
        <label for="incident">Description</label>
        <textarea id="incident" name="incident" rows="6" placeholder="Ex: panne VR #2, zone VR, 18:20..."></textarea>
      </div>
      <button class="btn btn-secondary" type="submit">Envoyer</button>
    </form>

    <?php if ($incidentMsg): ?>
      <p class="msg <?= str_contains($incidentMsg,'✅') ? 'success' : 'error' ?>"><?= e($incidentMsg) ?></p>
    <?php endif; ?>

    <p class="form-help">Les incidents sont enregistrés dans <code>public/logs/incidents.log</code> (à remplacer par une table SQL si besoin).</p>
  </section>
</div>

<p class="text-right">
  <a class="btn btn-link" href="<?= e($BASE_URL) ?>/admin/logout.php">Déconnexion</a>
</p>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
