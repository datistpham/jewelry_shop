<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    //
    /**
     * Lấy tất cả các thể loại từ bảng category.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategories()
    {
        $categories = DB::table('category')->get();
        return response()->json($categories);
    }
    /**
     * Tạo mới category
     *
     * @param  array  $data
     * @return bool
     */
    public function createCategory(array $data)
    {
        $now = date('Y-m-d H:i:s');

        $insertData = [
            'name' => $data['name'],
            'create_by' => $data['create_by'],
            'description' => $data['description'],
            'show_on_home' => $data['show_on_home'],
            'show_on_admin' => $data['show_on_admin'],
            'created_at' => $now,
            'updated_at' => $now
        ];

        $result = DB::table('category')->insert($insertData);

        return $result;
    }
}
