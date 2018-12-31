<?php
if($argv[1] && $argv[2] && $argv[3] && $argv[4] && $argv[5] && $argv[6] && $argv[7] && $argv[8]){
	$filename = $argv[1];
	$db = new mysqli($argv[2],$argv[3],$argv[4],$argv[5]);
	$table = $argv[6];
	if(mysqli_connect_errno()){
		echo "数据库连接错误";
		die;
	}
	$myfile = fopen($filename, "r") or die("文件打开失败");
	$qtable = $argv[7];
	$htable = $argv[8];
	while(!feof($myfile)) {
		$str = fgets($myfile);
		$strs = explode("	",$str);
		$qstr = $strs[0];
		$hstr = $strs[1];
		$db-> query("UPDATE $table SET $htable = '$hstr' WHERE $qtable = '$qstr'");
	}
  	echo "加入完成";
	fclose($myfile);
} else {
  echo "请输入：php addsql.php  文件名 数据库IP 数据库用户名 数据库密码 数据库名字 表格名 定位列名 插入列名";
}
?>