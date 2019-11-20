<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map(Request $request)
    {
        if ($request->isMethod('get')) {
            $locale = $request->segment(1);
            $lang_list = ['ru', 'kk', "en"];
            if (in_array($locale, $lang_list)) {
                $this->app->setLocale($locale);
                setcookie("site_lang", $locale, time() + (86400 * 30), "/");
                View::share('lang', $locale);

                if ($locale == 'ru') {
                    $segments = $request->segments();
                    $first = array_shift($segments);
                    header("HTTP/1.1 301 Moved Permanently");
                    header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
                    header('Location: ' . URL::to('/') . '/' . implode('/', $segments));
                    exit();
                }
            } else {
                if (Cookie::has('site_lang') && Cookie::get('site_lang') != 'ru') {
                    $locale = Cookie::get('site_lang');
                    $url = str_replace(URL::to('/'), "" . "/" . $locale, $request->fullUrl());
                    header("HTTP/1.1 301 Moved Permanently");
                    header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
                    header('Location: ' . $url);
                    exit();
                } else $locale = null;
            }

            Route::group([
                'middleware' => 'web',
                'namespace' => $this->namespace,
                'prefix' => $locale
            ], function ($router) {
                require base_path('routes/web.php');
            });
        }
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}
