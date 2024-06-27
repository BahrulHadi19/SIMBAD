<!DOCTYPE html>
<html>
<head>
    <title>BAHRUL</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa; /* Light gray background */
        }
        .navbar {
            background-color: #007bff; /* Primary blue color */
        }
        .navbar-brand {
            color: #ffffff !important; /* White text */
        }
        h4 {
            color: #007bff; /* Primary blue color */
        }
        .table-primary {
            background-color: #e9ecef; /* Light gray for table header */
        }
        .btn-warning {
            background-color: #ffc107; /* Warning yellow */
            border-color: #ffc107;
        }
        .btn-danger {
            background-color: #dc3545; /* Danger red */
            border-color: #dc3545;
        }
        .btn-primary {
            background-color: #28a745; /* Success green */
            border-color: #28a745;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark">
        <span class="navbar-brand mb-0 h1">PROJECT BAHRUL</span>
    </nav>
    <div class="container">
        <br>
        <h4><center>DATA PENJUALAN</center></h4>
        <?php
        include "koneksi.php";
        session_start();
        if (!isset($_SESSION['logerr'])) {
            $_SESSION['logerr'] = 'Belum login';
        }

        if (isset($_GET['Nomor_Barang'])) {
            $Nomor_Barang = htmlspecialchars($_GET["Nomor_Barang"]);

            // Use prepared statements to prevent SQL injection
            $stmt = $kon->prepare("DELETE FROM Penjualan WHERE Nomor_Barang = ?");
            $stmt->bind_param("s", $Nomor_Barang);

            if ($stmt->execute()) {
                header("Location: index.php");
                exit();  // Ensure the script stops executing after redirection
            } else {
                echo "<div class='alert alert-danger'> Data Gagal dihapus.</div>";
            }

            $stmt->close();
        }
        ?>

        <table class="table table-bordered">
            <thead>
                <tr class="table-primary">
                    <th>No</th>
                    <th>Nomor Barang</th>
                    <th>Nama Barang</th>
                    <th>Persediaan</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th colspan='2'>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM penjualan ORDER BY Nomor_Barang ASC";
                $hasil = mysqli_query($kon, $sql);
                $no = 0;
                while ($data = mysqli_fetch_array($hasil)) {
                    $no++;
                    ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo htmlspecialchars($data["Nomor_Barang"]); ?></td>
                        <td><?php echo htmlspecialchars($data["Nama_Barang"]); ?></td>
                        <td><?php echo htmlspecialchars($data["Persediaan"]); ?></td>
                        <td>Rp.<?php echo htmlspecialchars($data["Harga"]); ?></td>
                        <td>Rp.<?php echo htmlspecialchars($data["Jumlah"]); ?></td>
                        <td>
                            <a href="update.php?Nomor_Barang=<?php echo htmlspecialchars($data['Nomor_Barang']); ?>" class="btn btn-warning" role="button">Update</a>
                            <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?Nomor_Barang=<?php echo $data['Nomor_Barang']; ?>" class="btn btn-danger" role="button">Delete</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <a href="create.php" class="btn btn-primary" role="button">Tambah Data</a>
    </div>
</body>
</html>
