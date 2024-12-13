<?php

use Illuminate\Support\Facades\Route;

use App\Models\Skill;
use App\Http\Controllers\TestController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\AdminController;

Route::get('/', [AdminController::class, 'renderWelcomePage'])
    ->name('welcome');

Route::post('/add-comment', [BlogController::class, 'addComment'])->name('addComment');

Route::get('/pages/{name}', [AdminController::class, 'renderPublicPages'])
    ->name('pages');

Route::get('/test/{id}', [TestController::class, 'show']);

Route::get('/skills/{category}', [TestController::class, 'renderPageSkillsInCategory']);

// Это маршрут навыков
Route::get('/skills', [TestController::class, 'renderPageSkills']);

Route::get('/skills-json', [TestController::class, 'getAllSkills'])->middleware('auth');

// Страница создания скиллов
Route::get('/create-skill', [SkillController::class, 'renderCreatePage'])
    ->middleware('auth')
    ->name('skillCreate');

// Удаление скилла
Route::get('/delete-skill/{id}', [SkillController::class, 'deleteSkill'])
    ->middleware('auth')
    ->name('skillDelete');

// POST-запрос на создание скилла (НЕ СТРАНИЦА)
Route::post('/create-skill', [SkillController::class, 'createSkill'])
    ->middleware('auth')
    ->name('skillCreate.post');

Route::get('/portfolio', function () {
    $title = 'Портфолио Terricon';

    $jobs = [
        [
            'name' => 'Разработка сайта для ЖК',
            'price' => 1000,
            'val' => '$'
        ],
        [
            'name' => 'Разработка сайта для Клиники',
            'price' => 1500,
            'val' => '$'
        ],
        [
            'name' => 'Разработка сайта для Terricon',
            'price' => 2000,
            'val' => '$'
        ]
    ];

    return view('portfolio')
        ->with('title', $title)
        ->with('jobs', $jobs);
});

Route::get('/news', function () {
    $title = 'Новости';

    return view('news')->with('title', $title);
}); 

// ADMIN
Route::middleware([
    'auth',
    'roleChecker:admin'
])->prefix('admin')->group(function () {
    // /admin/users
    Route::get('/users', [AdminController::class, 'renderUsers'])
        ->name('renderUsers');

    /**
     * Редактирование юзера
     */
    Route::get('/users/{id}', [AdminController::class, 'renderEditUser'])
        ->name('renderEditUser');

    Route::post('/users/{id}', [AdminController::class, 'editUser'])
        ->name('editUser');

    /**
     * Добавление юзера
     */
    Route::get('/add-user', [AdminController::class, 'renderAddUser'])
        ->name('renderAddUser');

    Route::post('/add-user', [AdminController::class, 'addUser'])
        ->name('addUser');

    /**
     * Удаление юзера
     */
    Route::get('/delete-user/{id}', [AdminController::class, 'deleteUser'])
        ->name('deleteUser');

        Route::get('/delete-comment/{id}', [BlogController::class, 'deleteComment'])->name('deleteComment');
    Route::post('/edit-comment/{id}', [BlogController::class, 'editComment'])->name('editComment');
});
// /ADMIN

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});