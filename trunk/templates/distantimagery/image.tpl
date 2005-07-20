{include file=$template_dir|cat:"header.tpl"}

<table class="main">
    <tr>
        <td class="name">
            {$image.title}
        </td>
        <td class="navigation">
            {if $previous}<a href="{$previous.permalink}">Previous</a>{/if} |
            <a href="{$image.permalink}">Permalink</a> |
            {if $next}<a href="{$next.permalink}">Next</a>{/if}
        </td>
    </tr>
</table>

<table class="main">
    <tr>
        <td colspan="2" class="image">
            <img src="{$image.image}" width="{$image.width}" height="{$image.height}" />
        </td>
    </tr>
    <tr>
        <td class="info">
            {$image.date} |
            <IMAGE_CATEGORY>
        </td>
        <td rowspan="3" class="exif">
            <p class="exif">EXIF</p>
            <LANG_CAMERA_MODEL><br />
            <LANG_EXPOSURE_TIME><br />
            <LANG_APERTURE><br />
            <LANG_FOCAL_LENGTH><br />
            <LANG_FLASH><br />
            <LANG_ISO>
        </td>
    </tr>
    <tr>
        <td class="notes">
            {$image.body}
        </td>
    </tr>
    <tr>
        <td colspan="2" class="seperator"></td>
    </tr>
    <tr>
        <td colspan="2" class="thumbrow">
            <IMAGE_THUMBNAIL_ROW>
        </td>
    </tr>
    <tr>
        <td colspan="2" class="seperator"></td>
    </tr>
</table>

{include file=$template_dir|cat:"footer.tpl"}
