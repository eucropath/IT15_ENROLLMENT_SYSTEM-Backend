# Laravel Backend API Configuration for saycon-react-app

This document explains how to connect the `saycon-react-app` React frontend to this Laravel enrollment system backend.

## Backend API Endpoints

The Laravel backend provides the following API endpoints (all prefixed with `/api`):

### Students
- `GET /api/students` - Get all students
- `GET /api/students/{id}` - Get a specific student with enrolled courses
- `POST /api/students` - Create a new student
- `PUT /api/students/{id}` - Update a student
- `DELETE /api/students/{id}` - Delete a student

### Courses
- `GET /api/courses` - Get all courses
- `GET /api/courses/{id}` - Get a specific course with enrolled students
- `POST /api/courses` - Create a new course
- `PUT /api/courses/{id}` - Update a course
- `DELETE /api/courses/{id}` - Delete a course

### Enrollments
- `GET /api/enrollments` - Get all enrollments
- `POST /api/enrollments` - Enroll a student in a course
- `DELETE /api/enrollments/{id}` - Delete an enrollment

## Frontend Configuration

Create a `.env.local` file in your React project root with the following variables:

```env
VITE_API_URL=http://localhost:8000/api
```

If running on a different backend URL:

```env
VITE_API_URL=http://your-backend-domain.com/api
```

## API Request Examples

### Get All Students
```http
GET http://localhost:8000/api/students
```

**Response:**
```json
[
  {
    "id": 1,
    "student_number": "2024001",
    "first_name": "John",
    "last_name": "Doe",
    "email": "john.doe@example.com",
    "created_at": "2026-02-14T...",
    "updated_at": "2026-02-14T..."
  }
]
```

### Create a Student
```http
POST http://localhost:8000/api/students
Content-Type: application/json

{
  "student_number": "2024002",
  "first_name": "Jane",
  "last_name": "Smith",
  "email": "jane.smith@example.com"
}
```

**Response (201 Created):**
```json
{
  "id": 2,
  "student_number": "2024002",
  "first_name": "Jane",
  "last_name": "Smith",
  "email": "jane.smith@example.com",
  "created_at": "2026-03-19T...",
  "updated_at": "2026-03-19T..."
}
```

### Get All Courses
```http
GET http://localhost:8000/api/courses
```

**Response:**
```json
[
  {
    "id": 1,
    "course_code": "CS101",
    "course_name": "Introduction to Computer Science",
    "capacity": 30,
    "created_at": "2026-02-14T...",
    "updated_at": "2026-02-14T..."
  }
]
```

### Create a Course
```http
POST http://localhost:8000/api/courses
Content-Type: application/json

{
  "course_code": "CS102",
  "course_name": "Data Structures",
  "capacity": 25
}
```

### Enroll a Student in a Course
```http
POST http://localhost:8000/api/enrollments
Content-Type: application/json

{
  "student_id": 1,
  "course_id": 1
}
```

**Success Response (201 Created):**
```json
{
  "message": "Enrollment successful."
}
```

**Error Response (409 Conflict):**
```json
{
  "error": "Course is already full."
}
```

or

```json
{
  "error": "Student already enrolled."
}
```

### Get a Student with Their Courses
```http
GET http://localhost:8000/api/students/1
```

**Response:**
```json
{
  "id": 1,
  "student_number": "2024001",
  "first_name": "John",
  "last_name": "Doe",
  "email": "john.doe@example.com",
  "courses": [
    {
      "id": 1,
      "course_code": "CS101",
      "course_name": "Introduction to Computer Science",
      "capacity": 30,
      "pivot": {
        "student_id": 1,
        "course_id": 1
      }
    }
  ]
}
```

## React Frontend Integration Example

Here's a sample hook to fetch students from the API:

```javascript
import { useState, useEffect } from 'react';

export function useStudents() {
  const [students, setStudents] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  const apiUrl = import.meta.env.VITE_API_URL;

  useEffect(() => {
    fetch(`${apiUrl}/students`)
      .then(res => res.json())
      .then(data => {
        setStudents(data);
        setLoading(false);
      })
      .catch(err => {
        setError(err);
        setLoading(false);
      });
  }, []);

  return { students, loading, error };
}
```

## Running the Backend Server

Start the Laravel development server:

```bash
php artisan serve
```

The API will be available at `http://localhost:8000/api`

## CORS Configuration

CORS is configured in `config/cors.php` to allow requests from:
- All origins: `*`
- All HTTP methods
- All headers

Update the `allowed_origins` in `config/cors.php` for production to only allow your frontend domain:

```php
'allowed_origins' => ['https://saycon-react-app.com'],
```

## Error Handling

All API errors return appropriate HTTP status codes:
- `400` - Bad Request (validation failure)
- `404` - Not Found
- `409` - Conflict (duplicate enrollment, course full)
- `500` - Server Error

Error responses include a message:
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "student_number": ["The student number has already been taken."]
  }
}
```

## Database Models

### Student Model
- `id` - Primary key
- `student_number` - Unique student identifier
- `first_name` - Student's first name
- `last_name` - Student's last name
- `email` - Unique email address
- `courses()` - Relationship to courses (many-to-many)

### Course Model
- `id` - Primary key
- `course_code` - Unique course code
- `course_name` - Name of the course
- `capacity` - Maximum number of students
- `students()` - Relationship to students (many-to-many)

### Enrollment Model
- `id` - Primary key
- `student_id` - Foreign key to students
- `course_id` - Foreign key to courses
- `student()` - Relationship to student
- `course()` - Relationship to course
