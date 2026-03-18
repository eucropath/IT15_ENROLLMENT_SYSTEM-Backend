# IT-15 Student Enrollment System - Project Documentation

## Overview

The **IT-15 Student Enrollment System** is a modern web application built with **Laravel 12** on the backend and **React** on the frontend. It manages student enrollments, courses, and academic scheduling for educational institutions.

This system provides a complete RESTful API for managing:
- Students and their information
- Courses and their capacity limits
- Student enrollments in courses
- School days and academic calendar

## Table of Contents

1. [Project Structure](#project-structure)
2. [Technology Stack](#technology-stack)
3. [Setup Instructions](#setup-instructions)
4. [Database Schema](#database-schema)
5. [Models & Relationships](#models--relationships)
6. [API Endpoints](#api-endpoints)
7. [Frontend Integration](#frontend-integration)
8. [Running the Application](#running-the-application)
9. [Development Workflow](#development-workflow)
10. [Database Seeders](#database-seeders)
11. [Testing](#testing)

---

## Project Structure

```
it15_enrollment_system/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── StudentController.php       # Student management API
│   │       ├── CourseController.php        # Course management API
│   │       └── EnrollmentController.php    # Enrollment management API
│   ├── Models/
│   │   ├── Student.php                    # Student model with relationships
│   │   ├── Course.php                     # Course model with relationships
│   │   ├── Enrollment.php                 # Enrollment pivot model
│   │   ├── SchoolDay.php                  # Academic calendar model
│   │   └── User.php                       # User authentication model
│   └── Providers/
│       └── AppServiceProvider.php         # Application service configuration
├── bootstrap/
│   ├── app.php                            # Application initialization
│   └── providers.php                      # Service provider bootstrap
├── config/
│   ├── app.php                            # Application configuration
│   ├── auth.php                           # Authentication config
│   ├── database.php                       # Database configuration
│   ├── cors.php                           # CORS configuration
│   └── ...                                # Other configurations
├── database/
│   ├── migrations/                        # Database schema migrations
│   │   ├── create_users_table.php
│   │   ├── create_students_table.php
│   │   ├── create_courses_table.php
│   │   ├── create_enrollments_table.php
│   │   └── create_school_days_table.php
│   ├── factories/
│   │   └── UserFactory.php               # Model factories for testing
│   └── seeders/
│       ├── DatabaseSeeder.php            # Main seeder
│       ├── StudentSeeder.php             # Student seeding
│       ├── CourseSeeder.php              # Course seeding
│       ├── EnrollmentSeeder.php          # Enrollment seeding
│       └── SchoolDaySeeder.php           # School day seeding
├── public/
│   ├── index.php                          # Application entry point
│   └── robots.txt
├── resources/
│   ├── css/
│   │   └── app.css                        # Application styles
│   ├── js/
│   │   ├── app.js                         # Main application JavaScript
│   │   └── bootstrap.js                   # Bootstrap configuration
│   └── views/
│       └── welcome.blade.php              # Welcome view
├── routes/
│   ├── web.php                            # Web routes (traditional views)
│   ├── api.php                            # API routes (JSON endpoints)
│   └── console.php                        # Console commands
├── storage/                               # Application storage
├── tests/                                 # Test files
├── vendor/                                # Composer dependencies
├── .env.example                           # Environment variables template
├── artisan                                # Laravel CLI tool
├── composer.json                          # PHP dependencies
├── package.json                           # NPM dependencies
├── vite.config.js                         # Vite bundler configuration
├── phpunit.xml                            # PHPUnit test configuration
├── README.md                              # Framework documentation
├── SEEDERS_DOCUMENTATION.md               # Seeder documentation
└── API_DOCUMENTATION.md                   # API endpoint documentation
```

---

## Technology Stack

### Backend
- **Framework**: Laravel 12.0
- **PHP**: ^8.2
- **Database**: SQLite (configurable)
- **ORM**: Eloquent
- **API**: RESTful JSON API
- **CORS**: Fruitcake/PHP-CORS

### Frontend Integration
- **Framework**: React
- **HTTP Client**: Fetch API
- **Build Tool**: Vite
- **Package Manager**: NPM

### Development Tools
- **Testing**: PHPUnit 11.5
- **Code Formatting**: Laravel Pint
- **Database CLI**: Laravel Tinker
- **Debugging**: Laravel Pail
- **Task Runner**: Artisan

---

## Setup Instructions

### Prerequisites

- PHP >= 8.2
- Composer
- Node.js & NPM
- SQLite or MySQL
- Git

### Installation Steps

1. **Clone or navigate to the project directory**
   ```bash
   cd it15_enrollment_system
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Create environment configuration**
   ```bash
   cp .env.example .env
   ```

4. **Generate application key**
   ```bash
   php artisan key:generate
   ```

5. **Create database file** (for SQLite)
   ```bash
   touch database/database.sqlite
   ```

6. **Run migrations**
   ```bash
   php artisan migrate
   ```

7. **Seed the database** (optional)
   ```bash
   php artisan db:seed
   ```

8. **Install NPM dependencies**
   ```bash
   npm install
   ```

9. **Build frontend assets**
   ```bash
   npm run build
   ```

### Quick Setup

Use the provided setup script:

```bash
composer run setup
```

This will automatically:
- Install composer dependencies
- Copy `.env.example` to `.env`
- Generate application key
- Run migrations
- Install NPM dependencies
- Build assets

---

## Database Schema

### Users Table
```sql
CREATE TABLE users (
  id BIGINT PRIMARY KEY,
  name VARCHAR
  email VARCHAR UNIQUE,
  email_verified_at TIMESTAMP,
  password VARCHAR,
  remember_token VARCHAR,
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);
```

### Students Table
```sql
CREATE TABLE students (
  id BIGINT PRIMARY KEY,
  student_number VARCHAR UNIQUE,
  first_name VARCHAR,
  last_name VARCHAR,
  email VARCHAR UNIQUE,
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);
```

### Courses Table
```sql
CREATE TABLE courses (
  id BIGINT PRIMARY KEY,
  course_code VARCHAR UNIQUE,
  course_name VARCHAR,
  capacity INT,
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);
```

### Enrollments Table (Pivot Table)
```sql
CREATE TABLE enrollments (
  id BIGINT PRIMARY KEY,
  student_id BIGINT FOREIGN KEY,
  course_id BIGINT FOREIGN KEY,
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);
```

### School Days Table
```sql
CREATE TABLE school_days (
  id BIGINT PRIMARY KEY,
  date DATE,
  day_type VARCHAR,
  description TEXT,
  is_school_day BOOLEAN,
  academic_year VARCHAR,
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);
```

---

## Models & Relationships

### Student Model
**Location**: `app/Models/Student.php`

**Attributes**:
- `id` - Primary key
- `student_number` - Unique student ID
- `first_name` - Student's first name
- `last_name` - Student's last name
- `email` - Unique email address
- `created_at` - Record creation timestamp
- `updated_at` - Record update timestamp

**Relationships**:
- `courses()` - Many-to-many relationship with courses through enrollments

**Methods**:
```php
$student = Student::find(1);
$student->courses;  // Get all enrolled courses
$student->courses()->attach($courseId);  // Enroll in a course
$student->courses()->detach($courseId);  // Unenroll from a course
```

### Course Model
**Location**: `app/Models/Course.php`

**Attributes**:
- `id` - Primary key
- `course_code` - Unique course code
- `course_name` - Name of the course
- `capacity` - Maximum number of students
- `created_at` - Record creation timestamp
- `updated_at` - Record update timestamp

**Relationships**:
- `students()` - Many-to-many relationship with students through enrollments

**Methods**:
```php
$course = Course::find(1);
$course->students;  // Get all enrolled students
$enrolledCount = $course->students()->count();
$availableSeats = $course->capacity - $enrolledCount;
```

### Enrollment Model
**Location**: `app/Models/Enrollment.php`

**Purpose**: Pivot table for the Student-Course many-to-many relationship

**Attributes**:
- `id` - Primary key
- `student_id` - Foreign key to students table
- `course_id` - Foreign key to courses table
- `created_at` - Enrollment timestamp
- `updated_at` - Enrollment update timestamp

### SchoolDay Model
**Location**: `app/Models/SchoolDay.php`

**Attributes**:
- `id` - Primary key
- `date` - Date of the school day
- `day_type` - Type (e.g., 'regular', 'holiday', 'exam')
- `description` - Description for the day
- `is_school_day` - Boolean flag (true for school days)
- `academic_year` - Academic year (e.g., '2025-2026')
- `created_at` - Record creation timestamp
- `updated_at` - Record update timestamp

**Casts**:
- `date` - Cast to Carbon date instance
- `is_school_day` - Cast to boolean

---

## API Endpoints

All API endpoints are prefixed with `/api` and return JSON responses.

### Students API

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/students` | Get all students |
| GET | `/api/students/{id}` | Get a specific student with courses |
| POST | `/api/students` | Create a new student |
| PUT | `/api/students/{id}` | Update a student |
| DELETE | `/api/students/{id}` | Delete a student |

### Courses API

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/courses` | Get all courses |
| GET | `/api/courses/{id}` | Get a specific course with enrolled students |
| POST | `/api/courses` | Create a new course |
| PUT | `/api/courses/{id}` | Update a course |
| DELETE | `/api/courses/{id}` | Delete a course |

### Enrollments API

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/enrollments` | Get all enrollments |
| POST | `/api/enrollments` | Enroll a student in a course |
| DELETE | `/api/enrollments/{id}` | Delete an enrollment |

For detailed API examples and response formats, see [API_DOCUMENTATION.md](API_DOCUMENTATION.md).

---

## Frontend Integration

### Configuration

Add the backend API URL to your React app's `.env.local`:

```env
VITE_API_URL=http://localhost:8000/api
```

### Usage Example

```javascript
import { useState, useEffect } from 'react';

function StudentsList() {
  const [students, setStudents] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const apiUrl = import.meta.env.VITE_API_URL;
    
    fetch(`${apiUrl}/students`)
      .then(res => res.json())
      .then(data => {
        setStudents(data);
        setLoading(false);
      })
      .catch(err => console.error(err));
  }, []);

  if (loading) return <div>Loading...</div>;

  return (
    <ul>
      {students.map(student => (
        <li key={student.id}>
          {student.first_name} {student.last_name}
        </li>
      ))}
    </ul>
  );
}
```

### CORS Configuration

CORS is enabled for all origins in development. For production, update `config/cors.php`:

```php
'allowed_origins' => ['https://your-react-app-domain.com'],
```

---

## Running the Application

### Development Server

Start both backend and frontend with hot-reload:

```bash
composer run dev
```

This command runs:
1. PHP Laravel server on `http://localhost:8000`
2. Queue listener
3. Pail log viewer
4. Vite development server on `http://localhost:5173`

### Individual Services

**Start Laravel backend only:**
```bash
php artisan serve
```
- Available at: `http://localhost:8000`
- API at: `http://localhost:8000/api`

**Start Vite dev server only:**
```bash
npm run dev
```

**Build for production:**
```bash
npm run build
```

### Container/Docker

The project includes Laravel Sail for containerized development:

```bash
./vendor/bin/sail up
```

---

## Development Workflow

### Creating New Features

1. **Create a model with migration**
   ```bash
   php artisan make:model Feature -m
   ```

2. **Create a controller**
   ```bash
   php artisan make:controller FeatureController --resource
   ```

3. **Add routes to `routes/api.php`**
   ```php
   Route::apiResource('features', FeatureController::class);
   ```

4. **Implement the controller methods** to return JSON responses

5. **Test the endpoint**
   ```bash
   curl http://localhost:8000/api/features
   ```

### Code Quality

**Format code using Pint:**
```bash
php artisan pint
```

**Run tests:**
```bash
composer test
```

**Clear configuration cache:**
```bash
php artisan config:clear
```

---

## Database Seeders

The project includes seeders to populate test data. See [SEEDERS_DOCUMENTATION.md](SEEDERS_DOCUMENTATION.md) for detailed information.

### Seed the Database

```bash
php artisan db:seed
```

### Seed Specific Classes

```bash
php artisan db:seed --class=StudentSeeder
php artisan db:seed --class=CourseSeeder
php artisan db:seed --class=EnrollmentSeeder
php artisan db:seed --class=SchoolDaySeeder
```

### Available Seeders

- **DatabaseSeeder** - Main seeder that runs all seeders
- **StudentSeeder** - Creates sample students
- **CourseSeeder** - Creates sample courses
- **EnrollmentSeeder** - Creates sample enrollments
- **SchoolDaySeeder** - Creates academic calendar data

---

## Testing

### Run All Tests

```bash
composer test
```

### Run Specific Test Suite

```bash
php artisan test --filter=feature
php artisan test --filter=unit
```

### Test Structure

```
tests/
├── Feature/
│   └── ExampleTest.php              # Feature tests
└── Unit/
    └── ExampleTest.php              # Unit tests
```

### Writing Tests

**Example Feature Test**:
```php
namespace Tests\Feature;

use Tests\TestCase;

class StudentTest extends TestCase
{
    public function test_can_get_students()
    {
        $response = $this->getJson('/api/students');
        $response->assertStatus(200);
    }
}
```

---

## Configuration Files

### `.env` File Variables

```env
APP_NAME="IT-15 Enrollment"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=enrollment
# DB_USERNAME=root
# DB_PASSWORD=

CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
```

### Key Configuration Files

- `config/app.php` - Application name, timezone, encryption
- `config/database.php` - Database connections
- `config/cors.php` - CORS settings
- `config/auth.php` - Authentication configuration
- `config/cache.php` - Caching configuration

---

## Troubleshooting

### Common Issues

**Queue Not Working:**
```bash
php artisan queue:work
```

**Cache Issues:**
```bash
php artisan cache:clear
php artisan config:clear
```

**Database Lock:**
```bash
rm database/database.sqlite
touch database/database.sqlite
php artisan migrate
```

**Port Already in Use:**
```bash
php artisan serve --port=8001
```

---

## Performance Optimization

### Database Optimization

- Use eager loading to prevent N+1 queries:
  ```php
  $courses = Course::with('students')->get();
  ```

- Add indexes to frequently queried columns in migrations

### API Response Optimization

- Use pagination for large datasets:
  ```php
  $students = Student::paginate(15);
  ```

- Return only necessary fields:
  ```php
  $students = Student::select('id', 'first_name', 'last_name')->get();
  ```

---

## Deployment

### Production Checklist

- [ ] Update `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Configure proper database connection
- [ ] Update `CORS` allowed origins
- [ ] Run migrations: `php artisan migrate --force`
- [ ] Clear caches: `php artisan cache:clear`
- [ ] Build frontend assets: `npm run build`
- [ ] Set proper file permissions

---

## Contributing

When contributing to this project:

1. Create a feature branch
2. Make your changes
3. Run tests: `composer test`
4. Format code: `php artisan pint`
5. Create a pull request

---

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).

---

## Support

For API documentation: See [API_DOCUMENTATION.md](API_DOCUMENTATION.md)

For seeder documentation: See [SEEDERS_DOCUMENTATION.md](SEEDERS_DOCUMENTATION.md)

For questions or issues, contact the development team.
