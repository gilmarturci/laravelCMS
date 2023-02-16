<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site;
use App\Http\Controllers\Admin;
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
Auth::routes();

Route::get('/', [Site\HomeController::class, 'index']);

    Route::prefix('/painel')->group(function () {

    Route::get('/', [Admin\HomeController::class, 'index'])->name('admin');
    
    Route::get('login', [Admin\Auth\LoginController::class, 'index'])->name('login');
    Route::post('/login', [Admin\Auth\LoginController::class, 'authenticate'])->name('authenticate');
    Route::post('/logout', [Admin\Auth\LoginController::class, 'logout'])->name('logout');
     
    Route::get('/register', [Admin\Auth\RegisterController::class, 'index'])->name('register');
    Route::post('/register', [Admin\Auth\RegisterController::class, 'register']);
    
    Route::get('/reset', [Admin\Auth\ForgotPasswordController::class, 'index'])->name('reset');
    
    Route::resource('/users', '\App\Http\Controllers\Admin\UserController');
    
    Route::get('/profile', [Admin\ProfileController::class, 'index'])->name('profile');
    Route::put('/profilesave', [Admin\ProfileController::class, 'save'])->name('profile.save');
    
    Route::get('/settings', [Admin\SettingController::class, 'index'])->name('settings');
    Route::put('/settingssave', [Admin\SettingController::class, 'save'])->name('settings.save');
    
    Route::resource('/pages', '\App\Http\Controllers\Admin\PageController');
    
    Route::resource('/debertor', '\App\Http\Controllers\Admin\DebertorController');
    
    Route::resource('/titulo', '\App\Http\Controllers\Admin\TituloController');

       
     
    Route::get('pesquisa/{cep}', [Admin\EventController::class, 'cep'])->name('event.cep');
    Route::get('delete/{email}', [Admin\EventController::class, 'email_delete'])->name('event.email');
    Route::get('del.titulo/{titulo}', [Admin\TituloController::class, 'destroy'])->name('event.del.titulo');
     Route::get('update.titulo/{titulo}', [Admin\TituloController::class, 'update'])->name('event.update.titulo');
    Route::get('searchDebertor/{devedor}', [Admin\EventController::class, 'searchDevedor'])->name('event.searchDevedor');
    Route::get('searchCpf/{nome}', [Admin\EventController::class, 'searchCpfDevedor'])->name('event.searchCpfDevedor');
});

    Route::fallback([Site\PageController::class, 'index']);
    