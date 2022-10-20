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
