<?php
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
?>

<?php
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
?>

<span class="variable‑content"><?php echo $get_max_timestamp_return_value; ?></span>