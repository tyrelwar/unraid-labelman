<?php

namespace Labelman;

class Container
{
    private array $labels;
    public \SimpleXMLElement $config;
    public TSDProxy $TSDProxy;

    public function __construct(string $configFile)
    {
        if (!file_exists($configFile)) {
            throw("No config file found for {$container}");
        }
        
        $labels = array();
        $config = simplexml_load_file($configFile);
        
        foreach($config->Config as $c) {
            $attributes = $c->attributes();
            if($attributes['Type'] == "Label") {
                $labels[(string)$attributes['Target']] = (string)$c;
            }
        }

        $this->labels = $labels;
        $this->TSDProxy = new TSDProxy($labels);
        $this->config = $config;
    }

    public function getLabels(): array
    {
        return $this->labels;
    }
}