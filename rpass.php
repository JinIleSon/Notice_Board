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
   <form method=post action=rpass2.php?board=$board&id=$id&mode=$mode&wdate=$wdate>
   <table border=0 width=400 align=center>
   <tr><td align=center>암호를 입력하세요</td></tr>
   <tr><td align=center>암호: <input type=password size=15 name='pass'>
   <input type=submit value=입력></td></tr>
   </form>
   </table>
");

?>