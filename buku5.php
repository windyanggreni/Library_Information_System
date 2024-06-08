<?php
$aksi=isset($_GET['aksi']) ? $_GET['aksi'] : 'list';
switch ($aksi) {
    case 'list':
?>
<div class="container-fluid">
    <div class="container mt-5 ">
        <!-- <h1 class="text-center">List Mahasiswa</h1> -->
        <table class="table" id="example">
        <thead>
            <tr>
                <!-- <th style="background-color: salmon;">No</th> -->
                <!-- <th style="background-color: salmon;">Kode Buku</th> -->
                <th style="background-color: salmon; width: 10px;">Gambar</th>
                <th style="background-color: salmon; width:207px;">Judul</th>
                <th style="background-color: salmon;">Category</th>
                <th style="background-color: salmon; ">Pengarang</th>
                <th style="background-color: salmon; width:100px;">Penerbit</th>
                <!-- <th style="background-color: salmon;">Total Books</th> -->
                <!-- <th style="background-color: salmon;">Keterangan</th> -->
                <th style="background-color: salmon; width:207px">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $query = "SELECT buku.*, 
                                 kategori.nama_kategori, 
                                 pengarang.nama_pengarang, 
                                 penerbit.nama_penerbit
                            FROM buku 
                            JOIN kategori ON buku.category_id = kategori.id_kategori 
                            JOIN pengarang ON buku.pengarang_id = pengarang.id_pengarang
                            JOIN penerbit ON buku.penerbit_id = penerbit.id_penerbit
                            ORDER BY buku.kode_buku";

                $result = $db->query($query);
                $nomor = 1;
                foreach ($result as $row) : ?>
                <tr>
                        <!-- <td><?= $nomor++ ?></td> -->
                        <!-- <td><?= $row['kode_buku'] ?></td> -->
                        <td><img src="<?= $row['gambar'] ?>" alt="Buku Image" style="width: 60px;"></td>
                        <td><?= $row['judul'] ?></td>
                        <td><?= $row['nama_kategori'] ?></td>
                        <td><?= $row['nama_pengarang'] ?></td>
                        <td><?= $row['nama_penerbit'] ?></td>
                        <!-- <td><?= $row['total_books'] ?></td> -->
                        <td class="action-buttons">
                            <a href="?page=buku&aksi=sinopsis&id=<?= $row['id'] ?>" class="btn btn-warning">Detail</a>
                            <a href="?page=buku&aksi=edit&id=<?= $row['id'] ?>" data-bs-target="" class="btn btn-success">Edit</a>
                            <a href="" data-bs-toggle="modal" data-bs-target="#edit-buku">
                                login
                            </a>
                            <a onclick="return confirm('Are you sure want to delete?')" href="proses_buku.php?proses=delete&id=<?= $row['id'] ?>" class="btn btn-danger" style="margin-right: 10px;">Hapus</a>
                        </td>
                </tr>

                
                    <?php endforeach ?>
                </tbody>
            </table>
            <p class="text-center mt-4">Untuk input data silahkan <a href="?page=buku&aksi=input" class="btn btn-primary">KLIK DI SINI</a></p>
            
    </div>
</div>




<?php
    break;
    case 'input':
        ?>

<div class="container-fluid">
    <div class="container">


<h1 class="mb-4">Input Buku</h1>
<a href="index.php?page=buku&aksi=list" class="btn btn-primary mb-4">List Buku</a>

<form action="proses_buku.php?proses=insert" method="post" enctype="multipart/form-data">
    <div class="mb-3 row">
        <label for="kode_buku" class="col-sm-2 col-form-label">ISBN</label>
        <div class="col-sm-10">
            <input type="text" name="kode_buku" class="form-control" required>
        </div>
    </div>
    
    <div class="mb-3 row">
        <label for="judul" class="col-sm-2 col-form-label">Judul</label>
        <div class="col-sm-10">
            <input type="text" name="judul" class="form-control" required>
        </div>
    </div>

    <div class="mb-3 row">
    <label for="gambar" class="col-sm-2 col-form-label">Gambar</label>
    <div class="col-sm-10">
        <input type="file" name="gambar" accept="image/*" class="form-control-file" required>
    </div>
</div>

<div class="mb-3 row">
    <label for="category_id" class="col-sm-2 col-form-label">Category</label>
    <div class="col-sm-10">
        <select name="category_id" class="form-control" required>
            <?php
            $queryCategory = "SELECT * FROM kategori";
            $resultCategory = $db->query($queryCategory);
            foreach ($resultCategory as $rowCategory) {
                echo '<option value="' . $rowCategory['id_kategori'] . '">' . $rowCategory['nama_kategori'] . '</option>';
            }
            ?>
        </select>
    </div>
        </div>
        
        <div class="mb-3 row">
    <label for="pengarang_id" class="col-sm-2 col-form-label">Pengarang</label>
    <div class="col-sm-10">
        <select name="pengarang_id" class="form-control" required>
            <?php
            $queryPengarang = "SELECT * FROM pengarang";
            $resultPengarang = $db->query($queryPengarang);
            foreach ($resultPengarang as $rowPengarang) {
                echo '<option value="' . $rowPengarang['id_pengarang'] . '">' . $rowPengarang['nama_pengarang'] . '</option>';
            }
            ?>
        </select>
    </div>
    </div>

    <div class="mb-3 row">
        <label for="penerbit_id" class="col-sm-2 col-form-label">Penerbit</label>
        <div class="col-sm-10">
            <select name="penerbit_id" class="form-control" required>
                <?php
            $queryPenerbit = "SELECT * FROM penerbit";
            $resultPenerbit = $db->query($queryPenerbit);
            foreach ($resultPenerbit as $rowPenerbit) {
                echo '<option value="' . $rowPenerbit['id_penerbit'] . '">' . $rowPenerbit['nama_penerbit'] . '</option>';
            }
            ?>
        </select>
    </div>
</div>

<div class="mb-3 row">
    <label for="total_books" class="col-sm-2 col-form-label">Total Books</label>
        <div class="col-sm-10">
            <input type="text" name="total_books" class="form-control" required>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="sinopsis" class="col-sm-2 col-form-label">Sinopsis</label>
        <div class="col-sm-10">
            <textarea name="sinopsis" class="form-control" rows="5"></textarea>
        </div>
    </div>

    <div class="mb-3 row">
        <div class="col-sm-10 offset-sm-2">
            <input type="submit" name="submit" class="btn btn-success">
        </div>
    </div>
</form>
</div>
</div>

<?php
    break;
    case 'edit':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $query = "SELECT buku.*, 
                kategori.nama_kategori, 
                pengarang.nama_pengarang, 
                penerbit.nama_penerbit
            FROM buku 
            JOIN kategori ON buku.category_id = kategori.id_kategori 
            JOIN pengarang ON buku.pengarang_id = pengarang.id_pengarang
            JOIN penerbit ON buku.penerbit_id = penerbit.id_penerbit
            WHERE buku.id = $id
            ORDER BY buku.kode_buku";

$result = $db->query($query);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $kode_buku = $row['kode_buku'];
    $judul = $row['judul'];
    $gambar = $row['gambar'];
    $category_id = $row['category_id'];
    $pengarang_id = $row['pengarang_id'];
    $penerbit_id = $row['penerbit_id'];
    $total_books = $row['total_books'];
    $sinopsis = $row['sinopsis'];
    
} else {
    echo "Data dengan ID ".$id." Tidak Ditemukan!";
    exit;
}
} else {
    echo "Parameter tidak valid!";
    exit;
}
?>

