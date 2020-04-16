<?php
namespace App\Http\Middleware;
use Closure;
use App\User;

class UserAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->header('token') == NULL){
            return responder()->error(401, 'Token required')->respond(401);
        }

        $user = User::where('token',$request->header('token'))->first();

        if ($user) {
            $request->request->add(['userData' => $user]);
            return $next($request);
        }

        return responder()->error(401, 'Invalid token')->respond(401);


    }

}