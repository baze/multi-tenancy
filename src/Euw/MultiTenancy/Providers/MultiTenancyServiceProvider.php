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
			realpath( __DIR__ . '/../../../migrations' ) => $this->app->databasePath() . '/migrations',
		] );
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