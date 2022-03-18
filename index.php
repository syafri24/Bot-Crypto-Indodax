<?php
date_default_timezone_set("Asia/Jakarta");
session_start();
if(isset($_POST['login'])){
  $_SESSION['api'] = array(
    "key"=>$_POST['key'],
    "secret"=>$_POST['secret']
  );
  $cek = GetInfo($_SESSION['api']['key'],$_SESSION['api']['secret']);
  if($cek['success']!=1){
  session_destroy();
  header('Location: index.php?pesan=gagal');  
  }
}else if(isset($_POST['logout'])){
session_destroy();
header('Location: index.php');
}



function GetInfo($key,$secret){
  $url = 'https://indodax.com/tapi';
  $key = $key;
  $secretKey = $secret;

  $data = [
    'method' => 'getInfo',
    'timestamp' => '1578304294000',
    'recvWindow' => '1578303937000'
  ];
  $post_data = http_build_query($data, '', '&');
  $sign = hash_hmac('sha512', $post_data, $secretKey);

  $headers = ['Key:'.$key,'Sign:'.$sign];

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_URL => $url,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $data,
    CURLOPT_RETURNTRANSFER => true
  ));

  $response = curl_exec($curl);

  curl_close($curl);
  return json_decode($response,TRUE);
}



?>

<?php if(!isset($_SESSION['api'])){ ?>
  <html> 
  <head> 
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="assets/css/bootstrap.css"> 
    <title>Bot Crypto 2021</title> 
  </head> 
  <body> 
    <div class="container">
      <center>
        <h3>Manage Your Account</h3>
        <h7>BOT CRYPTO 2021 BY SYAFRI</h7>
      </center>
      <br/>
      <br/>
      <?php
      if(isset($_GET['pesan'])){?>
        <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                  API KEY ATAU SECRET KEY ANDA SALAH!!
                </div>

      <?php
      } 
      ?>

      <form action="" method="POST" role="form">
        <div class="form-group">
          <input type="text" class="form-control" name="key" placeholder="API Key">
        </div><div class="form-group">
          <input type="text" class="form-control" name="secret" placeholder="API Secret Key">
        </div>
        <center>
          <div class="form-group clearfix">

            <button type="submit" name="login" class="btn btn-danger">Login</button>
          </div>

          <div class="form-divider"></div>

          <a href="https://facebook.com/cyberzenixs">Create New Account</a>

        </form>
        <br/>
        <hr>
        <br/>
      </div>
    </div>
  <?php }else{ ?>
    <html> 
    <head> 
      <meta charset="utf-8"> 
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

      <link rel="stylesheet" href="assets/css/bootstrap.css"> 
      <title>Bot Crypto 2021</title> 
    </head> 
      <div class="container">
       <br>
       <form action="" method="POST" role="form">
          <button type="submit" id="btn-login" class="btn btn-info float-sm-right" name="logout">Logout</button>
        </form>
    <body> 
       <br><br>
       <center>
        <h3>Manage Your Account</h3>
        <h7>BOT CRYPTO 2021 BY SYAFRI</h7>
      </center>
      <br/>
      <hr>
      <br/>
      <?php
      $data = GetInfo($_SESSION['api']['key'],$_SESSION['api']['secret']);
      $nama = $data['return']['name'];
      $email = $data['return']['email'];
      $saldo = number_format($data['return']['balance']['idr'] , 0 , ',' , '.' );
      ?>
      Nama = <?php echo $nama;?><br/>
      Email = <?php echo $email;?><br/>
      Saldo = Rp <?php echo $saldo;?><br/>
      <br/>
      
         <div id="data"></div>
                
                <br><br>
              
            </div>
          <?php } ?>
          <script src="assets/js/jquery.js"></script> 
          <script src="assets/js/popper.js"></script> 
          <script src="assets/js/bootstrap.js"></script>
        </body> 
        </html>


        <script type="text/javascript">
  setInterval(function() {
    var key = '<?php echo $_SESSION['api']['key'];?>';
    var secret = '<?php echo $_SESSION['api']['secret'];?>';
    $("#data").load('data.php?key=' + key + '&secret=' + secret);
  }, 2000);
</script>