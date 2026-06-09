# System Architecture

## Overview

RLV-SaaS follows a decoupled full-stack architecture based on three independent services running inside Docker containers.

The system is designed to provide scalability, maintainability, security, and environment consistency between development and production.

---

## Architecture Diagram

Frontend (Vue.js)
        │
        ▼
 REST API (HTTP/JSON)
        │
        ▼
Backend (CodeIgniter 4)
        │
        ▼
     MySQL 8.4

---

## Docker Containers

### rlv_frontend

Single Page Application (SPA) developed with Vue.js.

Responsibilities:

- User interface
- Authentication screens
- Dashboard visualization
- CRUD operations
- API consumption

Technology Stack:

- Vue.js
- Vue Router
- Axios
- Bootstrap

---

### rlv_backend

REST API developed with CodeIgniter 4.

Responsibilities:

- Business logic
- Authentication
- Authorization
- Data validation
- Audit logging
- Database access

Technology Stack:

- PHP 8.3
- CodeIgniter 4
- PDO / MySQL
- RESTful APIs

---

### rlv_mysql

Database service.

Responsibilities:

- Data persistence
- Relational integrity
- Audit storage
- User and role management

Technology Stack:

- MySQL 8.4 LTS

Important:

The database runs in a Linux container, therefore table names are case-sensitive.

Example:

```sql
RLV_Users
```

is different from:

```sql
rlv_users
```

---

## Backend Layer Architecture

The backend follows a layered architecture:

```text
Controller
    │
    ▼
Service
    │
    ▼
Repository
    │
    ▼
Model
    │
    ▼
Database
```

### Controllers

Receive HTTP requests and return JSON responses.

Examples:

- Authentication
- Users
- Roles
- Audit
- Dashboard

### Services

Contain business rules and application logic.

Examples:

- Login validation
- Permission verification
- User management

### Repositories

Encapsulate database queries and data access operations.

### Models

Represent database tables and entity structures.

---

## Authentication Flow

```text
User Login
     │
     ▼
Frontend
     │
     ▼
Auth API
     │
     ▼
Credential Validation
     │
     ▼
User Session
     │
     ▼
Protected Modules
```

---

## Main Modules

### Dashboard

- Statistics
- Activity timeline
- System overview

### Users

- User management
- Account status control
- Session tracking

### Roles

- Role administration
- Permission assignment

### Directory

- Residential directory management

### Audit

- Activity monitoring
- Event traceability
- Maintain and Purge Tables

### Active Users

- Connected users monitoring
- Session information

---

## Deployment Strategy

The project is containerized using Docker Compose.

Services:

- rlv_frontend
- rlv_backend
- rlv_mysql

Benefits:

- Environment consistency
- Fast deployment
- Simplified maintenance
- Production parity
- Easier onboarding for developers

---

## Design Principles

- Separation of concerns
- Layered architecture
- RESTful communication
- Containerized deployment
- Database abstraction
- Scalable code structure
- Security-first approach