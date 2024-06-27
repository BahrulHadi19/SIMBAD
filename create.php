<!DOCTYPE html>
<html>
<head>
    <title>Penjualan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa; /* Light gray background */
        }
        .container {
            background-color: #ffffff; /* White container background */
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 0 10px rgba(0,0,0,0.1); /* Subtle shadow for depth */
            padding: 20px; /* Padding inside container */
            margin-top: 20px; /* Margin from top */
        }
        h2 {
            color: #007bff; /* Blue header */
            text-shadow: 1px 1px #6c757d; /* Text shadow for emphasis */
            margin-bottom: 20px; /* Bottom margin for separation */
            text-align: center; /* Center align header */
        }
        label {
            color: #343a40; /* Dark gray label text */
        }
        .form-control {
            border-color: #007bff; /* Blue border color for form controls */
        }
        .form-control:focus {
            border-color: #0069d9; /* Darker blue border color on focus */
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25); /* Light shadow on focus */
        }
        .btn-primary {
            background-color: #28a745; /* Green submit button */
            border-color: #28a745; /* Green border color */
        }
        .btn-primary:hover {
            background-color: #218838; /* Darker green on hover */
            border-color: #1e7e34; /* Darker border on hover */
        }
        ::placeholder {
            color: #6c757d; /* Placeholder text color */
        }
    </style>
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
    include "koneksi.php";

    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nomor_barang = input($_POST["nomor_barang"]);
        $nama_barang = input($_POST["nama_barang"]);
        $persediaan = input($_POST["persediaan"]);
        $harga = input($_POST["harga"]);
        $jumlah = input($_POST["jumlah"]);

        $sql = "INSERT INTO penjualan (nomor_barang, nama_barang, persediaan, harga, jumlah) VALUES ('$nomor_barang', '$nama_barang', '$persediaan', '$harga', '$jumlah')";
        $hasil = mysqli_query($kon, $sql);

        if ($hasil) {
            header("Location: index.php");
        } else {
            echo "<div class='alert alert-danger'> Data Gagal disimpan.</div>";
        }
    }
    ?>
    <h2>Masukkan Data</h2>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label>Nomor Barang:</label>
            <input type="text" name="nomor_barang" class="form-control" placeholder="Masukan nomor barang" required>
        </div>
        <div class="form-group">
            <label>Nama Barang:</label>
            <input type="text" name="nama_barang" class="form-control" placeholder="Masukan nama barang" required>
        </div>
        <div class="form-group">
            <label>Persediaan:</label>
            <input type="text" name="persediaan" id="persediaan" class="form-control" placeholder="Masukan persediaan" required oninput="updateJumlah()">
        </div>
        <div class="form-group">
            <label>Harga:</label>
            <input type="text" name="harga" id="harga" class="form-control" placeholder="Masukan harga" required oninput="updateJumlah()">
        </div>
        <div class="form-group">
            <label>Jumlah:</label>
            <input type="text" name="jumlah" id="jumlah" class="form-control" placeholder="Masukan jumlah" required readonly>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>
