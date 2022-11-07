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
<!-- wp:media-text {"align":"full","mediaType":"image","imageFill":true,"focalPoint":{"x":"0.63","y":"0.16"},"backgroundColor":"tertiary","className":"alignfull is-image-fill has-background-color has-text-color has-background has-link-color"} -->
<div class="wp-block-media-text alignfull is-stacked-on-mobile is-image-fill has-background-color has-text-color has-background has-link-color has-tertiary-background-color"><figure class="wp-block-media-text__media" style="background-image:url(https://drive.google.com/uc?export=view&amp;id=<?php echo $row["pic_url"]; ?>);background-position:63% 16%"><img src="https://drive.google.com/uc?export=view&amp;id=<?php echo $row["pic_url"]; ?>" alt=""/></figure><div class="wp-block-media-text__content"><!-- wp:spacer {"height":"32px"} -->
<div style="height:32px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:heading {"style":{"typography":{"fontWeight":"300","lineHeight":"1.115","fontSize":"clamp(3rem, 6vw, 4.5rem)"}},"textColor":"foreground"} -->
<h2 class="has-foreground-color has-text-color" style="font-size:clamp(3rem, 6vw, 4.5rem);font-weight:300;line-height:1.115"><?php echo $row["title"]; ?></h2>
<!-- /wp:heading -->

<!-- wp:preformatted {"textColor":"foreground"} -->
<pre class="wp-block-preformatted has-foreground-color has-text-color"><?php echo $row["author"]; ?><sub><?php echo $row["time"]; ?></sub></pre>
<!-- /wp:preformatted -->

<!-- wp:paragraph {"style":{"typography":{"lineHeight":"1.6"}},"textColor":"foreground"} -->
<p class="has-foreground-color has-text-color" style="line-height:1.6"><?php echo $row["content"]; ?></p>
<!-- /wp:paragraph -->

<!-- wp:site-logo {"width":60} /-->

<!-- wp:group {"style":{"spacing":{"padding":{"right":"min(8rem, 5vw)","top":"min(28rem, 28vw)"}}}} -->
<div class="wp-block-group" style="padding-top:min(28rem, 28vw);padding-right:min(8rem, 5vw)"><!-- wp:spacer {"height":"40px"} -->
<div style="height:40px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer --></div>
<!-- /wp:group -->

<!-- wp:spacer {"height":"32px"} -->
<div style="height:32px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer --></div></div>
<!-- /wp:media-text -->
<?php
			}//直向image
?>

<?php
		}
	}
?>

<a href="http://testsite2.test/2022/10/21/善行點滴">回善行點滴主畫面</a>

<meta charset="utf-8">
<?php mysqli_close($con);?>