<?php


	Route::get('/slugGet/get/{testSlug}', [
		'as' => 'admin.cms', 'uses' => 'Admin\CmsController@getPageSlug',
	]);
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@authenticate');
	Route::post('forgot', 'AuthController@forgotPassword');
	Route::post('verify', 'AuthController@verify');
	Route::post('reset', 'AuthController@reset');
	Route::post('register', 'AuthController@authenticate');
	Route::get('logout', 'AuthController@logout');
    Route::get('check', 'AuthController@check');
    
    Route::get('/get', [
		'as' => 'admin.cms', 'uses' => 'Admin\CmsController@allCmsPages',
	]);
	Route::get('/edit/{id}', [
		'as' => 'admin.cities.edit', 'uses' => 'Admin\CmsController@editCmsPageByPageID',
	]);

	Route::delete('/{id}', [
		'as' => 'admin.cms.destroy', 'uses' => 'Admin\CmsController@deleteCmsPageByID',
	]);

	Route::post('/update', [
		'as' => 'admin.cms.update', 'uses' => 'Admin\CmsController@updateCmsPage',
	]);

	Route::post('/add', [
		'as' => 'admin.cms.add', 'uses' => 'Admin\CmsController@addNewCmsPage',
	]);

	// Get Page by Slug

});

Route::get('total_downloads','Admin\UserController@totalDownloads');
Route::get('monthly_active_users','Admin\UserController@MonthlyActivceUsers');
Route::get('retention_rate','Admin\UserController@RetentionRate');
// session route
Route::post('phone-exist', [
	'as' => 'phone-exist', 'uses' => 'Admin\UserController@phoneExist',

]);

Route::post('phone-existId/{Id}', [
	'as' => 'phone-existId', 'uses' => 'Admin\UserController@phoneExistWithId',
]);
Route::post('passwordcheck', [
	'as' => 'passwordcheck', 'uses' => 'Admin\UserController@currentPassword',
]);
Route::get('/getCitiesToShow', 'Admin\CitiesController@getCitiesToShow');
Route::get('/getCityServices', 'Admin\ServiceProvidersController@getCityServices');

// Route::group(['prefix' => 'cms'], function () {

// 	// CMS Crud
// 	Route::get('/get', [
// 		'as' => 'admin.cms', 'uses' => 'Admin\CmsController@allCmsPages',
// 	]);
// 	Route::get('/edit/{id}', [
// 		'as' => 'admin.cities.edit', 'uses' => 'Admin\CmsController@editCmsPageByPageID',
// 	]);

// 	Route::delete('/{id}', [
// 		'as' => 'admin.cms.destroy', 'uses' => 'Admin\CmsController@deleteCmsPageByID',
// 	]);

// 	Route::post('/update', [
// 		'as' => 'admin.cms.update', 'uses' => 'Admin\CmsController@updateCmsPage',
// 	]);

// 	Route::post('/add', [
// 		'as' => 'admin.cms.add', 'uses' => 'Admin\CmsController@addNewCmsPage',
// 	]);

// 	// Get Page by Slug
// 	Route::get('/slugGet/get/{testSlug}', [
// 		'as' => 'admin.cms', 'uses' => 'Admin\CmsController@getPageSlug',
// 	]);

// });

