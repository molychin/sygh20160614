<?php 
	include("conn.php");

	$zgh=$_POST['zgh'];
	$mima=$_POST['mima'];
	$juese=$_POST['juese'];
	
	//获取当前学年、学期
	$SQL="select sygh_dqxnxq,njfw from systeminfo where bmmc='xueshengchu'";
	$query=mysqli_query($conn,$SQL);
	$row=mysqli_fetch_array($query,MYSQLI_ASSOC) or die('Error querying database,loginCheck.php.');	
	$dqxnxq=$row['sygh_dqxnxq'];
	$dqxn=substr($dqxnxq,0,9);
	$dqxq=substr($dqxnxq,strlen($dqxnxq)-1,1);
	$njfw=$row['njfw'];	//参加《生涯规划》的年级范围；
		
	//--获取当前用户基本信息
	if($juese=='xs'){
		$SQL="select xh,xm,mima,nj from xsjbxxb where xh='$zgh'";
		$query=mysqli_query($conn,$SQL);
		$row=mysqli_fetch_array($query,MYSQLI_ASSOC) or die('没有此用户！');
		$kuMima=$row['mima'];
		$xm=$row['xm'];		
		$nianji=$row['nj'];
		$qx='0';
	}else if($juese=='js'){
		$SQL="select zgh,xm,mima,qx,bm,bmdm from jsxxb where zgh='$zgh'";
		$query=mysqli_query($conn,$SQL);
		$row=mysqli_fetch_array($query,MYSQLI_ASSOC) or die('没有此用户！');
		$kuMima=$row['mima'];
		$xm=$row['xm'];	
		$qx=$row['qx'];
		$xy=$row['bm'];		
		$bmdm=$row['bmdm'];
	}
	
	//设置session
	session_start();
	$_SESSION['zgh']=$zgh;
	$_SESSION['juese']=$juese;
	$_SESSION['xm']=$xm;
	$_SESSION['dqxn']=$dqxn;
	$_SESSION['dqxq']=$dqxq;
	$_SESSION['njfw']=$njfw;
	$_SESSION['qx']=$qx;
	$_SESSION['count']=1;	//当前学生计数
	
	if($juese=='xs'){
		$_SESSION['nj']=$nianji;
	}
	
	if($mima==$kuMima){
		if($juese=='xs'){
			echo "<script> window.location.href='xsjbxx_xs.php'</script>"; 	//
		}else if($juese=='js'){		
			$_SESSION['xy']=$xy;	
			$_SESSION['bmdm']=$bmdm;
			
			if($qx%2==0){
				echo "<script> window.location.href='qxfp.php'</script>"; 	//转至管理员用户界面（权限分配）；
			}else if($qx%3==0){
				echo "<script> window.location.href='qxfp_bzr.php'</script>"; 	//转至教研主任界面（指定班主任/教学任务显示）；
			}else if($qx%7==0){
				echo "<script> window.location.href='show_xs.php'</script>"; 	//转至学工院长界面（查看审核情况）；
			}else if($qx%11==0){	//班主任
				echo "<script> window.location.href='xsjbxx_js.php'</script>"; 
			}else{
				echo "<br>无访问权限";				
			}
		}		
	}else {
		echo "<script> alert('用户名或密码不正确！'); </script>";
		echo "<script> window.location.href='login.php' </script>";  		
	}
?>  