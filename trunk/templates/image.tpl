<?php include($s_template_dir."header.tpl") ?>

<table class="main">
    <tr>
        <td class="name">
            <?= $s_image_title ?>
        </td>
        <td class="navigation">
            <?= $c_previous_link ?> |
            <?= $c_image_permalink ?> |
            <?= $c_next_link ?>
        </td>
    </tr>
</table>

<table class="main">
    <tr>
        <td colspan="2" class="image">
            <?= $c_image_tag ?>
        </td>
    </tr>
    <tr>
        <td class="info">
            <?= $s_image_date ?> |
            <!-- IMAGE_CATEGORY -->
        </td>
        <td rowspan="3" class="exif">
            <p class="exif">EXIF</p>
            <!-- LANG_CAMERA_MODEL --><br />
            <!-- LANG_EXPOSURE_TIME --><br />
            <!-- LANG_APERTURE --><br />
            <!-- LANG_FOCAL_LENGTH --><br />
            <!-- LANG_FLASH --><br />
            <!-- LANG_ISO -->
        </td>
    </tr>
    <tr>
        <td class="notes">
            <?= $s_image_body ?>
        </td>
    </tr>
    <tr>
        <td colspan="2" class="seperator"></td>
    </tr>
    <tr>
        <td colspan="2" class="thumbrow">
            <?= $c_thumbrow ?>
        </td>
    </tr>
    <tr>
        <td colspan="2" class="seperator"></td>
    </tr>
</table>

<?php include($template_dir."footer.tpl") ?>
