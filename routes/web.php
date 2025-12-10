<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnswersController;
use App\Http\Controllers\Configcontroller;
use App\Http\Controllers\CopyrighttextController;
use App\Http\Controllers\DestroyAllController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MainQuizController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'login');

Route::group(['middleware' => ['isadmin', 'prevent-back-history']], function () {

    Route::delete('delete/sheet/quiz/{id}', [TopicController::class, 'deleteperquizsheet'])->name('del.per.quiz.sheet');
    Route::delete('delete/topic/{id}', [TopicController::class, 'deleteTopic'])->name('del.topic');
    Route::get('/admin', [AdminController::class, 'index'])->name('dashboard');
    Route::get('examinee/exam/results/{id?}', [AdminController::class, 'getResult'])->name('exam.result');
    //Route::delete('reset/response/{topicid}/{userid}','AllReportController@delete');
    Route::get('/admin/examinees', [AdminController::class, 'applicants'])->name('examinees.lists');
    Route::get('/admin/admin_list', [AdminController::class, 'adminlist'])->name('admin.list');
    Route::resource('/admin/topics', TopicController::class);
    Route::resource('/admin/questions', QuestionsController::class);
    Route::resource('/admin/answers', AnswersController::class);
    Route::resource('/admin/settings', SettingController::class);
    Route::post('/admin/users/destroy', [DestroyAllController::class, 'AllUsersDestroy']);
    Route::post('/admin/users/retry/{user}', [DestroyAllController::class, 'retryUserExam'])->name('retry.exam');
    Route::post('/admin/answers/destroy', [DestroyAllController::class, 'AllAnswersDestroy']);
    Route::get('/exam/exportpdf', [AdminController::class, 'exportPDF'])->name('situation.pdf');
    Route::get('/exam/exportResultpdf', [AdminController::class, 'exportResultPDF'])->name('examresult.pdf');
    Route::post('/admin/uploadimg', [AdminController::class, 'uploadImages']);
    Route::post('/admin/questions/import_questions', [QuestionsController::class, 'importExcelToDB'])->name('import_questions');
    Route::post('/admin/send-invite/{token}/{name}/{email}/{id}', [EmailController::class, 'sendmail'])->name('send.invite');
});

Route::resource('/admin/dashboard', UsersController::class);
Route::get('/admin/export', [AdminController::class, 'exportTemplate'])->name('export');

Route::group(['middleware' => 'checkResult'], function () {

    Route::get('online-assessment/welcome/instructions', [AdminController::class, 'startquiz'])->name('start_quiz');
    Route::get('online-assessment/category/{slug?}', [AdminController::class, 'apptitude'])->name('aptitude_exam');
    Route::get('online-assessment/category/{slug}/direction',  [AdminController::class, 'category'])->name('category_title');
    Route::get('/calculate', [PublicController::class, 'notify']);
    Route::get('/violation', [PublicController::class, 'violation']);
});
Route::get('online-assesment/completed', [PublicController::class, 'index'])->name('exam.completed');
Route::get('online-assessment/verify-email/{id}', [AdminController::class, 'examinee'])->name('examinee');
Route::group(['middleware' => 'checkResult'], function () {
    Route::resource('online-assessment/category/{id}/quiz', MainQuizController::class);
});

Route::view('/404/page-not-found', 'errors.404')->name('404');
Route::view('/violate-rules', 'errors.403')->name('violation');
Route::view('/profilling', 'profile')->name('profilling');


Route::get('admin/moresettings/copyright', [CopyrighttextController::class, 'index'])->name('copyright.index');
Route::put('admin/moresettings/copyright/{id}', [CopyrighttextController::class, 'update'])->name('copyright.update');

//env.
Route::get('/admin/mail-settings', [Configcontroller::class, 'getset'])->name('mail.getset');
Route::post('admin/mail-settings', [Configcontroller::class, 'changeMailEnvKeys'])->name('mail.update');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::redirect('/start-exam', 'online-assessment/welcome/instructions');

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
})->middleware('auth')->name('logout');

Route::post('/violation/count', [PublicController::class, 'violationCount'])->name('violation.count');
