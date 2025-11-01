<?php

namespace Database\Seeders;

use App\Enums\CategoryTypeEnum;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $incomeCategories = [
            [
                'name' => 'Salary',
                'type' => CategoryTypeEnum::INCOME,
                'icon' => 'e041',
                'color' => '#43A047'
            ],
            [
                'name' => 'Gift',
                'type' => CategoryTypeEnum::INCOME,
                'icon' => 'e511',
                'color' => '#FDD835'
            ],
            [
                'name' => 'Other',
                'type' => CategoryTypeEnum::INCOME,
                'icon' => 'e402',
                'color' => '#607D8B'
            ],
        ];

        foreach ($incomeCategories as $category) {
            Category::create($category);
        }

        $expenseCategories = [
            [
                'name' => 'Food and Drink',
                'type' => CategoryTypeEnum::EXPENSE,
                'icon' => 'e390',
                'color' => '#FF5722',
            ],
            [
                'name' => 'Shopping',
                'type' => CategoryTypeEnum::EXPENSE,
                'icon' => 'f37f',
                'color' => '#FFC107',
            ],
            [
                'name' => 'Bill',
                'type' => CategoryTypeEnum::EXPENSE,
                'icon' => 'e50d',
                'color' => '#F44336',
            ],
            [
                'name' => 'Transportation',
                'type' => CategoryTypeEnum::EXPENSE,
                'icon' => 'e1d6',
                'color' => '#00BCD4',
            ],
            [
                'name' => 'Vehicle',
                'type' => CategoryTypeEnum::EXPENSE,
                'icon' => 'e1d8',
                'color' => '#9C27B0',
            ],
            [
                'name' => 'Other',
                'type' => CategoryTypeEnum::EXPENSE,
                'icon' => 'e402',
                'color' => '#607D8B',
            ],
        ];

        foreach ($expenseCategories as $category) {
            Category::create($category);
        }
    }
}
