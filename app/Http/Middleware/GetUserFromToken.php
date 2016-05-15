<?php


namespace App\Http\Middleware;

use App\User;
use Input;
use Illuminate\Http\Response;


class GetUserFromToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        $token = Input::get('token', $request->header('Authorization'));
        if (!$token) {
            $content = json_encode([
                'message' => 'token_not_provided',
                'code' => 400 
            ]);
            return (new Response($content, 400))->header('Content-Type', 'application/json');
        }

        $user = User::where('token', $token)->first();
        if (!$user) {
            $content = json_encode([
                'message' => 'user_not_found',
                'code' => 404 
            ]);
            return (new Response($content, 404))->header('Content-Type', 'application/json');
        }


        return $next($request);
    }
}
