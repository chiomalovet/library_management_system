Library Management System API
Overview
This project is a RESTful API for managing a library system, developed using Laravel. The API provides endpoints to manage books, authors, users, and borrow records. It incorporates features such as role-based access control (RBAC), search functionality, pagination, and rate limiting.

Table of Contents
Environment Setup
Entities
API Endpoints
Books
Authors
Users
Borrow Records
Additional Features
Error Handling
Testing
Documentation
Bonus Features
Environment Setup
Prerequisites
PHP 8.2.12 
Laravel 11
MySQL, 
Installation
Clone the repository:
git clone https://github.com/yourusername/library-management-api.git
cd library-management-api

Install dependencies:
composer install

Set up the environment:
cp .env.example .env
php artisan key:generate

Configure the database in the .env file:
env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=library_db
DB_USERNAME=root
DB_PASSWORD=

Run migrations to set up the database schema:
php artisan migrate

Start the development server:
php artisan serve

Entities
Book
id: Integer, primary key
title: String, required
isbn: String, required, unique
published_date: Date
author_id: Foreign key to Author
status: Enum [Available, Borrowed], required
Author
id: Integer, primary key
name: String, required
bio: Text, optional
birthdate: Date, optional
User
id: Integer, primary key
name: String, required
email: String, required, unique
password: String, required
role: Enum [Admin, Librarian, Member], required
BorrowRecord
id: Integer, primary key
user_id: Foreign key to User
book_id: Foreign key to Book
borrowed_at: DateTime, required
due_at: DateTime, required
returned_at: DateTime, optional
API Endpoints
Books
GET /books: Retrieve a list of all books with pagination.
GET /books/{id}: Retrieve details of a specific book by ID.
POST /books: Create a new book (Admin/Librarian only).
PUT /books/{id}: Update an existing book by ID (Admin/Librarian only).
DELETE /books/{id}: Delete a book by ID (Admin only).
POST /books/{id}/borrow: Borrow a book (Member only, if available).
POST /books/{id}/return: Return a borrowed book (Member only).
Authors
GET /authors: Retrieve a list of all authors with pagination.
GET /authors/{id}: Retrieve details of a specific author by ID.
POST /authors: Create a new author (Admin/Librarian only).
PUT /authors/{id}: Update an existing author by ID (Admin/Librarian only).
DELETE /authors/{id}: Delete an author by ID (Admin only).
Users
GET /users: Retrieve a list of all users (Admin only).
GET /users/{id}: Retrieve details of a specific user by ID (Admin only).
POST /users: Register a new user.
PUT /users/{id}: Update user details (Admin only or self).
DELETE /users/{id}: Delete a user by ID (Admin only).
POST /login: Authenticate a user and return a Sanctum token.
Borrow Records
GET /borrow-records: Retrieve all borrow records (Admin/Librarian only).
GET /borrow-records/{id}: Retrieve details of a specific borrow record by ID (Admin/Librarian only).
Additional Features
Role-Based Access Control (RBAC):

Admin: Full access to all resources.
Librarian: Manage books and authors, view borrow records.
Member: View books/authors, borrow and return books, update their profile.
Search Functionality:

Search books by title, author, or ISBN.
Pagination:

Implement pagination for listing books, authors, and borrow records.
Input Validation:

Validate input for all endpoints to ensure data integrity.
Error Handling
Implement error handling with appropriate status codes and messages to provide clear feedback on request failures.
Testing
Feature Tests:

Comprehensive feature tests are included for all API endpoints.
Run tests using:
bash
Copy code
php artisan test
Rate Limiting Tests:

Verify rate limiting functionality to ensure protection against abuse.
Documentation
Postman Collection:

A Postman collection is provided to document and test the API.
Import the collection from postman/LibraryManagementSystem.postman_collection.json into Postman.
API Documentation:

Detailed API documentation is included in the Postman collection, covering all endpoints, request formats, and response examples.
Bonus Features
Rate Limiting:
Rate limiting is implemented to prevent abuse and ensure fair use of the API.
