<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear-cache', function() {
	Artisan::call('cache:clear');
	Artisan::call('optimize:clear');
	Artisan::call('route:clear');
	Artisan::call('view:clear');
	Artisan::call('config:clear');
	Artisan::call('event:clear');
});
Route::get('/generate_pdf/{id?}','FinanceController@generate_pdf');
Route::get('/','HomeController@index');
Route::get('/privacy','HomeController@privacy');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => ['auth']], function () {
	Route::group(['middleware' => ['auth','can:isSuper']], function () {
		Route::resource('valuation','ValuationController');
		Route::resource('duplicate','DuplicateController');
		Route::resource('header', 'HeaderController');
		Route::resource('declaration','DeclarationController');
		Route::resource('area','AreaController');
		Route::resource('state','StateController');
		Route::resource('grid','GridController');
		Route::get('grid_excel','GridController@make_excel')->name('grid_excel');
		Route::get('area_excel','AreaController@make_excel')->name('area_excel');
		Route::post('valuation_position','ValuationController@valuation_position')->name('valuation_position');
		Route::post('declaration_position','DeclarationController@declaration_position')->name('declaration_position');
		Route::post('duplicate_position','DuplicateController@duplicate_position')->name('duplicate_position');
		Route::get('logs/','AdminController@logs')->name('logs');
		Route::get('backup_data','MakeBackup@backup')->name('backup_data');
		Route::get('fullbackup','MakeBackup@fullbackup')->name('fullbackup');
		Route::get('filebackup','MakeBackup@filebackup')->name('filebackup');
		Route::get('databasebackup','MakeBackup@databasebackup')->name('databasebackup');
		Route::get('downlaodbackup/{filename}','MakeBackup@downlaodbackup')->name('downlaodbackup');
		Route::delete('deletebackup/{filename}','MakeBackup@deletebackup')->name('deletebackup');
		Route::post('image_backup','MakeBackup@image_backup')->name('image_backup');
		Route::post('report_excel','FinanceController@report_excel')->name('report_excel');
		Route::post('make_excel','FinanceController@make_excel')->name('make_excel');
		Route::get('deleted_report','FinanceController@deleted_report')->name('deleted_report');
		Route::post('report_restore/{id?}','FinanceController@report_restore')->name('report_restore');

		Route::Post('report_delete/{id?}','FinanceController@report_delete')->name('report_delete');
		Route::Post('multiple_delete_report/{id?}','FinanceController@multiple_delete_report')->name('multiple_delete_report');
		Route::post('staff_status','StaffController@staff_status')->name('staff_status');
		Route::post('staff_position','StaffController@staff_position')->name('staff_position');
		Route::post('multiple_delete','FinanceController@multiple_delete')->name('multiple_delete');
		Route::post('rejected_delete','FinanceController@rejected_delete')->name('rejected_delete');
		Route::match(['get','put'],'update_deposit/{id?}','FinanceController@update_deposit')->name('update_deposit');
		Route::get('today_report_excel','FinanceController@today_report_excel')->name('today_report_excel');
		Route::post('delete_rejected/{id?}','FinanceController@delete_rejected')->name('delete_rejected');
		Route::post('pdf_remove','ValuationController@pdf_remove')->name('pdf_remove');
		
	});
	Route::group(['middleware' => ['auth','can:isWeb']], function () {
		Route::resource('users','UserController');
		Route::get('users/create/{role_id}','UserController@create')->name('create');
		//Route::get('users/{role}','UserController@show')->name('show');
		Route::resource('user_notification','UserNotificationController');
		Route::resource('company_notification','CompanyNotificationController');
		Route::match(['get','post'],'/profile','UserController@profile')->name('profile');
		Route::match(['get','post'],'/changepassword','UserController@changepassword')->name('changepassword');
		Route::post('getcompany_area','UserNotificationController@getcompany_area')->name('getcomparea');
		Route::post('share_notification','CompanyNotificationController@sharenote')->name('sharenote');
		Route::get('/old_reports','FinanceController@index')->name('old_reports');
		Route::get('/mobile_reports','FinanceController@index')->name('mobile_report');
		Route::get('/duplicate_reports','FinanceController@index')->name('duplicate_report');
		Route::get('/today_reports','FinanceController@index')->name('today_report');
		Route::resource('report','FinanceController');
		Route::post('image_reorder','FinanceController@image_reorder')->name('image_reorder');
		Route::post('image_rotate','FinanceController@image_rotate')->name('image_rotate');
		Route::post('image_remove','FinanceController@image_remove')->name('image_remove');
		Route::post('make_pdf','FinanceController@make_pdf')->name('make_pdf');
		Route::post('check_duplicate','FinanceController@check_duplicate')->name('check_duplicate');
		Route::get('getreason/','DuplicateController@getreason')->name('getreason');
		Route::get('users/{role}/{status?}','UserController@users')->name('userfill');
		Route::post('users/image','UserController@image')->name('updateimage');
		Route::post('/changerefer','UserController@changereferno')->name('changereferno');
		Route::post('/changerolerefer','UserController@changerolereferno')->name('changerolereferno');
		Route::post('documents','UserController@documents')->name('document');
		Route::post('statuschange','UserController@change_status')->name('statuschange');
		Route::get('make_users_zip/{id?}','UserController@make_users_zip')->name('make_users_zip');		
		Route::get('getstatearea','AreaController@getstatearea');
		Route::resource('staff','StaffController');
		Route::post('get_grid_pdf','ValuationController@get_grid_pdf')->name('get_grid_pdf');
		Route::post('get_grid','GridController@get_grid')->name('get_grid');
		Route::post('get_duplicate','FinanceController@get_duplicate')->name('get_duplicate');
		Route::put('report_reject/{id?}','FinanceController@report_reject')->name('report_reject');
		Route::get('reject_reports','FinanceController@reject_reports')->name('reject_reports');
		Route::get('get_rejected_reason/{id?}','FinanceController@get_rejected_reason')->name('get_rejected_reason');
		Route::post('rejected_restore/{id?}','FinanceController@rejected_restore')->name('rejected_restore');
	});
});
Route::group(['prefix' => 'admin','middleware' => ['auth','can:isMobile']], function () {
	Route::get('/','MobileadminController@home')->name('mobile_home');
	Route::get('/mobile_executive','MobileadminController@mobile_executive')->name('mobile_executive');
	Route::get('/reports','MobileadminController@reports')->name('reports');
	Route::get('/rejected_reports','MobileadminController@rejected_reports')->name('rejected_reports');
	Route::get('/notification','MobileadminController@notification')->name('notification');
	Route::post('/send_notification','MobileadminController@send_notification')->name('send_notification');
	Route::post('/profile_image','MobileadminController@profile_image')->name('profile_image');
	Route::post('/make_reports_excel','MobileadminController@make_reports_excel')->name('make_reports_excel');
});
Route::group(['prefix' => 'cp-admin','middleware' => ['auth','can:isCompany']], function () {
	Route::get('/','CompanyadminController@home')->name('company_home');
	Route::get('/company_notification','CompanyadminController@company_notification')->name('company_notification');
	Route::post('/company_notification_send','CompanyadminController@send_notification')->name('company_notification_send');
});  
Route::get('make_zip/{id?}','FinanceController@make_zip')->name('make_zip');
Route::post('/save-token','HomeController@saveToken')->name('save-token');
Route::get('/send-notification', 'HomeController@sendNotification')->name('send.notification');
/*Route::get('/unauthorized', function(){
    return View('unauthorized'); // Your Blade template name
});*/

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
