<?php

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

Route::get('/', function () {
    return redirect('login');
});

//login
Route::get('login', 'AdminLoginController@get_login')->name('login')->middleware('logged.in.cek');
Route::post('post-login', 'AdminLoginController@postLogin')->name('postLogin');
Route::post('gen-password', 'AdminLoginController@genPassword')->name('genPassword');
Route::get('logout', 'AdminLoginController@logout')->name('logout');

Route::middleware('access_permission')->group(function(){
	//dashboard
	Route::get('dashboard', 'DashboardController@getDashboard')->name('dashboard');

	//project
	Route::get('admin/project/','AdminProjectController@getProjectManagement')->name('getProjectManagement');
	// Route::get('admin/project/',function ()
	// {
	// 	dd("ok");
	// })->name('getProjectManagement');
	Route::get('admin/project/edit/{id}','AdminProjectController@getEditProject')->name('getEditProject');
	Route::post('admin/project/add/save/','AdminProjectController@saveAddProject')->name('saveAddProject');
	Route::post('admin/project/edit/save/','AdminProjectController@editProject')->name('editProject');
	Route::get('ajax-edit-project','AjaxController@ajaxEditProject')->name('ajaxEditProject');
	Route::get('admin/project/delete/{id}','AdminProjectController@deleteProject')->name('deleteProject');

	//ticket
	Route::get('admin/ticket/','AdminTicketController@getTicketManagement')->name('getTicketManagement');
	Route::get('admin/ticket/edit/{id}','AdminTicketController@getEditTicket')->name('getEditTicket');
	Route::post('admin/ticket/add/save/','AdminTicketController@saveAddTicket')->name('saveAddTicket');
	Route::post('admin/ticket/edit/save/','AdminTicketController@editTicket')->name('editTicket');
	Route::get('ajax-edit-ticket','AjaxController@ajaxEditTicket')->name('ajaxEditTicket');
	Route::get('admin/ticket/delete/{id}','AdminTicketController@deleteTicket')->name('deleteTicket');
	Route::get('ajax-new-bug','AjaxController@ajaxGetNewBug')->name('ajaxGetNewBug');
	Route::get('ajax-edit-new-bug','AjaxController@ajaxGetEditNewBug')->name('ajaxGetEditNewBug');
	Route::get('ajax-hapus-bug','AjaxController@ajaxHapusBug')->name('ajaxHapusBug');

	//penawaran
	Route::get('admin/penawaran/', 'AdminTransactionsController@getPenawaran')->name('getPenawaran');
	Route::get('admin/penawaran/add', 'AdminTransactionsController@addPenawaran')->name('addPenawaran');
	Route::get('admin/penawaran/save', 'AdminTransactionsController@savePenawaran')->name('savePenawaran');
	Route::get('admin/penawaran/edit/save', 'AdminTransactionsController@saveEditPenawaran')->name('saveEditPenawaran');
	Route::get('admin/penawaran/edit/{id}','AdminTransactionsController@editPenawaran')->name('editPenawaran');
	Route::get('admin/penawaran/view/{id}','AdminTransactionsController@viewPenawaran')->name('viewPenawaran');
	Route::get('admin/penawaran/delete/{id}','AdminTransactionsController@deletePenawaran')->name('deletePenawaran');
	Route::get('admin/penawaran/print/{id}','AdminTransactionsController@printPenawaran')->name('printPenawaran');

	//Purchase Order
	Route::get('admin/po/', 'AdminTOrderController@getPO')->name('getPO');
	Route::get('admin/po/save', 'AdminTransactionsController@saveOrder')->name('saveOrder');
	Route::get('admin/po/edit/save', 'AdminTransactionsController@saveEditOrder')->name('saveEditOrder');
	Route::get('admin/po/delete_po/{id}','AdminTOrderController@deleteOrder')->name('deleteOrder');
	Route::get('export-excel-po-tanggal','AdminTOrderController@exportExcelPOTanggal')->name('exportExcelPOTanggal');
	Route::get('export-excel-po','AdminTOrderController@exportExcelPO')->name('exportExcelPO');

	//profile
	Route::get('admin/master/user/profile','AdminUsersCompanyController@getProfile')->name('getProfile');
	Route::post('admin/master/user/edit/save/','AdminUsersCompanyController@saveEditUser')->name('saveEditUser');
	Route::post('admin/users_company/user/edit/save/','AdminUsersCompanyController@saveEditUser')->name('saveEditUser');

	//customer_management
	Route::post('user/company/update','AdminTransactionsController@updateCompany')->name('updateCompany');
	Route::get('admin/customer_management/','AdminUsersCompanyController@getCustomerManagement')->name('getCustomerManagement');
	Route::post('admin/customer_management/add_customer/save/','AdminUsersCompanyController@saveAddCustomer')->name('saveAddCustomer');
	Route::get('admin/customer_management/edit_customer/{id}','AdminUsersCompanyController@getEditCustomer')->name('getEditCustomer');
	Route::get('admin/customer_management/view_customer/{id}','AdminUsersCompanyController@getViewCustomer')->name('getViewCustomer');
	Route::get('admin/customer_management/approve/{id}','AdminUsersCompanyController@approveCustomer')->name('approveCustomer');
	Route::post('admin/customer_management/edit_customer/save/','AdminUsersCompanyController@editCustomer')->name('editCustomer');
	Route::get('admin/customer_management/delete_customer/{id}','AdminUsersCompanyController@deleteCustomer')->name('deleteCustomer');
	Route::get('admin/customer_management/disactive_customer/{id}','AdminUsersCompanyController@disactiveCustomer')->name('disactiveCustomer');
	Route::get('admin/customer_management/activate_customer/{id}','AdminUsersCompanyController@activateCustomer')->name('activateCustomer');
	Route::get('admin/customer_management/add_customer','AdminUsersCompanyController@getAddCustomer')->name('getAddCustomer');
	Route::get('export-excel-customer-tanggal','AdminUsersCompanyController@exportExcelCustomerTanggal')->name('exportExcelCustomerTanggal');
	Route::get('export-excel-customer','AdminUsersCompanyController@exportExcelCustomer')->name('exportExcelCustomer');

	//transaction
	Route::get('admin/transaction/','AdminTransactionsController@getTransaction')->name('getTransaction');

	//invoice
	Route::get('admin/invoice/','AdminInvoiceController@getInvoice')->name('getInvoice');
	Route::get('admin/invoice/add/{id}','AdminInvoiceController@createInvoice')->name('createInvoice');
	Route::get('admin/invoice/paid/{id}','AdminInvoiceController@paidInvoice')->name('paidInvoice');
	Route::get('admin/invoice/unpaid/{id}','AdminInvoiceController@unpaidInvoice')->name('unpaidInvoice');
	Route::post('admin/invoice/save', 'AdminInvoiceController@saveInvoice')->name('saveInvoice');
	Route::post('admin/invoice/pay', 'AdminInvoiceController@payInvoice')->name('payInvoice');
	Route::post('admin/invoice/edit/save', 'AdminInvoiceController@saveEditInvoice')->name('saveEditInvoice');
	Route::get('admin/invoice/delete/{id}','AdminInvoiceController@deleteInvoice')->name('deleteInvoice');
	Route::get('print_invoice', ['uses' => 'AdminInvoiceController@printInvoice']);
	Route::get('admin/invoice/print/{id}', ['uses' => 'AdminInvoiceController@printInvoiceID']);

	Route::middleware('cek_akses_admin')->group(function(){
	//user
	Route::get('admin/master/user/delete/{id}','AdminUsersCompanyController@deleteUser')->name('deleteUser');
	Route::get('admin/master/user/','AdminUsersCompanyController@getUserManagement')->name('getUserManagement');
	Route::get('admin/master/user/edit/{id}','AdminUsersCompanyController@getEditUser')->name('getEditUser');
	Route::post('admin/master/user/add/save/','AdminUsersCompanyController@saveAddUser')->name('saveAddUser');
	Route::get('admin/master/user/approve_user/{id}','AdminUsersCompanyController@approveUser')->name('approveUser');
	Route::post('admin/master/user/edit/save/','AdminUsersCompanyController@editUser')->name('editUser');
	Route::get('admin/master/user/disactive/{id}','AdminUsersCompanyController@disactiveUser')->name('disactiveUser');
	Route::get('admin/master/user/activate/{id}','AdminUsersCompanyController@activateUser')->name('activateUser');

	//vehicle
	Route::get('admin/master/vehicle/','AdminMasterController@getVehicle')->name('getVehicle');
	Route::get('admin/master/vehicle/add/','AdminMasterController@getAddVehicle')->name('getAddVehicle');
	Route::get('admin/master/vehicle/delete/{id}','AdminMasterController@deleteVehicle')->name('deleteVehicle');
	Route::get('admin/master/vehicle/edit/{id}','AdminMasterController@getEditVehicle')->name('getEditVehicle');
	Route::post('admin/master/vehicle/edit/save/','AdminMasterController@saveEditVehicle')->name('saveEditVehicle');
	Route::post('admin/master/vehicle/add/save/','AdminMasterController@saveAddVehicle')->name('saveAddVehicle');

	//pembayaran
	Route::get('admin/master/pembayaran/','AdminMasterController@getPembayaran')->name('getPembayaran');
	Route::get('admin/master/pembayaran/add/','AdminMasterController@getAddPembayaran')->name('getAddPembayaran');
	Route::get('admin/master/pembayaran/delete/{id}','AdminMasterController@deletePembayaran')->name('deletePembayaran');
	Route::get('admin/master/pembayaran/edit/{id}','AdminMasterController@getEditPembayaran')->name('getEditPembayaran');
	Route::post('admin/master/pembayaran/edit/save/','AdminMasterController@saveEditPembayaran')->name('saveEditPembayaran');
	Route::post('admin/master/pembayaran/add/save/','AdminMasterController@saveAddPembayaran')->name('saveAddPembayaran');
	//advance
	Route::get('admin/master/advance/','AdminTransactionsController@getAdvance')->name('getAdvance');
	Route::get('transactions/advance/update','AdminTransactionsController@updateAdvance')->name('updateAdvance');

	});
	//user-profile
	Route::get('user-profil','UserProfileController@user_profil')->name('user_profil');
	Route::post('save-profil','UserProfileController@save_profile')->name('save_profile');

	//ajax
	Route::get('ajax-city', 'AjaxController@ajaxCity')->name('ajaxCity');

	Route::get('ajax-customera', 'AjaxController@ajaxCustomera')->name('ajaxCustomera');

	Route::get('ajax-customer','AjaxController@ajaxCustomer')->name('ajaxCustomer');
	Route::get('ajax-penawaran','AjaxController@ajaxPenawaran')->name('ajaxPenawaran');
	Route::get('ajax-ref-pay','AjaxController@ajaxRefPay')->name('ajaxRefPay');
	Route::get('ajax-inv','AjaxController@ajaxInvoice')->name('ajaxInvoice');
	Route::get('ajax-edit-inv','AjaxController@ajaxEditInvoice')->name('ajaxEditInvoice');
	Route::get('ajax-edit-po','AjaxController@ajaxEditPO')->name('ajaxEditPO');
	Route::get('ajax-add-po','AjaxController@ajaxAddPO')->name('ajaxAddPO');
	Route::get('ajax-add-inv','AjaxController@ajaxAddInvoice')->name('ajaxAddInvoice');
	Route::get('ajax-edit-customer','AjaxController@ajaxEditCustomer')->name('ajaxEditCustomer');
	Route::get('ajax-edit-penawaran','AjaxController@ajaxEditPenawaran')->name('ajaxEditPenawaran');
	Route::get('ajax-edit-user','AjaxController@ajaxEditUser')->name('ajaxEditUser');
	Route::get('ajax-edit-kapal','AjaxController@ajaxEditKapal')->name('ajaxEditKapal');
	Route::get('ajax-edit-vehicle','AjaxController@ajaxEditVehicle')->name('ajaxEditVehicle');
	Route::get('ajax-t-vehicle','AjaxController@ajaxTVehicle')->name('ajaxTVehicle');
	Route::get('ajax-edit-t-vehicle','AjaxController@ajaxEditTVehicle')->name('ajaxEditTVehicle');
	Route::get('ajax-new-lokasi','AjaxController@ajaxGetNewLokasi')->name('ajaxGetNewLokasi');
	Route::get('ajax-edit-new-lokasi','AjaxController@ajaxGetEditNewLokasi')->name('ajaxGetEditNewLokasi');
	Route::get('ajax-hapus-lokasi','AjaxController@ajaxHapusLokasi')->name('ajaxHapusLokasi');
	Route::get('ajax-company', 'AjaxController@ajaxCompany')->name('ajaxCompany');
	Route::get('ajax-company-new','AjaxController@ajaxCompanyNew')->name('ajaxCompanyNew');
	Route::get('ajax-post', 'AjaxController@ajaxPost')->name('ajaxPost');
	Route::get('ajax-post-edit', 'AjaxController@ajaxPostEdit')->name('ajaxPostEdit');
});
Route::get('chart_order', 'AjaxController@chartOrder')->name('chartOrder');