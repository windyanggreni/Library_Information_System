<?php
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';

switch ($aksi) {
    case 'list':
?>
<div class="container-fluid">
    <div class="container mb-5">
    <p class="text-end mt-4"><a href="?page=pengarang&aksi=input" class="btn btn-primary" data-bs-target="#add-writer" data-bs-toggle="modal">Add writer</a></p>
        <table class="table table-striped" id="example">
            <thead>
                <tr>
                    <th style="background-color: #FA7C54;">No</th>
                    <th style="background-color: #FA7C54;">Nama Pengarang</th>
                    <th style="background-color: #FA7C54;">Keterangan</th>
                    <th style="background-color: #FA7C54;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM pengarang order by id_pengarang";
                $result = $db->query($query);
                $nomor = 1;
                foreach ($result as $row) : ?>
                    <tr>
                        <td><?= $nomor++ ?></td>
                        <td><?= $row['nama_pengarang'] ?></td>
                        <td><?= $row['keterangan'] ?></td>
                        <td class="action-buttons" style="white-space: nowrap;">
                            <a href="?page=pengarang&aksi=edit&id=<?= $row['id_pengarang'] ?>" class="btn btn-success button-edit" data-bs-toggle="modal" data-bs-target="#edit-writer<?= $row['id_pengarang'] ?>" ><img src="assets/img/Edit.png" alt=""></a>

                            <a onclick="return confirm('Are you sure want to delete?')" href="proses_pengarang.php?proses=delete&id=<?= $row['id_pengarang'] ?>" class="btn btn-danger button-delete" style="margin-right: 10px;"><img src="assets/img/Trash.png" alt=""></a>
                        </td>

                        <!-- MODAL EDIT -->
                        <div class="modal fade edit-writer" id="edit-writer<?= $row['id_pengarang'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-md modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <form action="proses_pengarang.php?proses=update" method="post">
                                            <input type="hidden" name="id_pengarang" value="<?= $row['id_pengarang']?>">
                                            <div class="mb-3 row">
                                                <label for="nama_pengarang" class="col-sm-2 col-form-label">Nama Pengarang</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="nama_pengarang" value="<?= $row['nama_pengarang'] ?>" class="form-control" required>
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
                        <div class="modal fade add-writer" id="add-writer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-md modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <form action="proses_pengarang.php?proses=insert" method="post">
                                            <div class="mb-3 row">
                                                <label for="nama_pengarang" class="col-sm-2 col-form-label">Nama Pengarang</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="nama_pengarang" class="form-control" required>
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
        <h1 class="mb-4">Input Pengarang</h1>
        <a href="index.php?page=pengarang&aksi=list" class="btn btn-primary mb-4">List Pengarang</a>

<?php
    break;
    case 'edit':
        if (isset($_GET['id'])) {
            $id_pengarang = $_GET['id'];
            $query = "SELECT * FROM pengarang WHERE id_pengarang='$id_pengarang'";
            $result = $db->query($query);

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $nama_pengarang = $row['nama_pengarang'];
                $keterangan = $row['keterangan'];
            } else {
                echo "Data dengan ID pengarang" . $id_pengarang . " Tidak Ditemukan!";
                exit;
            }
        } else {
            echo "Parameter tidak valid!";
            exit;
        }
?>

        <h1>Edit Pengarang</h1>
        <a href="index.php?page=pengarang&aksi=list" class="btn btn-primary">List Pengarang</a><br><br>

        <form action="proses_pengarang.php?proses=update" method="post">
            <input type="hidden" name="id_pengarang" value="<?= $id_pengarang ?>">
            <div class="mb-3 row">
                <label for="nama_pengarang" class="col-sm-2 col-form-label">Nama Pengarang</label>
                <div class="col-sm-10">
                    <input type="text" name="nama_pengarang" value="<?= $nama_pengarang ?>" class="form-control" required>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                <div class="col-sm-10">
                    <textarea name="keterangan" class="form-control" rows="5" required><?= $keterangan ?></textarea>
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
    }
?>
