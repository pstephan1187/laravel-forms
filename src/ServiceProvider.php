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
	        __DIR__.'/views' => function_exists('resource_path') ? resource_path('views/vendor/form') : base_path('resources/views/vendor/form'),
	    ]);

		Blade::directive('form', function($expression){
			return '<?php echo '.$expression.'->render(); ?>';
		});
	}
}