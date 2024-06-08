<?php
include 'koneksitugas.php';

if (isset($_POST['search'])) 
{
    $ky = isset($_POST['ky']) ? $_POST['ky'] : '';
    $query = "SELECT anggota.*, jurusan.nama_jurusan, prodi.nama_prodi
                FROM anggota
                JOIN jurusan ON anggota.jurusan_id = jurusan.id
                JOIN prodi ON anggota.prodi_id = prodi.id_prodi WHERE anggota.id_member LIKE '$ky%'";
    $result = $db->query($query);

    

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // MEMBER DETAILS INFORMATION
            echo <<<HTML
            <form action="" method="post">
            <div class="card w-100">
            <div class="card-body p-4">
            <dl class="row">
            <h4 style="margin-top: 0; margin-bottom: 40px; color: #007bff;">Data Anggota</h4>

            <dt class="col-sm-3">ID Member</dt>
            <dd class="col-sm-9">
                <input class="form-control" value="{$row['id_member']}" name="id_member" id="inputKode" readonly>
            </dd>

            <dt class="col-sm-3">Nama</dt>
            <dd class="col-sm-9">
                <input class="form-control" value="{$row['nama']}" name="nama" id="inputKode" readonly>
            </dd>

            <dt class="col-sm-3">Jurusan</dt>
            <dd class="col-sm-9">
                <input class="form-control" value="{$row['nama_jurusan']}" name="jurusan_id" id="inputKode" readonly>
            </dd>

            <dt class="col-sm-3">Prodi</dt>
            <dd class="col-sm-9">
                <input class="form-control" value="{$row['nama_prodi']}" name="prodi_id" id="inputKode" readonly>
            </dd>

            <dt class="col-sm-3">Status Keanggotaan</dt>
            <dd class="col-sm-9">
                <input class="form-control" type="status_keanggotaan" value="{$row['status_keanggotaan']}"  name="email" id="inputKode" readonly>
            </dd>

            <dt class="col-sm-3">Email</dt>
            <dd class="col-sm-9">
                <input class="form-control" type="email" value="{$row['email']}"  name="email" id="inputKode" readonly>
            </dd>

            <dt class="col-sm-3">No HP</dt>
            <dd class="col-sm-9">
                <input class="form-control" type="no_hp" value="{$row['no_hp']}"  name="email" id="inputKode" readonly>
            </dd>

            <dt class="col-sm-3">Tanggal Registrasi</dt>
            <dd class="col-sm-9">
                <input class="form-control" type="date" value="{$row['tanggal_daftar']}" name="tanggal_daftar" id="inputKode" readonly>
            </dd>
        </dl>
                    
        <!-- Tabel Peminjaman -->
        </div> 
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-2">Daftar Peminjaman</h5>
                <hr>
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-5">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">No</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">ID Member</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Kode Buku</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Tanggal Peminjaman</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Tanggal Pengembalian</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Status Pengembalian</h6>
                                    </th>
                                </tr>
                            </thead>
                        <tbody>
HTML;

            $id_member = $row['id_member'];
            $queryLoans = "SELECT * FROM peminjaman 
                           INNER JOIN buku ON peminjaman.kode_buku = buku.kode_buku 
                           WHERE peminjaman.id_member = '$id_member' AND status='Sedang Dipinjam'";
            $resultLoans = $db->query($queryLoans);

            if ($resultLoans->num_rows > 0) {
                $nomor = 1;
                while ($rowLoan = $resultLoans->fetch_assoc()) {
                    echo <<<HTML
                    <tr>
                        <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">$nomor</h6>
                        </td>
                        <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-1">{$rowLoan['id_member']}</h6>
                        </td>
                        <td class="border-bottom-0">
                            <p class="mb-0 fw-normal">{$rowLoan['kode_buku']}</p>
                        </td>
                        <td class="border-bottom-0">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-success rounded-3 fw-semibold">{$rowLoan['tanggal_peminjaman']}</span>
                            </div>
                        </td>
                        <td class="border-bottom-0">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-danger rounded-3 fw-semibold">{$rowLoan['tanggal_pengembalian']}</span>
                            </div>
                        </td>
                        
                        <td class="border-bottom-0">
                            <a class="btn btn-primary" href="proses_peminjaman.php?proses=pengembalian&kode_buku={$rowLoan['kode_buku']}&peminjaman_id={$rowLoan['peminjaman_id']}">
                            <i class="ti ti-check"></i> Return
                            </a>
                            <a class="btn btn-danger" onclick="return confirm('Apakah yakin menghapusnya?')" href="proses_peminjaman.php?proses=delete&kode_buku={$rowLoan['kode_buku']}&peminjaman_id={$rowLoan['peminjaman_id']}">
                            <i class="ti ti-x"></i> Hapus
                            </a>
                        </td>
                    </tr>
HTML;
                    $nomor++;
                }

                echo <<<HTML
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
HTML;
            } else {
                echo '<p>Tidak ada buku yang dipinjam untuk member ini.</p>';
            }

            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p>Data Anggota tidak ditemukan</p>';
    }
}

