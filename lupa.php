<?php
include "cekforget.php";
include "pages/db.php";
?>
<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Pengadaian2017</title>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

  <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'>
<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>

      <link rel="stylesheet" href="css/style.css">


</head>

<body>
 <style>
 .war
 {
    color : green;
 }
 </style>
<div class="pen-title">
  <h1>Pengaduan 2017</h1>
</div>
<!-- Form Module-->
<div class="module form-module">
  <div class="toggle">
  
  </div>
  <div class="form">
    <h2>Forget Password</h2>
    <form method="post" action="" enctype="multipart/form-data">
   <?php echo "<label class='war'>$forgetCetak</label>"; ?><br><br>
      <input type="text" name="email" placeholder="Email"/>
      <button type="submit">Send</button>
    </form>
  </div>
  <div class="cta"><a href="index.php">Sign In</a></div>
</div>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='https://codepen.io/andytran/pen/vLmRVp.js'></script>

    <script  src="js/index.js"></script>

</body>
</html>