<div class="container-fluid modal fade" id="edit-buku">
    <div class="container mb-5">
<h1>Edit Buku</h1>
<a href="index.php?page=buku&aksi=list" class="btn btn-primary">List Buku</a><br><br>
<form action="proses_buku.php?proses=update" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?=$id?>">
    <table class="table table-borderless">
        <tr>
            <td>ISBN</td>
            <td><input type="text" name="kode_buku" value="<?=$kode_buku?>" readonly class="form-control" required></td>
        </tr>
        
        <tr>
            <td>Judul</td>
            <td><input type="text" name="judul" value="<?=$judul?>" class="form-control" required></td>
        </tr>
        
        <tr>
            <td>Gambar</td>
            <td>
                <input type="file" name="gambar" accept="image/*" class="form-control-file">
                <img src="<?=$gambar?>" alt="Buku Image" style="width: 150px;">
            </td>
        </tr>
        
        <tr>
            <td>Category</td>
    <td>
        <select name="category_id" class="form-control" required>
            <?php
            $queryCategory = "SELECT * FROM kategori";
            $resultCategory = $db->query($queryCategory);
            foreach ($resultCategory as $rowCategory) {
                $selected = ($rowCategory['id_kategori'] == $category_id) ? 'selected' : '';
                echo '<option value="' . $rowCategory['id_kategori'] . '" ' . $selected . '>' . $rowCategory['nama_kategori'] . '</option>';
            }
            ?>
        </select>
    </td>