if (isset($_POST['peminjaman']) && isset($_POST['code']) && isset($_POST['id_member'])) 
{
    $code = $_POST['code'];
    $id_member = $_POST['id_member'];
    // Set nilai status ke 'Sedang Dipinjam'
    $status_peminjaman = 'Sedang Dipinjam';
    
    $maxLoanCount = 3;
    $currentLoanCount = getLoanCount($id_member, $db);

    if ($currentLoanCount >= $maxLoanCount) {
        echo '<div>Anda sudah mencapai batas maksimal peminjaman</div>';
    } else {
        $queryGetIdBuku = "SELECT kode_buku FROM buku WHERE kode_buku = '$code'";
        $resultGetIdBuku = $db->query($queryGetIdBuku);

        if ($resultGetIdBuku->num_rows > 0) {
            $rowGetIdBuku = $resultGetIdBuku->fetch_assoc();
            $kode_buku = $rowGetIdBuku['kode_buku'];

            $tanggal_peminjaman = date('Y-m-d');
            $tanggal_pengembalian = date('Y-m-d', strtotime('+7 days'));

            $queryStatusKeanggotaan = "SELECT status_keanggotaan FROM anggota WHERE id_member = '$id_member'";
            $resultStatusKeanggotaan = $db->query($queryStatusKeanggotaan);
            $rowStatusKeanggotaan = $resultStatusKeanggotaan->fetch_assoc();
            $type = $rowStatusKeanggotaan['status_keanggotaan']; 
            if ($type == "Dosen") {
                $tanggal_pengembalian = date('Y-m-d', strtotime($tanggal_peminjaman . '+30 days'));
            } else {
                $tanggal_pengembalian = date('Y-m-d', strtotime($tanggal_peminjaman . '+7 days'));
            }

            $queryPeminjaman = "INSERT INTO peminjaman(kode_buku, id_member, tanggal_peminjaman, tanggal_pengembalian, status) 
                            VALUES ('$kode_buku', '$id_member', '$tanggal_peminjaman', '$tanggal_pengembalian', '$status_peminjaman')";

            if ($db->query($queryPeminjaman)) {
                // Ambil informasi buku
                $queryInfoBuku = "SELECT * FROM buku WHERE kode_buku = '$kode_buku'";
                $resultInfoBuku = $db->query($queryInfoBuku);

                // Ambil informasi member
                $queryInfoMember = "SELECT * FROM anggota WHERE id_member = '$id_member'";
                $resultInfoMember = $db->query($queryInfoMember);

                $queryInfoPinjam = "SELECT * FROM peminjaman WHERE id_member = '$id_member'";
                $resultInfoPinjam = $db->query($queryInfoPinjam);

                if ($resultInfoBuku->num_rows > 0 && $resultInfoMember->num_rows > 0) {
                    $rowInfoBuku = $resultInfoBuku->fetch_assoc();
                    $rowInfoMember = $resultInfoMember->fetch_assoc();
                    $rowInfoPinjam = $resultInfoPinjam->fetch_assoc();

                    $queryStatusKeanggotaan = "SELECT status_keanggotaan FROM anggota WHERE id_member = '$id_member'";
                    $resultStatusKeanggotaan = $db->query($queryStatusKeanggotaan);

                    if ($resultStatusKeanggotaan->num_rows > 0) {
                        $rowStatusKeanggotaan = $resultStatusKeanggotaan->fetch_assoc();
                        $status_keanggotaan = $rowStatusKeanggotaan['status_keanggotaan'];

                        if ($status_keanggotaan == 'Dosen') {
                            $tanggal_pengembalian = date('Y-m-d', strtotime($tanggal_peminjaman . '+30 days'));
                        } else {
                            $tanggal_pengembalian = date('Y-m-d', strtotime($tanggal_peminjaman . '+7 days'));
                        }

                        // Update jumlah buku yang tersedia di tabel buku
                        $queryUpdateBuku = "UPDATE buku SET total_books = total_books - 1 WHERE kode_buku = '$kode_buku'";
                        $db->query($queryUpdateBuku);
                    }

                    echo <<<HTML
        <div class="col-lg-12 d-flex align-items-stretch">
          <div class="card w-100">
              <div class="card-body p-4">
                  <h5 class="card-title fw-semibold mb-2">Loan List</h5>
                  <hr>
                  <div class="table-responsive">
                      <table class="table text-nowrap mb-0 align-middle">
                          <thead class="text-dark fs-5">
                              <tr>
                                  <th class="border-bottom-0">
                                      <h6 class="fw-semibold mb-0">No</h6>
                                  </th>
                                  <th class="border-bottom-0">
                                      <h6 class="fw-semibold mb-0">ID Member</h6>
                                  </th>
                                  <th class="border-bottom-0">
                                      <h6 class="fw-semibold mb-0">Kode Buku</h6>
                                  </th>
                                  <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Loan Date</h6>
                                  </th>
                                  <th class="border-bottom-0">
                                  <h6 class="fw-semibold mb-0">Return Date</h6>
                                 </th>
                              </tr>
                          </thead>
                          <tbody>
                              <tr>
                                  <td class="border-bottom-0">
                                      <h6 class="fw-semibold mb-0">1</h6>
                                  </td>
                                  <td class="border-bottom-0">
                                      <h6 class="fw-semibold mb-1">{$rowInfoMember['id_member']}</h6>
                                  </td>
                                  <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">{$rowInfoBuku['kode_buku']}</p>
                                </td>
                                <td class="border-bottom-0">
                                  <div class="d-flex align-items-center gap-2">
                                      <span class="badge bg-success rounded-3 fw-semibold">{$rowInfoPinjam['tanggal_peminjaman']}</span>
                                  </div>
                              </td>
                              <td class="border-bottom-0">
                                  <div class="d-flex align-items-center gap-2">
                                      <span class="badge bg-danger rounded-3 fw-semibold">{$rowInfoPinjam['tanggal_pengembalian']}</span>
                                  </div>
                              </td>
                            </tr>  
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
        </div>
HTML;
                } else {
                    echo '<div>Failed to fetch book or member information.</div>';
                }
            } else {
                echo '<div>Failed to insert data into peminjaman table.</div>';
                echo "Error: " . $db->error;
            }


        } else {
            echo '<div>Book with code ' . $code . ' not found.</div>';
        }
    }
}

