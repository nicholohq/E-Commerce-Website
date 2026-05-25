<?php
// admin/orders.php - Admin Orders Management Controller
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/session.php';

requireAdmin();

$pageTitle = 'Manage Orders';
$activePage = 'orders';
$flash = getFlashMessage();

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    $order_id = intval($_POST['order_id'] ?? 0);
    $new_status = $_POST['new_status'] ?? '';
    $allowed = ['pending', 'processing', 'completed', 'cancelled'];

    if ($order_id > 0 && in_array($new_status, $allowed)) {
        $stmt = $pdo->prepare("UPDATE orders SET order_status = ? WHERE order_id = ?");
        $stmt->execute([$new_status, $order_id]);
        setFlashMessage('success', "Order #" . str_pad($order_id, 6, '0', STR_PAD_LEFT) . " status updated to " . ucfirst($new_status));
    } else {
        setFlashMessage('error', 'Invalid order or status.');
    }
    header('Location: ' . url('/admin/orders.php'));
    exit;
}

// Fetch all orders with user info
$orders = $pdo->query("
    SELECT o.*, u.full_name, u.email,
           COUNT(oi.order_item_id) as item_count,
           SUM(oi.quantity) as total_items
    FROM orders o
    JOIN users u ON o.user_id = u.user_id
    LEFT JOIN order_items oi ON o.order_id = oi.order_id
    GROUP BY o.order_id
    ORDER BY o.order_date DESC
")->fetchAll();

$payment_labels = ['cash_on_delivery' => 'COD', 'bank_transfer' => 'Bank', 'gcash' => 'GCash', 'credit_card' => 'Card'];
$status_config = [
    'pending' => ['class' => 'status-pending', 'icon' => 'clock'],
    'processing' => ['class' => 'status-processing', 'icon' => 'spinner'],
    'completed' => ['class' => 'status-completed', 'icon' => 'check-circle'],
    'cancelled' => ['class' => 'status-cancelled', 'icon' => 'times-circle']
];

// Render view
require_once __DIR__ . '/../views/admin/orders.view.php';
