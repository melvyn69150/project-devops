<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = getenv('DB_HOST') ?: 'db';
$port = getenv('DB_PORT') ?: '3306';
$db   = getenv('DB_NAME') ?: 'chatdb';
$user = getenv('DB_USER') ?: 'chatuser';
$pass = getenv('DB_PASS') ?: 'chatpass';

$pdo = null;
$dbErr = '';

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4",
        $user, $pass,
        [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ]
    );
} catch (Throwable $e) {
    $dbErr = $e->getMessage();
}
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<title>Chat</title>
<style>
body{font-family:system-ui, Arial; max-width:800px; margin:2rem auto;}
.warn{background:#fee;border:1px solid #c00;padding:8px;margin:10px 0}
.msg{border-bottom:1px solid #eee;padding:6px 0}
small{color:#666}
</style>
</head>
<body>
<h1>Chat</h1>

<?php if ($dbErr): ?>
  <div class="warn">Échec de la connexion DB : <?= htmlspecialchars($dbErr) ?></div>
<?php endif; ?>

<form method="post">
  <p><label>Nom d'utilisateur : <br>
    <input name="user" required></label></p>
  <p><label>Message : <br>
    <textarea name="msg" rows="3" required></textarea></label></p>
  <p><button type="submit" <?= $pdo ? '' : 'disabled' ?>>Envoyer</button></p>
</form>

<?php
if ($pdo && !empty($_POST['user']) && !empty($_POST['msg'])) {
    $stmt = $pdo->prepare('INSERT INTO messages(user, msg) VALUES (?, ?)');
    $stmt->execute([ $_POST['user'], $_POST['msg'] ]);
}

if ($pdo) {
    $pdo->exec("CREATE TABLE IF NOT EXISTS messages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user VARCHAR(64) NOT NULL,
        msg TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    echo "<h2>Derniers messages</h2>";
    foreach ($pdo->query("SELECT user, msg, created_at FROM messages ORDER BY id DESC LIMIT 20") as $row) {
        echo '<div class="msg"><b>'.htmlspecialchars($row['user']).'</b> : '
           . nl2br(htmlspecialchars($row['msg']))
           . ' <br><small>'.$row['created_at'].'</small></div>';
    }
}
?>
</body>
</html>
