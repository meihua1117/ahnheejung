<?php
	
	$ip_address   = $_POST['ip_address'];
	$mask         = $_POST['mask'];
	$gatway       = $_POST['gatway'];

	$network = "";
	$network .= "# interfaces(5) file used by ifup(8) and ifdown(8)\n";
	$network .= "# Include files from /etc/network/interfaces.d:\n";
	$network .= "source-directory /etc/network/interfaces.d\n\n";

	$network .= "#auto wlan1\n";
	$network .= "#iface wlan1 inet dhcp\n";
	$network .= "#wpa-ssid xunlong_orangepi\n";
	$network .= "#wpa-psk xunlong_orangepi_12345678\n\n";

	$network .= "#auto eth0      # ou auto enp0s7 (see  ifconfig)\n";
	$network .= "#iface eth0 inet static\n";
	$network .= "#        address ".$ip_address."\n";
	$network .= "#        netmask ".$mask."\n"; 
	$network .= "#        gateway ".$gatway."\n\n";

	$network .= "#DHCP Setup\n";
	$network .= "auto eth0\n";
	$network .= "	allow-hotplug eth0\n";
	$network .= "	iface eth0 inet dhcp\n";

	$netfile = fopen("../../../etc/network/interfaces", "w") or die("Unable to open file!");
	fwrite($netfile, $network);
	fclose($netfile);
	

	$commads = $ip_address.",";
	$commads .= $mask.",";
	$commads .= $gatway;

	$netfile = fopen("dhcp.txt", "w") or die("Unable to open file!");
	fwrite($netfile, $commads);
	fclose($netfile);


?>