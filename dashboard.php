<?php
$aksi=isset($_GET['aksi']) ? $_GET['aksi'] : 'dashboard';
switch ($aksi) {
    case 'dashboard':
?>
<body>
<!-- INFORMATION -->
<section id="information" class="information" >
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-body visitor">
                            <div class="card-text text-center">
                                <h1>Visitor</h1>
                                <?php
                                $query = "SELECT COUNT(*) as jumlah_kunjungan FROM kunjungan";
                                $result = $db->query($query);
                                if ($result) {
                                    $row = $result->fetch_assoc();
                                    $jumlahKunjungan = $row['jumlah_kunjungan'];
                                    echo "<span>$jumlahKunjungan</span>";                       
                                } else {
                                    echo "Error: " . $db->error;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                <div class="card card-reader">
                    <p class="text-center judul">Top Reader</p>
                        <div class="card-body">
                            <div class="row">
                                <?php
                                // Query to get the top 3 readers based on the number of borrowings
                                $queryTopReaders = "SELECT anggota.nama, anggota.id_member, COUNT(peminjaman.peminjaman_id) AS total_peminjaman
                                                    FROM anggota
                                                    LEFT JOIN peminjaman ON anggota.id_member = peminjaman.id_member
                                                    GROUP BY anggota.id_member
                                                    ORDER BY total_peminjaman DESC
                                                    LIMIT 3";

                                $resultTopReaders = $db->query($queryTopReaders);

                                if ($resultTopReaders) {
                                    while ($rowTopReaders = $resultTopReaders->fetch_assoc()) {
                                        $namaAnggota = $rowTopReaders['nama'];
                                        $id_member = $rowTopReaders['id_member'];
                                        $totalPeminjaman = $rowTopReaders['total_peminjaman'];

                                        echo '<div class="col-4 top-reader">
                                                <div class="top-reader-header text-center">
                                                    <a href=""><h1>' . $namaAnggota . '</h1></a>
                                                    <p>' . $id_member . '</p>
                                                </div>
                                                <div class="top-reader-content text-center">
                                                    <p>' . $totalPeminjaman . ' loans</p>
                                                </div>
                                            </div>';
                                    }
                                } else {
                                    echo "Error fetching top readers: " . $db->error;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>   
            </div>
        </div>  
    </div>
</section>

<!-- CATEGORIES -->
<section id="categories" class="categories">
    <div class="container-fluid">
        <div class="container">
            <div class="featured-services">
                <div class="row">
                    <div class="col-11">
                        <h1>Categories</h1>
                    </div>
                    <div class="col-1 mt-2">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">Show all</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        <div class="icon-box">
                            <a href="index.php?page=buku">              
                                <h4 class="title text-center"><a href="index.php?page=buku&aksi=buku_kategori&category_id=1">Fiksi</a></h4>
                            </a>
                            </div>
                        </div>
                    <div class="col-2">
                        <div class="icon-box">
                            <a href="">
                                <h4 class="title text-center"><a href="index.php?page=buku&aksi=buku_kategori&category_id=2">Romance</a></h4>
                            </a>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="icon-box">
                            <a href="">
                                <h4 class="title text-center"><a href="index.php?page=buku&aksi=buku_kategori&category_id=3">Thriller</a></h4>
                            </a>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="icon-box">
                            <a href="">
                                <h4 class="title text-center"><a href="index.php?page=buku&aksi=buku_kategori&category_id=4">Comedy</a></h4>
                            </a>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="icon-box">
                            <a href="">
                                <h4 class="title text-center"><a href="index.php?page=buku&aksi=buku_kategori&category_id=5">Sejarah</a></h4>
                            </a>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="icon-box">
                            <a href="">
                                <h4 class="title text-center"><a href="index.php?page=buku&aksi=buku_kategori&category_id=6">Agama</a></h4>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--MODAL -->
        <div class="modal fade featured-services" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">                        
                        <div class="col-2">
                        <div class="icon-box">
                            <a href="index.php?page=buku">
                                <h4 class="title text-center"><a href="index.php?page=buku&aksi=buku_kategori&category_id=1">Fiksi</a></h4>
                            </a>
                            </div>
                        </div>
                    <div class="col-2">
                        <div class="icon-box">
                            <a href="">
                                <h4 class="title text-center"><a href="index.php?page=buku&aksi=buku_kategori&category_id=2">Romance</a></h4>
                            </a>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="icon-box">
                            <a href="">
                                <h4 class="title text-center"><a href="index.php?page=buku&aksi=buku_kategori&category_id=3">Thriller</a></h4>
                            </a>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="icon-box">
                            <a href="">
                                <h4 class="title text-center"><a href="index.php?page=buku&aksi=buku_kategori&category_id=4">Comedy</a></h4>
                            </a>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="icon-box">
                            <a href="">
                                <h4 class="title text-center"><a href="index.php?page=buku&aksi=buku_kategori&category_id=5">Sejarah</a></h4>
                            </a>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="icon-box">
                            <a href="">
                                <h4 class="title text-center"><a href="index.php?page=buku&aksi=buku_kategori&category_id=6">Agama</a></h4>
                            </a>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="icon-box">
                            <a href="">
                                <h4 class="title text-center"><a href="index.php?page=buku&aksi=buku_kategori&category_id=7">Bahasa</a></h4>
                            </a>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="icon-box">
                            <a href="">
                                <h4 class="title text-center"><a href="index.php?page=buku&aksi=buku_kategori&category_id=8">Teknologi</a></h4>
                            </a>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="icon-box">
                            <a href="">
                                <h4 class="title text-center"><a href="index.php?page=buku&aksi=buku_kategori&category_id=9">Kesehatan</a></h4>
                            </a>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="icon-box">
                            <a href="">
                                <h4 class="title text-center"><a href="index.php?page=buku&aksi=buku_kategori&category_id=10">Biografi</a></h4>
                            </a>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="icon-box">
                            <a href="">
                                <h4 class="title text-center"><a href="index.php?page=buku&aksi=buku_kategori&category_id=11">Motivasi</a></h4>
                            </a>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- BOOK INFORMATION -->
<section id="books" class="books">
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-11 book-list">
                    <h1>Books</h1>
                </div>
                <div class="col-1 mt-2 sono">
                    <a href="index.php?page=buku"><p>Show all</p></a>
                </div>
            </div>
            <div class="row">
                <?php
                include 'koneksitugas.php';

                $query = "SELECT buku.*, 
                            kategori.nama_kategori, 
                            pengarang.nama_pengarang, 
                            penerbit.nama_penerbit
                            FROM buku 
                            LEFT JOIN kategori ON buku.category_id = kategori.id_kategori 
                            LEFT JOIN pengarang ON buku.pengarang_id = pengarang.id_pengarang
                            LEFT JOIN penerbit ON buku.penerbit_id = penerbit.id_penerbit
                            ORDER BY buku.kode_buku";
                $result = $db->query($query);

                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-2">';
                    echo '<div class="card">';
                    echo '<div class="card-body">';
                    echo '<div class="book-img">';
                    echo '<a href="index.php?page=buku&aksi=sinopsis&id=' . $row['id'] . '"><img src="' . $row['gambar'] . '" class="card-image" alt="..."></a>';
                    echo '</div>';
                    echo '<div class="book-title">';
                    $judul = $row['judul'];
                    echo '<h1>' . (strlen($judul) > 15 ? substr($judul, 0, 13) . '...' : $judul) . '</h1>';
                    echo '<div class="book-writer">';
                    echo '<p>' . $row['nama_pengarang'] . '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                $db->close();
                ?>
            </div>
        </div>
    </div>
</section>

<?php
    break;
    }
?>

</body>
</html>