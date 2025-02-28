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
 
$con=mysql_connect("localhost","root","apmsetup");
mysql_select_db("comma",$con);

$result=mysql_query("select * from boardreply where id=$id and wdate='$wdate'",$con);

// 수정하고자 하는 원본 게시물에서 수정 가능한 항목을 추출함
$id=mysql_result($result,0,"id");
$name=mysql_result($result,0,"name");
$wdate=mysql_result($result,0,"wdate");
$content=mysql_result($result,0,"content");
$passwd=mysql_result($result,0,"passwd");

echo("
	<form method=post action=rmprocess.php?board=$board&id=$id&wdate=$wdate>
	<table width=700 border=0>
	<tr>
	<td width=100 align=right>이름 </td>
	<td width=600><input type=text name=name size=7 value='$name'></td>
	</tr>
	<tr>
	<tr>
	<td align=right>덧글 </td>
	<td><input type=text name=content size=50 value=$content></td>
	</tr>
	<tr><td><br></td></tr>
	
	
	<tr>
	<td align=center colspan=2>
	<input type=submit value=수정하기>
	</td>
	</tr>
	</table>
	</form>");

mysql_close($con);

?>
