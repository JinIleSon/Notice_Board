<?

if(!$writer){
	echo("
		<script>
		window.alert('이름이 없습니다. 다시 입력하세요.')
		history.go(-1)
		</script>
	");
	exit;
}

$con=mysql_connect("localhost","root","apmsetup");
mysql_select_db("comma",$con);

// 답변 글은 원본 글보다 깊이가 1 증가됨
$result=mysql_query("select space from $board where id=$id", $con);
$space=mysql_result($result, 0, "space");
$space=$space+1;

$wdate=date("Y-m-d"); // 단변 글을 쓴 날짜 저장

//파일 처리 루틴
if ($userfile) {	
   $savedir = "./pds";	//첨부 파일이 저장될 폴더
   $temp = $userfile_name;
   copy($userfile, "$savedir/$temp");
   unlink($userfile);
}

// 답변글이 추가되면 글의 개수가 하나 증가하므로 글 번호를 정리
$tmp = mysql_query("select id from $board", $con);
$total = mysql_num_rows($tmp);

while($total >= $id):
	mysql_query("update $board set id=id+1 where id=$total", $con);
	mysql_query("update boardreply set id=id+1 where id=$total", $con);
	$total--;
endwhile;

// 원래 글 번호 위치에 답변 글을 삽입함
mysql_query("insert into   $board(id, writer, passwd, topic, content, hit, wdate, space, filename, filesize) values ($id, '$writer', '$passwd', '$topic','$content', 0, '$wdate', $space, '$userfile_name', '$userfile_size')", $con);

mysql_close($con);

echo("<meta http-equiv='Refresh' content='0; url=show.php?board=$board'>");

?>