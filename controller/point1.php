<?php

$path = $_SERVER['DOCUMENT_ROOT'];

include_once $path . '/wp-config.php';
include_once $path . '/wp-load.php';
include_once $path . '/wp-includes/wp-db.php';
include_once $path . '/wp-includes/pluggable.php';
//include_once $path . '/wp-content/plugins/woocommerce/includes/wc-core-functions.php';


$user= $_GET['user'];


$userid= absint($user);
$description= $_GET['d'];
$ck= 'ck_' . wc_rand_hash();
$cs= 'cs_' . wc_rand_hash();
$permissions= $_GET['p'];

$response = array(
	'user_id'         => $userid,
	'description'     => $description,
	'permissions'     => $permissions,
	'consumer_key'    => $ck,
	'consumer_secret' => $cs,
	'truncated_key'   => substr( $ck, -7 ),
);

$data = array(
					'user_id'         => $userid,
					'description'     => $description,
					'permissions'     => $permissions,
					'consumer_key'    => wc_api_hash( $ck ),
					'consumer_secret' => $cs,
					'truncated_key'   => substr( $ck, -7 ),
				);
try{

$wpdb->insert(
					$wpdb->prefix . 'woocommerce_api_keys',
					$data,
					array(
						'%d',
						'%s',
						'%s',
						'%s',
						'%s',
						'%s',
					)
				);
}

catch(Exception $e){
	echo $e;
	
}

$keyid=$wpdb->insert_id;
   if ($keyid> 0){
	
	header('Content-Type: application/json');
	echo json_encode($response);
}

   else {
	header('Content-Type: application/json');
	echo 'BAD REQUEST';
}
?>
