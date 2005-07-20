<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

require('libs/Smarty/Smarty.class.php');
require('includes/config.php');
require('includes/functions.php');

ConnectToDatabase();

$smarty = new Smarty();

// Get config from database
$keys = array('site_title', 'template_dir', 'mod_rewrite');
$config = GetConfigItems($keys);

$tpldir = $config['template_dir'];
$smarty->assign('template_dir', $tpldir);
$smarty->assign('site_title', $config['site_title']);
$smarty->assign('mod_rewrite', $config['mod_rewrite']);

// Work out sql query
if (!isset($_GET['image']))
{
    $query = "SELECT * FROM ${db_prefix}entry ORDER BY date desc LIMIT 1";
}
else
{
    $query = "SELECT * FROM ${db_prefix}entry WHERE ID='".CleanInput($_GET['image'])."'";
}

$current_image = GetImageFromQuery($query);

if ($current_image != null)
{
    $smarty->assign('image', $current_image);
    
    // Look up previous and next
    $query = "SELECT * FROM ${db_prefix}entry WHERE date<'".$current_image['date']."' ORDER BY date desc LIMIT 1";
    $previous_image = GetImageFromQuery($query);
    if ($previous_image != null)
    {
        $smarty->assign('previous', $previous_image);
    }
    
    $query = "SELECT * FROM ${db_prefix}entry WHERE date>'".$current_image['date']."' ORDER BY date asc LIMIT 1";
    $next_image = GetImageFromQuery($query);
    if ($next_image != null)
    {
        $smarty->assign('next', $next_image);
    }
}

$tpl = "image.tpl";

if (isset($_GET['page']))
{
    if (file_exists("templates/".$tpldir.$_GET['page'].".tpl"))
    {
        $tpl = $_GET['page'].".tpl";
    }
}

$smarty->display($tpldir.$tpl);

?>
