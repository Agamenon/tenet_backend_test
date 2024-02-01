<?php

namespace App\Exceptions;

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $errorsCode = [
        23000 => [
            'DELETE' => 'Can\'t delete due to Integrity/Historical data.',
            'POST' => 'Can\'t update due to Integrity data.',
        ],
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
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (QueryException $e, $request) {
            $method = $request->method();
            $code = (int) $e->getCode();

            return response()->json([
                'message' => $this->errorsCode[$code][$method] ?? 'Server Error',
            ], 404);
        });
    }
}
