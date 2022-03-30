<?php

use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\UserDebugController;
use App\Http\Controllers\auth\AdminAuthController;
use App\Http\Controllers\auth\AdminResetPassword;
use App\Http\Controllers\auth\EmailVerificationController;
use App\Http\Controllers\auth\ResetEmojiImagePasswordController;
use App\Http\Controllers\auth\ResetPasswordController;
use App\Http\Controllers\auth\SecurityCheckControlller;
use App\Http\Controllers\auth\UserCustomAuth;
use App\Http\Controllers\auth\VerifyOTPController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserDashboard\DashboardController;
use App\Http\Controllers\UserDashboard\FilesController;
use App\Http\Controllers\UserDashboard\FolderController;
use App\Http\Controllers\UserDashboard\ProfileSettingController;
use App\Http\Controllers\UserDashboard\ShareFileController;
use App\Models\Admin;
use App\Models\Questions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

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

Route::fallback(function () {
    return view('errors.404');
});

// Auth::routes(['verify' => true]);



Route::get('/', function () {

    if (Auth::check()) {
        return redirect('dashboard');
    }
    return view('user-views.home');
})->name('home');

Route::post('/user/login-process', [UserCustomAuth::class, 'userLoginProcess']);

Route::get('security-image-check', [SecurityCheckControlller::class, 'imageSecurityCheck'])->middleware('preauth');
Route::get('security-image/{image}', [SecurityCheckControlller::class, 'getSecurityImage'])->middleware('preauth');;
Route::post('verify-security-image', [SecurityCheckControlller::class, 'verifyUserImagePassword'])->middleware('preauth');
Route::get('security-emoji-check', [SecurityCheckControlller::class, 'emojiSecuirityCheck'])->middleware('preauth');
Route::post('verify-security-emoji', [SecurityCheckControlller::class, 'verifyUserEmojiPassword'])->middleware('preauth');

/**
 * user registration routes
 */

Route::get('/registration', [UserCustomAuth::class, 'registrationView']);
Route::post('/user/registration-process', [UserCustomAuth::class, 'registrationProcess']);
Route::get('/user/{uuid}/choose-secuirity-questions', [UserCustomAuth::class, 'secuirityQuestionView']);

/**
 * check unique user email
 * check  unique user phone
 */
Route::post('/user/check-email', [UserCustomAuth::class, 'checkUserEmail']);
Route::post('/user/check-phone', [UserCustomAuth::class, 'checkUserPhone']);

//logout route
Route::get('/logout', [UserCustomAuth::class, 'userLogOut'])->middleware('auth');

/**
 * User email verification
 * without verify the user can't access the dashboard
 */

Route::get('/email/verify', [EmailVerificationController::class, 'verificationNotice'])->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verificationVerify'])->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationController::class, 'verificationNotification'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');

//user dashboard route
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('user.dashboard');
Route::post('get-user-folders', [FolderController::class, 'getUserFolders'])->middleware('auth');




//folders route
Route::get('folders', [FolderController::class, 'index'])->middleware(['auth', 'verified']);
Route::get('folders/{uuid}', [FolderController::class, 'folderFiles'])->middleware(['auth', 'verified']);
Route::post('create-folder', [FolderController::class, 'makeFolder'])->middleware('auth');
Route::post('folders/update', [FilesController::class, 'editFolder'])->middleware('auth');
Route::delete('folders/delete', [FolderController::class, 'deleteFolder'])->middleware('auth');

//profile settings
Route::get('settings', [ProfileSettingController::class, 'index'])->middleware(['auth', 'verified']);
Route::get('user/avatar/{image}', [ProfileSettingController::class, 'getUserAvatar'])->middleware('auth');;


/**
 * Update user personal information like FirstName and LastName
 * Update user security questions answer
 * Update user profile avatar picture
 */

Route::post('user/update/personal-info', [ProfileSettingController::class, 'updateUserPersonalInfo'])->middleware(['auth', 'verified'])->name('user.update.information.submit');
Route::post('user/update/security-question', [ProfileSettingController::class, 'updateSecurityQuestionAnswer'])->middleware(['auth', 'verified'])->name('user.update.question.submit');
Route::post('user/update/avatar', [ProfileSettingController::class, 'updateAvatar'])->middleware(['auth', 'verified'])->name('user.update.avatar.submit');


//files route
Route::post('files/uplaod-file', [FilesController::class, 'uploadFiles'])->middleware('auth');
Route::post('file/update-file', [FilesController::class, 'editFiles'])->middleware('auth');
Route::delete('files/delete-file', [FilesController::class, 'deleteFile'])->middleware('auth');
Route::get('file/download/{uuid}', [FilesController::class, 'downloadFile'])->middleware('auth');


//share file 
Route::post('file/share', [ShareFileController::class, 'shareFile'])->middleware('auth');
Route::get('shared-files', [ShareFileController::class, 'getSharedWithUserFiles'])->middleware(['auth', 'verified']);

//reset password
Route::get('forgot-password', [ResetPasswordController::class, 'index'])->middleware('guest');

