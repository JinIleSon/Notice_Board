<?
echo ("
	<link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">
	<link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>
	<link href=\"https://fonts.googleapis.com/css2?family=Hi+Melody&family=Sunflower:wght@300&display=swap\" rel=\"stylesheet\">
	<style type='text/css'>
		table {
			
			font-family: 'Hi Melody', cursive;
			font-family: 'Sunflower', sans-serif;
			font-size:17px;
		}
		h1 {
			font-family: 'Hi Melody', cursive;
			font-family: 'Sunflower', sans-serif;
			
		}
		input {
			font-family: 'Hi Melody', cursive;
			font-family: 'Sunflower', sans-serif;
		}
	</style>
");
 
if (!$key) {
	echo("<script>
		window.alert('검색어를 입력하세요');
		history.go(-1);
		</script>");
	exit;
}
echo ("<style type='text/css'>
		table {border-collapse:collapse;
			border-right:none;       
			border-left:none;
			
		}
	</style>
");

echo ("<center> 
	<style>
		table {border-collapse:collapse;}
		a {text-decoration:none;}
	</style>
");

$con = mysql_connect("localhost","root","apmsetup");
mysql_select_db("comma",$con);
$result=mysql_query("select * from $board where $field like '%$key%' order by id desc",$con);
$total = mysql_num_rows($result);

echo("
   <table border=0 width=700>
   <tr><td align=center colspan=2><h1>게시판</h1></td><tr>
   <tr><td>검색어:$key , 찾은 개수:$total 개</td>
   <td align=right>&nbsp;&nbsp;&nbsp;<a href=show.php?board=$board><img src='catalog.png' width=25 height=25></a></td></tr>
   </table>
");

echo("
   <table border=1 width=700>
   <tr bgcolor=#6C788C><td align=center width=50 style='padding:10px;'><b><font color=white>번호</font></b></td>
   <td align=center width=100 style='padding:10px;'><b><font color=white>작성자</font></b></td>
   <td align=center width=400 style='padding:10px;'><b><font color=white>제목</font></b></td>
   <td align=center width=150 style='padding:10px;'><b><font color=white>작성일</font></b></td>
   <td align=center width=50 style='padding:10px;'><b><font color=white>조회</font></b></td>
   </tr>
");

if (!$total){
	echo("<tr><td colspan=5 align=center>검색된 글이 없습니다.</td></tr>");
} else {

	$counter=0;

	while($counter<$total):

		$id=mysql_result($result,$counter,"id");
		$writer=mysql_result($result,$counter,"writer");
		$topic=mysql_result($result,$counter,"topic");
		$hit=mysql_result($result,$counter,"hit");
		$wdate=mysql_result($result,$counter,"wdate");
		$space=mysql_result($result,$counter,"space");
		$filename=mysql_result($result,$counter,"filename");
		
		$t="";

		if   ($space>0) {
			for ($i=0 ;   $i<=$space ; $i++)
			$t=$t .  "&nbsp;";	// $space > 0 인 경우 제목 앞에 공백 추가
		}

		$result2 = mysql_query("select * from boardreply where id=$id", $con);
		$total2 = mysql_num_rows($result2);
		if (!$filename) {
			if (!$total2) {
				echo("
					<tr onmouseover=\"this.style.color='white'; this.style.background='#BDBDBD';\" onmouseout=\"this.style.color='black';this.style.background='';\"><td align=center style='padding:10px;'>$id</td>
					<td align=center style='padding:10px;'>$writer</td>
					<td align=left style='padding:10px;'>$t<a href=content.php?board=$board&id=$id onmouseover=\"this.style.color='white';\" onmouseout=\"this.style.color='blue';\">$topic</a></td>
					<td align=center style='padding:10px;'>$wdate</td><td align=center>$hit</td>
					</tr>
				");
			} else {
				echo("
					<tr onmouseover=\"this.style.color='white'; this.style.background='#BDBDBD';\" onmouseout=\"this.style.color='black';this.style.background='';\"><td align=center style='padding:10px;'>$id</td>
					<td align=center style='padding:10px;'>$writer</td>
					<td align=left style='padding:10px;'>$t<a href=content.php?board=$board&id=$id onmouseover=\"this.style.color='white';\" onmouseout=\"this.style.color='blue';\">$topic [$total2]</a></td>
					<td align=center style='padding:10px;'>$wdate</td><td align=center>$hit</td>
					</tr>
				");
			}
		} else {
			if (!$total2) {
				echo("
					<tr onmouseover=\"this.style.color='white'; this.style.background='#BDBDBD';\" onmouseout=\"this.style.color='black';this.style.background='';\"><td align=center style='padding:10px;'>$id</td>
					<td align=center style='padding:10px;'>$writer</td>
					<td align=left style='padding:10px;'>$t<a href=content.php?board=$board&id=$id onmouseover=\"this.style.color='white';\" onmouseout=\"this.style.color='blue';\">$topic <img width=15 height=15 src='floppy2.png'/></a></td>
					<td align=center style='padding:10px;'>$wdate</td><td align=center style='padding:10px;'>$hit</td>
					</tr>
				");
			} else {
				echo("
					<tr onmouseover=\"this.style.color='white'; this.style.background='#BDBDBD';\" onmouseout=\"this.style.color='black';this.style.background='';\"><td align=center style='padding:10px;'>$id</td>
					<td align=center style='padding:10px;'>$writer</td>
					<td align=left style='padding:10px;'>$t<a href=content.php?board=$board&id=$id onmouseover=\"this.style.color='white';\" onmouseout=\"this.style.color='blue';\">$topic [$total2] <img width=15 height=15 src='floppy2.png'/></a></td>
					<td align=center style='padding:10px;'>$wdate</td><td align=center style='padding:10px;'>$hit</td>
					</tr>
				");
			}
		}
		$counter = $counter + 1;

	endwhile;


	echo("</table></center>");
}

mysql_close($con);

?>