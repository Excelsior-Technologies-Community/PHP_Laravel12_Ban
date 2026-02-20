# PHP_Laravel12_Ban
## Project Overview

Laravel Ban System is a complete user restriction and moderation module built with Laravel 12.

This system allows administrators to:

* Ban users temporarily or permanently
* Track full ban history
* Store ban reasons
* Automatically expire temporary bans
* Restrict banned users from accessing protected routes
* Manage bans via admin dashboard

The system includes authentication, middleware protection, service layer logic, and Bootstrap-based UI.

---

## Step 1 – Install Fresh Laravel

```bash
composer create-project laravel/laravel laravel-ban-system
cd laravel-ban-system
```

---

## Step 2 – Configure Database (.env)

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_ban
DB_USERNAME=root
DB_PASSWORD=
```

Create the database manually in MySQL.

---

## Step 3 – Create Migrations

### 1. Add Ban Columns to Users Table

```bash
php artisan make:migration add_ban_columns_to_users_table
```

Fields Added:

* is_banned (boolean)
* banned_until (timestamp)
* ban_reason (text)
* banned_by (foreign key to users)
* is_admin (boolean)

---

### 2. Create Ban History Table

```bash
php artisan make:migration create_ban_history_table
```

Table: ban_history

Columns:

* id
* user_id
* banned_by
* unbanned_by
* ban_reason
* unban_reason
* banned_at
* unbanned_at
* ban_until
* timestamps

---

## Step 4 – Models

### User Model Enhancements

Add:

* isBanned() helper method
* Relationship: bannedBy()
* Relationship: banHistory()
* Casts for datetime and boolean fields

The isBanned() method automatically removes expired temporary bans.

---

### BanHistory Model

Tracks:

* Who banned the user
* Who unbanned the user
* Reason
* Ban duration
* Timestamps

---

## Step 5 – Middleware

### CheckBanned Middleware

* Logs out banned users
* Displays ban reason
* Shows ban expiration date
* Prevents access to protected routes

---

### Admin Middleware

* Allows only users with is_admin = true
* Returns 403 if unauthorized

---

## Step 6 – Register Middleware

Register aliases inside bootstrap/app.php:

* check.banned
* admin

---

## Step 7 – BanService (Business Logic Layer)

Responsibilities:

* Ban user (transaction-safe)
* Unban user
* Maintain ban history
* Fetch banned users
* Fetch available users
* Retrieve full history for a user

Uses database transactions to ensure consistency.

---

## Step 8 – Admin BanController

Controller Methods:

* index() – List banned users
* create() – Show ban form
* store() – Ban user
* show() – Show ban history
* update() – Unban user

Located at:

```
app/Http/Controllers/Admin/BanController.php
```

---

## Step 9 – Routes

Protected User Routes:

* auth
* verified
* check.banned

Admin Routes:

* auth
* verified
* check.banned
* admin

Prefix: /admin

---

## Step 10 – Views

Structure:

```
resources/views/
├── layouts/app.blade.php
├── dashboard.blade.php
└── admin/bans/
    ├── index.blade.php
    ├── create.blade.php
    └── show.blade.php
```

UI Built With:

* Bootstrap 5
* Modal forms
* Pagination
* Flash messages

---

## Step 11 – Install Authentication (Laravel Breeze)

```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run dev
```

---

## Step 12 – Create Admin Seeder

```bash
php artisan make:seeder AdminUserSeeder
```

Creates:

* Admin User
* Regular User

---

## Step 13 – Run Migrations and Seeders

```bash
php artisan migrate
php artisan db:seed --class=AdminUserSeeder
```

---

## Step 14 – Clear Cache

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

---

## Step 15 – Start Application

```bash
php artisan serve
```

Visit:

```
http://127.0.0.1:8000
```
<img width="1310" height="373" alt="image" src="https://github.com/user-attachments/assets/f455b9e3-5dca-4c41-85fa-2fc04a13adc9" />
<img width="1606" height="391" alt="image" src="https://github.com/user-attachments/assets/e001b9ae-4cf2-49db-8d76-e1f31c455f5b" />
<img width="1919" height="758" alt="image" src="https://github.com/user-attachments/assets/47adc7a4-bfee-4c75-8ce6-dacf69468173" />
<img width="943" height="534" alt="image" src="https://github.com/user-attachments/assets/e0611dad-8cf3-4aa2-aacb-3eda88ed274c" />
<img width="1551" height="576" alt="image" src="https://github.com/user-attachments/assets/f49b2c6d-c03d-4117-a036-a85ed425b634" />

---

## Testing Flow

1. Login as Admin
2. Navigate to Ban Management
3. Ban Regular User
4. Attempt login as banned user (access denied)
5. Unban user
6. Login restored

---

## Key Features

* User authentication
* Admin role protection
* Ban check middleware
* Temporary bans
* Permanent bans
* Full ban history tracking
* Automatic expiration logic
* Clean Bootstrap UI

---

## Real-World Use Cases

* Community moderation systems
* SaaS user control
* Subscription enforcement
* Policy violation handling
* Enterprise access management

---

This Laravel Ban System demonstrates a production-ready moderation architecture suitable for enterprise applications and scalable user management systems.

