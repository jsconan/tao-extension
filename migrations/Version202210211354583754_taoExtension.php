<?php

declare(strict_types=1);

namespace oat\taoExtension\migrations;

use Doctrine\DBAL\Schema\Schema;
use oat\oatbox\reporting\Report as Report;
use oat\tao\model\theme\DefaultTheme;
use oat\tao\model\theme\ThemeService;
use oat\tao\scripts\tools\migrations\AbstractMigration;
use oat\taoDeliveryRdf\model\theme\DeliveryThemeDetailsProvider;
use oat\taoExtension\model\theme\TaoExtensionDefaultTheme;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version202210211354583754_taoExtension extends AbstractMigration
{

    public function getDescription(): string
    {
        return 'Install the platform theme';
    }

    public function up(Schema $schema): void
    {
        /** @var ThemeService $themeService */
        $themeService = $this->getServiceManager()->get(ThemeService::SERVICE_ID);
        $themeService->setTheme(new TaoExtensionDefaultTheme());
        $themeService->removeThemeById((new DefaultTheme())->getId());
        $themeService->setOption(ThemeService::OPTION_THEME_DETAILS_PROVIDERS, [new DeliveryThemeDetailsProvider()]);
        $this->getServiceManager()->register(ThemeService::SERVICE_ID, $themeService);
        $this->addReport(new Report(Report::TYPE_SUCCESS, 'Platform theme successfully registered'));
    }

    public function down(Schema $schema): void
    {
        /** @var ThemeService $themeService */
        $themeService = $this->getServiceManager()->get(ThemeService::SERVICE_ID);
        $themeService->setTheme(new DefaultTheme());
        $themeService->removeThemeById((new TaoExtensionDefaultTheme())->getId());
        $themeService->setOption(ThemeService::OPTION_THEME_DETAILS_PROVIDERS, [new DeliveryThemeDetailsProvider()]);
        $this->getServiceManager()->register(ThemeService::SERVICE_ID, $themeService);
        $this->addReport(new Report(Report::TYPE_SUCCESS, 'Platform theme successfully rolled back'));
    }
}
