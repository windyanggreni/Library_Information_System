<?php
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';
switch ($aksi) {
    case 'list':
?>

<div class="container-fluid">
    <div class="container">
        <h1 class="text-center">List Visitor</h1>
        <table class="table table-striped" id="example">
            <thead>
                <tr>
                    <th style="background-color: salmon;">No</th>
                    <th style="background-color: salmon;">ID Member</th>
                    <th style="background-color: salmon;">Jurusan</th>
                    <th style="background-color: salmon;">Prodi</th>
                    <th style="background-color: salmon;">Tanggal Kunjungan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT kunjungan.*, jurusan.nama_jurusan, prodi.nama_prodi
                FROM kunjungan
                JOIN jurusan ON kunjungan.id = jurusan.id
                JOIN prodi ON kunjungan.id = prodi.id_prodi";

                $result = $db->query($query);
                $nomor = 1;
                foreach ($result as $row) : ?>
                    <tr>
                        <td><?= $nomor++ ?></td>
                        <td><?= $row['id_member'] ?></td>
                        <td><?= $row['nama_jurusan'] ?></td>
                        <td><?= $row['nama_prodi'] ?></td>
                        <td><?= $row['tanggal_kunjungan'] ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<?php
    break;
    case 'input':
    $tanggal_kunjungan_default = date("Y-m-d");

    $query_jurusan = "SELECT * FROM jurusan";
    $result_jurusan = $db->query($query_jurusan);

?>
<div class="container-fluid">
    <div class="container">
        <h1 class="mb-4">Input Kunjungan</h1>
        <?php if ($isUserLoggedIn && $isAdmin) : ?>
        <a href="index.php?page=visitor&aksi=list" class="btn btn-primary mb-4">List Pengunjung</a>
        <?php endif; ?>
            <form action="proses_visitor.php?proses=insert" method="post" enctype="multipart/form-data">
                <div class="mb-3 row">
                    <label for="id_member" class="col-sm-2 col-form-label">ID Member</label>
                    <div class="col-sm-10">
                        <input type="text" name="id_member" class="form-control" required>
                    </div>
                </div>

    <div class="mb-3 row">
        <label for="jurusan" class="col-sm-2 col-form-label">Jurusan</label>
        <div class="col-sm-10">
            <select id="jurusan" name="jurusan_id" class="form-control" required>
                <option value="" disabled selected>- Pilih Jurusan -</option>
                <?php
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
        <label for="tgl"  class="col-sm-2 col-form-label">Tanggal Kunjungan</label>
        <div class="col-sm-2">
            <input type="text" name="tanggal_kunjungan" class="form-control" value="<?= date('d', strtotime($tanggal_kunjungan_default)) ?>" readonly>
        </div>
        <div class="col-sm-2">
            <input type="text" name="bulan_kunjungan" class="form-control" value="<?= date('m', strtotime($tanggal_kunjungan_default)) ?>" readonly>
        </div>
        <div class="col-sm-2">
            <input type="text" name="tahun_kunjungan" class="form-control" value="<?= date('Y', strtotime($tanggal_kunjungan_default)) ?>" readonly>
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

        // Bersihkan opsi Prodi sebelum menambahkan yang baru
        prodiDropdown.innerHTML = '';

        // Tambahkan opsi default untuk Prodi
        var defaultOption = document.createElement('option');
        defaultOption.value = '';
        //defaultOption.text = 'pilih';
        //prodiDropdown.appendChild(defaultOption);

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

<?php
    break;
    }
?>