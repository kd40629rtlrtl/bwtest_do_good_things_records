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
		
		$sql="UPDATE bwtest SET author='$_POST[author]',short_description='$_POST[short_description]',title='$_POST[title]',content='$_POST[content]' WHERE random_string='$_POST[random_string]'";

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
	$query = "SELECT * FROM bwtest where random_string='$_GET[random_string]' "; //搜尋 *(全部欄位) ，從 表staff

	//mysqli_query << PHP 有很多種...指令(?) ，這是其中一個，我現在還都是學到甚麼用什麼，沒辦法自己看手冊，然後實驗+學習使用。 

	$query_run = mysqli_query($con,$query); //$con <<此變數來自引入的 db_cn.php
?>
<div class="container">
<meta charset="utf-8">
<?php
	if(mysqli_num_rows($query_run) > 0)
	{
		foreach($query_run as $row)
		{
?>
<!-- wp:heading -->
<h2><?php echo $row["title"]; ?></h2>
<!-- /wp:heading -->

<!-- wp:image {"align":"full","sizeSlug":"large","className":"is-style-default"} -->
<figure class="wp-block-image alignfull size-large is-style-default"><img src="https://drive.google.com/uc?export=view&amp;id=<?php echo $row["pic_url"]; ?>" alt="<?php echo $row["short_description"]; ?>" width="100%"/><figcaption><?php echo $row["short_description"]; ?></figcaption></figure>
<!-- /wp:image -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"100%"} -->
<div class="wp-block-column" style="flex-basis:100%"><!-- wp:paragraph {"align":"right"} -->
<p class="has-text-align-right"><?php echo $row["author"]; ?><sub> <?php echo $row["time"]; ?></sub><gwmw style="display:none;"></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<p><?php echo $row["content"]; ?></p>
<?php
		}
	}
?>
<html>
<body>
<meta charset="utf-8">
<label>資料修改</label>
<form method="post">
作者(字數限制:16):<br><input maxlength="16" type="text" name="author" value="<?php echo $row["author"]; ?>"></input><br>
標題(字數限制:64):<br><input maxlength="64" type="text" name="title" value="<?php echo $row["title"];?>"></input><br>
摘要(字數限制:256):<br><textarea maxlength="256" cols="80" maxlength="64" rows="5" name="short_description" ><?php echo $row["short_description"];?></textarea><br>
善行內容:(字數限制:1024)<br><textarea maxlength="1024" cols="80" rows="10" name="content"><?php echo $row["content"];?></textarea><br>
提交 <input type="submit" name="random_string" value="<?php echo $row['random_string'];?>"></input>
</form>

</body>
</html>

</div>

<?php mysqli_close($con);?>