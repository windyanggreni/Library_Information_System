<?php
include 'koneksitugas.php';

if($_GET['proses']=='insert') 
{
    if (isset($_POST['submit'])) {
        $nama_prodi = $_POST['nama_prodi'];
        $jurusan_id = $_POST['jurusan_id'];

        $query = "INSERT INTO prodi (nama_prodi, jurusan_id) VALUES (?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param("si", $nama_prodi, $jurusan_id);

        if ($stmt->execute()) {
            header("Location: index.php?page=prodi&aksi=list");
        } else {
            echo "Data Gagal Ditambahkan" . $stmt->error;
        }

        $stmt->close();
    }
}

if($_GET['proses']=='update') 
{
    if (isset($_POST['submit'])) {
        $id_prodi = $_POST['id_prodi'];
        $nama_prodi = $_POST['nama_prodi'];
        $jurusan_id = $_POST['jurusan_id'];

        $query = "UPDATE prodi SET nama_prodi=?, jurusan_id=? WHERE id_prodi=?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("sii", $nama_prodi, $jurusan_id, $id_prodi);

        if ($stmt->execute()) {
            header("Location: index.php?page=prodi&aksi=list");
        } else {
            echo "Data Gagal Diupdate" . $stmt->error;
        }

        $stmt->close();
    }
}



if($_GET['proses']=='delete') 
{
    if (isset($_GET['id_prodi'])) {
        $id_prodi = $_GET['id_prodi'];
        $sql = "DELETE FROM prodi WHERE id_prodi='$id_prodi'";
    
        if ($db->query($sql) == TRUE) {
            header("Location: index.php?page=prodi");
        } else {
            echo "Gagal Update!" . $db->error;
        }
        
    } else {
        echo "id_prodi TIDAK DITEMUKAN!";
    }
}

?>