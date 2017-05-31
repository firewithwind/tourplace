<?php
	@mysql_connect("localhost:3306","root","") or die("mysql连接失败！");
	@mysql_select_db("tourplace") or die("db连接失败！");
	//mysql_set_charset("gbk");
	mysql_query("set names 'gbk'");
?>