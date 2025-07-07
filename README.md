
# EcoPack Services Management System

A comprehensive business management system built with CodeIgniter 3.0 and PHP 7.3, designed for logistics, warehousing, and transport services management.

## 🏢 About EcoPack Services

EcoPack Services is a complete enterprise resource planning (ERP) system that handles:

- **Transport Management** - Vehicle tracking, consignment management, delivery scheduling
- **Warehouse Operations** - Inventory management, stock transfers, rental item tracking  
- **Financial Management** - Invoicing, billing, payment tracking, GST reporting
- **Human Resources** - Employee management, attendance, payroll, leave management
- **Project Management** - Project tracking, task management, reporting

## 🚀 Features

### Core Modules

- **Dashboard** - Real-time analytics and business insights
- **Consignment Management** - Booking, tracking, and delivery management
- **Vehicle Management** - Fleet tracking, maintenance, driver assignments
- **Warehouse Management** - Stock control, transfers, rental items
- **Financial Management** - Invoicing, payments, GST compliance
- **Employee Management** - HR operations, attendance, payroll
- **Reporting** - Comprehensive business reports and analytics

### Key Capabilities

- Multi-branch operations support
- Real-time inventory tracking
- Automated billing and invoicing
- GST-compliant reporting
- Employee attendance and payroll
- Document management
- Role-based access control

## 🛠️ Technology Stack

- **Backend**: CodeIgniter 3.0 (PHP 7.3)
- **Database**: MySQL
- **Frontend**: Bootstrap 4, jQuery, HTML5/CSS3
- **Charts**: Morris.js, Chart.js, C3.js
- **PDF Generation**: Built-in PDF libraries
- **Authentication**: Session-based with role management

## 📋 System Requirements

- PHP 7.3 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- 512MB RAM minimum (1GB recommended)
- 1GB disk space minimum

## 🔧 Installation

### Quick Setup on Replit

1. **Database Setup**:
   ```bash
   mysql -u root -e "CREATE DATABASE IF NOT EXISTS db_ecopack_database;"
   mysql -u root db_ecopack_database < database/db_ecopack_database.sql
   ```

2. **Configuration**:
   - Database settings are pre-configured in `application/config/database.php`
   - Base URL and other settings in `application/config/config.php`

3. **Start the Server**:
   ```bash
   php -S 0.0.0.0:5000 -t .
   ```

4. **Access the Application**:
   - Open the webview panel in Replit
   - Default admin credentials are provided in the database

### Manual Installation

1. **Clone/Download** the project files
2. **Import Database**: Import `database/db_ecopack_database.sql` into MySQL
3. **Configure Database**: Update `application/config/database.php` with your database credentials
4. **Set Permissions**: Ensure `uploads/` and `application/logs/` are writable
5. **Configure Web Server**: Point document root to project folder

## 📁 Project Structure

```
ecopackservices/
├── application/              # CodeIgniter application files
│   ├── controllers/         # Business logic controllers
│   ├── models/             # Data models
│   ├── views/              # UI templates
│   ├── config/             # Configuration files
│   ├── libraries/          # Custom libraries
│   └── helpers/            # Helper functions
├── assets/                 # Static assets (CSS, JS, images)
├── uploads/                # User uploaded files
├── database/               # Database schema and backups
├── system/                 # CodeIgniter core files
└── vendor/                 # Composer dependencies
```

## 🔐 Default Login

**Admin Access**:
- URL: `/` (redirects to login)
- Username: `admin`
- Password: `admin123`

> **Security Note**: Change default credentials immediately after installation

## 📚 User Guide

### Getting Started

1. **Dashboard Overview**: View key metrics and recent activities
2. **User Management**: Set up user accounts and permissions
3. **Master Data**: Configure places, vehicles, warehouses, and items
4. **Daily Operations**: Process consignments, manage inventory, track vehicles

### Key Workflows

**Consignment Processing**:
1. Create new consignment booking
2. Assign vehicle and driver
3. Generate delivery challan
4. Track delivery status
5. Generate invoice and collect payment

**Inventory Management**:
1. Receive stock from suppliers
2. Transfer between warehouses
3. Allocate items for rental/sale
4. Monitor stock levels and reorder points

**Financial Operations**:
1. Generate invoices for services
2. Record payments and receipts
3. Track outstanding dues
4. Generate GST reports

## 🔧 Configuration

### Database Configuration
Edit `application/config/database.php`:
```php
$db['default'] = array(
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'db_ecopack_database',
    // ... other settings
);
```

### Email Configuration
Edit `application/config/email.php` for SMTP settings.

### File Upload Settings
Configure upload paths and restrictions in controllers.

## 📊 Reporting Features

- **Financial Reports**: P&L, Balance Sheet, GST Returns
- **Operational Reports**: Consignment tracking, vehicle utilization
- **Inventory Reports**: Stock levels, movement analysis
- **HR Reports**: Attendance, payroll, employee performance

## 🛡️ Security Features

- Session-based authentication
- Role-based access control
- Input validation and sanitization
- CSRF protection
- SQL injection prevention
- File upload restrictions

## 🔄 Backup & Maintenance

### Database Backup
```bash
mysqldump -u root -p db_ecopack_database > backup_$(date +%Y%m%d).sql
```

### Log Files
- Application logs: `application/logs/`
- Error logs: Check server error logs
- Session files: `ci_session/`

## 🚀 Deployment on Replit

This application is optimized for Replit deployment:

1. **Development**: Use the Run button to start the PHP server
2. **Database**: MySQL is pre-configured and accessible
3. **File Storage**: Uploads stored in the `uploads/` directory
4. **Environment**: Production-ready configuration included

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 📞 Support

For technical support or questions:
- Check the application logs in `application/logs/`
- Review database schema in `database/`
- Consult CodeIgniter 3.0 documentation

## 📄 License

This project is proprietary software for EcoPack Services. All rights reserved.

## 🔮 Roadmap

- [ ] Mobile application development
- [ ] Advanced analytics dashboard
- [ ] Integration with third-party logistics APIs
- [ ] Enhanced reporting capabilities
- [ ] Multi-language support
- [ ] Real-time notifications

---

**EcoPack Services Management System** - Streamlining logistics and business operations since 2018.
