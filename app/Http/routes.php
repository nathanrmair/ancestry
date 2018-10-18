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

Route::get('/', 'ApplicationController@getHome');
Route::get('/home', 'ApplicationController@getHome');

//Privacy policy route
Route::get('privacy_policy', 'ApplicationController@getPrivacyPolicy');



//Cookies
Route::get('/cookiesPolicy','ApplicationController@getCookies');

// About page
Route::get('/about','ApplicationController@getAbout');

// Authentication routes...
Route::auth();
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
//Limited Visitors route
Route::get('limited_users', 'Auth\AuthController@limitedUsers');

//Messages routes
Route::get('/profile/dashboard/messages', 'MessagesController@showSummaryOfMessages');
Route::get('/conversation/get', 'MessagesController@getConversation');
Route::post('/messages/new', 'MessagesController@createNewMessage');
Route::post('/messages/conversation/new', 'MessagesController@createNewConversation');
Route::get('/messages/checkForNew', 'MessagesController@checkForNew');
Route::get('/messages/conversation/{id}/isUnread', 'MessagesController@checkForUnreadConversation');
Route::get('/userType','MessagesController@userType');

// Message Search Offers
Route::post('/messages/offerASearch', 'MessagesController@offerASearch');
Route::get('/messages/getOfferedSearches', 'MessagesController@getOfferedSearches');
Route::get('/messages/acceptSearchOffer', 'MessagesController@acceptSearchOffer');
Route::get('/messages/declineSearchOffer', 'MessagesController@declineSearchOffer');
Route::get('/messages/cancelSearchOffer', 'MessagesController@cancelSearchOffer');

//NewsLetter routes
Route::post('/newsletter/signup', 'NewsletterController@registerNewEmail');

// Message Attachments routes
Route::get('fileentry/get/{filename}/{id}','FileEntryController@getBase64');

//Searching routes
Route::get('/search', 'SearchController@show');
Route::get('/search/query', 'SearchController@search');
Route::get('/search/map', 'SearchController@searchMap');
Route::get('/search/isLogged', 'SearchController@isLogged');

//Profile searches status route

Route::get('/profile/searches','SearchesStatusController@show');
Route::get('/profile/searches/{search_id}','SearchesStatusController@showASearch');
Route::get('/profile/searches/complete/{search_id}','SearchesStatusController@completeASearch');
Route::post('/profile/searches/complete/{search_id}','SearchesStatusController@sendCompleteSearch');


//Profile credits routes
Route::get('/profile/credits', 'CreditsController@show');
Route::post('profile/buycredits', 'CreditsController@buyCredits');
Route::post('profile/withdrawcredits', 'CreditsController@withdrawCredits');

//Profile membership routes...
Route::get('/profile/membership','MembershipController@show');
Route::get('/profile/upgrade','MembershipController@upgrade');

//Dashboard related routes...
Route::get('/profile/dashboard','DashboardController@dashboardPage');

//Provider utilities routes...
Route::get('/visitor_overview/{user_id}','ProviderUtilitiesController@visitorById');
Route::get('/profile/mygallery', 'ProvidersImagesController@getProvidersImagesView');
Route::get('/profile/mygallery/delete/{image_id}', 'ProvidersImagesController@deleteImage');
Route::post('/profile/mygallery/add', 'ProvidersImagesController@addMoreImages');

//Visitor utilities routes...
Route::get('/provider_overview/{user_id}', [
    'as' => 'provider_overview',
    'uses' => 'VisitorUtilitiesController@providerById'
]);

//Profile editing routes...
Route::get('/profile/edit','ProfileController@editProfile');
Route::post('/profile/submit','ProfileController@editProfileSubmit');



// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// Provider_reg routes...
Route::get('/provider_reg', 'ProvidersRegController@show');
Route::post('/sendforapproval', 'ProvidersRegController@postSendforapproval');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// ==================== ADMIN ROUTES =========================
//user controller routes
Route::get('admin/adminMain', 'Admin\UsersController@adminMain');
Route::get('admin/users', 'Admin\UsersController@index');
Route::get('admin/users/searchUsers', 'Admin\UsersController@search');
Route::post('admin/users/searchByName', 'Admin\UsersController@searchByName');
Route::post('admin/users/searchByEmail', 'Admin\UsersController@searchByEmail');
Route::post('admin/users/searchByType', 'Admin\UsersController@searchByType');
Route::post('admin/users/delete', 'Admin\UsersController@deleteUser');

