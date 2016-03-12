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

Route::get('/user', function () {

 $user = new User;
        $user->name =  "admin";
        $user->email =  "luismartinez24";
        $user->password =  bcrypt("admin");
        $user->save();

});

Route::get('/role', function () {

$owner = new Role();
$owner->name         = 'owner';
$owner->display_name = 'Project Owner'; // optional
$owner->description  = 'User is the owner of a given project'; // optional
$owner->save();

$admin = new Role();
$admin->name         = 'admin';
$admin->display_name = 'User Administrator'; // optional
$admin->description  = 'User is allowed to manage and edit other users'; // optional
$admin->save();

});

Route::get('/roleuser', function () {

$user = User::where('name', '=', 'admin')->first();

$admin = Role::where('name', '=', 'admin')->first();
// role attach alias
$user->attachRole($admin); // parameter can be an Role object, array, or id

// or eloquent's original technique
$user->roles()->attach($admin->id); // id only

});


Route::get('/permi', function () {

$createPost = new Permission();
$createPost->name         = 'create-post';
$createPost->display_name = 'Create Posts'; // optional
// Allow a user to...
$createPost->description  = 'create new blog posts'; // optional
$createPost->save();

$editUser = new Permission();
$editUser->name         = 'edit-user';
$editUser->display_name = 'Edit Users'; // optional
// Allow a user to...
$editUser->description  = 'edit existing users'; // optional
$editUser->save();

});

Route::get('/permirole', function () {

$admin = Role::where('name', '=', 'admin')->first();

$owner = Role::where('name', '=', 'owner')->first();

$createPost = Permission::where('name', '=', 'create-post')->first();

$editUser = Permission::where('name', '=', 'edit-user')->first();

$admin->attachPermission($createPost);
// equivalent to $admin->perms()->sync(array($createPost->id));

$owner->attachPermissions(array($createPost, $editUser));
// equivalent to $owner->perms()->sync(array($createPost->id, $editUser->id));

});

Route::get('/view', function () {

$user = User::where('name', '=', 'admin')->first();

echo "is Owner:".$user->hasRole('owner').'<br>';   // false
echo "is Admin:".$user->hasRole('admin').'<br>';   // true
echo "can edit-user:".$user->can('edit-user').'<br>';   // false
echo "can Owner: create-post".$user->can('create-post').'<br>'; // true

echo "has Owner or admin role:".$user->hasRole(['owner', 'admin']).'<br>';       // true
echo "has edit-use or create-post permission:".$user->can(['edit-user', 'create-post']).'<br>'; // true

echo "has owner or admin role:".$user->hasRole(['owner', 'admin']).'<br>';             // true
echo "has owner and admin role:".$user->hasRole(['owner', 'admin'], true).'<br>';       // false, user does not have admin role
echo "has edit-user or create-post permission:".$user->can(['edit-user', 'create-post']).'<br>';       // true
echo "has edit-user and create-post permission:".$user->can(['edit-user', 'create-post'], true).'<br>'; // false, user does not have edit-user permission

});

