<?php
	include("conn.php");
	
	/*增*/
	if(!empty($_POST)){
		echo "1110";
		$name=$_POST['Data']['User_name'];
		$password=$_POST['Data']['User_Password'];
		$intro=$_POST['Data']['User_Intro'];
		$type=$_POST['Data']['User_Type'];
		$ID=getID($type);
		if($ID=='99999999'){/*失败*/
			echo json_encode(array('Type'=>1,'Result'=>json_encode(array('Errmsg'=>"ID生成错误！"))));
		}else{/*成功*/
			$Null="";
			$sql="insert into `user`(`User_ID`,`User_Name`,`User_Password`,`User_Truename`,
				`User_Intro`,`User_Sex`,`User_Phone`,`User_Birthday`,`User_IDcard`,`User_Level`,
				`User_Scenic_ID`,`User_Type`)
				values('$ID','$name','$password','$Null','$intro',
				'$Null','$Null','$Null','$Null','50','$Null','$type')";
			mysql_query($sql);
			echo json_encode(array('Type'=>0,'Result'=>json_encode(array('User_ID'=>'$ID'))));
		}
	}
	
	/*删*/
	if(!empty($_DELETE['User_ID'])){
		$dID=$_DELETE['User_ID'];
		$sql="select count(*) as count from `user` where `User_ID`='$dID'";
		$query=mysql_query($sql);
		if(mysql_num_rows($query)){
			$rs=mysql_fetch_array($query);
			$count=$rs[0];
		}else{
			$count=0;
		}
		if($count==0){/*失败*/
			echo json_encode(array('Type'=>"1",'Result'=>"删除的用户不存在！"));
		}else{/*成功*/
			$sql="delete from `user` where `User_ID`='$dID'";
			mysql_query($sql);
			echo json_encode(array('Type'=>"0",'Result'=>$dID));
		}
	}
	
	/*改*/
	
	
	/*查*/
	
	
function getID($usertype){
	if($usertype=='0'){
		if(!@$f=fopen("ID_0.txt","r")){
			$ID_0=1;
			$ff=fopen("ID_0.txt","w");
			fwrite($ff,$ID_0);
			fclose($ff);
		}else{
			$ID_0=fgets($f,10);
			fclose($f);
			$ID_0++;
			$ff=fopen("ID_0.txt","w");
			fwrite($ff,$ID_0);
			fclose($ff);
		}
		if(strlen($ID_0)>7)/*id已满*/
			return '99999999';
		else{
			$num=7-strlen($ID_0);
			while($num>0){
				$ID_0='0'.$ID_0;
				$num--;
			}
			$ID_0='0'.$ID_0;
			return $ID_0;
		}
	}else{
		if(!@$f=fopen("ID_1.txt","r")){
			$ID_1=1;
			$ff=fopen("ID_1.txt","w");
			fwrite($ff,$ID_1);
			fclose($ff);
		}else{
			$ID_1=fgets($f,10);
			fclose($f);
			$ID_1++;
			$ff=fopen("ID_1.txt","w");
			fwrite($ff,$ID_1);
			fclose($ff);
		}
		if(strlen($ID_1)>7)/*id已满*/
			return '99999999';
		else{
			$num=7-strlen($ID_1);
			while($num>0){
				$ID_1='0'.$ID_1;
				$num--;
			}
			$ID_1='1'.$ID_1;
			return $ID_1;
		}
	}
}
	
?>