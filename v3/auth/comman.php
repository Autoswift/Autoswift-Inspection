<?php 
	include_once ("auth.php");
	$auth = new auth();
	
		$url="https://79.137.66.178/vm/v3/cluster";		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
		$headers = array();
		$headers[] = 'Cookie: ses6=6D69F23C9C881B76AABBFC40';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$result = json_decode(curl_exec($ch),true);;
		if (curl_errno($ch)) {
		  	echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);
		if(isset($result['list'])){
			foreach ($result['list'] as $key => $value) {
				$cluster['cluster_id']=$value['id'];
				$cluster['cluster_name']=$value['name'];
				//$auth->insert($cluster,'cluster');
			}
		}
		$url="https://79.137.66.178/vm/v3/os";		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
		$headers = array();
		$headers[] = 'Cookie: ses6=6D69F23C9C881B76AABBFC40';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$result = json_decode(curl_exec($ch),true);;
		if (curl_errno($ch)) {
		  	echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);
		print_r($result);
		die();
		if(isset($result['list'])){
			foreach ($result['list'] as $key => $value) {
				foreach ($value['clusters'] as $key => $value1) {
					$sql="select * from os_data where os_id='".$value['id']."' and cluster_id='".$value1['id']."'";
					$res = $auth->checkdata($sql);
					if(!$res){
					$sql="insert into os_data values(null,'".$value['id']."','".$value['name']."','".$value['os_group']."','".$value1['id']."')";
					$auth->execute($sql,'os_data');	
					}
				}
			}
		}
		die();
		$url="https://79.137.66.178/vm/v3/recipe";		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
		$headers = array();
		$headers[] = 'Cookie: ses6=6D69F23C9C881B76AABBFC40';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$result = json_decode(curl_exec($ch),true);;
		if (curl_errno($ch)) {
		  	echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);
		if(isset($result['list'])){
			foreach ($result['list'] as $key => $value) {
				print_r($value['tags']);
				echo $sql="select * from os_data where os_name LIKE='%".$value['id']."'%";
				$res = $auth->checkdata($sql);
				print_r($res);	
				$sql="insert into os_data values(null,'".$value['id']."','".$value['name']."','".$value1['id']."')";
			}
		}
?>