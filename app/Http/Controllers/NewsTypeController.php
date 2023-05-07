<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class NewsTypeController extends Controller
{
    //
    /**
     * Get all news types from the database.
     *
     * @return Illuminate\Support\Collection
     */
    public function getAllNewsTypes()
    {
        $newsTypes = DB::table('news_type')->get();
        return $newsTypes;
    }

    /**
     * Get detail of a news type by id
     *
     * @param int $id
     * @return stdClass|null
     */
    public function getNewsTypeDetail(int $id)
    {
        $newsType = DB::table('news_type')
            ->select('id', 'new_type_name', 'description', 'created_at', 'updated_at')
            ->where('id', $id)
            ->first();
        return $newsType;
    }
    /**
     * Tạo mới một loại tin tức trong bảng news_type.
     *
     * @param array $data Thông tin của loại tin tức mới.
     * @return int ID của bản ghi vừa được tạo.
     */
    public function createNewsType(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'new_type_name' => 'required|max:255',
            'description' => 'required|max:255',
        ]);

        // Create a new news type
        DB::table('news_type')->insert([
            'new_type_name' => $validatedData['new_type_name'],
            'description' => $validatedData['description'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'message' => 'News type created successfully',
        ], 201);
    }
    /**
     * Update news type record in the database.
     *
     * @param int $id The ID of the news type to update.
     * @param array $data The data to update the news type record with.
     * @return bool True if the update was successful, false otherwise.
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateNewsType($id, array $data)
    {
        // Define validation rules for the update data
        $rules = [
            'new_type_name' => 'required|max:255',
            'description' => 'required|max:255',
            'updated_at' => 'required|date_format:Y-m-d H:i:s',
        ];

        // Validate the update data
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        // Update the news type record in the database
        $result = DB::table('news_type')
            ->where('id', $id)
            ->update([
                'new_type_name' => $data['new_type_name'],
                'description' => $data['description'],
                'updated_at' => $data['updated_at'],
            ]);

        return $result !== false;
    }
    /**
     * Xoá một bản ghi News Type
     *
     * @param int $id
     * @return int Số lượng bản ghi bị xoá
     */
    public function deleteNewsType($id)
    {
        // Validate input
        if (!is_numeric($id) || $id <= 0) {
            throw new InvalidArgumentException('Invalid news type ID');
        }

        // Delete the record
        $deleted = DB::table('news_type')->where('id', $id)->delete();

        return $deleted;
    }
}
