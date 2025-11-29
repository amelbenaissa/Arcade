<?php
$pageTitle = 'Connexion employé';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/header.php';

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $login = trim($_POST['login'] ?? '');
  $password = (string)($_POST['password'] ?? '');

  if ($login === '' || $password === '') {
    $error = "Veuillez remplir tous les champs.";
  } else {
    try {
      $st = $pdo->prepare("SELECT id_employe, login, mot_de_passe, role FROM Employe WHERE login = :login");
      $st->execute([':login' => $login]);
      $u = $st->fetch();

      // Support: either a hashed password (preferred) or legacy plain text (discouraged).
      $ok = false;
      if ($u && is_string($u['mot_de_passe'])) {
        $stored = $u['mot_de_passe'];
        $isHash = str_starts_with($stored, '$2y$') || str_starts_with($stored, '$argon2');
        $ok = $isHash ? password_verify($password, $stored) : hash_equals($stored, $password);
      }

      if ($ok) {
        session_regenerate_id(true);
        $_SESSION['employe_id'] = (int)$u['id_employe'];
        $_SESSION['employe_login'] = $u['login'];
        $_SESSION['employe_role'] = $u['role'];

        header("Location: {$BASE_URL}/admin/dashboard.php");
        exit;
      }
      $error = "Login ou mot de passe incorrect.";
    } catch (Throwable $e) {
      $error = "Erreur lors de la connexion.";
    }
  }
}
?>

<section class="page-header">
  <h1>Espace employé</h1>
  <p>Connexion réservée aux employés (accès via <code>/admin</code>).</p>
</section>

<div class="form-wrap">
  <form method="post" class="card form-card">
    <div class="form-row">
      <label for="login">Login</label>
      <input id="login" name="login" type="text" required>
    </div>
    <div class="form-row">
      <label for="password">Mot de passe</label>
      <input id="password" name="password" type="password" required>
    </div>
    <button class="btn btn-primary" type="submit">Se connecter</button>
    <p class="form-help">Première connexion ? <a href="<?= e($BASE_URL) ?>/admin/first_login.php">Activer mon compte</a></p>

    <?php if ($error): ?>
      <p class="msg error"><?= e($error) ?></p>
    <?php endif; ?>
  </form>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
