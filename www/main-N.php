<?php
	session_start();
	$userName = $_SESSION["m_id"];
	$userPassword = $_SESSION["m_pass"];
	$findUser = false;



	$line = fopen('language.txt', 'r');
	$lan = fgets($line,1024);

	

	
	$loginvalue = array();
	$handle = fopen("login.txt", "r");
	if ($handle) {
	    while (($line = fgets($handle)) !== false) {

	        $login = explode(',', $line);
	        if( trim($userName)==trim($login[0]) && trim($userPassword)==trim($login[1]) ){

				$findUser = true;
				break;
			}

	    }

	    fclose($handle);
	} else {
	    // error opening the file.
	} 
	if($userName == "" || $userPassword == "")
		$findUser = false;

	
	$lines = file('network.txt');
	$value = '';
	foreach ($lines as $line_num => $line) {
	   $value .= htmlspecialchars($line);
	}
	if($value == '')
		$value = ',,';
	$nets = explode(',', $value);


	$siplines = file('sip.txt');
	$sipvalue = '';
	foreach ($siplines as $line_num => $line) {
	   $sipvalue .= htmlspecialchars($line);
	}
	if($sipvalue == '')
		$sipvalue = ',,,';
	$sip = explode(',', $sipvalue);


	$cameralines = file('camera.txt');
	$cameravalue = '';
	foreach ($cameralines as $line_num => $line) {
	   $cameravalue .= htmlspecialchars($line);
	}
	if($cameravalue == '')
		$cameravalue = ',,,,';
	$camera = explode(',', $cameravalue);

	$alarmlines = file('alarm.txt');
	$alamvalue = '';
	foreach ($alarmlines as $line_num => $line) {
	   $alamvalue .= htmlspecialchars($line);
	}
	if($alamvalue == '')
		$alamvalue = ',';
	$alarm = explode(',', $alamvalue);

	
	$value = array();
	if($lan == 0)
	{
		$lines = file('english.txt');
		foreach ($lines as $line_num => $line) {
		   $value[] = trim(preg_replace('/\s\s+/', ' ', htmlspecialchars($line)));
		}
	}
	else
	{
		$lines = file('korea.txt');
		foreach ($lines as $line_num => $line) {
		   $value[] = trim(preg_replace('/\s\s+/', ' ', htmlspecialchars($line)));
		}
	}
	
	if(!$findUser){
		echo '<script>';
        echo 'alert("'.$value[48].'");';
        echo 'window.location.href = "index.php"';
        echo '</script>';
    }
	

