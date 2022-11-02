<style>
img.a {
  width: 240px;
  height: 180px;
  object-fit: cover;
}
</style>

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
	function set_visible() {
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

		$query = "SELECT visible FROM bwtest WHERE random_string='$_POST[random_string]'";

		$query_run = mysqli_query($con,$query); //$con <<此變數來自引入的 db_cn.php
		$return_value="0";

		if(mysqli_num_rows($query_run) > 0)
		{
			foreach($query_run as $row)
			{
				$return_value = $row["visible"];
			}
		}

		if($return_value == "0")
			$sql="UPDATE bwtest SET visible='1' WHERE random_string='$_POST[random_string]'";
		else
			$sql="UPDATE bwtest SET visible='0' WHERE random_string='$_POST[random_string]'";
		echo "sql=$sql\n";

		if (mysqli_query($con, $sql)) {
			echo "新记录插入成功";
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($con);
		}
		mysqli_close($con);
	}

	if(array_key_exists('random_string', $_POST)) {
		set_visible();
	}
?>

<?php
	$query = "SELECT * FROM bwtest ORDER BY timestamp DESC"; //搜尋 *(全部欄位) ，從 表staff

	//mysqli_query << PHP 有很多種...指令(?) ，這是其中一個，我現在還都是學到甚麼用什麼，沒辦法自己看手冊，然後實驗+學習使用。 

	$query_run = mysqli_query($con,$query); //$con <<此變數來自引入的 db_cn.php
?>
			<?php
				if(mysqli_num_rows($query_run) > 0)
				{
					$column_idx=0;
					foreach($query_run as $row)
					{
						if($column_idx == 0)
						{
			?>
<!-- wp:group {"align":"wide"} -->
<div class="wp-block-group alignwide"><!-- wp:columns {"verticalAlignment":"top","align":"full","style":{"color":{"text":"#000000","background":"#ffffff"}}} -->
<div class="wp-block-columns alignfull are-vertically-aligned-top has-text-color has-background" style="background-color:#ffffff;color:#000000">
			<?php
						}
			?>
<!-- wp:column {"verticalAlignment":"top"} -->
<div class="wp-block-column is-vertically-aligned-top"><!-- wp:image {"sizeSlug":"large"} -->
<form method="post">內容:<?php if($row['visible']=="0"){echo "隱藏";}else{echo "可見";} ?> <input type="submit" name="random_string" value="<?php echo $row['random_string']; ?>"/></form>
<?php
						if($row['visible'] == "0")
						{
?>
<a href="http://testsite2.test/2022/11/01/new-page-admin/?random_string=<?php echo $row['random_string']; ?>" style="color:gray;">
<?php					}
						else
						{?>
<a href="http://testsite2.test/2022/11/01/new-page-admin/?random_string=<?php echo $row['random_string']; ?>">
<?php					}?>
<figure class="wp-block-image size-large"><img class="a" src="https://drive.google.com/uc?export=view&amp;id=<?php echo $row["pic_url"]; ?>" alt=""/><figcaption><gwmw style="display:none;"><gwmw style="display:none;"></gwmw><gwmw style="display:none;"></figcaption></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"24px","lineHeight":"1.3"}}} -->
<h3 style="font-size:24px;line-height:1.3;width: 240px; word-break: break-all;word-wrap: break-word;"><strong><?php echo $row["title"]; ?></strong></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php echo $row["time"]; ?></p>
<p style="width: 240px; word-break: break-all;word-wrap: break-word;"><?php echo $row["short_description"]; ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->
</a>
			<?php
						if($column_idx == 3) //結尾
						{
			?>
</div>
			<?php
						}
						else //column 間空白
						{
			?>
&emsp;
&emsp;
			<?php
						}

						if($column_idx<3) $column_idx++;
						else $column_idx=0;
					}
					if($column_idx != 0) //如果4個column排不滿，要多塞隱形的column來維持版面
					{
						for($idx=$column_idx; $idx<4; $idx++) //因為離開前一個loop時有++，所以前一個loop column_idx=0的在這邊代表column_idx=1，就是只印了一個column，那代表右邊要多塞3個隱形的column
						{
			?>
<div style="visibility:hidden">
<form method="post">內容:<?php if($row['visible']=="0"){echo "隱藏";}else{echo "可見";} ?> <input type="submit" name="random_string" value="<?php echo $row['random_string']; ?>"/></form>
<a href="http://testsite2.test/2022/11/01/new-page-admin/?random_string=<?php echo $row['random_string']; ?>">
<!-- wp:column {"verticalAlignment":"top"} -->
<div class="wp-block-column is-vertically-aligned-top"><!-- wp:image {"sizeSlug":"large"} -->
<figure class="wp-block-image size-large"><img class="a" src="https://drive.google.com/uc?export=view&amp;id=<?php echo $row["pic_url"]; ?>" alt=""/><figcaption><gwmw style="display:none;"><gwmw style="display:none;"><gwmw style="display:none;"></gwmw></gwmw></gwmw></figcaption></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"24px","lineHeight":"1.3"}}} -->
<h3 style="font-size:24px;line-height:1.3"><strong><?php echo $row["title"]; ?></strong></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php echo $row["time"]; ?></p>
<p style="width: 240px; word-break: break-all;word-wrap: break-word;"><?php echo $row["short_description"]; ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->
</a>
</div>
			<?php
							if($idx<3) //column 間空白
							{
			?>
&emsp;
&emsp;
			<?php
							}
						}
					}
			?>
</div>
<!-- /wp:columns -->
<!-- /wp:group -->
			<?php
				}
			?>
<?php mysqli_close($con);?>