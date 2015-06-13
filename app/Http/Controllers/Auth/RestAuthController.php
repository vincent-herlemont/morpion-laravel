<?php namespace App\Http\Controllers;

use Auth;
use Illuminate\Routing\Controller;

class  RestAuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function authenticate()
    {
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            // Authentication passed...
          // return redirect()->intended('dashboard');
          return "true";
        }
    }
}
