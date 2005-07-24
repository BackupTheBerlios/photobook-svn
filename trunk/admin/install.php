<?php
error_reporting(E_ALL ^ E_NOTICE);

require('../includes/functions.php');
require('../includes/template.class.php');

// *****************************************************************************
function CheckFolderPermissions($dir, &$status)
{
    $error = false;
    if (!file_exists($dir)) {
        if (mkdir($dir, 0775)) {
            $status = '<font color="green"><b>Created</b></font>';
        } else {
            $status = '<font color="red"><b>Could not be created</b></font>';
            $error = true;
        }
    } else {
        if (is_writeable($dir)) {
            $status = '<font color="green"><b>Writeable</b></font>';
        } else {
            $status = '<font color="red"><b>Not writeable</b></font>';
            $error = true;
        }
    }

    return $error;
}

function Step1()
{
    $error = false;

    $dirpath = realpath('../');
    if (is_writeable($dirpath)) {
        $dirstatus = '<font color="green"><b>Writeable</b></font>';
    } else {
        $dirstatus = '<font color="red"><b>Not writeable</b></font>';
        $error = true;
    }
    
    $imagepath = realpath('../images');
    $error = $error || CheckFolderPermissions($imagepath, $imagestatus);
    
    $thumbpath = realpath('../thumbnails');
    $error = $error || CheckFolderPermissions($thumbpath, $thumbstatus);    

    if ($error)
    {
        $endmsg = 'There were some errors in the diagnosis. Please fix the errors and then check the installation again.<br /><a href="install.php">Recheck installation</a>';
    }
    else
    {
        $endmsg = '<form action="install.php" method="post"><input type="hidden" name="step" value="2" /><input type="submit" value="Continue Installation"/>
</form>';
    }
    
    $tpl = new Template('templates/step1.tpl');
    
    $tpl->set('step', '1');
    $tpl->set('dirpath', $dirpath);
    $tpl->set('dirstatus', $dirstatus);
    $tpl->set('imagepath', $imagepath);
    $tpl->set('imagestatus', $imagestatus);
    $tpl->set('thumbpath', $thumbpath);
    $tpl->set('thumbstatus', $thumbstatus);
    $tpl->set('endmsg', $endmsg);
    
    $tpl->display();
}

function Step2()
{
    $tpl = new Template('templates/step2.tpl');
    
    $tpl->set('step', '2');
    
    $tpl->display();
}

function CreateConfigFile($server, $username, $password, $name, $prefix)
{
    $filename = '../config.php';
    
    if (!$handle = fopen($filename, 'w'))
    {
        echo "Cannot create config file";
        return false;
    }
    
    $content = '<?php

$db_server = "'.$server.'";
$db_username = "'.$username.'";
$db_password = "'.$password.'";
$db_name = "'.$name.'";
$db_prefix = "'.$prefix.'";

?>';
    
    if (!fwrite($handle, $content))
    {
        echo "Cannot write config file";
        return false;
    }
    
    fclose($handle);
    
    return true;
}

function CreateDatabase($host, $username, $password, $name, $prefix)
{
    mysql_connect($host, $username, $password) or die ("Error: ".mysql_error());
    echo "Connected to database<br />";

    mysql_query('CREATE DATABASE '.$name) or die ("Error: ".mysql_error());
    echo "Database created<br />";
    
    mysql_select_db($name);
    
    $query = "CREATE TABLE ${prefix}categories (
        id int(11) NOT NULL auto_increment, 
        category varchar(150) NOT NULL default '', 
        PRIMARY KEY  (id)
        )";
    mysql_query($query) or die ("Error: ".mysql_error());
    echo "Table ${prefix}categories created<br />";
    
    $query = "CREATE TABLE ${prefix}config (
        version int(11) NOT NULL default 0,
        site_title varchar(128) NOT NULL default '',
        template_dir varchar(128) NOT NULL default '',
        mod_rewrite int(1) NOT NULL default 0,
        thumbtotal int(8) NOT NULL default 0
        )";
    mysql_query($query) or die ("Error: ".mysql_error());
    echo "Table ${prefix}config created<br />";
    
    $query = "CREATE TABLE ${prefix}entry (
        id int(11) NOT NULL auto_increment,
        date datetime NOT NULL default '0000-00-00 00:00:00',
        title varchar(150) NOT NULL default '',
        body text NOT NULL,
        image varchar(150) NOT NULL default '',
        PRIMARY KEY  (id),
        KEY datetime (date)
        )";
    mysql_query($query) or die ("Error: ".mysql_error());
    echo "Table ${prefix}entry created<br />";
    
    $query = "CREATE TABLE ${prefix}entrycat (
        cat_id int(11) NOT NULL default 0,
        entry_id int(11) NOT NULL default 0,
        KEY cat_id (cat_id),
        KEY entry_id (entry_id)
        )";
    mysql_query($query) or die ("Error: ".mysql_error());
    echo "Table ${prefix}entrycat created<br />";
    
    $query = "CREATE TABLE ${prefix}users (
        id int(11) NOT NULL auto_increment,
        name varchar(32) NOT NULL default '',
        password varchar(32) NOT NULL default '',
        PRIMARY KEY  (id)
        )";
    mysql_query($query) or die ("Error: ".mysql_error());
    echo "Table ${prefix}users created<br />";
    
    $query = "INSERT INTO ${prefix}categories (category) VALUES ('Default');";
    mysql_query($query) or die ("Error: ".mysql_error());
    $query = "INSERT INTO ${prefix}config (version, thumbtotal) VALUES (1, 5);";
    mysql_query($query) or die ("Error: ".mysql_error());
    echo "Default data inserted<br />";
}

function Step3()
{
    $tpl = new Template();
    
    $tpl->set('step', '3');
    
    $tpl->display('templates/header_install.tpl');

    if (CreateConfigFile($_POST['host'], 
        $_POST['username'], 
        $_POST['password'],
        $_POST['name'],
        $_POST['prefix']))
    {
        echo 'Config file created successfully';
    }
    else
    {
        echo 'Could not create config file';
    }
    echo '<br/>';
    
    CreateDatabase($_POST['host'], 
        $_POST['username'], 
        $_POST['password'],
        $_POST['name'],
        $_POST['prefix']);
        
    echo 'Congratulations. You have successfully installed photobook.<br />Go <a href="../index.php">here</a> to see your site.';
    
    $tpl->display('templates/footer_install.tpl');
}

// *****************************************************************************
if (!isset($_POST['step']))
{
    if (file_exists('../config.php'))
    {
        redirect('../index.php');
        exit();
    }
    $step = 1;
}
else
{
    $step = $_POST['step'];
}

switch ($step) {
    case 1:
        Step1();
        break;
    case 2:
        Step2();
        break;
    case 3:
        Step3();
        break;
    default:
        Step1();
        break;
}

?>