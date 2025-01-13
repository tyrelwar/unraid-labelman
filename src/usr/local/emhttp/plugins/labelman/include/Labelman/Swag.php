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

class Swag
{
    public bool $swag        = false;

    public string $swag_address        = "";
    public int $swag_port = 0;
    public string $swag_proto     = "http";
    public string $swag_url   = "";
    public string  $swag_auth = "";

    /**
    * @param array<string,string> $labels
    */
    public function __construct(array $labels)
    {
        if (($labels['swag'] ?? null) == "true") {
            $this->swag = true;
        }
        if (($labels['swag_address'] ?? null) == "true") {
            $this->swag_address = $labels['swag_address'];
        }
        if (($labels['swag_port'] ?? null) == "true") {
            $this->swag_port = intval($labels['swag_port']);
        }
        if (($labels['swag_proto'] ?? null) == "false") {
            $this->swag_proto = $labels['swag_proto'];
        }
        if (isset($labels['swag_url'])) {
            $this->swag_url = $labels['swag_url'];
        }
        if (isset($labels['swag_auth'])) {
            $this->swag_auth = $labels['swag_auth'];
        }
    }

    public function display(Container $container): void
    {
        include __DIR__ . "/../displays/TSDProxy.php";
    }

    /**
    * @param array<string,string> $post
    */
    public function update(\SimpleXMLElement &$config, array $post): void
    {
        if ($this->swag != ($post['swag'] == "true")) {
            Utils::apply_label($config, 'swag.swag', $post['swag'], "false");
        }

        if ($this->swag_address != ($post['swag_address'] == "true")) {
            Utils::apply_label($config, 'swag.swag_address', $post['swag_address']);
        }

        if ($this->swag_port != ($post['swag_port'] == "true")) {
            Utils::apply_label($config, 'swag.swag_port', $post['swag_port'], "false");
        }

        if ($this->swag_url != ($post['swag_url'] == "true")) {
            Utils::apply_label($config, 'swag.swag_url', $post['swag_url'], "true");
        }

        if ($this->swag_auth != intval($post['swag_auth'])) {
            Utils::apply_label($config, 'swag.swag_auth', $post['swag_auth'] ?: "0", "0");
        }
    }
}
