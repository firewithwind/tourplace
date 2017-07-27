<?php
	include("conn.php");
	include("request.php");
	session_start();

	switch ($request_method) {
		case 'GET':
			IFGET($request_data);
			break;
		case 'POST':
			IFPOST($request_data);
			break;
		case 'PUT':
			IFPUT($request_data);
			break;
		case 'DELETE':
			IFDELETE($request_data);
			break;
		default:
			break;
	}

/*��*/
function IFPOST($request_data){
	if($request_data['Type']==0){
		if(empty($request_data['Data']['Scenic_Name'])||
		   empty($request_data['Data']['Scenic_Intro'])||
		   empty($request_data['Data']['Province_ID'])||
		   empty($request_data['Data']['City_ID'])||
		   empty($request_data['Data']['Scenic_Adress'])||
		   empty($request_data['Data']['Scenic_Phone'])||
		   empty($request_data['Data']['Scenic_Level'])||
		   empty($request_data['Data']['Scenic_License'])||
		   empty($request_data['Data']['Scenic_Picture'])||
		   empty($request_data['Data']['Scenic_Vedio'])||
		   empty($request_data['Data']['Scenic_Type'])){
			echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"2.The information is incomplete!")));
		}else{
			$ID=getID();
			if($ID=='99999999'){
				echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"3.The scenic ID is fulled!")));
			}else{
				$aa1=$request_data['Data']['Scenic_Name'];
				$aa2=$request_data['Data']['Scenic_Intro'];
				$aa3=$request_data['Data']['Province_ID'];
				$aa4=$request_data['Data']['City_ID'];
				$aa5=$request_data['Data']['Scenic_Adress'];
				$aa6=$request_data['Data']['Scenic_Phone'];
				$aa7=$request_data['Data']['Scenic_Level'];
				$aa8=$request_data['Data']['Scenic_License'];
				$aa9=$request_data['Data']['Scenic_Picture'];
				$aa0=$request_data['Data']['Scenic_Vedio'];
				$aaa=$request_data['Data']['Scenic_Type'];
				$sql="SELECT * FROM `tourplace`.`scenic`
				WHERE `Scenic_License`='$aa8'";
				$rs=mysql_fetch_array(mysql_query($sql));
				$count=count($rs);
				if($count==0){
					$sql="INSERT INTO `tourplace`.`scenic`(`Scenic_ID`,`Scenic_Picture`,`Scenic_Name`,`Scenic_Intro`,
					`Province_ID1`,`City_ID`,`Scenic_Adress`,`Scenic_Phone`,`Scenic_Level`,`Scenic_License`,`Scenic_Vedio`,`Scenic_Type`)
					VALUES('$ID','$aa9','$aa1','$aa2','$aa3','$aa4','$aa5','$aa6','$aa7','$aa8','$aa0','$aaa')";
					mysql_query($sql);
					echo json_encode(array('Type'=>0,'Result'=>array('Scenic_ID'=>$ID)));
				}else{
					echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"4.The scenic is existed!")));
				}
			}
		}
	}else{
		echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"1.The request is error!")));
	}
}

/*ɾ*/
function IFDELETE($request_data){
	if($request_data['Type']==0){
		$delete=explode('+',$request_data['Delete']['Scenic_ID']);
		$count=count($delete);
		$flag=1;
		while($count>0){
			$ww=$delete[$count-1];
			$sql="SELECT FROM `tourplace`.`scenic` WHERE `scenic`.`scenic_ID`='$ww'";
			$rs=mysql_fetch_array(mysql_query($sql));
			if(count($rs)==0) $flag=0;
			$count--;
		}
		if($flag==0){
			echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"2.Exist some ID is error!")));
		}else{
			$count=count($delete);
			while($count>0){
				$ww=$delete[$count-1];
				$sql="DELETE FROM `tourplace`.`scenic` WHERE `scenic`.`scenic_ID`='$ww'";
				mysql_query($sql);
				$count--;
			}
			$fh=$request_data['Delete']['Scenic_ID'];
			echo json_encode(array('Type'=>0,'Result'=>array('Scenic_ID'=>$fh)));
		}
	}else{
		echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"1.The request is error!")));
	}
}