?>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="css/reset.min.css">
		<!--link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'>
		<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'-->
		<link href="css/main.css" rel="stylesheet" type="text/css" />
	</head>
	<script src="js/jquery-latest.js"></script>
	<script type="text/javascript">
		function menuItem(index) {
			$(".container").removeClass("active");
			$(".container:nth-child("+index+")").addClass("active");
			for (var i = 1; i < 8; i++) {
				$("#content"+i).css("display", "none");
			}
			$("#content"+index).css("display", "block");			
		}
		
		function saveNet() {

			var ip_address = $("#ip_address").val();
			var mask       = $("#mask").val();
			var gatway     = $("#gatway").val();

			
			$.ajax({
			    
			    url: 'network.php',
		        dataType: 'text',
		        type: 'post',
		        contentType: 'application/x-www-form-urlencoded',
		        data: {"ip_address" : ip_address, "mask" : mask, "gatway" : gatway},
		        success: function( data, textStatus, jQxhr ){
		            alert("<?php echo $value[43];?>");
		        },
		        error: function( jqXhr, textStatus, errorThrown ){
		            console.log( errorThrown );
		        }
			});
		}

		function saveSIP() {

			var user_name       = $("#user_name").val();
			var sip_ip_address  = $("#sip_ip_address").val();
			var user_pass       = $("#user_pass").val();
			var call_num        = $("#call_num").val();
			var ring_wav		= $("#ring_wav").val();

			
			
			$.ajax({
			    
			    url: 'main-o-py.php',
		        dataType: 'text',
		        type: 'post',
		        contentType: 'application/x-www-form-urlencoded',
		        data: {"user_name" : user_name, "sip_ip_address" : sip_ip_address, "user_pass" : user_pass, "call_num" : call_num, "ring_wav" : ring_wav},
		        success: function( data, textStatus, jQxhr ){
		            alert("<?php echo $value[43]; ?>");
		        },
		        error: function( jqXhr, textStatus, errorThrown ){
		            console.log( errorThrown );
		        }
			});
		}

		function saveCamera() {

			var camera_mask        = $("#camera_mask").val();
			var camera_ip_address  = $("#camera_ip_address").val();
			var camera_no          = $("#camera_no").val();
			var preset_no          = $("#preset_no").val();
			var camera_protocol    = $("#camera_protocol").val();
			var em_led        = $("#em_led").val();
			var em_light      = $("#em_light").val();
			
			if(camera_mask != '1' && camera_protocol == '')
			{
				alert("<?php echo $value[49]; ?>");
				return;
			}
			$.ajax({
			    
			    url: 'camera_call.php',
		        dataType: 'text',
		        type: 'post',
		        contentType: 'application/x-www-form-urlencoded',
		        data: {"camera_mask" : camera_mask, "camera_ip_address" : camera_ip_address, "camera_no" : camera_no, "preset_no" : preset_no, "camera_protocol" : camera_protocol, "em_led" : em_led, "em_light" : em_light},
		        success: function( data, textStatus, jQxhr ){
		            alert("<?php echo $value[43]; ?>");
		        },
		        error: function( jqXhr, textStatus, errorThrown ){
		            console.log( errorThrown );
		        }
			});
		}

		
		function reboot() {
			alert("<?php echo $value[44]; ?>");
			window.location.href = "reboot.php";
		}

		
		function myFunction(val) {
		    if(val == '2')
			{
				document.getElementById('camera_ip_address').disabled = true;
				document.getElementById('camera_no').disabled = true;
				document.getElementById('preset_no').disabled = true;
			}
			else
			{
				document.getElementById('camera_ip_address').disabled = false;
				document.getElementById('camera_no').disabled = false;
				document.getElementById('preset_no').disabled = false;
			}
		}

		function saveUser() {

			var addUserName       = $("#addUserName").val();
			var addUserPass       = $("#addUserPass").val();
			var logUser = '<?php echo trim($userName); ?>';
			var logPass = '<?php echo trim($userPassword); ?>';
			
			var r = confirm("<?php echo $value[45]; ?>");
			if (r == true) {
			    window.location.href = "assUser.php?id="+addUserName+"&pass="+addUserPass+"&logUser="+logUser+"&logPass="+logPass;
			}
		}
		function delUser(val, duser, uname, upass){
			var selid = "sel"+val;
			var userDiv = document.getElementById(selid);
			userDiv.style.display = 'none';   
			var r = confirm("<?php echo $value[46]; ?>");
			if (r == true) {
			    window.location.href = "deletUser.php?id="+uname+"&pass="+upass+"&duser="+duser;
			}
		}
	</script>
	<title>EMCALL</title>
	<body>
		<div class="main">
			<div>
				<div class="leftdiv">
					<div class="markdiv">
						<img src="img/mark.png" style="margin-top: 17px;width: 110px;">
					</div>
					<div class="titledivtop">
						<img src="img/title.png" style="margin-top: 17px;width: 233px;">
					</div>
				</div>
				<div class="rightdiv">
					<div style="float: left;width: 170px;height: 400px;background-color: #536372;">
						<div class="container active" onclick="menuItem(1);">
							<span class="menu">&nbsp;<?php echo $value[7]; ?></span>
						</div>
						<div class="container" onclick="menuItem(2);">
							<span class="menu">&nbsp;<?php echo $value[11]; ?></span>
						</div>
						<div class="container" onclick="menuItem(3);">
							<span class="menu">&nbsp;<?php echo $value[15]; ?></span>
						</div>
						<div class="container" onclick="menuItem(4);">
							<span class="menu">&nbsp;<?php echo $value[20]; ?></span>
						</div>
						<div class="container" onclick="menuItem(5);">
							<span class="menu">&nbsp;<?php echo $value[27]; ?></span>
						</div>
						<div class="container" onclick="menuItem(6);">
							<span class="menu">&nbsp;<?php echo $value[30]; ?></span>
						</div>
						<div class="container" onclick="menuItem(7);">
							<span class="menu">&nbsp;<?php echo $value[40]; ?></span>
						</div>
					</div>
					<div style="float: right;width: 600px;height: 400px;background-color: #ddd;font-size: 14px;padding-left: 30px;">
						<!--System Information-->
						<div id="content1" style="display: block;">
							<div class="subtitle"><span><?php echo $value[7]; ?></span></div>
							<div class="sub_content">
								<div class="listdiv">
									<div class="left200"><span>EMCALL </span></div>
									<div class="right230"><span style="color: #808080;">Version 1.0</span></div>
								</div>
								<div class="listdiv">
									<div class="left200"><span><?php echo $value[8]; ?></span></div>
									<div class="right230"><span style="color: #808080;"><?php echo $sip[0];?></span></div>
								</div>
								<div class="listdiv">
									<div class="left200"><span><?php echo $value[9]; ?></span></div>
									<div class="right230"><span style="color: #808080;"><?php echo $sip[1];?></span></div>
								</div>
							</div>
						</div>
						<!---SIP Server Setup-->
						<div id="content2" style="display: none;">
							<div class="subtitle"><span><?php echo $value[11]; ?></span></div>
							<div class="sub_content">
								<div class="listdiv">
									<div class="left200"><span><?php echo $value[12]; ?></span></div>
									<div class="right230"><input type="text" name="ip_address" id="ip_address" value="<?php  echo $nets[0];?>"></div>
								</div>
								<div class="listdiv">
									<div class="left200"><span><?php echo $value[13]; ?></span></div>
									<div class="right230"><input type="text" name="mask" id="mask" value="<?php  echo $nets[1];?>"></div>
								</div>
								<div class="listdiv">
									<div class="left200"><span><?php echo $value[14]; ?></span></div>
									<div class="right230"><input type="text" name="gatway" id="gatway" value="<?php  echo $nets[2];?>"></div>
								</div>
								<div class="listdiv">
									<div class="btn" onclick="saveNet()">
										<span class="txt"><?php echo $value[10]; ?></span>
									</div>
								</div>
							</div>
						</div>	
						<!--SIP Account Setup-->
						<div id="content3" style="display: none;">
							<div class="subtitle"><span><?php echo $value[15]; ?></span></div>
							<div class="sub_content">
								<form method="post" enctype="multipart/form-data" action="main-o-py.php">
									<input type="hidden" name="msg" value="<?php echo $value[43]; ?>">
									<div class="listdiv">
										<div class="left200"><span><?php echo $value[16]; ?></span></div>
										<div class="right230"><input type="text" name="user_name" id="user_name" value="<?php echo $sip[0];?>"></div>
									</div>
									<div class="listdiv">
										<div class="left200"><span><?php echo $value[17]; ?></span></div>
										<div class="right230"><input type="text" name="sip_ip_address" id="sip_ip_address" value="<?php echo $sip[1];?>"></div>
									</div>
									<div class="listdiv">
										<div class="left200"><span><?php echo $value[4]; ?></span></div>
										<div class="right230"><input type="text" name="user_pass" id="user_pass" value="<?php echo $sip[2];?>"></div>
									</div>
									<div class="listdiv">
										<div class="left200"><span><?php echo $value[19]; ?></span></div>
										<div class="right230"><input type="text" name="call_num" id="call_num" value="<?php echo $sip[3];?>"></div>
									</div>
									<div class="listdiv">
										<div class="left200"><span>Ring Back</span></div>
										<div class="right230"><input type="file" name="ring_wav" id="ring_wav" class="ring_wav"></div>
									</div>
									<div class="listdiv" style="padding-left: 180px;  padding-top: 20px;">
										<input type="submit"  name="<?php echo $value[10]; ?>" value="<?php echo $value[10]; ?>">
										<!-- <div class="btn" onclick="saveSIP()">
											<span class="txt"><?php echo $value[10]; ?></span>
										</div> -->
									</div>
								</form>
							</div>
						</div>	
						<!--Network Setup-->
						<div id="content4" style="display: none;">
							<div class="subtitle"><span><?php echo $value[20]; ?></span></div>
							<div class="sub_content">
								<div class="listdiv">
									<div class="left120"><span><?php echo $value[21]; ?></span></div>
									<div class="right330">
										<select name="camera_mask" id="camera_mask" style="width: 100px;" onchange="myFunction(this.value)">
											<option value="0" <?=($camera[0]=='0')? "selected":"";?>><?php echo $value[22]; ?></option>
											<option value="1" <?=($camera[0]=='1')? "selected":"";?>>Flexwatch</option>
											<option value="2" <?=($camera[0]=='2')? "selected":"";?>><?php echo $value[23]; ?></option>
										</select>
									</div>
								</div>
								<div class="listdiv">
									<div class="left120"><span><?php echo $value[12]; ?></span></div>
									<div class="right330"><input type="text" style="width: 300px;" name="camera_ip_address" id="camera_ip_address" value="<?php echo $camera[1];?>"></div>
								</div>
								<div class="listdiv">
									<div class="left120"><span><?php echo $value[25]; ?></span></div>
									<div class="right330"><input type="text" style="width: 70px;" name="camera_no" id="camera_no" value="<?php echo $camera[2];?>"></div>
								</div>
								<div class="listdiv">
									<div class="left120" style="margin-top: 5px;"><span><?php echo $value[26]; ?></span></div>
									<div class="right330"><input type="text" style="width: 70px;" name="preset_no" id="preset_no" value="<?php echo $camera[3];?>"></div>
								</div>
								<div class="listdiv" style="height: 80px;">
									<div class="left120"><span><?php echo $value[23]; ?></span></div>
									<div class="right330">
										<textarea name="camera_protocol" id="camera_protocol" style="width: 300px;height: 80px;"><?php echo $camera[4];?></textarea>
									</div>
								</div>
								<div class="listdiv">
									<div class="btn" onclick="saveCamera()">
										<span class="txt"><?php echo $value[10]; ?></span>
									</div>
								</div>
							</div>
						</div>	
						<!--Alarm Port Set-->
						<div id="content5" style="display: none;">
							<div class="subtitle"><span><?php echo $value[27]; ?></span></div>
							<div class="sub_content">
								<div class="listdiv">
									<div class="left200"><span><?php echo $value[28]; ?></span></div>
									<div class="right230"><input type="text" name="em_led" id="em_led" value="<?php if($alarm[0] == '') echo ('30'); else echo $alarm[0];?>"></div>
								</div>
								<div class="listdiv">
									<div class="left200"><span><?php echo $value[29]; ?></span></div>
									<div class="right230"><input type="text" name="em_light" id="em_light" value="<?php if($alarm[1] == '') echo ('30'); else echo $alarm[1];?>"></div>
								</div>
								<div class="listdiv">
									<div class="btn" onclick="saveCamera()">
										<span class="txt"><?php echo $value[10]; ?></span>
									</div>
								</div>
							</div>
						</div>	
						<!--Alarm Port Set-->
						<div id="content6" style="display: none;">
							<div class="subtitle"><span><?php echo $value[30]; ?></span></div>
							<div class="sub_content">
								<div class="listdiv">
									<div style="float: left;width: 50%;">
										<div style="float: left;width: 70%;"><span><?php echo $value[31]; ?></span></div>
										<div style="float: right;width: 30%;"><?php echo $login[0]; ?></div>
									</div>
									<div style="float: right;width: 50%;">
										<div style="float: left;width: 70%;"><span><?php echo $value[32]; ?></span></div>
										<div style="float: right;width: 30%;"><?php echo $login[1];?></div>
									</div>
									
								</div>
								<div class="listdiv">
									<div style="float: left;width: 35%;">
										<input type="text" name="addUserName" id="addUserName" placeholder="<?php echo $value[1]; ?>" style="width: 100px;">
									</div>
									<div style="float: left;width: 35%;">
										<input type="text" name="addUserPass" id="addUserPass" placeholder="<?php echo $value[4]; ?>" style="width: 100px;">
									</div>
									<div style="float: left;width: 30%;">
										<div class="btn" onclick="saveUser()" style="margin-left: 0px; margin-top: 0px;">
											<span class="txt"><?php echo $value[39]; ?></span>
										</div>
									</div>
								</div>
								<div class="listdiv" style="overflow-y: scroll;margin-left: 0px; height: 230px;">
									<?php 
										$handle = fopen("login.txt", "r");
										if ($handle) {
										    while (($line = fgets($handle)) !== false) {

										        $login = explode(',', $line);
										        if(trim($line[0]) != ""){		
										        	if(trim($login[0]) != "root" && trim($login[0]) != trim($userName)){
										    			$i = 0;
									?>
										<div style="width: 100%;border-top: 1px; border-style: solid;height: 20px;text-align: center;border-color: #c3bebe;" id="sel<?php echo $i; ?>">
											<div style="width: 40%;float: left;"><?php echo trim($login[0]); ?></div>
											<div style="width: 40%;float: left;"><?php echo trim($login[1]); ?></div>
											<div style="width: 20%;float: left;">
												<img src="img/close.png" style="width: 20px;cursor: pointer;" 
												onclick="delUser(<?php echo $i; ?>, '<?php echo trim($login[0]); ?>', '<?php echo trim($userName); ?>', '<?php echo trim($userPassword); ?>')">
											</div>
										</div>
									<?php 				$i++;
													}
												}
											}

										    fclose($handle);
										} else {
										    // error opening the file.
										} 
									?>
								</div>
							</div>
						</div>	
						<!--System Restart-->
						<div id="content7" style="display: none;">
							<div class="subtitle"><span><?php echo $value[40]; ?></span></div>
							<div class="sub_content">
								<div style="text-align: center;"><span><?php echo $value[41]; ?></span></div>
								<div class="listdiv">
									<div class="btn" onclick="reboot()">
										<span class="txt"><?php echo $value[42]; ?></span>
									</div>
								</div>
							</div>
						</div>	
					</div>
				</div>
			</div>
			<div class="footer">Copyright ⓒ AEPEL All rights reserved. ☎ 1811-6061</div>
		</div>
	</body>
</html>