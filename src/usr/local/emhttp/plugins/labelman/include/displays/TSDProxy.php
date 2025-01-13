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

if ( ! isset($container)) {
    throw new \Exception("Container not set");
}

?>
<h3>TSDProxy</h3>

<dl>
    <dt>Enabled</dt>
    <dd>
        <select name='TSDProxy_enable' size='1'>
            <?= Utils::make_option($container->TSDProxy->enable, 'true', "Yes");?>
            <?= Utils::make_option( ! $container->TSDProxy->enable, 'false', "No");?>
        </select>
    </dd>
</dl>
<div class="advanced">
    <dl>
        <dt>Name</dt>
        <dd>
            <input type="text" name="TSDProxy_name" class="narrow" min="0" max="65535" value="<?= $container->TSDProxy->name; ?>" placeholder="">
        </dd>
    </dl>
    <blockquote class='inline_help'>The name to use for the new Tailscale machine. If left blank, the container name is used.</blockquote>

    <dl>
        <dt>Container Port</dt>
        <dd>
            <input type="number" name="TSDProxy_container_port" class="narrow" min="0" max="65535" value="<?= $container->TSDProxy->container_port; ?>" placeholder="0">
        </dd>
    </dl>
    <blockquote class='inline_help'>The port on the container to proxy. Leave at default (0) to autodetect the correct port. This is usually only needed when a container publishes multiple ports.</blockquote>

    <dl>
        <dt>Ephemeral</dt>
        <dd>
            <select name='TSDProxy_ephemeral' size='1'>
                <?= Utils::make_option($container->TSDProxy->ephemeral, 'true', "Yes");?>
                <?= Utils::make_option( ! $container->TSDProxy->ephemeral, 'false', "No");?>
            </select>
        </dd>
    </dl>
    <blockquote class='inline_help'>Make the Tailscale node ephemeral. Should usually be false, only change if you know what you are doing.</blockquote>

    <dl>
        <dt>Funnel</dt>
        <dd>
            <select name='TSDProxy_funnel' size='1'>
                <?= Utils::make_option($container->TSDProxy->funnel, 'true', "Yes");?>
                <?= Utils::make_option( ! $container->TSDProxy->funnel, 'false', "No");?>
            </select>
        </dd>
    </dl>
    <blockquote class='inline_help'>Allow connections from the internet to the published service.</blockquote>

    <dl>
        <dt>Scheme</dt>
        <dd>
            <select name='TSDProxy_scheme' size='1'>
                <?= Utils::make_option($container->TSDProxy->scheme == "http", 'http', "HTTP");?>
                <?= Utils::make_option($container->TSDProxy->scheme == "https", 'https', "HTTPS");?>
            </select>
        </dd>
    </dl>
    <blockquote class='inline_help'>Switch to HTTPS for containers that publish HTTPS endpoints instead of HTTP.</blockquote>

    <dl>
        <dt>TLS Validate</dt>
        <dd>
            <select name='TSDProxy_tlsvalidate' size='1'>
                <?= Utils::make_option($container->TSDProxy->tlsvalidate, 'true', "Yes");?>
                <?= Utils::make_option( ! $container->TSDProxy->tlsvalidate, 'false', "No");?>
            </select>
        </dd>
    </dl>
    <blockquote class='inline_help'>Validate TLS certificate. Only applicable when scheme is set to HTTPS.</blockquote>
</div>

<h3>Swag</h3>

<dl>
    <dt>Enabled</dt>
    <dd>
        <select name='swag' size='1'>
            <?= Utils::make_option($container->Swag->swag, 'enable', "Yes");?>
            <?= Utils::make_option( ! $container->Swag->swag, 'false', "No");?>
        </select>
    </dd>
</dl>
<div class="advanced">
    <dl>
        <dt>Container Name</dt>
        <dd>
            <input type="text" name="swag_address" class="narrow" min="0" max="65535" value="<?= $container->Swag->swag_address; ?>" placeholder="<?=$container?>">
        </dd>
    </dl>
    <blockquote class='inline_help'>optional - overrides upstream app address. Can be set to an IP or a DNS hostname. Defaults to container name.</blockquote>

    <dl>
        <dt>Container Port</dt>
        <dd>
            <input type="number" name="swag_port" class="narrow" min="0" max="65535" value="<?= $container->Swag->swag_port; ?>" placeholder="0">
        </dd>
    </dl>
    <blockquote class='inline_help'>The port on the container to proxy. Leave at default (0) to autodetect the correct port. This is usually only needed when a container publishes multiple ports.</blockquote>

    <dl>
        <dt>Scheme</dt>
        <dd>
            <select name='swag_proto' size='1'>
                <?= Utils::make_option($container->Swag->swag_prot == "http", 'http', "HTTP");?>
                <?= Utils::make_option($container->Swag->swag_prot == "https", 'https', "HTTPS");?>
            </select>
        </dd>
    </dl>
    <blockquote class='inline_help'>- optional - overrides internal proto (defaults to http)</blockquote>

    <dl>
        <dt>URL</dt>
        <dd>
            <input type="text" name="swag_url" class="narrow" min="0" max="65535" value="<?= $container->Swag->swag_url; ?>" placeholder="<?=$container . '.domain.com'?>">
        </dd>
    </dl>
    <blockquote class='inline_help'>optional - overrides server_name (defaults to containername.*)</blockquote>

    <dl>
        <dt>swag_auth</dt>
        <dd>
            <select name='swag_auth' size='1'>
                <?= Utils::make_option( ! $container->Swag->swag_auth, '', "None");?>
                <?= Utils::make_option($container->Swag->swag_auth, 'authelia', "authelia");?>
                <?= Utils::make_option( ! $container->Swag->swag_auth, 'ldap', "ldap");?>
                <?= Utils::make_option( ! $container->Swag->swag_auth, 'http', "http");?>

            </select>
        </dd>
    </dl>
    <blockquote class='inline_help'>optional - enables auth methods (options are authelia, ldap and http for basic http auth)</blockquote>
</div>