<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth;
use App\Http\Controllers\Api\ResidentController;
use App\Http\Controllers\Api\VisitorRecordController;
use App\Http\Controllers\Api\ClusterController;
use App\Http\Controllers\Api\GuardController;

Route::get('/guards/{id}/contact-info', [GuardController::class, 'getContactInfo']);

Route::get('/clusters/{cluster_id}/is-maintenance-time', [ClusterController::class, 'isMaintenanceTime'])->middleware('auth:sanctum');

Route::post('auth',[Auth::class,'auth'])->name('auth');

Route::get('/residents/count', [ResidentController::class, 'countResidents'])->middleware('auth:sanctum');

Route::post('/houses/{house_id}/visitor-records', [VisitorRecordController::class, 'createVisitorRecord'])->middleware('auth:sanctum');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
