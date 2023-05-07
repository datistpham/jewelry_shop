<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IntroductionController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIntroduction(Request $request)
    {
        $introductions = DB::table('introduction')->get();
        return response()->json($introductions);
    }
    /**
     * Get introduction detail by id
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getIntroductionDetail($id)
    {
        $introduction = DB::table('introduction')->where('id', $id)->first();

        if (!$introduction) {
            return response()->json(['message' => 'Introduction not found'], 404);
        }

        return response()->json($introduction);
    }
    /**
     * Store a newly created Introduction in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addNewIntroduction(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'image' => 'required|string',
            'content' => 'required|string',
            'create_by' => 'required|string',
        ]);

        $now = Carbon::now();

        DB::table('introduction')->insert([
            'name' => $validatedData['name'],
            'image' => $validatedData['image'],
            'content' => $validatedData['content'],
            'create_by' => $validatedData['create_by'],
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return response()->json(['message' => 'Introduction created successfully.'], 201);
    }
    /**
     * Update the specified introduction in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateIntroduction(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|string|max:255',
            'content' => 'required|string',
            'create_by' => 'required|string|max:255',
        ]);

        DB::table('introduction')
            ->where('id', $id)
            ->update([
                'name' => $validatedData['name'],
                'image' => $validatedData['image'],
                'content' => $validatedData['content'],
                'create_by' => $validatedData['create_by'],
                'updated_at' => Carbon::now(),
            ]);

        return response()->json(['message' => 'Introduction updated successfully.']);
    }
    /**
     * Xóa dữ liệu từ bảng introduction với điều kiện id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteIntroduction($id)
    {
        DB::table('introduction')->where('id', '=', $id)->delete();

        return response()->json([
            'message' => 'Xóa dữ liệu thành công!'
        ]);
    }
}
