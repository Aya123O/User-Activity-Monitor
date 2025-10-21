User Activity Tracking & Inactivity Monitoring System
https://img.shields.io/badge/Laravel-12.34.0-FF2D20?style=for-the-badge&logo=laravel
https://img.shields.io/badge/PHP-8.3.6-777BB4?style=for-the-badge&logo=php
https://img.shields.io/badge/Bootstrap-5.3.0-7952B3?style=for-the-badge&logo=bootstrap
https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql
https://img.shields.io/badge/License-MIT-green?style=for-the-badge

A comprehensive Laravel-based system for monitoring user activities, tracking inactivity, and enforcing security policies with automated penalty systems.

 Quick Start
Prerequisites
PHP 8.1+

MySQL 8.0+

Composer 2.0+

Node.js 16.0+

Installation
bash
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
 Features
Real-time Activity Tracking - Monitor user actions, logins, file operations

Inactivity Monitoring - Automatic warnings and session termination

Penalty System - Progressive penalties for violations

Admin Dashboard - Comprehensive analytics and user management

Security Features - CSRF protection, XSS prevention, role-based access

 Default Settings
Setting	Value	Description
First Warning	5 seconds	Initial inactivity alert
Final Warning	10 seconds	Countdown before logout
Auto Logout	15 seconds	Session termination
 User Roles
Admin Users:

Full system access

User management

Activity logs review

System configuration

Regular Users:

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
 API Endpoints
http
# Activity monitoring
POST /api/inactivity-log
GET /api/user-stats

# User management  
GET/POST/PUT/DELETE /api/users
 Production Deployment
bash
# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Queue worker
php artisan queue:work --daemon
 testing
bash
# Run tests
php artisan test

# With coverage
php artisan test --coverage-html coverage/
 Contributing
Fork the repository

Create feature branch (git checkout -b feature/AmazingFeature)

Commit changes (git commit -m 'Add AmazingFeature')

Push to branch (git push origin feature/AmazingFeature)

Open Pull Request

