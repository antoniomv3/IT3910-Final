<?php

class finalView {
    public function __construct(){
    }
    public function __destruct(){
    }
    
    public function getHtml($nav, $data) {
        switch($nav) {
            case 'home':
                if($_SESSION['logStatus'] === 'true') {
                    $html = $this->setupHomePage($data);
                } else {
                    $html = $this->setupLoginPage();
                }
                break;
            case 'login': 
                if($_SESSION['logStatus'] === 'true') {
                    $html = $this->setupHomePage($data);
                } else {
                    $html = $this->setupLoginPage();
                }
                break;
            case 'newList':
                $html = $this->setupNewList($data);
                break;
            default:
                break;
        }
        return $html;
    }
    
//////////////////////////////////////////////////////////////////////////
    
    private function setupLoginPage() {
        $html = '
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>IT3910 - Login</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> 
    <link href="signin.css" rel="stylesheet">
</head>
    
<body>
   <div class="container">';
        
        if(isset($_SESSION['logError'])) {
            if($_SESSION['logError'] === 'Yes') {
                $html .= '
                <div class="alert alert-danger" role="alert">
                    Login unsuccessful, please try again.
                </div>';
            }
        } 
        
        $html .= '
        <form action="index.php" method="post" class="form-signin">
            <input type="hidden" name="action" value="login">
        <h2 class="form-signin-heading">Please sign in</h2>
            <label for="inputEmail" class="sr-only">Email address</label>
            <input name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
            <label for="inputPassword" class="sr-only">Password</label>
            <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="row mt-3"><p> </p></div>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        </form>
    </div>
</body>
</html>';
        return $html;
    }
    
//////////////////////////////////////////////////////////////////////////
    
    private function setupHomePage($tableData) {
        $html = '
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>IT3910 - Home</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> 
    <link href="cover.css" rel="stylesheet">
  </head>

  <body>

    <div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">

          <div class="masthead clearfix">
            <div class="inner">
              <h3 class="masthead-brand">Welcome ' .$_SESSION['email']. '!</h3>
              <nav>
                <ul class="nav masthead-nav">
                  <li class="active"><a href="http://ec2-34-219-16-84.us-west-2.compute.amazonaws.com/?nav=home">Home</a></li>
                  <li><a href="http://ec2-34-219-16-84.us-west-2.compute.amazonaws.com/?nav=newList">New List</a></li>
                  <li><a href="http://ec2-34-219-16-84.us-west-2.compute.amazonaws.com/?nav=logout">Logout</a></li>
                </ul>
              </nav>
            </div>
          </div>

          <div class="inner cover">
            <h1 class="cover-heading">Wish Lists</h1>
            <form action="index.php" method="post">
                <input type="hidden" name="action" value="search">
                <div class="form-group">
                    <label for="search">Search Recipients</label>
                    <input class="form-control" id="search" name="Search">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <p class="lead"><table class="table table-bordered table-hover"><thead class="thead-light"><tr><th scope="col">Recipient</th><th scope="col">Gift</th></tr></thead>'.$tableData.'</table></p>
          </div>

          <div class="mastfoot">
            <div class="inner">
              <p>Cover template for <a href="http://getbootstrap.com">Bootstrap</a>, by <a href="https://twitter.com/mdo">@mdo</a>.</p>
            </div>
          </div>

        </div>

      </div>

    </div>

  </body>
</html>';
        return $html;
    }
    
//////////////////////////////////////////////////////////////////////////
    
    private function setupNewList($giftData) {
        $html = '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>IT3910 - Home</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> 
    <link href="cover.css" rel="stylesheet">
  </head>

  <body>

    <div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">

          <div class="masthead clearfix">
            <div class="inner">
              <h3 class="masthead-brand">Welcome ' .$_SESSION['email']. '!</h3>
              <nav>
                <ul class="nav masthead-nav">
                  <li><a href="http://ec2-34-219-16-84.us-west-2.compute.amazonaws.com/?nav=home">Home</a></li>
                  <li class="active"><a href="http://ec2-34-219-16-84.us-west-2.compute.amazonaws.com/?nav=newList">New List</a></li>
                  <li><a href="http://ec2-34-219-16-84.us-west-2.compute.amazonaws.com/?nav=logout">Logout</a></li>
                </ul>
              </nav>
            </div>
          </div>

          <div class="inner cover">
            <h1 class="cover-heading">New List</h1>
            
            
           <form action="index.php" method="post">
                <input type="hidden" name="action" value="submitList">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="Name" value="" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="relation">Relation</label>
                        <input type="text" class="form-control" id="relation" name="Relation" value="">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="Address" value="">
                    </div>
                <h2>Wish List</h2>
      
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="choice1">Choice 1</label>
                        <select class="form-control" id="choice1" name="Choice1"><option value="NA">N/A</option>'.$giftData.'</select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="choice2">Choice 2</label>
                        <select class="form-control" id="choice2" name="Choice2"><option value="NA">N/A</option>'.$giftData.'</select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="choice3">Choice 3</label>
                        <select class="form-control" id="choice3" name="Choice3"><option value="NA">N/A</option>'.$giftData.'</select>
                    </div>
                </div>
                <input type="submit" class="btn btn-primary" value="Submit">
          </div>

          <div class="mastfoot">
            <div class="inner">
              <p>Cover template for <a href="http://getbootstrap.com">Bootstrap</a>, by <a href="https://twitter.com/mdo">@mdo</a>.</p>
            </div>
          </div>

        </div>

      </div>

    </div>

  </body>
</html>';
        return $html;
    }
}
?>