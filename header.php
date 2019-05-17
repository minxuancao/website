<?
	$settings = parse_ini_file($_SERVER["DOCUMENT_ROOT"]."/settings.ini", true);
	define("SITE_PATH", getFullServerName());
	$menu = [];
	foreach ($settings as $section_name=>$data)
	{
		if (preg_match_all("/([^.]+)\.([^.]+)/",$section_name,$section_name))
		{
			$menu[$section_name[1][0]][$section_name[2][0]] = [];
			foreach ($data as $title=>$link)
			{
				$menu[$section_name[1][0]][$section_name[2][0]][$title]['link'] = $link.".html";
				$menu[$section_name[1][0]][$section_name[2][0]][$title]['active'] = $link == $_GET['page'];
			}
		}
	}

	function left_side_menu($type)
	{
		global $menu;
		foreach ($menu[$type] as $title=>$menu_data)
		{
			?><h6 class="dropdown-header"><?=$title?></h6><?
			foreach ($menu_data as $title=>$data)
			{
				?><a class="dropdown-item" href="<?= $data["link"] ?>"<?= $data["active"] ? ' class="active"' : "" ?>><?=$title?></a><?
			}
		}
	}
	function prepare_md($txt) {
		$txt = preg_replace("/\.md([^a-zA-Z])/",'.html$1',$txt);
		return $txt;
	}

	function getFullServerName()
	{
		$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5))=='https'? 'https' : 'http';
		if ($_SERVER["SERVER_PORT"] == 443) {
			$protocol = 'https';
		} elseif (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
			$protocol = 'https';
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
			$protocol = 'https';
		}
			
		return $protocol."://".$_SERVER["SERVER_NAME"]."/";
	}
		
?>

<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Logrange Streaming Database.">
	<title>Logrange Streaming Database.</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="../../style.css">
</head>

<body class="<?=PAGE?>">
	<?include("nav.php");?>
	<div class="container px-0 <?=PAGE?>">
		<div class="row <?=PAGE?>">
		
		