# Docker Documentation

## Overview

RLV-SaaS uses a fully containerized architecture based on Docker Compose. The environment consists of three independent containers connected through an internal Docker network:

|----------------------------------------------|
| Container      | Purpose                     |
| -------------- | --------------------------- |
| `rlv_frontend` | Vue.js frontend application |
| `rlv_backend`  | CodeIgniter 4 REST API      |
| `rlv_mysql`    | MySQL 8.4 LTS database      |
|----------------------------------------------|
---

## Environment Commands

### Build and Start Containers

```bash
docker compose up -d --build
```

Builds all images and starts the complete environment.

### Stop Containers

```bash
docker compose down
```

Stops and removes running containers.

### Rebuild Containers

```bash
docker compose up -d --build
```

Use this command after modifying Dockerfiles or container configurations.

---

## Local Endpoints
|-------------------------------------|
| Service     | URL                   |
| ----------- | --------------------- |
| Frontend    | http://localhost:8081 |
| Backend API | http://localhost:8080 |
| MySQL       | localhost:3307        |
|-------------------------------------|

---

## Useful Commands

### View Running Containers

```bash
docker ps
```

### View Backend Logs

```bash
docker logs rlv_backend
```

### View Frontend Logs

```bash
docker logs rlv_frontend
```

### View Database Logs

```bash
docker logs rlv_mysql
```

### Access Backend Container

```bash
docker exec -it rlv_backend bash
```

### Access Frontend Container

```bash
docker exec -it rlv_frontend sh
```

### Access MySQL Container

```bash
docker exec -it rlv_mysql mysql -u root -p
```

---

## Database Migrations

Run all pending migrations:

```bash
docker compose exec backend php spark migrate
```

Rollback the latest migration batch:

```bash
docker compose exec backend php spark migrate:rollback
```

---

## Database Seeders

Run the user seeder:

```bash
docker compose exec backend php spark db:seed RLVUsersSeeder
```

Run a specific seeder:

```bash
docker compose exec backend php spark db:seed SeederName
```

---

## Verification Checklist

After startup, verify that:

* Frontend is accessible on port 8081.
* Backend API is accessible on port 8080.
* MySQL container is running on port 3307.
* Docker containers report healthy status.
* Database migrations execute successfully.
* Authentication works correctly.

---

## Notes

* The database runs on Linux and is case-sensitive.
* Table names referenced in repositories, models, and migrations must match exactly.
* Environment variables should never be committed to Git.
* Docker is the recommended environment for both development and deployment consistency.
