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

### 1. Clone Repository
```bash
git clone https://github.com/your-organization/user-activity-monitor.git
cd user-activity-monitor
2. Install Dependencies
bash
composer install
npm install
npm run build
3. Environment Configuration
bash
cp .env.example .env
php artisan key:generate
Update .env with your database credentials:

env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=activity_monitor
DB_USERNAME=your_username
DB_PASSWORD=your_password
4. Database Setup
bash
php artisan migrate
php artisan db:seed
5. Storage Setup
bash
php artisan storage:link
6. Application Setup
bash
php artisan optimize:clear
php artisan serve
🔧 Configuration
Default System Settings
The system includes pre-configured settings:

Setting	Default Value	Description
idle_timeout	5 seconds	First inactivity warning
idle_warning_timeout	10 seconds	Final warning before logout
idle_logout_timeout	15 seconds	Automatic logout timeout
activity_monitoring_enabled	true	Enable activity tracking
inactivity_penalty_enabled	true	Enable penalty system
Customization
Modify settings via Admin Panel → System Configuration or update system_settings table directly.

👥 User Roles
Admin Users
Access to all system features

User management and role assignment

View all activity logs and penalties

System configuration access

Export and reporting capabilities

Regular Users
Personal activity dashboard

View own activity history

Profile management

Limited to assigned permissions

📊 Activity Tracking
Tracked Actions
Authentication: Login, logout, session events

CRUD Operations: Create, read, update, delete actions

File Operations: Uploads, downloads, file management

System Events: Profile updates, password changes

Custom Actions: Any user-initiated system interaction

Data Captured
User identification

Action type and description

Timestamp with timezone

IP address and geolocation

Browser and device information

Before/after values for updates

⚠️ Inactivity Monitoring
Alert System
First Alert (5 seconds): Visual warning message

Final Warning (10 seconds): Prominent warning with countdown

Auto Logout (15 seconds): Session termination with penalty

Penalty System
First Offense: Warning logged

Second Offense: Temporary restrictions

Third+ Offense: Progressive penalties

Administrative Review: Manual intervention available

🎨 Frontend Technology Stack
Bootstrap 5.3 - Responsive UI framework

Font Awesome 6 - Icon library

Vanilla JavaScript - Client-side interactions

jQuery - DOM manipulation (optional)

Alpine.js - Reactive components (optional)

Tailwind CSS - Utility-first CSS (optional)

🔒 Security Features
CSRF Protection - All forms protected

XSS Prevention - Input sanitization

SQL Injection Protection - Eloquent ORM

Session Security - Secure cookie handling

Role-based Middleware - Route protection

Input Validation - Server-side validation

📈 API Endpoints
Activity Monitoring
http
POST /api/inactivity-log
POST /api/activity-ping
GET /api/user-stats
POST /api/check-inactivity
User Management
http
GET /api/users
POST /api/users
PUT /api/users/{id}
DELETE /api/users/{id}
🗄 Database Schema
Core Tables
users - User accounts and profiles

activity_logs - Activity tracking records

inactivity_logs - Inactivity session records

penalties - User penalty records

system_settings - Configuration storage

Relationships
Users ↔ Activity Logs (One to Many)

Users ↔ Inactivity Logs (One to Many)

Users ↔ Penalties (One to Many)

🚀 Deployment
Production Setup
bash
# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set proper permissions
chmod -R 755 storage
chmod -R 755 bootstrap/cache
Environment Variables (Production)
env
APP_ENV=production
APP_DEBUG=false
LOG_LEVEL=error
Queue Configuration (Recommended)
bash
# Configure queue worker for background tasks
php artisan queue:work --daemon
🧪 Testing
Run Test Suite
bash
# Unit tests
php artisan test

# Feature tests
php artisan test --testsuite=Feature

# Generate test coverage
php artisan test --coverage-html coverage/
Sample Data
bash
# Seed with sample data
php artisan db:seed --class=SampleDataSeeder
📝 Usage Examples
Monitoring User Activity
php
// Log custom activity
ActivityLogService::logActivity(
    $user,
    'custom_action',
    $model,
    $oldValues,
    $newValues,
    'Custom action description'
);
Checking Inactivity
javascript
// Frontend inactivity monitoring
const monitor = new InactivityMonitor();
monitor.updateTimeouts(5, 10, 15); // Custom timeouts
🔄 Maintenance
Regular Tasks
bash
# Clear old logs (automated)
php artisan schedule:run

# Backup database
php artisan backup:run

# Update system settings
php artisan settings:sync
Log Rotation
Configure log rotation in config/logging.php for production environments.

🐛 Troubleshooting
Common Issues
Activity Not Logging

Check activity_monitoring_enabled setting

Verify middleware is applied to routes

Check database connection

Inactivity Alerts Not Showing

Verify JavaScript is enabled

Check browser console for errors

Validate timeout settings

Permission Errors

Verify user roles in database

Check middleware configuration

Review route permissions

Debug Mode
Enable debug mode for detailed error reporting:

env
APP_DEBUG=true
LOG_LEVEL=debug
🤝 Contributing
Fork the repository

Create feature branch (git checkout -b feature/AmazingFeature)

Commit changes (git commit -m 'Add AmazingFeature')

Push to branch (git push origin feature/AmazingFeature)

Open Pull Request

Development Guidelines
Follow PSR-12 coding standards

Write tests for new features

Update documentation

Use meaningful commit messages

📄 License
This project is licensed under the MIT License - see the LICENSE.md file for details.

🏆 Acknowledgments
Laravel Framework and Community

Bootstrap Team for UI components

Font Awesome for icons

Contributors and testers

📞 Support
For support and questions:

📧 Email: support@organization.com

🐛 Issues: GitHub Issues

📚 Documentation: Wiki

<div align="center">
Built with ❤️ using Laravel & Bootstrap

⬆ Back to Top

</div> ```
Additional Documentation Files
You might also want to create these supporting files:

1. DEPLOYMENT.md
markdown
# Deployment Guide

## Server Requirements
- Ubuntu 20.04 LTS or higher
- Nginx 1.18+
- PHP 8.1+
- MySQL 8.0+
- Redis (optional, for caching)

## Production Deployment Steps
1. Server preparation and security hardening
2. Web server configuration (Nginx/Apache)
3. SSL certificate installation
4. Database optimization
5. Queue worker setup
6. Monitoring and logging configuration
2. API.md
markdown
# API Documentation

## Authentication
All API endpoints require authentication via session cookies.

## Endpoints
### Get User Statistics
```http
GET /api/user-stats
Response: {
  "today_activities": 15,
  "inactivity_count": 2,
  "penalty_count": 0
}
Log Inactivity
http
POST /api/inactivity-log
Body: {
  "type": "alert|warning|logout",
  "duration": 300
}
Rate Limiting
60 requests per minute per user

1000 requests per hour per user

text

### 3. `SECURITY.md`
```markdown
# Security Policy

## Reporting Vulnerabilities
Please report security vulnerabilities to security@organization.com

## Security Features
- Input validation and sanitization
- CSRF protection on all forms
- SQL injection prevention
- XSS protection
- Secure session management
- Role-based access control