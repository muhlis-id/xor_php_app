<?php
// edit.php
require 'db.php';
$config = require 'config.php';
$key_b64 = $config['app_key_b64'];
require 'crypto.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM notes WHERE id = ?");
$stmt->execute([$id]);
$row = $stmt->fetch();
if (!$row) { echo "Not found"; exit; }

$nonce_old = $row['nonce'];
$content_old = xor_decrypt($row['ciphertext'], $key_b64, $nonce_old);

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    if (trim($title) === '' || trim($content) === '') {
        $err = 'Title dan Content wajib diisi.';
    } else {
        // re-encrypt with new nonce (so keystream unik)
        $enc = xor_encrypt($content, $key_b64);
        $sql = "UPDATE notes SET title=:title, ciphertext=:ciphertext, nonce=:nonce WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':ciphertext', $enc['ciphertext_b64']);
        $stmt->bindValue(':nonce', $enc['nonce'], PDO::PARAM_LOB);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        header('Location: view.php?id=' . $id);
        exit;
    }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Edit Note</title></head><body>
<h1>Edit Note</h1>
<?php if($err): ?><p style="color:red"><?=htmlspecialchars($err)?></p><?php endif; ?>
<form method="post">
  <p>Title<br><input name="title" value="<?=htmlspecialchars($row['title'])?>" style="width:400px"></p>
  <p>Content<br><textarea name="content" rows="6" cols="60"><?=htmlspecialchars($content_old)?></textarea></p>
  <p><button type="submit">Simpan</button> <a href="view.php?id=<?=$id?>">Batal</a></p>
</form>
</body></html>