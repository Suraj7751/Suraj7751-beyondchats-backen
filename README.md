# BeyondChats Backend Assignment

## Overview
This project is a backend automation system built using **Laravel** and **Node.js**.

The system scrapes blog articles, enhances content using an LLM (Gemini with fallback), and republishes optimized articles back into the Laravel backend using REST APIs.

---

## Tech Stack
- Laravel 11 (Backend API)
- SQLite (Database)
- Node.js (Automation Service)
- Axios & Cheerio (Web scraping)
- Google Gemini API (LLM with fallback handling)

---

## Project Structure

beyondchats-backend/
│
├── app/
│ ├── Models/Article.php
│ ├── Http/Controllers/ArticleController.php
│
├── database/
│ └── migrations/
│
├── phase-2-node/
│ ├── index.js
│ ├── package.json
│ └── .env
│
├── routes/
│ └── api.php
│
└── README.md


---

## Phase 1: Laravel Backend

### Features
- REST APIs for managing articles
- Automatic slug generation at model level
- Validation and error handling
- SQLite database support

### API Endpoints

| Method | Endpoint | Description |
|------|---------|------------|
| GET | /api/articles | Fetch all articles |
| POST | /api/articles | Create a new article |
| PUT | /api/articles/{id} | Update an article |
| DELETE | /api/articles/{id} | Delete an article |

### Run Laravel
```bash
php artisan migrate
php artisan serve


Phase 2: Node.js Automation
What it does

Fetches the latest article from Laravel API

Searches related articles using DuckDuckGo

Scrapes reference content

Enhances the article using Gemini LLM

Uses fallback logic if LLM is unavailable

Publishes the updated article back to Laravel


Run Phase 2 Automation
cd phase-2-node
npm install
node index.js

Environment Variables
Laravel .env
DB_CONNECTION=sqlite

Node.js .env
LARAVEL_API=http://127.0.0.1:8000/api/articles
GEMINI_API_KEY=your_api_key_here

Sample Output
Latest article: 10 Solutions for Common Customer Service Issues
Generating updated article using LLM...
⚠️ Gemini unavailable, using fallback rewrite
✅ Updated article published successfully!

Design Decisions

Slug generation is handled in the Laravel model, not the client

Node.js focuses only on automation and orchestration

Validation is enforced at the backend API layer

LLM failures do not stop the pipeline

Duplicate data issues are avoided through backend ownership

Final Result

Original articles are stored in the database

Enhanced “(Updated)” articles are auto-generated

References are appended to the final content

System runs end-to-end without manual intervention