</tr>


         <tr>
    <td>Pengarang</td>
    <td>
        <select name="pengarang_id" class="form-control" required>
            <?php
            $queryPengarang = "SELECT * FROM pengarang";
            $resultPengarang = $db->query($queryPengarang);
            foreach ($resultPengarang as $rowPengarang) {
                $selected = ($rowPengarang['id_pengarang'] == $pengarang_id) ? 'selected' : '';
                echo '<option value="' . $rowPengarang['id_pengarang'] . '" ' . $selected . '>' . $rowPengarang['nama_pengarang'] . '</option>';
            }
            ?>
        </select>
    </td>
</tr>

<tr>
    <td>Penerbit</td>
    <td>
        <select name="penerbit_id" class="form-control" required>
            <?php
            $queryPenerbit = "SELECT * FROM penerbit";
            $resultPenerbit = $db->query($queryPenerbit);
            foreach ($resultPenerbit as $rowPenerbit) {
                $selected = ($rowPenerbit['id_penerbit'] == $penerbit_id) ? 'selected' : '';
                echo '<option value="' . $rowPenerbit['id_penerbit'] . '" ' . $selected . '>' . $rowPenerbit['nama_penerbit'] . '</option>';
            }
            ?>
        </select>
    </td>
</tr>


<tr>
    <td>Total Books</td>
    <td><input type="text" name="total_books" value="<?=$total_books?>" class="form-control" required></td>
</tr>

<tr>
    <td>Sinopsis</td>
            <td><textarea name="sinopsis" class="form-control" rows="5"><?=$sinopsis?></textarea></td>
        </tr>
        
        <tr>
            <td></td>
            <td><input type="submit" name="submit" class="btn btn-success"></td>
        </tr>
    </table>
</form>
</div>
</div>

<?php
    break;
    case 'sinopsis':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            
            $query = "SELECT buku.*, 
                kategori.nama_kategori, 
                pengarang.nama_pengarang, 
                penerbit.nama_penerbit
            FROM buku 
            JOIN kategori ON buku.category_id = kategori.id_kategori 
            JOIN pengarang ON buku.pengarang_id = pengarang.id_pengarang
            JOIN penerbit ON buku.penerbit_id = penerbit.id_penerbit
            WHERE buku.id = $id
            ORDER BY buku.kode_buku";

$result = $db->query($query);

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $kode_buku = $row['kode_buku'];
                $judul = $row['judul'];
                $gambar = $row['gambar'];
                $category_id = $row['category_id'];
                $pengarang_id = $row['pengarang_id'];
                $penerbit_id = $row['penerbit_id'];
                $total_books = $row['total_books'];
                $sinopsis = $row['sinopsis'];
            } else {
                echo "Data dengan ID " . $id . " Tidak Ditemukan!";
                exit;
            }
        } else {
            echo "Parameter tidak valid!";
            exit;
        }
?>


<div class="container mt-5">
    <h1 class="page-header mb-4">Detail Buku</h1>
    
    <div class="row">
        <div class="col-md-3">
            <img src="<?= $gambar ?>" class="img-fluid" alt="Gambar Buku">
        </div>
        
        <div class="col-md-8">
            <div class="mb-3">
                <h3><?= $judul ?></h3>
            </div>
            
            <div class="mb-3">
                <strong>Category:</strong>
                <p><?= $row['nama_kategori'] ?></p>
            </div>

            <div class="mb-3">
                <strong>Pengarang:</strong>
                <p><?= $row['nama_pengarang'] ?></p>
            </div>
            
            <div class="mb-3">
                <strong>Penerbit:</strong>
                <p><?= $row['nama_penerbit'] ?></p>
            </div>
            
            <div class="mb-3">
                <strong>Total Books:</strong>
                <p><?= $total_books ?></p>
            </div>
            
            <div class="mb-3">
                <strong>Sinopsis:</strong>
                <p><?= $sinopsis ?></p>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="index.php?page=buku&aksi=list" class="btn btn-primary">Kembali</a>
    </div>
</div> 


<?php
    break;
    case 'buku_kategori':
