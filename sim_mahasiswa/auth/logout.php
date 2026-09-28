<?php

session_start();

// Menghapus semua session
session_unset();

// Menghancurkan session
session_destroy();

// Kembali ke halaman login
header("Location: login.php");
exit;

?>