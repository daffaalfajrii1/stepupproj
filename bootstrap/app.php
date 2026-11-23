<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo('/admin');
        $middleware->redirectUsersTo('/admin');
        $middleware->web(append: [
            \App\Http\Middleware\RecordVisit::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

$webRoot = dirname(__DIR__, 2).DIRECTORY_SEPARATOR.'public_html';
if (is_file($webRoot.DIRECTORY_SEPARATOR.'index.php')) {
    $app->usePublicPath($webRoot);
}

return $app;