//reports controller routes
Route::get('admin/reportsOverview', 'Admin\ReportsController@showReports');
Route::get('admin/reportsOverview/{name}','Admin\ReportsController@getIndividualMessageStats');
Route::get('admin/providerSummary/{userId}', 'Admin\ReportsController@providerSummary');
Route::get('admin/visitorSummary/{userId}', 'Admin\ReportsController@visitorSummary');
Route::get('admin/queries-report', 'Admin\ReportsController@queriesReport');
//Admin approving route...
Route::get('admin/approveProviders','ApproveController@show');
Route::get('admin/decline/{pending_id}','ApproveController@decline');
Route::get('admin/approve/{pending_id}','ApproveController@approve');


Route::get('admin/emailProvider/{userId}', 'Admin\EmailController@getSendEmailToProviderView');
Route::post('admin/emailProvider/send', 'Admin\EmailController@sendEmailToProvider');
Route::get('admin/email-all-providers', 'Admin\EmailController@getEmailAllProviders');
Route::post('admin/email-all-providers/send', 'Admin\EmailController@emailAllProviders');
Route::get('admin/email-all-visitors', 'Admin\EmailController@getEmailAllVisitors');
Route::post('admin/email-all-visitors/send', 'Admin\EmailController@emailAllVisitors');
Route::get('admin/send-newsletter', 'Admin\EmailController@getSendNewsletter');
Route::post('admin/send-newsletter/send', 'Admin\EmailController@sendNewsletter');

//reports
Route::get('admin/reports/providers','Admin\ReportsController@getProviderReports');
Route::get('admin/reports/provider/{user_id}',[
    'uses' => 'Admin\ReportsController@getProviderReport',
    'as' => 'admin/reports/provider']);
Route::get('admin/reports/provider_stats/{user_id}',[
    'uses' => 'Admin\ReportsController@getStats',
    'as' => 'admin/reports/provider_stats']);

//======================= END ADMIN ROUTES ============================
// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

Route::get('register/verify/{confirmationCode}', [
    'as' => 'confirmation_path',
    'uses' => 'Auth\AuthController@confirm'
]);

//Ancestor routes...
Route::get('ancestor/create/',[
    'as' => 'ancestor/create',
    'uses' => 'AncestorController@createAncestorPage'
])->middleware(['auth','isVisitor']);

Route::post('ancestor/create/','AncestorController@editAncestor');

Route::get('ancestor/edit/{ancestorId}',[
    'as' => 'ancestor/create',
    'uses' => 'AncestorController@editAncestorPage'
]);

Route::post('ancestor/edit/','AncestorController@editAncestor');
Route::get('ancestors','AncestorController@ancestors');
Route::post('ancestor/delete/','AncestorController@deleteAncestor');



//FAQ routes 
Route::get('/FAQs','faqsController@faqsPage');

//admin only
Route::get('admin/FAQs/edit/{question_id}','faqsController@edit');
Route::get('admin/FAQs/create','faqsController@edit');
Route::post('admin/FAQs/edit','faqsController@submit');
Route::get('admin/FAQs/delete/{question_id}','faqsController@delete');

//Report routes
Route::get('reports/user',[
    'uses' => 'Reports\UserReportsController@getReports',
    'as' => 'reports/user']);
Route::get('reports/get/{report_id}',[
    'uses' => 'Reports\UserReportsController@getReport',
    'as' => 'reports/get']);
Route::get('reports/pdf/{report_id}',[
    'uses' => 'Reports\UserReportsController@getReportPDF',
    'as' => 'reports/pdf']);
Route::get('reports/stats/{user_id?}',[
    'uses' => 'Reports\UserReportsController@getStats',
    'as' => 'reports/stats']);

Route::get('csv', 'ApplicationController@loadCsv')->middleware('admin');

//Route::get('reports/gen','Reports\ProviderReportsController@generateReports');

// Route that unsubscribes and subscribes all newsletter subscribed people

Route::get('unsubscribeAll','Admin\EmailController@unsubscribeAll');

Route::get('subscribeAll','Admin\EmailController@subscribeAll');