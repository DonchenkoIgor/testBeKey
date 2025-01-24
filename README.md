# Task management

## Description
The project implements a task management system with support for CRUD operations, user authorization and task filtering.

## Requirements
Before you begin, make sure you have installed:
- Docker and Docker Compose
- Git

## Installation and Deployment

1. **Clone the repository**

git clone https://github.com/DonchenkoIgor/testBeKey.git  
cd your-repository

2. **Copy the .env.example file to .env**

cp .env.example .env  
The PostgreSQL connection settings are already specified in docker-compose.yml, no changes are required.

3. **Run the project using Docker Run the command:**  
   docker-compose up -d


4. **Install Laravel dependencies**  
   docker exec -it app-container composer install  
   docker exec -it app-container php artisan key:generate  
   docker exec -it app-container php artisan migrate --seed

5. **Generating API documentation**  
   docker exec -it app-container php artisan scribe:generate

## API functionality

- List of available URLs:
    * List of tasks (list): [GET]: /api/tasks
    * Add task (add): [POST]: /api/tasks
    * Edit task (edit): [PUT]: /api//tasks/{task}
    * Delete task (delete): [DELETE]: /api/tasks/{task}
    * Changing the execution status: [PATCH]: /api/tasks/{task}/toggle

## Authentication

- All operations require authentication. To obtain a token, run:
    * Registration: [POST]: /api/register  
      {  
      "name": "name",  
      "email": "email@example.com",  
      "password": "password",  
      "password_confirmation": "password"  
      }


* Authorization: [POST]: /api/login  
  {  
  "email": "email@example.com",  
  "password": "password"  
  }


* In response, you will receive a token that you need to use for all subsequent requests:  
  {  
  "token": "your_token"  
  }
*

## Test data:
* Email: arthur46@example.net  
  password: password123
* Email: onie.conn@example.net  
  password: password123
* Email: schuster.tyshawn@example.org  
  password: password123
