# Learnora - Learning Management System

A comprehensive PHP-based learning management system for online courses, training events, and educational content management.

## 🚀 Features

### Core Functionality
- **Course Management**: Create, edit, and manage online courses and training events
- **User Management**: Multi-role system (Admin, Users, Trainers, Affiliates)
- **Payment Processing**: Integrated payment system with manual payment verification
- **Event Management**: Physical, online, and hybrid event support
- **Content Delivery**: Video, text, and hybrid learning formats
- **Certification**: Course completion certificates
- **Review System**: User ratings and reviews for courses
- **Wishlist & Cart**: E-commerce functionality for course enrollment

### User Roles
- **Admin**: Full system management and oversight
- **Trainers**: Course creation and management
- **Users**: Course enrollment and learning
- **Affiliates**: Marketing and referral system

### Advanced Features
- **Multi-format Content**: Video lessons, text modules, quizzes
- **Event Scheduling**: Date/time management for live events
- **Location Management**: Physical addresses, online links, hybrid options
- **Ticket System**: Customer support and dispute resolution
- **Wallet System**: Internal currency and withdrawal management
- **Loyalty Program**: Rewards and incentives
- **Email Notifications**: Automated communication system
- **SEO Optimization**: Built-in SEO management

## 📋 Requirements

### Server Requirements
- **PHP**: 7.4+ (recommended 8.0+)
- **MySQL**: 5.7+ or MariaDB 10.2+
- **Web Server**: Apache (with mod_rewrite) or Nginx
- **PHP Extensions**:
  - mysqli
  - mbstring
  - curl
  - gd
  - zip
  - xml
  - json

### Optional Requirements
- **SMTP Server**: For email functionality
- **SSL Certificate**: For secure payments
- **Cron Jobs**: For automated tasks

## 🛠️ Installation

### 1. Database Setup
```sql
-- Create database
CREATE DATABASE learnora_learnorastore;

-- Import the database schema
-- Use the provided categories.sql file
```

### 2. Configuration
1. Clone or download the repository
2. Configure database connection in `backend/connect.php`:
```php
$db_host = "localhost";
$db_username = "your_db_username";
$db_pass = "your_db_password";
$db_name = "learnora_learnorastore";
```

3. Set up site URLs in `backend/connect.php`:
```php
$siteurl = 'https://yourdomain.com/'; // Production
// For local development:
$siteurl = 'http://localhost/learnora/';
```

### 3. File Permissions
```bash
chmod 755 uploads/
chmod 755 documents/
```

### 4. Email Configuration
Configure SMTP settings in `backend/functions.php` for email functionality.

## 📁 Directory Structure

```
learnora/
├── admin/                  # Admin panel
│   ├── pages/             # Admin page templates
│   ├── assets/            # Admin assets (CSS, JS, images)
│   └── login.php          # Admin login
├── affiliate/              # Affiliate system
├── backend/                # Core backend logic
│   ├── actions.php        # Main form processing
│   ├── connect.php        # Database connection
│   ├── functions.php      # Utility functions
│   └── PHPMailer/         # Email library
├── assets/                 # Frontend assets
│   ├── css/               # Stylesheets
│   ├── js/                # JavaScript files
│   └── vendor/            # Third-party libraries
├── uploads/                # User uploads (images, files)
├── documents/              # Course materials and videos
├── *.php                   # Frontend pages
└── categories.sql          # Database schema
```

## 🔧 Configuration

### Database Configuration
Edit `backend/connect.php`:
```php
// Database settings
$db_host = "localhost";
$db_username = "root";
$db_pass = "";
$db_name = "learnora_learnorastore";

// Site configuration
$siteurl = 'http://localhost/learnora/';
$siteprefix = 'ln_'; // Database table prefix
```

### Email Settings
Configure SMTP in `backend/functions.php`:
```php
function sendEmail($to, $toName, $fromName, $fromEmail, $message, $subject) {
    // SMTP configuration here
}
```

## 👥 User Management

### Default Admin Access
- URL: `/admin/`
- Default credentials: Check database for admin user

### User Types
1. **Admin**: Full system access via `/admin/`
2. **User**: Regular users register via `register.php`
3. **Trainer**: Course creators (register via `register-trainer.php`)
4. **Affiliate**: Marketing partners (register via affiliate system)

## 💳 Payment System

### Supported Methods
- Manual payment with proof upload
- Paystack integration (configured in payment files)
- Wallet system for internal transactions

### Payment Flow
1. User adds course to cart
2. Proceeds to checkout
3. Selects payment method
4. For manual payments: uploads proof
5. Admin verifies and activates enrollment

## 📚 Course Management

### Course Formats
- **Video**: Video lessons with multiple quality options
- **Text**: PDF/document-based learning
- **Hybrid**: Combination of video and text
- **Live**: Scheduled events (physical/online/hybrid)

### Course Features
- Multi-instructor support
- Category and subcategory organization
- Pricing tiers (free, paid, donation)
- Event scheduling and management
- Certificate generation
- Student reviews and ratings

## 🔒 Security Features

- Password hashing using PHP's `password_hash()`
- SQL injection prevention with prepared statements
- File upload validation
- Session management
- CSRF protection (in forms)
- Input sanitization

## 📧 Email Templates

The system includes automated emails for:
- User registration verification
- Password reset
- Course enrollment confirmations
- Payment notifications
- Admin alerts

## 🛠️ Customization

### Theming
- Modify CSS files in `assets/css/`
- Edit header.php and footer.php for layout changes
- Admin theme in `admin/assets/`

### Adding New Features
1. Create new pages in root directory
2. Add form processing to `backend/actions.php`
3. Database operations in `backend/functions.php`
4. Admin pages in `admin/pages/`

## 🐛 Troubleshooting

### Common Issues

1. **Login Issues**
   - Check database connection in `connect.php`
   - Verify user status is 'active'
   - Check password hashing compatibility

2. **File Upload Issues**
   - Ensure `uploads/` and `documents/` directories are writable
   - Check PHP upload limits in `php.ini`

3. **Email Issues**
   - Configure SMTP settings
   - Check email template paths
   - Verify spam filters

4. **Payment Issues**
   - Check payment gateway credentials
   - Verify webhook URLs
   - Check currency settings

### Debug Mode
Enable debugging in `backend/connect.php`:
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

## 📝 Development Notes

### Code Structure
- **MVC Pattern**: Basic separation of concerns
- **Database Layer**: mysqli with prepared statements
- **Frontend**: Bootstrap-based responsive design
- **Admin Panel**: Separate admin interface

### Key Files
- `backend/actions.php`: Main form processing logic
- `backend/functions.php`: Utility functions and helpers
- `backend/connect.php`: Database and configuration
- `header.php`: Frontend header and navigation
- `footer.php`: Frontend footer

### Database Schema
- Tables use `ln_` prefix
- Refer to `categories.sql` for complete schema
- Includes users, courses, payments, and support tables

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 📄 License

This project is licensed under the terms specified in the original template license. Please refer to the license file for details.

## 📞 Support

For support and questions:
- Check the troubleshooting section
- Review the database schema
- Test with sample data
- Verify server requirements

## 🔄 Updates

When updating:
1. Backup database and files
2. Test in staging environment
3. Update database schema if needed
4. Clear browser cache
5. Test critical functionality

---

**Note**: This is a complex learning management system. Ensure you have proper development experience before making modifications. Always test changes in a development environment first.
