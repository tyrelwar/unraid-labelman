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
?>

<h3>Label Manager</h3>

Please select the container you would like to manage:

<ul>

<?php

foreach ($dockerOut as $c) {
    $containerURL = urlencode($c);
    echo("<li><a href='/Settings/Labelman?container={$containerURL}'>{$c}</a></li>");
}
?>

</ul>