<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Profile\UserController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\RecoverPasswordController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home
Route::redirect('/', '/login');

// Authentication
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});

Route::controller(RecoverPasswordController::class)->group(function () {
    Route::post('auth/recover', 'request')->name('password.email');
    Route::get('auth/recover-page', 'show')->name('password.reset');
});

// User
Route::controller(UserController::class)->group(function () {
    Route::get('profile/{id}', 'show')->where('id', '[0-9]+')->name('show');
    Route::get('/edit-profile/{id}', 'edit')->where('id', '[0-9]+')->name('edit');
    Route::put('/profile/{id}', 'update')->name('user.update');
    Route::post('profile/updateImage','updateImage')->name('profile.updateImage');  
    Route::post('/user-name', 'name');
});

//Project
Route::controller(ProjectController::class)->group(function() {
    Route::get('/project/create','showCreateForm')->name('createproject');
    Route::post('/project/create', 'create');
    Route::get('/projects', 'showProjects')->name('allprojects');
    Route::get('/project/{project_id}','show')->where(['project_id'=>'[0-9]+'])->name('project');
    Route::get('/project/{project_id}/tasks', 'showProjectTasks')->where(['project_id' => '[0-9]+'])->name('showProjectTasks');
    Route::get('/search-projects', 'search');
    Route::get('/project/{project_id}/adduser', 'showNonProjectMembers')->where(['project_id' => '[0-9]+'])->name('nonprojectmembers');
    Route::post('/project/add-user', 'addUser')->name('adduser');
});

//Task
Route::controller(TaskController::class)->group(function() {
    Route::get('/project/{project_id}/task/create', 'createTaskForm')->where(['project_id' => '[0-9]+'])->name('createtaskform');
    Route::post('/task/create', 'create')->name('createtask');
    Route::get('/task/{task_id}','show')->where(['task_id'=>'[0-9]+'])->name('task');
    Route::get('/task/{task_id}/edit', 'editDetailsForm')->name('editDetailsForm');
    Route::patch('/task/edit', 'updateDetails')->name('updatetaskdetails');
    Route::patch('/task/complete', 'completetask')->name('completeassignedtask');
    Route::post('/search-tasks', 'search');
});


// OAuth
Route::controller(GoogleController::class)->group(function () {
    Route::get('auth/google', 'redirect')->name('google-auth');
    Route::get('auth/google/call-back', 'callbackGoogle')->name('google-call-back');
});


Route::controller(AdminController::class)->group(function () {
    Route::post('admin/ban','banUser')->name('admin.banUser');
    Route::post('admin/unban','unbanUser')->name('admin.unbanUser');
});