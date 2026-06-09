# Database Documentation

## Overview

RLV-SaaS uses MySQL 8.4 LTS as its persistence layer. Database schema management is handled through CodeIgniter 4 Migrations, while initial data population is managed through Seeders.

The database is deployed inside the `rlv_mysql` Docker container and follows Linux case-sensitive naming conventions.

---

## Initialization Commands

### Run All Pending Migrations

```bash
docker compose exec backend php spark migrate
```

### Rollback Last Migration Batch

```bash
docker compose exec backend php spark migrate:rollback
```

### Execute User Seeder

```bash
docker compose exec backend php spark db:seed RLVUsersSeeder
```

---

## Naming Convention

Table names follow PascalCase naming standards to ensure compatibility with Linux-based environments.

Example:

```text
RLV_Users
RLV_Roles
RLV_ActiveUsers
```

Avoid using lowercase references such as:

```text
rlv_users
rlv_roles
rlv_active_users
```

Linux environments are case-sensitive and may generate runtime errors if table names do not match exactly.

---

## Core Tables

### RLV_Users

Stores application users.

Main information:

* User credentials
* User status
* Authentication data
* Role assignment
* Login information

---

### RLV_Roles

Stores system roles and access profiles.

Examples:

* Super Administrator
* Administrator
* Operator
* Resident

---

### RLV_Permissions

Stores available permissions within the application.

Examples:

* Create Users
* Edit Users
* Delete Users
* View Audit Logs

---

### RLV_RolePermissions

Many-to-many relationship between roles and permissions.

Defines what actions each role is allowed to perform.

---

### RLV_ActiveUsers

Tracks active user sessions.

Used by:

* Active Users Dashboard
* Session Monitoring
* Security Auditing

---

### RLV_AuditLogs

Stores system activity records.

Examples:

* User login
* User logout
* Record creation
* Record modification
* Record deletion

---

## Database Lifecycle

1. Create containers.
2. Run migrations.
3. Execute seeders.
4. Verify generated tables.
5. Validate login and permissions.

---

## Verification Commands

List database tables:

```bash
docker exec -it rlv_mysql mysql -u root -p
```

```sql
USE rlv_saas;
SHOW TABLES;
```

View user records:

```sql
SELECT * FROM RLV_Users;
```

View roles:

```sql
SELECT * FROM RLV_Roles;
```

---

## Notes

* All schema changes must be implemented through migrations.
* Manual table modifications should be avoided.
* Seeders should only contain initialization or testing data.
* Production data must never be stored inside seeders.
* Docker is the official development environment for database consistency.
