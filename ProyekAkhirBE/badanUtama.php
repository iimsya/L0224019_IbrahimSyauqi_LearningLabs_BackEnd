<?php
include 'database.php';

if (isset($_POST['add_task'])) {
    $task = $_POST['task'];
    $sql = "INSERT INTO tasks (task) VALUES ('$task')";
    $conn->query($sql);
    header("Location: index.php");
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM tasks WHERE id=$id");
    header("Location: index.php");
}

if (isset($_POST['update_task'])) {
    $id = $_POST['id'];
    $task = $_POST['task'];
    $conn->query("UPDATE tasks SET task='$task' WHERE id=$id");
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="baju.css">
</head>
<body background="images/gambar1.jpeg">
    <h1>Daftar Kegiatan</h1>
    
    <form method="POST" action="index.php">
        <input type="text" name="task" placeholder="Mau nambah kegiatan apa ?" required>
        <button type="submit" name="add_task">Tambah</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Kegiatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT * FROM tasks ORDER BY created_at DESC");
            while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['task']); ?></td>
                    <td>
                        <a href="index.php?edit=<?= $row['id']; ?>">Edit</a> |
                        <a href="index.php?delete=<?= $row['id']; ?>" onclick="return confirm('yakin mau hapus nih ?');">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <?php if (isset($_GET['edit'])): 
        $id = $_GET['edit'];
        $task = $conn->query("SELECT * FROM tasks WHERE id=$id")->fetch_assoc();
    ?>
    <form method="POST" action="index.php">
        <input type="hidden" name="id" value="<?= $id; ?>">
        <input type="text" name="task" value="<?= htmlspecialchars($task['task']); ?>" required>
        <button type="submit" name="update_task">Perbarui</button>
    </form>
    <?php endif; ?>
</body>
</html>
