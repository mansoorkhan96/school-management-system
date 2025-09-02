<?php

use App\Models\Student;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('login');

Route::get('/printables/id-card', function () {
    $student = Student::first();

    return view('printables.id-card', [
        'student' => $student,
    ]);
})->name('printables.id-card');

Route::get('/printables/id-card-landscape', function () {
    $student = Student::first();

    return view('printables.id-card-landscape', [
        'student' => $student,
    ]);
})->name('printables.id-card-landscape');
