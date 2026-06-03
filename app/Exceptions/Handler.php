<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

/**
 * @codeCoverageIgnore
 */
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,

    ];

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];



    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    // public function render($request, Throwable $exception)
    // {
    //     if ($exception instanceof NotFoundHttpException) {
    //         return response()->view('layouts.errors.404', [], 404);
    //     } elseif ($exception instanceof HttpException && $exception->getStatusCode() == 403) {
    //         if (auth('admin')->check()) {
    //             return redirect('/errors')->withErrors('Sorry, the page is restricted to authorized users only.');
    //         }
    //         if (auth('merchant')->check()) {
    //             return redirect('/errors')->withErrors('Sorry, the page is restricted to authorized users only.');
    //         }
    //         if (auth('team')->check()) {
    //             return redirect('/errors')->withErrors('Sorry, the page is restricted to authorized users only.');
    //         }
    //         return response()->view(
    //             'layouts.errors.403',
    //             ['error' => 'Sorry, this page is restricted to authorized users only.'],
    //             403
    //         );
    //     } elseif ($exception instanceof HttpException) {
    //         Log::info($exception->getMessage());
    //         return response()->view('layouts.errors.503', ['error' => $exception->getTrace()], 500);
    //     }

    //     return parent::render($request, $exception);
    // }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }

    public function register()
    {
        $this->renderable(function (\Spatie\Permission\Exceptions\UnauthorizedException $e, $request) {
            return response()->json([
                'responseMessage' => 'You do not have the required authorization.',
                'responseStatus'  => 403,
            ]);
        });
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}