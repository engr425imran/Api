<?php
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\Auth\RegisteredUserController;
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

// --------------------- Edit Or Show Delivery   ------------------------------
Route::get('/deliveries/edit/{id}', [DeliveryController::class, 'edit']);
Route::get('/deliveries/show/{id}', [DeliveryController::class, 'show']);
// --------------------- Save Delivery   ---------------------------------------
Route::get('/getdata', [DeliveryController::class, 'index']);
Route::post('/savedata', [DeliveryController::class, 'store']);

// -----------------------------------------------------------------------------
Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);
    return ['token' => $token->plainTextToken];
});
// --------------------  Get User  ----------------------------------------------
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// --------------------  Logout User  ----------------------------------------------
Route::middleware('auth:sanctum')->post('/sanctum/logout',[ApiController::class, 'logout']);

Route::post('/sanctum/token', [ApiController::class, 'create']);
Route::post('/sanctum/login', [ApiController::class, 'login']);

// -------------------- Socailte Routes  ----------------------------------------------

Route::get('/auth/redirect', function () {
    return Socialite::driver('google')->stateless()->redirect()->getTargetUrl();
});

Route::get('/auth/callback', function () {
    $callBackUser = Socialite::driver('google')->stateless()->user();
    if(!User::where('email',$callBackUser->email)->first()) {
        $newUser=User::create([
            'name' =>$callBackUser->name,
            'email' =>$callBackUser->email
        ]);
        $deviceName = 'ipone13';              

        return $newUser->createToken($deviceName)->plainTextToken;

    }
    else {
        $user = User::where('email', $callBackUser->email)->first();

        return $user->createToken($deviceName)->plainTextToken;

    }
});
