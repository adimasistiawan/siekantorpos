1. Install Dependencies
composer install
`npm install && npm run dev`

2. Configure Environment
`cp .env.example .env`
Update the .env with your database credentials:
`DB_CONNECTION=mysql`
`DB_HOST=127.0.0.1`
`DB_PORT=3306`
`DB_DATABASE=your_database_name`
`DB_USERNAME=your_db_username`
`DB_PASSWORD=your_db_password`

3. Generate Application Key
`php artisan key:generate`

4. Migrate the Database
`php artisan migrate`

5. Start the Development Server
`php artisan serve`
