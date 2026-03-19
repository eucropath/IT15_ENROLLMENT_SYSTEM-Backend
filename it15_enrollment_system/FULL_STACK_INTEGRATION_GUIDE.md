# Full-Stack IT15 Enrollment System Integration Guide

## Overview

This guide explains how to connect the **saycon-react-app** (React Frontend) with the **it15_enrollment_system** (Laravel Backend) as a complete RESTful API-based full-stack application.

---

## Architecture

```
┌─────────────────────────────────────────┐
│     SAYCON-react-app (React + Vite)     │
│     http://localhost:5173                │
│                                         │
│  • Authentication UI                    │
│  • Student Dashboard                    │
│  • Course Management                    │
│  • Enrollment Forms                     │
│  • School Calendar                      │
└──────────────┬──────────────────────────┘
               │ HTTP/REST API
               │ Bearer Token Auth
               │
               ▼
┌──────────────────────────────────────────┐
│  it15_enrollment_system (Laravel 11)     │
│  http://localhost:8000/api                │
│                                          │
│  ✓ Authentication (Laravel Sanctum)      │
│  ✓ Student CRUD Operations               │
│  ✓ Course Management                     │
│  ✓ Enrollment Management                 │
│  ✓ School Day Management                 │
│  ✓ Data Validation & Business Logic      │
└──────────────┬───────────────────────────┘
               │
               ▼
        ┌─────────────────┐
        │   MySQL DB      │
        │ it15_enrollment │
        └─────────────────┘
```

---

## Prerequisites

### Backend Requirements
- PHP 8.0 or higher
- MySQL 5.7 or higher
- Composer
- Laravel 11

### Frontend Requirements
- Node.js 16 or higher
- npm or yarn
- React 19
- Vite

---

## Backend Setup

### 1. Install Dependencies

```bash
cd C:\Users\ACER\Downloads\it15_enrollment_system
composer install
```

### 2. Environment Configuration

The `.env` file is already configured with:
- **MySQL Database**: `it15_enrollment`
- **App URL**: `http://localhost:8000`
- **CORS**: Enabled for all origins (configured in `config/cors.php`)

### 3. Generate Application Key

```bash
php artisan key:generate
```

### 4. Run Database Migrations

```bash
php artisan migrate:fresh --seed
```

This will:
- Create all database tables
- Run seeders to populate sample data
- Create authentication tables for Laravel Sanctum

### 5. Start the Development Server

```bash
php artisan serve
```

The backend will be available at: **http://localhost:8000**

### 6. API Base URL

The API is available at: **http://localhost:8000/api**

---

## Frontend Setup

### 1. Install Dependencies

```bash
cd C:\Users\ACER\Downloads\SAYCON-react-app
npm install
```

### 2. Configuration

The `.env` file is already configured with:
```
VITE_API_BASE_URL=http://localhost:8000/api
```

### 3. Start the Development Server

```bash
npm run dev
```

The frontend will be available at: **http://localhost:5173**

---

## API Endpoints

### Authentication Endpoints (Public)

| Endpoint | Method | Description | Body |
|----------|--------|-------------|------|
| `/api/auth/login` | POST | User login | `{ username, password }` |
| `/api/auth/register` | POST | User registration | `{ username, email, password, password_confirmation }` |

### Protected Endpoints (Requires Token)

#### Student Management
| Endpoint | Method | Description |
|----------|--------|-------------|
| `/api/students` | GET | List all students (paginated) |
| `/api/students/{id}` | GET | Get specific student |
| `/api/students` | POST | Create new student |
| `/api/students/{id}` | PUT | Update student |
| `/api/students/{id}` | DELETE | Delete student |
| `/api/students/{id}/courses` | GET | Get student's enrolled courses |
| `/api/students/{id}/enrollments` | GET | Get student's enrollments |

#### Course Management
| Endpoint | Method | Description |
|----------|--------|-------------|
| `/api/courses` | GET | List all courses (paginated) |
| `/api/courses/{id}` | GET | Get specific course |
| `/api/courses` | POST | Create new course |
| `/api/courses/{id}` | PUT | Update course |
| `/api/courses/{id}` | DELETE | Delete course |
| `/api/courses/{id}/students` | GET | Get students in a course |

#### Enrollment Management
| Endpoint | Method | Description | Body |
|----------|--------|-------------|------|
| `/api/enrollments` | GET | List all enrollments (paginated) | |
| `/api/enrollments/{id}` | GET | Get specific enrollment | |
| `/api/enrollments` | POST | Create enrollment | `{ student_id, course_id }` |
| `/api/enrollments/{id}` | DELETE | Delete enrollment | |

#### School Days
| Endpoint | Method | Description | Body |
|----------|--------|-------------|------|
| `/api/school-days` | GET | List all school days | |
| `/api/school-days/{id}` | GET | Get specific school day | |
| `/api/school-days` | POST | Create school day | `{ date, day_type, description, is_school_day, academic_year }` |
| `/api/school-days/{id}` | PUT | Update school day | |
| `/api/school-days/{id}` | DELETE | Delete school day | |
| `/api/school-days/active/days` | GET | Get active school days | |

#### Authentication
| Endpoint | Method | Description |
|----------|--------|-------------|
| `/api/auth/profile` | GET | Get current user profile |
| `/api/auth/refresh` | POST | Refresh authentication token |
| `/api/auth/logout` | POST | Logout user |

---

## Authentication Flow

### Login Process

