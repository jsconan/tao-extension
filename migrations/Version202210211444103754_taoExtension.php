<?php

declare(strict_types=1);

namespace oat\taoExtension\migrations;

use Doctrine\DBAL\Schema\Schema;
use oat\oatbox\reporting\Report;
use oat\tao\scripts\tools\migrations\AbstractMigration;
use oat\taoTests\models\runner\plugins\PluginRegistry;
use oat\taoTests\models\runner\plugins\TestPlugin;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version202210211444103754_taoExtension extends AbstractMigration
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

    public function getDescription(): string
    {
        return 'Install test runner plugins';
    }

    public function up(Schema $schema): void
    {
        $registry = PluginRegistry::getRegistry();
        $count = 0;

        foreach (self::$plugins as $pluginData) {
            if ($registry->register(TestPlugin::fromArray($pluginData))) {
                $count++;
            }
        }

        $this->addReport(new Report(Report::TYPE_SUCCESS, $count . ' plugins registered.'));
    }

    public function down(Schema $schema): void
    {
        $registry = PluginRegistry::getRegistry();
        $count = 0;

        foreach (self::$plugins as $pluginData) {
            if ($registry->isRegistered($pluginData['module'])) {
                $registry->remove($pluginData['module']);
                $count++;
            }
        }

        $this->addReport(new Report(Report::TYPE_SUCCESS, $count . ' plugins unregistered.'));
    }
}
