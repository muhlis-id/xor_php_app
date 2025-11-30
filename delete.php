<?php
// delete.php
require 'db.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("DELETE FROM notes WHERE id = ?");
$stmt->execute([$id]);
header('Location: index.php');
exit;