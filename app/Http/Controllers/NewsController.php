<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    //
    /**
     * Get the list of news.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNews()
    {
        $news = DB::table('news')
            ->join('news_type', 'news.new_type_id', '=', 'news_type.id')
            ->select('news.id', 'news_type.new_type_name', 'news.title', 'news.description', 'news.created_at')
            ->orderBy('news.created_at', 'desc')
            ->get();

        return response()->json(['data' => $news], 200);
    }
    /**
     * Lấy chi tiết tin tức theo id
     *
     * @param int $id
     * @return Illuminate\Http\Response
     */
    public function getDetailNews($id)
    {
        $news = DB::table('news')
            ->select('news.id', 'news.new_type_id', 'news.title', 'news.description', 'news.content', 'news.created_at', 'news.updated_at', 'news_type.new_type_name')
            ->join('news_type', 'news.new_type_id', '=', 'news_type.id')
            ->where('news.id', '=', $id)
            ->first();
        if (!$news) {
            return response()->json(['message' => 'Tin tức không tồn tại'], 404);
        }
        return response()->json(['news' => $news], 200);
    }
    /**
     * Thêm mới tin tức vào bảng news.
     *
     * @param array $data Thông tin của tin tức cần thêm mới.
     * @return mixed
     * @throws Exception
     */
    public function createNews(Request $request)
    {
        $request->validate([
            'new_type_id' => 'required|exists:news_type,id',
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'content' => 'required',
            'created_at' => 'required',
            'updated_at' => 'required',
        ]);

        DB::table('news')->insert([
            "new_type_id" => $request->new_type_id,
            "title" => $request->title,
            "description" => $request->description,
            "content" => $request->content,
            "created_at" => $request->created_at,
            "updated_at" => $request->updated_at,
        ]);

        return response()->json([
            'message' => 'News created successfully.'
        ], 201);
    }
    /**
     * Update the specified news in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'new_type_id' => 'required|exists:new_types,id',
            'title' => 'required',
            'description' => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        DB::table('news')
            ->where('id', $id)
            ->update([
                'new_type_id' => $request->new_type_id,
                'title' => $request->title,
                'description' => $request->description,
                'content' => $request->content,
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);

        return response()->json(['message' => 'News updated successfully.'], 200);
    }
    /**
     * Xóa bản ghi từ bảng `news` dựa trên `id` của nó.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function deleteNews($id)
    {
        $news = DB::table('news')->where('id', $id)->delete();

        if (!$news) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa bản ghi',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Bản ghi đã được xóa thành công',
        ]);
    }
}
