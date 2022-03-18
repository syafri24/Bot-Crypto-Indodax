<?php
$key = $_GET['key'];
$secret  =$_GET['secret'];
function GetInfo($key,$secret){
  $url = 'https://indodax.com/tapi';

  $data = [
    'method' => 'getInfo',
    'timestamp' => '1578304294000',
    'recvWindow' => '1578303937000'
  ];
  $post_data = http_build_query($data, '', '&');
  $sign = hash_hmac('sha512', $post_data, $secret);

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
}?>
<div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
          <thead>
            <tr>
              <div class="table-responsive">
                <thead>
                  <tr>
                    <th>Crypto</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Target</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <?php
                $data1 =GetInfo($key,$secret); 
                foreach($data1['return']['balance'] as $crypto => $val){
                  if($val>=1 && $crypto!='idr'){
$pair_id = $crypto.'idr';
$url = "https://indodax.com/api/ticker/".$pair_id;
$curlHandle = curl_init();
curl_setopt($curlHandle, CURLOPT_URL, $url);
curl_setopt($curlHandle, CURLOPT_HEADER, 0);
curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curlHandle, CURLOPT_TIMEOUT,30);
curl_setopt($curlHandle, CURLOPT_POST, 1);
$result = curl_exec($curlHandle);
curl_close($curlHandle);

$b = json_decode($result, true);

                    ?>
                    <tr>
                      <td><?php echo strtoupper($crypto);?></td>
                      <td><?php echo $val;?></td>
                      <td><?php echo $b['ticker']['last'];?></td>
                      <td>5%</td>
                      <td><button class="btn btn-success">Running</button></td>
                    </tr>
                    <?php 
                  }}
                  ?></table></div>