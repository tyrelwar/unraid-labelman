<?php

namespace Labelman;

/*
    Copyright (C) 2025  Derek Kaser

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.
*/

$docroot = $docroot ?? $_SERVER['DOCUMENT_ROOT'] ?: '/usr/local/emhttp';
require_once "{$docroot}/plugins/labelman/include/common.php";

$dockerOut = Utils::run_command('docker container ls --format="{{.Names}}" --filter "label=net.unraid.docker.managed=dockerman"');
sort($dockerOut, SORT_STRING | SORT_FLAG_CASE);

$images = Utils::getImages();

$show_TSDProxy = TSDProxy::serviceExists($images);

?>
<script src="/webGui/javascript/jquery.tablesorter.widgets.js"></script>
<link type="text/css" rel="stylesheet" href="/plugins/labelman/style.css">

<h3>Label Manager</h3>

Please select the container you would like to manage:

<table id='statusTable' class="unraid statusTable tablesorter">
    <thead>
        <tr>
            <th>Container</th>
            <?php if ($show_TSDProxy) { ?><th class="filter-select filter-match">TSDProxy Enabled</th><?php } ?>
            <th class="filter-false">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach ($dockerOut as $c) {
                $configFile = realpath("/boot/config/plugins/dockerMan/templates-user/my-{$c}.xml");
                if ( ! $configFile || ! str_starts_with($configFile, "/boot/config/plugins/dockerMan/templates-user/my-")) {
                    continue;
                }
                $container    = new Container($configFile);
                $containerURL = urlencode($c);

                $row = "<tr><td>{$c}</td>";

                if ($show_TSDProxy) {
                    $row .= "<td>" . ($container->TSDProxy->isEnabled() ? "Yes" : "No") . "</td>";
                }

                $row .= "<td><a href='/Settings/Labelman?container={$containerURL}'>Edit</a></td></tr>";

                echo($row);
            }
?>
    </tbody>
</table>
<button type="button" class="reset">Reset Filters</button>

<script>
$(function() {
    $('#statusTable').tablesorter({
      widthFixed : true,
      sortList: [[0,0]],
      sortAppend: [[0,0]],
      widgets: ['stickyHeaders','filter','zebra'],
      widgetOptions: {
        // on black and white, offset is height of #menu
        // on azure and gray, offset is height of #header
        stickyHeaders_offset: ($('#menu').height() < 50) ? $('#menu').height() : $('#header').height(),
        filter_columnFilters: true,
        filter_reset: '.reset',
        filter_liveSearch: true,

        zebra: ["normal-row","alt-row"]
      }
    });
});

</script>



