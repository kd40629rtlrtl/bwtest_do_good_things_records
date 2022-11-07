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
	$query = "SELECT * FROM bwtest where random_string='$_GET[random_string]' "; //搜尋 *(全部欄位) ，從 表staff

	//mysqli_query << PHP 有很多種...指令(?) ，這是其中一個，我現在還都是學到甚麼用什麼，沒辦法自己看手冊，然後實驗+學習使用。 

	$query_run = mysqli_query($con,$query); //$con <<此變數來自引入的 db_cn.php
?>

<meta charset="utf-8">
<?php
	if(mysqli_num_rows($query_run) > 0)
	{
		foreach($query_run as $row)
		{
?>

<?php
			$url = "https://drive.google.com/uc?id=".$row["pic_url"];
			$imageData = base64_encode(file_get_contents($url));
			list($img_width, $img_height) = getimagesizefromstring(file_get_contents($url));

			if($img_width > $img_height) { //橫向image
?>
<div class="container">
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
</div>
<?php 
			} //橫向image
			else
			{//直向image
?>
<!-- wp:group {"align":"full","layout":{"inherit":true,"type":"constrained"}} -->
<div class="wp-block-group alignfull"><!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":"5%"}}} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"width":"70%"} -->
<div class="wp-block-column" style="flex-basis:70%"><!-- wp:heading {"level":1,"align":"wide","style":{"typography":{"fontSize":"clamp(3rem, 6vw, 4.5rem)"},"spacing":{"margin":{"bottom":"0px"}}}} -->
<h1 class="alignwide" style="margin-bottom:0px;font-size:clamp(3rem, 6vw, 4.5rem)"><?php echo $row["title"]; ?></h1>
<!-- /wp:heading --></div>
<!-- /wp:column -->

<!-- wp:column {"width":""} -->
<div class="wp-block-column"></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":"5%"}}} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"width":"40%","style":{"spacing":{"padding":{"bottom":"0px","top":"0"}}},"fontSize":"medium"} -->
<div class="wp-block-column has-medium-font-size" style="padding-top:0;padding-bottom:0px;flex-basis:40%"><!-- wp:image {"align":"left","id":130,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image alignleft size-full"><img src="https://drive.google.com/uc?export=view&amp;id=<?php echo $row["pic_url"]; ?>"alt="" class="wp-image-130"/><figcaption class="wp-element-caption"><?php echo $row["short_description"]; ?></figcaption></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"width":""} -->
<div class="wp-block-column"><!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:spacer {"height":"16px"} -->
<div style="height:16px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer --></div>
<!-- /wp:group -->

<!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="has-large-font-size"><?php echo $row["author"]; ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php echo $row["time"]; ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="has-large-font-size"><?php echo $row["content"]; ?></h3>
<!-- /wp:heading -->

<!-- wp:spacer {"height":"16px"} -->
<div style="height:16px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
<?php
			}//直向image
?>

<?php
		}
	}
?>

<a href="http://testsite2.test/2022/10/21/善行點滴">回善行點滴主畫面</a>


<?php mysqli_close($con);?>