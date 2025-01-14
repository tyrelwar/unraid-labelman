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

$docroot = isset($docroot) ? $docroot : (isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] : '/usr/local/emhttp');
require_once "{$docroot}/plugins/labelman/include/common.php";

readfile('/usr/local/emhttp/update.htm');

if (!isset($_POST['containerName'])) {
    throw new \Exception("No container specified");
}

$containerName = $_POST['containerName'];
$configFile    = realpath("/boot/config/plugins/dockerMan/templates-user/my-{$containerName}.xml");
if (!$configFile || substr($configFile, 0, strlen("/boot/config/plugins/dockerMan/templates-user/my-")) !== "/boot/config/plugins/dockerMan/templates-user/my-") {
    throw new \Exception("Bad Request");
}

$container = new Container($configFile);

// Determine the container type
$containerType = isset($_POST['containerType']) ? $_POST['containerType'] : 'tsdproxy';

// Update the container type in the config
$container->config->type = $containerType;

// Update the appropriate container settings
switch ($containerType) {
    case 'tsdproxy':
        $container->TSDProxy->update($container->config, $_POST);
        break;
    case 'swag':
        $container->Swag->update($container->config, $_POST);
        break;
    default:
        throw new \Exception("Invalid container type");
}

$dom                     = new \DOMDocument('1.0');
$dom->preserveWhiteSpace = false;
$dom->formatOutput       = true;
$dom->loadXML($container->config->asXML());

// Create config backup
$time = time();
copy($configFile, "/boot/config/plugins/labelman/{$containerName}.{$time}.xml");

// Write config file
file_put_contents($configFile, $dom->saveXML());

Utils::run_command("/usr/local/emhttp/plugins/dynamix.docker.manager/scripts/rebuild_container '{$containerName}'");