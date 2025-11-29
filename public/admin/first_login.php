<?php
$pageTitle = 'Première connexion';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/header.php';

$msg = null; $type = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $login = trim($_POST['login'] ?? '');
  $old = (string)($_POST['old_password'] ?? '');
  $new = (string)($_POST['new_password'] ?? '');

  if ($login === '' || $old === '' || $new === '') {
    $msg = "Tous les champs sont obligatoires.";
    $type = 'error';
  } elseif (mb_strlen($new) < 8) {
    $msg = "Le nouveau mot de passe doit contenir au moins 8 caractères.";
    $type = 'error';
  } else {
    try {
      $st = $pdo->prepare("SELECT id_employe, mot_de_passe FROM Employe WHERE login=:login");
      $st->execute([':login' => $login]);
      $u = $st->fetch();

      if (!$u) {
        $msg = "Employé introuvable.";
        $type = 'error';
      } else {
        $stored = (string)($u['mot_de_passe'] ?? '');
        $isHash = str_starts_with($stored, '$2y$') || str_starts_with($stored, '$argon2');

        // If already hashed: require correct current password; else treat as legacy plain.
        $matches = $isHash ? password_verify($old, $stored) : hash_equals($stored, $old);

        if (!$matches) {
          $msg = "Mot de passe actuel incorrect.";
          $type = 'error';
        } else {
          $hash = password_hash($new, PASSWORD_DEFAULT);
          $up = $pdo->prepare("UPDATE Employe SET mot_de_passe=:hash WHERE id_employe=:id");
          $up->execute([':hash' => $hash, ':id' => (int)$u['id_employe']]);

          $msg = "Compte sécurisé ✅ Vous pouvez maintenant vous connecter.";
          $type = 'success';
        }
      }
    } catch (Throwable $e) {
      $msg = "Erreur lors de la mise à jour du mot de passe.";
      $type = 'error';
    }
  }
}
?>

<section class="page-header">
  <h1>Première connexion</h1>
  <p>Sécurisez votre compte : le mot de passe sera stocké sous forme hachée.</p>
</section>

<div class="form-wrap">
  <form method="post" class="card form-card">
    <div class="form-row">
      <label for="login">Login</label>
      <input id="login" name="login" type="text" required>
    </div>
    <div class="form-row">
      <label for="old_password">Mot de passe actuel</label>
      <input id="old_password" name="old_password" type="password" required>
    </div>
    <div class="form-row">
      <label for="new_password">Nouveau mot de passe</label>
      <input id="new_password" name="new_password" type="password" required>
    </div>

    <button class="btn btn-primary" type="submit">Valider</button>
    <a class="btn btn-link" href="<?= e($BASE_URL) ?>/admin/login.php">Retour</a>

    <?php if ($msg): ?>
      <p class="msg <?= $type === 'success' ? 'success' : 'error' ?>"><?= e($msg) ?></p>
    <?php endif; ?>
  </form>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
