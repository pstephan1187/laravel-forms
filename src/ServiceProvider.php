<?php

namespace Formery;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider as BaseProvider;

class ServiceProvider extends BaseProvider
{
	public function register()
	{}

	public function boot()
	{
		$this->loadViewsFrom(__DIR__.'/views', 'form');

	    $this->publishes([
	        __DIR__.'/views' => resource_path('views/vendor/form'),
	    ]);

		Blade::directive('form', function($expression){
			return '<?php echo '.$expression.'->render(); ?>';
		});
	}
}