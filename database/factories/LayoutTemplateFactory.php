<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LayoutTemplate>
 */
class LayoutTemplateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gridTypes = ['1-col', '2-col', '3-col', '2x2', '3x3'];
        $gridType = fake()->randomElement($gridTypes);
        
        return [
            'name' => fake()->words(3, true) . ' Template',
            'description' => fake()->sentence(),
            'thumbnail_path' => null,
            'grid_type' => $gridType,
            'grid_config' => $this->generateGridConfig($gridType),
            'elements' => $this->generateElements($gridType),
            'is_active' => false,
            'created_by' => 1, // Default admin user
        ];
    }

    /**
     * Generate grid configuration based on grid type
     */
    private function generateGridConfig($gridType): array
    {
        $configs = [
            '1-col' => [
                'type' => '1-col',
                'rows' => 1,
                'columns' => 1,
                'areas' => [
                    ['id' => 1, 'row' => 1, 'col' => 1, 'rowSpan' => 1, 'colSpan' => 1]
                ],
                'gap' => '20px',
                'padding' => '30px'
            ],
            '2-col' => [
                'type' => '2-col',
                'rows' => 1,
                'columns' => 2,
                'areas' => [
                    ['id' => 1, 'row' => 1, 'col' => 1, 'rowSpan' => 1, 'colSpan' => 1],
                    ['id' => 2, 'row' => 1, 'col' => 2, 'rowSpan' => 1, 'colSpan' => 1]
                ],
                'gap' => '20px',
                'padding' => '30px'
            ],
            '3-col' => [
                'type' => '3-col',
                'rows' => 1,
                'columns' => 3,
                'areas' => [
                    ['id' => 1, 'row' => 1, 'col' => 1, 'rowSpan' => 1, 'colSpan' => 1],
                    ['id' => 2, 'row' => 1, 'col' => 2, 'rowSpan' => 1, 'colSpan' => 1],
                    ['id' => 3, 'row' => 1, 'col' => 3, 'rowSpan' => 1, 'colSpan' => 1]
                ],
                'gap' => '20px',
                'padding' => '30px'
            ],
            '2x2' => [
                'type' => '2x2',
                'rows' => 2,
                'columns' => 2,
                'areas' => [
                    ['id' => 1, 'row' => 1, 'col' => 1, 'rowSpan' => 1, 'colSpan' => 1],
                    ['id' => 2, 'row' => 1, 'col' => 2, 'rowSpan' => 1, 'colSpan' => 1],
                    ['id' => 3, 'row' => 2, 'col' => 1, 'rowSpan' => 1, 'colSpan' => 1],
                    ['id' => 4, 'row' => 2, 'col' => 2, 'rowSpan' => 1, 'colSpan' => 1]
                ],
                'gap' => '20px',
                'padding' => '30px'
            ],
            '3x3' => [
                'type' => '3x3',
                'rows' => 3,
                'columns' => 3,
                'areas' => [
                    ['id' => 1, 'row' => 1, 'col' => 1, 'rowSpan' => 1, 'colSpan' => 1],
                    ['id' => 2, 'row' => 1, 'col' => 2, 'rowSpan' => 1, 'colSpan' => 1],
                    ['id' => 3, 'row' => 1, 'col' => 3, 'rowSpan' => 1, 'colSpan' => 1],
                    ['id' => 4, 'row' => 2, 'col' => 1, 'rowSpan' => 1, 'colSpan' => 1],
                    ['id' => 5, 'row' => 2, 'col' => 2, 'rowSpan' => 1, 'colSpan' => 1],
                    ['id' => 6, 'row' => 2, 'col' => 3, 'rowSpan' => 1, 'colSpan' => 1],
                    ['id' => 7, 'row' => 3, 'col' => 1, 'rowSpan' => 1, 'colSpan' => 1],
                    ['id' => 8, 'row' => 3, 'col' => 2, 'rowSpan' => 1, 'colSpan' => 1],
                    ['id' => 9, 'row' => 3, 'col' => 3, 'rowSpan' => 1, 'colSpan' => 1]
                ],
                'gap' => '15px',
                'padding' => '30px'
            ]
        ];

        return $configs[$gridType] ?? $configs['2x2'];
    }

    /**
     * Generate sample elements
     */
    private function generateElements($gridType): array
    {
        $colors = ['#1345BE', '#092058', '#FFC67C', '#f5f5f5', '#333333'];
        
        return [
            [
                'id' => 'elem-1',
                'type' => 'text',
                'gridArea' => 1,
                'content' => 'Selamat Datang di BPS Sumatera Utara',
                'styles' => [
                    'fontSize' => '24px',
                    'color' => '#333333',
                    'fontWeight' => 'bold',
                    'textAlign' => 'center',
                    'padding' => '20px'
                ],
                'position' => [
                    'x' => 0,
                    'y' => 0,
                    'width' => '100%',
                    'height' => 'auto'
                ]
            ],
            [
                'id' => 'elem-2',
                'type' => 'color',
                'gridArea' => 2,
                'styles' => [
                    'backgroundColor' => fake()->randomElement($colors),
                    'opacity' => 1
                ]
            ]
        ];
    }
}
