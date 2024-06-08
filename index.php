<?php

session_start();
require 'koneksitugas.php';

$isUserLoggedIn = isset($_SESSION['login']);
$isAdmin = isset($_SESSION['level']) && $_SESSION['level'] == 'admin';

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Sistem Informasi Perpustakaan PB</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link href='https://fonts.googleapis.com/css?family=Lexend Deca' rel='stylesheet'>

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <style>
    </style>
</head>
<body>
  <div class="sidebar">
    <div class="w3-sidebar w3-bar-block">
       <div class="logos">
        <a href="index.html" class="logo">
          <p> Perpustakaan Politeknik Negeri Padang</p>
          <!-- Menu-menu yang selalu tampil untuk kedua level-->
          <a href="index.php?page=dashboard" class="w3-bar-item w3-button"><img src="assets/img/home.png"width=30px  alt="" class="me-2 mb-1 mt-1">Dashboard</a>
          <a href="index.php?page=buku" class="w3-bar-item w3-button"><img src="assets/img/Bookshelf.png"width=30px  alt="" class="me-2 mb-1">Book List</a>
          <a href="index.php?page=staff" class="w3-bar-item w3-button"><img src="assets/img/Admin.png"width=30px  alt="" class="me-2 mb-1">Staff List</a>

          <a href="index.php?page=visitor&aksi=input" class="w3-bar-item w3-button"><img src="assets/img/Visitor.png"width=30px  alt="" class="me-2">Visitor</a>'

          <?php
          // Menu tambahan khusus jika login sebagai admin
          if ($isUserLoggedIn) {
              echo '<a href="index.php?page=anggota" class="w3-bar-item w3-button"><img src="assets/img/user.png"width=30px  alt="" class="me-2 mb-1">Member</a>';

              echo '<a href="index.php?page=kategori" class="w3-bar-item w3-button"><img src="assets/img/categories.png"width=30px  alt="" class="me-2 mb-1">Categories</a>';

              echo '<a href="index.php?page=pengarang" class="w3-bar-item w3-button"><img src="assets/img/Writer.png"width=30px  alt="" class="me-2 mb-1">Pengarang</a>';  

              echo '<a href="index.php?page=penerbit" class="w3-bar-item w3-button"><img src="assets/img/home.png"width=30px  alt="" class="me-2 mb-1">Penerbit</a>';

              echo '<a href="index.php?page=peminjaman" class="w3-bar-item w3-button"><img src="assets/img/home.png"width=30px  alt="" class="me-2 mb-1">Peminjaman</a>';
          }
          ?>
      </div>
  </div>
</div>

<div style="margin-left:15%;">
  <nav class="navbar">
    <form class="container-fluid">
      <div class="input-group mx-4 my-3">
        <input type="text" class="form-control rounded-pill border-warning" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1">
          <span class="input-group-text rounded-pill ms-5 border border-warning" id="dateDisplay"></span>
          <span class="input-group-text rounded-pill border border-warning ms-5" id="current-time"></span>
          <span class="input-group-text rounded-pill border border-warning ms-5" >
          <?php
            if ($isUserLoggedIn) {
                echo '<div class="user-info">';
                echo 'Logged in as ' . $_SESSION['email'];

                // Tambahkan informasi admin
                if ($isAdmin) {
                    echo ' (Admin)';
                    // Tampilkan foto admin jika tersedia
                if(isset($_SESSION['foto'])) {
                  echo '<img src="' . $_SESSION['foto'] . '" class="rounded-circle" width="20px" height="20px" alt="Admin Photo">';
              }
                }
            echo '</div>';
            echo '<a href="logout.php" class="ms-2">Logout</a>';
            }
          ?>
          </span>
            <a href="login.php">
              <span class="input-group-text rounded-pill border-warning ms-5" id="basic-addon1">   
                <img src="assets/img/user.png" class="rounded-circle" width="20px" height="20px" alt="">
              </span>
            </a>
             
      <script>
          document.getElementById('loginBtn').addEventListener('click', function () {
              var email = document.getElementById('emailInput').value;
              var password = document.getElementById('passwordInput').value;

              // Create a FormData object to send data as a POST request
              var formData = new FormData();
              formData.append('email', email);
              formData.append('password', password);

              // Send login credentials to the server using fetch API
              fetch('login.php', {
                  method: 'POST',
                  body: formData
              })
              .then(response => response.json())
              .then(data => {
                  if (data.success) {
                      // If login is successful, redirect to admin page
                      window.location.href = 'admin_dashboard.php';
                  } else {
                      // If login fails, show an alert
                      alert('Login failed. Please check your credentials.');
                  }
              })
              .catch(error => {
                  console.error('Error during login:', error);
                  alert('An error occurred during login.');
              });
          });
      </script>
    </div>
  </form>
</nav>

<div class="container" background-color: salmon;>
      <?php
        $p=isset($_GET['page']) ? $_GET['page'] : 'dashboard'; //ternary
        if ($p=='dashboard') include 'dashboard.php';
        if ($p=='visitor') include 'visitor.php';
        if ($p=='buku') include 'buku.php';
        if ($p=='anggota') include 'anggota.php';
        if ($p=='kategori') include 'kategori.php';
        if ($p=='peminjaman') include 'peminjaman.php';
        if ($p=='staff') include 'staff.php';
        if ($p=='pengarang') include 'pengarang.php';
        if ($p=='penerbit') include 'penerbit.php';
        if ($p=='jurusan') include 'jurusan.php';
        if ($p=='prodi') include 'prodi.php';
      ?>  
  </div>
</div>

<script>
    function updateDateAndTime() {
      const dateElement = document.getElementById('dateDisplay');
      const currentDate = new Date();
      const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric', timeZoneName: 'short' };
      const formattedDate = currentDate.toLocaleDateString('id-ID', '00-00-000');
      dateElement.textContent = formattedDate;
    }

    // Panggil fungsi updateDateAndTime setiap detik (1000 milidetik)
    setInterval(updateDateAndTime, 1000);

    // Panggil fungsi untuk menampilkan tanggal dan jam saat halaman dimuat
    updateDateAndTime();

      // Fungsi untuk mendapatkan waktu saat ini dengan format hh:mm:ss
      function getCurrentTime() {
      var date = new Date();
      var hours = date.getHours();
      var minutes = date.getMinutes();
      var seconds = date.getSeconds();
                          
      // Tambahkan nol di depan angka jika hanya satu digit
      hours = (hours < 10) ? "0" + hours : hours;
      minutes = (minutes < 10) ? "0" + minutes : minutes;
      seconds = (seconds < 10) ? "0" + seconds : seconds;
                          
      return hours + ":" + minutes + ":" + seconds;
      }
                          
      // Fungsi untuk mengupdate waktu setiap detik
      function updateClock() {
      var timeElement = document.getElementById("current-time");
        if (timeElement) {
            timeElement.innerHTML = getCurrentTime();
        }
      }
                          
      // Memperbarui waktu setiap detik
      setInterval(updateClock, 1000);
      </script>
        <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
        <script src="assets/vendor/aos/aos.js"></script>
        <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
        <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
        <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
        <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
        <script src="assets/vendor/php-email-form/validate.js"></script>


      <!-- Template Main JS File -->
      <script src="assets/js/main.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script src="bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
        <script>
          new DataTable('#example');
      </script>
</body>
</html>
