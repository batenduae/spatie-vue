<?php
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/eCommerce',function (){
    return Inertia::render('TailAdminViews/Dashboard/ECommerceView');
})->name('eCommerce');

Route::get('/calendar',function (){
    return Inertia::render('TailAdminViews/CalendarView');
})->name('calendar');

Route::get('/profileView',function (){
    return Inertia::render('TailAdminViews/ProfileView');
})->name('profileView');

Route::get('/form/form-elements',function (){
    return Inertia::render('TailAdminViews/Forms/FormElementsView');
})->name('formElements');

Route::get('/forms/form-layout',function (){
    return Inertia::render('TailAdminViews/Forms/FormLayoutView');
})->name('formLayout');

Route::get('/tables',function (){
    return Inertia::render('TailAdminViews/TablesView');
})->name('tables');

Route::get('/pages/settings',function (){
    return Inertia::render('TailAdminViews/Pages/SettingsView');
})->name('settings');

Route::get('/calendar',function (){
    return Inertia::render('TailAdminViews/CalendarView');
})->name('calendar');

Route::get('/charts/basic-chart',function (){
    return Inertia::render('TailAdminViews/Charts/BasicChartView');
})->name('basicChart');

Route::get('/ui-elements/alerts',function (){
    return Inertia::render('TailAdminViews/UiElements/AlertsView');
})->name('alerts');

Route::get('/ui-elements/buttons',function (){
    return Inertia::render('TailAdminViews/UiElements/ButtonsView');
})->name('buttons');

Route::get('/auth/signin',function (){
    return Inertia::render('TailAdminViews/Authentication/SigninView');
})->name('signin');

Route::get('/auth/signup',function (){
    return Inertia::render('TailAdminViews/Authentication/SignupView');
})->name('signup');
