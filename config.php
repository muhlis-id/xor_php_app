<?php
// config.php
return [
    'db_host' => '127.0.0.1',
    'db_name' => 'xor_crud_php',
    'db_user' => 'root',
    'db_pass' => '', // password mysql (saat ini masih kosong)
    // KEY SYMMETRIC: harus 32 byte (bisa random). Ex: base64_encode(random_bytes(32)) -> simpan string base64
    'app_key_b64' => 'ZGVtb19rZXlfbXVzdF9iZV9jaGFuZ2VkXzMyMQ=='
];