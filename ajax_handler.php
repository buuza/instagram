<?php
	
	if (isset($_POST['tag'])){
		$tagName = trim($_POST['tag']);
		
		$tagName = str_replace(" ","",$tagName);
		if (strpbrk(",",$tagName)){
			$tagNames = explode(",", $tagName);
		} else {
			$tagNames[] = $tagName;
		}
		$res = array();
		//Get data from instagram api
		foreach($tagNames as $tag){
			$token = array(
				'access_token' => '356026601.1fb234f.624b500980f54f36b16f4831c5a63470'
			);

			$url = 'https://api.instagram.com/v1/tags/'.$tag.'/media/recent?'.http_build_query($token);

			try {
				$curl_connection = curl_init($url);
				curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
				curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
		
				//Data are stored in $data
				$data[] = json_decode(curl_exec($curl_connection), true);
				curl_close($curl_connection);
				++$count;
			} catch(Exception $e) {
				return $e->getMessage();
			}
		
		}

		foreach ($data as $key => $value){
			$newUrl = $value['pagination']['next_url'];	
			if($value['data']){
				foreach($value['data'] as $pic){
					$pic_url = $pic['images']['low_resolution']['url'];
					$images .= '<img src="'.$pic_url.'">';
					$counter++;
				}
			} else {
				echo "Sorry, nothing found, try different tag";
			}
			$images .= '<button onclick="loadMore("'.$newUrl.'")">Load more</button>';
		}
		echo $images;
	}
	
	if (isset($_POST['newUrl'])){
		$url = $_POST['newUrl'];
echo "This is new URL : ".$url;
			try {
				$curl_connection = curl_init($url);
				curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
				curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
		
				//Data are stored in $data
				$data[] = json_decode(curl_exec($curl_connection), true);
				curl_close($curl_connection);
				++$count;
			} catch(Exception $e) {
				return $e->getMessage();
			}		
		
	}
?>