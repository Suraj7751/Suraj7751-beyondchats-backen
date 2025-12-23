# BeyondChats Backend Assignment

## Overview

This project is a full-stack backend automation system built using Laravel, Node.js, and React.

The system:

Scrapes blog articles

Enhances content using an LLM (Google Gemini with fallback)

Stores and republishes optimized articles via a Laravel REST API

Displays articles in a React frontend

The architecture is designed to be fault-tolerant, scalable, and production-safe.

🧱 Tech Stack

Laravel 12 – Backend REST API

SQLite – Database

Node.js – Automation & orchestration service

Axios – HTTP client

Cheerio – Web scraping

Google Gemini API – LLM-based content enhancement (with fallback)

React (Vite) – Frontend UI

📂 Project Structure
beyondchats-backend/
│
├── app/
│   ├── Models/
│   │   └── Article.php
│   └── Http/
│       └── Controllers/
│           └── ArticleController.php
│
├── database/
│   └── migrations/
│
├── phase-2-node/
│   ├── index.js
│   ├── package.json
│   └── .env
│
├── phase-3-frontend/
│   ├── src/
│   │   └── App.jsx
│   ├── .env
│   └── package.json
│
├── routes/
│   └── api.php
│
└── README.md

🟢 Phase 1: Laravel Backend
Features

RESTful APIs for article management

Automatic unique slug generation at model level

Request validation and error handling

SQLite database support

API Endpoints
Method	Endpoint	Description
GET	/api/articles	Fetch all articles
POST	/api/articles	Create a new article
PUT	/api/articles/{id}	Update an article
DELETE	/api/articles/{id}	Delete an article
Run Backend
php artisan migrate
php artisan serve


Backend runs at:

http://127.0.0.1:8000

🔵 Phase 2: Node.js Automation
What Phase 2 Does

Fetches the latest article from Laravel API

Searches related articles using DuckDuckGo

Cleans and decodes redirect URLs

Scrapes reference article content

Enhances content using Google Gemini LLM

Falls back to safe rewrite if LLM is unavailable

Publishes the updated article back to Laravel

This ensures the pipeline never breaks, even if external services fail.

Run Phase 2
cd phase-2-node
npm install
node index.js

Sample Output
Generating updated article using LLM...
⚠️ Gemini unavailable, using fallback rewrite
✅ Updated article published successfully!

🟣 Phase 3: React Frontend (Optional)

A simple React UI built with Vite that:

Fetches articles from Laravel API

Displays original and AI-enhanced articles

Provides a clean, readable interface

Run Frontend
cd phase-3-frontend
npm install
npm run dev


Frontend runs at:

http://localhost:5173

🔐 Environment Variables
Laravel .env
DB_CONNECTION=sqlite

Node.js .env
LARAVEL_API=http://127.0.0.1:8000/api/articles
GEMINI_API_KEY=your_api_key_here

React .env
VITE_API_URL=http://127.0.0.1:8000/api/articles

🧠 Design Decisions

Slug generation handled in Laravel model, not client

Node.js focuses only on automation and orchestration

Backend owns validation and data integrity

LLM failures do not break the system

Clear separation of concerns across layers

✅ Final Outcome

Original articles stored in database

AI-enhanced “(Updated)” articles auto-generated

References appended to final content

Fully automated end-to-end pipeline

Optional frontend for visualization

👤 Author

Suraj

🏁 Status

✔ Phase 1 – Backend API
✔ Phase 2 – Automation + AI
✔ Phase 3 – Frontend UI (Optional)

Assignment completed successfully.
