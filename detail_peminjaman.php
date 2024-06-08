<?php
include 'koneksitugas.php';

    $peminjamanQuery = "SELECT * FROM peminjaman";

    $peminjamanResult = $db->query($peminjamanQuery);

    if ($peminjamanResult) {
    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body {
                font-family: Arial, sans-serif;
            }

            .container-fluid img {
                max-width: 100%;
                height: auto;
                max-height: 150px;
            }

            .container {
                margin: 20px;
            }

            h1 {
                text-align: center;
                margin-bottom: 20px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }

            th,
            td {
                text-align: center;
                padding: 10px;
                border: 1px solid #dee2e6;
            }

            @media print {
                body {
                    margin: 0;
                }

                .container {
                    margin: 0;
                }

                .container-fluid img {
                    max-width: 100%;
                    height: auto;
                    max-height: 150px;
                }
            }
        </style>
    </head>

    <body>
        <div class="container-fluid">
            <img src="images/kop.png" alt="Deskripsi Gambar">
        </div>

        <div class="container">
            <h1>List Peminjaman</h1>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Peminjaman ID</th>
                        <th>Kode Buku</th>
                        <th>ID Member</th>
                        <th>Tanggal Peminjaman</th>
                        <th>Tanggal Pengembalian</th>
                        <th>Denda</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $nomorPeminjaman = 1;

                    foreach ($peminjamanResult as $peminjamanRow) :
                    ?>
                        <tr>
                            <td><?= $nomorPeminjaman++ ?></td>
                            <td><?= $peminjamanRow['peminjaman_id'] ?></td>
                            <td><?= $peminjamanRow['kode_buku'] ?></td>
                            <td><?= $peminjamanRow['id_member'] ?></td>
                            <td><?= $peminjamanRow['tanggal_peminjaman'] ?></td>
                            <td><?= $peminjamanRow['tanggal_pengembalian'] ?></td>
                            <td><?= $peminjamanRow['denda'] ?></td>
                            <td><?= $peminjamanRow['status'] ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>

        <script>
           window.print()
        </script>
        
    </body>
</html>

<?php
    } else {
        echo "Query tidak berhasil dieksekusi.";
    }
?>
