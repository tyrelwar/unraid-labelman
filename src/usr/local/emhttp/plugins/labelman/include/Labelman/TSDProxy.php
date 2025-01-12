<?php

namespace Labelman;

class TSDProxy
{
    public bool $enable = false;
    public bool $ephemeral = false;
    public string $name = "";
    public bool $funnel = false;
    public int $container_port = 0;
    public string $scheme = "http";
    public bool $tlsvalidate = true;

    public function __construct(array $labels)
    {
        if(($labels['tsdproxy.enable'] ?? null) == "true") {
            $this->enable = true;
        }
        if(($labels['tsdproxy.ephemeral'] ?? null) == "true") {
            $this->ephemeral = true;
        }
        if(($labels['tsdproxy.funnel'] ?? null) == "true") {
            $this->funnel = true;
        }
        if(($labels['tsdproxy.tlsvalidate'] ?? null) == "false") {
            $this->tlsvalidate = false;
        }
        if(isset($labels['tsdproxy.container_port'])) {
            $this->container_port = intval($labels['tsdproxy.container_port']);
        }
        if(isset($labels['tsdproxy.name'])) {
            $this->name = $labels['tsdproxy.name'];
        }
        if(isset($labels['tsdproxy.scheme'])) {
            $this->scheme = $labels['tsdproxy.scheme'];
        }
    }

    public function display(Container $container) : void {
        include(__DIR__ . "/../displays/TSDProxy.php");
    }

    public function update(\SimpleXMLElement &$config, array $post) : void {
        if($this->enable != ($post['TSDProxy_enable'] == "true")) {
            Utils::apply_label($config, 'tsdproxy.enable', $post['TSDProxy_enable'], "false");
        }

        if($this->ephemeral != ($post['TSDProxy_ephemeral'] == "true")) {
            Utils::apply_label($config, 'tsdproxy.ephemeral', $post['TSDProxy_ephemeral']);
        }

        if($this->funnel != ($post['TSDProxy_funnel'] == "true")) {
            Utils::apply_label($config, 'tsdproxy.funnel', $post['TSDProxy_funnel'], "false");
        }

        if($this->tlsvalidate != ($post['TSDProxy_tlsvalidate'] == "true")) {
            Utils::apply_label($config, 'tsdproxy.tlsvalidate', $post['TSDProxy_tlsvalidate'], "true");
        }

        if($this->container_port != intval($post['TSDProxy_container_port'])) {
            Utils::apply_label($config, 'tsdproxy.container_port', intval($post['TSDProxy_container_port']), "0");
        }

        if($this->name != $post['TSDProxy_name']) {
            Utils::apply_label($config, 'tsdproxy.name', $post['TSDProxy_name'], "");
        }

        if($this->scheme != $post['TSDProxy_scheme']) {
            Utils::apply_label($config, 'tsdproxy.scheme', $post['TSDProxy_scheme'], "http");
        }
    }

}