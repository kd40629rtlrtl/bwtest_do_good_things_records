<?php
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

	$db_host = "127.0.0.1";
	$db_username = "root";
	$db_password = "";
	$database = "testsite"; //因為是本地測試，改這一段就好(輸入你指定的資料庫名稱，我指定test_2021，如下圖)

	$con = mysqli_connect("$db_host", "$db_username", "$db_password", "$database");

	if(!$con)
	{
		die("連線失敗!!!!!");
		echo("連線失敗!!!!!");

		$ssql = "set names utf8";
		mysqli_query($con,$ssql);
	}
	else echo("連線成功!!!!!");

	$get_max_timestamp_query = "SELECT MAX(timestamp) FROM bwtest";

	$get_max_timestamp_query_run = mysqli_query($con,$get_max_timestamp_query); //$con <<此變數來自引入的 db_cn.php
	$get_max_timestamp_return_value="*";
	
	if(mysqli_num_rows($get_max_timestamp_query_run) > 0)
	{
		foreach($get_max_timestamp_query_run as $get_max_timestamp_row)
		{
			$get_max_timestamp_return_value = $get_max_timestamp_row["MAX(timestamp)"];
		}
	}
	if ($get_max_timestamp_return_value == NULL) $get_max_timestamp_return_value=0;

	echo "get_max_timestamp_return_value=";
	echo $get_max_timestamp_return_value;
	
	// Initialize URL to the variable
	$url = 'https://script.google.com/macros/s/AKfycbylmom2I5Qqi9sTTs2dGNaJh31rKtZO-ysiWv7Ln1t-PNLg11pbRfJxDIb0kjp03Kf4/exec?timestamp='.$get_max_timestamp_return_value;

	// Use parse_url() function to parse the URL
	// and return an associative array which
	// contains its various components
	$json = file_get_contents($url);

	$obj = json_decode($json,true);

	foreach($obj as $row_idx => $row) {
		$time = $row["dataload"][0];
		$author = $row["dataload"][1];
		$title = $row["dataload"][2];
		$short_description = $row["dataload"][3];
		$content = $row["dataload"][4];
		sscanf($row["dataload"][5], "https://drive.google.com/open?id=%s", $pic_url);
		$timestamp=strtotime($row["dataload"][0])*1000;

		echo $row["dataload"][0];
		echo $row["dataload"][1];
		//echo $row["dataload"][2];
		//echo $row["dataload"][3];
		//echo $row["dataload"][4];
		//echo $row["dataload"][5]."<br>";
		echo $timestamp;
		echo "<br>";
		
		if($row_idx != 0) {
			$random_string=generateRandomString();
			$visible = "0";
			$sql="INSERT INTO bwtest (time,author,title,short_description,content,pic_url,timestamp, random_string, visible)
			VALUES
			('$time','$author','$title','$short_description','$content','$pic_url','$timestamp','$random_string','$visible')";
			if (mysqli_query($con, $sql)) {
				echo "新记录插入成功";
			} else {
				echo "Error: " . $sql . "<br>" . mysqli_error($con);
			}
		}
	}
	mysqli_close($con);
?>


