var app = angular.module('morpion',['ngResource','myServices','ngRoute']);

app.config(function($interpolateProvider) {
  $interpolateProvider.startSymbol('!/');
  $interpolateProvider.endSymbol('/!');
});

app.config(['$routeProvider', '$httpProvider', function ($routeProvider, $httpProvider) {
  $httpProvider.interceptors.push(['$q', '$location', '$localStorage', function ($q, $location, $localStorage) {
   return {
       'request': function (config) {
           config.headers = config.headers || {};
           console.log('request header !');
           if ($localStorage.token) {
               config.headers.Authorization = 'Bearer ' + $localStorage.token;
           }
           return config;
       },
       'responseError': function (response) {
           if (response.status === 401 || response.status === 403) {
            console.log("no connected");
           }
           return $q.reject(response);
       }
   };
}]);
}]);
app.factory('user',function(){ 
  var user = {
    email:'',
    password:'',
    name:''
  };
  return {
    getUser:function(){
      return user;
    },
    setUser:function(_user){
      user = _user;
    }
  };
});
app.controller('authUser',['$rootScope','$scope','$resource','$log','Auth','$http','$localStorage','user',function($rootScope,$scope,$resource,$log,Auth,$http,$localStorage,user){
  $scope.user = user.getUser();
  $scope.logout = function () {
    Auth.logout(function () {
      $log.info('logout!');
   });
  };
  $scope.signin = function () {
     var formData = {
       email: $scope.user.email,
       password: $scope.user.password
     };
     Auth.signin(formData, function(res){
        $localStorage.token = res.token;
        getUser();
     }, function () {
        $rootScope.error = 'Invalid credentials.';
  });};
  $scope.signup = function () {
    var formData = {
      email: $scope.user.email,
      password: $scope.user.password,
      name: $scope.user.name
    };
    Auth.signup(formData,function(res){ 
        $localStorage.token = res.token;
        getUser();
    } , function () {
      $rootScope.error = 'Failed to signup';
    });
  };
  var User = $resource('/getUserInfo');
  function getUser(){  
    User.get(function(data){
      $scope.user = data.data;
      user.setUser(data.data);
    });
  }
  getUser();
}]);
app.factory('gameFactory',function(){ 
  return {
    name:''
  };
});
app.controller('gamesManager',['$rootScope','$scope','$resource','$log','user','gameFactory','$interval',function($rotScope,$scope,$resource,$log,user,gameFactory,$interval){
  $scope.game = gameFactory;
  $scope.games = [];
  var Game = $resource('/game/:gameId',{gameId:'@id'},{
    'get':{method:'GET', isArray:true},
    'update':{method: 'PUT'}
  });
  $scope.getAllGames = function(){ 
    Game.get(function(data){
      $scope.games = data;
    });
  };
  $scope.delGame = function(game){
    Game.delete({gameId:game.id},function(){
      $scope.getAllGames();
    });
  };
  $scope.createGame = function(newGameName){
    Game.save(newGameName,function (data){
      $scope.getAllGames();
    });
  };
  $scope.join = function(_game){
    Game.update({id:_game.id,user_id:user.getUser().id},function(data){
      $scope.game.name = _game.name;
      $scope.game.id = _game.id;
      
      $scope.getAllGames();
    });
  };
  $scope.getAllGames();
  $interval(function(){
    $scope.getAllGames();
  },3000);
}]);
app.controller('gameController',['gameFactory','user','$log','$scope','$resource','$rootScope','$interval',function(gameFactory,user,$log,$scope,$resource,$rootScope,$interval){
  function initFrames(){
    $scope.frames=[];
    var len = 9;
    var frame = {
      g_n:null,
      game_id:null,
      user_id:null,
    };
    for ( var i = 1; i <= len; i++ ) {
      frame.n = i;
      $scope.frames.push(angular.copy(frame));
    }
  } 
  var Frame = $resource('/frame/:frameId',{frameId:'@id'},{
    'get':{method:'GET', isArray:true},
    'update':{method: 'PUT'}
  });
  var WhoseWin = $resource('/whoseWin/:gameId',{gameId:'@id'});
  var CanIPlayed = $resource('/canIPlayed/:gameId',{gameId:'@id'});
  $scope.frames= [];
  $scope.infoGame = {
    canIPlayed:false,
    whoseWin:{}
  };
  $scope.setFrame = function(data){
    var sendFrameData = {
      n:data.n,
      user_id:user.getUser().id,
      game_id:$scope.game.id
    };
    Frame.save(sendFrameData,function (rep){
      $scope.provideFrames();
    });
  };
  initFrames();
  function win(){ 
    CanIPlayed.get({gameId:$scope.game.id},function(data){
      $scope.infoGame.canIPlayed = data.canIPlayed;
    });
    WhoseWin.get({gameId:$scope.game.id},function(data){
      $scope.infoGame.whoseWin = data;
    });
  }
  $scope.provideFrames = function(){
    Frame.get({'game_id':$scope.game.id},function(data){
      angular.forEach(data,function(value,key){
        $scope.frames[value.n-1] = value;
      });
    });  
  };
  $scope.$watch('game',function(newValew,lastValue){
    if($scope.game.id!==undefined){
      initFrames();
      $scope.provideFrames();
      win();
    }
  },true);
  $scope.game = gameFactory;
  $interval(function(){
    if($scope.game.id!==undefined){
      $scope.provideFrames();
      win();
    }
  },2000);
}]);
app.directive('morpionFrame',function(){
  return {
    template:'<button ng-click="send()">!/info.user_id/!&nbsp;</button>',
    scope:{
      info:'=info',
      send:'&'
    },
  };
});
