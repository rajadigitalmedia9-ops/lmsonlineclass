<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@artinlms.com'],
            ['name' => 'Admin User', 'password' => bcrypt('password123')]
        );

        // 2. Create Student User
        $student = User::firstOrCreate(
            ['email' => 'student@example.com'],
            ['name' => 'Test Student', 'password' => bcrypt('password123')]
        );

        // 3. Create a Dummy Course
        $course = \App\Models\Course::firstOrCreate(
            ['name' => 'Flutter Masterclass'],
            ['description' => 'Learn Flutter from scratch', 'status' => 'active']
        );

        // 4. Create a Dummy Batch
        $batch = \App\Models\Batch::firstOrCreate(
            ['name' => 'Morning Batch'],
            ['course_id' => $course->id, 'status' => 'active']
        );

        // 5. Create a Dummy Subject
        $subject = \App\Models\Subject::firstOrCreate(
            ['name' => 'Dart Basics'],
            ['course_id' => $course->id, 'status' => 'active']
        );

        // 6. Enroll the Student in the Batch
        \App\Models\Enrollment::firstOrCreate(
            ['user_id' => $student->id, 'batch_id' => $batch->id],
            ['course_id' => $course->id, 'status' => 'active']
        );
}
