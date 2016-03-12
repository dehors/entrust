<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Role;
use App\User;
use App\Permission;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});
