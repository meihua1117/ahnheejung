﻿<?php
	session_start();
	$userName = $_SESSION["m_id"];
	$userPassword = $_SESSION["m_pass"];
	$findUser = false;

	$p = $_GET["p"];



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

	$levellines = file('dv.txt');
	$dvValue = '';
	foreach ($levellines as $line_num => $line) {
	   $dvValue .= htmlspecialchars($line);
	}
	if($dvValue == '') $dvValue = '50';

	$bgmiplines = file('bgmip.txt');
	$bgmipValue = '';
	foreach ($bgmiplines as $line_num => $line) {
	   $bgmipValue .= htmlspecialchars($line);
	}


	
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
		<meta name="google" value="notranslate">
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
			for (var i = 1; i < 11; i++) {
				$("#content"+i).css("display", "none");
			}
			$("#content"+index).css("display", "block");			
		}
		
		function saveNet() {

			var ip_address = $("#ip_address").val();
			var mask       = $("#mask").val();
			var gatway     = $("#gatway").val();

			var netGroup = $("input:radio[name ='group1']:checked").val();
			var tagetUri = "";
			if(netGroup == 'static') tagetUri = "network.php";
			else tagetUri = "dhcp.php";
			
			$.ajax({
			    
			    url: tagetUri, 
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
				console.log("deletUser.php?id="+uname+"&pass="+upass+"&duser="+duser);
			    window.location.href = "deletUser.php?id="+uname+"&pass="+upass+"&duser="+duser;
			}
		}

		function selectAudio() {
			var id = $('#audioID').val();
			if (!id) {
				alert("<?php echo $value[63];?>");
				return;
			} else {
				if(id == "BGM") $('#bgmList').css("visibility", "visible");
				else $('#bgmList').css("visibility", "hidden");
				$.ajax({
			    url: 'getAudioInfo.php',
		        dataType: 'text',
		        type: 'post',
		        contentType: 'application/x-www-form-urlencoded',
		        data: {"id" : id, "point" : "content"},
		        success: function( data, textStatus, jQxhr ){
		            $('#audioContent').val(data);
		        },
		        error: function( jqXhr, textStatus, errorThrown ){
		            console.log( errorThrown );
		        }
				});
			}
		}

		function selectEventAudio() { 
			var id = $('#eventAudioID').val();
			var port = $('#audioEventPort').val();
			if (!id) {
				alert("<?php echo $value[63];?>");
				return;
			} else {
				$.ajax({
			    url: 'updateAudioInfo.php',
		        dataType: 'text',
		        type: 'post',
		        contentType: 'application/x-www-form-urlencoded',
		        data: {"audioID" : id, "port" : port},
		        success: function( data, textStatus, jQxhr ){
		        	if (!data)
		        		alert("<?php echo $value[64];?>");
		        	else
		        		alert("<?php echo $value[65];?>");
		        },
		        error: function( jqXhr, textStatus, errorThrown ){
		            console.log( errorThrown );
		        }
				});
			}
		}

		function selectWebPlayAudio() {
			var id = $('#webPlayAudioID').val();
			if (!id) {
				alert("<?php echo $value[63];?>");
				return;
			} else {
				$.ajax({
			    url: 'getAudioInfo.php',
		        dataType: 'text',
		        type: 'post',
		        contentType: 'application/x-www-form-urlencoded',
		        data: {"id" : id, "point" : "all"},
		        success: function( data, textStatus, jQxhr ){
		        	let response = JSON.parse(data);
		        	if (!response.file) {
		        		alert("<?php echo $value[64];?>");
		        		return;
		        	} else {
		        		$('#webPlayAudio').attr('src', 'sound/' + response.file);
		        		$('#webPlayContent').val(response.content);
		        	}
		        },
		        error: function( jqXhr, textStatus, errorThrown ){
		            console.log( errorThrown );
		        }
				});
			}
		}

		function selectDevicePlayAudio() {
			var id = $('#devicePlayAudioID').val();
			if (!id) {
				alert("<?php echo $value[63];?>");
				return;
			} else {
				$.ajax({
			    url: 'getAudioInfo.php',
		        dataType: 'text',
		        type: 'post',
		        contentType: 'application/x-www-form-urlencoded',
		        data: {"id" : id, "point" : "all"},
		        success: function( data, textStatus, jQxhr ){
		        	let response = JSON.parse(data);
		        	if (!response.file) {
		        		alert("<?php echo $value[64];?>");
		        		return;
		        	} else {
		        		$('#devicePlayContent').val(response.content);
		        	}
		        },
		        error: function( jqXhr, textStatus, errorThrown ){
		            console.log( errorThrown );
		        }
				});
			}
		}

		function devicePlay() {
			var id = $('#devicePlayAudioID').val();
			if (!id) {
				alert("<?php echo $value[63];?>");
				return;
			} else {
				$.ajax({
			    url: 'deviceAudioPlay.php',
		        dataType: 'text',
		        type: 'post',
		        contentType: 'application/x-www-form-urlencoded',
		        data: {"id" : id},
		        success: function( data, textStatus, jQxhr ){
		        	//let response = JSON.parse(data);
		        },
		        error: function( jqXhr, textStatus, errorThrown ){
		            console.log( errorThrown );
		        }
				});
			}
		}

		function deviceStop() {
			$.ajax({
			    url: 'deviceAudioStop.php',
		        dataType: 'text',
		        type: 'post',
		        contentType: 'application/x-www-form-urlencoded',
		        data: {"id" : ""},
		        success: function( data, textStatus, jQxhr ){
		        	let response = JSON.parse(data);
		        },
		        error: function( jqXhr, textStatus, errorThrown ){
		            console.log( errorThrown );
		        }
			});
		}

		function levelPlay(idx) {
			var strUrl="";
			if(idx == 0) strUrl = 'levelAudioPlay.php';
			else strUrl = 'levelAudioStop.php';
			$.ajax({
			    url: strUrl,
		        dataType: 'text',
		        type: 'post',
		        contentType: 'application/x-www-form-urlencoded',
		        data: {"id" : ""},
		        success: function( data, textStatus, jQxhr ){
		        	//let response = JSON.parse(data);
		        },
		        error: function( jqXhr, textStatus, errorThrown ){
		            console.log( errorThrown );
		        }
			});
		}

		function playWebAudio() {
			var id = $('#webPlayAudioID').val();
			if (!id) {
				alert("<?php echo $value[63];?>");
				return;
			} else {
				webPlayAudio.play();
			}
		}

		function stopWebAudio() {
			if (!webPlayAudio.paused) {
				webPlayAudio.pause();
			}
		}

		function changeDeviceVolume() {
			var volume = $('#deviceVolume').val();
			$.ajax({
				url: 'deviceVolume.php',
				dataType: 'text',
				type: 'post',
				contentType: 'application/x-www-form-urlencoded',
				data: {"volume" : volume},
				success: function( data, textStatus, jQxhr ){
					alert("<?php echo $value[69];?>")
				},
				error: function( jqXhr, textStatus, errorThrown ){
					console.log( errorThrown );
				}
			});
		}

		function setSchedule() {
			var id = $('#scheduleAudioID').val();
			var day = $('#scheduleDaySelect').val();
			var time = $('#scheduleTimeSelect').val();
			if (!id) {
				alert("<?php echo $value[63];?>");
				return;
			} else if (!day) {
				alert("<?php echo $value[67];?>");
				return;
			} else if (!time) {
				alert("<?php echo $value[68];?>");
				return;
			}

			$.ajax({
				url: 'setSchedule.php',
				dataType: 'text',
				type: 'post',
				contentType: 'application/x-www-form-urlencoded',
				data: {"id" : id, "day" : day, "time" : time},
				success: function( data, textStatus, jQxhr ){
					if (data == 0)
						alert("<?php echo $value[64];?>");
					else if (data == 1)
						alert("<?php echo $value[77];?>");
					else
						alert("<?php echo $value[69];?>");
				},
				error: function( jqXhr, textStatus, errorThrown ){
					console.log( errorThrown );
				}
			});
		}

		function deleteSchedule(id){ 
			var r = confirm("<?php echo $value[79]; ?>");
			if (r == true) {
			    window.location.href = "deleteSchedule.php?id="+id;
			}
		}

		function deleteBGM(id){ 
			var r = confirm("<?php echo $value[79]; ?>");
			if (r == true) {
			    window.location.href = "deleteBGM.php?id="+id;
			}
		}

		$(document).ready(function(){
			var webPlayAudio = document.getElementById("webPlayAudio");
			var mPage = "<?=$p?>";
			if(mPage == "s") menuItem(9);
			if(mPage == "b") menuItem(10);
			webPlayAudio.volume = 1;
	  		var timer;
			var percent = 0;

			$('#audioProgress').val(<?=$dvValue?> * 100);

			webPlayAudio.addEventListener("playing", function(_event) {
			  var duration = _event.target.duration;
			});
			webPlayAudio.addEventListener("pause", function(_event) {
			  clearTimeout(timer);
			});
			var startTimer = function(duration, element){ 
			  if(percent < 100) {
			    timer = setTimeout(function (){advance(duration, element)}, 100);
			  }
			}

			$('#audioContent').on('keyup', function() {
				var id = $('#audioID').val();
				var content = $(this).val();
				if (!id) {
					alert("<?php echo $value[63];?>");
					return;
				} else {
					$.ajax({
				    url: 'updateAudioInfo.php',
			        dataType: 'text',
			        type: 'post',
			        contentType: 'application/x-www-form-urlencoded',
			        data: {"audioID" : id, "content" : content},
			        success: function( data, textStatus, jQxhr ){
			            console.log(data);
			        },
			        error: function( jqXhr, textStatus, errorThrown ){
			            console.log( errorThrown );
			        }
					});
				}
			})

			// $('#audioEventPort').on('keyup', function() {
			// 	var id = $('#eventAudioID').val();
			// 	var port = $(this).val();
			// 	if (!id) {
			// 		alert("<?php echo $value[63];?>");
			// 		return;
			// 	} else {
			// 		$.ajax({
			// 	    url: 'updateAudioInfo.php',
			//         dataType: 'text',
			//         type: 'post',
			//         contentType: 'application/x-www-form-urlencoded',
			//         data: {"id" : id, "port" : port},
			//         success: function( data, textStatus, jQxhr ){
			//             console.log(data);
			//         },
			//         error: function( jqXhr, textStatus, errorThrown ){
			//             console.log( errorThrown );
			//         }
			// 		});
			// 	}
			// })

			// $("#uploadAudio").click(function() {
			// 	var id = $('#audioID').val();
			// 	if (!id) {
			// 		alert("<?php echo $value[63];?>");
			// 		return;
			// 	} else {
			// 		var fd = new FormData();
	        // 		var files = $('#audioFile')[0].files;
	        
			// 		// Check file selected or not
			// 		if(files.length > 0 ){
			// 			var r = confirm("Are you sure you want to upload this file?");
			// 			if (r == true) {
			// 				fd.append('id', id);
			// 				fd.append('audioFile',files[0]);
			// 				$.ajax({
			// 					url: 'updateAudioInfo.php',
			// 					type: 'post',
			// 					data: fd,
			// 					contentType: false,
			// 					processData: false,
			// 					success: function(response){
			// 						if(response != 0){
			// 							alert("<?php echo $value[65];?>"); // Display image element
			// 						}else{
			// 							alert("<?php echo $value[66];?>");
			// 						}
			// 					},
			// 				});
			// 			}
			// 		}else{
			// 			alert("<?php echo $value[63];?>");
			// 		}
			// 	}
    		// })


			$("#uploadAudio").click(function() {
				var id = $('#audioID').val();
				if (!id) {
					alert("<?php echo $value[63];?>");
					return;
				} else {
					$('form[name=formaudio]').submit();
				}
			});

			$('#bgmipsave').click(function() {
				var bgmip = $('#bgmip').val();
				if (!bgmip) {
					alert("<?php echo $value[63];?>");
					return;
				} else {
					$.ajax({
						url: 'bgmipaddress.php',
						dataType: 'text',
						type: 'post',
						contentType: 'application/x-www-form-urlencoded',
						data: {"bgmip" : bgmip},
						success: function( data, textStatus, jQxhr ){
							alert("<?php echo $value[65];?>"); 
						},
						error: function( jqXhr, textStatus, errorThrown ){
							console.log( errorThrown );
						}
					});
				}
			})

			$('#bgmstart').click(function() {
				var bgmip = $('#bgmip').val();
				if (!bgmip) {
					alert("<?php echo $value[63];?>");
					return;
				} else {
					$.ajax({
						url: 'bgmipstart.php',
						dataType: 'text',
						type: 'post',
						contentType: 'application/x-www-form-urlencoded',
						data: {"bgmip" : bgmip},
						success: function( data, textStatus, jQxhr ){
							console.log(data);
						},
						error: function( jqXhr, textStatus, errorThrown ){
							console.log( errorThrown );
						}
					});
				}
			})

			$('#bgmstop').click(function() {
				$.ajax({
					url: 'bgmipstop.php',
					dataType: 'text',
					type: 'post',
					contentType: 'application/x-www-form-urlencoded',
					data: {"id" : ""},
					success: function( data, textStatus, jQxhr ){
						let response = JSON.parse(data);
					},
					error: function( jqXhr, textStatus, errorThrown ){
						console.log( errorThrown );
					}
				});
			})


	})
	</script>

	<script language="javascript">
		var intervalVar; 
		function RefreshImage() {
			if(intervalVar) {
				clearInterval(intervalVar);
			}
			document.getElementById("pic0").setAttribute("src", "img/03.png?a=" + String(Math.random()*99999999));

			intervalVar = setTimeout(function() {
				RefreshImage();
			}, 100);
		}
	</script>
	<title>EMCALL</title>
	<body onload="RefreshImage()">
		<!-- <audio id="scheduleAudio" src="" controls style="display: none;"></audio> -->
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
					<div style="float: left;width: 170px;height: 450px;background-color: #536372;">
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
							<span class="menu">&nbsp;<?php echo $value[50]; ?></span>
						</div>
						<div class="container" onclick="menuItem(7);">
							<span class="menu">&nbsp;<?php echo $value[30]; ?></span>
						</div>
						<div class="container" onclick="menuItem(8);">
							<span class="menu">&nbsp;<?php echo $value[40]; ?></span>
						</div>
					</div>
					<div style="float: right;width: 600px;height: 450px;background-color: #ddd;font-size: 14px;padding-left: 30px;">
						<!--System Information-->
						<div id="content1" style="display: block;">
							<div class="subtitle"><span><?php echo $value[7]; ?></span></div>
							<div class="sub_content">
								<div class="listdiv">
									<div class="left200"><span>EMCALL </span></div>
									<div class="right230"><span style="color: #808080;">Version 2.0</span></div>
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
						<!---Network Setup-->
						<div id="content2" style="display: none;">
							<div class="subtitle"><span><?php echo $value[11]; ?></span></div>
							<div class="sub_content">
								<div class="listdiv">
									<div class="left200"><span>IP Setup</span></div>
									<div class="right230">
									<div>
										<input type="radio" value="static" name="group1" checked>Static
										<input type="radio" value="dhcp" name="group1" style="margin-left:35px;">DHCP
									</div>
									</div>
								</div>
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
										<input type="submit" name="<?php echo $value[10]; ?>" value="<?php echo $value[10]; ?>">
									</div>
									<div class="listdiv" style="padding-top: 30px;">
										<div class="left200"><span><?php echo $value[81]; ?></span></div>
										<div class="right230">
											<input type="text" name="bgmip" id="bgmip" value="<?php echo $bgmipValue; ?>">
											<input type="button" id="bgmipsave" name="bgmipsave" value="<?php echo $value[10]; ?>">
										</div>
									</div>
									<div class="listdiv" style="padding-left: 180px;  padding-top: 10px;">
										<input type="button" id="bgmstart"  name="bgmstart" value="<?php echo $value[82]; ?>">
										<input type="button" id="bgmstop"  name="bgmstop" value="<?php echo $value[83]; ?>">
									</div>
								</form>
							</div>
						</div>	
						<!--Camera Setup-->
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
						<!--Audio Setup-->
						<div id="content6" style="display: none;">
							<div class="subtitle"><span><?php echo $value[50]; ?></span></div>
							<div class="sub_content" style="padding: 10px;height: 375px;">
								<form method="post" enctype="multipart/form-data" name="formaudio" action="updateAudioInfo.php">
								<div class="listdiv" style="display: flex;">
									<div class="left200"><span><?php echo $value[51]; ?></span></div>
									<div class="right230">
										<select id="audioID" name="audioID" style="float:left;" onChange="selectAudio()">
											<option></option>
											<option value="BGM">BGM</option>
											<?php
												for($i=1; $i<=50; $i++) {
											?>
											<option value="<?=$i?>"><?=$i?></option>
											<?php } ?>
										</select>
										<span style="float:left;margin-left:3px;margin-top: 4px;"><?php echo $value[58]; ?>:</span>
										<input id="audioContent" style="float:left;margin-left:5px;width: 100px;" type="text" />
										<img id="bgmList" name="bgmList" src="img/schedule-play.svg" style="width:20px; float:left; margin-left: 10px; margin-top: 3px; cursor: pointer;visibility: hidden;" onclick="menuItem(10);" />
									</div>
								</div>
								<div class="listdiv" style="display: flex;">
									<div class="left200"></div>
									<div class="right230">
										<input type="file" accept="audio/mp3,audio/wav" name="audioFile[]" id="audioFile" class="ring_wav"  multiple>
										<input type="button" id="uploadAudio" name="<?php echo $value[51]; ?>" value="<?php echo $value[51]; ?>">
									</div>
								</div>
								</form>
								<div class="listdiv" style="display: flex;">
									<div class="left200"><span><?php echo $value[52]; ?></span></div>
									<div class="right230">
										<span style="float:left;margin-top: 4px;"><?php echo $value[59]; ?>:</span>
										<select id="eventAudioID" style="float:left;margin-left:5px;" onChange="selectEventAudio()">
											<option></option>
											<?php
												for($i=1; $i<=50; $i++) {
											?>
											<option value="<?=$i?>"><?=$i?></option>
											<?php } ?>
										</select>
										<span style="float:left;margin-left:10px;margin-top: 4px;"><?php echo $value[60]; ?>:</span>
										<input id="audioEventPort" style="float:left;margin-left:5px;width: 30px;" type="text" value="27" />
									</div>
								</div>
								<div class="listdiv" style="display: flex;">
									<div class="left200"><span><?php echo $value[53]; ?></span></div>
									<div class="right230">
										<select id="devicePlayAudioID" style="float:left;"  onchange="selectDevicePlayAudio()">
											<option></option>
											<option value="BGM">BGM</option>
											<?php
												for($i=1; $i<=50; $i++) {
											?>
											<option value="<?=$i?>"><?=$i?></option>
											<?php } ?>
										</select>
										<span style="float:left;margin-left:10px;margin-top: 4px;"><?php echo $value[58]; ?>:</span>
										<input id="devicePlayContent" style="float:left;margin-left:5px;width: 100px;" type="text" />
										<img onclick="devicePlay()" src="img/play.png" style="width:20px; float:left; margin-left:5px; margin-top: 3px; cursor: pointer;" />
										<img onclick="deviceStop()" src="img/stop.png" style="width:20px; float:left; margin-left:5px; margin-top: 3px; cursor: pointer;" />
									</div>
								</div>
								<div class="listdiv" style="display: flex;">
									<div class="left200"><span><?php echo $value[54]; ?></span></div>
									<div class="right230">
										<span style="float:left;margin-top: 4px;"><?php echo $value[61]; ?>:</span>
										<select id="deviceVolume" style="float:left;margin-left:10px;" onchange="changeDeviceVolume()">
											<option value="0" <?php if($dvValue == 0) {?> selected <?php }?>>0%</option>
											<option value="10" <?php if($dvValue == 10) {?> selected <?php }?>>10%</option>
											<option value="20" <?php if($dvValue == 20) {?> selected <?php }?>>20%</option>
											<option value="30" <?php if($dvValue == 30) {?> selected <?php }?>>30%</option>
											<option value="40" <?php if($dvValue == 40) {?> selected <?php }?>>40%</option>
											<option value="50" <?php if($dvValue == 50) {?> selected <?php }?>>50%</option>
											<option value="60" <?php if($dvValue == 60) {?> selected <?php }?>>60%</option>
											<option value="70" <?php if($dvValue == 70) {?> selected <?php }?>>70%</option>
											<option value="80" <?php if($dvValue == 80) {?> selected <?php }?>>80%</option>
											<option value="90" <?php if($dvValue == 90) {?> selected <?php }?>>90%</option>
											<option value="100" <?php if($dvValue == 100) {?> selected <?php }?>>100%</option>
										</select>
										<span style="float:left;margin-left:10px;margin-top: 13px;font-size: 13px;"><?php echo $value[62]; ?></span>
									</div>
								</div>
								<div class="listdiv" style="display: flex;height: 125px;">
									<div class="left200"><span><?php echo $value[56]; ?></span></div>
									<div class="right230">
										<img name="pic0" id="pic0" src="img/03.png" style="width: 180px; float: left; margin-left: 10px; margin-top: -8px;" />

										<img onclick="levelPlay(0)" src="img/play.png" style="width:20px; float:left; margin-left:5px; margin-top: 3px; cursor: pointer;" />
										<img onclick="levelPlay(1)" src="img/stop.png" style="width:20px; float:left; margin-left:5px; margin-top: 3px; cursor: pointer;" />
									</div>
								</div>
								<div class="listdiv" style="display: flex;">
									<div class="left200"><span><?php echo $value[55]; ?></span></div>
									<div class="right230">
										<select id="scheduleDaySelect" style="float:left;">
											<option value="sunday"><?php echo $value[70]; ?></option>
											<option value="monday"><?php echo $value[71]; ?></option>
											<option value="tuesday"><?php echo $value[72]; ?></option>
											<option value="wednesday"><?php echo $value[73]; ?></option>
											<option value="thursday"><?php echo $value[74]; ?></option>
											<option value="friday"><?php echo $value[75]; ?></option>
											<option value="saturday"><?php echo $value[76]; ?></option>
										</select>
										<input id="scheduleTimeSelect" style="float:left; margin-left:5px;" type="time" />
										<select id="scheduleAudioID" style="float:left; margin-left:5px;">
											<option></option>
											<?php
												for($i=1; $i<=50; $i++) {
											?>
											<option value="<?=$i?>"><?=$i?></option>
											<?php } ?>
										</select>
										<img id="scheduleList" src="img/schedule-play.svg" style="width:20px; float:left; margin-left: 10px; margin-top: 3px; cursor: pointer;" onclick="menuItem(9);" />
										<img src="img/save.png" style="width:20px; float:left; margin-left: 10px; margin-top: 3px; cursor: pointer;" onclick="setSchedule();" />
									</div>
								</div>
								<div class="listdiv" style="display: flex;">
									<div class="left200"><span><?php echo $value[57]; ?></span></div>
									<div class="right230">
										<select id="webPlayAudioID" style="float:left;" onchange="selectWebPlayAudio()">
											<option></option>
											<?php
												for($i=1; $i<=50; $i++) {
											?>
											<option value="<?=$i?>"><?=$i?></option>
											<?php } ?>
										</select>
										<audio id="webPlayAudio" src="" controls style="display: none;"></audio>
										<span style="float:left;margin-left:10px;margin-top: 4px;"><?php echo $value[58]; ?>:</span>
										<input id="webPlayContent" style="float:left;margin-left:5px;width: 120px;" type="text" />
										<img id="playWebAudio" src="img/play.png" style="width:20px; float:left; margin-left:5px; margin-top: 3px; cursor: pointer;" onclick="playWebAudio()" />
										<img id="stopWebAudio" src="img/stop.png" style="width:20px; float:left; margin-left:5px; margin-top: 3px; cursor: pointer;" onclick="stopWebAudio()" />
									</div>
								</div>
							</div>
						</div>	

						<!-- Schedule List -->
						<div id="content9" style="display: none;">
							<div class="subtitle"><span><?php echo $value[78]; ?></span></div>
							<div class="sub_content">
								<div class="listdiv" style="overflow-y: scroll; margin-left: 0px; height: 230px;">
									<?php 
										$handle = fopen("schedule.txt", "r");
										if ($handle) {
											$i = 0;
										  while (($line = fgets($handle)) !== false) {
										  	$info = explode(',', $line);
									?>
										<div style="width: 99%; border-top: 1px; border-bottom: 1px; border-left: 1px; border-style: solid; height: 20px; text-align: center;border-color: #c3bebe;">
											<div style="width: 5%;float: left;"><?php echo trim($info[0]); ?></div>
											<div style="width: 25%;float: left;"><?php echo trim($info[1]); ?></div>
											<div style="width: 25%;float: left;"><?php echo trim($info[2]); ?></div>
											<div style="width: 25%;float: left;"><?php echo trim($info[3]); ?></div>
											<div style="width: 20%;float: left;">
												<img src="img/close.png" style="width: 20px;cursor: pointer;" 
												onclick="deleteSchedule(<?php echo trim($info[0]); ?>)">
											</div>
										</div>
									<?php 				
												$i++;
											}
											fclose($handle);
										} else {
										    // error opening the file.
										} 
									?>
								</div>
							</div>
						</div>

						<!-- BGM List -->
						<div id="content10" style="display: none;">
							<div class="subtitle"><span><?php echo $value[81]; ?></span></div>
							<div class="sub_content">
								<div class="listdiv" style="overflow-y: scroll; margin-left: 0px; height: 230px;">
									<?php 
										$handle = fopen("bgm.txt", "r");
										if ($handle) {
											$i = 0;
										  while (($line = fgets($handle)) !== false) {
										  	$info = trim($line);
									?>
										<div style="width: 99%; border-top: 1px; border-bottom: 1px; border-left: 1px; border-style: solid; height: 20px; text-align: center;border-color: #c3bebe;">
											<div style="width: 80%;float: left;text-align: left;"><?php echo trim($info); ?></div>
											<div style="width: 20%;float: left;">
												<img src="img/close.png" style="width: 20px;cursor: pointer;"  onclick="deleteBGM('<?php echo trim($info); ?>')">
											</div>
										</div>
									<?php 				
												$i++;
											}
											fclose($handle);
										} else {
										    // error opening the file.
										} 
									?>
								</div>
							</div>
						</div>


						<!--Add User-->
						<div id="content7" style="display: none;">
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
										        if(trim($line) != ""){		
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
						<div id="content8" style="display: none;">
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
			<div class="footer">Copyright ⓒ AEPEL All rights reserved. ☎ 031-945-5830</div>
		</div>
	</body>
</html>