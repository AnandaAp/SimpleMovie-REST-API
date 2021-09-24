<?php
    //using XAMPP
    $hostname = "localhost";
    $database = "ilist";
    $username = "root";
    $password = "";
    $connect = mysqli_connect($hostname, $username, $password, $database);
    // script cek koneksi   
    if (!$connect) {
        die("Koneksi Tidak Berhasil: " . mysqli_connect_error());
    }

    //using MAMP
    // $user = 'root';
    // $password = 'root';
    // $db = 'ilist';
    // $host = 'localhost';
    // $port = 3306;

    // $link = mysqli_init();
    // $success = mysqli_real_connect(
    //     $link,
    //     $host,
    //     $user,
    //     $password,
    //     $db,
    //     $port
    // );
    // if (!$success) {
    //     die("Koneksi Tidak Berhasil: " . mysqli_connect_error());
    // }
?>