<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    //
    /**
     * Tạo role mới.
     *
     * @param string $name Tên role mới.
     * @param string $type Loại role (customer/employee/admin).
     * @return void
     */
    public function createRoles()
    {
        // create role for customer
        DB::table('role')->insert([
            'name' => 'customer',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // create role for employee
        DB::table('role')->insert([
            'name' => 'employee',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // create role for admin
        DB::table('role')->insert([
            'name' => 'admin',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
