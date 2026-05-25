<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> - E-Commerce Store</title>
    <link rel="stylesheet" href="<?php echo url('/css/style.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php require_once __DIR__ . '/partials/nav.view.php'; ?>

    <div class="admin-container">
        <div class="admin-welcome">
            <div><h1>Products</h1><p>Manage your product inventory</p></div>
            <span class="admin-badge"><?php echo count($products); ?> total products</span>
        </div>

        <div class="admin-card">
            <table class="admin-table">
                <thead>
                    <tr><th>ID</th><th>Product</th><th>Category</th><th>Price</th><th>Stock</th><th>Status</th><th>Added</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td>#<?php echo $product['product_id']; ?></td>
                            <td><strong><?php echo htmlspecialchars($product['product_name']); ?></strong></td>
                            <td><?php echo htmlspecialchars($product['category_name'] ?? 'N/A'); ?></td>
                            <td>$<?php echo number_format($product['price'], 2); ?></td>
                            <td>
                                <span class="list-badge <?php echo $product['stock_quantity'] <= 5 ? 'badge-danger' : ($product['stock_quantity'] <= 20 ? 'badge-warning' : 'badge-success'); ?>">
                                    <?php echo $product['stock_quantity']; ?>
                                </span>
                            </td>
                            <td><span class="order-status status-<?php echo $product['status'] === 'available' ? 'completed' : ($product['status'] === 'out_of_stock' ? 'cancelled' : 'pending'); ?>"><?php echo ucfirst(str_replace('_', ' ', $product['status'])); ?></span></td>
                            <td><?php echo date('M j, Y', strtotime($product['created_at'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php require_once __DIR__ . '/../../includes/footer.php'; ?>
</body>
</html>
