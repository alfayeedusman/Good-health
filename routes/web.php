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
Route::prefix('/')->group(function() {
	Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
	Route::post('register', 'Auth\RegisterController@register')->name('register.submit');
	Route::get('register/verify/{id}', 'Auth\RegisterController@verifyRegistration')->name('verify');
	Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
	Route::post('logout', 'Auth\LoginController@getLogout')->name('logout');
	Route::get('logout', 'Auth\LoginController@getLogout')->name('logout');
    Route::post('login', 'Auth\LoginController@postLogin')->name('login.submit');
    Route::get('/', function () {
          return view('index');
    });
	Route::get('/generate-epins', function () {
      //generateEpins();
    });
	
    //Auth::routes();
	// Route::get('/home', function () {
        // return view('layouts.member.index');
    // });
	Route::get('/dashboard', 'MemberController@index')->name('dashboard');
	Route::get('/profile', 'MemberController@profile')->name('profile');
	Route::post('/profile', 'MemberController@postProfile')->name('profile.submit');
	Route::get('/security', 'MemberController@security')->name('security');
	Route::post('/security', 'MemberController@postSecurity')->name('security.submit');
	Route::get('/security-pin', 'MemberController@security')->name('security');
	Route::post('/security-pin', 'MemberController@postSecurityPin')->name('security-pin.submit');
	Route::get('/accounts', 'MemberController@accounts')->name('accounts');
	Route::post('/accounts', 'MemberController@postAddAccountAccounts')->name('add-accounts.submit');
	Route::get('/activation-codes', 'MemberController@activationCodes')->name('activation-codes');
	Route::post('/activation-codes', 'MemberController@postActivationCodes')->name('activation-codes.submit');
	//Route::get('/referrals', 'MemberController@referrals')->name('referrals');
	Route::get('/genealogy', 'MemberController@genealogy')->name('genealogy');
	Route::get('/encashments', 'MemberController@encashments')->name('encashments');
	Route::post('/encashments', 'MemberController@postEncashments')->name('encashments.submit');
	//Route::get('/save-mop', 'MemberController@encashments')->name('save.mop');
	//Route::post('/save-mop', 'MemberController@postSaveMop')->name('save.mop.submit');

	//Route::post('/profile/set-greetings', 'MemberController@postSaveRefferalGreetings')->name('save.profile.referral-greetings');
	//Route::get('/move-to-wallet/{id}/{id2}', 'MemberController@moveToWallet')->name('move.to.wallet');
	

	//Route::get('/activation-codes', 'MemberController@activationCodes')->name('activation-codes');
	//Route::post('/activation-codes', 'MemberController@postActivationCodes')->name('activation-codes.submit');
	//Route::get('/money-back/claim/{id}', 'MemberController@claimMoneyBack')->name('claim.money.back');
	
	Route::get('/accounts-register', 'MemberController@accountsRegister')->name('accountsRegister');
	Route::post('/accounts-register', 'MemberController@postAddRegisterAccounts')->name('add-register-accounts.submit');

	Route::get('/unilevel', 'MemberController@unilevel')->name('unilevel');
	Route::post('/unilevel', 'MemberController@postUnilevel')->name('unilevel.submit');

	Route::get('/unilevel-claim', 'MemberController@unilevelClaim')->name('unilevel-claim');
	
	Route::get('/encashments/gc', 'MemberController@encashmentsGC')->name('encashmentsGC');
	Route::post('/encashments/gc', 'MemberController@postEncashmentsGC')->name('encashmentsGC.submit');
});

Route::prefix('/admin')->group(function() {

	Route::get('/dashboard', 'AdminController@index')->name('admin.dashboard');
	Route::get('/members', 'AdminController@members')->name('admin.members');
	Route::get('/members/{id}', 'AdminController@membersInfo')->name('admin.members.info');
	Route::post('/members/{id}', 'AdminController@postProfile')->name('admin.profile.submit');
	Route::post('/members-security/{id}', 'AdminController@postSecurity')->name('admin.security.submit');
	Route::post('/members-security-pin/{id}', 'AdminController@postSecurityPin')->name('admin.security-pin.submit');
	Route::post('/members-status/{id}', 'AdminController@postProfileStatus')->name('admin.profile-status.submit');
	Route::get('/activation-codes', 'AdminController@activationCodes')->name('admin.activation.codes');
	Route::post('/activation-codes', 'AdminController@postActivationCodes')->name('admin.activation.codes.submit');
	//Route::get('/activation-codes/retrieve/{id}', 'AdminController@activationCodesRetrieve')->name('admin.activation.codes.retrieve');
	//Route::get('/activation-codes/retrieve-all/{id}', 'AdminController@activationCodesRetrieveAll')->name('admin.activation.codes.retrieve.all');


	Route::get('/transfer-codes', 'AdminController@transferCodes')->name('admin.transfer.codes');
	Route::post('/transfer-codes', 'AdminController@postTransferCodes')->name('admin.transfer.codes.submit');
	Route::get('/accounts', 'AdminController@accounts')->name('admin.accounts');
	Route::post('/accounts', 'AdminController@postAccounts')->name('admin.accounts.submmit');
	Route::get('/genealogy', 'AdminController@genealogy')->name('admin.genealogy');

	Route::get('/encashments', 'AdminController@encashments')->name('admin.encashments');
	Route::get('/encashments/{id}/{status}', 'AdminController@encashmentsStatus')->name('admin.encashments.status');

	Route::get('/encashmentsGc', 'AdminController@encashmentsGc')->name('admin.encashmentsgc');
	Route::get('/encashmentsGc/{id}/{status}', 'AdminController@encashmentsStatusGc')->name('admin.encashmentsgc.status');

	Route::get('/settings', 'AdminController@settings')->name('admin.settings');
	Route::post('/settings', 'AdminController@postSettings')->name('admin.settings.submit');


	Route::get('/admin-users', 'AdminController@adminUsers')->name('admin.admin.users');
	Route::post('/admin-users', 'AdminController@adminUsersSubmit')->name('admin.admin.users.submit');

	//Route::get('/bonus-income', 'AdminController@bonusIncome')->name('admin.bonus.income');
	//Route::post('/bonus-income', 'AdminController@postBonusIncome')->name('admin.post.bonus.income');
	
	//Route::get('/bonus-income-product-pool', 'AdminController@bonusIncome')->name('admin.bonus.income');
	//Route::post('/bonus-income-product-pool', 'AdminController@postBonusIncomeProductPool')->name('admin.post.bonus.income.product.pool');
	

	Route::get('/unilevel-codes', 'AdminController@unilevelCodes')->name('admin.unilevel.codes');
	Route::post('/unilevel-codes', 'AdminController@postUnilevelCodes')->name('admin.unilevel.codes.submit');
});


Route::prefix('/shop')->group(function() {

	//Route::get('/', 'ShopController@home')->name('shop.home');

});

