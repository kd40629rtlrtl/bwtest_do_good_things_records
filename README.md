網頁功能:
將google表單填入的內容加入網頁

請參考 Php code整合進wordpress.docx
1.建立php snippet
安裝plugin “Insert PHP Code Snippet”
這個plugin 可以將php code包成短代碼插入文章中，可以用它來顯示mysql的內容，或是傳值給前端js

(補充:
目前php傳到前端js的方式
(參考https://tw.coderbridge.com/questions/468ecca5b66444a88555dd77b90bd3b2)
If the php variable is visible inside the inner HTML, you could do something like this to grab the variable:

HTML(這段包入php snippet):
<span class="variable content"><?php echo $variable; ?></span>

jQuery(js中插入):
var php_variable = $(".variable content").text();
alert(php_variable);

補充ends)

另外要注意的是，php snippet的短代碼間都是獨立的，變數不可共用。
步驟:“XYZ PHP Code”>”PHPCode Snippets”>”Add New PHP Code Snippet”
建立3個php snippet

a. get-max-timestamp
內容:php_snippets\get-max-timestamp.php
功能：用來抓取table中最新的timestamp
b. php-show-db
內容：php_snippets\php-show-db.php
功能：印出table中現有的資料(以表格的形式印出)，並產生超連結網址
c. new-page
內容：php_snippets\new-page.php
功能：點擊超連結後，載入新頁面的內容


2.建立文章
共要建立2個文章

a. PHP MYSQL Test
內容：文章/PHP MYSQL Test.html
功能：善行點滴主畫面，以及用來sync google sheet的資料(按f5即可重新sync)

b. New page !!文章網址要是http://testsite2.test/2022/10/18/new-page/，如果不是的話請將php snippet ”get-max-timestamp”中的 href(超連結)網址部分替換成新的網址
內容：文章/new_page.html
功能：善行點滴主畫面的連結都是連到這個文章

“新增文章”>”編輯”>右上角3個點按下去 >”程式碼編輯器”
把文章內容貼到第二個框中
 

3.Copy file to localhost folder
將這個file丟到 Laragon下的/www資料夾
test_insert_only_insert.php
內容：localhost\test_insert_only_insert.php
功能：用來接js POST的資料，然後插入table中

(補充：
目前js POST的方式
In js(20221018/文章/PHP MYSQL Test.html)
function doPost(time, author, title, short_description, content, pic_url, timestamp)
{
$.ajax({
    url: "test_insert_only_insert.php", 
    method: "POST", 
    //data: { "message":$('#input-message').val(),"sender":$('#sender').val(),"receiver":$('#receiver').val()},you can pass the values directly like this or else you can store it in variables and can pass
    data: {"time":time,"author":author,"title":title, "short_description":short_description,"content":content,"pic_url":pic_url, "timestamp":timestamp},
	success:function(msg){
	$('#result').html(msg);
	}
   });
}

In php(test_insert_only_insert.php)
<?php
	require_once 'db_cn.php';

	$sql="INSERT INTO bwtest (time,author,title,short_description,content,pic_url,timestamp)
	VALUES
	('$_POST[time]','$_POST[author]','$_POST[title]','$_POST[short_description]','$_POST[content]','$_POST[pic_url]','$_POST[timestamp]')";

	echo "sql=$sql\n";

	if (mysqli_query($con, $sql)) {
		echo "新记录插入成功";
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($con);
	}
	mysqli_close($con);
?>
補充ends)
 
===測試===
1.在mysql中建立database跟table
Laragon 主畫面 > “終端”

mysql –uroot
(進入mysql的shell)
CREATE DATABASE testsite;
USE testsite;
CREATE TABLE bwtest (time VARCHAR(64) NOT NULL, author VARCHAR(16) NOT NULL, title VARCHAR(64) NOT NULL, short_description VARCHAR(256) NOT NULL, content VARCHAR(512) NOT NULL, pic_url VARCHAR(256) NOT NULL, timestamp VARCHAR(32) NOT NULL);
 
2.LOAD data into mysql and fill the main/new page.
進入 PHP MYSQL Test 文章，
http://testsite2.test/2022/10/18/php-mysql-test/
這部分是從google抓出來的資料
 

看一下mysql是否有資料進入了
select author from bwtest;

PHP MYSQL Test 文章按下f5 refresh頁面，可以看到產生了圖文跟超連結
隨意點一個，就會產生新的頁面，裡面會有該善行的詳細資料。
 
3.Update data by google form
https://docs.google.com/forms/d/e/1FAIpQLSfwr6kIkICJOYSIm1B6z9waTCLjtn8LRcBZqt4C5Fb6lZPSmg/viewform
新增故事20 孝傳五世
 


更新前 最新的是 ”籠負母歸”
 
Refresh 這是從googel sheet中抓出更新的資料。
 
再 refresh “孝傳五世” 出現了