1. **Frontend** sends login request:
```javascript
const response = await login(username, password);
```

2. **Backend** validates credentials and returns:
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "user": { "id": 1, "name": "username", "email": "user@example.com" },
    "token": "AbCdEf123456...",
    "token_type": "Bearer"
  }
}
```

3. **Frontend** stores token:
```javascript
localStorage.setItem('auth_token', response.data.token);
localStorage.setItem('auth_user', JSON.stringify(response.data.user));
```

4. **All subsequent requests** include token in header:
```
Authorization: Bearer {token}
```

### Protected Endpoints

All protected endpoints require the `Authorization: Bearer {token}` header. The frontend API service automatically includes this for authenticated requests.

---

## Data Models

### Student
```json
{
  "id": 1,
  "student_number": "CS-2021-001",
  "first_name": "Juan",
  "last_name": "Dela Cruz",
  "email": "juan@example.com",
  "created_at": "2026-02-14T10:00:00Z",
  "updated_at": "2026-02-14T10:00:00Z"
}
```

### Course
```json
{
  "id": 1,
  "course_code": "CS101",
  "course_name": "Introduction to Computer Science",
  "capacity": 50,
  "created_at": "2026-02-14T10:00:00Z",
  "updated_at": "2026-02-14T10:00:00Z"
}
```

### Enrollment
```json
{
  "id": 1,
  "student_id": 1,
  "course_id": 1,
  "created_at": "2026-02-14T10:00:00Z",
  "updated_at": "2026-02-14T10:00:00Z"
}
```

### School Day
```json
{
  "id": 1,
  "date": "2026-03-19",
  "day_type": "regular",
  "description": "Regular class day",
  "is_school_day": true,
  "academic_year": "2025-2026",
  "created_at": "2026-03-19T10:00:00Z",
  "updated_at": "2026-03-19T10:00:00Z"
}
```

---

## Running Both Servers

### Option 1: Using Separate Terminals

**Terminal 1 - Backend:**
```bash
cd C:\Users\ACER\Downloads\it15_enrollment_system
php artisan serve
```

**Terminal 2 - Frontend:**
```bash
cd C:\Users\ACER\Downloads\SAYCON-react-app
npm run dev
```

### Option 2: Using PowerShell Script

Create a file `START_FULL_STACK.ps1`:

```powershell
# Start backend
Start-Process powershell {
    cd "C:\Users\ACER\Downloads\it15_enrollment_system"
    php artisan serve
}

# Start frontend
Start-Process powershell {
    cd "C:\Users\ACER\Downloads\SAYCON-react-app"
    npm run dev
}

Write-Host "Both servers starting..."
Write-Host "Backend: http://localhost:8000"
Write-Host "Frontend: http://localhost:5173"
```

Run with:
```bash
powershell -ExecutionPolicy Bypass -File START_FULL_STACK.ps1
```

---

## Testing the Integration

### 1. Test Authentication

**Using curl:**
```bash
# Register
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "username": "testuser",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'

# Login
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "username": "testuser",
    "password": "password123"
  }'
```

### 2. Test Protected Endpoints

**Get all students:**
```bash
curl -X GET http://localhost:8000/api/students \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

### 3. Test with Frontend

1. Open http://localhost:5173 in browser
2. Login with credentials
3. Navigate to student/course management areas
4. Perform CRUD operations

---

## Common Issues & Solutions

### Issue: CORS Error
**Solution:** CORS is already configured in `config/cors.php` to allow all origins.

### Issue: Token Expired
**Solution:** The frontend automatically handles token expiration and can refresh.

### Issue: Database Connection Error
**Solution:** Ensure:
- MySQL is running
- `.env` database credentials are correct
- Run `php artisan migrate:fresh --seed`

### Issue: Port Already in Use
**Alternative ports:**
```bash
# Backend on port 8001
php artisan serve --port=8001

# Frontend on port 5174
npm run dev -- --port 5174
```

---

## Development Notes

### Backend Changes Made

1. **Created AuthController** - Handles login, register, and token management
2. **Created SchoolDayController** - Manages school day operations
3. **Updated API Routes** - Added authentication and protected routes
4. **Enhanced Controllers** - Updated Student, Course, Enrollment controllers with consistent response format
5. **Updated Models** - Added relationships and proper table definitions

### Frontend Changes Made

1. **Added SchoolDay API functions** - For school day operations
2. **API Service** - Already supports backend integration with automatic token handling

### Response Format

All API responses follow this standard format:

```json
{
  "success": true,
  "message": "Operation successful",
  "data": { /* Response data */ }
}
```

---

## Next Steps

1. **Populate Demo Data:** Run seeders to add sample students and courses
2. **Test All Endpoints:** Use Postman or curl to test all API endpoints
3. **Frontend UI:** Update React components to fully utilize all API endpoints
4. **Error Handling:** Add more specific error handling in frontend
5. **Validation:** Add client-side validation for form inputs

---

## API Documentation Reference

For quick reference, all available endpoints are documented in:
- **Backend:** `API_DOCUMENTATION.md` in the Laravel project
- **Frontend:** `src/services/api.js` contains all API function signatures

---

## Support

For issues or questions regarding the integration, check:
1. Browser console (frontend errors)
2. Laravel logs: `storage/logs/laravel.log`
3. Network tab in browser DevTools (API requests)

---

**Last Updated:** March 19, 2026
**Version:** 1.0
**Status:** Ready for Development/Testing
