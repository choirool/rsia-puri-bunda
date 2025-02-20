# Laravel Project

## Requirements
- PHP >= 8.2
- Node.js >= 18

## Development Setup

1. **Clone the repository**
   ```sh
   git clone <repository_url>
   cd <project_directory>
   ```

2. **Set up environment variables**
   ```sh
   cp .env.example .env
   ```
   Update the `.env` file with your configuration settings.

3. **Generate application key**
   ```sh
   php artisan key:generate
   ```

4. **Install PHP dependencies**
   ```sh
   composer install
   ```

5. **Install JavaScript dependencies**
   ```sh
   npm install
   ```

6. **Run database migrations and seed data**
   ```sh
   php artisan migrate --seed
   ```

7. **Run Laravel development server**
   ```sh
   php artisan serve
   ```

8. **Run Vite development server**
   ```sh
   npm run dev
   ```

## Production Build

To build assets for production, run:
```sh
npm run build
```
