<?php
session_start();
include("connection.php");

// Check admin session
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit;
}

/* ---------------- FETCH DATA FOR EDIT ---------------- */
$editData = null;
if (isset($_GET['edit'])) {
    $editId = $_GET['edit'];
    $editRes = mysqli_query($conn, "SELECT * FROM menu_master WHERE MenuId='$editId'");
    $editData = mysqli_fetch_assoc($editRes);
}

/* ---------------- UPDATE ITEM ---------------- */
if (isset($_POST['update'])) {

    $menu_id     = $_POST['menuid'];
    $subcategory = $_POST['subcategory'];
    $name        = $_POST['name'];
    $description = $_POST['description'];
    $rate        = $_POST['rate'];
    $menutype    = $_POST['menutype'];
    $discount    = $_POST['discount'];

    if (!empty($_FILES['image']['name'])) {
        $image = "../images/" . time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
        $imgSql = ", MenuImageUrl='$image'";
    } else {
        $imgSql = "";
    }

    mysqli_query($conn, "
        UPDATE menu_master SET
        MenuSubCategoryName='$subcategory',
        MenuName='$name',
        Description='$description',
        Rate='$rate',
        MenuTypeId='$menutype',
        Discount='$discount'
        $imgSql
        WHERE MenuId='$menu_id'
    ");

    $_SESSION['success'] = "✏️ Record updated successfully";
    header("Location: menu_items.php");
    exit;
}

/* ---------------- ADD ITEM ---------------- */
if (isset($_POST['add'])) {

    $menu_id     = $_POST['menuid'];
    $subcategory = $_POST['subcategory'];
    $name        = $_POST['name'];
    $description = $_POST['description'];
    $rate        = $_POST['rate'];
    $menutype    = $_POST['menutype'];
    $discount    = $_POST['discount'];

    $image = "";
    if (!empty($_FILES['image']['name'])) {
        $image = "../images/" . time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }

    mysqli_query($conn, "
        INSERT INTO menu_master
        (MenuId, MenuSubCategoryName, MenuName, MenuImageUrl, Description, Rate, MenuTypeId, Discount)
        VALUES
        ('$menu_id','$subcategory','$name','$image','$description','$rate','$menutype','$discount')
    ");

    $_SESSION['success'] = "✅ New record added successfully";
    header("Location: menu_items.php");
    exit;
}

/* ---------------- DELETE ITEM ---------------- */
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM menu_master WHERE MenuId='$id'");
    $_SESSION['success'] = "🗑️ Record deleted successfully";
    header("Location: menu_items.php");
    exit;
}

/* ---------------- FETCH ALL ITEMS ---------------- */
$items = mysqli_query($conn, "SELECT * FROM menu_master ORDER BY MenuId ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Menu Items</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body { background: #f6f7fb; }
        .page-card { border-radius: 14px; box-shadow: 0 8px 20px rgba(0,0,0,.05); }
        .menu-img { width:50px;height:50px;object-fit:cover;border-radius:8px;border:1px solid #ddd; }
        .restaurant-logo { max-height:120px; display:block; margin:0 auto 5px; }
        .back-btn { position:absolute; top:15px; left:15px; }
    </style>
</head>

<body>

<a href="dashboard.php" class="btn btn-outline-dark back-btn">← Back</a>

<div class="container-fluid">

    <img src="digus_restaurant.jpeg" class="restaurant-logo">

    <?php if (isset($_SESSION['success'])) { ?>
        <div class="alert alert-success alert-dismissible fade show text-center">
            <?= $_SESSION['success']; ?>
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php unset($_SESSION['success']); } ?>

    <!-- TABLE -->
    <div class="card page-card">
        <div class="card-body">
            <h5 class="text-center fw-semibold">Menu Items</h5>

            <div class="table-responsive">
                <table class="table table-bordered align-middle text-nowrap">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Sub Category</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Description</th>
                            <th>Rate</th>
                            <th>Type</th>
                            <th>Discount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = mysqli_fetch_assoc($items)) { ?>
                        <tr>
                            <td><?= $row['MenuId'] ?></td>
                            <td><?= $row['MenuSubCategoryName'] ?></td>
                            <td><?= $row['MenuName'] ?></td>
                            <td><img src="<?= $row['MenuImageUrl'] ?>" class="menu-img"></td>
                            <td><?= $row['Description'] ?></td>
                            <td><?= $row['Rate'] ?></td>
                            <td><?= $row['MenuTypeId']==1 ? 'Veg' : 'Non-Veg' ?></td>
                            <td><?= $row['Discount'] ?></td>
                            <td>
                                <a href="?edit=<?= $row['MenuId'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="?delete=<?= $row['MenuId'] ?>" onclick="return confirm('Delete?')" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ADD / EDIT FORM -->
    <div class="card page-card mt-4">
        <div class="card-body">

            <h4><?= isset($editData) ? "✏️ Edit Menu Item" : "➕ Add New Menu Item" ?></h4>

            <form method="POST" enctype="multipart/form-data" class="row g-3">

                <div class="col-md-3">
                    <input type="number" name="menuid" class="form-control"
                        value="<?= $editData['MenuId'] ?? '' ?>"
                        <?= isset($editData) ? 'readonly' : '' ?>
                        placeholder="Menu ID" required>
                </div>

                <div class="col-md-3">
                    <input type="text" name="subcategory" class="form-control"
                        value="<?= $editData['MenuSubCategoryName'] ?? '' ?>"
                        placeholder="Sub Category" required>
                </div>

                <div class="col-md-3">
                    <input type="text" name="name" class="form-control"
                        value="<?= $editData['MenuName'] ?? '' ?>"
                        placeholder="Menu Name" required>
                </div>

                <div class="col-md-2">
                    <input type="number" step="0.01" name="rate" class="form-control"
                        value="<?= $editData['Rate'] ?? '' ?>" placeholder="Rate" required>
                </div>

                <div class="col-md-2">
                    <input type="number" step="0.01" name="discount" class="form-control"
                        value="<?= $editData['Discount'] ?? '' ?>" placeholder="Discount">
                </div>

                <div class="col-md-2">
                    <select name="menutype" class="form-control" required>
                        <option value="">Menu Type</option>
                        <option value="1" <?= (isset($editData) && $editData['MenuTypeId']==1)?'selected':'' ?>>Veg</option>
                        <option value="2" <?= (isset($editData) && $editData['MenuTypeId']==2)?'selected':'' ?>>Non-Veg</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <textarea name="description" class="form-control" rows="2"><?= $editData['Description'] ?? '' ?></textarea>
                </div>

                <div class="col-md-6">
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="col-12 text-center">
                    <?php if (isset($editData)) { ?>
                        <button type="submit" name="update" class="btn btn-warning px-4">Update</button>
                        <a href="menu_items.php" class="btn btn-secondary ms-2">Cancel</a>
                    <?php } else { ?>
                        <button type="submit" name="add" class="btn btn-success px-4">Add Item</button>
                    <?php } ?>
                </div>

            </form>
        </div>
    </div>

</div>

<script>
setTimeout(()=>{ document.querySelector('.alert')?.remove(); },3000);
</script>

</body>
</html>
