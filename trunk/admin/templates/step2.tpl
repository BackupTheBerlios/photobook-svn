<?php include('templates/header_install.tpl') ?>

<h2>Database Settings</h2>
Please enter your database information.
<form action="install.php" method="post" onSubmit="return validate(this)">
<input type="hidden" name="step" value="3" />
<table>
    <tr>
        <td>
            <h3>Database host</h3>
            The hostname for your database server
        </td><td>
            <input type="text" name="host" value="localhost" />
        </td>
    </tr><tr>
        <td>
            <h3>Database user</h3>
            The username used to connect to your database
        </td><td>
            <input type="text" name="username" value="photobook" />
        </td>
    </tr><tr>
        <td>
            <h3>Database password</h3>
            The password matching the above username
        </td><td>
            <input type="password" name="password" />
        </td>
    </tr><tr>
        <td>
            <h3>Database name</h3>
            The name of your database
        </td><td>
            <input type="text" name="name" value="photobook" />
        </td>
    </tr><tr>
        <td>
            <h3>Database table prefix</h3>
            Prefix for the table names, e.g. photobook_
        </td><td>
            <input type="text" name="prefix" value="pb_" />
        </td>
    </tr>
</table>
<input type="submit" value="Complete Installation"/>
</form>

<?php include('templates/footer_install.tpl') ?>
