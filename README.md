# xor_php_app
Aplikasi web untuk enkripsi simetris data menggunakan stream XOR yang berbasis php

Panduan Pengguna’an Aplikasi Enkripsi

1.	Import File dump_mysql.sql ke melalui MySQL client/phpMyAdmin untuk membuat database, table, baris dan kolom tabelnya. Sehingga akan muncul tampilan di admin console yang berisi database, table, baris dan kolom:
2.	Buat file config.php untuk menghubungkan dengan database yang telah kita buat beserta key nya:
3.	Jalankan server yang digunakan (Apache server dll). Jika server sudah running, buka web app nya melalui browser dan akses ke linknya melalui http://localhost/xor_php_app/index.php
4.	Untuk menggunakan aplikasinya, pertama kita bisa klik pada “+ Buat Catatan Baru”. Kita bisa mengisikan data yang kita inginkan dan menyimpannya atau membatalkannya.
5.	Jika sudah disimpan maka hasil enkripsinya dapat kita lihat di database kita.
Dan akan muncul data baru pada table. Kita bisa melihat hasil dekripsinya dengan mengklik “Lihat Decript” pada kolom “Aksi” 
6.	Dibawah hasil dekripsi terdapat menu “Edit”, pada menu tersebut fungsinya sama seperti pada menu “Edit” di kolom “Aksi”
7.	Pada menu edit, kita dapat merubah isi teks beserta ciphertextnya.
8.	Data yang telah kita input dapat dihapus dari database dengan menggunakan fitur/menu “Hapus” pada kolom “Aksi”
9.	Ketika kita membuat catatan baru. Maka akan muncul dengan ID yang berbeda dengan sebelumya yang telah kita hapus,
