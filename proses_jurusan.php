<?php
include 'koneksitugas.php';
if ($_GET['proses'] == 'insert') {
    if (isset($_POST['submit'])) {
        
        $nama_jurusan = $_POST['nama_jurusan'];
    
        $query = "INSERT INTO jurusan (nama_jurusan) VALUES (?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $nama_jurusan);

        if ($stmt->execute()) {
            header("Location: index.php?page=jurusan&aksi=list");
        } else {
            echo "Data Gagal Disimpan" . $stmt->error;
        }

        $stmt->close();
    }
}

if ($_GET['proses'] == 'update') {
    if (isset($_POST['submit'])) {
        $id = $_POST['id'];
        $nama_jurusan = $_POST['nama_jurusan'];

        $query = "UPDATE jurusan SET nama_jurusan=? WHERE id=?";
        $stmt = $db->prepare($query);

        $stmt->bind_param("si", $nama_jurusan, $id);

        if ($stmt->execute()) {
            header("Location: index.php?page=jurusan");
        } else {
            echo "Data Gagal Diupdate: " . $stmt->error;
        }

        $stmt->close();
    }
}


if ($_GET['proses'] == 'delete') 
{
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "DELETE FROM jurusan WHERE id='$id'";

        if ($db->query($sql) == TRUE) {
            Header("Location: index.php?page=jurusan");
        } else {
            echo "Gagal Update!" . $db->error;
        }
    } else {
        echo "ID TIDAK DITEMUKAN!";
    }
}
?>
