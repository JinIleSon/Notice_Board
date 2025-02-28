<?

$con=mysql_connect("localhost","root","apmsetup");
mysql_select_db("comma",$con);

mysql_query("delete from boardreply where id=$id and wdate='$wdate'",$con);
echo("
	<script>
	window.alert('덧글이 삭제 되었습니다.');
	</script>
");


// 글 삭제 결과를 보여주기 위한 글 목록 보기 프로그램 호출
echo("<meta http-equiv='Refresh' content='0; url=content.php?board=$board&id=$id'>");

mysql_close($con);

?>