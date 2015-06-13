<?php namespace App\Game;

use App\Game;
use App\Frame;
use DB;

class Morpion {
  
  const WINTAB = [
          [1,2,3],
          [4,5,6],
          [7,8,9],
          [1,4,7],
          [2,5,8],
          [3,6,9],
          [1,5,9],
          [7,5,3]
        ];
  
  private function frameToWin($frames){
    return in_array(1,array_map(function($winFrames) use ($frames){
      return ((count(array_intersect($frames,$winFrames)))==3)?1:false;
    },Morpion::WINTAB));
  } 
  
  private function getFrameByGameByUserN($idGame,$idUser){
    return DB::table('frames')->where('game_id',$idGame)->where('user_id',$idUser)->get();
  }
  
  private function isUserWin($userFrames,$n){ 
    $mapFrameFn = function($t){
      return intval($t->n);
    };
    return ($this->frameToWin(array_map($mapFrameFn,$userFrames)))?$n:false;
  }
  
  public function whoseWin($game){
    $framesUser1 = $this->getFrameByGameByUserN($game->id,$game->user1_id);
    $framesUser2 = $this->getFrameByGameByUserN($game->id,$game->user2_id);
    if($win=$this->isUserWin($framesUser1,1)){
      return $win;
    }else if($win=$this->isUserWin($framesUser2,2)){
      return $win; 
    }else return false;
  }
  
  public function canIPlayed($user,$game){
    $whoseUserPlayedLast = null;
    $lastFrame = DB::table('frames')->where('game_id',$game->id)->orderBy('id', 'desc')->first();
    if(!is_null($lastFrame)){
      $whoseUserPlayedLast = $lastFrame->user_id;
      if($user->id!=$whoseUserPlayedLast){
        return true;
      }
      return false;
    }
    return true;
  }
}

