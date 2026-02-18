<?php

namespace Database\Seeders;

use App\Models\TemplateCategory;
use Illuminate\Database\Seeder;

class TemplateCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Customer Information',
                'slug' => 'customer',
                'icon' => 'person',
                'sort_order' => 1,
            ],
            [
                'name' => 'Vehicle Information',
                'slug' => 'vehicle',
                'icon' => 'car-front',
                'sort_order' => 2,
            ],
            [
                'name' => 'Dealership',
                'slug' => 'dealership',
                'icon' => 'building',
                'sort_order' => 3,
            ],
            [
                'name' => 'Trade-In Information',
                'slug' => 'tradein',
                'icon' => 'arrow-left-right',
                'sort_order' => 4,
            ],
            [
                'name' => 'Deal Information',
                'slug' => 'deal',
                'icon' => 'file-earmark-text',
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            TemplateCategory::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}