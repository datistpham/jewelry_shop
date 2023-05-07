<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //
    public function getAllProduct()
    {
        $products = DB::table('product')->get();
        return response()->json($products);
    }

    public function getDetailProduct(Request $request)
    {
        $product = DB::table('product')
            ->where('id', $request->productId)
            ->first();
        return response()->json($product);
    }
    /**
     * Thêm sản phẩm mới vào database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function addProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'required|string|max:255',
            'size' => 'required|string|max:255',
            'material' => 'required|string|max:255',
            'note' => 'required|string|max:255',
            'shipment_number' => 'required|string|max:255',
            'introduction' => 'required|string',
            'status' => 'required|integer',
            'amount' => 'required|integer',
            'product_type_id' => 'required|integer',
            'producer_id' => 'required|integer',
            'price' => 'required|integer',
            'sales_price' => 'required|integer',
            'show_home' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $result = DB::table('product')->insertGetId([
            'name' => $request->name,
            'image' => $request->image,
            'size' => $request->size,
            'material' => $request->material,
            'note' => $request->note,
            'shipment_number' => $request->shipment_number,
            'introduction' => $request->introduction,
            'status' => $request->status,
            'amount' => $request->amount,
            'product_type_id' => $request->product_type_id,
            'producer_id' => $request->producer_id,
            'price' => $request->price,
            'sales_price' => $request->sales_price,
            'show_home' => $request->show_home,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['product_id' => $result], 200);
    }
    /**
     * Cập nhật sản phẩm
     *
     * @param  int  $id
     * @param  Illuminate\Http\Request  $request
     * @return Illuminate\Http\JsonResponse
     */
    public function updateProduct($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'image' => 'required|max:255',
            'size' => 'required|max:255',
            'material' => 'required|max:255',
            'note' => 'required|max:255',
            'shipment_number' => 'required|max:255',
            'introduction' => 'required',
            'status' => 'required|integer',
            'amount' => 'required|integer',
            'product_type_id' => 'required|integer',
            'producer_id' => 'required|integer',
            'price' => 'required|integer',
            'sales_price' => 'required|integer',
            'show_home' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        try {
            $product = DB::table('product')->where('id', $id)->first();

            if (!$product) {
                return response()->json(['error' => 'Product not found'], 404);
            }

            $updateData = [
                'name' => $request->input('name'),
                'image' => $request->input('image'),
                'size' => $request->input('size'),
                'material' => $request->input('material'),
                'note' => $request->input('note'),
                'shipment_number' => $request->input('shipment_number'),
                'introduction' => $request->input('introduction'),
                'status' => $request->input('status'),
                'amount' => $request->input('amount'),
                'product_type_id' => $request->input('product_type_id'),
                'producer_id' => $request->input('producer_id'),
                'created_at' => $product->created_at,
                'updated_at' => now(),
                'price' => $request->input('price'),
                'sales_price' => $request->input('sales_price'),
                'show_home' => $request->input('show_home'),
            ];

            DB::table('product')->where('id', $id)->update($updateData);

            $updatedProduct = DB::table('product')->where('id', $id)->first();

            return response()->json(['product' => $updatedProduct], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Xóa sản phẩm
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteProduct($id)
    {
        $deleted = DB::table('product')->where('id', $id)->delete();
        if ($deleted) {
            return response()->json([
                'status' => 'success',
                'message' => 'Sản phẩm đã được xóa thành công'
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Không thể xóa sản phẩm'
            ], 400);
        }
    }
}
