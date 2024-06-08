<?php
include 'koneksitugas.php';

$tanggal_kunjungan_default = date("Y-m-d");

if ($_GET['proses'] == 'insert') 
{
    if (isset($_POST['submit'])) {
        $id_member = $_POST['id_member'];
        $jurusan_id = $_POST['jurusan_id'];
        $prodi_id = $_POST['prodi_id'];

        $tanggal_kunjungan = $tanggal_kunjungan_default;

        $query = "INSERT INTO kunjungan (id_member, jurusan_id, prodi_id, tanggal_kunjungan) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($query);

        $stmt->bind_param("siis", $id_member, $jurusan_id, $prodi_id, $tanggal_kunjungan);

        if ($stmt->execute()) {
            header("Location: index.php?page=visitor&aksi=list");
        } else {
            echo "Data Gagal Disimpan" . $stmt->error;
        }

        $stmt->close();
    }
}