?>

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
    // Include your database connection file
    include 'koneksitugas.php';

    // Ambil parameter category_id dari URL
    $category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';

    // Pastikan category_id tidak kosong
    if (!empty($category_id)) {
        // Fetch data from the database
        $query = "SELECT buku.*, 
                     kategori.nama_kategori, 
                     pengarang.nama_pengarang, 
                     penerbit.nama_penerbit
                 FROM buku 
                 LEFT JOIN kategori ON buku.category_id = kategori.id_kategori 
                 LEFT JOIN pengarang ON buku.pengarang_id = pengarang.id_pengarang
                 LEFT JOIN penerbit ON buku.penerbit_id = penerbit.id_penerbit
                 WHERE buku.category_id = $category_id
                 ORDER BY buku.kode_buku";
        $result = $db->query($query);

        // Loop through the data and display each book
        while ($row = $result->fetch_assoc()) {
            echo '<div class="col-2">';
            echo '<div class="card">';
            echo '<div class="card-body">';
            echo '<div class="book-img">';
            echo '<a href="index.php?page=buku&aksi=sinopsis&id=' . $row['id'] . '"><img src="' . $row['gambar'] . '" class="card-image" alt="..."></a>';
            echo '</div>';
            echo '<div class="book-title">';
            echo '<h1>' . $row['judul'] . '</h1>';
            echo '<div class="book-writer">';
            echo '<p>' . $row['nama_pengarang'] . '</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }

        // Close the database connection
        $db->close();
    } else {
        echo "Category ID is empty.";
    }
?>
            </div>
        </div>
    </div>
</section>

<?php
    
    break;
}
?>

<div class="modal fade login" id="input-buku" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-body">
                    <form action="proses_buku.php?proses=insert" method="post" enctype="multipart/form-data">
    <div class="mb-3 row">
        <label for="kode_buku" class="col-sm-2 col-form-label">ISBN</label>
        <div class="col-sm-10">
            <input type="text" name="kode_buku" class="form-control" required>
        </div>
    </div>
    
    <div class="mb-3 row">
        <label for="judul" class="col-sm-2 col-form-label">Judul</label>
        <div class="col-sm-10">
            <input type="text" name="judul" class="form-control" required>
        </div>
    </div>

    <div class="mb-3 row">
    <label for="gambar" class="col-sm-2 col-form-label">Gambar</label>
    <div class="col-sm-10">
        <input type="file" name="gambar" accept="image/*" class="form-control-file" required>
    </div>
</div>

<div class="mb-3 row">
    <label for="category_id" class="col-sm-2 col-form-label">Category</label>
    <div class="col-sm-10">
        <select name="category_id" class="form-control" required>
            <?php
            $queryCategory = "SELECT * FROM kategori";
            $resultCategory = $db->query($queryCategory);
            foreach ($resultCategory as $rowCategory) {
                echo '<option value="' . $rowCategory['id_kategori'] . '">' . $rowCategory['nama_kategori'] . '</option>';
            }
            ?>
        </select>
    </div>
        </div>
        
        <div class="mb-3 row">
    <label for="pengarang_id" class="col-sm-2 col-form-label">Pengarang</label>
    <div class="col-sm-10">
        <select name="pengarang_id" class="form-control" required>
            <?php
            $queryPengarang = "SELECT * FROM pengarang";
            $resultPengarang = $db->query($queryPengarang);
            foreach ($resultPengarang as $rowPengarang) {
                echo '<option value="' . $rowPengarang['id_pengarang'] . '">' . $rowPengarang['nama_pengarang'] . '</option>';
            }
            ?>
        </select>
    </div>
    </div>

    <div class="mb-3 row">
        <label for="penerbit_id" class="col-sm-2 col-form-label">Penerbit</label>
        <div class="col-sm-10">
            <select name="penerbit_id" class="form-control" required>
                <?php
            $queryPenerbit = "SELECT * FROM penerbit";
            $resultPenerbit = $db->query($queryPenerbit);
            foreach ($resultPenerbit as $rowPenerbit) {
                echo '<option value="' . $rowPenerbit['id_penerbit'] . '">' . $rowPenerbit['nama_penerbit'] . '</option>';
            }
            ?>
        </select>
    </div>
</div>

<div class="mb-3 row">
    <label for="total_books" class="col-sm-2 col-form-label">Total Books</label>
        <div class="col-sm-10">
            <input type="text" name="total_books" class="form-control" required>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="sinopsis" class="col-sm-2 col-form-label">Sinopsis</label>
        <div class="col-sm-10">
            <textarea name="sinopsis" class="form-control" rows="5"></textarea>
        </div>
    </div>

    <div class="mb-3 row">
        <div class="col-sm-10 offset-sm-2">
            <input type="submit" name="submit" class="btn btn-success">
        </div>
    </div>
</form>
                    </div>
                  </div>
                </div>
              </div>

