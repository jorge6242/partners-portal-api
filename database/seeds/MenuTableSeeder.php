<?php

use App\Menu;
use App\MenuItem;
use Illuminate\Database\Seeder;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $menuBase = Menu::create([
            'name' => 'menu-base',
            'slug' => 'menu-base',
            'description' => 'Menu Base',
        ]);

        $m1 = MenuItem::create([
            'name' => 'Opción 1',
            'slug' => 'opcion1',
            'parent' => 0,
            'order' => 0,
            'description' => 'Opción 1',
            'menu_id' => $menuBase->id,
        ]);
        MenuItem::create([
            'name' => 'Opción 2',
            'slug' => 'opcion2',
            'parent' => 0,
            'order' => 1,
            'description' => 'Opción 2',
            'menu_id' => $menuBase->id,
        ]);
        $m3 = MenuItem::create([
            'name' => 'Opción 3',
            'slug' => 'opcion3',
            'parent' => 0,
            'order' => 2,
            'description' => 'Opción 3',
            'menu_id' => $menuBase->id,
        ]);
        $m4 = MenuItem::create([
            'name' => 'Opción 4',
            'slug' => 'opcion4',
            'parent' => 0,
            'order' => 3,
            'description' => 'Opción 4',
            'menu_id' => $menuBase->id,
        ]);
        MenuItem::create([
            'name' => 'Opción 1.1',
            'slug' => 'opcion-1.1',
            'parent' => $m1->id,
            'order' => 0,
            'description' => 'Opción 1.1',
            'menu_id' => $menuBase->id,
        ]);
        MenuItem::create([
            'name' => 'Opción 1.2',
            'slug' => 'opcion-1.2',
            'parent' => $m1->id,
            'order' => 1,
            'description' => '',
            'menu_id' => $menuBase->id,
        ]);
        MenuItem::create([
            'name' => 'Opción 3.1',
            'slug' => 'opcion-3.1',
            'parent' => $m3->id,
            'order' => 0,
            'description' => 'Opción 1.2',
            'menu_id' => $menuBase->id,
        ]);
        $m32 = MenuItem::create([
            'name' => 'Opción 3.2',
            'slug' => 'opcion-3.2',
            'parent' => $m3->id,
            'order' => 1,
            'description' => 'Opción 3.2',
            'menu_id' => $menuBase->id,
        ]);
        MenuItem::create([
            'name' => 'Opción 4.1',
            'slug' => 'opcion-4.1',
            'parent' => $m4->id,
            'order' => 0,
            'description' => 'Opción 4.1',
            'menu_id' => $menuBase->id,
        ]);
        MenuItem::create([
            'name' => 'Opción 3.2.1',
            'slug' => 'opcion-3.2.1',
            'parent' => $m32->id,
            'order' => 0,
            'description' => 'Opción 3.2.1',
            'menu_id' => $menuBase->id,
        ]);
        MenuItem::create([
            'name' => 'Opción 3.2.2',
            'slug' => 'opcion-3.2.2',
            'parent' => $m32->id,
            'order' => 1,
            'description' => 'Opción 3.2.2',
            'menu_id' => $menuBase->id,
        ]);
        MenuItem::create([
            'name' => 'Opción 3.2.3',
            'slug' => 'opcion-3.2.3',
            'parent' => $m32->id,
            'order' => 2,
            'description' => 'Opción 3.2.3',
            'menu_id' => $menuBase->id,
        ]);
    }
}
