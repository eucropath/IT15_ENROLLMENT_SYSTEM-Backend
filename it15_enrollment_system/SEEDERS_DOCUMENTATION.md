# Database Seeders Documentation

## Overview
This document describes the implemented database seeders for the IT15 Enrollment System. The seeders generate comprehensive dummy data for students, courses, and academic calendar.

## Seeder Summary

### 1. StudentSeeder
**Location:** `database/seeders/StudentSeeder.php`

**Purpose:** Generates 500 student records with demographic information

**Features:**
- Creates 500 unique student records with:
  - `student_number`: Formatted as "2026-00001" to "2026-00500"
  - `first_name`: Random Filipino first names
  - `last_name`: Random Filipino last names
  - `email`: Unique email addresses
- Uses Faker library with Philippine locale for realistic data
- Implements batch insertion (100 records at a time) for optimal performance
- All timestamps are automatically generated on creation

**Data Generated:** 500 records

### 2. CourseSeeder
**Location:** `database/seeders/CourseSeeder.php`

**Purpose:** Creates 20+ courses across different departments

**Courses by Department:**

#### Information Technology (6 courses)
- IT101: Introduction to Programming (capacity: 40)
- IT102: Data Structures (capacity: 35)
- IT201: Database Systems (capacity: 30)
- IT202: Web Development (capacity: 40)
- IT301: Software Engineering (capacity: 35)
- IT302: Mobile App Development (capacity: 30)

#### Computer Science (5 courses)
- CS101: Algorithm Design (capacity: 35)
- CS102: Computer Networks (capacity: 32)
- CS201: Operating Systems (capacity: 30)
- CS301: Artificial Intelligence (capacity: 28)
- CS302: Machine Learning Fundamentals (capacity: 25)

#### Information Systems (5 courses)
- IS101: Business Information Systems (capacity: 40)
- IS102: Enterprise Resource Planning (capacity: 35)
- IS201: Systems Analysis & Design (capacity: 30)
- IS202: Network Security (capacity: 28)
- IS301: Cloud Computing (capacity: 32)

#### General Education (4 courses)
- GE101: English Communication (capacity: 50)
- GE102: Mathematics for Computing (capacity: 45)
- GE201: Professional Ethics (capacity: 40)
- GE202: Technical Writing (capacity: 38)

**Data Generated:** 20 courses with realistic capacities

### 3. SchoolDaySeeder
**Location:** `database/seeders/SchoolDaySeeder.php`

**Purpose:** Generates academic calendar data including school days, holidays, and events

**Academic Year:** 2026-2027 (June 1, 2026 - May 31, 2027)

**Features:**
- Generates all days in the academic year with proper categorization
- Includes Philippine national holidays
- Marks weekends
- Includes special academic events and milestones
- Batch insertion for performance

**Day Types:**
1. **Regular** - Standard school days
2. **Holiday** - National holidays and special days off
3. **Weekend** - Saturdays and Sundays
4. **Event** - Special academic milestones (exam periods, semester starts/ends)

**Included Holidays:**
- New Year's Day (Jan 1-2)
- Chinese New Year (Feb 17-18)
- EDSA Revolution Anniversary (Feb 25)
- Holy Week (Apr 9-12)
- Labor Day (May 1)
- Eid celebrations (May 24-25)
- National Heroes Day (Aug 21)
- All Saints & Souls Day (Nov 1-2)
- Bonifacio Day (Nov 30)
- Immaculate Conception (Dec 8)
- Christmas & Year-end (Dec 24-31)

**Academic Events:**
- 1st Semester: June 1 - October 16
- 2nd Semester: October 19 - January 22
- Summer Classes: February 1 - March 30
- Midterm examinations in both semesters
- Final examinations after each semester

**Data Generated:** ~365 calendar day records

### 4. EnrollmentSeeder
**Location:** `database/seeders/EnrollmentSeeder.php`

**Purpose:** Creates student-course enrollments

**Features:**
- Randomly assigns each student to 3-5 courses
- Ensures no duplicate enrollments (enforced by database unique constraint)
- Creates realistic enrollment distribution
- Works with all 500 students and 20 courses

**Total Enrollments Generated:** ~2,000-2,500 enrollment records

## Modified Files

### Models Updated

#### Student.php
- Fixed `protected $fillable` property (moved from inside method)
- Proper relationship definition for courses

#### Course.php
- Fixed `protected $fillable` property (moved from inside method)
- Proper relationship definition for students

### Database Changes

#### New Migration
**Location:** `database/migrations/2026_02_14_060000_create_school_days_table.php`

Schema:
```
- id (primary key)
- date (unique, date)
- day_type (enum: regular, holiday, event, weekend)
- description (string, nullable)
- is_school_day (boolean)
- academic_year (string, indexed)
- timestamps (created_at, updated_at)
```

#### New Model
**Location:** `app/Models/SchoolDay.php`

Properties:
- Fillable: date, day_type, description, is_school_day, academic_year
- Casts: date as date, is_school_day as boolean

### DatabaseSeeder Updated
**Location:** `database/seeders/DatabaseSeeder.php`

Now includes proper seeding order:
1. Create test user
2. Seed courses
3. Seed students
4. Seed school days
5. Seed enrollments

## Usage Instructions

### Running All Seeders
```bash
php artisan migrate:fresh --seed
```
This will:
- Drop all tables and rebuild them
- Run all migrations (including the new school_days table)
- Execute all seeders in order

### Running Individual Seeders
```bash
# Run only course seeder
php artisan db:seed --class=CourseSeeder

# Run only student seeder
php artisan db:seed --class=StudentSeeder

# Run only school day seeder
php artisan db:seed --class=SchoolDaySeeder

# Run only enrollment seeder
php artisan db:seed --class=EnrollmentSeeder
```

### Seeding Without Dropping Tables
```bash
php artisan db:seed
```
Note: This will fail if records already exist due to unique constraints

## Database Schema Summary

### students table
- 500 records with unique student numbers and emails

### courses table
- 20 records across 4 departments

### enrollments table
- ~2,000-2,500 join records linking students to courses

### school_days table
- ~365 calendar records for academic year 2026-2027

## Performance Metrics

- **StudentSeeder:** Bulk insertion in 100-record batches
- **CourseSeeder:** Sequential insertion (20 records)
- **SchoolDaySeeder:** Bulk insertion in 100-record batches
- **EnrollmentSeeder:** ~2,000-2,500 attach operations

Total execution time should be under 30 seconds on typical systems.

## API Readiness

The seeded data is ready to serve the React frontend with:
- Complete student roster (500 students)
- Full course catalog (20 courses across departments)
- Academic calendar for attendance tracking and event management
- Student-course relationships for enrollment queries

## Notes

- All data uses realistic Philippines-based calendar and naming
- Email addresses are guaranteed unique using Faker
- Student numbers follow institutional format
- Course capacities are realistic variations for different course types
- Academic year spans June 2026 - May 2027 (typical Philippine academic year)
- All timestamps are automatically set on creation
