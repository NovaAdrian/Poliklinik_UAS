<?php 
$page = "poli";

// Memeriksa apakah pengguna sudah login, jika tidak, arahkan kembali ke halaman login
if(!isset($_SESSION["username"])){
    header("location: index.php?page=loginUser");
    exit;
}
?>

<form class="form row" method="POST" action="" name="myForm" onsubmit="return(validate());">
    <!-- Kode php untuk menghubungkan form dengan database -->
    <?php
    include('koneksi.php');
    $nama_poli = '';
    $keterangan = '';
    if (isset($_GET['id'])) {
        $ambil = mysqli_query($mysqli, 
        "SELECT * FROM poli 
        WHERE id='" . $_GET['id'] . "'");
        while ($row = mysqli_fetch_array($ambil)) {
            $nama_poli = $row['nama_poli'];
            $keterangan = $row['alamat'];
        }
    ?>
        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
    <?php
    }
    ?>
    <div>
        <label class="form-label fw-bold">
            Nama Poli
        </label>
        <input type="text" class="form-control my-2" name="nama_poli" value="<?php echo $nama_poli?>">
        <label class="form-label fw-bold">
            Keterangan
        </label>
        <input type="text" class="form-control my-2" name="keterangan" value="<?php echo $keterangan ?>">
        <button type="submit" class="btn btn-primary rounded-pill px-3" name="simpan">Simpan</button>
    </div>
</form>

<!-- Table-->
<div class="table-responsive">
    <table class="table table-hover">
        <!--thead atau baris judul-->
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Poli</th>
                <th scope="col">Keterangan</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <!--tbody berisi isi tabel sesuai dengan judul atau head-->
        <tbody>
            <!-- Kode PHP untuk menampilkan semua isi dari tabel urut
            berdasarkan status dan tanggal awal-->
            <?php
            $result = mysqli_query(
                $mysqli,"SELECT * FROM poli ORDER BY nama_poli DESC"
            );
            $no = 1;
            while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <th scope="row"><?php echo $no++ ?></th>
                    <td><?php echo $data['nama_poli'] ?></td>
                    <td><?php echo $data['keterangan'] ?></td>
                    <td>
                        <a class="btn btn-success rounded-pill px-3" 
                        href="index.php?page=poli&id=<?php echo $data['id'] ?>">Ubah
                        </a>
                        <a class="btn btn-danger rounded-pill px-3" 
                        href="index.php?page=poli&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus
                        </a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<?php
include('koneksi.php');
if (isset($_POST['simpan'])) {
    if (isset($_POST['id'])) {
        $ubah = mysqli_query($mysqli, "UPDATE poli SET 
                                        nama_poli = '" . $_POST['nama_poli'] . "',
                                        keterangan = '" . $_POST['keterangan'] . "'
                                        WHERE
                                        id = '" . $_POST['id'] . "'");
    } else {
        $tambah = mysqli_query($mysqli, "INSERT INTO poli(nama_poli, keterangan) 
                                        VALUES ( 
                                            '" . $_POST['nama_poli'] . "',
                                            '" . $_POST['keterangan'] . "'
                                            )");
    }

    echo "<script> 
            document.location='index.php?page=poli';
            </script>";
}

if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM poli WHERE id = '" . $_GET['id'] . "'");
    }

    echo "<script> 
            document.location='index.php?page=poli';
            </script>";
}
?>
