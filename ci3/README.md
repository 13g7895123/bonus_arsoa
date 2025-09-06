# CodeIgniter 3 Docker Project

This is a CodeIgniter 3 project with Docker configuration.

## Quick Start

1. Copy `.env.example` to `.env` and adjust the port settings:
```bash
cp .env.example .env
```

2. Build and start the containers:
```bash
docker-compose up -d --build
```

3. Access the application:
- Web Application: http://localhost:8080
- phpMyAdmin: http://localhost:8081

## Environment Configuration

Edit the `.env` file to customize ports and database settings:

```env
# Docker Compose Environment Variables
WEB_PORT=8080
DB_PORT=3306
PMA_PORT=8081

# Database Configuration
DB_ROOT_PASSWORD=rootpassword
DB_NAME=ci3_database
DB_USER=ci3_user
DB_PASSWORD=ci3_password
```

## Services

- **nginx**: Nginx web server
- **php**: PHP 7.4 with FPM
- **db**: MySQL 5.7
- **phpmyadmin**: Database management interface

## Directory Structure

```
ci3/
├── application/          # CodeIgniter application files
├── docker/
│   └── nginx/
│       └── nginx.conf   # Nginx server configuration
├── docker-compose.yml   # Docker Compose configuration
├── Dockerfile.php      # Custom PHP-FPM Docker image
├── .env               # Environment variables
└── README.md          # This file
```