/*��*/
function IFPUT($request_data){
	if($request_data['Type']==0){
		$ID=$request_data['Scenic_ID'];
		$sql="SELECT * FROM `tourplace`.`scenic` WHERE `Scenic_ID`='$id'";
		$rs=mysql_fetch_array(mysql_query($sql));
		$count=count($rs);
		if($count==0){
			echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"2.Can not find the scenic ID!")));
		}else if(empty($request_data['Update']['Scenic_Name'])||
				 empty($request_data['Update']['Scenic_Intro'])||
				 empty($request_data['Update']['Province_ID'])||
				 empty($request_data['Update']['City_ID'])||
				 empty($request_data['Update']['Scenic_Adress'])||
				 empty($request_data['Update']['Scenic_Phone'])||
				 empty($request_data['Update']['Scenic_Level'])||
				 empty($request_data['Update']['Scenic_License'])||
				 empty($request_data['Update']['Scenic_Picture'])||
				 empty($request_data['Update']['Scenic_Vedio'])||
				 empty($request_data['Update']['Scenic_Type'])){
			echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"3.The information is incomplete!")));
		}else{
			$aa1=$request_data['Update']['Scenic_Name'];
			$aa2=$request_data['Update']['Scenic_Intro'];
			$aa3=$request_data['Update']['Province_ID'];
			$aa4=$request_data['Update']['City_ID'];
			$aa5=$request_data['Update']['Scenic_Adress'];
			$aa6=$request_data['Update']['Scenic_Phone'];
			$aa7=$request_data['Update']['Scenic_Level'];
			$aa8=$request_data['Update']['Scenic_License'];
			$aa9=$request_data['Update']['Scenic_Picture'];
			$aa0=$request_data['Update']['Scenic_Vedio'];
			$aaa=$request_data['Update']['Scenic_Type'];
			$sql="UPDATE `tourplace`.`scenic` SET
					`Scenic_Picture`='$aa9',
					`Scenic_Name`='$aa1',
					`Scenic_Intro`='$aa2',
					`Province_ID1`='$aa3',
					`City_ID`='$aa4',
					`Scenic_Adress`='$aa5',
					`Scenic_Phone`='$aa6',
					`Scenic_Level`='$aa7'
					`Scenic_License`='$aa8'
					`Scenic_Vedio`='$aa0'
					`Scenic_Type`='$aaa'
					WHERE `Scenic_ID`='$ID'";
			mysql_query($sql);
			echo json_encode(array('Type'=>0,'Result'=>""));
		}
	}else{
		echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"1.The request is error!")));
	}
}

