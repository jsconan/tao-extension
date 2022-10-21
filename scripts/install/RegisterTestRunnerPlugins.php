<?php

namespace oat\taoExtension\scripts\install;

use oat\oatbox\reporting\Report;
use oat\oatbox\extension\InstallAction;
use oat\taoTests\models\runner\plugins\PluginRegistry;
use oat\taoTests\models\runner\plugins\TestPlugin;

class RegisterTestRunnerPlugins extends InstallAction
{
    private static $plugins = [
        [
            'id' => 'hider',
            'name' => 'Hider',
            'module' => 'taoExtension/runner/plugins/hider',
            'bundle' => 'taoExtension/loader/testRunner.min',
            'description' => 'Hide the item',
            'category' => 'tools',
            'active' => true,
            'tags' => ['tools']
        ]
    ];

    public function __invoke($params = [])
    {
        $registry = PluginRegistry::getRegistry();
        $count = 0;

        foreach (self::$plugins as $pluginData) {
            if ($registry->register(TestPlugin::fromArray($pluginData))) {
                $count++;
            }
        }

        return new Report(Report::TYPE_SUCCESS, $count . ' plugins registered.');
    }
}