if (isset($_GET['proses']) && $_GET['proses'] == 'pengembalian') 
{
    $kode_buku = $_GET['kode_buku'];
    $peminjaman_id = $_GET['peminjaman_id'];

    // Mendapatkan tanggal pengembalian dari tabel peminjaman
    $queryGetDueDate = "SELECT tanggal_pengembalian FROM peminjaman WHERE kode_buku = '$kode_buku' AND peminjaman_id = '$peminjaman_id'";
    $result = $db->query($queryGetDueDate);
    $row = $result->fetch_assoc();
    $tanggal_pengembalian = $row['tanggal_pengembalian'];

    // Mendapatkan tanggal pengembalian aktual
    $actual_return_date = date('Y-m-d');

    // Menghitung perbedaan hari
    $diff_days = floor((strtotime($actual_return_date) - strtotime($tanggal_pengembalian)) / (60 * 60 * 24));

    // Menentukan batas waktu tertentu untuk penerapan denda (misalnya, 1 hari)
    $late_return_penalty = 200; 
    $late_return_days_limit = 1; 

    if ($diff_days >= $late_return_days_limit) {
        // Menghitung total denda
        $total_penalty = $diff_days * $late_return_penalty;

        // Update status dan tambahkan denda
        $queryUpdateStatus = "UPDATE peminjaman SET status = 'Sudah Dikembalikan', denda = $total_penalty WHERE kode_buku = '$kode_buku' AND peminjaman_id = '$peminjaman_id'";
        if ($db->query($queryUpdateStatus) === TRUE) {
            $queryUpdateTotalBooks = "UPDATE buku SET total_books = total_books + 1 WHERE kode_buku = '$kode_buku'";
            $db->query($queryUpdateTotalBooks);

            header("Location: index.php?page=peminjaman");
        } else {
            echo "Buku gagal dikembalikan! " . $db->error;
        }
    } else {
        // Update status tanpa denda
        $queryUpdateStatus = "UPDATE peminjaman SET status = 'Sudah Dikembalikan' WHERE kode_buku = '$kode_buku' AND peminjaman_id = '$peminjaman_id'";
        if ($db->query($queryUpdateStatus) === TRUE) {
            $queryUpdateTotalBooks = "UPDATE buku SET total_books = total_books + 1 WHERE kode_buku = '$kode_buku'";
            $db->query($queryUpdateTotalBooks);

            header("Location: index.php?page=peminjaman");
        } else {
            echo "Buku gagal dikembalikan! " . $db->error;
        }
    }
}

if (isset($_GET['proses']) && $_GET['proses'] == 'delete') 
{
    $kode_buku = $_GET['kode_buku'];
    $peminjaman_id = $_GET['peminjaman_id'];

    $sql = "DELETE FROM peminjaman WHERE kode_buku='$kode_buku' AND peminjaman_id='$peminjaman_id'";

    if ($db->query($sql) === TRUE) {
        $queryUpdateTotalBooks = "UPDATE buku SET total_books = total_books + 1 WHERE kode_buku = '$kode_buku'";
        $db->query($queryUpdateTotalBooks);
        header("Location: index.php?page=peminjaman");
    } else {
        echo "Data gagal dihapus! " . $db->error;
    }
}

function getLoanCount($id_member, $db)
{
    $query = "SELECT COUNT(*) as total FROM peminjaman WHERE id_member = '$id_member' AND status='Sedang Dipinjam'";
    $result = $db->query($query);

    if ($result) {
        $row = $result->fetch_assoc();
        return $row['total'];
    } else {
        return 0;
    }
}

$db->close();
?>