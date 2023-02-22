<?php

use App\Http\Controllers\Api\{
    AuthController,
    CommentController,
    CommunityController,
    PostController,
};
use App\Http\Resources\{
    PostResource,
    UserResource,
    CommunityResource
};
use App\Models\Post;
use App\Models\User;
use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('posts', function () {
    return PostResource::collection(Post::all());
})->middleware(['auth:sanctum', 'abilities:check-status,place-orders']);

Route::get('users', function () {
    return UserResource::collection(User::all());
});

Route::apiResources([
    'communities' => CommunityController::class,
    'posts' => PostController::class,
    'comments' => CommentController::class,
]);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('communities', CommunityController::class)->only(['store', 'update', 'destroy']);
    Route::apiResource('posts', PostController::class)->only(['store', 'update', 'destroy']);
    Route::apiResource('comments', CommentController::class)->only(['store', 'update', 'destroy']);
});

Route::post('login', AuthController::class)->name('api.login');