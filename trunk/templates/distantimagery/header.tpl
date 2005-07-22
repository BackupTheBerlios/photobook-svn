<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
<title><?=$site_title;?></title>
<link rel="stylesheet" href="<?=$template_dir;?>styles.css" type="text/css" />
</head>

<body>
<div id="wrapper">

<table class="header">
    <tr>
        <td class="title">
            <?=$site_title;?>
        </td>
        <td class="menu">
            <a href="index.php">Current</a> | 
            <a href="<?=MakePageURL("about");?>">About</a> | 
            Archives
        </td>
    </tr>
    <tr>
        <td colspan="2" class="seperator"></td>
    </tr>
</table>
