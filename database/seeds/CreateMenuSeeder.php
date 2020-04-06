<?php

use App\Menu;
use App\Role;
use App\MenuItem;
use App\MenuItemRole;
use Illuminate\Database\Seeder;

class CreateMenuSeeder extends Seeder
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

        MenuItem::create([
            'name' => 'Inicio',
            'slug' => 'inicio',
            'parent' => 0,
            'order' => 0,
            'description' => 'Inicio',
            'route' => '/dashboard/main',
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Notas',
            'slug' => 'notas',
            'parent' => 0,
            'order' => 0,
            'description' => 'Notas',
            'route' => '/dashboard/main',
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Socios',
            'slug' => 'socios',
            'parent' => 0,
            'order' => 0,
            'description' => 'Socios',
            'route' => '/dashboard/partner',
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Actualizacion de Datos',
            'slug' => 'actualizacion-datos',
            'parent' => 0,
            'order' => 0,
            'description' => 'Actualizacion de Datos',
            'route' => '/dashboard/actualizacion-datos',
            'menu_id' => $menuBase->id,
        ]);

       $fact = MenuItem::create([
            'name' => 'Facturacion',
            'slug' => 'facturacion',
            'parent' => 0,
            'order' => 0,
            'description' => 'Facturacion',
            'route' => null,
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Reporte de Pagos',
            'slug' => 'reporte-pagos',
            'parent' => $fact->id,
            'order' => 0,
            'description' => 'Reporte de Pagos',
            'route' => '/dashboard/reporte-pagos',
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Estado de Cuenta',
            'slug' => 'estado-cuenta',
            'parent' => $fact->id,
            'order' => 0,
            'description' => 'Estado de Cuenta',
            'route' => '/dashboard/status-account',
            'menu_id' => $menuBase->id,
        ]);

        MenuItem::create([
            'name' => 'Facturas por Pagar',
            'slug' => 'facturas-por-pagar',
            'parent' => $fact->id,
            'order' => 0,
            'description' => 'Facturas por Pagar',
            'route' => '/dashboard/facturas-por-pagar',
            'menu_id' => $menuBase->id,
        ]);

        $data = [ 
            ['menuItem' =>  'inicio', 'role' => 'promotor' ],
            [ 'menuItem' => 'notas', 'role' => 'promotor' ],
            [ 'menuItem' => 'socios', 'role' => 'promotor' ],
            [ 'menuItem' => 'actualizacion-datos', 'role' => 'socio' ],
            [ 'menuItem' => 'facturacion', 'role' => 'socio' ],
            [ 'menuItem' => 'reporte-pagos', 'role' => 'socio' ],
            [ 'menuItem' => 'estado-cuenta', 'role' => 'socio' ],
            [ 'menuItem' => 'facturas-por-pagar', 'role' => 'socio' ],
        ];
        foreach ($data as $key => $value) {
            $admin = Role::where('slug', $value['role'])->first();
            $menuItem = MenuItem::where('slug', $value['menuItem'])->first();
            MenuItemRole::create([
                'role_id' => $admin->id,
                'menu_item_id' => $menuItem->id,
            ]);
        }
    }
}
