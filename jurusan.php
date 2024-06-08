<?php
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';
switch ($aksi) {
    case 'list':
?>
        
<h1 class="text-center">List Jurusan</h1>
<table class="table table-striped" id="example">
    <thead>
        <tr>
            <th style="background-color: salmon;">No</th>
            <th style="background-color: salmon;">Jurusan</th>
            <th style="background-color: salmon;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = "SELECT * FROM jurusan";
        $result = $db->query($query);
        $nomor = 1;
        foreach ($result as $row) : ?>
            <tr>
                <td><?= $nomor++ ?></td>
                <td><?= $row['nama_jurusan'] ?></td>
                <td class="action-buttons" style="white-space: nowrap;">
                    <a href="?page=jurusan&aksi=edit&id=<?= $row['id'] ?>" class="btn btn-success">Edit</a>
                    <a onclick="return confirm('Are you sure want to delete?')" href="proses_jurusan.php?proses=delete&id=<?= $row['id'] ?>" class="btn btn-danger" style="margin-right: 10px;">Hapus</a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<?php
if ($_SESSION['level'] == 'admin') {
?>
    <p class="text-center mt-4">Untuk input data silahkan <a href="?page=jurusan&aksi=input" class="btn btn-primary">KLIK DI SINI</a></p>
<?php
}
?>


<?php
    break;
    case 'input':
?>

<h1 class="mb-4">Input Jurusan</h1>
<a href="index.php?page=jurusan&aksi=list" class="btn btn-primary mb-4">List jurusan</a>

<form action="proses_jurusan.php?proses=insert" method="post" enctype="multipart/form-data">
   
    <input type="hidden" name="id" value="<?=$id?>">

    <div class="mb-3 row">
        <label for="nama_jurusan" class="col-sm-2 col-form-label">Nama Jurusan</label>
        <div class="col-sm-10">
            <input type="text" name="nama_jurusan" class="form-control" required>
        </div>
    </div>

    <div class="mb-3 row">
        <div class="col-sm-10 offset-sm-2">
            <input type="submit" name="submit" class="btn btn-success">
        </div>
    </div>
</form>

<?php
    break;
    case 'edit':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $query = "SELECT * FROM jurusan WHERE id='$id'";
            $result = $db->query($query);

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $nama_jurusan =  $row['nama_jurusan'];
            } else {
                echo "Data dengan ID ".$id." Tidak Ditemukan!";
                exit;
            }
        } else {
            echo "Parameter tidak valid!";
            exit;
        }
?>

<h1>Edit jurusan</h1>
<a href="index.php?page=jurusan&aksi=list" class="btn btn-primary">List jurusan</a><br><br>
<form action="proses_jurusan.php?proses=update" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?=$id?>">
    <table class="table table-borderless">
        <tr>
            <td>Id Jurusan</td>
            <td><input type="text" name="id" value="<?=$id?>" class="form-control" readonly required></td>
        </tr>

        <tr>
            <td>Jurusan</td>
            <td><input type="text" name="nama_jurusan" value="<?=$nama_jurusan?>" class="form-control" required></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="submit" class="btn btn-success"></td>
        </tr>
    </table>
</form>

<?php
    break;
}
?>
