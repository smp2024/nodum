<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Pintura',
            'slug' => 'pintura',
            'status' => '1',
        ]);
        Category::create([
            'name' => 'Fotografía',
            'slug' => 'fotografia',
            'status' => '1',
        ]);
        Category::create([
            'name' => 'Escultura',
            'slug' => 'escultura',
            'status' => '1',
        ]);
        Category::create([
            'name' => 'Gráfica',
            'slug' => 'grafica',
            'status' => '1',
        ]);
        Category::create([
            'name' => 'Dibujo',
            'slug' => 'dibujo',
            'status' => '1',
        ]);
    }
}
