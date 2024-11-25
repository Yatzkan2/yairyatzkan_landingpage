# Media Supreme Landing Page

## Description

This project is a landing page application designed to capture leads and manage them through an admin control page.  

## Build Instructions

To build and run the project using Docker, follow these steps:

1. **Clone the repository:**
    ```bash
    cd yairyatzkan_landingpage
    ```

2. **Build and start the services:**
    ```bash
    docker-compose up --build
    ```

    Landing page (frontend) : [http://localhost:8003/](http://localhost:8003/)
    
    Admin (backend) : [http://localhost:83/admin/](http://localhost:83/admin/)
    
    username: username

    password: 1234

## Backend

### Overview
```bash 
backend
├── Dockerfile
├── admin/ 
│   ├── index.php #main admin control page
│   ├── login.php #admin login
│   ├── logout.php #logout from admin user
│   └── styles.css
├── config.php #system configuration
├── db_ops.php #Database functions
├── dev_scripts/ #scripts that used during development but not part of the system
│   ├── hash.php #hashing the admin password
│   └── seed.php #creating the Database initial leads using curl
├── index.php #redircting to control page (/admin/index.php)
└── submit.php #handling the request from the landing page (adding leads from the frontend)
```

## Frontend

### Overview
```bash
frontend
├── Dockerfile
├── css/ #from provided template 
├── fonts/ #from provided template
├── images/ #from provided template
├── index.html #from provided template. edited
├── js
│   └── scripts.js #submitting the form to 'submit.php'
└── videos/ #from provided template
```

### Description
The landing page is taken from one of the templates provided. The only edition was ```js/scripts.js``` wehere the request is sent to the backend according to tasks demands.

## Database

### Overview
```bash
db
├── Dockerfile
└── setup.sql #setup initial tables taken from 'seed.php' and 'hash.php'
```
### Tables
leads
```
+----------------+--------------+-------------------+
| Column         | Type         | Description       |
+----------------+--------------+-------------------+
| id             | INT          | Primary Key       |
| first_name     | VARCHAR(255) | First Name        |
| last_name      | VARCHAR(255) | Last Name         |
| email          | VARCHAR(255) | Email (Unique)    |
| phone_number   | VARCHAR(20)  | Phone Number      |
| ip             | VARCHAR(45)  | IP Address        |
| country        | VARCHAR(100) | Country           |
| url            | TEXT         | URL               |
| note           | TEXT         | Note              |
| sub_1          | TEXT         | Additional Field  |
| called         | BOOLEAN      | Called Status     |
| created_at     | TIMESTAMP    | Creation Time     |
+----------------+--------------+-------------------+
```

admins
```
+-------------+--------------+-------------------------+
| Column      | Type         | Description             |
+-------------+--------------+-------------------------+
| id          | INT          | Primary Key             |
| username    | VARCHAR(255) | Username (Unique)       |
| password    | VARCHAR(255) | Hashed Password         |
+-------------+--------------+-------------------------+
```

 
