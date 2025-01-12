<?php

namespace Labelman;

$docroot = $docroot ?? $_SERVER['DOCUMENT_ROOT'] ?: '/usr/local/emhttp';
require_once "{$docroot}/plugins/labelman/include/common.php";

if (!isset($_GET['container'])) {
    throw("No container specified");
}

$containerName = $_GET['container'];
$configFile = realpath("/boot/config/plugins/dockerMan/templates-user/my-{$containerName}.xml");
if ( ! $configFile || ! str_starts_with($configFile, "/boot/config/plugins/dockerMan/templates-user/my-")) {
    throw("Bad Request");
}

$container = new Container($configFile);
?>
<link type="text/css" rel="stylesheet" href="<?= Utils::auto_v('/webGui/styles/jquery.switchbutton.css');?>">
<span class="status vhshift"><input type="checkbox" class="advancedview"></span>

<h2><?= $containerName ?></h2>

<form action="/plugins/labelman/update.php" method="POST" target="progressFrame">
<input type="hidden" name="containerName" value="<?= urlencode($containerName) ?>">

<?php $container->TSDProxy->display($container); ?>

<h3>Save Settings</h3>

<dl>
    <dt>&nbsp;</dt>
    <dd>
        <input type="submit" name="#apply" value="Apply"><input type="button" id="DONE" value="Back" onclick="window.location.href='/Settings/Labelman'">
    </dd>
</dl>
</form>

<script src="<?= Utils::auto_v('/webGui/javascript/jquery.switchbutton.js');?>"></script>
<script>
    $(function() {
        if ($.cookie('labelman_view_mode') == 'advanced') {
            $('.advanced').show();
        } else {
            $('.advanced').hide();
        }

        $('.advancedview').switchButton({
            labels_placement: "left",
            on_label: "Advanced",
            off_label: "Basic",
            checked: $.cookie('labelman_view_mode') == 'advanced'
        });
        $('.advancedview').change(function(){
            if($('.advancedview').is(':checked')) {
                $('.advanced').show('slow');
            } else {
                $('.advanced').hide('slow');
            }
            $.cookie('labelman_view_mode', $('.advancedview').is(':checked') ? 'advanced' : 'basic', {expires:3650});
        });
    });
</script>