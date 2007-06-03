{config_load file="/libs/lang.conf"}

{php}

if(isset($_POST["process"])) {
	switch ($_POST["process"]) {
		case 1:
			do_register1();
			break;
		case 2:
			do_register2();
			break;
	}
} else {
	do_register0();
}

{/php}