<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

require('includes/config.php');
require('includes/functions.php');
require('includes/template.class.php');

ConnectToDatabase();

$tpl = new Template();

// Get config from database
$config = GetConfigItems();

$tpldir = 'templates/'.$config['template_dir'];
$tpl->set('template_dir', $tpldir);
$tpl->set('site_title', $config['site_title']);

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
    SetImage($tpl, $current_image, 'image');
    
    // Look up previous and next
    $query = "SELECT * FROM ${db_prefix}entry WHERE date<'".$current_image['date']."' ORDER BY date desc LIMIT 1";
    $previous_image = GetImageFromQuery($query);
    SetImage($tpl, $previous_image, 'previous');
    
    $query = "SELECT * FROM ${db_prefix}entry WHERE date>'".$current_image['date']."' ORDER BY date asc LIMIT 1";
    $next_image = GetImageFromQuery($query);
    SetImage($tpl, $next_image, 'next');
}

$filename = "image.tpl";

if (isset($_GET['page']))
{
    if (file_exists($tpldir.$_GET['page'].".tpl"))
    {
        $filename = $_GET['page'].".tpl";
    }
}

$tpl->display($tpldir.$filename);

?>
