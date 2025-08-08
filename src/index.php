<?php
$dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8', getenv('DB_HOST'), getenv('DB_NAME'));
try {
  $pdo = new PDO($dsn, getenv('DB_USER'), getenv('DB_PASS'));
  echo "OK - Connexion DB\n";
} catch (Exception $e) {
  echo "ERREUR DB: " . $e->getMessage();
}
?>
