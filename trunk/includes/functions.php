<?php

function CleanInput($value)
{
   // Stripslashes
   if (get_magic_quotes_gpc()) {
       $value = stripslashes($value);
   }
   // Quote if not integer
   if (!is_numeric($value)) {
       $value = mysql_real_escape_string($value);
   }
   return $value;
}

function GetConfigItems()
{
    global $db_prefix;
    
    $query = "SELECT * FROM ${db_prefix}config";
    
    $result = mysql_query($query);
    if ($row = mysql_fetch_array($result))
    {
        $value = $row;
    }
    
    // Convert special fields from string to correct value
    if (strtolower($value['mod_rewrite']) == '1')
    {
        $value['mod_rewrite'] = true;
    }
    else
    {
        $value['mod_rewrite'] = false;
    }
        
    return $value;
}

function MakeImageURL($id)
{
    global $config;
    
    if ($config['mod_rewrite'])
    {
        return "image/".$id;
    }
    else
    {
        return "index.php?image=".$id;
    }
}

function MakePageURL($page)
{
    global $config;
            
    if ($config['mod_rewrite'])
    {
        return $page;
    }
    else
    {
        return "index.php?page=".$page;
    }
}

function SetImage(&$tpl, $image, $prefix)
{
    $tpl->set($prefix.'_title', $image['title']);
    $tpl->set($prefix.'_permalink', $image['permalink']);
    $tpl->set($prefix.'_url', $image['url']);
    $tpl->set($prefix.'_thumbnail', $image['thumbnail']);
    $tpl->set($prefix.'_width', $image['width']);
    $tpl->set($prefix.'_height', $image['height']);
    $tpl->set($prefix.'_date', $image['date']);
    $tpl->set($prefix.'_body', $image['body']);
}

function GetImageFromQuery($query)
{
    $result = mysql_query($query);
    
    $row = null;
    
    $images = Array();
    
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
    {
        // Set image object
        $row['url'] = 'images/'.$row['image'];
        $row['thumbnail'] = 'thumbnails/'.$row['image'];
        $row['permalink'] = MakeImageURL($row['id']);
        $row['body'] = nl2br($row['body']);
        list($width, $height, $type, $attr) = getimagesize($row['url']);
        $row['width'] = $width;
        $row['height'] = $height;
        list($width, $height, $type, $attr) = getimagesize($row['thumbnail']);
        $row['thumbwidth'] = $width;
        $row['thumbheight'] = $height;
        
        $images[] = $row;
    }

    return $images;
}

function GetCountFromQuery($query)
{
    $result = mysql_query($query);
    
    $row = null;
    
    if ($row = mysql_fetch_array($result))
    {
        return $row['count'];
    }
    
    return 0;
}

function ConnectToDatabase()
{
    global $db_server, $db_username, $db_password, $db_name;

    mysql_connect($db_server, $db_username, $db_password) or die("Couldn't Connect to Server " . mysql_error() . "<br /");
    mysql_select_db($db_name) or die("Database not found " . mysql_error());
}

function Redirect($to)
{
  $schema = $_SERVER['SERVER_PORT'] == '443' ? 'https' : 'http';
  $host = strlen($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:$_SERVER['SERVER_NAME'];
  $self = dirname($_SERVER['PHP_SELF']);
  if (headers_sent()) return false;
  else
  {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: $schema://$host$self/$to");
    exit();
  }
}

?>