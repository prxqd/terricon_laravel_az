<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Controllers\SkillControler;

Route::get('/skills',[SkillControler::class, 'getApiSkills']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
