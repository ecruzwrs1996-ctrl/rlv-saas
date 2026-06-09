# Development Credentials

## Overview

The following accounts are intended exclusively for local development, testing, and validation environments.

Passwords are stored in the database using BCRYPT hashing and are never persisted as plaintext.

---

## Default Test Users

| Role                | Username     |
| ------------------- | ------------ |
| Super Administrator | `SysAdm`     |
| Administrator       | `Admin`      |
| Security Guard      | `Guardia_01` |

---

## Seeder

Test accounts are generated automatically by:

```bash
docker compose exec backend php spark db:seed RLVUsersSeeder
```

---

## Authentication Notes

* User passwords are hashed using BCRYPT.
* Authentication is handled through the backend API.
* User permissions are assigned through roles.
* Access control follows Role-Based Access Control (RBAC) principles.

---

## Security Notice

Development credentials must never be used in production environments.

Production users should be created through the application and assigned secure passwords according to organizational security policies.
