<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Profile\UserController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RecoverPasswordController;



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
Route::redirect('/', '/index');
Route::view('/index', 'pages.index')->name('index');
// Route::view('/about', 'pages.about')->name('about'); vai deixar de existir

Route::view('/home', 'pages.homePage')->name('home');

//redirects
Route::get('/forbidden', function () {
    return view('pages.forbidden');
});
Route::get('/notfound', function () {
    return view('pages.notfound');
});

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
    Route::get('password/forget', 'show')->name('password.forgot');
    Route::post('password/forget', 'request');
    Route::get('password/recover', 'showRecover')->name('password.recover');
    Route::post('password/recover', 'recover');
});

// User
Route::controller(UserController::class)->group(function () {
    Route::get('profile/{id}', 'show')->where('id', '[0-9]+')->name('show');
    Route::get('/edit-profile/{id}', 'edit')->where('id', '[0-9]+')->name('edit');
    Route::put('/profile/{id}', 'update')->name('user.update');
    Route::post('profile/updateImage','updateImage')->name('profile.updateImage');  
    Route::post('/user-name', 'name');
    Route::post('admin/delete/{id}','deleteUser')->where('id', '[0-9]+')->name('deleteUser');
    Route::get('/search-users', 'search');
});

//Project
Route::controller(ProjectController::class)->group(function() {
    Route::post('/project/create', 'create')->name('project.create');
    Route::get('/projects', 'showAllProjects')->name('allprojects');
    Route::get('/project/{project_id}','show')->where(['project_id'=>'[0-9]+'])->name('project');
    Route::get('/search-projects', 'search');
    Route::post('/addMember', 'addMember')->name('addmember');
    Route::delete('/leaveProject/{id}', 'leaveProject')->name('leaveproject');
    Route::delete('/kickMember/{user_id}/{project_id}', 'kickMember')->name('kickmember');
    Route::post('/changeCoordinator/{username}/{project_id}', 'changeCoordinator')->name('changeCoordinator');
    Route::patch('/project/edit', 'updatedetails')->name('project.update_details');
    Route::patch('/project/{id}/changevisibility', 'update_visibility')->name('project.update_visibility');
    Route::patch('/project/{id}/changestatus', 'update_status')->name('project.update_status');
    Route::post('/favoriteProject', 'favoriteProject')->name('favoriteProject');
});

//Task
Route::controller(TaskController::class)->group(function() {
    Route::post('/task/create', 'create')->name('task.create');
    Route::get('/task/{task_id}','show')->where(['task_id'=>'[0-9]+'])->name('task');
    Route::patch('/task/edit', 'updatedetails')->name('task.update_details');
    Route::patch('/task/complete/{taskId}', 'completetask')->name('task.complete');
    Route::patch('/task/archive/{taskId}', 'archivetask')->name('task.archive');
    Route::post('/search-tasks', 'search');
    Route::patch('/task/assign', 'assign')->name('task.assign');
    Route::patch('/task/upload', 'upload_file')->name('task.upload');
    Route::get('/task/download/{task}', 'download_file')->name('task.download');
});

//Comment
Route::controller(CommentController::class)->group(function() {
    Route::post('/comment/create', 'create')->name('comment.create');
    Route::delete('/comment/delete/{id}', 'delete')->name('comment.delete');
    Route::patch('/comment/edit/{id}', 'edit')->name('comment.edit');
});

//Invite
Route::controller(InviteController::class)->group(function() {
    Route::post('/invite/create', 'create')->name('invite.create');
});	

//Message
Route::controller(MessageController::class)->group(function() {
    Route::post('/message/create', 'create')->name('message.create');
    Route::delete('/message/delete/{id}', 'delete')->name('message.delete');
    Route::patch('/message/edit/{id}', 'edit')->name('message.edit');
});	

//Notifications
Route::controller(NotificationController::class)->group(function() {
    Route::post('/dismiss-notification', 'dismiss')->name('notification.dismiss');
    Route::get('/notifications', 'show')->name('notifications');
});

// Google API
Route::controller(GoogleController::class)->group(function () {
    Route::get('auth/google', 'redirect')->name('google-auth');
    Route::get('auth/google/call-back', 'callbackGoogle')->name('google-call-back');
});

//Admin
Route::controller(AdminController::class)->group(function () {
    Route::post('admin/ban/{id}','banUser')->where('id', '[0-9]+')->name('admin.banUser');
    Route::post('admin/unban/{id}','unbanUser')->where('id', '[0-9]+')->name('admin.unbanUser');
    Route::get('dashboard','dashboard')->name('admin.dashboard');
});
