<?php
// Include header
include_once 'header.php';

// Check if user is not logged in, redirect to login page
include_once 'auth.php';
if (!isLoggedIn()) {
    redirectToLogin();
}

// Include database connection
include_once 'db.php';

// Fetch products from database
$query = "SELECT * FROM products";
$result = $conn->query($query);
?>

<div class="container mt-5">
    <h2>Manage Products</h2>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addProductModal">Add Product</button>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td>$<?php echo number_format($row['price'], 2); ?></td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td>
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editProductModal<?php echo $row['id']; ?>">Edit</button>
                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteProductModal<?php echo $row['id']; ?>">Delete</button>
                        </td>
                    </tr>
                    <!-- Edit Product Modal -->
                    <div class="modal fade" id="editProductModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editProductModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editProductModalLabel<?php echo $row['id']; ?>">Edit Product</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Edit product form -->
                                    <form action="process_edit_product.php" method="POST">
                                        <input type="hidden" name="productId" value="<?php echo $row['id']; ?>">
                                        <div class="mb-3">
                                            <label for="productName" class="form-label">Product Name</label>
                                            <input type="text" class="form-control" id="productName" name="productName" value="<?php echo $row['name']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="productPrice" class="form-label">Price</label>
                                            <input type="number" class="form-control" id="productPrice" name="productPrice" value="<?php echo $row['price']; ?>" step="0.01" min="0" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="productQuantity" class="form-label">Quantity</label>
                                            <input type="number" class="form-control" id="productQuantity" name="productQuantity" value="<?php echo $row['quantity']; ?>" min="0" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Delete Product Modal -->
                    <div class="modal fade" id="deleteProductModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteProductModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteProductModalLabel<?php echo $row['id']; ?>">Delete Product</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Confirm deletion message -->
                                    <p>Are you sure you want to delete this product?</p>
                                    <!-- Delete product form -->
                                    <form action="process_delete_product.php" method="POST">
                                        <input type="hidden" name="productId" value="<?php echo $row['id']; ?>">
                                        <button type="submit" class="btn btn-danger">Delete Product</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
            } else { ?>
                <tr>
                    <td colspan="5">No products found.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Add product form -->
                <form action="process_add_product.php" method="POST">
                    <div class="mb-3">
                        <label for="productName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="productName" name="productName" required>
                    </div>
                    <div class="mb-3">
                        <label for="productPrice" class="form-label">Price</label>
                        <input type="number" class="form-control" id="productPrice" name="productPrice" step="0.01" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="productQuantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="productQuantity" name="productQuantity" min="0" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>