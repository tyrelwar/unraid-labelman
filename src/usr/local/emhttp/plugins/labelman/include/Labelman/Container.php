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

class Container
{
    /** @var array<string,string> */
    private array $labels;

    public \SimpleXMLElement $config;

    /** @var array<string,Service> $Services */
    public array $Services = array();

    public function __construct(string $configFile)
    {
        if ( ! file_exists($configFile)) {
            throw new \Exception("No config file found for {$configFile}");
        }

        $config = simplexml_load_file($configFile);
        if ( ! $config) {
            throw new \Exception("Could not load config file for {$configFile}");
        }

        $labels = array();

        foreach ($config->Config as $c) {
            $attributes = $c->attributes();
            if (isset($attributes['Type']) && strtolower($attributes['Type']) == "label") {
                $labels[(string)$attributes['Target']] = (string)$c;
            }
        }

        $this->labels = $labels;
        $this->config = $config;

        $services = Utils::getServices();
        foreach ($services as $service) {
            try {
                $newService = new $service($this);
                if ($newService instanceof Service) {
                    $this->Services[$service] = $newService;
                } else {
                    Utils::logmsg("Service {$service} does not implement Service interface");
                }
            } catch (\Throwable $e) {
                Utils::logmsg("Error loading service {$service}: {$e->getMessage()}");
            }
        }
    }

    /** @return array<string,string> */
    public function getLabels(): array
    {
        return $this->labels;
    }
}
