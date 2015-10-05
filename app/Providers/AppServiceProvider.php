<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\MessageBag;
use Event;
use Queue;

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
        view()->addNamespace('moderator', $base.'/moderator');

        /**
         * Hook for adding theme support and making global view variables
         */
        view()->composer('*::layout.page', function($view)
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

        /**
         * Proxy for puting events to queue service
         *
         * With ability to put some events to separated queue
         */
        Event::listen('event.*', function($param)
        {
            $pool = Event::firing();

            $handler = 'App\\Jobs\\'. str_replace(' ', '\\', ucwords(str_replace('.', ' ', $pool)));

            if (!class_exists($handler))
                return;

            $queue = null;

            // if separated queue
            if (in_array($pool, config('queue.separated')))
                $queue = config('queue.prefix').$pool;

            try
            {
                Queue::push($handler, $param, $queue);
            }
            catch (Exception $e)
            {
                //echo $e->getMessage();
            }
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
