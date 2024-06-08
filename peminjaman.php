<button class="btn btn-primary mb-3" type="button" onclick="window.location.href='detail_peminjaman.php'">Detail Peminjaman</button>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Book Loans</h5>
                <form method="post" action="proses_peminjaman.php" id="searchForm">
                    <div class="row mb-2">
                        <label for="inputKode" class="col-sm-2 col-form-label">ID Member</label>
                        <div class="col-sm-5">
                            <div class="input-group mb-4">
                                <input name="ky" type="text" class="form-control" placeholder="Enter keywords"
                                    aria-label="Enter keywords" aria-describedby="button-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" onclick="searchLoans()">Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <form method="post" action="proses_peminjaman.php" id="loanForm">
                    <div class="row mb-2">
                        <label for="inputKode" class="col-sm-2 col-form-label">Kode Buku</label>
                        <div class="col-sm-5">
                            <div class="input-group mb-2">
                                <input name="code" type="text" class="form-control" placeholder="Enter keywords"
                                    aria-label="Enter keywords" aria-describedby="button-addon2">
                                <div class="input-group-append">  
                                    <button id="btnLoansForm" class="btn btn-primary" type="button" onclick="processLoans()" style="display:none;">Loans</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            <div id="searchResults" class="container-fluid d-flex align-items-stretch">
                <!-- Hasil Pencarian Search akan ditampilkan di sini -->
            </div>

            <div id="loanResults" class="col-lg-12 d-flex align-items-stretch">
                <!-- Hasil Pencarian Loans akan ditampilkan di sini -->
            </div>
        </div>
    </div>
</div>

<script>
function searchLoans() {
    var ky = document.getElementsByName('ky')[0].value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'proses_peminjaman.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('search=true&ky=' + ky);

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById('searchResults').innerHTML = xhr.responseText;
            document.getElementById('btnLoansForm').style.display = 'block';
        }
    };
}

function processLoans() {
    // Mendapatkan nilai id_member dari input kata kunci
    var ky = document.getElementsByName('ky')[0].value;

    var code = document.getElementsByName('code')[0].value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'proses_peminjaman.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('peminjaman=true&code=' + code + '&id_member=' + ky);

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById('loanResults').innerHTML += xhr.responseText;
        }
    };
}
</script>



