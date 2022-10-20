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
	$query = "SELECT * FROM bwtest ORDER BY timestamp"; //搜尋 *(全部欄位) ，從 表staff

	//mysqli_query << PHP 有很多種...指令(?) ，這是其中一個，我現在還都是學到甚麼用什麼，沒辦法自己看手冊，然後實驗+學習使用。 

	$query_run = mysqli_query($con,$query); //$con <<此變數來自引入的 db_cn.php
?>

<div class="container">
	<table class="table table-sm table-bordered"style="text-align:center;">
		<thead style="text-align:center;">
			<tr style="text-align:center;">
				<th>time</th>
				<th>author</th>
				<th>title</th>
				<th>short_description</th>
				<th>content</th>
				<th>pic_url</th>
				<th>timestamp</th>
			</tr>
		</thead>

		<tbody>
			<?php
				if(mysqli_num_rows($query_run) > 0)
				{
					foreach($query_run as $row)
					{
			?>
							<tr>
								<td><?php echo $row["time"]; ?></td> 
								<td><?php echo $row["author"]; ?></td> 
								<td><?php echo $row["title"]; ?></td>
								<td><?php echo $row["short_description"]; ?></td> 
								<td><?php echo $row["content"]; ?></td> 
								<td><?php echo $row["pic_url"]; ?></td>
								<td><?php echo $row["timestamp"]; ?></td>
							</tr>
							<!-- wp:image {"align":"full","sizeSlug":"large","className":"is-style-default"} -->
<figure class="wp-block-image alignfull size-large is-style-default"><img src="https://drive.google.com/uc?export=view&amp;id=<?php echo $row["pic_url"]; ?>" alt="<?php echo $row["short_description"]; ?>"/>
<br><a href="http://testsite2.test/2022/10/18/new-page/?title=<?php echo $row['title']; ?>"><?php echo $row["title"]; ?></a>
<figcaption><?php echo $row["short_description"]; ?></figcaption></figure><br><br><br>
							<!-- /wp:image -->
			<?php
					}
				}
			?>
		</tbody>
	</body>

</div>

<?php mysqli_close($con);?>