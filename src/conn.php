<?php
	@mysql_connect("localhost:3306","root","") or die("mysql����ʧ�ܣ�");
	@mysql_select_db("tourplace") or die("db����ʧ�ܣ�");
	//mysql_set_charset("gbk");
	mysql_query("set names 'gbk'");
?>