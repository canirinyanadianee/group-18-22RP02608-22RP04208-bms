# Blood Management System (BMS)

A comprehensive web-based platform for managing blood banks, donations, requests, and inventory tracking.

## Features

- User Management (Admin, Hospital, Donor, Patient)
- Blood Bank Management
- Blood Donation Tracking
- Blood Request Management
- Real-time Blood Inventory Tracking
- Multi-language Support
- Role-based Access Control
- Automated Notifications

## Prerequisites

- PHP 8.1 or higher
- Composer
- MySQL 5.7 or higher
- Node.js and NPM
- XAMPP/WAMP/LAMP stack

## Installation Steps

1. **Clone the Repository**
   ```bash
   git clone [repository-url]
   cd bms
   ```

2. **Install PHP Dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript Dependencies**
   ```bash
   npm install
   ```

4. **Create Environment File**
   ```bash
   cp .env.example .env
   ```

5. **Configure Environment Variables**
   Open `.env` file and update the following:
   ```
   APP_NAME="Blood Management System"
   APP_ENV=local
   APP_KEY=base64:your-key-here
   APP_DEBUG=true
   APP_URL=http://localhost

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=bms
   DB_USERNAME=root
   DB_PASSWORD=

   MAIL_MAILER=mailpit
   MAIL_HOST=localhost
   MAIL_PORT=1025
   MAIL_USERNAME=null
   MAIL_PASSWORD=null
   MAIL_ENCRYPTION=null
   MAIL_FROM_ADDRESS="noreply@bms.com"
   MAIL_FROM_NAME="${APP_NAME}"
   ```

6. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

7. **Create Database**
   ```sql
   CREATE DATABASE bms;
   ```

8. **Run Migrations and Seeders**
   ```bash
   php artisan migrate:fresh --seed
   ```

9. **Compile Assets**
   ```bash
   npm run dev
   ```

10. **Start Development Server**
    ```bash
    php artisan serve
    ```

## Default Login Credentials

After running the seeders, you can log in with these default credentials:

- **Admin Account**
  - Email: admin@bms.com
  - Password: password

- **Hospital Account** Register your account to a system
  for example:
  login use: your created account 
  - Email: hospital@bms.com
  - Password: password

- **Donor Account** Register your account to a system
  for example:
  login use: your created account
  - Email: donor@bms.com
  - Password: password

- **Patient Account** Register your account to a system
  for example:
  login use: your created account
  - Email: patient@bms.com
  - Password: password

## System Structure

### Database Tables
- `users` - User accounts and profiles
- `blood_banks` - Blood bank information
- `blood_donations` - Blood donation records
- `blood_requests` - Blood request records
- `blood_inventories` - Blood stock inventory
- `notifications` - System notifications
- `languages` - Supported languages
- `donation_drives` - Blood donation drive events
- `donation_registrations` - Donation drive registrations

### Key Features

1. **User Management**
   - Role-based access control
   - User profiles and verification
   - Multi-language support

2. **Blood Bank Management**
   - Blood bank registration
   - Inventory tracking
   - Stock level monitoring

3. **Blood Donation Management**
   - Donation scheduling
   - Donor eligibility checking
   - Donation history tracking

4. **Blood Request Management**
   - Request creation and tracking
   - Urgency level management
   - Automated matching with available blood

5. **Inventory Management**
   - Real-time stock tracking
   - Blood type categorization
   - Low stock alerts

## API Endpoints

The system provides RESTful API endpoints for:

- Authentication
- User Management
- Blood Bank Operations
- Blood Donation Tracking
- Blood Request Processing
- Inventory Management

## Security Features

- CSRF Protection
- XSS Prevention
- SQL Injection Protection
- Password Hashing
- Role-based Authorization
- Input Validation

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support, email support@bms.com or create an issue in the repository.

## Acknowledgments

- Laravel Framework
- Tailwind CSS
- Alpine.js
- MySQL
- Mailpit for email testing
