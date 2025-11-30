<?php
// create.php
require 'db.php';
$config = require 'config.php';
$key_b64 = $config['app_key_b64'];

require 'crypto.php';

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    if (trim($title) === '' || trim($content) === '') {
        $err = 'Title dan Content wajib diisi.';
    } else {
        $enc = xor_encrypt($content, $key_b64); // returns ciphertext_b64 and nonce (binary)
        $sql = "INSERT INTO notes (title, ciphertext, nonce) VALUES (:title, :ciphertext, :nonce)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':ciphertext', $enc['ciphertext_b64']);
        $stmt->bindValue(':nonce', $enc['nonce'], PDO::PARAM_LOB);
        $stmt->execute();
        header('Location: index.php');
        exit;
    }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Buat Note</title></head><body>
<h1>Buat Note</h1>
<?php if($err): ?><p style="color:red"><?=htmlspecialchars($err)?></p><?php endif; ?>
<form method="post">
  <p>Title<br><input name="title" style="width:400px"></p>
  <p>Content<br><textarea name="content" rows="6" cols="60"></textarea></p>
  <p><button type="submit">Simpan</button> <a href="index.php">Batal</a></p>
</form>
</body></html>