Route::post('forgot-password', [ResetPasswordController::class, 'getPasswordResetLink'])->middleware('guest');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'resetViewPage'])->middleware('guest')->name('password.reset');

Route::post('reset-password', [ResetPasswordController::class, 'resetUserPassord'])->middleware('guest');

Route::get('check-secuirty-questions', [ResetPasswordController::class, 'checkSecuirityQuestion'])->middleware('guest');

Route::get('file-size', [DashboardController::class, 'calculateTotalMemory'])->middleware('auth');


/**
 * Reset user emoji password
 * Reset user image password
 */

Route::get('reset/{option}/{id}/{token}/{uuid}', [ResetEmojiImagePasswordController::class, 'viewImageEmojiResetPage'])->name('user.reset.image-emoji-password');
Route::post('reset/emoji-password', [ResetEmojiImagePasswordController::class, 'emojiPasswordResetProcess'])->name('user.reset.emoji-password.submit');
Route::post('reset/image-password', [ResetEmojiImagePasswordController::class, 'imagePasswordResetProcess'])->name('user.reset.image-password.submit');
//ajax get user list
Route::post('search/users', [FilesController::class, 'findUser']);

Route::get('insert-question', function () {
    $questions = [
        "In what city were you born?",
        "What is the name of your favorite pet?",
        "What is your mother's maiden name?",
        "What high school did you attend?",
        "What is the name of your first school?",
        "What was the make of your first car?",
        "What was your favorite food as a child?",
        "Where did you meet your spouse?",
    ];

    // return count($questions);
    // foreach ($questions as $q) {
    //     Questions::create([
    //         'question' => $q
    //     ]);
    // }
    return Questions::all();
});


Route::get('contact', [ContactController::class, 'index']);
Route::get('support', [ContactController::class, 'support']);
Route::post('send-queries', [ContactController::class, 'sendMessage']);


Route::get('check', function () {
    return view('email.reset-emoji-image-security');
});






/*************
 * Admin Route
 * Perform all admin functionality
 *************/

Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', [AdminAuthController::class, 'index'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'adminLogin'])->name('admin.login.submit');


    Route::get('/reset/temp-password', [AdminResetPassword::class, 'viewTempPassReset'])->name('admin.reset.temp-password.view');

    Route::post('/reset/temp-password', [AdminResetPassword::class, 'resetAdminTempPassword'])->name('admin.reset.temp-password.submit');


    //create super admin
    Route::get('super-admin', function () {
        $admin = [
            'name' => 'Almamun',
            'email' => 'hamimalmizan@protonmail.com',
            'temp_password' => Hash::make('almamun123'),
            'isTemp' => 1,
            'role' => 1,
        ];
        return Admin::find(1);

        // return Admin::create($admin);
    });

    Route::get('/verify-otp', [VerifyOTPController::class, 'viewOTPPage'])->middleware('auth:admin')->name('admin.verify.otp');
    Route::post('/verify-otp', [VerifyOTPController::class, 'processOTP'])->middleware('auth:admin')->name('admin.verify.otp.submit');
    Route::post('/resend/otp', [VerifyOTPController::class, 'resendOTP'])->middleware('auth:admin')->name('admin.resend.otp');
    Route::group(['middleware' => ['auth:admin', 'validotp']], function () {
        Route::get('/', [IndexController::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [AdminAuthController::class, 'adminLogout'])->name('admin.logout');



        /**
         * add admin user with roles
         * view employee list
         * reset password with a temp password
         * 
         */
        Route::post('/add-user', [IndexController::class, 'addAdmin'])->name('admin.add-user');
        Route::get('/employee', [IndexController::class, 'adminUsers'])->name('admin.employee');
        Route::get('/employee/{uuid}', [IndexController::class, 'getEmployeeData'])->name('amdin.employee.getdata');
        Route::post('/employee/update', [IndexController::class, 'updateEmployee'])->name('amdin.employee.update.submit');
        Route::post('set-temp-password', [IndexController::class, 'setTemporaryPassword'])->name('admin.set-admin.temp-password');

        /**
         * read user submited message
         * reply to a contact message
         */
        Route::post('read-message', [IndexController::class, 'readMessage'])->name('admin.read.message');
        Route::post('reply-message', [IndexController::class, 'replyContactMessage'])->name('admin.reply.contact-message');


        /**
         * User Debug Route
         * finder user details 
         */
        Route::get('/users', [UserDebugController::class, 'index'])->name('admin.users');
        Route::get('/debug/user/{uuid}', [UserDebugController::class, 'debugUser'])->name('admin.debug.user');
        Route::get('/debug/user/{uuid}/{item}', [UserDebugController::class, 'getUserImages'])->name('admin.debug.user.image');

        Route::post('/debug/user/reset-security-password', [UserDebugController::class, 'resetEmojiImagePasswordToken'])->name('admin.debug.user.reset-security-password.submit');



        /**
         * Update user storage limit
         */

        Route::post('/update/storage', [UserDebugController::class, 'updateUserStorageLimit'])->name('amdin.update.user-storage.submit');
    });
});
