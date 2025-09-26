<?php

namespace Database\Seeders;

use App\Models\ActivityChecklist;
use App\Models\KitActivationCode;
use App\Models\TinkeringModule;
use App\Models\TinkeringModuleSubActivity;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TinkeringLMSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@tinkeringlms.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create sample students
        $student1 = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'email_verified_at' => now(),
        ]);

        $student2 = User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'email_verified_at' => now(),
        ]);

        // Create Tinkering Electro Basics module
        $teModule = TinkeringModule::create([
            'module_name' => 'Tinkering Electro Basics',
            'slug' => 'tinkering-electro-basics',
            'description' => 'Learn the fundamentals of electronics and basic circuit building through hands-on activities.',
            'focus_area' => 'Electronics & Circuits',
            'suggested_age_group' => '8-14 years',
            'duration' => '4-6 weeks',
            'key_skills' => ['Circuit Building', 'Basic Electronics', 'Problem Solving', 'Creativity'],
            'is_active' => true,
            'created_by' => $admin->id,
        ]);

        // Create Tinkering Programming module
        $tpModule = TinkeringModule::create([
            'module_name' => 'Tinkering Programming',
            'slug' => 'tinkering-programming',
            'description' => 'Introduction to programming concepts through visual programming and basic coding.',
            'focus_area' => 'Programming & Logic',
            'suggested_age_group' => '10-16 years',
            'duration' => '6-8 weeks',
            'key_skills' => ['Programming Logic', 'Problem Solving', 'Algorithm Design', 'Debugging'],
            'is_active' => true,
            'created_by' => $admin->id,
        ]);

        // Create sub-activities for TE module
        $teActivity1 = TinkeringModuleSubActivity::create([
            'tinkering_module_id' => $teModule->id,
            'title' => 'Introduction to Basic Components',
            'slug' => 'introduction-basic-components',
            'objective' => 'Understand basic electronic components and their functions.',
            'concept_focus' => 'Component identification and basic functionality',
            'materials_needed' => ['LED', 'Resistor', 'Battery', 'Breadboard', 'Jumper wires'],
            'instructions' => 'In this activity, you will learn about basic electronic components and how to identify them. Start by examining each component and understanding its purpose.',
            'explanation' => 'Electronic components are the building blocks of circuits. Each component has a specific function and understanding them is crucial for building circuits.',
            'is_active' => true,
            'order' => 1,
        ]);

        $teActivity2 = TinkeringModuleSubActivity::create([
            'tinkering_module_id' => $teModule->id,
            'title' => 'Building Your First Circuit',
            'slug' => 'building-first-circuit',
            'objective' => 'Build a simple LED circuit using a breadboard.',
            'concept_focus' => 'Circuit building and component connections',
            'materials_needed' => ['LED', '220Ω Resistor', '9V Battery', 'Breadboard', 'Jumper wires'],
            'instructions' => 'Connect the LED to the battery through a resistor using the breadboard. Make sure to observe proper polarity.',
            'explanation' => 'This circuit demonstrates the basic principle of current flow and the importance of resistors in protecting components.',
            'is_active' => true,
            'order' => 2,
        ]);

        // Create sub-activities for TP module
        $tpActivity1 = TinkeringModuleSubActivity::create([
            'tinkering_module_id' => $tpModule->id,
            'title' => 'Introduction to Programming Concepts',
            'slug' => 'introduction-programming-concepts',
            'objective' => 'Understand basic programming concepts and logic.',
            'concept_focus' => 'Programming fundamentals and logical thinking',
            'materials_needed' => ['Computer', 'Scratch or similar visual programming tool'],
            'instructions' => 'Explore the visual programming environment and create your first simple program.',
            'explanation' => 'Programming is about giving instructions to a computer in a language it understands.',
            'is_active' => true,
            'order' => 1,
        ]);

        // Create checklists for activities
        ActivityChecklist::create([
            'tinkering_module_sub_activity_id' => $teActivity1->id,
            'item' => 'Identify and name all basic components',
            'order' => 1,
        ]);

        ActivityChecklist::create([
            'tinkering_module_sub_activity_id' => $teActivity1->id,
            'item' => 'Understand the function of each component',
            'order' => 2,
        ]);

        ActivityChecklist::create([
            'tinkering_module_sub_activity_id' => $teActivity1->id,
            'item' => 'Complete the component identification quiz',
            'order' => 3,
        ]);

        ActivityChecklist::create([
            'tinkering_module_sub_activity_id' => $teActivity2->id,
            'item' => 'Set up the breadboard correctly',
            'order' => 1,
        ]);

        ActivityChecklist::create([
            'tinkering_module_sub_activity_id' => $teActivity2->id,
            'item' => 'Connect LED with proper polarity',
            'order' => 2,
        ]);

        ActivityChecklist::create([
            'tinkering_module_sub_activity_id' => $teActivity2->id,
            'item' => 'Add resistor to protect the LED',
            'order' => 3,
        ]);

        ActivityChecklist::create([
            'tinkering_module_sub_activity_id' => $teActivity2->id,
            'item' => 'Test the circuit and observe LED lighting',
            'order' => 4,
        ]);

        // Create kit activation codes
        $codes = [
            'TE-000001', 'TE-000002', 'TE-000003', 'TE-000004', 'TE-000005',
            'TP-000001', 'TP-000002', 'TP-000003', 'TP-000004', 'TP-000005'
        ];

        foreach ($codes as $index => $code) {
            $moduleId = str_starts_with($code, 'TE') ? $teModule->id : $tpModule->id;
            $usedBy = $index < 3 ? ($index < 2 ? $student1->id : $student2->id) : null;
            $status = $index < 3 ? 'used' : 'unused';
            $usedAt = $index < 3 ? now() : null;

            KitActivationCode::create([
                'code' => $code,
                'used_by' => $usedBy,
                'status' => $status,
                'module_id' => $moduleId,
                'generated_by' => $admin->id,
                'used_at' => $usedAt,
            ]);
        }
    }
}
