<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/managing-departments', 'Api\MainController@getManagingDepartments');

Route::get('/departments/{id}/sub-collection-list', 'Api\MainController@getSubCollectionListByDepartment');

Route::get('/employees/collection-list', 'Api\MainController@getEmployeesCollectionList');

Route::get('/unformed-employees/collection-list', 'Api\MainController@getUnformedEmployeesCollectionList');
