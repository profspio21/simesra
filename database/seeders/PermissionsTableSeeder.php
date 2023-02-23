<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'outlet_kitchen_create',
            ],
            [
                'id'    => 18,
                'title' => 'outlet_kitchen_edit',
            ],
            [
                'id'    => 19,
                'title' => 'outlet_kitchen_show',
            ],
            [
                'id'    => 20,
                'title' => 'outlet_kitchen_delete',
            ],
            [
                'id'    => 21,
                'title' => 'outlet_kitchen_access',
            ],
            [
                'id'    => 22,
                'title' => 'rm_category_create',
            ],
            [
                'id'    => 23,
                'title' => 'rm_category_edit',
            ],
            [
                'id'    => 24,
                'title' => 'rm_category_show',
            ],
            [
                'id'    => 25,
                'title' => 'rm_category_delete',
            ],
            [
                'id'    => 26,
                'title' => 'rm_category_access',
            ],
            [
                'id'    => 27,
                'title' => 'raw_material_create',
            ],
            [
                'id'    => 28,
                'title' => 'raw_material_edit',
            ],
            [
                'id'    => 29,
                'title' => 'raw_material_show',
            ],
            [
                'id'    => 30,
                'title' => 'raw_material_delete',
            ],
            [
                'id'    => 31,
                'title' => 'raw_material_access',
            ],
            [
                'id'    => 32,
                'title' => 'bahan_access',
            ],
            [
                'id'    => 33,
                'title' => 'product_create',
            ],
            [
                'id'    => 34,
                'title' => 'product_edit',
            ],
            [
                'id'    => 35,
                'title' => 'product_show',
            ],
            [
                'id'    => 36,
                'title' => 'product_delete',
            ],
            [
                'id'    => 37,
                'title' => 'product_access',
            ],
            [
                'id'    => 38,
                'title' => 'sale_create',
            ],
            [
                'id'    => 39,
                'title' => 'sale_edit',
            ],
            [
                'id'    => 40,
                'title' => 'sale_show',
            ],
            [
                'id'    => 41,
                'title' => 'sale_delete',
            ],
            [
                'id'    => 42,
                'title' => 'sale_access',
            ],
            [
                'id'    => 43,
                'title' => 'order_create',
            ],
            [
                'id'    => 44,
                'title' => 'order_edit',
            ],
            [
                'id'    => 45,
                'title' => 'order_show',
            ],
            [
                'id'    => 46,
                'title' => 'order_delete',
            ],
            [
                'id'    => 47,
                'title' => 'order_access',
            ],
            [
                'id'    => 48,
                'title' => 'profile_password_edit',
            ],
            [
                'id'    => 49,
                'title' => 'import',
            ],
            [
                'id'    => 50,
                'title' => 'approve_reject_ck',
            ],
            [
                'id'    => 51,
                'title' => 'confirm_ok_om',
            ],
            [
                'id'    => 52,
                'title' => 'approve_sa',
            ],
            [
                'id'    => 53,
                'title' => 'approve_om',
            ],
            [
                'id'    => 54,
                'title' => 'stock_access',
            ],
            [
                'id'    => 55,
                'title' => 'stock_create',
            ],
        ];

        Permission::insert($permissions);
    }
}