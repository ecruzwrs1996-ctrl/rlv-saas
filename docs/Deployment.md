# Deployment Guide

## Production Requirements

* Ubuntu Server 24.04 LTS
* Docker Engine
* Docker Compose
* Git
* Reverse Proxy (Nginx recommended)
* SSL Certificate (Let's Encrypt)

---

## Clone Repository

```bash
git clone https://github.com/ecruzwrs1996-ctrl/rlv-saas.git
cd rlv-saas
```

---

## Configure Environment Variables

Backend:

```bash
cp backend/env backend/.env
```

Update:

```env
CI_ENVIRONMENT=production
database.default.hostname=rlv_mysql
database.default.database=rlv_saas
database.default.username=app_user
database.default.password=strong_password
```

---

## Build Containers

```bash
docker compose build
```

---

## Start Services

```bash
docker compose up -d
```

---

## Run Database Migrations

```bash
docker compose exec backend php spark migrate
```

---

## Run Seeders

```bash
docker compose exec backend php spark db:seed RLVUsersSeeder
```

---

## Verify Containers

```bash
docker ps
```

Expected services:

```text
rlv_frontend
rlv_backend
rlv_mysql
```

---

## Backup Database

Create backup:

```bash
docker exec rlv_mysql mysqldump -u root -p rlv_saas > backup.sql
```

Restore backup:

```bash
docker exec -i rlv_mysql mysql -u root -p rlv_saas < backup.sql
```

---

## Recommended Production Practices

* Enable HTTPS
* Use strong passwords
* Disable development mode
* Restrict database access
* Configure automated backups
* Monitor logs regularly
* Implement firewall rules

---

## Update Procedure

```bash
git pull origin main

docker compose down

docker compose up -d --build
```

Verify:

```bash
docker ps
```
