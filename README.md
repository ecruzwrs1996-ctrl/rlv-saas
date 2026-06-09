# RLV-SaaS (Residential Local Verification)

## Overview

Welcome to **RLV-SaaS**, a full-stack enterprise platform designed for residential access management, auditing, user administration, and operational control in high-security environments.

The system follows a decoupled architecture with independent frontend, backend, and database layers. Docker containerization ensures consistency between development, testing, and production environments while reducing deployment and compatibility issues.

---

## Main Features

* JWT-based authentication and authorization
* User management
* Role management
* Permissions management
* Active users monitoring
* Audit and activity logging
* Dashboard analytics
* Responsive user interface
* RESTful API architecture
* Dockerized deployment environment

---

## Technology Stack

### Frontend

* Vue.js
* Vue Router
* Axios
* Bootstrap

### Backend

* PHP 8.3
* CodeIgniter 4
* JWT Authentication

### Database

* MySQL 8.4 LTS

### DevOps

* Docker
* Docker Compose
* Git

---

## Project Architecture

The application is composed of three independent containers connected through an internal Docker network:

### Frontend Container (rlv_frontend)

A Single Page Application (SPA) built with Vue.js that provides the user interface and communicates with the backend API.

### Backend Container (rlv_backend)

A RESTful API built with CodeIgniter 4 that handles business logic, authentication, authorization, auditing, and database operations.

### Database Container (rlv_mysql)

A MySQL 8.4 database server responsible for persistent data storage.

---

## System Architecture Diagram

Frontend (Vue.js)
↓
REST API
↓
Backend (CodeIgniter 4)
↓
Repositories
↓
Models
↓
MySQL Database

---

## Prerequisites

Before installing the project, make sure you have the following software installed:

* Docker Desktop
* Docker Compose
* Git

Windows users should have WSL2 enabled.

---

## Installation

### Clone the Repository

```bash
git clone https://github.com/ecruzwrs1996-ctrl/rlv-saas.git

cd RLV-SaaS
```

### Build Containers

```bash
docker compose up -d --build
```

### Verify Running Containers

```bash
docker ps
```

Expected containers:

```text
rlv_frontend
rlv_backend
rlv_mysql
```

---

## Database Migration

Run all database migrations:

```bash
docker compose exec backend php spark migrate
```

---

## Database Seeders

Populate initial system data:

```bash
docker compose exec backend php spark db:seed RLVUsersSeeder
```

---

## Access URLs

### Frontend

```text
http://localhost:8081
```

### Backend API

```text
http://localhost:8080
```

---

## Project Structure

```text
RLV-SaaS
│
├── backend
│   ├── app
│   ├── public
│   ├── writable
│   └── vendor
│
├── frontend
│   ├── src
│   ├── public
│   └── node_modules
│
├── docker
│   ├── backend
│   └── frontend
│
├── docs
│   ├── Achitecture.md
│   ├── Docker.md
│   ├── Database.md
│   └── Credentials.md
│
└── docker-compose.yml
```

---

## Documentation

Additional project documentation is available in the `/docs` directory.

* Architecture.md
* Docker.md
* Database.md
* Credentials.md

### Diagrams

- Entity Relationship Diagram (ERD)
- Business Process Flow Diagram

### Manuals

- User Manual

---

## Version

Current Release:

```text
v1.0.0
```

---

## License

This project is intended for educational, internal, and commercial use according to the owner's requirements.

All rights reserved.
