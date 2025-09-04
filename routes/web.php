<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;




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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    $schools = [];
    return view('dashboard', compact('user'));
    // return view('admin.school.index', compact('user', 'schools'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('/students/export-excel', [StudentController::class, 'export'])->name('students.export');
Route::get('/schools/export-excel', [SchoolController::class, 'export'])->name('schools.export');

Route::resource('schools', SchoolController::class)->middleware('auth');
Route::resource('students', StudentController::class)->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('teachers/export', [TeacherController::class, 'export'])->name('teachers.export');
    Route::resource('teachers', TeacherController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::get('users/export', [UserController::class, 'export'])->name('users.export');
    Route::resource('users', UserController::class);
});
Route::post('groups/{group}/students', [GroupController::class, 'addStudents'])->name('groups.addStudents');
Route::post('groups/{group}/teachers', [GroupController::class, 'addTeachers'])->name('groups.addTeachers');
Route::get('groups/{group}/students', [GroupController::class, 'formStudents'])->name('groups.formStudents');
Route::get('groups/{group}/teachers', [GroupController::class, 'formTeachers'])->name('groups.formTeachers');
//storeDocument
Route::post('groups/{group}/documents', [GroupController::class, 'storeDocument'])->name('groups.storeDocument');
Route::delete('groups/{group}/documents/{id}', [GroupController::class, 'destroyDocument'])->name('groups.destroyDocument');
// Route::delete('groups/{group}/documents/{id}', f);
Route::resource('groups', GroupController::class);