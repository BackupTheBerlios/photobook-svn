<?php
error_reporting(E_ALL ^ E_NOTICE);

require('includes/functions.php');

if (!file_exists('config.php'))
{
    redirect('admin/install.php');
    exit();
}

require('config.php');
require('includes/template.class.php');

ConnectToDatabase();

$tpl = new Template();

// Get config from database
$config = GetConfigItems();

$tpldir = 'templates/'.$config['template_dir'];
$tpl->set('template_dir', $tpldir);
$tpl->set('site_title', $config['site_title']);

// *****************************************************************************
// Set up the filename
$filename = "image.tpl";

if (isset($_GET['page']))
{
    if (file_exists($tpldir.$_GET['page'].".tpl"))
    {
        $filename = $_GET['page'].".tpl";
    }
    else
    {
        // Error finding page. Produce error page and stop processing.
        $page_error = '404 Not Found';
        $tpl->set('page_error', $page_error);
        if (!headers_sent())
        {
            header("HTTP/1.1 404 Not Found");
        }
        if (file_exists($tpldir.'error.tpl'))
        {
            $filename = 'error.tpl';
            $tpl->display($tpldir.$filename);
        }
        else
        {
            echo "<html><head><title>${page_error}</title></head><body><h1>${page_error}</h1></body></html>";
        }
        exit();
    }
}

// *****************************************************************************
// Work out sql query for current image
if (!isset($_GET['image']))
{
    $query = "SELECT * FROM ${db_prefix}entry ORDER BY date desc LIMIT 1";
}
else
{
    $query = "SELECT * FROM ${db_prefix}entry WHERE ID='".CleanInput($_GET['image'])."'";
}
$current_image_array = GetImageFromQuery($query);

if (count($current_image_array) < 1)
{
    // redirect to admin login
    //Redirect("admin/index.php");
    exit();
}

$current_image = $current_image_array[0];
SetImage($tpl, $current_image, 'image');
    
if ($current_image != null)
{
    // Look up previous and next
    $query = "SELECT * FROM ${db_prefix}entry WHERE date<'".$current_image['date']."' ORDER BY date desc LIMIT 1";
    $previous_image = GetImageFromQuery($query);
    if (count($previous_image) > 0)
    {
        $previous_image = $previous_image[0];
        SetImage($tpl, $previous_image, 'previous');
    }
    
    $query = "SELECT * FROM ${db_prefix}entry WHERE date>'".$current_image['date']."' ORDER BY date asc LIMIT 1";
    $next_image = GetImageFromQuery($query);
    if (count($next_image) > 0)
    {
        $next_image = $next_image[0];
        SetImage($tpl, $next_image, 'next');
    }
}

// *****************************************************************************
// get the thumbnails
if (!isset($_GET['image']))
{
    $query = "SELECT * FROM ${db_prefix}entry ORDER by date desc limit ${config['thumbtotal']}";
    $thumbs = array_reverse(GetImageFromQuery($query));
}
else
{
    $thumbhalf = ($config['thumbtotal']-1)/2;
    $lcount = GetCountFromQuery("SELECT count(*) as count from ${db_prefix}entry WHERE date<'".$current_image['date']."'");
    $rcount = GetCountFromQuery("SELECT count(*) as count from ${db_prefix}entry WHERE date>'".$current_image['date']."'");
    $llimit = $thumbhalf;
    $rlimit = $thumbhalf;
    if ($lcount < $thumbhalf)
    {
        $rlimit = $rlimit + $thumbhalf - $lcount;
    }
    if ($rcount < $thumbhalf)
    {
        $llimit = $llimit + $thumbhalf - $rcount;
    }
    
    $query = "SELECT * FROM ${db_prefix}entry WHERE date<'".$current_image['date']."' ORDER BY date desc limit ${llimit}";
    $thumbs1 = array_reverse(GetImageFromQuery($query));
    $query = "SELECT * FROM ${db_prefix}entry WHERE date>'".$current_image['date']."' ORDER BY date asc limit ${rlimit}";
    $thumbs2 = GetImageFromQuery($query);
    
    $thumbs = array_merge($thumbs1, $current_image_array, $thumbs2);
}
for ($i = 0; $i < count($thumbs); $i++)
{
    $thumbs[$i]['current'] = $thumbs[$i]['id'] == $current_image['id'];
}
$tpl->set('thumbs', $thumbs);

$tpl->display($tpldir.$filename);

?>
