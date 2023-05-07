<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SlideController extends Controller
{
    /**
     * Lấy danh sách các slide từ bảng slide
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSlide()
    {
        $slides = DB::table('slide')->get();

        return response()->json($slides);
    }
    //
    /**
     * Tạo slide
     *
     * @param  string  $slideName
     * @param  string  $image
     * @return void
     */
    public function createSlide(Request $request)
    {
        DB::table('slide')->insert([
            'slide_name' => $request->slide_name,
            'image' => $request->image,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return response()->json(["add" => true]);
    }
    /**
     * Cập nhật slide theo ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateSlide($id, Request $request)
    {
        $slide = DB::table('slide')->where('id', $id)->first();
        if ($slide) {
            DB::table('slide')->where('id', $id)->update(["slide_name" => $request->slide_name, "image" => $request->image]);
            return response()->json(['message' => 'Slide updated successfully'], 200);
        } else {
            return response()->json(['message' => 'Slide not found'], 404);
        }
    }

    /**
     * Xóa slide với id được cung cấp.
     *
     * @param int $id ID của slide cần xóa.
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteSlide(Request $request, $id)
    {
        $slide = DB::table('slide')->where('id', $id)->first();

        if (!$slide) {
            return response()->json(['message' => 'Slide not found'], 404);
        }

        DB::table('slide')->where('id', $id)->delete();

        return response()->json(['message' => 'Slide deleted successfully'], 200);
    }
}
