<?php
require "../config/database.php";
require "../config/csrf.php";

//session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit();
}

$page = $_GET['page'] ?? 1;
if ($page < 1) $page = 1;
$limit = 2;
$offset = ($page - 1) * $limit;

$search = $_GET['search'] ?? null;
if ($search) {
   // COUNT
    $countStmt = $pdo->prepare("
        SELECT COUNT(*) FROM products 
        WHERE name LIKE :search 
        OR CAST(price AS CHAR) LIKE :search 
        OR CAST(quantity AS CHAR) LIKE :search
    ");
    $countStmt->execute([':search' => "%$search%"]);
    $totalRecords = $countStmt->fetchColumn();

    // DATA
    $stmt = $pdo->prepare("
        SELECT * FROM products 
        WHERE name LIKE :search 
        OR CAST(price AS CHAR) LIKE :search 
        OR CAST(quantity AS CHAR) LIKE :search
        ORDER BY id DESC
        LIMIT $limit OFFSET $offset
    ");
    $stmt->execute([':search' => "%$search%"]);
} else {
    // COUNT
    $totalRecords = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();

    // DATA
    $stmt = $pdo->prepare("
        SELECT * FROM products 
        ORDER BY id DESC
        LIMIT $limit OFFSET $offset
    ");
    $stmt->execute();
}
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalPages = ceil($totalRecords / $limit);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
</head>
<body>
    <p>Add Products ? <a href="add.php">Add</a></p>

    <?php if (isset($_SESSION['success_msg'])) : ?>
        <p style="color:green"><?= $_SESSION['success_msg'] ?></p>
    <?php 
        unset($_SESSION['success_msg']);
        endif;
    ?>

    <h2>Product List</h2>
    <form action="list.php" method="GET">
        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="search here"/>
        <button type="submit">Search</button>
    </form><br/>
    <table border="1">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
        <?php 
            $count = $offset + 1;
            foreach($products as $p) { ?>
            <tr>
                <td><?=($count++)?></td>
                <td><?= htmlspecialchars($p['name'] ?? "") ?></td>
                <td><?= htmlspecialchars($p['price'] ?? "") ?></td>
                <td><?= htmlspecialchars($p['quantity'] ?? "") ?></td>
                <td><img src="../uploads/<?= htmlspecialchars($p['image'] ?? "") ?>" width="50" height="50"/></td>
                <td>
                    <a href="edit.php?id=<?=$p['id']?>">Edit</a>
                    <form action="delete.php" method="POST">
                        <input type="hidden" name="csrf_token" value="<?= create_csrf() ?>">
                        <input type="hidden" name="id" value="<?= $p['id'] ?>" >
                        <button type="submit" name="delete" onclick= return confirm('Are you sure to delete?');>Delete</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
    <br/>

    <?php
    if($page > 1){
        echo "<a href='?page=".($page-1)."&search=".urlencode($search)."'>Prev</a> ";
    }

    for($i = 1; $i <= $totalPages; $i++){

        if($i == $page){
            echo "<strong>$i</strong> ";
        } else {
            echo "<a href='?page=$i&search=".urlencode($search)."'>$i</a> ";
        }
    }

    if($page < $totalPages){
        echo "<a href='?page=".($page+1)."&search=".urlencode($search)."'>Next</a>";
    }
    ?>
</body>
</html>