<?php
    use App\Http\Middleware\SystemAdminMiddleware;
    use App\Http\Controller\UserController;

    Route::prefix('admin/users')
        ->middleware([SystemAdminMiddleware::class])
        ->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('admin.users.index');
            Route::post('/{user}/block', [UserController::class, 'block'])->name('admin.users.block');
            Route::post('/{user}/unblock', [UserController::class, 'unblock'])->name('admin.users.unblock');
            Route::put('/{user}', [UserController::class, 'update'])->name('admin.users.update');
    });

?>