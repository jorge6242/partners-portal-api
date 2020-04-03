<?php

use App\Role;
use App\MenuItem;
use App\MenuItemRole;
use Illuminate\Database\Seeder;

class MenuItemRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::where('slug', 'administrador')->first();
        $menuItem = MenuItem::where('slug', 'opcion-3.2.3')->first();
        MenuItemRole::create([
            'role_id' => $admin->id,
            'menu_item_id' => $menuItem->id,
        ]);

    }
}
