<?php
$start = 0;
$urlq = $_SERVER['SERVER_PORT'] == 443 ? "https://" : "http://";
$urlh = ($_SERVER['SERVER_PORT'] == 80) || ($_SERVER['SERVER_PORT'] == 443) ? "":":".$_SERVER['SERVER_PORT'];
echo $urlh;
switch ($_REQUEST["who"])
{
	case "no1":
		$db = new mysqli("127.0.0.1","no1","no1","no1");
		if(mysqli_connect_errno()){
			echo "数据库连接错误";
			die;
		}
		$start = 1;
		$who = $_REQUEST["who"];
		break;

	default:
		echo '<table border="1">';
		echo "<tr>";
		echo "请选择数据库";
		echo "</tr>";
		echo "<tr>";

		echo "<td>";
		echo '<a href="'.$urlq.$_SERVER['HTTP_HOST'].$urlh.$_SERVER['PHP_SELF'].'?who=no1">'."1号数据库".'</a>';
		echo "</td>";

		echo "<tr>";
		echo "</table>";
}
if($start){
	echo '<table border="1">';
	echo "<tr>";
	echo "请选择表名";
	echo "</tr>";
	echo "<tr>";
  	echo "<td>";
	echo '<a href="'.$urlq.$_SERVER['HTTP_HOST'].$urlh.$_SERVER['PHP_SELF'].'">'."主页".'</a>';
	echo "</td>";
	$result = $db->query("SHOW TABLES");
	while($rows = $result->fetch_row()){
		echo "<td>";
		echo '<a href="'.$urlq.$_SERVER['HTTP_HOST'].$urlh.$_SERVER['PHP_SELF'].'?who='.$who.'&table='.$rows[0].'">'.$rows[0].'</a>';
		echo "</td>";
	}
	echo "</tr>";
	echo "</table>";
	if($_REQUEST["table"]){
      	$ls = 50;//每页显示50
		$tablename = $_REQUEST["table"];
		if(!$_REQUEST["num"]){
			$nownum = 0;
		} else {
			$nownum = $_REQUEST["num"];
		}
		$num = $nownum*$ls;
		$result = $db->query("select count(*) from $tablename");
		$maxnum = $result->fetch_row()[0];
		$maxnum = (int)($maxnum/$ls);
		$minnum = $nownum-5;
		if($minnum<0){
			$minnum = 0;
		}
		$bignum = $minnum+10;
		echo '<table border="1">';
		echo "<tr>";
		$result = $db->query("SHOW COLUMNS FROM $tablename");
		while($rows = $result->fetch_row()){
			echo "<td>";
			echo $rows[0];
			echo "</td>";
		}
		echo "</tr>";
		$result = $db->query("SELECT * FROM $tablename LIMIT $num, $ls;");
		while($rows = $result->fetch_row()){
			echo "<tr>";
			foreach ($rows as $row){
				echo "<td>";
				echo $row;
				echo "</td>";
			}
			echo "</tr>";
		}
		echo "</table>";

		echo '<table>';//页码
		echo "<tr>";
		echo "<td>";
		$url = $urlq.$_SERVER['HTTP_HOST'].$urlh.$_SERVER['PHP_SELF']."?who=$who&table=$tablename&num=0";
		echo '<a href="'.$url.'">'."首页".'</a>';
      	echo "</td>";
		for($x=$minnum; $x<$bignum; $x++){
			if($x <= $maxnum){
				echo "<td>";
				$url = $urlq.$_SERVER['HTTP_HOST'].$urlh.$_SERVER['PHP_SELF']."?who=$who&table=$tablename&num=$x";
				echo '<a href="'.$url.'">'.$x.'</a>';
				echo "</td>";
			}
		}
		echo "<td>";
		$url = $urlq.$_SERVER['HTTP_HOST'].$urlh.$_SERVER['PHP_SELF']."?who=$who&table=$tablename&num=$maxnum";
		echo '<a href="'.$url.'">'."尾页".'</a>';
      	echo "</td>";
		echo "</tr>";
		echo "</table>";
	}
}
?>
