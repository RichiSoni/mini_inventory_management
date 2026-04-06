# mini_inventory_management

A simple Inventory Management System built with **vanilla PHP** and **MySQL**. Supports user authentication, product CRUD with image uploads, search, and pagination.

---

## Features

-  User Registration & Login with session-based authentication
-  Product management — Add, Edit, Delete, List
-  Search products by name, price, or quantity
-  Pagination on product listing
-  Image upload support (JPG/PNG, max 2MB)
-  CSRF protection on all write operations
-  Password hashing with `password_hash()`
-  Server-side form validation with old input flash

---

## Tech Stack

- **PHP** >= 7.4
- **MySQL** — Database
- **PDO** — Database access (prepared statements)
- **HTML/CSS** — Frontend (no framework)

---

## ⚙️ Installation & Setup

### 1. Clone the repository

```bash
git clone https://github.com/RichiSoni/mini_inventory_management.git
cd mini_inventory_management
```

### 2. Create the database

Import the provided SQL file into your MySQL server:

```bash
mysql -u root -p < database.sql
```

Or open **phpMyAdmin** and import `database.sql` manually.

### 3. Configure database connection

Open `config/database.php` and update your credentials:

```php
$host     = "localhost";
$dbname   = "mini_inventory_management";
$username = "root";
$password = "";
```

### 4. Create the uploads folder

Make sure the `uploads/` directory exists and is writable:

```bash
mkdir uploads
chmod 755 uploads
```

### 5. Start a local server

place the project inside your **XAMPP/WAMP** `htdocs` folder and access it via `http://localhost/mini_inventory_management`.

---

## 📁 Project Structure

```
mini_inventory_management/
├── auth/
│   ├── login.php               # Login form
│   ├── login_process.php       # Login logic
│   ├── logout.php              # Session destroy
│   ├── register.php            # Registration form
│   └── register_process.php   # Registration logic
├── config/
│   ├── database.php            # PDO connection
│   └── csrf.php                # CSRF token helpers
├── products/
│   ├── list.php                # Product listing with search & pagination
│   ├── add.php                 # Add product form
│   ├── add_process.php         # Add product logic
│   ├── edit.php                # Edit product form
│   ├── update.php              # Update product logic
│   └── delete.php              # Delete product logic
├── uploads/                    # Uploaded product images
├── dashboard.php               # Home page after login
├── index.php                   # Entry point (redirects based on auth)
└── database.sql                # Database schema
```

---

## Authentication Flow

1. Visit `/index.php` — redirects to login if not authenticated
2. Register a new account at `/auth/register.php`
3. Login at `/auth/login.php` — session is created on success
4. Logout at `/auth/logout.php` — session is destroyed

---

## Product Management

| Action | URL |
|--------|-----|
| List products | `products/list.php` |
| Add product | `products/add.php` |
| Edit product | `products/edit.php?id={id}` |
| Delete product | `products/delete.php` (POST) |

**Supported image types:** JPG, PNG — max **2MB**

---

## Validation Rules

**Registration:**

| Field | Rules |
|-------|-------|
| `name` | Required |
| `email` | Required, valid email, unique |
| `password` | Required, min 6 characters |
| `confirm_password` | Required, must match password |

**Product:**

| Field | Rules |
|-------|-------|
| `name` | Required |
| `price` | Required, numeric, >= 0 |
| `quantity` | Required, numeric, >= 0 |
| `image` | Required on add, JPG/PNG only, max 2MB |

---

## Security

- Passwords stored using `password_hash()` (bcrypt)
- All DB queries use **PDO prepared statements** (no SQL injection)
- **CSRF tokens** on all POST forms
- Session-based auth guard on all protected pages

---
