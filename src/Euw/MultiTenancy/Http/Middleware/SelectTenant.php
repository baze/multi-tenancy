<?php namespace Euw\MultiTenancy\Http\Middleware;

use Closure;
use Euw\MultiTenancy\Exceptions\TenantIsNotActiveException;
use Euw\MultiTenancy\Exceptions\TenantIsNotPublicException;
use Euw\MultiTenancy\Exceptions\TenantNotFoundException;
use Euw\MultiTenancy\Modules\Tenants\Models\Tenant;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;

class SelectTenant {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$server = explode( '.', Request::server( 'HTTP_HOST' ) );

		if ( $server[0] == 'apps' || $server[0] == 'www' ) {
			array_shift( $server );
		}

		if ( count( $server ) == 3 ) {
			$subdomain = $server[0];

			$tenant = Tenant::where( 'subdomain', '=', $subdomain )->first();

			if ( ! $tenant ) {
				throw new TenantNotFoundException;
			}

			if ( ! $tenant->active ) {
				throw new TenantIsNotActiveException;
			}

			if ( ! $tenant->public ) {
				throw new TenantIsNotPublicException;
			}


			$context = app()->make( 'Euw\MultiTenancy\Contexts\Context' );
			$context->set( $tenant );
		}

		return $next($request);
	}

}
