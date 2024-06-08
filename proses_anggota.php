<?php
include 'koneksitugas.php';

$tanggal_daftar_default = date("Y-m-d");

if ($_GET['proses'] == 'insert') {
    if (isset($_POST['submit'])) {
        $id_member = $_POST['id_member'];
        $nama_mhs = $_POST['nama_mhs'];
        $jurusan_id = $_POST['jurusan_id'];
        $prodi_id = $_POST['prodi_id'];
        $tanggal_lahir = $_POST['tahun_lahir'] . '-' . $_POST['bulan_lahir'] . '-' . $_POST['tanggal_lahir'];
        $tanggal_daftar = $tanggal_daftar_default;
        $email = $_POST['email'];
        $no_hp = $_POST['no_hp'];

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

        $alamat = $_POST['alamat'];
        $status_keanggotaan = $_POST['status_keanggotaan'];

        $queryCheckExisting = "SELECT id FROM anggota WHERE id_member=?";
        $stmtCheckExisting = $db->prepare($queryCheckExisting);
        $stmtCheckExisting->bind_param("s", $id_member);
        $stmtCheckExisting->execute();
        $stmtCheckExisting->store_result();

        if ($stmtCheckExisting->num_rows > 0) {
            echo "Maaf, ID Member sudah terdaftar.";
            exit;
        }

        $query = "INSERT INTO anggota (id_member, nama, jurusan_id, prodi_id, tanggal_lahir, tanggal_daftar, email, no_hp, foto, alamat, status_keanggotaan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($query);

        $stmt->bind_param("ssiisssssss", $id_member, $nama_mhs, $jurusan_id, $prodi_id, $tanggal_lahir, $tanggal_daftar, $email, $no_hp, $foto_path, $alamat, $status_keanggotaan);

        if ($stmt->execute()) {
            header("Location: index.php?page=anggota&aksi=list");
        } else {
            echo "Data Gagal Disimpan" . $stmt->error;
        }
        
        $stmt->close();
    }
}

if ($_GET['proses'] == 'update') {
    if (isset($_POST['submit'])) {
        $id = $_POST['id'];
        $id_member = $_POST['id_member'];
        $nama = $_POST['nama'];
        $jurusan_id = $_POST['jurusan_id'];
        $prodi_id = $_POST['prodi_id'];
        $tanggal_lahir = $_POST['tahun_lahir'] . '-' . $_POST['bulan_lahir'] . '-' . $_POST['tanggal_lahir'];
        $tanggal_daftar = $_POST['tahun_daftar'] . '-' . $_POST['bulan_daftar'] . '-' . $_POST['tanggal_daftar'];
        $email = $_POST['email'];
        $no_hp = $_POST['no_hp'];
        $alamat = $_POST['alamat'];
        $status_keanggotaan = $_POST['status_keanggotaan'];

        $foto_path = '';
        if (isset($_FILES['foto']['tmp_name']) && !empty($_FILES['foto']['tmp_name'])) {
            $foto_name = $_FILES['foto']['name'];
            $foto_tmp = $_FILES['foto']['tmp_name'];
            $folder_path = "images/";
            $foto_path = $folder_path . $foto_name;

            move_uploaded_file($foto_tmp, $foto_path);
        } else {
            // Jika foto tidak diunggah, gunakan foto lama dari database
            $queryGetOldPhoto = "SELECT foto FROM anggota WHERE id=?";
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

        $query = "UPDATE anggota SET id_member=?, nama=?, jurusan_id=?, prodi_id=?, tanggal_lahir=?, tanggal_daftar=?, email=?, no_hp=?, foto=?, alamat=?, status_keanggotaan=? WHERE id=?";
        $stmt = $db->prepare($query);

        $stmt->bind_param("ssiisssssssi", $id_member, $nama, $jurusan_id, $prodi_id, $tanggal_lahir, $tanggal_daftar, $email, $no_hp, $foto_path, $alamat, $status_keanggotaan, $id);

        if ($stmt->execute()) {
            header("Location: index.php?page=anggota");
        } else {
            echo "Data Gagal Diupdate" . $stmt->error;
        }

        $stmt->close();
    }
}

if ($_GET['proses'] == 'delete') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "DELETE FROM anggota WHERE id='$id'";

        if ($db->query($sql) == TRUE) {
            Header("Location: index.php?page=anggota");
        } else {
            echo "Gagal Update!" . $db->error;
        }
    } else {
        echo "ID TIDAK DITEMUKAN!";
    }
}
?>