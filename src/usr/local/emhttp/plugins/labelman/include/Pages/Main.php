<?php

namespace Labelman;

$docroot = $docroot ?? $_SERVER['DOCUMENT_ROOT'] ?: '/usr/local/emhttp';
require_once "{$docroot}/plugins/labelman/include/common.php";

$dockerOut = Utils::run_command('docker container ls --format="{{.Names}}" --filter "label=net.unraid.docker.managed=dockerman"');
sort($dockerOut, SORT_STRING | SORT_FLAG_CASE);
?>

<h3>Label Manager</h3>

Please select the container you would like to manage:

<ul>

<?php

foreach($dockerOut ?? array() as $c) {
    $containerURL = urlencode($c);
    echo("<li><a href='/Settings/Labelman?container={$containerURL}'>{$c}</a></li>");
}
?>

</ul>