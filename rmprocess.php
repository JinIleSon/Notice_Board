<?

if (!$name){
	echo("
		<script>
		window.alert('이름이 없습니다. 다시 입력하세요')
		history.go(-1)
		</script>
	");
	exit;
}

if (!$content){
	echo("
		<script>
		window.alert('내용이 없습니다. 다시 입력하세요')
		history.go(-1)
		</script>
	");
	exit;
}

$con = mysql_connect("localhost","root","apmsetup");
mysql_select_db("comma",$con);
$result = mysql_query("select * from boardreply where id=$id and wdate='$wdate'", $con);

$wdate2 = date("Y-m-d-H:i:s");	//글 수정한 날짜 저장

// 변경 내용을 테이블에 저장함
mysql_query("update boardreply set name='$name', content='$content', wdate='$wdate2' where id=$id and wdate='$wdate'", $con);



echo("<meta http-equiv='Refresh' content='0; url=content.php?board=$board&id=$id'>");

mysql_close($con);

?>