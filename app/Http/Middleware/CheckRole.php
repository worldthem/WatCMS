<?php 
namespace App\Http\Middleware;

// First copy this file into your middleware directory

use Closure;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Modules\User; 
class CheckRole{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle( $request, Closure $next){
        // Get the required roles from the route
         $roles = $this->getRequiredRoleForRoute($request->route());
         $req= new User();
          
        // Check if a role is required for the route, and
        // if so, ensure that the user has that role.
         if($req->hasRole($roles) || !$roles) {
            return $next($request);
          }
           
         return redirect('/');
         return response([

            'error' => [
                'code' => 'INSUFFICIENT_ROLE',
                'description' => 'You are not authorized to access this resource.'
            ]
        ], 401); 

    }

    private function getRequiredRoleForRoute($route) {
        $actions = $route->getAction();
        
        
        return isset($actions['roles']) ? $actions['roles'] : null;
    }
    
 
}

