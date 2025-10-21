# User Activity Tracking & Inactivity Monitoring System

![Laravel](https://img.shields.io/badge/Laravel-12.34.0-FF2D20?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.3.6-777BB4?style=for-the-badge&logo=php)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3.0-7952B3?style=for-the-badge&logo=bootstrap)

A comprehensive enterprise-grade monitoring system built with Laravel that tracks user activities, monitors inactivity, and automatically enforces security policies with penalty systems.

## 🚀 Features

### Core Functionality
- **Real-time Activity Tracking** - Monitor all user actions (CRUD operations, logins, uploads, downloads)
- **Intelligent Inactivity Monitoring** - Automatic session management with configurable timeouts
- **Automated Penalty System** - Progressive penalties for repeated violations
- **Role-based Access Control** - Separate admin and user interfaces
- **Comprehensive Audit Logs** - Detailed activity history with device/browser information

### Security & Monitoring
- **Multi-stage Inactivity Alerts** - Visual warnings before automatic logout
- **IP & Device Tracking** - Monitor user access patterns and locations
- **Automatic Session Termination** - Configurable timeout-based logout
- **Violation Escalation** - Progressive penalty system for repeated offenses

### Admin Dashboard
- **Real-time Statistics** - Live user activity and system metrics
- **User Management** - Complete CRUD operations with role management
- **Activity Logs** - Searchable, filterable activity history
- **Penalty Management** - View and manage user penalties
- **System Configuration** - Customizable monitoring parameters

## 📋 System Requirements

- **PHP**: 8.1 or higher
- **Laravel**: 12.34.0
- **Database**: MySQL 8.0+ / PostgreSQL / SQLite
- **Composer**: 2.0 or higher
- **Node.js**: 16.0 or higher (for frontend assets)

## 🛠 Installation
# Clone repository
git clone https://github.com/your-organization/user-activity-monitor.git
cd user-activity-monitor

# Install dependencies
composer install
npm install && npm run build

# Setup environment
cp .env.example .env
php artisan key:generate

# Configure database in .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=activity_monitor
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Setup database
php artisan migrate --seed
php artisan storage:link

# Start development server
php artisan serve

## ⚙️ Default Settings
Setting	Value	Description
First Warning	5 seconds	Initial inactivity alert
Final Warning	10 seconds	Countdown before logout
Auto Logout	15 seconds	Session termination

## 👥 User Roles
# Admin Users:

Full system access

User management

Activity logs review

System configuration

# Regular Users:

Personal dashboard

Activity history

Profile management
🛠 Usage
Log User Activity
php
ActivityLogService::logActivity(
    $user,
    'custom_action',
    $model,
    $oldValues,
    $newValues,
    'Action description'
);
Frontend Monitoring
javascript
const monitor = new InactivityMonitor();
monitor.updateTimeouts(5, 10, 15);
📊 API Endpoints
http
# Activity monitoring
POST /api/inactivity-log
GET /api/user-stats

# User management  
GET/POST/PUT/DELETE /api/users
🚀 Production Deployment
bash
# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Queue worker
php artisan queue:work --daemon
🧪 Testing
bash
# Run tests
php artisan test

# With coverage
php artisan test --coverage-html coverage/
## 🤝 Contributing
Fork the repository

Create feature branch (git checkout -b feature/AmazingFeature)

Commit changes (git commit -m 'Add AmazingFeature')

Push to branch (git push origin feature/AmazingFeature)

Open Pull Request

## 📄 License
This project is licensed under the MIT License - see LICENSE.md for details.


