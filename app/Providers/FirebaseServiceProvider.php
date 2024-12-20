<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Service\Auth;
use Kreait\Firebase\Service\Messaging;

class FirebaseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Messaging::class, function () {
            $factory = (new Factory)->withServiceAccount(env('FIREBASE_CREDENTIALS'));
            return $factory->createMessaging();
        });
    }
}
