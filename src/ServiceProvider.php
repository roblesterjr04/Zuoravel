<?php

namespace Lester\Zuoravel;

use Lester\Zuoravel\Classes\Zuora;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    const CONFIG_PATH = __DIR__ . '/../config/zuoravel.php';

    public function register()
    {
        $this->mergeConfigFrom(
			self::CONFIG_PATH,
			'zuoravel'
		);

        $this->app->bind('zuora', function() {
			return new Zuora();
		});

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Zuora', 'Lester\Zuoravel\Facades\Zuora');
    }

    public function boot()
    {
        $this->publishes([
			self::CONFIG_PATH => config_path('zuoravel.php'),
		], 'config');

        \Blade::directive('payment', function($expression) {
            return "<?php echo Zuora::paymentScreen($expression); ?>";
        });
    }

}
