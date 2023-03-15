<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // FOR LIVE VERSION
        $this->app->bind('path.public', function(){
            return base_path(). '/../../public_html';
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        setlocale(LC_ALL, 'id_ID.utf8');
        Carbon::setLocale('id_ID.utf8');

        Blade::directive('money', function($money){
            return "<?php echo number_format($money, 0, ',', '.'); ?>";
        });

//        Blade::setEchoFormat('nl2br(e(%s))');

    }
}
