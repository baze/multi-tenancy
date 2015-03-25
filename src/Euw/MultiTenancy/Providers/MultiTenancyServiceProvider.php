<?php namespace Euw\MultiTenancy\Providers;

use Illuminate\Support\ServiceProvider;

class MultiTenancyServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot() {
		$this->publishes( [
			__DIR__ . '/../../../migrations/' => base_path( '/database/migrations' )
		], 'migrations' );
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register() {
		$this->app->register( 'Euw\MultiTenancy\Providers\ContextServiceProvider' );
	}

}