// admin route
Route::group(['prefix' => 'admin', 'middleware' => ['api.auth']], function (){

    Route::get('logout', 'AuthController@logout');

    Route::resource('todos', 'Demo\TodosController');

    Route::post('todos/toggleTodo/{id}', [
        'as' => 'admin.todos.toggle', 'uses' => 'Demo\TodosController@toggleTodo'
    ]);

    Route::group(['prefix' => 'settings'], function () {

        Route::post('/social', [
            'as' => 'admin.settings.social', 'uses' => 'Demo\SettingsController@postSocial'
        ]);
    });

    Route::group(['prefix' => 'medicines'], function () {

        Route::get('/get',[
            'as' => 'admin.medicines', 'uses' => 'Admin\MedicinesController@allMedicines'
        ]);
        Route::get('/catGet/get',[
            'as' => 'admin.medicines', 'uses' => 'Admin\MedicinesController@allMedicinesCat'
        ]);
        Route::get('/count/get',[
            'as' => 'admin.medicines', 'uses' => 'Admin\MedicinesController@countMedicines'
        ]);
        Route::get('/dropdown/get',[
            'as' => 'admin.medicines', 'uses' => 'Admin\MedicinesController@allMedicinesDropdown'
        ]);
        Route::get('/miscelleneousdropdown/get',[
            'as' => 'admin.medicines', 'uses' => 'Admin\MedicinesController@allMiscellaneousMedicinesDropdown'
        ]);
        Route::delete('/{id}',[
            'as' => 'admin.medicines.destroy', 'uses' => 'Admin\MedicinesController@destroyMedicine'
        ]);
        Route::delete('/delCate/{id}',[
            'as' => 'admin.medicines.destroy', 'uses' => 'Admin\MedicinesCategoryController@destroyMedicineCat'
        ]);
        Route::get('/edit/{id}',[
            'as' => 'admin.medicines', 'uses' => 'Admin\MedicinesController@editMedicine'
        ]);
        Route::post('/update', [
            'as' => 'admin.medicines', 'uses' => 'Admin\MedicinesController@updateMedicine'
        ]);
        // Route::post('/cat/add', [
        //     'as' => 'admin.medicines.add', 'uses' => 'Admin\MedicinesController@catAdd'
        // ]);
        Route::post('/add', [
            'as' => 'admin.medicines.add', 'uses' => 'Admin\MedicinesController@addMedicine'
        ]);
        Route::post('/updatepimage/{id}',[
            'as' => 'admin.medicines.update', 'uses' => 'Admin\MedicinesController@iconSet'
        ]);
        Route::get('/category/get',[
            'as' => 'admin.medicines', 'uses' => 'Admin\MedicinesCategoryController@allMedicinesCat'
        ]);
        // Route::delete('/cat/{id}',[
        //     'as' => 'admin.medicines.destroy', 'uses' => 'Admin\MedicinesCategoryController@destroyMedicineCat'
        // ]);
        Route::post('/cat/add', [
            'as' => 'admin.medicines.add', 'uses' => 'Admin\MedicinesCategoryController@addMedicineCat'
        ]);
        Route::post('/cat/update', [
            'as' => 'admin.medicines.add', 'uses' => 'Admin\MedicinesCategoryController@updateMedicineCat'
        ]);
        Route::get('/categoryOFpharmacy/{id}',[
            'as' => 'admin.medicines', 'uses' => 'Admin\PharmacyCatMedicineController@editPharmaCat'
        ]);
        Route::get('getWarnings', 'Admin\MedicinesController@medicineWarning');
        Route::get('/getMiscellaneousMedicines',[
            'as' => 'admin.miscellaneousMedicines', 'uses' => 'Admin\MedicinesController@allMiscellaneousMedicines'
        ]);
        Route::get('/editMiscellaneous/{id}',[
            'as' => 'admin.medicines', 'uses' => 'Admin\MedicinesController@editMiscellaneousMedicine'
        ]);
        
        Route::post('/updateMiscellaneous', [
            'as' => 'admin.medicines', 'uses' => 'Admin\MedicinesController@updateMiscellaneousMedicine'
        ]);
        Route::delete('/miscellaneous/{id}',[
            'as' => 'admin.medicines.destroy', 'uses' => 'Admin\MedicinesController@destroyMiscellaneousMedicine'
        ]);
       
    });

    Route::group(['prefix' => 'history'], function () {

        Route::get('/get/{id}',[
            'as' => 'admin.history', 'uses' => 'Admin\UserController@UsersHistory'
        ]);
    });

//statistics
// Route::group(['prefix' => 'statistics'], function () {

//     Route::get('/total_signups',[
//         'as' => 'users.total_signups', 'uses' => 'Admin\UserController@totalSignups'
//     ]);
//     Route::get('/total_downloads',[
//         'as' => 'users.total_downloads', 'uses' => 'Admin\UserController@totalDownloads'
//     ]);
//     Route::get('/monthly_active_users',[
//         'as' => 'users.monthly_active_users', 'uses' => 'Admin\UserController@MonthlyActivceUsers'
//     ]);
//     Route::get('/retention_rate',[
//         'as' => 'users.retention_rate', 'uses' => 'Admin\UserController@RetentionRate'
//     ]);
// });



    Route::group(['prefix' => 'users'], function (){

        Route::post('EmployeeUpdate', [
			'as' => 'admin.roles.add', 'uses' => 'Admin\UserController@EmployeeUpdate',
        ]);
        Route::get('/recentEmp/get',[
            'as' => 'admin.users', 'uses' => 'Admin\UserController@recentEmp'
        ]);

        Route::get('/get',[
            'as' => 'admin.users', 'uses' => 'Admin\UserController@allUsers'
        ]);
        Route::get('/countPanel/get',[
            'as' => 'admin.users', 'uses' => 'Admin\UserController@countPanel'
        ]);
        Route::get('employees/get',[
            'as' => 'admin.users', 'uses' => 'Admin\UserController@allEmployees'
        ]);
        Route::post('employeesEdit/get',[
            'as' => 'admin.users', 'uses' => 'Admin\UserController@EditEmployees'
        ]);
        Route::get('employee/edit/{id}',[
            'as' => 'admin.users.edit', 'uses' => 'Admin\UserController@EditGetEmployees'
        ]);
        Route::get('/graph',[
            'as' => 'admin.users', 'uses' => 'Admin\UserController@graph'
        ]);
        Route::get('/mingledGraph',[
            'as' => 'admin.users', 'uses' => 'Admin\UserController@mingledGraph'
        ]);

        Route::get('/recent/get',[
            'as' => 'admin.users', 'uses' => 'Admin\UserController@recentUsers'
        ]);

        Route::get('/edit/{id}',[
            'as' => 'admin.users.edit', 'uses' => 'Admin\UserController@editUser'
        ]);    
        Route::get('/album/{id}',[
            'as' => 'admin.users.edit', 'uses' => 'Admin\UserController@albumUser'
        ]);   

        Route::delete('/{id}',[
            'as' => 'admin.users.destroy', 'uses' => 'Admin\UserController@destroyUser'
        ]);

        Route::post('/verify/{id}',[
            'as' => 'admin.users.verify', 'uses' => 'Admin\UserController@verify'
        ]);

        Route::put('/unVerify/{id}',[
            'as' => 'admin.users.unVerify', 'uses' => 'Admin\UserController@unVerify'
        ]);

        Route::put('/{id}',[
            'as' => 'admin.users.block', 'uses' => 'Admin\UserController@block'
        ]);

        Route::put('unblock/{id}',[
            'as' => 'admin.users.unblock', 'uses' => 'Admin\UserController@unblock'
        ]);       

        Route::post('/update', [
            'as' => 'admin.users.update', 'uses' => 'Admin\UserController@updateUser'
        ]);

        Route::post('/updatePkg', [
            'as' => 'admin.users.updatePkg', 'uses' => 'Admin\UserController@updatePkg'
        ]);

        Route::post('/EmployeeAdd', [
            'as' => 'admin.users.add', 'uses' => 'Admin\UserController@addEmployee'
        ]);
        Route::post('/deActivate_activate/{id}', [
            'as' => 'admin.users', 'uses' => 'Admin\UserController@deActivate_activate'
        ]);

        Route::get('admin/edit/{id}',[
            'as' => 'admin.users', 'uses' => 'Admin\UserController@getadmin'
        ]);

        Route::get('/usercountget',[
            'as' => 'admin.users', 'uses' => 'Admin\UserController@userCount'
        ]);

        Route::get('/matches/get',[
            'as' => 'admin.users', 'uses' => 'Admin\UserController@getUserMatches'
        ]);
       
        Route::get('/jsonDropdowns',[
            'as' => 'admin.users', 'uses' => 'Admin\UserController@jsonDropdowns'
        ]);
        Route::get('/blocked/get',[
            'as' => 'admin.users', 'uses' => 'Admin\UserController@allBlockedUsers'
        ]);
        Route::get('/reportsC/get',[
            'as' => 'admin.users', 'uses' => 'Admin\UserController@allreportsUsers'
        ]);
        Route::get('/blockedByAdmin/get',[
            'as' => 'admin.users', 'uses' => 'Admin\UserController@blockedByAdmin'
        ]);
        Route::get('/deactive',[
            'as' => 'admin.users', 'uses' => 'Admin\UserController@deactiveUsers'
        ]);

        Route::get('reports/get',[
            'as' => 'admin.users', 'uses' => 'Admin\SubsriptionsController@usersReports'
        ]);

        Route::get('usersReportsCount/get',[
            'as' => 'admin.users', 'uses' => 'Admin\SubsriptionsController@usersReportsCount'
        ]);
        Route::get('userprescription',[
            'as' => 'admin.users.prescriptions', 'uses' => 'Admin\UserController@getPrescriptions'
        ]);
        Route::post('userprescriptionUpdate/{id}',[
            'as' => 'admin.users.prescriptions', 'uses' => 'Admin\UserController@updatePrescription'
        ]);

      

    });

    Route::group(['prefix' => 'Laboratories'], function (){

        Route::get('/get', [
			'as' => 'admin.Laboratories', 'uses' => 'Admin\LaboratoriesController@allLaboratories',
        ]);
        Route::get('/dropdown/get', [
			'as' => 'admin.Laboratories', 'uses' => 'Admin\LaboratoriesController@allLaboratoriesDropdown',
		]);
        Route::get('/edit/{id}',[
            'as' => 'admin.Laboratories', 'uses' => 'Admin\LaboratoriesController@updateLaboratoriesGet'
        ]);
        Route::get('/labCatEdit/{id}',[
            'as' => 'admin.Laboratories', 'uses' => 'Admin\TestsInLabCategoryController@labCatEdit'
        ]);
        Route::get('/cities',[
            'as' => 'admin.Laboratories', 'uses' => 'Admin\LaboratoriesController@getCities'
        ]);
        Route::post('/add',[
            'as' => 'admin.Laboratories', 'uses' => 'Admin\LaboratoriesController@addLaboratories'
        ]);
        Route::post('/update',[
            'as' => 'admin.Laboratories', 'uses' => 'Admin\LaboratoriesController@updateLaboratories'
        ]);
        Route::delete('/{id}', [
			'as' => 'admin.Laboratories.destroy', 'uses' => 'Admin\LaboratoriesController@destroyLaboratories',
        ]);
        Route::get('pharmacyDropdown/', [
			'as' => 'admin.Laboratories', 'uses' => 'Admin\LaboratoriesController@dropdown',
        ]);
        

    });

    
    Route::group(['prefix' => 'Tests'], function (){

        Route::get('/get', [
			'as' => 'admin.Tests', 'uses' => 'Admin\TestsController@allTests',
        ]);
        Route::get('/count/get', [
			'as' => 'admin.Tests', 'uses' => 'Admin\TestsController@countTests',
        ]);
        Route::get('/dropdown/get/{catID}', [
			'as' => 'admin.Tests', 'uses' => 'Admin\TestsController@allTestsDropdown',
        ]);
        Route::get('/dropdownTests/get/{catID}', [
			'as' => 'admin.Tests', 'uses' => 'Admin\TestsController@dropdownTests',
		]);
        Route::get('/edit/{id}',[
            'as' => 'admin.Tests', 'uses' => 'Admin\TestsController@updateTestsGet'
        ]);
        Route::get('/cities',[
            'as' => 'admin.Tests', 'uses' => 'Admin\TestsController@getCities'
        ]);
        Route::post('/add',[
            'as' => 'admin.Tests', 'uses' => 'Admin\TestsController@addTests'
        ]);
        Route::post('/update',[
            'as' => 'admin.Tests', 'uses' => 'Admin\TestsController@updateTests'
        ]);
        Route::delete('/{id}', [
			'as' => 'admin.Tests.destroy', 'uses' => 'Admin\TestsController@destroyTests',
        ]);
        Route::get('pharmacyDropdown/', [
			'as' => 'admin.Tests', 'uses' => 'Admin\TestsController@dropdown',
        ]);
        Route::post('/cat/update', [
            'as' => 'admin.medicines.add', 'uses' => 'Admin\TestsCategoryController@updateTestCat'
        ]);
        

    });

    Route::group(['prefix' => 'TestsCategory'], function (){

        Route::get('/get', [
			'as' => 'admin.TestsCategory', 'uses' => 'Admin\TestsCategoryController@allCategoryTests',
        ]);
        Route::get('paginate/get', [
			'as' => 'admin.TestsCategory', 'uses' => 'Admin\TestsCategoryController@allCategory',
        ]);
        Route::post('/add', [
			'as' => 'admin.TestsCategory', 'uses' => 'Admin\TestsCategoryController@addCategory',
        ]);

        Route::delete('/{id}', [
			'as' => 'admin.TestsCategory.destroy', 'uses' => 'Admin\TestsCategoryController@destroyTestsCat',
        ]);

    });

    Route::group(['prefix' => 'Services'], function (){

        Route::get('/get', [
			'as' => 'admin.Services', 'uses' => 'Admin\HMServicesController@allServices',
        ]);
        
        Route::get('Dropdown/get', [
			'as' => 'admin.Services', 'uses' => 'Admin\HMServicesController@allServicesDropdown',
        ]);

        Route::delete('/{id}', [
			'as' => 'admin.Services.destroy', 'uses' => 'Admin\HMServicesController@destroy',
        ]);

        Route::post('/add',[
            'as' => 'admin.Services', 'uses' => 'Admin\HMServicesController@addService'
        ]);

        Route::post('/update',[
            'as' => 'admin.Services', 'uses' => 'Admin\HMServicesController@updateService'
        ]);

        Route::get('/edit/{id}',[
            'as' => 'admin.Services', 'uses' => 'Admin\HMServicesController@EditService'
        ]);

    });

    Route::group(['prefix' => 'providers'], function (){

        Route::get('/get', [
			'as' => 'admin.Providers', 'uses' => 'Admin\ServiceProvidersController@allServicesProviders',
        ]);

        Route::get('/count/get', [
			'as' => 'admin.Providers', 'uses' => 'Admin\ServiceProvidersController@countTotal',
        ]);

        Route::get('/dropdownOfProv/get', [
			'as' => 'admin.providers', 'uses' => 'Admin\ServiceProvidersController@providersDropdown',
        ]);

        Route::get('/dropdownOfProv/orders/get', [
			'as' => 'admin.providers', 'uses' => 'Admin\ServiceProvidersController@providersDropdownOrder',
        ]);

        Route::delete('/{id}', [
			'as' => 'admin.Providers.destroy', 'uses' => 'Admin\ServiceProvidersController@destroy',
        ]);

        Route::post('/add',[
            'as' => 'admin.Providers', 'uses' => 'Admin\ServiceProvidersController@addProviders'
        ]);

        Route::post('/update',[
            'as' => 'admin.Providers', 'uses' => 'Admin\ServiceProvidersController@updateproviders'
        ]);

        Route::get('/edit/{id}',[
            'as' => 'admin.Providers', 'uses' => 'Admin\ServiceProvidersController@EditService'
        ]);

        Route::post('/updatepimage/{id}',[
            'as' => 'admin.Providers.update', 'uses' => 'Admin\ServiceProvidersController@iconSet'
        ]);

    });

    Route::group(['prefix' => 'medicineCategory'], function (){

        Route::get('MedicineCategory/', [
			'as' => 'admin.medicineCategory', 'uses' => 'Admin\MedicinesCategoryController@dropdown',
        ]);
        Route::get('MedicineOfCategory/{id}', [
			'as' => 'admin.medicineCategory', 'uses' => 'Admin\MedicinesCategoryController@dropdownSelected',
		]);
        

    });

    Route::group(['prefix' => 'Equipments'], function (){

        Route::get('/get', [
			'as' => 'admin.Equipments', 'uses' => 'Admin\EquipmentsController@allEquipments',
        ]);
        Route::get('/count/get', [
			'as' => 'admin.Equipments', 'uses' => 'Admin\EquipmentsController@countEquipments',
        ]);
        Route::get('/filtered/get', [
			'as' => 'admin.Equipments', 'uses' => 'Admin\EquipmentsController@filteredEquipments',
        ]);
        Route::get('/dropdown/get', [
			'as' => 'admin.Equipments', 'uses' => 'Admin\EquipmentsController@allEquipmentsDropdown',
		]);
        Route::get('/edit/{id}',[
            'as' => 'admin.Equipments', 'uses' => 'Admin\EquipmentsController@updateEquipmentsGet'
        ]);
        Route::post('/updatepimage/{id}',[
            'as' => 'admin.Equipments.update', 'uses' => 'Admin\EquipmentsController@iconSet'
        ]);
        Route::get('/cities',[
            'as' => 'admin.Equipments', 'uses' => 'Admin\EquipmentsController@getCities'
        ]);
        Route::post('/add',[
            'as' => 'admin.Equipments', 'uses' => 'Admin\EquipmentsController@addEquipments'
        ]);
        Route::post('/update',[
            'as' => 'admin.Equipments', 'uses' => 'Admin\EquipmentsController@updateEquipments'
        ]);
        Route::delete('/{id}', [
			'as' => 'admin.Equipments.destroy', 'uses' => 'Admin\EquipmentsController@destroyEquipments',
        ]);
        Route::get('pharmacyDropdown/', [
			'as' => 'admin.Equipments', 'uses' => 'Admin\EquipmentsController@dropdown',
        ]);
        Route::get('/getRentalEquipment', [
			'as' => 'admin.Equipments', 'uses' => 'Admin\EquipmentsController@allRentalEquipments',
        ]);
        Route::post('/rentalEquipmentPriceAdd',[
            'as' => 'admin.Equipments', 'uses' => 'Admin\EquipmentsController@rentalEquipmentPriceAdd'
        ]);
        

    });



    Route::group(['prefix' => 'cities'], function (){

        Route::get('/get',[
            'as' => 'admin.cities', 'uses' => 'Admin\CitiesController@allCities'
        ]);
        Route::get('/edit/{id}',[
            'as' => 'admin.cities.edit', 'uses' => 'Admin\CitiesController@editCity'
        ]);
        
        Route::delete('/{id}',[
            'as' => 'admin.cities.destroy', 'uses' => 'Admin\CitiesController@destroyCity'
        ]);

        Route::put('/{id}',[
            'as' => 'admin.cities.block', 'uses' => 'Admin\CitiesController@block'
        ]);

        Route::post('/update', [
            'as' => 'admin.cities.update', 'uses' => 'Admin\CitiesController@updateCity'
        ]);

        Route::post('/status', [
            'as' => 'admin.cities.update', 'uses' => 'Admin\CitiesController@cityStatus'
        ]);

        Route::post('/add', [
            'as' => 'admin.cities.add', 'uses' => 'Admin\CitiesController@addCity'
        ]);

        Route::get('/get',[
            'as' => 'admin.cities', 'uses' => 'Admin\CitiesController@getCities'
        ]);
        Route::get('/getCitiesToShow',[
            'as' => 'admin.cities', 'uses' => 'Admin\CitiesController@getCitiesToShow'
        ]);

    });

    Route::group(['prefix' => 'UserTestReports'], function (){

        // Route::get('/get',[
        //     'as' => 'admin.UserTestReports', 'uses' => 'Admin\UserTestReportsController@allUserTestReports'
        // ]);
        Route::get('/edit/{id}',[
            'as' => 'admin.UserTestReports.edit', 'uses' => 'Admin\UserTestReportsController@editCity'
        ]);
        
        Route::post('/updatepimage/{id}',[
            'as' => 'admin.UserTestReports.update', 'uses' => 'Admin\UserTestReportsController@iconSet'
        ]);

        Route::put('/{id}',[
            'as' => 'admin.UserTestReports.block', 'uses' => 'Admin\UserTestReportsController@block'
        ]);

        Route::post('/update', [
            'as' => 'admin.UserTestReports.update', 'uses' => 'Admin\UserTestReportsController@updateCity'
        ]);

        Route::post('/add', [
            'as' => 'admin.UserTestReports.add', 'uses' => 'Admin\UserTestReportsController@addCity'
        ]);

        Route::get('/get',[
            'as' => 'admin.UserTestReports', 'uses' => 'Admin\UserTestReportsController@getUserTestReports'
        ]);
        Route::delete('/{id}',[
            'as' => 'admin.report.destroy', 'uses' => 'Admin\UserTestReportsController@destroyReport'
        ]);

    });

    //user complaints
    Route::group(['prefix' => 'UserComplaints'], function (){

        Route::get('/get',[
            'as' => 'admin.UserTestReports', 'uses' => 'Admin\UserComplaintController@allComplaints'
        ]);
        Route::post('/add', [
            'as' => 'admin.UserTestReports.add', 'uses' => 'Admin\UserComplaintController@addComplaint'
        ]);
        Route::get('/edit/{id}',[
            'as' => 'admin.UserTestReports.edit', 'uses' => 'Admin\UserComplaintController@editComplaint'
        ]);
         Route::post('/update', [
                'as' => 'admin.UserTestReports.update', 'uses' => 'Admin\UserComplaintController@updateComplaint'
            ]);
        // Route::post('/updatepimage/{id}',[
        //     'as' => 'admin.UserTestReports.update', 'uses' => 'Admin\UserTestReportsController@iconSet'
        // ]);

        // Route::put('/{id}',[
        //     'as' => 'admin.UserTestReports.block', 'uses' => 'Admin\UserTestReportsController@block'
        // ]);

        // Route::post('/update', [
        //     'as' => 'admin.UserTestReports.update', 'uses' => 'Admin\UserTestReportsController@updateCity'
        // ]);

        

        // Route::get('/get',[
        //     'as' => 'admin.UserTestReports', 'uses' => 'Admin\UserTestReportsController@getUserTestReports'
        // ]);
        // Route::delete('/{id}',[
        //     'as' => 'admin.report.destroy', 'uses' => 'Admin\UserTestReportsController@destroyReport'
        // ]);

    });

//orders
    Route::group(['prefix' => 'orders'], function (){

        Route::get('/get',[
            'as' => 'admin.orders', 'uses' => 'Admin\OrdersController@allorders'
        ]);
        Route::get('/getHighestGrossingProducts',[
            'as' => 'admin.orders', 'uses' => 'Admin\OrdersController@getHighestGrossingProducts'
        ]);
        Route::get('/getHighestGrossingServices',[
            'as' => 'admin.orders', 'uses' => 'Admin\OrdersController@getHighestGrossingServices'
        ]);
        Route::get('/orderInWeek',[
            'as' => 'admin.orders', 'uses' => 'Admin\OrdersController@orderInWeek'
        ]);
        Route::get('/pendingCount/get',[
            'as' => 'admin.orders', 'uses' => 'Admin\OrdersController@pendingCount'
        ]);
        Route::get('/cancelCount/get',[
            'as' => 'admin.orders', 'uses' => 'Admin\OrdersController@cancelCount'
        ]);
        Route::get('/completeCount/get',[
            'as' => 'admin.orders', 'uses' => 'Admin\OrdersController@completeCount'
        ]);
        Route::get('singleOrder/{id}',[
            'as' => 'admin.orders', 'uses' => 'Admin\OrdersController@singleOrder'
        ]);
        Route::get('medicOrder/{id}',[
            'as' => 'admin.orders', 'uses' => 'Admin\OrdersController@medicOrder'
        ]);
        Route::get('equipOrder/{id}',[
            'as' => 'admin.orders', 'uses' => 'Admin\OrdersController@equipOrder'
        ]);
        Route::get('labtestOrder/{id}',[
            'as' => 'admin.orders', 'uses' => 'Admin\OrdersController@labtestOrder'
        ]);
        Route::get('otherMedOrder/{id}',[
            'as' => 'admin.orders', 'uses' => 'Admin\OrdersController@otherMedOrder'
        ]);
        Route::get('/edit/{id}',[
            'as' => 'admin.orders.edit', 'uses' => 'Admin\OrdersController@editCity'
        ]);
        
        Route::post('/updatepimage/{id}',[
            'as' => 'admin.orders.update', 'uses' => 'Admin\OrdersController@iconSet'
        ]);

        Route::put('/{id}',[
            'as' => 'admin.orders.block', 'uses' => 'Admin\OrdersController@block'
        ]);

        Route::post('/update', [
            'as' => 'admin.orders.update', 'uses' => 'Admin\OrdersController@updateCity'
        ]);

        Route::post('/status', [
            'as' => 'admin.orders.update', 'uses' => 'Admin\OrdersController@changeOrderStatus'
        ]);

        Route::post('/add', [
            'as' => 'admin.orders.add', 'uses' => 'Admin\OrdersController@addCity'
        ]);

        Route::get('/inDemandMed/get',[
            'as' => 'admin.orders', 'uses' => 'Admin\LaboratoriesController@inDemandMed'
        ]);
        Route::get('/inDemandEqu/get',[
            'as' => 'admin.orders', 'uses' => 'Admin\LaboratoriesController@inDemandEqu'
        ]);
        Route::get('/inDemandTest/get',[
            'as' => 'admin.orders', 'uses' => 'Admin\LaboratoriesController@inDemandTest'
        ]);
        Route::post('/inDemandRem', [
            'as' => 'admin.orders', 'uses' => 'Admin\LaboratoriesController@inDemandRem'
        ]);

        Route::get('/promotion/get',[
            'as' => 'admin.orders', 'uses' => 'Admin\OrdersController@getPromotion'
        ]);

        Route::post('/promotion/add', [
            'as' => 'admin.orders.update', 'uses' => 'Admin\OrdersController@addPromotion'
        ]);

        Route::post('/promotion/end', [
            'as' => 'admin.orders.update', 'uses' => 'Admin\OrdersController@endPromotion'
        ]);

        Route::get('/serviceOrders/get',[
            'as' => 'admin.orders', 'uses' => 'Admin\OrdersController@serviceOrdersGet'
        ]);

        Route::post('/providerSelected/add', [
            'as' => 'admin.orders.update', 'uses' => 'Admin\OrdersController@providerSelected'
        ]);

        Route::post('/statusChange', [
            'as' => 'admin.orders.update', 'uses' => 'Admin\OrdersController@statusChangeOrder'
        ]);

        Route::post('/inDemandAdd', [
            'as' => 'admin.orders', 'uses' => 'Admin\LaboratoriesController@inDemandAdd'
        ]);

        Route::post('/serviceOrder/add', [
            'as' => 'admin.orders', 'uses' => 'Admin\OrdersController@serviceOrder'
        ]);
        Route::post('/newOrder','Admin\OrdersController@newOrder');

        Route::get('/getRentalEquipmentReport',[
            'as' => 'admin.orders', 'uses' => 'Admin\OrdersController@getRentalEquipmentReport'
        ]);


    });

    // Roles
	Route::group(['prefix' => 'roles'], function () {

		// Roles Crud
		Route::get('/get', [
			'as' => 'admin.roles', 'uses' => 'Admin\RolesController@getRoles',
		]);
		Route::get('/edit/{id}', [
			'as' => 'admin.roles.edit', 'uses' => 'Admin\RolesController@editRoleByID',
		]);

		Route::delete('/{id}', [
			'as' => 'admin.role.destroy', 'uses' => 'Admin\RolesController@deleteRolePageByID',
		]);

		Route::post('/update', [
			'as' => 'admin.role.update', 'uses' => 'Admin\RolesController@updateRole',
		]);

		Route::post('/add', [
			'as' => 'admin.roles.add', 'uses' => 'Admin\RolesController@addNewRole',
		]);

		Route::get('/currentUserRole', [
			'as' => 'admin.roles', 'uses' => 'Admin\RolesController@getCurrentUserRoles',
		]);

        Route::get('/PermissionsList/get', [
			'as' => 'admin.roles', 'uses' => 'Admin\PermissionsController@PermissionsList',
		]);

		// // Get Page by Slug
		// Route::get('/slugGet/get/{testSlug}',[
		//     'as' => 'admin.cms', 'uses' => 'Admin\CmsController@getPageSlug'
		// ]);

	});

    Route::group(['prefix' => 'getimg'], function (){
        Route::get('/get/{id}',[
            'as' => 'admin.getimg', 'uses' => 'Admin\PropertiesController@PropertyImg'
        ]);
    });

    Route::group(['prefix' => 'subscriptions'], function (){

        Route::get('/get',[
            'as' => 'admin.subscriptions', 'uses' => 'Admin\SubsriptionsController@basicSubscriptions'
        ]);
        Route::get('users/get',[
            'as' => 'admin.subscriptions', 'uses' => 'Admin\SubsriptionsController@usersSubscriptions'
        ]);

        
   
        Route::get('basicTotal/get',[
            'as' => 'admin.subscriptions', 'uses' => 'Admin\SubsriptionsController@basicTotal'
        ]);
        Route::get('premiumTotal/get',[
            'as' => 'admin.subscriptions', 'uses' => 'Admin\SubsriptionsController@premiumTotal'
        ]);
        Route::get('premium/get',[
            'as' => 'admin.subscriptions', 'uses' => 'Admin\SubsriptionsController@premiumSubscriptions'
        ]);

        Route::get('features/get',[
            'as' => 'admin.subscriptions', 'uses' => 'Admin\SubsriptionsController@features'
        ]);
       
        Route::post('/updatepimage/{id}',[
            'as' => 'admin.subscriptions.update', 'uses' => 'Admin\SubsriptionsController@iconSet'
        ]);
        // Route::post('/newImage',[
        //     'as' => 'admin.subscriptions.update', 'uses' => 'Admin\SubsriptionsController@newImageSet'
        // ]);
        
        Route::delete('/{id}',[
            'as' => 'admin.subscriptions.destroy', 'uses' => 'Admin\SubsriptionsController@destroyPackageData'
        ]);
        Route::get('/edit/{id}',[
            'as' => 'admin.subscriptions.edit', 'uses' => 'Admin\SubsriptionsController@allPkgs'
        ]);

        Route::post('/update', [
            'as' => 'admin.subscriptions.update', 'uses' => 'Admin\SubsriptionsController@updatePackage'
        ]);

        Route::post('/add', [
            'as' => 'admin.subscriptions.add', 'uses' => 'Admin\SubsriptionsController@addSubsriptions'
        ]);

         Route::get('paymentreport/get',[
            'as' => 'admin.subscriptions.paymentreport', 'uses' => 'Admin\SubsriptionsController@getUserHistory'
        ]);
        Route::get('report/get',[
            'as' => 'admin.subscriptions.paymentreport', 'uses' => 'Admin\SubsriptionsController@getReport'
        ]);

    });
    
    Route::group(['prefix' => 'features'], function (){

        Route::get('/get',[
            'as' => 'admin.features', 'uses' => 'Admin\FeaturesController@getAllFeatures'
        ]);
        Route::get('just/get',[
            'as' => 'admin.features', 'uses' => 'Admin\FeaturesController@getAllFeaturesOnly'
        ]);

        Route::get('/featureslist/{id}',[
            'as' => 'admin.featureslist', 'uses' => 'Admin\FeaturesController@getAllFeaturesUpdated'
        ]);

        Route::get('feature/get',[
            'as' => 'admin.features', 'uses' => 'Admin\FeaturesController@getAllFeaturesChange'
        ]);

        Route::get('/update',[
            'as' => 'admin.features.update', 'uses' => 'Admin\FeaturesController@updateFeaturesChange'
        ]);
        Route::post('/updateDescription',[
            'as' => 'admin.features.update', 'uses' => 'Admin\FeaturesController@updateDescription'
        ]);
        Route::get('/edit/{id}',[
            'as' => 'admin.features.edit', 'uses' => 'Admin\FeaturesController@getThisFeature'
        ]);

    });

    // Cms
    // Route::group(['prefix' => 'cms'], function (){

    //     // CMS Crud
    //     Route::get('/get',[
    //         'as' => 'admin.cms', 'uses' => 'Admin\CmsController@allCmsPages'
    //     ]);
    //     Route::get('/edit/{id}',[
    //         'as' => 'admin.cities.edit', 'uses' => 'Admin\CmsController@editCmsPageByPageID'
    //     ]);
        
    //     Route::delete('/{id}',[
    //         'as' => 'admin.cms.destroy', 'uses' => 'Admin\CmsController@deleteCmsPageByID'
    //     ]);

    //     Route::post('/update', [
    //         'as' => 'admin.cms.update', 'uses' => 'Admin\CmsController@updateCmsPage'
    //     ]);

    //     Route::post('/add', [
    //         'as' => 'admin.cms.add', 'uses' => 'Admin\CmsController@addNewCmsPage'
    //     ]);

    //     // Get Page by Slug
    //     Route::get('/slugGet/get/{testSlug}',[
    //         'as' => 'admin.cms', 'uses' => 'Admin\CmsController@getPageSlug'
    //     ]);

    // });

    Route::group(['prefix' => 'statusupdate'], function (){

        Route::post('update',[
            'as' => 'admin.statusupdate.update', 'uses' => 'Admin\FileController@statusupdate'
        ]);
        
    });

    Route::group(['prefix' => 'adminprofile'], function (){

        Route::post('update',[
            'as' => 'admin.adminprofile.update', 'uses' => 'Admin\UserController@adminprofile'
        ]);
        Route::post('upload_user_profile', 'Admin\UserController@uploadProfilePicture');

        Route::post('resetPass/update',[
            'as' => 'admin.adminprofile.resetPass/update', 'uses' => 'Admin\UserController@resetPassAdmin'
        ]);
        
    });

    Route::group(['prefix' => 'setting'], function (){

        Route::get('/edit',[
            'as' => 'admin.setting.edit', 'uses' => 'Admin\SettingController@socialGet'
        ]);
        Route::post('/update',[
            'as' => 'admin.setting.update', 'uses' => 'Admin\SettingController@updateSocial'
        ]);
        Route::post('/ranking',[
            'as' => 'admin.setting.update', 'uses' => 'Admin\SettingController@updateRankingMinutes'
        ]);
        Route::get('/rankingGet',[
            'as' => 'admin.setting', 'uses' => 'Admin\SettingController@rankingGet'
        ]);
        
    });

    //website blogs apis

    Route::group(['prefix' => 'blogs'], function() {
      Route::post('/add', ['uses' => 'Web\SiteBlogsController@addNewBlog'
      ]);

      Route::post('/addBlogImage/{id}', ['uses' => 'Web\SiteBlogsController@addBlogImage'
      ]);

      Route::get('/getBlogs', ['uses' => 'Web\SiteBlogsController@getBlogs']);
      Route::get('/editBlog/{id}', ['uses' => 'Web\SiteBlogsController@editBlog']);
      Route::get('/filterBlog', ['uses' => 'Web\SiteBlogsController@filterBlog']);
      Route::put('/updateBlog/{id}', ['uses' => 'Web\SiteBlogsController@updateBlog']);
      Route::delete('/deleteBlog/{id}', ['uses' => 'Web\SiteBlogsController@deleteBlog']);
    });
    
    // emails

    Route::group(['prefix' => 'contact'], function() {
      Route::get('/allContact', ['uses' => 'Web\ContactusController@allContactInfo']);

      Route::put('/changeStatus/{id}', ['uses' => 'Web\ContactusController@changeStatus']);
    });
});

Route::get('delete/{id}', [
	'as' => 'admin.subscriptions.destroy', 'uses' => 'Admin\SubsriptionsController@destroyPkg',
]);

// get active blogs on website without auth

Route::get('/allBlogs', ['uses' => 'Web\SiteBlogsController@allBlogs']);
Route::get('/showBlog/{id}', ['uses' => 'Web\SiteBlogsController@showBlog']);

// contact us api

Route::post('/formSubmit', ['uses' => 'Web\ContactusController@ContactForm']);
// Route::get('/allContact', ['uses' => 'Web\ContactusController@allContactInfo']);
// Route::put('/changeStatus/{id}', ['uses' => 'Web\ContactusController@changeStatus']);

//Cities API for website
// Route::get('/allCities', ['uses' => 'Admin\CitiesController@allCities']);
