<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🌱 Starting database seeding...');
        
        $this->call([
            // User seeder (admin and regular users)
            AdminSeeder::class,
            
            // Category seeders (must run before posts and products)
            PostCategorySeeder::class,
            ProductCategorySeeder::class,
            
            // Content seeders
            PostSeeder::class,
            ProductSeeder::class,
        ]);
            // Seed category for team division
            \App\Models\Category::firstOrCreate([
                'type' => 'team',
                'name' => 'Divisi Team',
            ], [
                'slug' => 'divisi-team',
                'description' => 'Kategori untuk divisi team',
                'status' => 1,
            ]);
        
        $this->command->info('✅ Database seeding completed successfully!');
        $this->command->info('📊 Summary:');
        $this->command->info('   - Users with admin/user roles');
        $this->command->info('   - Post categories (10 categories)');
        $this->command->info('   - Product categories (10 categories)');
        $this->command->info('   - Sample posts (10 articles)');
        $this->command->info('   - Sample products (10 tech products)');
    }
}