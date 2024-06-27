<!DOCTYPE html>
<html>
<head>
    <title>Update Penjualan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script>
        function updateJumlah() {
            let harga = document.getElementById('harga').value;
            let persediaan = document.getElementById('persediaan').value;
            let jumlah = document.getElementById('jumlah');

            if (harga && persediaan) {
                jumlah.value = parseFloat(harga) * parseFloat(persediaan);
            } else {
                jumlah.value = '';
            }
        }
    </script>
</head>
<body>
<div class="container">
    <?php
    // Sambungkan ke database
    include "koneksi.php";

    function input($data) {
        global $kon;
        $data = mysqli_real_escape_string($kon, $data);
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Ambil data yang akan diupdate
    if (isset($_GET['Nomor_Barang'])) {
        $nomor_barang = input($_GET["Nomor_Barang"]);
        $sql = "SELECT * FROM penjualan WHERE Nomor_Barang='$nomor_barang'";
        $hasil = mysqli_query($kon, $sql);
        $data = mysqli_fetch_assoc($hasil);
    }

    // Proses update data
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $Nomor_Barang = input($_POST["Nomor_Barang"]);
        $Nama_Barang = input($_POST["Nama_Barang"]);
        $Persediaan = input($_POST["Persediaan"]);
        $Harga = input($_POST["Harga"]);
        $Jumlah = input($_POST["Jumlah"]);

        $sql = "UPDATE penjualan SET Nama_Barang='$Nama_Barang', Persediaan='$Persediaan', Harga='$Harga', Jumlah='$Jumlah' WHERE Nomor_Barang='$Nomor_Barang'";
        $hasil = mysqli_query($kon, $sql);

        if ($hasil) {
            header("Location: index.php");
            exit;
        } else {
            echo "<div class='alert alert-danger'> Data Gagal disimpan.</div>";
        }
    }
    ?>
    <h2>Update Data</h2>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label>Nomor Barang:</label>
            <input type="text" name="Nomor_Barang" class="form-control" value="<?php echo isset($data['Nomor_Barang']) ? htmlspecialchars($data['Nomor_Barang']) : ''; ?>" readonly>
        </div>
        <div class="form-group">
            <label>Nama Barang:</label>
            <input type="text" name="Nama_Barang" class="form-control" value="<?php echo isset($data['Nama_Barang']) ? htmlspecialchars($data['Nama_Barang']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <label>Persediaan:</label>
            <input type="text" name="Persediaan" id="persediaan" class="form-control" value="<?php echo isset($data['Persediaan']) ? htmlspecialchars($data['Persediaan']) : ''; ?>" required oninput="updateJumlah()">
        </div>
        <div class="form-group">
            <label>Harga:</label>
            <input type="text" name="Harga" id="harga" class="form-control" value="<?php echo isset($data['Harga']) ? htmlspecialchars($data['Harga']) : ''; ?>" required oninput="updateJumlah()">
        </div>
        <div class="form-group">
            <label>Jumlah:</label>
            <input type="text" name="Jumlah" id="jumlah" class="form-control" value="<?php echo isset($data['Jumlah']) ? htmlspecialchars($data['Jumlah']) : ''; ?>" required readonly>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>
