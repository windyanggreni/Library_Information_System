<?php
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';

switch ($aksi) {
    case 'list':
?>
<div class="container-fluid">
    <div class="container mb-5">
    <p class="text-end mt-4"><a href="?page=penerbit&aksi=input" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-publisher">Add Publisher</a></p>
        <table class="table table-striped" id="example">
            <thead>
                <tr>
                    <th style="background-color: #FA7C54;">No</th>
                    <th style="background-color: #FA7C54;">Nama Penerbit</th>
                    <th style="background-color: #FA7C54;">Keterangan</th>
                    <th style="background-color: #FA7C54;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM penerbit order by id_penerbit";
                $result = $db->query($query);
                $nomor = 1;
                foreach ($result as $row) : ?>
                    <tr>
                        <td><?= $nomor++ ?></td>
                        <td><?= $row['nama_penerbit'] ?></td>
                        <td><?= $row['keterangan'] ?></td>
                        <td class="action-buttons" style="white-space: nowrap;">

                            <a href="?page=penerbit&aksi=edit&id=<?= $row['id_penerbit'] ?>" class="btn btn-success button-edit" data-bs-target="#edit-publisher<?= $row['id_penerbit'] ?>" data-bs-toggle="modal" ><img src="assets/img/Edit.png" alt="" ></a>

                            <a onclick="return confirm('Are you sure want to delete?')" href="proses_penerbit.php?proses=delete&id=<?= $row['id_penerbit'] ?>" class="btn btn-danger button-delete" style="margin-right: 10px;"><img src="assets/img/Trash.png" alt=""></a>
                        </td>
                        <!-- MODAL EDIT -->
                        <div class="modal fade edit-writer" id="edit-publisher<?= $row['id_penerbit'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-md modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <form action="proses_penerbit.php?proses=update" method="post">
                                            <input type="hidden" name="id_penerbit" value="<?= $row['id_penerbit']?>">
                                            <div class="mb-3 row">
                                                <label for="nama_penerbit" class="col-sm-2 col-form-label">Nama Penerbit</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="nama_penerbit" value="<?= $row['nama_penerbit']?>" class="form-control" required>
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                                                <div class="col-sm-10">
                                                    <textarea name="keterangan" class="form-control" rows="5" required><?= $row['keterangan'] ?></textarea>
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

                        <!-- MODAL INPUT -->
                        <div class="modal fade edit-writer" id="add-publisher" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-md modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <form action="proses_penerbit.php?proses=insert" method="post">
                                            <div class="mb-3 row">
                                                <label for="nama_penerbit" class="col-sm-2 col-form-label">Nama Penerbit</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="nama_penerbit" class="form-control" required>
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                                                <div class="col-sm-10">
                                                    <textarea name="keterangan" class="form-control" rows="5" required></textarea>
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
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<?php
    break;
    case 'input':
?>
    <h1 class="mb-4">Input Penerbit</h1>
    <a href="index.php?page=penerbit&aksi=list" class="btn btn-primary mb-4">List Penerbit</a>

<?php
    break;
    case 'edit':
        if (isset($_GET['id'])) {
            $id_penerbit = $_GET['id'];
            $query = "SELECT * FROM penerbit WHERE id_penerbit='$id_penerbit'";
            $result = $db->query($query);

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $nama_penerbit = $row['nama_penerbit'];
                $keterangan = $row['keterangan'];
            } else {
                echo "Data dengan ID penerbit" . $id_penerbit . " Tidak Ditemukan!";
                exit;
            }
        } else {
            echo "Parameter tidak valid!";
            exit;
        }
?>

    <h1>Edit penerbit</h1>
    <a href="index.php?page=penerbit&aksi=list" class="btn btn-primary">List Penerbit</a><br><br>

<?php
        break;
}
?>
