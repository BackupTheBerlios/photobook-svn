<?php include($template_dir."header.tpl") ?>

<table class="main">
    <tr>
        <td class="name">
            <?= $image_title ?>
        </td>
        <td class="navigation">
            <?php if ($previous_permalink): ?>
            <a href="<?= $previous_permalink ?>">Previous</a>
            <?php endif ?> |
            <a href="<?= $image_permalink ?>">Permalink</a> |
            <?php if ($next_permalink): ?>
            <a href="<?= $next_permalink ?>">Next</a>
            <?php endif ?>
        </td>
    </tr>
</table>

<table class="main">
    <tr>
        <td colspan="2" class="image">
            <img src="<?= $image_url ?>" width="<?= $image_width ?>" height="<?= $image_height ?>" />
        </td>
    </tr>
    <tr>
        <td class="info">
            <?= $image_date ?> |
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
            <?= $image_body ?>
        </td>
    </tr>
    <tr>
        <td colspan="2" class="seperator"></td>
    </tr>
    <tr>
        <td colspan="2" class="thumbrow">
            <?php foreach($thumbs as $thumb): ?><a href="<?= $thumb['permalink'] ?>"><img src="<?= $thumb['thumbnail'] ?>" title="<?= $thumb['title'] ?>" width="<?= $thumb['thumbwidth'] ?>" height="<?= $thumb['thumbheight'] ?>" class="<? if ($thumb['current']): ?>current-thumbnail<? else: ?>thumbnails<? endif ?>" /></a><?php endforeach ?>
        </td>
    </tr>
    <tr>
        <td colspan="2" class="seperator"></td>
    </tr>
</table>

<?php include($template_dir."footer.tpl") ?>
