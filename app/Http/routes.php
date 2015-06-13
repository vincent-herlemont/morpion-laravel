<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use Illuminate\Http\Response as HttpResponse;
use App\Game;
use App\User;


Route::group(['middleware' => 'jwt.auth'],function(){
  Route::resource('frame','FrameController');
  Route::resource('game','GameController');
});

Route::get('/whoseWin/{idGame}', function($idGame){
  $morpion = $this->app->make('Morpion');
  $game = Game::find($idGame);
  $user = User::find($morpion->whoseWin($game));
  return Response::json($user);
});

Route::get('/canIPlayed/{idGame}',function($idGame){ 
  $morpion = $this->app->make('Morpion');
  $token = JWTAuth::getToken();
  $user = JWTAuth::toUser($token);
  $game = Game::find($idGame);
  return Response::json(["canIPlayed"=>$morpion->canIPlayed($user,$game)]);
});

Route::get('/', function () {
    return view('welcome');
});



Route::post('/signin', function () {
   $credentials = Input::only('email', 'password');

   if ( ! $token = JWTAuth::attempt($credentials)) {
       return Response::json(false, HttpResponse::HTTP_UNAUTHORIZED);
   }
   return Response::json(compact('token'));
});

Route::post('/signup', function () {
   $credentials = Input::only('name','email','password');
  try {
    $credentials['password']=Hash::make($credentials['password']);
    $user = User::create($credentials);
   } catch (Exception $e) {
     return Response::json(['error' => 'User already exists.'], HttpResponse::HTTP_CONFLICT);
   }

   $token = JWTAuth::fromUser($user);

   return Response::json(compact('token'));
});


Route::get('/getUserInfo', [
   'middleware' => 'jwt.auth',
   function () {
       $token = JWTAuth::getToken();
       $user = JWTAuth::toUser($token);

       return Response::json([
         'data' => [
              'id' => $user->id,
               'name' => $user->name,
               'email' => $user->email,
               'registered_at' => $user->created_at->toDateTimeString()
           ]
       ]);
   }
]);
