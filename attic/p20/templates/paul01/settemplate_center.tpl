{include file="templates.tpl"}
{php}
	if(isset($_GET['template'])){
		if(file_exists("./templates/".$_GET['template']."/link_summary.tpl")){
			setcookie("template", $_GET['template']);
			header('Location: ./settemplate.php');
		}
	}
{/php}
