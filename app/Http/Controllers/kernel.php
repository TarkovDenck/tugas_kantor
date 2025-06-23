protected $routeMiddleware = [
    // middleware bawaan ...
    'check.session' => \App\Http\Middleware\CheckSession::class,
];