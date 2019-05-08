<?php
/**
 * @category  ScandiPWA
 * @package   ScandiPWA\Sitemap
 * @author    Ilja Lapkovskis <info@scandiweb.com / ilja@scandiweb.com>
 * @copyright Copyright (c) 2019 Scandiweb, Ltd (http://scandiweb.com)
 * @license   OSL-3.0
 */

namespace ScandiPWA\Sitemap\Model;


use Magento\Framework\UrlInterface;
use Magento\Sitemap\Model\Sitemap as MagentoSitemap;

class Sitemap extends MagentoSitemap
{
    /**
     * Override default type
     *
     * @param string $url
     * @param string $type
     * @return string
     */
    protected function _getUrl($url, $type = UrlInterface::URL_TYPE_WEB)
    {
        return parent::_getUrl($url, $type);
    }
}
