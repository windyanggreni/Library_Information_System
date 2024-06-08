<?php
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';
switch ($aksi) {
    case 'list':
?>

<div class="modal fade add-staff" id="add-staff" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center">
                <p class="text-center">Add Staff</p>
            </div>
            <div class="modal-body ">
                <form action="proses_staff.php?proses=insert" method="post" enctype="multipart/form-data">
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" name="email" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="foto" class="col-sm-2 col-form-label">Foto</label>
                        <div class="col-sm-10">
                            <input type="file" name="foto" accept="image/*" class="form-control-file" required>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" name="password" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="level" class="col-sm-2 col-form-label">Status Staff</label>
                        <div class="col-sm-10">
                            <select name="level" class="form-control" required>
                                <option value="Admin">Admin</option>
                                <option value="Pustakawan">Pustakawan</option>
                            </select>
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

<div class="container-fluid">
    <div class="container staff-list">
        <p class="text-end mt-4"><a href="?page=staff&aksi=input" class="btn btn-primary" data-bs-toggle="modal"  data-bs-target="#add-staff">Add Staff</a></p>
            <table class="table table-striped" id="example">
                <thead>
                    <tr>
                        <th style="background-color: #FA7C54;">No</th>
                        <th style="background-color: #FA7C54;">Foto</th>
                        <th style="background-color: #FA7C54;">Nama Staff</th>
                        <!-- <th style="background-color: #FA7C54;">Email</th> -->
                        <th style="background-color: #FA7C54;">Status Staff</th>
                        <?php if ($isUserLoggedIn && $isAdmin) : ?>
                        <th style="background-color: #FA7C54;">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
            <tbody>

            <?php
                $query = "SELECT * FROM staff";
                $result = $db->query($query);
                $nomor = 1;
                foreach ($result as $row) : ?>
                <tr>
                    <td><?= $nomor++ ?></td>
                    <td><img src="<?= $row['foto'] ?>" alt="Foto Staff" style="width: 80px;"></td>
                    <td><?= $row['nama'] ?></td>
                    <td><?= $row['level'] ?></td>

                    <?php if ($isUserLoggedIn && $isAdmin) : ?>
                    <td class="action-buttons" style="white-space: nowrap;">
                        <a href="?page=staff&aksi=edit&id=<?= $row['id'] ?>" class="btn btn-success button-edit" data-bs-toggle="modal" data-bs-target="#edit-staff<?= $row['id'] ?>"><img src="assets/img/Edit.png" alt=""></a>
                        <a onclick="return confirm('Are you sure want to delete?')" href="proses_staff.php?proses=delete&id=<?= $row['id'] ?>" class="btn btn-danger button-delete" style="margin-right: 10px;"><img src="assets/img/Trash.png" alt=""></a>
                    <?php endif; ?>
                    <div class="modal fade edit-staff" id="edit-staff<?= $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header text-center">
                                    <p class="text-center">Edit Staff</p>
                                </div>
                                <div class="modal-body">
                                    <form action="proses_staff.php?proses=update" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="<?=$row['id']?>">
                                        <label>Nama</label>
                                        <input type="text" name="nama" value="<?=$row['nama']?>"class="form-control" required>

                                        <label>Email</label>
                                        <input type="text" name="email" value="<?=$row['email']?>" class="form-control" required>

                                        <label>Foto</label>
                                        <input type="file" name="foto" accept="image/*" class="form-control-file">
                                        
                                        <br>
                                        <img src="<?=$row['foto']?>" alt="Foto Staff" style="width: 150px;" class="mt-2 mb-2">

                                        <br>
                                        <label for="">Password</label>
                                        <input type="password" name="password" value="<?=$row['password']?>" class="form-control" required>

                                        <label for="">Status Staff</label>

                                        <select name="level" class="form-control" required>
                                            <option value="Admin" <?= ($row['level'] == 'Admin') ? 'selected' : '' ?>>Admin</option>
                                            <option value="Pustakawan" <?= ($row['level'] == 'Pustakawan') ? 'selected' : '' ?>>Pustakawan</option>
                                        </select>

                                        <input type="submit" name="submit" class="btn btn-success"></td>
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

<h1 class="mb-4">Input Staff</h1>
    <a href="index.php?page=staff&aksi=list" class="btn btn-primary mb-4">List Staff</a>
        <div class="modal fade edit-staff" id="add-staff" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <p class="text-center">Edit Staff</p>
                    </div>
                <div class="modal-body">
                    <form action="proses_staff.php?proses=insert" method="post" enctype="multipart/form-data">
                        <div class="mb-3 row">
                            <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" name="nama" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="text" name="email" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="foto" class="col-sm-2 col-form-label">Foto</label>
                            <div class="col-sm-10">
                                <input type="file" name="foto" accept="image/*" class="form-control-file" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="password" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" name="password" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="level" class="col-sm-2 col-form-label">Status Staff</label>
                            <div class="col-sm-10">
                                <select name="level" class="form-control" required>
                                    <option value="Admin">Admin</option>
                                    <option value="Pustakawan">Pustakawan</option>
                                </select>
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

<?php
    break;
    case 'edit':

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $query = "SELECT * FROM staff WHERE id='$id'";
            $result = $db->query($query);

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $nama = $row['nama'];
                $email = $row['email'];
                $password =  $row['password'];
                $level = $row['level'];
                $foto = $row['foto'];

            } else {
                echo "Data dengan ID ".$id." Tidak Ditemukan!";
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


