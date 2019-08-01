<?php
/**
 * @category  ScandiPWA
 * @package   ScandiPWA\Sitemap
 * @author    Ilja Lapkovskis <info@scandiweb.com / ilja@scandiweb.com>
 * @copyright Copyright (c) 2019 Scandiweb, Ltd (http://scandiweb.com)
 * @license   OSL-3.0
 */


use \Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'ScandiPWA_Sitemap',
    __DIR__
);
