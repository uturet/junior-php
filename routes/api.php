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

Route::get('/managing-departments/{type}', 'Api\MainController@getManagingDepartments')->where(['type' => 'list|widget']);

Route::middleware('custom.api.auth')->group(function () {

    Route::get('/departments/{id}/sub-collection-list', 'Api\MainController@getSubCollectionListByDepartment');

    Route::get('/employees/collection-list', 'Api\MainController@getEmployeesCollectionList');

    Route::get('/archived-employees/collection-list', 'Api\MainController@getArchivedEmployeesCollectionList');

    Route::get('/unformed-employees/collection-list', 'Api\MainController@getUnformedEmployeesCollectionList');

    Route::get('/employees/{id}/sub-collection', 'Api\MainController@getSubCollectionByEmployee');

    Route::get('/unformed-employees', 'Api\MainController@getUnformedEmployees');

    Route::get('/archived-employees', 'Api\MainController@getArchivedEmployees');

    Route::get('/free-positions', 'Api\MainController@getFreePositions');

    Route::get('/departments/{id}/sub-collection', 'Api\MainController@getSubCollectionByDepartment');

    Route::get('/departments/collection-list', 'Api\MainController@getDepartmentsCollectionList');

    Route::get('/positions/collection-list', 'Api\MainController@getPositionsCollectionList');

    Route::get('/events/collection-list', 'Api\MainController@getEventsCollectionList');


});