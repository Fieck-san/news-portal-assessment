# Assessment

Project based on the Malaysiakini news page.

- `backend/` contains the Laravel API.
- `frontend/` contains the Angular app.
- MySQL runs through Docker Compose.

## Run With Docker

Make sure Docker Desktop is running, then run this from the project root:

```bash
docker compose up --build
```

On first run, the backend container will:

- install Composer dependencies
- generate the Laravel app key
- run the migrations
- seed the database
- start the Laravel API

The frontend container will install npm dependencies and start Angular.

Open these URLs after the containers finish starting:

- Frontend: http://localhost:4200
- API: http://localhost:8000/api/news

Local Docker database credentials:

```text
DB_DATABASE=news_portal
DB_USERNAME=root
DB_PASSWORD=123456
```

## API Endpoints

```text
GET /api/news
GET /api/news/{id}
GET /api/news/{slug}
GET /api/categories
GET /api/categories/{slug}/news
```

Some optional query parameters are also available:

```text
GET /api/news?per_page=8&page=1
GET /api/news?category=politik
GET /api/news?lang=en
GET /api/news?lang=ms
```

## Manual Setup

Docker is the easiest way to run the project, but the backend can also be run manually if PHP, composer, and mysql are installed.

Backend:

```bash
cd backend
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve
```

Frontend:

```bash
cd frontend
npm install
npm start
```

## Tests

Backend:

```bash
docker compose run --rm backend php artisan test
```

Frontend:

```bash
cd frontend
npm test
npm run build
```

## Submission

This repository includes:

1. Laravel backend source code in `backend/`, including migrations and seeders.
2. Angular frontend source code in `frontend/`.
3. Setup instructions above for running the migrations/seeders, starting the Laravel API, and serving the Angular app.
