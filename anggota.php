<?php
    $aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';
    switch ($aksi) {
    case 'list':
?>
 

 <div class="container-sm">
    <div class="container list-member">
        <div class="container-fluid">
            <div class="container mt-5 text-end">
                <?php if ($isUserLoggedIn && $isAdmin) : ?>
                    <a href="" data-bs-toggle="modal" data-bs-target="#input-anggota" class="btn btn-primary mb-4">Add Member</a>
                <?php endif; ?>
                <div class="modal fade login" id="input-anggota" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <form action="proses_anggota.php?proses=insert" method="post" enctype="multipart/form-data">
                                    <h2>Input Anggota</h2>
                                    <div class="mb-3 row">
                                        <label for="kode_buku" class="col-sm-2 col-form-label">ID Member</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="id_member" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="nama_mhs" class="col-sm-2 col-form-label">Nama</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="nama_mhs" class="form-control" required>
                                        </div>
                                    </div>
    
                                    <div class="mb-3 row">
                                        <label for="jurusan" class="col-sm-2 col-form-label">Jurusan</label>
                                        <div class="col-sm-10">
                                            <select id="jurusan" name="jurusan_id" class="form-control" required>
                                            <option value="" disabled selected>- Pilih Jurusan -</option>
                                                 <?php
                                                 $query_jurusan = "SELECT * FROM jurusan";
                                                 $result_jurusan = $db->query($query_jurusan);
                                                    while ($row_jurusan = $result_jurusan->fetch_assoc()) {
                                                        echo '<option value="' . $row_jurusan['id'] . '">' . $row_jurusan['nama_jurusan'] . '</option>';
                                                    }
                                                 ?>
                                                </select>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="prodi" class="col-sm-2 col-form-label">Prodi</label>
                                        <div class="col-sm-10">
                                            <select id="prodi" name="prodi_id" class="form-control" required>
                                                <!-- Opsi Prodi akan ditambahkan menggunakan JavaScript -->
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="tgl" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                                        <div class="col-sm-2">
                                            <select name="tanggal_lahir" class="form-control" required>
                                            <option value="" disabled selected>-DD-</option>
                                                <?php for ($i = 1; $i <= 31; $i++) : ?>
                                                    <option value="<?= $i ?>"><?= $i ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <select name="bulan_lahir" class="form-control" required>
                                            <option value="" disabled selected>-MM-</option>
                                                <?php for ($i = 1; $i <= 12; $i++) : ?>
                                                    <option value="<?= $i ?>"><?= date('F', mktime(0, 0, 0, $i, 1)) ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <select name="tahun_lahir" class="form-control" required>
                                            <option value="" disabled selected>-YYYY-</option>
                                                <?php for ($i = date('Y'); $i >= date('Y') - 50; $i--) : ?>
                                                    <option value="<?= $i ?>"><?= $i ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <?php
                                        $tanggal_daftar_default = date('Y-m-d');
                                    ?>

                                    <div class="mb-3 row">
                                        <label for="tgl" class="col-sm-2 col-form-label">Tanggal Pendaftaran</label>
                                        <div class="col-sm-2">
                                             <input type="text" name="tanggal_daftar" class="form-control" value="<?= date('d', strtotime($tanggal_daftar_default)) ?>" readonly>
                                        </div>
                                        <div class="col-sm-2">
                                             <input type="text" name="bulan_daftar" class="form-control" value="<?= date('m', strtotime($tanggal_daftar_default)) ?>" readonly>
                                        </div>
                                        <div class="col-sm-2">
                                             <input type="text" name="tahun_daftar" class="form-control" value="<?= date('Y', strtotime($tanggal_daftar_default)) ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" name="email" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="no_hp" class="col-sm-2 col-form-label">No HP</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="no_hp" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="foto" class="col-sm-2 col-form-label">Foto</label>
                                        <div class="col-sm-10">
                                            <input type="file" name="foto" accept="image/*" class="form-control-file" required>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                                        <div class="col-sm-10">
                                            <textarea name="alamat" class="form-control" rows="5" required></textarea>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="status_keanggotaan" class="col-sm-2 col-form-label">Status Keanggotaan</label>
                                        <div class="col-sm-10">
                                            <select name="status_keanggotaan" class="form-control" required>
                                                <option value="Mahasiswa">Mahasiswa</option>
                                                <option value="Tendik">Tendik</option>
                                                <option value="Dosen">Dosen</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <div class="col-sm-10 offset-sm-2">
                                            <input type="submit" name="submit" class="btn btn-success">
                                        </div>
                                    </div>
                                </form>

                                <script>
                                    document.addEventListener("DOMContentLoaded", function () {
                                        loadProdiOptions();

                                        document.getElementById("jurusan").addEventListener("change", function () {
                                            loadProdiOptions();
                                        });
                                    });

                                    function loadProdiOptions() {
                                        var jurusanDropdown = document.getElementById("jurusan");
                                        var selectedJurusanId = jurusanDropdown.options[jurusanDropdown.selectedIndex].value;

                                        var prodiDropdown = document.getElementById("prodi");

                                        prodiDropdown.innerHTML = '';

                                        var defaultOption = document.createElement('option');
                                        defaultOption.value = '';
  
                                        <?php
                                        // Mengambil daftar Prodi berdasarkan Jurusan
                                        $query_prodi_options = "SELECT * FROM prodi";
                                        $result_prodi_options = $db->query($query_prodi_options);

                                        while ($row_prodi_options = $result_prodi_options->fetch_assoc()) {
                                            echo "if (selectedJurusanId === '" . $row_prodi_options['jurusan_id'] . "') {";
                                            echo "var option = document.createElement('option');";
                                            echo "option.value = '" . $row_prodi_options['id_prodi'] . "';";
                                            echo "option.text = '" . $row_prodi_options['nama_prodi'] . "';";
                                            echo "prodiDropdown.appendChild(option);";
                                            echo "}";
                                        }
                                        ?>
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                </div>

                <table class="table table-striped" id="example">
                    <thead>
                        <tr>
                            <th style="background-color: salmon;">ID Member</th>
                            <th style="background-color: salmon;">Nama</th>
                            <th style="background-color: salmon;">Jurusan</th>
                            <th style="background-color: salmon;">Tanggal Lahir</th>
                            <th style="background-color: salmon;">No HP</th>
                            <th style="background-color: salmon;">Foto</th>
                            <th style="background-color: salmon;">Status Keanggotaan</th>
                            <th style="background-color: salmon;">Aksi</th>
                        </tr>
                    </thead>
                <tbody>
                    <?php
                        $query = "SELECT anggota.*, jurusan.nama_jurusan, prodi.nama_prodi
                                  FROM anggota
                                  JOIN jurusan ON anggota.jurusan_id = jurusan.id
                                  JOIN prodi ON anggota.prodi_id = prodi.id_prodi";

                        $result = $db->query($query);
                        $nomor = 1;
                        foreach ($result as $row) : ?>
                        <tr>
                            <td><?= $row['id_member'] ?></td>
                            <td><?= $row['nama'] ?></td>
                            <td><?= $row['nama_jurusan'] ?></td>
                            <td><?= $row['tanggal_lahir'] ?></td>
                            <td><?= $row['no_hp'] ?></td>
                            <td><img src="<?= $row['foto'] ?>" alt="Foto Mahasiswa" style="width: 60px;"></td>
                            <td><?= $row['status_keanggotaan'] ?></td>
                            <td class="action-buttons" style="white-space: nowrap;">
                                <a href="?page=anggota&aksi=edit&id=<?= $row['id'] ?>" class="btn btn-success">Edit</a>
                                <a onclick="return confirm('Are you sure want to delete?')" href="proses_anggota.php?proses=delete&id=<?= $row['id'] ?>" class="btn btn-danger" style="margin-right: 10px;">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>

                <?php
                    break;
                    case 'edit':
                    $tanggal_daftar_default = date("Y-m-d");
                        if (isset($_GET['id'])) {
                            $id = $_GET['id'];
                            $query = "SELECT anggota.*, jurusan.nama_jurusan, prodi.nama_prodi
                                      FROM anggota
                                      JOIN jurusan ON anggota.jurusan_id = jurusan.id
                                      JOIN prodi ON anggota.prodi_id = prodi.id_prodi
                                      WHERE anggota.id = $id ";
                            $result = $db->query($query);

                            if ($result->num_rows == 1) {
                                $row = $result->fetch_assoc();
                                $id_member = $row['id_member'];
                                $nama = $row['nama'];
                                $jurusan_id =  $row['jurusan_id'];
                                $prodi_id = $row['prodi_id'];
                                $tanggal_lahir = $row['tanggal_lahir'];
                                $tanggal_daftar = $row['tanggal_daftar'];
                                $email = $row['email'];
                                $no_hp = $row['no_hp'];
                                $foto = $row['foto'];
                                $alamat = $row['alamat'];
                                $status_keanggotaan = $row['status_keanggotaan'];
                            } else {
                                echo "Data dengan ID ".$id." Tidak Ditemukan!";
                                exit;
                            }
                        } else {
                            echo "Parameter tidak valid!";
                            exit;
                        }
                ?>

                <div class="container-fluid">
                <div class="container mb-5">
                <h1>Edit Anggota</h1>
                    <a href="index.php?page=anggota&aksi=list" class="btn btn-primary">List Anggota</a><br><br>
                        <form action="proses_anggota.php?proses=update" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= $id ?>">
                                <table class="table table-borderless">
                                    <tr>
                                        <td>ID Member</td>
                                        <td><input type="text" name="id_member" value="<?= $id_member ?>" readonly class="form-control" required></td>
                                    </tr>

                                    <tr>
                                        <td>Nama</td>
                                        <td><input type="text" name="nama" value="<?= $nama ?>" class="form-control" required></td>
                                    </tr>

                                    <tr>
                                        <td>Jurusan</td>
                                        <td>
                                            <select id="jurusan" name="jurusan_id" class="form-control" required>
                                                <option value="" disabled selected>- Pilih Jurusan -</option>
                                                <?php
                                                    $query_jurusan = "SELECT * FROM jurusan";
                                                    $result_jurusan = $db->query($query_jurusan);

                                                    while ($row_jurusan = $result_jurusan->fetch_assoc()) {
                                                        echo '<option value="' . $row_jurusan['id'] . '"';
                                                        echo ($jurusan_id == $row_jurusan['id']) ? ' selected' : '';
                                                        echo '>' . $row_jurusan['nama_jurusan'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Prodi</td>
                                        <td>
                                            <select id="prodi" name="prodi_id" class="form-control" required>
                                                <!-- Opsi Prodi akan ditambahkan menggunakan JavaScript -->
                                            </select>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td>Tanggal Lahir</td>
                                        <td>
                                            <div class="mb-3 row">
                                                <div class="col-sm-2">
                                                    <select name="tanggal_lahir" class="form-control" required>
                                                        <option value="">-DD-</option>
                                                            <?php for ($i = 1; $i <= 31; $i++) : ?>
                                                            <option value="<?= $i ?>" <?= ($i == date('d', strtotime($tanggal_lahir))) ? 'selected' : '' ?>>
                                                            <?= $i ?>
                                                        </option>
                                                            <?php endfor; ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-2">
                                                    <select name="bulan_lahir" class="form-control" required>
                                                        <option value="">-MM-</option>
                                                              <?php for ($i = 1; $i <= 12; $i++) : ?>
                                                              <option value="<?= $i ?>" <?= ($i == date('m', strtotime($tanggal_lahir))) ? 'selected' : '' ?>>
                                                              <?= date('F', mktime(0, 0, 0, $i, 1)) ?>
                                                        </option>
                                                              <?php endfor; ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-2">
                                                    <select name="tahun_lahir" class="form-control" required>
                                                        <option value="">-YYYY-</option>
                                                            <?php for ($i = date('Y'); $i >= date('Y') - 50; $i--) : ?>
                                                            <option value="<?= $i ?>" <?= ($i == date('Y', strtotime($tanggal_lahir))) ? 'selected' : '' ?>>
                                                            <?= $i ?>
                                                        </option>
                                                            <?php endfor; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Tanggal Pendaftaran</td>
                                        <td>
                                            <div class="mb-3 row">
                                                <div class="col-sm-2">
                                                    <input type="text" name="tanggal_daftar" class="form-control" value="<?= date('d', strtotime($tanggal_daftar)) ?>" readonly>
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="text" name="bulan_daftar" class="form-control" value="<?= date('m', strtotime($tanggal_daftar)) ?>" readonly>
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="text" name="tahun_daftar" class="form-control" value="<?= date('Y', strtotime($tanggal_daftar)) ?>" readonly>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Email</td>
                                        <td><input type="email" name="email" value="<?= $email ?>" class="form-control" required></td>
                                    </tr>

                                    <tr>
                                        <td>No HP</td>
                                        <td><input type="text" name="no_hp" value="<?= $no_hp ?>" class="form-control" required></td>
                                    </tr>

                                    <tr>
                                        <td>Foto</td>
                                        <td>
                                            <input type="file" name="foto" accept="image/*" class="form-control-file">
                                            <img src="<?= $foto ?>" alt="Foto Anggota" style="width: 150px;">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Alamat</td>
                                        <td><textarea name="alamat" class="form-control" rows="5" required><?= $alamat ?></textarea></td>
                                    </tr>

                                    <tr>
                                        <td>Status Keanggotaan</td>
                                        <td>
                                            <select name="status_keanggotaan" class="form-control" required>
                                                <option value="Mahasiswa" <?= ($status_keanggotaan == 'Mahasiswa') ? 'selected' : '' ?>>Mahasiswa</option>
                                                <option value="Tendik" <?= ($status_keanggotaan == 'Tendik') ? 'selected' : '' ?>>Tendik</option>
                                                <option value="Dosen" <?= ($status_keanggotaan == 'Dosen') ? 'selected' : '' ?>>Dosen</option>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td></td>
                                        <td><input type="submit" name="submit" class="btn btn-success"></td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </div>

                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            loadProdiOptions();

                            document.getElementById("jurusan").addEventListener("change", function () {
                                loadProdiOptions();
                            });
                        });

                        function loadProdiOptions() {
                            var jurusanDropdown = document.getElementById("jurusan");
                            var selectedJurusanId = jurusanDropdown.options[jurusanDropdown.selectedIndex].value;

                            var prodiDropdown = document.getElementById("prodi");

                            prodiDropdown.innerHTML = '';

                            var defaultOption = document.createElement('option');
                            defaultOption.value = '';

                            <?php
                            $query_prodi_options = "SELECT * FROM prodi";
                            $result_prodi_options = $db->query($query_prodi_options);

                            while ($row_prodi_options = $result_prodi_options->fetch_assoc()) {
                                echo "if (selectedJurusanId === '" . $row_prodi_options['jurusan_id'] . "') {";
                                echo "var option = document.createElement('option');";
                                echo "option.value = '" . $row_prodi_options['id_prodi'] . "';";
                                echo "option.text = '" . $row_prodi_options['nama_prodi'] . "';";
                                echo "prodiDropdown.appendChild(option);";
                                echo "}";
                            }
                            ?>
                            var selectedProdiId = <?php echo $prodi_id; ?>;
                            prodiDropdown.value = selectedProdiId;
                        }
                    </script>

<?php
    break;
}
?>