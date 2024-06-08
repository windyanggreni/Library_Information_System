<?php
$aksi=isset($_GET['aksi']) ? $_GET['aksi'] : 'list';
switch ($aksi) {
    case 'list':
?>
        
        <h1 class="text-center">List Prodi</h1>
        <table class="table table-bordered table-striped">
            <thead >
                <tr>
                <th style="background-color: salmon;">No</th>
                    <th style="background-color: salmon;">Nama Prodi</th>
                    <th style="background-color: salmon;">Jurusan</th>
                    <th style="background-color: salmon;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php  
                  $query = "SELECT prodi.*, 
                                   jurusan.nama_jurusan
                            FROM prodi
                            JOIN jurusan ON prodi.jurusan_id = jurusan.id      
                            ORDER BY prodi.id_prodi";

                $result = $db->query($query);
                $nomor = 1;
                foreach($result as $row) : ?>
                    <tr>
                        <td><?= $nomor++ ?></td>
                        <td><?= $row['nama_prodi']?></td>
                        <td><?= $row['nama_jurusan']?></td>               
                        <td class="action-buttons">
                            <a href="?page=prodi&aksi=edit&id_prodi=<?=$row['id_prodi']?>" class="btn btn-success">Edit</a>
                            <a onclick="return confirm('Are you sure want to delete?')" 
                            href="proses_prodi.php?proses=delete&id_prodi=<?=$row['id_prodi']?>" class="btn btn-danger">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <p class="text-center mt-4">Untuk input data silahkan <a href="?page=prodi&aksi=input" class="btn btn-primary">KLIK DI SINI</a></p>


<?php
    break;
    case 'input' :
?>

<h1 class="mb-4">Input Prodi</h1>
<a href="index.php?page=prodi" class="btn btn-primary mb-4">List Prodi</a>

<form action="proses_prodi.php?proses=insert" method="post">
    <div class="mb-3">
        <label for="nama_prodi" class="form-label">Nama Prodi</label>
        <input type="text" name="nama_prodi" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="jurusan_id" class="form-label">Jurusan</label>
        <select name="jurusan_id" class="form-select" required>
            <?php
            $query_jurusan = "SELECT * FROM jurusan";
            $result_jurusan = $db->query($query_jurusan);

            foreach ($result_jurusan as $row_jurusan) :
            ?>
                <option value="<?= $row_jurusan['id'] ?>"><?= $row_jurusan['nama_jurusan'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <input type="submit" name="submit" class="btn btn-success">
    </div>
</form>

<?php
    break;
    case 'edit':
        if (isset($_GET['id_prodi'])) {
            $id_prodi = $_GET['id_prodi'];

            // Query untuk mendapatkan data prodi berdasarkan id_prodi
            $query_prodi = "SELECT prodi.*, jurusan.nama_jurusan
                            FROM prodi
                            JOIN jurusan ON prodi.jurusan_id = jurusan.id
                            WHERE prodi.id_prodi = $id_prodi";
                            
            $result_prodi = $db->query($query_prodi);

            if ($result_prodi->num_rows == 1) {
                $row = $result_prodi->fetch_assoc();
                $nama_prodi = $row['nama_prodi'];
                $jurusan_id = $row['jurusan_id'];
            } else {
                echo "Data id_prodi $id_prodi Tidak Ditemukan!";
                exit;
            }
        } else {
            echo "Parameter tidak valid!";
            exit;
        }
?>

<h1>Edit Prodi</h1>
<a href="index.php?page=prodi&aksi=list" class="btn btn-primary">List Prodi</a><br><br>
<form action="proses_prodi.php?proses=update" method="post">
    <input type="hidden" name="id_prodi" value="<?= $id_prodi ?>">

    <table class="table table-borderless">
        <tr>
            <td>Nama Prodi</td>
            <td><input type="text" name="nama_prodi" value="<?= $nama_prodi ?>" class="form-control" required></td>
        </tr>

        <tr>
            <td>Jurusan</td>
            <td>
                <select name="jurusan_id" class="form-control" required>
                    <?php
                    // Query untuk mendapatkan data jurusan
                    $query_jurusan = "SELECT * FROM jurusan";
                    $result_jurusan = $db->query($query_jurusan);

                    foreach ($result_jurusan as $row_jurusan) {
                        $selected = ($row_jurusan['id'] == $jurusan_id) ? 'selected' : '';
                        echo '<option value="' . $row_jurusan['id'] . '" ' . $selected . '>' . $row_jurusan['nama_jurusan'] . '</option>';
                    }
                    ?>
                </select>
            </td>
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

