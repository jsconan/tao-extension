<?php
namespace oat\taoExtension\scripts\install;

use oat\oatbox\reporting\Report as Report;
use oat\oatbox\extension\InstallAction;
use oat\tao\model\theme\DefaultTheme;
use oat\taoExtension\model\theme\TaoExtensionDefaultTheme;
use oat\tao\model\theme\ThemeService;
use oat\taoDeliveryRdf\model\theme\DeliveryThemeDetailsProvider;

/**
 * You can check the result of this script by opening:
 * tao/config/tao/theming.conf.php
 */
class SetPlatformTheme extends InstallAction
{
    public function __invoke($params = [])
    {
        /** @var ThemeService $themeService */
        $themeService = $this->getServiceManager()->get(ThemeService::SERVICE_ID);
        $themeService->setTheme(new TaoExtensionDefaultTheme());
        $themeService->removeThemeById((new DefaultTheme())->getId());
        $themeService->setOption(ThemeService::OPTION_THEME_DETAILS_PROVIDERS, [new DeliveryThemeDetailsProvider()]);
        $this->getServiceManager()->register(ThemeService::SERVICE_ID, $themeService);
        return new Report(Report::TYPE_SUCCESS, 'Platform theme successfully registered');
    }
}
