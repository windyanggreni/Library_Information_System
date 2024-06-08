<?php
include 'koneksitugas.php';


if ($_GET['proses'] == 'insert') {
    if (isset($_POST['submit'])) {
        $kode_buku = $_POST['kode_buku'];
        $judul = $_POST['judul'];
        $category_id = $_POST['category_id'];
        $pengarang_id = $_POST['pengarang_id'];
        $penerbit_id = $_POST['penerbit_id'];
        $total_books = $_POST['total_books'];
        $sinopsis = $_POST['sinopsis'];

        $queryCheckExisting = "SELECT id FROM buku WHERE kode_buku=?";
        $stmtCheckExisting = $db->prepare($queryCheckExisting);
        $stmtCheckExisting->bind_param("s", $kode_buku);
        $stmtCheckExisting->execute();
        $stmtCheckExisting->store_result();

        if ($stmtCheckExisting->num_rows > 0) {
            echo "Kode Buku sudah ada";
            exit; 
        }
        

        // Periksa apakah gambar diupload
        $gambar_path = '';
        if (isset($_FILES['gambar']['tmp_name']) && !empty($_FILES['gambar']['tmp_name'])) {
            $gambar_name = $_FILES['gambar']['name'];
            $gambar_tmp = $_FILES['gambar']['tmp_name'];

            // Sesuaikan folder tempat gambar disimpan
            $folder_path = "images/";

            // Sesuaikan path gambar dengan nama folder dan nama file
            $gambar_path = $folder_path . $gambar_name;

            move_uploaded_file($gambar_tmp, $gambar_path);
        }

        $query = "INSERT INTO buku (kode_buku, judul, category_id, pengarang_id, penerbit_id, total_books, gambar, sinopsis) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($query);

        $stmt->bind_param("ssiiiiss", $kode_buku, $judul, $category_id, $pengarang_id, $penerbit_id, $total_books, $gambar_path, $sinopsis);

        if ($stmt->execute()) {
            header("Location: index.php?page=buku");
        } else {
            echo "Data Gagal Disimpan" . $stmt->error;
        }

        $stmt->close();
    }
}

if ($_GET['proses'] == 'update') {
    if (isset($_POST['submit'])) {
        $id = $_POST['id'];
        $kode_buku = $_POST['kode_buku'];
        $judul = $_POST['judul'];
        $category_id = $_POST['category_id'];
        $pengarang_id = $_POST['pengarang_id'];
        $penerbit_id = $_POST['penerbit_id'];
        $total_books = $_POST['total_books'];
        $sinopsis = $_POST['sinopsis'];

        $gambar_path = '';
        if (isset($_FILES['gambar']['tmp_name']) && !empty($_FILES['gambar']['tmp_name'])) {
            $gambar_name = $_FILES['gambar']['name'];
            $gambar_tmp = $_FILES['gambar']['tmp_name'];
            $folder_path = "images/";
            $gambar_path = $folder_path . $gambar_name;
            
            move_uploaded_file($gambar_tmp, $gambar_path);
        } else {
            // Jika gambar tidak diunggah, gunakan gambar lama dari database
            $queryGetOldImage = "SELECT gambar FROM buku WHERE id=?";
            $stmtGetOldImage = $db->prepare($queryGetOldImage);
            $stmtGetOldImage->bind_param("i", $id);
            $stmtGetOldImage->execute();
            $stmtGetOldImage->store_result();

            $gambarLama = '';
            $stmtGetOldImage->bind_result($gambarLama);
            $stmtGetOldImage->fetch();

            // Set nilai gambar_path dengan gambar lama
            $gambar_path = $gambarLama;

            $stmtGetOldImage->close();
        }

        $query = "UPDATE buku SET kode_buku=?, judul=?, category_id=?, pengarang_id=?, penerbit_id=?, total_books=?, gambar=?, sinopsis=? WHERE id=?";
        $stmt = $db->prepare($query);

        $stmt->bind_param("ssiiiissi", $kode_buku, $judul, $category_id, $pengarang_id, $penerbit_id, $total_books, $gambar_path, $sinopsis, $id);

        if ($stmt->execute()) {
            header("Location: index.php?page=buku");
        } else {
            echo "Data Gagal Diupdate" . $stmt->error;
        }

        $stmt->close();
    }
}



if($_GET['proses']=='delete') 
{
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "DELETE FROM buku WHERE id='$id'";

        if ($db->query($sql) == TRUE) {
            Header("Location: index.php?page=buku");
        } else {
            echo "Gagal Update!" . $db->error;
        }
        
    } else {
        echo "ID TIDAK DITEMUKAN!";
    }
}

?>