# 🛒 E-Commerce Website - Final Project

## Project Status: 🟢 Database Layer Complete

**Last Updated:** May 21, 2026

---

## 📋 Project Overview

A fully functional basic e-commerce website that allows users to browse products, add items to a cart, and simulate the checkout process. The system includes an admin panel for managing products and orders.

---

## ✅ Completed Work (Database Design & Integration)

- ✅ Database schema designed with 6 core tables
- ✅ Foreign key relationships established
- ✅ Indexes added for query optimization
- ✅ Sample data populated for testing
- ✅ GitHub repository configured
- ✅ PHP environment configured
- ✅ Database connection working

### Tables Created

| Table | Records | Description |
|-------|---------|-------------|
| users | 2 | Admin + customer accounts |
| categories | 4 | Product categories |
| products | 9 | Sample products |
| orders | 1 | Sample order |
| order_items | 2 | Order details |
| cart | 0 | Shopping cart (empty) |

### Database Credentials

| Parameter | Value |
|-----------|-------|
| Database Name | `ecommerce_website` |
| Host | `127.0.0.1` or `localhost` |
| Port | `3306` |
| Username | `root` |
| Password | `root` |

---

## 🚀 Complete Setup Instructions

Copy and paste these commands in order:

```bash
# 1. Clone the repository
git clone https://github.com/nicholohq/E-Commerce-Website.git
cd E-Commerce-Website

# 2. Import database (run this in MySQL Workbench or phpMyAdmin)
# Create database and run the database.sql file

# 3. Configure database connection
# Edit config/database.php and set:
# $host = '127.0.0.1';
# $dbname = 'ecommerce_website';
# $username = 'root';
# $password = 'root';

# 4a. Start server using XAMPP
# Move folder to C:\xampp\htdocs\E-Commerce-Website
# Start Apache and MySQL in XAMPP Control Panel
# Open browser to http://localhost/E-Commerce-Website/

# 4b. OR start server using PHP built-in
php -S localhost:8080

# 5. Test the connection
# Open browser to http://localhost:8080/test_db.php
