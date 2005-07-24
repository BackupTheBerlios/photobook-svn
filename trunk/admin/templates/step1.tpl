<?php include('templates/header_install.tpl') ?>

Welcome to the Photobook Installation.<br />
This page will diagnose your current setup and tell you if there are any problems.<br />

<h2>Directories</h2>
<table>
    <tr>
        <td>
            <?=$dirpath?>
        </td><td>
            <?=$dirstatus?>
        </td>
    </tr><tr>
        <td>
            <?=$imagepath?>
        </td><td>
            <?=$imagestatus?>
        </td>
    </tr><tr>
        <td>
            <?=$thumbpath?>
        </td><td>
            <?=$thumbstatus?>
        </td>
    </tr>
</table>

<?= $endmsg ?>

<?php include('templates/footer_install.tpl') ?>
