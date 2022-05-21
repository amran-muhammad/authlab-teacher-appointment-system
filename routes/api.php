<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ScheduleController;
use App\Http\Controllers\API\BookingController;


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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
Route::post('user/create/new/teacher', [UserController::class, 'create_new_teacher'])->middleware('auth:sanctum');
Route::post('user/create/new/student', [UserController::class, 'create_new_student'])->middleware('auth:sanctum');
Route::post('user/update/data', [UserController::class, 'update_user'])->middleware('auth:sanctum');
Route::get('user/search', [UserController::class, 'find_a_user'])->middleware('auth:sanctum');
Route::get('teachers/all', [UserController::class, 'get_all_teacher'])->middleware('auth:sanctum');
Route::get('students/all', [UserController::class, 'get_all_student'])->middleware('auth:sanctum');

//dashboard
Route::get('dashboard/search', [ScheduleController::class, 'find_a_user'])->middleware('auth:sanctum');
Route::get('dashboard/schedules/all', [ScheduleController::class, 'get_all_schedule_for_dashboard'])->middleware('auth:sanctum');
Route::get('dashboard/teachers/all', [UserController::class, 'get_all_dashboard_teacher'])->middleware('auth:sanctum');

//Schedues
Route::get('schedules/all', [ScheduleController::class, 'get_schedules'])->middleware('auth:sanctum');
Route::post('schedules/create', [ScheduleController::class, 'create_schedule'])->middleware('auth:sanctum');
Route::put('schedules/update', [ScheduleController::class, 'update_schedule'])->middleware('auth:sanctum');
Route::post('schedules/delete', [ScheduleController::class, 'delete_schedule'])->middleware('auth:sanctum');

//Booking
Route::post('booking/delete', [BookingController::class, 'delete_booking'])->middleware('auth:sanctum');
Route::put('booking/update', [BookingController::class, 'update_booking'])->middleware('auth:sanctum');
Route::post('booking/create', [BookingController::class, 'create_booking'])->middleware('auth:sanctum');
Route::get('booking/all', [BookingController::class, 'get_bookings'])->middleware('auth:sanctum');
