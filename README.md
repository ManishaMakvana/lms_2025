# Tinkering LMS - Learning Management System

A comprehensive Laravel 12-based Learning Management System for hands-on tinkering and maker education.

## 🚀 Features

- **Kit Activation Codes**: Generate unique codes (format: XX-XXXXXX)
- **Modular Learning**: Tinkering modules with sub-activities
- **Progress Tracking**: Real-time progress with checklists
- **Role-based Access**: Admin, Trainer, Student roles
- **Google OAuth**: Social login integration
- **Admin Dashboard**: Complete management panel

## 📋 Requirements

- PHP 8.2+
- Laravel 12
- MySQL 8.0+
- Composer
- Node.js & NPM

## 🛠️ Installation

### 1. Install Dependencies
```bash
composer install
npm install
```

### 2. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Database Setup
```bash
php artisan migrate
php artisan db:seed
```

### 4. Build Assets
```bash
npm run build
```

## 🎯 Quick Start

### Default Admin Credentials
- **Email**: admin@tinkeringlms.com
- **Password**: password

### Sample Kit Codes
- **TE-000001** (Tinkering Electro Basics)
- **TP-000001** (Tinkering Programming)

## 🛠️ Commands

### Generate Kit Codes
```bash
php artisan tinkering:generate-codes TE 10
php artisan tinkering:generate-codes TP 5 --module=2
```

### Start Development
```bash
php artisan serve
php artisan queue:work
```

## 📊 Database Schema

- **users**: User accounts with roles
- **tinkering_modules**: Learning modules
- **tinkering_module_sub_activities**: Activities within modules
- **activity_checklists**: Progress tracking
- **kit_activation_codes**: Unique access codes
- **user_activity_progress**: User progress data

## 🧪 Testing

```bash
php artisan test
```

## 📝 License

MIT License