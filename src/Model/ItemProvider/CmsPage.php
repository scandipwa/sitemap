<?php
/**
 * @category  ScandiPWA
 * @package   ScandiPWA\Sitemap
 * @author    Ilja Lapkovskis <info@scandiweb.com / ilja@scandiweb.com>
 * @copyright Copyright (c) 2019 Scandiweb, Ltd (http://scandiweb.com)
 * @license   OSL-3.0
 */

namespace ScandiPWA\Sitemap\Model\ItemProvider;

use Magento\Sitemap\Model\ItemProvider\ConfigReaderInterface;
use Magento\Sitemap\Model\ItemProvider\ItemProviderInterface;
use Magento\Sitemap\Model\ResourceModel\Cms\PageFactory;
use Magento\Sitemap\Model\SitemapItemInterfaceFactory;

class CmsPage implements ItemProviderInterface
{
    /**
     * Cms page factory
     *
     * @var PageFactory
     */
    private $cmsPageFactory;

    /**
     * Sitemap item factory
     *
     * @var SitemapItemInterfaceFactory
     */
    private $itemFactory;

    /**
     * Config reader
     *
     * @var ConfigReaderInterface
     */
    private $configReader;

    /**
     * CmsPage constructor.
     *
     * @param ConfigReaderInterface $configReader
     * @param PageFactory $cmsPageFactory
     * @param SitemapItemInterfaceFactory $itemFactory
     */
    public function __construct(
        ConfigReaderInterface $configReader,
        PageFactory $cmsPageFactory,
        SitemapItemInterfaceFactory $itemFactory
    ) {
        $this->cmsPageFactory = $cmsPageFactory;
        $this->itemFactory = $itemFactory;
        $this->configReader = $configReader;
    }

    /**
     * {@inheritdoc}
     */
    public function getItems($storeId)
    {
        $collection = $this->cmsPageFactory->create()->getCollection($storeId);
        $items = array_map(function ($item) use ($storeId) {
            return $this->itemFactory->create([
                'url' => DIRECTORY_SEPARATOR . 'page' . DIRECTORY_SEPARATOR . $item->getUrl(),
                'updatedAt' => $item->getUpdatedAt(),
                'images' => $item->getImages(),
                'priority' => $this->configReader->getPriority($storeId),
                'changeFrequency' => $this->configReader->getChangeFrequency($storeId),
            ]);
        }, $collection);

        return $items;
    }
}
