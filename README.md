# A2F Project - Two-Factor Authentication (2FA) System

**Project for school A2F with Darioooooo**

This project demonstrates a two-factor authentication (2FA) system, utilizing TOTP (Time-Based One-Time Password) for enhanced security during login. It is implemented using PHP and various libraries for OTP generation and QR code creation.

## Requirements

To run this project, make sure you have the following installed on your machine:

- **PHP**
- **Composer** (https://getcomposer.org/download/)

## Installation

Follow these steps to set up the project:

1. **Clone the repository**:
   ```bash
   git clone https://github.com/scr1ptys/TOTP_Project.git
   cd TOTP_Project/main
   composer require spomky-labs/otphp
   composer require endroid/qr-code
   ```
2. **Setup the database**


You need to create the necessary database and tables for this project.

Use the provided bdd folder to execute the SQL commands to initialize your database.

Ensure you configure the correct database credentials in the db.php file.  
