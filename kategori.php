<?php
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';

switch ($aksi) {
    case 'list':
?>
<div class="container-fluid">
    <div class="container mb-5 list-category">
    <p class="text-end mt-4"><a href="#" data-bs-toggle="modal" data-bs-target="#add-category" class="btn btn-primary">Add Category</a></p>
        <table class="table table-striped" id="example">
            <thead>
                <tr>
                    <th style="background-color: #FA7C54;">No</th>
                    <th style="background-color: #FA7C54;">Nama Kategori</th>
                    <th style="background-color: #FA7C54;">Keterangan</th>
                    <th style="background-color: #FA7C54;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM kategori order by id_kategori";
                $result = $db->query($query);
                $nomor = 1;
                foreach ($result as $row) : ?>
                    <tr>
                        <td><?= $nomor++ ?></td>
                        <td><?= $row['nama_kategori'] ?></td>
                        <td><?= $row['keterangan'] ?></td>
                        <td class="action-buttons" style="white-space: nowrap;">
                            <a href="#" class="btn btn-success button-edit" data-bs-toggle="modal" data-bs-target="#edit-category<?= $row['id_kategori'] ?>" ><img src="assets/img/Edit.png" alt=""></a>
                            <a onclick="return confirm('Are you sure want to delete?')" href="proses_kategori.php?proses=delete&id=<?= $row['id_kategori'] ?>" class="btn btn-danger button-delete" style="margin-right: 10px;"><img src="assets/img/Trash.png" alt=""></a>
                        </td>
                        <div class="modal fade login" id="edit-category<?= $row['id_kategori'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-md modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <form action="proses_kategori.php?proses=update" method="post">
                                            <input type="hidden" name="id_kategori" value="<?= $row['id_kategori'] ?>">
                                                <div class="mb-3 row">
                                                    <label for="nama_kategori" class="col-sm-2 col-form-label">Nama Kategori</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="nama_kategori" value="<?= $row['nama_kategori'] ?>" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                                                    <div class="col-sm-10">
                                                        <textarea name="keterangan" class="form-control" rows="5" required><?= $row['keterangan'] ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="mb-3 row">
                                                    <div class="col-sm-10 offset-sm-2">
                                                        <input type="submit" name="submit" class="btn btn-submit">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade login" id="add-category" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-md modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <form action="proses_kategori.php?proses=insert" method="post">
                                                <div class="mb-3 row">
                                                    <label for="nama_kategori" class="col-sm-2 col-form-label">Nama Kategori</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="nama_kategori" class="form-control" required>
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
    <h1 class="mb-4">Input Kategori</h1>

    <?php
            break;
        case 'edit':
            if (isset($_GET['id'])) {
                $id_kategori = $_GET['id'];
                $query = "SELECT * FROM kategori WHERE id_kategori='$id_kategori'";
                $result = $db->query($query);

                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();
                    $nama_kategori = $row['nama_kategori'];
                    $keterangan = $row['keterangan'];
                } else {
                    echo "Data dengan ID Kategori " . $id_kategori . " Tidak Ditemukan!";
                    exit;
                }
            } else {
                echo "Parameter tidak valid!";
                exit;
            }
    ?>

<?php
    break;
    }
?>
