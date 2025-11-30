<?php
// index.php - list notes
require 'db.php';
$stmt = $pdo->query("SELECT id, title, created_at, updated_at FROM notes ORDER BY id DESC");
$rows = $stmt->fetchAll();
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Enkripsi - XOR CRUD</title></head>
<body>
<h1>App Konversi Catatan dengan Enkripsi Simetris XOR</h1>
<p><a href="create.php">+ Buat Catatan Baru</a></p>
<table border="1" cellpadding="6" cellspacing="0">
<tr><th>ID</th><th>Title</th><th>Created</th><th>Updated</th><th>Aksi</th></tr>
<?php foreach($rows as $r): ?>
<tr>
  <td><?=htmlspecialchars($r['id'])?></td>
  <td><?=htmlspecialchars($r['title'])?></td>
  <td><?=htmlspecialchars($r['created_at'])?></td>
  <td><?=htmlspecialchars($r['updated_at'])?></td>
  <td>
    <a href="view.php?id=<?=urlencode($r['id'])?>">Lihat Decript</a> |
    <a href="edit.php?id=<?=urlencode($r['id'])?>">Edit</a> |
    <a href="delete.php?id=<?=urlencode($r['id'])?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
  </td>
</tr>
<?php endforeach; ?>
</table>
</body>
</html>