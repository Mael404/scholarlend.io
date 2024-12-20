<html>
  <head>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
  </head>
    <style>
     body {
  text-align: center;
  padding: 40px 0;
  background: #EBF0F5;
}

h1 {
  color: #88B04B;
  font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
  font-weight: 900;
  font-size: 40px;
  margin-bottom: 10px;
}

p {
  color: #404F5E;
  font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
  font-size: 20px;
  margin: 0;
}

i {
  color: #9ABC66;
  font-size: 100px;
  line-height: 200px;
  margin-left: -15px;
}

.card {
  background: white;
  padding: 60px;
  border-radius: 4px;
  box-shadow: 0 2px 3px #C8D0D8;
  display: inline-block;
  margin: 0 auto;
}

/* Custom styles for the login button */
.btn-login {
  display: inline-block;
  margin-top: 20px;
  padding: 10px 20px;
  font-size: 18px;
  font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
  color: #fff;
  background-color: #28a745;
  border-radius: 5px;
  text-decoration: none;
  transition: background-color 0.3s ease;
}

.btn-login:hover {
  background-color: #218838;
}

    </style>
    <body>
    <div class="card" style="border-radius: 14px;">
  <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
    <i class="checkmark">✓</i>
  </div>
  <h1>Success</h1>
  <p>Password reset successful!<br/> You may now continue with your account.</p>

  <!-- Add a link to proceed to login.php -->
  <a href="login.php" class="btn-login">Proceed to Login</a>
</div>


    </body>
</html>