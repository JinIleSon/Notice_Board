<?

$con=mysql_connect("localhost","root","apmsetup");
mysql_select_db("comma",$con);
$result=mysql_query("select passwd from $board where id=$id",$con);
$passwd=mysql_result($result,0,"passwd");

if ($pass != $passwd) {            // 암호가 일치하지 않는 경우
	echo   ("<script>
		window.alert('입력 암호가 일치하지 않네요');
		history.go(-1);
		</script>");
	exit;		
} else {                  // 암호가 일치하는 경우
    switch ($mode) {
        case 0:          // 수정 프로그램 호출
            echo("<meta   http-equiv='Refresh' content='0; url=modify.php?board=$board&id=$id'>");
            break;
        case 1:          // 삭제 프로그램 호출
            echo("<meta   http-equiv='Refresh' content='0; url=delete.php?board=$board&id=$id'>");
            break;
    }   	   
}

mysql_close($con);

?>