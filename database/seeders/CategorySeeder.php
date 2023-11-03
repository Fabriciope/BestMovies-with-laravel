<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'drama',
            'action',
            'fantasy',
            'adventure',
            'thriller',
            'romance',
            'sci-fi',
            'horror',

        ];

        foreach ($categories as $category) {
            DB::table('categories')
                ->insert(['category' => $category]);
        }
    }
}
