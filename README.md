# Quick Ride Backend  
Cortex Competition - Team 1

## Overview
The **Quick Ride** backend is built to support a seamless experience for rent-a-car services, offering robust and scalable features for managing vehicles, reservations, customers, and payments. The API is designed for flexibility and performance, with clear documentation and an intuitive structure.

## Features
- User authentication and authorization
- Vehicle management
- Rental system
- Reviews system
- PDF invoice generation
- Error handling and validation

## Tech Stack
- **Backend Framework**: Laravel
- **Database**: MYSQL
- **PDF Generation**: DOMPDF
- **Version Control**: Git
- **Admin Dashboard**: AdminLTE 3

## Installation & Setup
1. **Clone the repository**  
   ```bash
   git clone https://github.com/your-repo/quick-ride-backend.git
Install dependencies

composer install
Set up environment variables

cp .env.example .env
php artisan key:generate
Open with your favorite terminal editor and change default values:

APP_ENV=production
APP_DEBUG=false
...
LOG_LEVEL=none
And these (according to your system):

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```
Email Configuration: Make sure to include your email settings in the .env file:
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=quickride321@gmail.com
MAIL_PASSWORD=rohlpbstwlnhbtuz
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="quickride321@gmail.com"
MAIL_FROM_NAME="${APP_NAME}"```
Create database
```

Start the project

```
php artisan serve
Web Server Configuration
Nginx Configuration

```
To set up Nginx to serve your Laravel application, follow these steps:

Install Nginx (if not already installed):
```

sudo apt update
sudo apt install nginx
Create a new Nginx server block:

``` bash

sudo $EDITOR /etc/nginx/sites-available/quick-ride

server {
   listen 80;
   server_name your_domain.com;  # Replace with your domain or IP

   root /var/www/quick-ride/public;  # Change to the right path

   index index.php index.html index.htm;

   location / {
       try_files $uri $uri/ /index.php?$query_string;
   }

   location ~ \.php$ {
       include snippets/fastcgi-php.conf;
       fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;  # Your PHP version 
       fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
       include fastcgi_params;
   }

   location ~ /\.ht {
       deny all;
   }
}
```
Enable the server block:
```


sudo ln -s /etc/nginx/sites-available/quick-ride /etc/nginx/sites-enabled/
Test the Nginx configuration:


sudo nginx -t
Start Nginx



sudo systemctl restart nginx
Set permissions Change to the path where you cloned the project:


sudo chown -R www-data:www-data /var/www/quick-ride/storage
sudo chown -R www-data:www-data /var/www/quick-ride/bootstrap/cache
```

Additional Setup for AdminLTE 3 and DOMPDF
AdminLTE 3
Install AdminLTE
You can install AdminLTE via npm:

```
npm install admin-lte
Configure AdminLTE
Make sure to include the AdminLTE CSS and JS files in your Blade templates or layout files.

```
DOMPDF
Install DOMPDF
You can install DOMPDF using Composer:

```
composer require barryvdh/laravel-dompdf
Publish the configuration (optional)


php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