/*��*/
function IFGET($request_data){
	$sql="";
	if(empty($request_data['Keys'])){
		$sql="SELECT *";
	}else{
		$sql="SELECT ";
		$Key=explode('+',$request_data['Keys']);
		$arrcount=count($Key);
		$i=0;
		while($i<$arrcount){
			$sql.="`".$Key[$i]."`";
			if($i!=$arrcount-1) $sql.=",";
				$i++;
		}
	}
	if($request_data['Type']==0){
		if(empty($request_data['Search']['Scenic_ID'])){
			$sql.=" FROM `tourplace`.`scenic` WHERE 1";
		}else{
			$tid=$request_data['Search']['Scenic_ID'];
			$sql.=" FROM `tourplace`.`scenic` WHERE `Scenic_ID`='$tid'";
		}
		nextstep($request_data,$sql);
	}else if($request_data['Type']==1){
		if(empty($request_data['Search']['Scenic_Name'])){
			$sql.=" FROM `tourplace`.`scenic` WHERE 1";
		}else{
			$tname=$request_data['Search']['Scenic_Name'];
			$sql.=" FROM `tourplace`.`scenic` WHERE `Scenic_Name`='$tname'";
		}
		nextstep($request_data,$sql);
	}else if($request_data['Type']==2){
		if(empty($request_data['Search']['Scenic_License'])){
			$sql.=" FROM `tourplace`.`scenic` WHERE 1";
		}else{
			$tlicense=$request_data['Search']['Scenic_License'];
			$sql.=" FROM `tourplace`.`scenic` WHERE `Scenic_License`='$tlicense'";
		}
		nextstep($request_data,$sql);
	}else if($request_data['Type']==3){
		if(empty($request_data['Search']['Province_ID'])){
			$sql.=" FROM `tourplace`.`scenic` WHERE 1";
		}else if(empty($request_data['Search']['City_ID'])){
			$provinceid=$request_data['Search']['Province_ID'];
			$sql.=" FROM `tourplace`.`scenic` WHERE `Province_ID1`='$provinceid'";
		}else{
			$provinceid=$request_data['Search']['Province_ID'];
			$cityid=$request_data['Search']['City_ID'];
			$sql.=" FROM `tourplace`.`scenic` WHERE `Province_ID1`='$provinceid'";
			$sql.=" AND `City_ID`='$cityid'";
		}
		if(!empty($request_data['Search']['Scenic_Level'])){
			$sceniclevel=$request_data['Search']['Scenic_Level'];
			$sql.=" AND `Scenic_Level`='$sceniclevel'";
		}
		if(!empty($request_data['Search']['Scenic_Type'])){
			$scenictype=$request_data['Search']['Scenic_Type'];
			$sql.=" AND `Scenic_Type`='$scenictype'";
		}
		nextstep($request_data,$sql);
	}else if($request_data['Type']==4){
		$id=$request_data['Search']['User_ID'];
		if(empty($request_data['Search']['User_ID'])){
			$id=$_SESSION['User_ID'];
		}else{
			$id=$request_data['Search']['User_ID'];
		}
		$sql1="SELECT `Scenic_ID1` FROM `tourplace`.`user` WHERE `User_ID`='$id'";
		$sql.=" FROM `tourplace`.`scenic` WHERE `Scenic_ID` IN(".$sql1.")";
		nextstep($request_data,$sql);
	}else{
		echo json_encode(array('Type'=>1,'Size'=>0,'sumSize'=>0,'Result'=>array('Errmsg'=>"1.The request is error!")));
	}
}

function nextstep($request_data,$sql){
	$result=array();
	$page=$request_data['Page'];
	$pagesize=$request_data['PageSize'];
	$query=mysql_query($sql);
	while($row=mysql_fetch_assoc($query))
		$result[]=$row;
	$resultcount=count($result);
	if($resultcount==0){
		echo json_encode(array('Type'=>1,'Size'=>0,'sumSize'=>0,'Result'=>array('Errmsg'=>"2.Can not find something about this information!")));
	}else{
		$pre=$pagesize*($page-1);
		if($pre>$resultcount){
			echo json_encode(array('Type'=>1,'Size'=>0,'sumSize'=>0,'Result'=>array('Errmsg'=>"1.The page number is error!")));
		}else{
			$finalresult=array();
			$finalcount=0;
			while($finalcount<$pagesize && $pre+$finalcount<$resultcount){
				$finalresult[]=$result[$pre+$finalcount];
				$finalcount++;
			}
			if($pagesize==0){
				echo json_encode(array('Type'=>0,'Size'=>$resultcount,'sumSize'=>$resultcount,'Result'=>$result));
			}else{
				echo json_encode(array('Type'=>0,'Size'=>$finalcount,'sumSize'=>$resultcount,'Result'=>$finalresult));
			}
		}
	}
}

function getID(){
	if(!@$f=fopen("ID_Record\Scenic_ID.txt","r")){
		$ID_0=1;
		$ff=fopen("ID_Record\Scenic_ID.txt","w");
		fwrite($ff,$ID_0);
		fclose($ff);
	}else{
		$ID_0=fgets($f,10);
		fclose($f);
		$ID_0++;
		$ff=fopen("ID_Record\Scenic_ID.txt","w");
		fwrite($ff,$ID_0);
		fclose($ff);
	}
	if(strlen($ID_0)>8)/*id����*/
		return '99999999';
	else{
		$num=8-strlen($ID_0);
		while($num>0){
			$ID_0='0'.$ID_0;
			$num--;
		}
		return $ID_0;
	}
}

?>
