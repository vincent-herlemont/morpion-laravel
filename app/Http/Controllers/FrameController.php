<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use App\Game;
use App\Frame;
use JWTAuth;
use DB;
use App\Game\Morpion;
use Log;

class FrameController extends Controller
{

    protected $morpion;

    public function __construct(Morpion $morpion)
    {
      //Log::debug(dd($morpion));
      $this->morpion = $morpion;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
      $gameId = $request->input('game_id');
      if(!is_null($gameId)){
        $frames = DB::table('frames')->where('game_id',$gameId)->get();
          return response()->json($frames);
      } 
      return response()->json(Frame::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    { 
      function issetReplace($var){
        if (isset($var)) {
          return $var;
        }else{
          return 0;
        }
      }
      $token = JWTAuth::gettoken();
      $user = JWTAuth::touser($token);
      $game = Game::find(intval($request->input('game_id')));

      if(
        (issetReplace($game->user1_id)==$user->id||issetReplace($game->user2_id)==$user->id)
       &&($this->morpion->canIPlayed($user,$game))
      ){
        $frame = new Frame;
        $frame->n = $request->input('n');
        $frame->game_id = $request->input('game_id');
        $frame->user_id = $user->id;
        $frame->save();
        $whoseWinId = $this->morpion->whoseWin($game); 
        return response()->json(["message"=>"Frame ".$frame->n." in game ".$frame->game_id." created.","whoseWinId"=>$whoseWinId]);
      }else{
        return response()->json(["message"=>"We aren't in a game."]);
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
