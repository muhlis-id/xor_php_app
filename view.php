<?php
// view.php
require 'db.php';
$config = require 'config.php';
$key_b64 = $config['app_key_b64'];
require 'crypto.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM notes WHERE id = ?");
$stmt->execute([$id]);
$row = $stmt->fetch();
if (!$row) {
    http_response_code(404);
    echo "Note tidak ditemukan."; exit;
}
$nonce = $row['nonce']; // binary
$plaintext = xor_decrypt($row['ciphertext'], $key_b64, $nonce);
?>
<!doctype html><html><head><meta charset="utf-8"><title>Lihat Note</title></head><body>
<h1><?=htmlspecialchars($row['title'])?></h1>
<p><em>Dibuat: <?=htmlspecialchars($row['created_at'])?></em></p>
<pre><?=htmlspecialchars($plaintext)?></pre>
<p><a href="index.php">Kembali</a> | <a href="edit.php?id=<?=$id?>">Edit</a></p>
</body></html>