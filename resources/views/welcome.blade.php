<html ng-app="morpion">
    <head>
        <title>Laravel</title>

        <link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>

        <style>
            body {
                margin: 0;
                padding: 0;
                width: 100%;
                height: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
                margin-bottom: 40px;
            }

            .quote {
                font-size: 24px;
            }
        </style>
    </head>
    <body>
         <h2>Morpion Laravel</h2>
        <div ng-controller="authUser">
          <div>Connected with <u>!/user.name/!</u></div>
          <div><button ng-click="logout()">Logout</button></div>
          <div>
            <div><b>Authentification</b></div>
            <label>Email</label>
            <input type="text" ng-model="user.email"/></br>
            <label>Password</label>
            <input type="password" ng-model="user.password"/></br>
            <button ng-click="signin()">SignIn</button>
          </div>
          <div>
            <div><b>Inscription</b></div>
            <label>Name</label>
            <input type="text" ng-model="user.name"/><br/>
            <label>Email</label>
            <input type="text" ng-model="user.email"/></br>
            <label>Password</label>
            <input type="password" ng-model="user.password"/></br>
            <button ng-click="signup()">SignUp</button>
          </div>
        </div>
        <div ng-controller="gamesManager">
          Games Manager <br />
          <input type="text" ng-model="newGameName" /><button ng-click="createGame({name:newGameName})">Create</button>
          <ul>
            <li ng-repeat="game in games">
                !/game.name/! <button ng-click=delGame(game)>x</button>
                <button ng-click="join(game)">Join</button>!/game.user2_id?'complet':'free place'/!
            </li>
          </ul> 
          <div ng-controller="gameController">
            !/(game.name)?"You are in a game : ":""/!                     
            !/(game.name)?game.name:"You aren't in a game."/!</br>
            !/(infoGame.canIPlayed)?"Your turn !":"Not your turn ... please wait"/!<br />
            !/(infoGame.whoseWin.name)?"The winner is : ":""/!
            !/(infoGame.whoseWin.name)?infoGame.whoseWin.name:""/!
            !/(infoGame.whoseWin.name)?" !!!":""/!
            <table>
              <tr>
                <td ng-repeat="frame in frames | limitTo:3:0">
                  <morpion-frame info="frame" send="setFrame(frame)"></morpion-frame>
                </td>
              </tr>
              <tr>
                <td ng-repeat="frame in frames | limitTo:3:3">
                  <morpion-frame info="frame" send="setFrame(frame)"></morpion-frame>
              </td>
              </tr>
              <tr>
                <td ng-repeat="frame in frames | limitTo:3:6">
                  <morpion-frame info="frame" send="setFrame(frame)"></morpion-frame>
              </td>
              </tr>
            </table>
          </div>
        </div>
        <script src="{{ asset('/js/vendor.js') }}"></script>
        <script src="./js/services.js"></script>
        <script src="./js/app.js"></script>
    </body>
</html>
