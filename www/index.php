<?php
	$line = fopen('language.txt', 'r');
	$lan = fgets($line,1024);

	$value = array();
	if($lan == 0)
	{
		$lines = file('english.txt');
		foreach ($lines as $line_num => $line) {
		   $value[] = htmlspecialchars($line);
		}
	}
	else
	{
		$lines = file('korea.txt');
		foreach ($lines as $line_num => $line) {
		   $value[] = htmlspecialchars($line);
		}
	} 
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>EMCALL</title>
		<link rel="stylesheet" href="css/reset.min.css">
		<!--link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900'>
		<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'-->
		<link rel="stylesheet" href="css/style.css">
		<script src="js/jquery-1.10.2.js"></script>
		<script type="text/javascript">

			function login() {

			var userName      = document.getElementById("userName").value;
			var userPassword  = document.getElementById("userPassword").value;
			
			if(userName == "" || userPassword == "") {

				alert("<?php echo trim($value[47]); ?>");
				return;
			}
			window.location.href = "main.php?userName="+userName+"&userPassword="+userPassword;

		}

		</script>
	</head>
	<body>
		<div class="pen-title"></div>
		<div class="module form-module">
			
			<div class="form">
				<h2><?php echo $value[0]; ?></h2>
				<form method="post" action="login.php">
					<input type="text" name="userName" id="userName" placeholder="<?php echo $value[1]; ?>"/>
					<input type="password" name="userPassword" id="userPassword" placeholder="<?php echo $value[4]; ?>"/>
					<button type="submit"><?php echo trim($value[6]); ?></button>
				</form>
			</div>
			<div class="langDiv">
				<input type="radio" name="lang" class="chk" id="echk" value="0" <?php if($lan == 0) echo "checked='checked'"; ?>><label for="enChk">English</label>
				<input type="radio" name="lang" class="chk" id="kchk" value="1" <?php if($lan == 1) echo "checked='checked'"; ?>><label for="krChk">한국어</label>
			</div>
			<div class="cta"></div>
		</div>
		<script>
			$( "input:radio" ).on( "click", function() {
				var lang = $( "input:radio:checked" ).val();
			  	window.location.href = "language.php?lang=" + lang;
			});
		</script>
	</body>
</html>