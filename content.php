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
 
echo ("
	<style>
		table { border-collapse:collapse; }
		a {text-decoration:none;}
	</style>
");
$con=mysql_connect("localhost","root","apmsetup");
mysql_select_db("comma",$con);
$result=mysql_query("select * from $board where id=$id",$con);

// 각 필드에 해당하는 데이터를 뽑아 내는 과정
$id=mysql_result($result,0,"id");
$writer=mysql_result($result,0,"writer");
$topic=mysql_result($result,0,"topic");
$hit=mysql_result($result,0,"hit");
$filename = mysql_result($result, 0, "filename");
$filesize = mysql_result($result, 0, "filesize");

$hit = $hit +1;   //조회수를 하나 증가
mysql_query("update $board set hit=$hit where id=$id",$con);

$wdate=mysql_result($result,0,"wdate");

$content=mysql_result($result,0,"content");

if ($filesize > 1000) {
	$kb_filesize =   (int)($filesize / 1000);
	$disp_size = $kb_filesize . ' KBytes';
} else {
		$disp_size = $filesize . ' Bytes';
	}

// 테이블로부터 읽은 내용을 화면에 디스플레이
echo("<center>
	<table border=0 width=700>
	<tr><td align=center><h1>게시판</h1></td></tr>
	</table>

	<table border=1 width=700 style='border-right:none;border-left:none;'>
	<tr bgcolor=#E1E1E1>
	<td colspan=4 style='padding:10px;'><b>제목</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $topic</td>
	</tr>
	<tr>
	<td width=200 style='padding:10px;'>작성자&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href=mailto:$email>$writer</a></td>
	<td align=center width=300 style='padding:10px;'>작성일&nbsp; $wdate</td>
	<td width=100 style='padding:10px;'>번호&nbsp; $id</td>
	<td width=100 style='padding:10px;'>조회수&nbsp; $hit</td>
	</tr>
	");
	if ($filename != '') {
		echo("
			<tr>
			<td colspan=4 style='padding:10px'><b>파일</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img width=15 height=15 src='floppy2.png'/> &nbsp<a href=./pds/$filename>$filename</a> [$disp_size]</td>
			</tr>
		");
	}
$con=mysql_connect("localhost","root","apmsetup");
mysql_select_db("comma",$con);
$result=mysql_query("select * from $board where id=$id",$con);
$filename = mysql_result($result, 0, "filename");

list($filename1, $filename2) = explode(".",$filename);


echo ("
	<tr height=200>
");
if ($filename2 == 'jpg' || $filename2 == 'png') {
	echo ("<td colspan=4 align=center><img src=$filename><pre>$content</pre></td>");
} else {
	echo ("<td colspan=4><pre>$content</pre></td>");
}
echo ("
	</tr>
	</table>

	<table   border=0 width=700>
	<tr>
	
	<td align=right height=50>
	<a href=input.php?board=$board><img src='pencil.png' width=25 height=25>&nbsp;</a>
	<a href=pass.php?board=$board&id=$id&mode=0><img src='change.png' width=25 height=25>&nbsp;</a> 
	<a href=pass.php?board=$board&id=$id&mode=1><img src='delete.png' width=25 height=25>&nbsp;</a> 
	<a href=reply.php?board=$board&id=$id><img src='qna.png' width=25 height=25>&nbsp;</a> 
	<a href=show.php?board=$board><img src='catalog.png' width=25 height=25>&nbsp;</a>
	</td></tr>
	</table>
");
?>
<?
	echo ("<br>");
	
	$result =   mysql_query("select * from boardreply where id=$id", $con);

	$total =   mysql_num_rows($result);
	if (!$total)   {
	echo ("
		<table width=700><tr><td align=center>아직 등록된 글이 없습니다<br></td></tr></table>");
	echo ("
		<table border=0 width=700>
			<tr>
				<td>
					덧글 <font color='red'>$total</font> 개
				</td>
			</tr>
	");
	} else {
		$i = 0;
		echo ("
		<table border=0 width=700>
			<tr>
				<td>
					덧글 <font color='red'>$total</font> 개
				</td>
			</tr>
		");
		while ($i < $total):
			$id = mysql_result($result, $i, "id");
			$name = mysql_result($result, $i, "name");
			$wdate = mysql_result($result, $i, "wdate");
			$content = mysql_result($result, $i, "content");
			$passwd = mysql_result($result, $i, "passwd");
			
			echo ("
				<table border=1 width=700>
					<tr height=70>
						<td width=100 align=center style='border-right:hidden;'>$name</td>
						<td width=500 style='border-right:hidden;padding-bottom:10px;'><font size=2>$wdate</font> <br><br> $content</td>
						<td width=100 align=center><a href=rpass.php?board=$board&id=$id&mode=0&wdate=$wdate>수정</a> | <a href=rpass.php?board=$board&id=$id&mode=1&wdate=$wdate>삭제</a></td>
					</tr>
				</table>
				
			");
			$i++;
		endwhile;
	}
	echo ("
		<br>
		<form action=memo.php?board=$board&id=$id method=post>
		<table border=1 width=700 height=70>
			<tr>
				<td align=center style='border-right:hidden;'>
					이름<br>
					<input type=text size=8 name=wname>
				</td>
				<td colspan=2 align=center style='border-right:hidden;'>
					<textarea name=wmemo rows=3 cols=60></textarea>
					
				</td>
				<td align=center style='border-right:hidden;'>
					암호<br>
					<input type=password name=passwd size=8>
				</td>
				<td align=center>
					<input type=submit value='등록'>
				</td>
			</tr>
	
	
	
		</table>
		
		<br>
	");
	$pid = $id-1;
	$aid = $id+1;
	$con = mysql_connect("localhost","root","apmsetup");
	mysql_select_db("comma",$con);
	$aaresult = mysql_query("select * from $board order by id desc", $con);
	$aaid = mysql_result($aaresult, 0, "id");
	$ppresult = mysql_query("select * from $board order by id", $con);
	$ppid = mysql_result($ppresult, 0, "id");
	$ppid = $ppid - 1;
	$aaid = $aaid + 1;
	if ($ppid != $pid) {
		$presult = mysql_query("select * from $board where id=$pid", $con);
		$ptopic = mysql_result($presult, 0, "topic");
		echo ("
			<table border=1 width=700>
		");
		if ($aaid != $aid) {
			echo ("<tr style='border-top: 2px solid; border-bottom:none; border-left:none; border-right:none;'>");
		} else {
			echo ("<tr style='border-top: 2px solid; border-left:none; border-right:none; border-bottom:2px solid;'>");
		}
		echo ("
			<td style='padding:15px;'>
			<a href=content.php?board=$board&id=$pid>&nbsp;&nbsp;이전글 &nbsp;▲ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$ptopic</a>
			</td>
			</tr>
			</table>
	");
	}
	if ($aaid != $aid) {
		$aresult = mysql_query("select * from $board where id=$aid", $con);
		$atopic = mysql_result($aresult, 0, "topic");
		echo ("
			<table border=1 width=700>
		");
		if ($ppid != $pid) {
			echo ("<tr style='border-bottom:2px solid; border-left:none; border-right:none; border-top:1px solid #BDBDBD;'>");
		} else {
			echo ("<tr style='border-bottom:2px solid; border-left:none; border-right:none; border-top:2px solid;'>");
		}
		echo ("
			<td style='padding:15px;'>
			<a href=content.php?board=$board&id=$aid>&nbsp;&nbsp;다음글 &nbsp;▼ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$atopic</a>
			</td>
			</tr>
			</table>
		");
	}
?>
<?
 
$con = mysql_connect("localhost","root","apmsetup");
mysql_select_db("comma",$con);
$result = mysql_query("select * from $board order by id desc", $con);
$total = mysql_num_rows($result);

echo ("<style>
		table {border-collapse:collapse;}
	</style>
");

echo("
	
	<br>
	<table border=1 width=700 
			style='border-right:none;       
			border-left:none;'>
	<tr bgcolor=#6C788C><td align=center width=50 style='padding:10px;'><b><font color=white>번호</font></b></td>
	<td align=center width=100 style='padding:10px;'><b><font color=white>작성자</font></b></td>
	<td align=center width=400 style='padding:10px;'><b><font color=white>제목</font></b></td>
	<td align=center width=150 style='padding:10px;'><b><font color=white>작성일</font></b></td>
	<td align=center width=50 style='padding:10px;'><b><font color=white>조회</font></b></td>
	</tr>
");

if (!$total){
	echo("
		<tr><td colspan=5 align=center>아직 등록된 글이 없습니다.</td></tr>
	");
} else {

	if   ($cpage=='') $cpage=1;    // $cpage -  현재 페이지 번호
	$pagesize = 5;                // $pagesize - 한 페이지에 출력할 목록 개수

	$totalpage = (int)($total/$pagesize);
	if (($total%$pagesize)!=0) $totalpage = $totalpage + 1;

	$counter=0;

	while($counter<$pagesize):
		$newcounter=($cpage-1)*$pagesize+$counter;
		if ($newcounter == $total) break;
		
		$aid=mysql_result($result,$newcounter,"id");
		$writer=mysql_result($result,$newcounter,"writer");
		$topic=mysql_result($result,$newcounter,"topic");
		$hit=mysql_result($result,$newcounter,"hit");
		$wdate=mysql_result($result,$newcounter,"wdate");
		$space=mysql_result($result,$newcounter,"space");
		$filename=mysql_result($result,$newcounter,"filename");
		$t="";

		if   ($space>0) {
			for ($i=0 ; $i<=$space ; $i++)
				$t = $t . "&nbsp;";     // 답변 글의 경우 제목 앞 부분에 공백을 채움
		}
		
		$result2 = mysql_query("select * from boardreply where id=$aid", $con);
		$total2 = mysql_num_rows($result2);
		
		if ($id == $aid) {
			if (!$filename) {
				if (!$total2) {
					echo("
					<tr bgcolor=#B3B9C4><td align=center style='padding:10px;'>→ $aid</td>
					<td align=center style='padding:10px;'>$writer</td>
					<td align=left style='padding:10px;'>$t<a href=content.php?board=$board&id=$aid>$topic</a></td>
					<td align=center style='padding:10px;'>$wdate</td><td align=center style='padding:10px;'>$hit</td>
					</tr>
					");
				} else {
					echo("
					<tr bgcolor=#B3B9C4><td align=center style='padding:10px;'>→ $aid</td>
					<td align=center style='padding:10px;'>$writer</td>
					<td align=left style='padding:10px;'>$t<a href=content.php?board=$board&id=$aid>$topic [$total2]</a></td>
					<td align=center style='padding:10px;'>$wdate</td><td align=center style='padding:10px;'>$hit</td>
					</tr>
					");
				}
			} else {
				if (!$total2) {
					echo("
					<tr bgcolor=#B3B9C4><td align=center style='padding:10px;'>→ $aid</td>
					<td align=center style='padding:10px;'>$writer</td>
					<td align=left style='padding:10px;'>$t<a href=content.php?board=$board&id=$aid>$topic <img width=15 height=15 src='floppy2.png'/></a></td>
					<td align=center style='padding:10px;'>$wdate</td><td align=center style='padding:10px;'>$hit</td>
					</tr>
					");
				} else {
					echo("
					<tr bgcolor=#B3B9C4><td align=center style='padding:10px;'>→ $aid</td>
					<td align=center style='padding:10px;'>$writer</td>
					<td align=left style='padding:10px;'>$t<a href=content.php?board=$board&id=$aid>$topic [$total2] <img width=15 height=15 src='floppy2.png'/></a></td>
					<td align=center style='padding:10px;'>$wdate</td><td align=center style='padding:10px;'>$hit</td>
					</tr>
					");
				}
			}
		} else {
			if (!$filename) {
				if (!$total2) {
					echo("
						<tr onmouseover=\"this.style.color='white'; this.style.background='#BDBDBD';\" onmouseout=\"this.style.color='black';this.style.background='';\"><td align=center style='padding:10px;'>$aid</td>
						<td align=center style='padding:10px;'>$writer</td>
						<td align=left style='padding:10px;'>$t<a href=content.php?board=$board&id=$aid onmouseover=\"this.style.color='white';\" onmouseout=\"this.style.color='blue';\">$topic</a></td>
						<td align=center style='padding:10px;'>$wdate</td><td align=center style='padding:10px;'>$hit</td>
						</tr>
					");
				} else {
					echo("
						<tr onmouseover=\"this.style.color='white'; this.style.background='#BDBDBD';\" onmouseout=\"this.style.color='black';this.style.background='';\"><td align=center style='padding:10px;'>$aid</td>
						<td align=center style='padding:10px;'>$writer</td>
						<td align=left style='padding:10px;'>$t<a href=content.php?board=$board&id=$aid onmouseover=\"this.style.color='white';\" onmouseout=\"this.style.color='blue';\">$topic [$total2]</a></td>
						<td align=center style='padding:10px;'>$wdate</td><td align=center style='padding:10px;'>$hit</td>
						</tr>
					");
				}
			} else {
				if (!$total2) {
					echo("
						<tr onmouseover=\"this.style.color='white'; this.style.background='#BDBDBD';\" onmouseout=\"this.style.color='black';this.style.background='';\"><td align=center style='padding:10px;'>$aid</td>
						<td align=center style='padding:10px;'>$writer</td>
						<td align=left style='padding:10px;'>$t<a href=content.php?board=$board&id=$aid onmouseover=\"this.style.color='white';\" onmouseout=\"this.style.color='blue';\">$topic <img width=15 height=15 src='floppy2.png'/></a></td>
						<td align=center style='padding:10px;'>$wdate</td><td align=center style='padding:10px;'>$hit</td>
						</tr>
					");
				} else {
					echo("
						<tr onmouseover=\"this.style.color='white'; this.style.background='#BDBDBD';\" onmouseout=\"this.style.color='black';this.style.background='';\"><td align=center style='padding:10px;'>$aid</td>
						<td align=center style='padding:10px;'>$writer</td>
						<td align=left style='padding:10px;'>$t<a href=content.php?board=$board&id=$aid onmouseover=\"this.style.color='white';\" onmouseout=\"this.style.color='blue';\">$topic [$total2] <img width=15 height=15 src='floppy2.png'/></a></td>
						<td align=center style='padding:10px;'>$wdate</td><td align=center style='padding:10px;'>$hit</td>
						</tr>
					");
				}
			}
		}

		$counter = $counter + 1;

	endwhile;

	echo("</table>");

	echo ("<br>
		  <table border=0 width=350>
		  <tr align=center style='vertical-align:top;'>");
		   
	// 화면 하단에 페이지 번호 출력
	if ($cblock=='') $cblock=1;   // $cblock - 현재 페이지 블록값
	$blocksize = 5;             // $blocksize - 화면상에 출력할 페이지 번호 개수

	$pblock = $cblock - 1;      // 이전 블록은 현재 블록 - 1
	$nblock = $cblock + 1;     // 다음 블록은 현재 블록 + 1
		
	// 현재 블록의 첫 페이지 번호
	$startpage = ($cblock - 1) * $blocksize + 1;	

	$pstartpage = $startpage - 1;  // 이전 블록의 마지막 페이지 번호
	$nstartpage = $startpage + $blocksize;  // 다음 블록의 첫 페이지 번호

	if ($pblock > 0 && $cpage != 1) {
			echo ("
				<td align=center width=70>
				<form action=show.php?board=$board&cblock=$pblock&cpage=1 method=post>
					<input type=submit value='<<' name=pstartpage
					onmouseover=\"this.style.color='white'; this.style.background='#BDBDBD';\" onmouseout=\"this.style.color='black';this.style.background='';\"
					style='width:40; height:40; border-style:solid; border-width:1px;'>
				</form>
				</td>");
		}
	if ($pblock > 0)        // 이전 블록이 존재하면 [이전블록] 버튼을 활성화
		echo ("
			<td align=center width=70>
			<form action=show.php?board=$board&cblock=$pblock&cpage=$pstartpage method=post>
				<input type=submit value='<' name=pstartpage
				onmouseover=\"this.style.color='white'; this.style.background='#BDBDBD';\" onmouseout=\"this.style.color='black';this.style.background='';\"
				style='width:40; height:40; border-style:solid; border-width:1px;'>
			</form>
			</td>");

	// 현재 블록에 속한 페이지 번호를 출력	
	$i =   $startpage;
	while($i < $nstartpage):
	   if ($i > $totalpage) break;  // 마지막 페이지를 출력했으면 종료함
	   echo ("
			<td align=center height=50 width=70>
			<form action=show.php?board=$board&cblock=$cblock&cpage=$i method=post>
		");
		if ($i == $cpage) {
			echo ("
				<input type=submit value=$i name=i 
				style='background-color:#BDBDBD; color:white; border-style:solid; border-width:1px; width:40; height:40;'>
			");
		} else {
			echo ("
				<input type=submit value=$i name=i 
				onmouseover=\"this.style.color='white'; this.style.background='#BDBDBD';\" onmouseout=\"this.style.color='black';this.style.background='';\"
				style='width:40; height:40; border-style:solid; border-width:1px;'>
			");
		}
		echo ("
			</form>
			</td>");
	   $i = $i + 1;
	endwhile;
	 
	// 다음 블록의 시작 페이지가 전체 페이지 수보다 작으면 [다음블록] 버튼 활성화  
	if ($nstartpage <= $totalpage)   
		echo ("
			<td align=center valign=middle width=70>
			<form action=show.php?board=$board&cblock=$nblock&cpage=$nstartpage method=post>
				<input type=submit value='>' name=nstartpage
				onmouseover=\"this.style.color='white'; this.style.background='#BDBDBD';\" onmouseout=\"this.style.color='black';this.style.background='';\"
				style='width:40; height:40; border-style:solid; border-width:1px;'>
			</form>
			</td>");
	if ($nstartpage <= $totalpage && $cpage!=$totalpage) {
			echo ("
				<td align=center width=70>
				<form action=show.php?board=$board&cblock=$nblock&cpage=$totalpage method=post>
					<input type=submit value='>>' name=totalpage
					onmouseover=\"this.style.color='white'; this.style.background='#BDBDBD';\" onmouseout=\"this.style.color='black';this.style.background='';\"
					style='width:40; height:40; border-style:solid; border-width:1px;'>
				</form>
				</td>");
		}

	echo ("</tr></table></center>");
}
	
mysql_close($con);

?>