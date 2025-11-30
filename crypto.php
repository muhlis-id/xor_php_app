<?php
// crypto.php
// Implementasi keystream via SHA256(key || nonce || counter)
// Menghasilkan ciphertext base64 dan menyimpan nonce (binary)

function base64_to_bytes($b64) {
    return base64_decode($b64);
}

function gen_nonce($n = 16) {
    return random_bytes($n);
}

function keystream($key_bytes, $nonce, $length) {
    $out = '';
    $counter = 0;
    while (strlen($out) < $length) {
        // counter 8 bytes big-endian
        $ctr = pack('J', $counter); // PHP 7.0+ pack J = unsigned long long (machine dependent) — safer to use manual
        // pack J might be platform dependent, use 8-byte big-endian:
        $ctr = pack('N2', ($counter >> 32) & 0xFFFFFFFF, $counter & 0xFFFFFFFF);
        $digest = hash('sha256', $key_bytes . $nonce . $ctr, true);
        $out .= $digest;
        $counter++;
    }
    return substr($out, 0, $length);
}

function xor_encrypt($plaintext, $key_b64, $nonce = null) {
    $key = base64_to_bytes($key_b64);
    if ($nonce === null) $nonce = gen_nonce(16);
    $ks = keystream($key, $nonce, strlen($plaintext));
    $ct = $plaintext ^ $ks; // PHP binary string XOR
    return [
        'ciphertext_b64' => base64_encode($ct),
        'nonce' => $nonce // binary
    ];
}

function xor_decrypt($ciphertext_b64, $key_b64, $nonce) {
    $key = base64_to_bytes($key_b64);
    $ct = base64_decode($ciphertext_b64);
    $ks = keystream($key, $nonce, strlen($ct));
    $pt = $ct ^ $ks;
    return $pt;
}