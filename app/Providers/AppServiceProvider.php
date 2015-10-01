<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\MessageBag;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Specifying availible themes and their base paths
         */
        $base = realpath(base_path('resources/views'));
        view()->addNamespace('pirates', $base.'/pirates');
        view()->addNamespace('adm', $base.'/adm');

        /**
         * Hook for adding theme support and making global view variables
         */
        view()->composer('pirates::layout.page', function($view)
        {
            $shared = $view->getFactory()->getShared();

            // resiving global messages variable (as well as errors)
            if (empty($shared['messages']))
                $shared['messages'] = session('messages', new MessageBag);

            if (!($shared['messages'] instanceof MessageBag))
                $shared['messages'] = new MessageBag;

            if (!isset($shared['baseurl']))
                $view->getFactory()->share('baseurl', config('app.url'));

            /**
             * Making variables global for subviews
             */

            $data = $view->getData();

            if (!empty($data['vars']))
            {
                foreach ($data['vars'] as $key => $value)
                    $view->getFactory()->share($key, $value);
            }

            $view->getFactory()->share('messages', $shared['messages']);

            // global current user
            $view->getFactory()->share('auth_user', auth()->user());

            /**
             * Themes support
             */

            $name = $view->getName();

            $theme = substr($name, 0, strpos($name, '::'));

            // sharing current theme
            if (!isset($shared['theme']))
                $view->getFactory()->share('theme', $theme);

            $hints = $view->getFactory()->getFinder()->getHints();

            // setting up base path for templates searching based on current theme
            $view->getFactory()->addLocation($hints[$theme][0]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
