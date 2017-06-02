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
		default:
			break;
	}
	
/*增*/
function IFPOST($request_data){
	if(isset($request_data['Province_Name'])){
		$name=$request_data['Province_Name'];
		$ID=getID();
		if($ID=='99999999'){/*失败*/
			echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"2.The ID is fulled!")));
		}else{/*成功*/
			$sql="INSERT INTO `tourplace`.`province`(`Province_ID`,`Province_Name`)
				VALUES('$ID','$name')";
			mysql_query($sql);
			echo json_encode(array('Type'=>0,'Result'=>array('Province_ID'=>$ID)));
		}
	}else{
		echo json_encode(array('Type'=>1,'Result'=>array('Errmsg'=>"1.The province name is empty!")));
	}
}

/*查*/
function IFGET($request_data){
	$result=array();
	$page=$request_data['Page'];
	$pagesize=$request_data['PageSize'];
	$sql="";
	if($request_data['Type']==0){
		if(!empty($request_data['Search']['Provnice_ID'])){
			$proid=$request_data['Search']['Provnice_ID'];
			if(empty($request_data['Keys'])){
				$Citys=array();
				$sql1="SELECT * FROM `tourplace`.`city` WHERE `Province_ID='$proid'";
				$query=mysql_query($sql1);
				while($row=mysql_fetch_assoc($query))
					$Citys[]=$row;
				$sql="SELECT * FROM `tourplace`.`province` WHERE `Province_ID='$proid'";
				$query=mysql_query($sql);
				while($row=mysql_fetch_assoc($query)){
					$result[]=$row;
					$result[]=$Citys;
				}
			}else{
				$sql.="SELECT ";
				$Key=explode('+',$request_data['Keys']);
				$arrcount=count($Key);
				$i=0;$flag=0;
				while($i<$arrcount){
					if($Key[$i]=="Province_ID")
						$sql.="`province`.`Province_ID`";
					else
						$sql.="`province`.`Province_Name`";
					if($Key[$i]=="Citys") $flag=1;
					if($i!=$arrcount-1) $sql.=",";
					$i++;
				}
				$sql.=" FROM `province` WHERE `Province_ID='$proid'";
				if($flag==1){
					$Citys=array();
					$sql1="SELECT * FROM `tourplace`.`city` WHERE `Province_ID='$proid'";
					$query=mysql_query($sql1);
					while($row=mysql_fetch_assoc($query))
						$Citys[]=$row;
					$query=mysql_query($sql);
					while($row=mysql_fetch_assoc($query)){
						$result[]=$row;
						$result[]=$Citys;
					}
				}else{
					$query=mysql_query($sql);
					while($row=mysql_fetch_assoc($query))
						$result[]=$row;
				}
			}
			$resultcount=count($result);
			$pre=$pagesize*($page-1);
			if($pre>$resultcount){
				echo json_encode(array('Type'=>1,'Size'=>0,'Result'=>array('Errmsg'=>"1.The page number is error!")));
			}else{
				$finalresult=array();
				$finalcount=0;
				while($finalcount<$pagesize && $pre+$finalcount<$resultcount){
					$finalresult[]=$result[$pre+$finalcount];
					$finalcount++;
				}
				if($pagesize==0)
					echo json_encode(array('Type'=>0,'Size'=>$resultcount,'Result'=>$result));
				else
					echo json_encode(array('Type'=>0,'Size'=>$finalcount,'Result'=>$finalresult));
			}
		}else{
			if(empty($request_data['Keys'])){
				$sql="SELECT * FROM `tourplace`.`province`";
				$query=mysql_query($sql);
				while($row=mysql_fetch_assoc($query)){
					$result[]=$row;
					$pro=$row['Province_ID'];
					$Citys=array();
					$sql1="SELECT * FROM `tourplace`.`city` WHERE Province_ID='$pro'";
					$query=mysql_query($sql1);
					while($row=mysql_fetch_assoc($query))
						$Citys[]=$row;
					$result[]=$Citys;
				}
			}else{
				$sql.="SELECT ";
				$Key=explode('+',$request_data['Keys']);
				$arrcount=count($Key);
				$i=0;$flag=0;
				while($i<$arrcount){
					if($Key[$i]=="Province_ID")
						$sql.="`province`.`Province_ID`";
					else
						$sql.="`province`.`Province_Name`";
					if($Key[$i]=="Citys") $flag=1;
					if($i!=$arrcount-1) $sql.=",";
					$i++;
				}
				$sql.="FROM `province`";
				if($flag==1){
					$query=mysql_query($sql);
					while($row=mysql_fetch_assoc($query)){
						$result[]=$row;
						$Citys=array();
						if(!empty($row['Province_ID'])){
							$pro=$row['Province_ID'];
							$sql1="SELECT * FROM `tourplace`.`city` WHERE `Province_ID='$pro'";
						}else if(!empty($row['Province_Name'])){
							$pro=$row['Province_Name'];
							$sql1="SELECT * FROM `tourplace`.`city` WHERE `Province_Name='$pro'";
						}else{
							$sql1="SELECT * FROM `tourplace`.`city`";
						}
						$query=mysql_query($sql1);
						while($row=mysql_fetch_assoc($query))
							$Citys[]=$row;
						$result[]=$Citys;
					}
				}else{
					$query=mysql_query($sql);
					while($row=mysql_fetch_assoc($query))
						$result[]=$row;
				}
			}
			$resultcount=count($result);
			$pre=$pagesize*($page-1);
			if($pre>$resultcount){
				echo json_encode(array('Type'=>1,'Size'=>0,'Result'=>array('Errmsg'=>"1.The page number is error!")));
			}else{
				$finalresult=array();
				$finalcount=0;
				while($finalcount<$pagesize && $pre+$finalcount<$resultcount){
					$finalresult[]=$result[$pre+$finalcount];
					$finalcount++;
				}
				if($pagesize==0)
					echo json_encode(array('Type'=>0,'Size'=>$resultcount,'Result'=>$result));
				else
					echo json_encode(array('Type'=>0,'Size'=>$finalcount,'Result'=>$finalresult));
			}
		}
	}else if($request_data['Type']==1){
		if(!empty($request_data['Search']['Provnice_Name'])){
			$proid=$request_data['Search']['Provnice_Name'];
			if(empty($request_data['Keys'])){
				$Citys=array();
				$sql1="SELECT * FROM `tourplace`.`city` WHERE `Province_Name='$proid'";
				$query=mysql_query($sql1);
				while($row=mysql_fetch_assoc($query))
					$Citys[]=$row;
				$sql="SELECT * FROM `tourplace`.`province` WHERE `Province_Name='$proid'";
				$query=mysql_query($sql);
				while($row=mysql_fetch_assoc($query)){
					$result[]=$row;
					$result[]=$Citys;
				}
			}else{
				$sql.="SELECT ";
				$Key=explode('+',$request_data['Keys']);
				$arrcount=count($Key);
				$i=0;$flag=0;
				while($i<$arrcount){
					if($Key[$i]=="Province_ID")
						$sql.="`province`.`Province_ID`";
					else
						$sql.="`province`.`Province_Name`";
					if($Key[$i]=="Citys") $flag=1;
					if($i!=$arrcount-1) $sql.=",";
					$i++;
				}
				$sql.=" FROM `province` WHERE `Province_Name='$proid'";
				if($flag==1){
					$Citys=array();
					$sql1="SELECT * FROM `tourplace`.`city` WHERE `Province_Name='$proid'";
					$query=mysql_query($sql1);
					while($row=mysql_fetch_assoc($query))
						$Citys[]=$row;
					$query=mysql_query($sql);
					while($row=mysql_fetch_assoc($query)){
						$result[]=$row;
						$result[]=$Citys;
					}
				}else{
					$query=mysql_query($sql);
					while($row=mysql_fetch_assoc($query))
						$result[]=$row;
				}
			}
			$resultcount=count($result);
			$pre=$pagesize*($page-1);
			if($pre>$resultcount){
				echo json_encode(array('Type'=>1,'Size'=>0,'Result'=>array('Errmsg'=>"1.The page number is error!")));
			}else{
				$finalresult=array();
				$finalcount=0;
				while($finalcount<$pagesize && $pre+$finalcount<$resultcount){
					$finalresult[]=$result[$pre+$finalcount];
					$finalcount++;
				}
				if($pagesize==0)
					echo json_encode(array('Type'=>0,'Size'=>$resultcount,'Result'=>$result));
				else
					echo json_encode(array('Type'=>0,'Size'=>$finalcount,'Result'=>$finalresult));
			}
		}else{
			if(empty($request_data['Keys'])){
				$sql="SELECT * FROM `tourplace`.`province`";
				$query=mysql_query($sql);
				while($row=mysql_fetch_assoc($query)){
					$result[]=$row;
					$pro=$row['Province_Name'];
					$Citys=array();
					$sql1="SELECT * FROM `tourplace`.`city` WHERE Province_Name='$pro'";
					$query=mysql_query($sql1);
					while($row=mysql_fetch_assoc($query))
						$Citys[]=$row;
					$result[]=$Citys;
				}
			}else{
				$sql.="SELECT ";
				$Key=explode('+',$request_data['Keys']);
				$arrcount=count($Key);
				$i=0;$flag=0;
				while($i<$arrcount){
					if($Key[$i]=="Province_ID")
						$sql.="`province`.`Province_ID`";
					else
						$sql.="`province`.`Province_Name`";
					if($Key[$i]=="Citys") $flag=1;
					if($i!=$arrcount-1) $sql.=",";
					$i++;
				}
				$sql.="FROM `province`";
				if($flag==1){
					$query=mysql_query($sql);
					while($row=mysql_fetch_assoc($query)){
						$result[]=$row;
						$Citys=array();
						if(!empty($row['Province_ID'])){
							$pro=$row['Province_ID'];
							$sql1="SELECT * FROM `tourplace`.`city` WHERE `Province_ID='$pro'";
						}else if(!empty($row['Province_Name'])){
							$pro=$row['Province_Name'];
							$sql1="SELECT * FROM `tourplace`.`city` WHERE `Province_Name='$pro'";
						}else{
							$sql1="SELECT * FROM `tourplace`.`city`";
						}
						$query=mysql_query($sql1);
						while($row=mysql_fetch_assoc($query))
							$Citys[]=$row;
						$result[]=$Citys;
					}
				}else{
					$query=mysql_query($sql);
					while($row=mysql_fetch_assoc($query))
						$result[]=$row;
				}
			}
			$resultcount=count($result);
			$pre=$pagesize*($page-1);
			if($pre>$resultcount){
				echo json_encode(array('Type'=>1,'Size'=>0,'Result'=>array('Errmsg'=>"1.The page number is error!")));
			}else{
				$finalresult=array();
				$finalcount=0;
				while($finalcount<$pagesize && $pre+$finalcount<$resultcount){
					$finalresult[]=$result[$pre+$finalcount];
					$finalcount++;
				}
				if($pagesize==0)
					echo json_encode(array('Type'=>0,'Size'=>$resultcount,'Result'=>$result));
				else
					echo json_encode(array('Type'=>0,'Size'=>$finalcount,'Result'=>$finalresult));
			}
		}
	}else{
		echo json_encode(array('Type'=>1,'Num'=>0,'Result'=>array('Errmsg'=>"1.The request is error!")));
	}
}

function getID(){
	if(!@$f=fopen("ID_Record\Province_ID.txt","r")){
		$ID_0=1;
		$ff=fopen("ID_Record\Province_ID.txt","w");
		fwrite($ff,$ID_0);
		fclose($ff);
	}else{
		$ID_0=fgets($f,10);
		fclose($f);
		$ID_0++;
		$ff=fopen("ID_Record\Province_ID.txt","w");
		fwrite($ff,$ID_0);
		fclose($ff);
	}
	if(strlen($ID_0)>8)/*id已满*/
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