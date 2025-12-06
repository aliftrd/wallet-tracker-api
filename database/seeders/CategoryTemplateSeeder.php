<?php

namespace Database\Seeders;

use App\Enums\CategoryTypeEnum;
use App\Models\CategoryTemplate;
use Illuminate\Database\Seeder;

class CategoryTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $income = [
            ['name' => 'Salary', 'type' => CategoryTypeEnum::INCOME],
            ['name' => 'Freelance', 'type' => CategoryTypeEnum::INCOME],
            ['name' => 'Business', 'type' => CategoryTypeEnum::INCOME],
            ['name' => 'Bonus', 'type' => CategoryTypeEnum::INCOME],
            ['name' => 'Investment', 'type' => CategoryTypeEnum::INCOME],
            ['name' => 'Other Income', 'type' => CategoryTypeEnum::INCOME],
        ];

        $expense = [
            ['name' => 'Food & Drinks', 'type' => CategoryTypeEnum::EXPENSE],
            ['name' => 'Transportation', 'type' => CategoryTypeEnum::EXPENSE],
            ['name' => 'Housing', 'type' => CategoryTypeEnum::EXPENSE],
            ['name' => 'Bills & Utilities', 'type' => CategoryTypeEnum::EXPENSE],
            ['name' => 'Shopping', 'type' => CategoryTypeEnum::EXPENSE],
            ['name' => 'Health', 'type' => CategoryTypeEnum::EXPENSE],
            ['name' => 'Education', 'type' => CategoryTypeEnum::EXPENSE],
            ['name' => 'Entertainment', 'type' => CategoryTypeEnum::EXPENSE],
            ['name' => 'Travel', 'type' => CategoryTypeEnum::EXPENSE],
            ['name' => 'Other Expense', 'type' => CategoryTypeEnum::EXPENSE],
        ];

        $now = now();
        $categories = array_map(function ($category) use ($now) {
            return array_merge($category, [
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }, array_merge($income, $expense));

        CategoryTemplate::insert($categories);
    }
}
