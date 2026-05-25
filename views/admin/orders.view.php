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
            <div><h1>Orders</h1><p>Manage customer orders and update statuses</p></div>
            <span class="admin-badge"><?php echo count($orders); ?> total orders</span>
        </div>

        <?php if ($flash): ?>
            <div class="alert alert-<?php echo $flash['type']; ?>">
                <i class="fas fa-<?php echo $flash['type'] === 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                <span><?php echo $flash['message']; ?></span>
            </div>
        <?php endif; ?>

        <div class="admin-card">
            <table class="admin-table">
                <thead>
                    <tr><th>Order</th><th>Customer</th><th>Items</th><th>Total</th><th>Payment</th><th>Status</th><th>Date</th><th>Action</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <?php $sc = $status_config[$order['order_status']] ?? $status_config['pending']; ?>
                        <tr>
                            <td><strong>#<?php echo str_pad($order['order_id'], 6, '0', STR_PAD_LEFT); ?></strong></td>
                            <td>
                                <div><?php echo htmlspecialchars($order['full_name']); ?></div>
                                <small style="color:#718096;"><?php echo htmlspecialchars($order['email']); ?></small>
                            </td>
                            <td><?php echo $order['total_items'] ?? $order['item_count']; ?></td>
                            <td><strong>$<?php echo number_format($order['total_amount'], 2); ?></strong></td>
                            <td><?php echo $payment_labels[$order['payment_method']] ?? $order['payment_method']; ?></td>
                            <td><span class="order-status <?php echo $sc['class']; ?>"><i class="fas fa-<?php echo $sc['icon']; ?>"></i> <?php echo ucfirst($order['order_status']); ?></span></td>
                            <td><?php echo date('M j, Y', strtotime($order['order_date'])); ?></td>
                            <td>
                                <form method="POST" action="<?php echo url('/admin/orders.php'); ?>" class="status-form">
                                    <input type="hidden" name="action" value="update_status">
                                    <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                    <select name="new_status" class="status-select" onchange="this.form.submit()">
                                        <option value="">Change...</option>
                                        <option value="pending" <?php echo $order['order_status'] === 'pending' ? 'disabled' : ''; ?>>Pending</option>
                                        <option value="processing" <?php echo $order['order_status'] === 'processing' ? 'disabled' : ''; ?>>Processing</option>
                                        <option value="completed" <?php echo $order['order_status'] === 'completed' ? 'disabled' : ''; ?>>Completed</option>
                                        <option value="cancelled" <?php echo $order['order_status'] === 'cancelled' ? 'disabled' : ''; ?>>Cancelled</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php require_once __DIR__ . '/../../includes/footer.php'; ?>
</body>
</html>
