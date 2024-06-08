<?php
include 'koneksitugas.php';

if ($_GET['proses'] == 'insert') {
    if (isset($_POST['submit'])) {
        $nama = $_POST['nama'];
        $email = $_POST['email'];
     
        $password = $_POST['password'];
        $level = $_POST['level'];

    // Periksa apakah gambar diupload
    $foto_path = '';
    if (isset($_FILES['foto']['tmp_name']) && !empty($_FILES['foto']['tmp_name'])) {
        $foto_name = $_FILES['foto']['name'];
        $foto_tmp = $_FILES['foto']['tmp_name'];

        // Sesuaikan folder tempat foto disimpan
        $folder_path = "images/";

        // Sesuaikan path foto dengan nama folder dan nama file
        $foto_path = $folder_path . $foto_name;

        move_uploaded_file($foto_tmp, $foto_path);
 }


 $query = "INSERT INTO staff (nama, email, foto, password, level) VALUES (?, ?, ?, ?, ?)";
        $stmt = $db->prepare($query);

        $stmt->bind_param("sssss", $nama, $email, $foto_path, $password, $level);

        if ($stmt->execute()) {
            header("Location: index.php?page=staff&aksi=list");
        } else {
            echo "Data Gagal Disimpan" . $stmt->error;
        }
 }

 $stmt->close();
}


if ($_GET['proses'] == 'update') {
    if (isset($_POST['submit'])) {
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $email = $_POST['email'];

        $password = $_POST['password'];
        $level = $_POST['level'];

         $foto_path = '';
         if (isset($_FILES['foto']['tmp_name']) && !empty($_FILES['foto']['tmp_name'])) {
             $foto_name = $_FILES['foto']['name'];
             $foto_tmp = $_FILES['foto']['tmp_name'];
 
             $folder_path = "images/";

             $foto_path = $folder_path . $foto_name;
 
             move_uploaded_file($foto_tmp, $foto_path);
         } else {
             // Jika foto tidak diunggah, gunakan foto lama dari database
             $queryGetOldPhoto = "SELECT foto FROM staff WHERE id=?";
             $stmtGetOldPhoto = $db->prepare($queryGetOldPhoto);
             $stmtGetOldPhoto->bind_param("i", $id);
             $stmtGetOldPhoto->execute();
             $stmtGetOldPhoto->store_result();
 
             $fotoLama = '';
             $stmtGetOldPhoto->bind_result($fotoLama);
             $stmtGetOldPhoto->fetch();
 
             // Set nilai foto_path dengan foto lama
             $foto_path = $fotoLama;
 
             $stmtGetOldPhoto->close();
         }

        $query = "UPDATE staff SET nama=?, email=?, foto=?, password=?, level=? WHERE id=?";
        $stmt = $db->prepare($query);

        $stmt->bind_param("sssssi", $nama, $email, $foto_path, $password, $level, $id);

        if ($stmt->execute()) {
            header("Location: index.php?page=staff");
        } else {
            echo "Data Gagal Diupdate" . $stmt->error;
        }

        $stmt->close();
    }
}

if ($_GET['proses'] == 'delete') 
{
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "DELETE FROM staff WHERE id='$id'";

        if ($db->query($sql) == TRUE) {
            header("Location: index.php?page=staff");
        } else {
            echo "Gagal Update!" . $db->error;
        }
    } else {
        echo "ID TIDAK DITEMUKAN!";
    }
}
?>
