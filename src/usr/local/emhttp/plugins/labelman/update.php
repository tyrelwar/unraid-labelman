<?php

namespace Labelman;

$docroot = $docroot ?? $_SERVER['DOCUMENT_ROOT'] ?: '/usr/local/emhttp';
require_once "{$docroot}/plugins/labelman/include/common.php";

readfile('/usr/local/emhttp/update.htm');

if (!isset($_POST['containerName'])) {
    throw("No container specified");
}

$containerName = $_POST['containerName'];
$configFile = realpath("/boot/config/plugins/dockerMan/templates-user/my-{$containerName}.xml");
if ( ! $configFile || ! str_starts_with($configFile, "/boot/config/plugins/dockerMan/templates-user/my-")) {
    throw("Bad Request");
}

$container = new Container($configFile);

$container->TSDProxy->update($container->config, $_POST);

$dom = new \DOMDocument('1.0');
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->loadXML($container->config->asXML());

file_put_contents($configFile, $dom->saveXML());

Utils::run_command("/usr/local/emhttp/plugins/dynamix.docker.manager/scripts/rebuild_container '{$containerName}'");