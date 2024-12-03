<?php
    include "assets/header.php";
    include "assets/sidebar.php";
    include "assets/main.php";
    $search = '';
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $query = "SELECT * FROM PELANGGAN where NAMA_PELANGGAN LIKE '%$search%' ORDER BY NAMA_PELANGGAN ASC ";
        $result = mysqli_query($conn, $query);
    }else{
        $query = "SELECT * FROM PELANGGAN";
        $result = mysqli_query($conn, $query);
    }
    if (isset($_GET['id'])) {
        $id_pelanggan = $_GET['id'];
        $query = "DELETE FROM PELANGGAN WHERE ID_PELANGGAN = $id_pelanggan";
        $result = mysqli_query($conn, $query);
        echo "<script>confirm('Data pelanggan berhasil dihapus!'); window.location.href='pelanggan.php';</script>";
    } 
if (isset($_POST['save'])) {
    $id_pelanggan = $_POST['ida'];
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $query = "UPDATE pelanggan SET NAMA_PELANGGAN = '$nama_pelanggan' WHERE ID_PELANGGAN = '$id_pelanggan'";
    $query_run = mysqli_query($conn, $query);
    echo "<script>alert('Data pelanggan berhasil diperbarui!'); window.location.href='pelanggan.php';</script>";
}
?>
<h1>Tabel Pelanggan</h1>
<div class="mb-4 d-flex justify-content-between align-items-center">
<form method="GET" class="d-flex">
        <input 
            class="form-control w-100 me-2" 
            placeholder="cari nama pelanggan" 
            type="text" 
            name="search" 
            id="search"
            value="<?php echo htmlspecialchars($search); ?>" />
            <script>
                $(document).ready(function() {
                    $("#search").autocomplete({
                        source: function(request, response) {
                            $.ajax({
                            url: "search_pelanggan.php",
                            type: "GET",
                            data: { term: request.term },
                            dataType: "json",
                            success: function(data) {
                                response(data);
                                        }
                                    });
                                },
                                minLength: 2
                            });
                        });
        </script>
        <button class="btn btn-primary" type="submit">Search</button>
    </form>
</div>
<table>
    <tr>
        <th>ID Pelanggan</th>
        <th>Nama Pelanggan</th>
        <th>Aksi</th>
    </tr>
    <?php 
foreach ($result as $row) { 
    $id_pelanggan = isset($_GET['ida']) ? $_GET['ida'] : null; ?>
    <tr>
        <td><?= $row['ID_PELANGGAN']; ?></td>
        <?php $rows=0; if ($id_pelanggan == $row['ID_PELANGGAN']) { ?>
            <form method="POST" action="pelanggan.php">
                <td>
                    <input type="hidden" name="id" value="<?= $rows++ ?>">
                    <input type="text" name="nama_pelanggan" value="<?= htmlspecialchars($row['NAMA_PELANGGAN']); ?>" required>
                </td>
                <td>
                    <div class="d-flex gap-1 justify-content-center">
                        <button type="submit" name="save" class="btn btn-success btn-sm">Save</button>
                        <a href="pelanggan.php" class="btn btn-secondary btn-sm">Cancel</a>
                    </div>
                </td>
            </form>
        <?php } else { ?>
            <td><?= htmlspecialchars($row['NAMA_PELANGGAN']); ?></td>
            <td>
                <div class="d-flex gap-1 justify-content-center">
                    <a href="pelanggan.php?ida=<?= $row['ID_PELANGGAN']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="pelanggan.php?id=<?= $row['ID_PELANGGAN']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?')">Delete</a>
                </div>
            </td>
        <?php } ?>
    </tr>
<?php } 
?>
</table>
</div>
<?php
    include "assets/footer.php";
?>
