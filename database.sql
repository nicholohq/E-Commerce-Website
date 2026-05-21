-- =============================================
-- E-COMMERCE WEBSITE DATABASE
-- Final Project Database Schema
-- =============================================

-- Drop database if exists (for fresh install)
DROP DATABASE IF EXISTS ecommerce_website;

-- Create new database
CREATE DATABASE IF NOT EXISTS ecommerce_website;
USE ecommerce_website;

-- =============================================
-- TABLE 1: users (customers and admin)
-- =============================================
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    user_type ENUM('customer', 'admin') DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- =============================================
-- TABLE 2: categories
-- =============================================
CREATE TABLE categories (
    category_id INT PRIMARY KEY AUTO_INCREMENT,
    category_name VARCHAR(50) UNIQUE NOT NULL,
    description TEXT,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =============================================
-- TABLE 3: products
-- =============================================
CREATE TABLE products (
    product_id INT PRIMARY KEY AUTO_INCREMENT,
    product_name VARCHAR(200) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL CHECK (price >= 0),
    stock_quantity INT DEFAULT 0 CHECK (stock_quantity >= 0),
    product_image VARCHAR(255),
    category_id INT,
    status ENUM('available', 'out_of_stock', 'discontinued') DEFAULT 'available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (category_id) REFERENCES categories(category_id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);

-- =============================================
-- TABLE 4: orders
-- =============================================
CREATE TABLE orders (
    order_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total_amount DECIMAL(10, 2) NOT NULL CHECK (total_amount >= 0),
    order_status ENUM('pending', 'processing', 'completed', 'cancelled') DEFAULT 'pending',
    shipping_address TEXT NOT NULL,
    payment_method VARCHAR(50) DEFAULT 'cash_on_delivery',
    notes TEXT,
    
    FOREIGN KEY (user_id) REFERENCES users(user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- =============================================
-- TABLE 5: order_items
-- =============================================
CREATE TABLE order_items (
    order_item_id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL CHECK (quantity > 0),
    unit_price DECIMAL(10, 2) NOT NULL CHECK (unit_price >= 0),
    subtotal DECIMAL(10, 2) GENERATED ALWAYS AS (quantity * unit_price) STORED,
    
    FOREIGN KEY (order_id) REFERENCES orders(order_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);

-- =============================================
-- TABLE 6: cart (shopping cart)
-- =============================================
CREATE TABLE cart (
    cart_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL CHECK (quantity > 0),
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    
    UNIQUE KEY unique_cart_item (user_id, product_id)
);

-- =============================================
-- INDEXES for better performance
-- =============================================
CREATE INDEX idx_user_email ON users(email);
CREATE INDEX idx_product_category ON products(category_id);
CREATE INDEX idx_product_status ON products(status);
CREATE INDEX idx_order_user ON orders(user_id);
CREATE INDEX idx_order_date ON orders(order_date);
CREATE INDEX idx_order_status ON orders(order_status);
CREATE INDEX idx_cart_user ON cart(user_id);

-- =============================================
-- INSERT SAMPLE DATA
-- =============================================

-- Insert Admin User (password: admin123)
INSERT INTO users (full_name, email, password_hash, phone, address, user_type) VALUES
('Admin User', 'admin@ecommerce.com', 'admin123', '09123456789', 'Admin Office, Main Street', 'admin');

-- Insert Test Customer (password: customer123)
INSERT INTO users (full_name, email, password_hash, phone, address, user_type) VALUES
('John Doe', 'customer@example.com', 'customer123', '09876543210', '123 Customer St, Manila', 'customer');

-- Insert Categories
INSERT INTO categories (category_name, description, status) VALUES
('Electronics', 'Gadgets, devices, and electronic items', 'active'),
('Clothing', 'Fashion apparel and accessories', 'active'),
('Books', 'Educational and recreational books', 'active'),
('Home & Living', 'Furniture, decor, and household items', 'active');

-- Insert Products
INSERT INTO products (product_name, description, price, stock_quantity, category_id, status) VALUES
('iPhone 15 Pro', 'Latest Apple smartphone with A17 chip', 999.99, 50, 1, 'available'),
('Samsung Galaxy S24', 'Premium Android smartphone', 899.99, 45, 1, 'available'),
('MacBook Pro 14"', 'Powerful laptop for professionals', 1999.99, 30, 1, 'available'),
('Cotton T-Shirt', 'Comfortable 100% cotton t-shirt', 19.99, 100, 2, 'available'),
('Jeans Pants', 'Classic blue denim jeans', 49.99, 75, 2, 'available'),
('Python Programming', 'Learn Python from scratch', 39.99, 50, 3, 'available'),
('Web Development Guide', 'Complete HTML, CSS, JavaScript guide', 45.99, 40, 3, 'available'),
('Desk Lamp', 'LED desk lamp with adjustable brightness', 29.99, 60, 4, 'available'),
('Coffee Mug', 'Ceramic coffee mug 350ml', 9.99, 200, 4, 'available');

-- Insert a sample order
INSERT INTO orders (user_id, total_amount, order_status, shipping_address, payment_method) VALUES
(2, 1069.98, 'completed', '123 Customer St, Manila', 'cash_on_delivery');

INSERT INTO order_items (order_id, product_id, quantity, unit_price) VALUES
(1, 1, 1, 999.99),
(1, 4, 3, 19.99);

-- =============================================
-- VERIFY DATA (Run these SELECT queries to check)
-- =============================================
SELECT 'Users:' as 'Checking:', COUNT(*) as 'Count' FROM users
UNION ALL
SELECT 'Categories:', COUNT(*) FROM categories
UNION ALL
SELECT 'Products:', COUNT(*) FROM products
UNION ALL
SELECT 'Orders:', COUNT(*) FROM orders
UNION ALL
SELECT 'Order Items:', COUNT(*) FROM order_items;