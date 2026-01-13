<?php
session_start();
include("connection.php");

// Check admin session
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit;
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
        body { background:#f6f7fb; }
        .page-card { border-radius:14px; box-shadow:0 8px 20px rgba(0,0,0,.05); }
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
                <table class="table table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Sub Category</th>
                            <th>Name</th>
                            <th>Image</th>
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
                            <td><?= $row['Rate'] ?></td>
                            <td><?= $row['MenuTypeId']==1?'Veg':'Non-Veg' ?></td>
                            <td><?= $row['Discount'] ?></td>
                            <td>
                                <button
                                    class="btn btn-warning btn-sm editBtn"
                                    data-id="<?= $row['MenuId'] ?>"
                                    data-sub="<?= $row['MenuSubCategoryName'] ?>"
                                    data-name="<?= $row['MenuName'] ?>"
                                    data-desc="<?= $row['Description'] ?>"
                                    data-rate="<?= $row['Rate'] ?>"
                                    data-type="<?= $row['MenuTypeId'] ?>"
                                    data-discount="<?= $row['Discount'] ?>"
                                >Edit</button>

                                <a href="?delete=<?= $row['MenuId'] ?>"
                                   onclick="return confirm('Delete?')"
                                   class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ADD FORM -->
    <div class="card page-card mt-4">
        <div class="card-body">
            <h4>➕ Add New Menu Item</h4>

            <form method="POST" enctype="multipart/form-data" class="row g-3">
                <div class="col-md-3">
                    <input type="number" name="menuid" class="form-control" placeholder="Menu ID" required>
                </div>
                <div class="col-md-3">
                    <input type="text" name="subcategory" class="form-control" placeholder="Sub Category" required>
                </div>
                <div class="col-md-3">
                    <input type="text" name="name" class="form-control" placeholder="Menu Name" required>
                </div>
                <div class="col-md-2">
                    <input type="number" step="0.01" name="rate" class="form-control" placeholder="Rate" required>
                </div>
                <div class="col-md-2">
                    <input type="number" step="0.01" name="discount" class="form-control" placeholder="Discount">
                </div>
                <div class="col-md-2">
                    <select name="menutype" class="form-control" required>
                        <option value="">Menu Type</option>
                        <option value="1">Veg</option>
                        <option value="2">Non-Veg</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <textarea name="description" class="form-control" rows="2" placeholder="Description"></textarea>
                </div>
                <div class="col-md-6">
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="col-12 text-center">
                    <button type="submit" name="add" class="btn btn-success px-4">Add Item</button>
                </div>
            </form>
        </div>
    </div>

</div>

<!-- EDIT MODAL -->
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">✏️ Edit Menu Item</h5>
          <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body row g-3">
          <input type="hidden" name="menuid" id="edit_menuid">

          <div class="col-md-4">
            <input type="text" name="subcategory" id="edit_sub" class="form-control" required>
          </div>
          <div class="col-md-4">
            <input type="text" name="name" id="edit_name" class="form-control" required>
          </div>
          <div class="col-md-4">
            <input type="number" step="0.01" name="rate" id="edit_rate" class="form-control" required>
          </div>
          <div class="col-md-4">
            <input type="number" step="0.01" name="discount" id="edit_discount" class="form-control">
          </div>
          <div class="col-md-4">
            <select name="menutype" id="edit_type" class="form-control">
              <option value="1">Veg</option>
              <option value="2">Non-Veg</option>
            </select>
          </div>
          <div class="col-md-12">
            <textarea name="description" id="edit_desc" class="form-control" rows="2"></textarea>
          </div>
          <div class="col-md-12">
            <input type="file" name="image" class="form-control">
            <small class="text-muted">Leave empty to keep old image</small>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" name="update" class="btn btn-warning">Update</button>
          <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.querySelectorAll('.editBtn').forEach(btn => {
    btn.onclick = function () {
        edit_menuid.value = this.dataset.id;
        edit_sub.value = this.dataset.sub;
        edit_name.value = this.dataset.name;
        edit_desc.value = this.dataset.desc;
        edit_rate.value = this.dataset.rate;
        edit_discount.value = this.dataset.discount;
        edit_type.value = this.dataset.type;
        new bootstrap.Modal(editModal).show();
    };
});
</script>

</body>
</html>
