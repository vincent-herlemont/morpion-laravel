<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Game;
use Input; 

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
      return response()->json(Game::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {    
      
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    { 
        $game = new Game;
        $game->name = $request->input('name');
        $game->save();
        return response()->json(["message"=>"Game ".$game->name." created."]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return response()->json(Game::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit()
    {
      
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
      $input = Input::all();
      $game = Game::find($id);
      var_dump($game->user1_id);
      var_dump($game->user2_id);
      if(is_null($game->user1_id)){
        $game->user1_id = $input['user_id'];
      }else if(is_null($game->user2_id)&&($game->user1_id!=$input['user_id'])){  
        $game->user2_id = $input['user_id'];
      };
      $game->save();
      var_dump($input);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {  
      $nameGame = Game::find($id)->name;
      Game::destroy($id);
      return response()->json(["message"=>"The game ".$nameGame." destroyed."]);
    }
}
