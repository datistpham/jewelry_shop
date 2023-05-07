<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IntroductionController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NewsTypeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Auth
Route::post("/api/register", [AuthController::class, "register"]);
Route::post("/api/login", [AuthController::class, "login"]);

// Product
Route::get("/api/product", [ProductController::class, "getAllProduct"]);
Route::get("/api/product/detail", [ProductController::class, "getDetailProduct"]);
Route::post("/api/product", [ProductController::class, "addProduct"]);
Route::patch("/api/product/{id}", [ProductController::class, "updateProduct"]);
Route::delete("/api/product/{id}", [ProductController::class, "deleteProduct"]);

// Role
Route::post("/api/role", [RoleController::class, "createRoles"]);

// Slide
Route::get("/api/slide", [SlideController::class, "getSlide"]);
Route::post("/api/slide", [SlideController::class, "createSlide"]);
Route::patch("/api/slide/{id}", [SlideController::class, "updateSlide"]);
Route::delete("/api/slide/{id}", [SlideController::class, "deleteSlide"]);

// Category

Route::get("/api/category", [CategoryController::class, "getCategories"]);
Route::post("/api/category", [CategoryController::class, "createCategory"]);
Route::patch("/api/category", [CategoryController::class, "updateCategory"]);
Route::delete("/api/category", [CategoryController::class, "deleteCategory"]);


// Upload file

Route::post("/api/upload", [UploadController::class, "uploadFile"]);

// New type

Route::get("/api/new-types", [NewsTypeController::class, "getAllNewsTypes"]);
Route::get("/api/new-types/{id}", [NewsTypeController::class, "getAllNewsTypes"]);
Route::post("/api/new-type", [NewsTypeController::class, "createNewsType"]);
Route::patch("/api/new-type", [NewsTypeController::class, "updateNewsType"]);
Route::delete("/api/new-type", [NewsTypeController::class, "deleteNewsType"]);

// News

Route::get("/api/news", [NewsController::class, "getNews"]);
Route::get("/api/news/{id}", [NewsController::class, "getDetailNews"]);
Route::post("/api/news", [NewsController::class, "createNews"]);
Route::patch("/api/news/{id}", [NewsController::class, "updateNews"] );
Route::delete("/api/news", [NewsController::class, "deleteNews"] );

// Introduction

Route::get("/api/introduction", [IntroductionController::class, "getIntroduction"]);
Route::get("/api/introduction/{id}", [IntroductionController::class, "getIntroductionDetail"]);
Route::post("/api/introduction", [IntroductionController::class, "addNewIntroduction"]);
Route::patch("/api/introduction/{id}", [IntroductionController::class, "updateIntroduction"] );
Route::delete("/api/introduction", [IntroductionController::class, "deleteIntroduction"] );



