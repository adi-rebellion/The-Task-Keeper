# The Task Keeper

## Description

This project implements a Laravel-based REST API application for managing tasks and notes, with token-based authentication using Laravel Passport. It includes Docker deployment for easy setup and maintenance.

## Features

- User Registration & Login with token-based authentication
- CRUD operations for Tasks and Notes
- Relationships between Tasks and Notes (One-to-Many)
- API endpoints for creating tasks with multiple notes and attachments
- Filtering and ordering tasks based on priority and note count

## Requirements

- Laravel 8.75
- Docker for deployment (`sudo docker-compose build` and `sudo docker-compose up`)
- PHP runs on port 29100, PHPMyAdmin on port 29182

## Installation and Setup

1. Clone the repository:

   ```bash
   git clone https://github.com/adi-rebellion/The-Task-Keeper.git
   cd TaskKeeper
   ```

2. Build and start Docker containers:

   ```bash
   sudo docker compose build
   sudo docker compose up
   ```

3. Access the application in your web browser:

   ```
   http://localhost:29100
   ```


## Test Credentials

   User's Email:

   ```bash
   john@example.com
   ```
  User's Password:

   ```bash
   password
   ```



## API Documentation

📘 API documentation is available in Swagger format at:

Explore the API using Swagger UI with Bearer authorization.

1. Click on the `Authorize` button.
2. Enter `Bearer your_access_token` in the `Value` field.
3. Click `Authorize`.
4. Now you can explore and test API endpoints securely.


```
http://localhost:29100/api/documentation
```

📘 API documentation is available in Postman format at:

 
1. Click on the `Import` button.
2. Enter `URL` in the `Value` field.
3. Click `Import`.
4. Now you can explore and test API endpoints securely.


```
https://api.postman.com/collections/13214997-b739b124-b280-41f9-9128-d87639d9c02e?access_key=PMAT-01J1ZCBBDZMPWTNXJ6H4894Z0P
```



### Authentication

#### User Register
- Endpoint: `/api/register`
- Method: POST
- Parameters:
  - `name` (string): User's name
  - `email` (string): User's email address
  - `password` (string): User's password
  - `confirm_password` (string): User's confirm password
- Response:
  - `message`: User registered successfully. 
  - `access_token`: Token for accessing protected endpoints

#### User Login
- Endpoint: `/api/login`
- Method: POST
- Parameters:
  - `email` (string): User's email address
  - `password` (string): User's password
- Response:
  - `message`: User logged in successfully. 
  - `access_token`: Token for accessing protected endpoints

#### User Logout
- Endpoint: `/api/logout`
- Method: POST
- Headers:
  - `Authorization: Bearer {access_token}`
- Response:
  - `message`: User logged out successfully. 

### Tasks API

#### Create Task with Notes and Attachments

- Endpoint: `/api/tasks`
- Method: POST
- Headers:
  - `Authorization: Bearer {access_token}`
- Body:
  ```json
    {
        "subject": "New Task",
        "description": "Task Description",
        "start_date": "2024-07-01",
        "due_date": "2024-07-10",
        "status": "New",
        "priority": "High",
        "notes": [
            {
                "subject": "Note 1",
                "note": "This is the first note",
                "attachments": [
                    "file1.png",
                    "file2.pdf"
                ]
            },
            {
                "subject": "Note 2",
                "note": "This is the second note",
                "attachments": [
                    "file3.docx"
                ]
            }
        ]
    }   
  ```

#### Retrieve Tasks with Notes

- Endpoint: `/api/tasks`
- Method: GET
- Headers:
  - `Authorization: Bearer {access_token}`
- Query Parameters:
  - `filter[status]`: Filter by task status (e.g., `New`)
  - `filter[due_date]`: Filter by due date (e.g., `2024-07-10`)
  - `filter[priority]`: Filter by priority (e.g., `High`)
  - `filter[notes]`: Retrieve tasks with at least one note attached
- Response:
  ```json
  [
    {
      "id": 1,
      "subject": "Task subject",
      "description": "Task description",
      "start_date": "2024-07-04",
      "due_date": "2024-07-10",
      "status": "New",
      "priority": "High",
      "notes": [
        {
          "id": 1,
          "subject": "Note 1 subject",
          "note": "Note 1 content"
        },
        {
          "id": 2,
          "subject": "Note 2 subject",
          "note": "Note 2 content"
        }
      ]
    }
  ]
  ```

## Contributors

- Aditya Naidu

