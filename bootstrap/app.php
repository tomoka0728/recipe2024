<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\LogSessionData;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function(){
            Route::middleware('web')
            ->prefix('admin')->name('admin.')
            ->group(__DIR__ . '/../routes/admin.php');
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(function($request) {
            if(request()->routeIs('admin*')){
                return $request->expectsJson() ? null : route('admin.login');
            }
            return $request->expectsJson() ? null : route('login');
            });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
