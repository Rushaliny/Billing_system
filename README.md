# Billing System

A simple and efficient billing system built with Laravel. This application allows users to manage customer records, pay bills, and generate reports through a secure and user-friendly interface.

## 🚀 Features

- User authentication [Login/Logout]
- Add, edit, and delete pay bills
- Filter bills by date, month, or year
- Search by account number
- Generate downloadable reports
- Clean and responsive UI with Blade & Bootstrap

## 🛠 Tech Stack

- Laravel 10+
- Blade Templating
- MySQL
- Bootstrap 5
- JavaScript & jQuery


## 🧰 How to Install and Run the Project (ZIP Version)



1. **Extract the ZIP file** into your local directory.

2. **Navigate to the project folder:**

   ```bash
   cd Billing_system

3. **Install dependencies**

   ```bash
    composer install
    npm install && npm run dev

4. **Set up environment**

   ```bash
    cp .env.example .env
    php artisan key:generate

5. **Configure your .env file**
    
    Database name - billing_system

6. **Run migrations**

   ```bash  
    php artisan migrate

7. **Serve the app**

   ```bash
    php artisan serve

8. **Seed the database (to create default admin login)**

    ```bash
    php artisan db:seed

9. **Start the development server:**    
    
    ```bash
    php artisan serve


## 👤 User Roles

**Admin** 


*You can change the password through the Admin profile* 

**Clone the repo: (If Need)**

   ```bash
   git clone https://github.com/Rushaliny/Billing_system.git
   cd Billing_system
