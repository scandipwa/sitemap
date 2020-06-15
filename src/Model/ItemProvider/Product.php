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
use Magento\Sitemap\Model\ResourceModel\Catalog\ProductFactory;
use Magento\Sitemap\Model\SitemapItemInterfaceFactory;

class Product implements ItemProviderInterface
{
    /**
     * Product factory
     *
     * @var ProductFactory
     */
    private $productFactory;

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
     * ProductSitemapItemResolver constructor.
     *
     * @param ConfigReaderInterface $configReader
     * @param ProductFactory $productFactory
     * @param SitemapItemInterfaceFactory $itemFactory
     */
    public function __construct(
        ConfigReaderInterface $configReader,
        ProductFactory $productFactory,
        SitemapItemInterfaceFactory $itemFactory
    ) {
        $this->productFactory = $productFactory;
        $this->itemFactory = $itemFactory;
        $this->configReader = $configReader;
    }

    /**
     * {@inheritdoc}
     */
    public function getItems($storeId)
    {
        $collection = $this->productFactory->create()
            ->getCollection($storeId);

        $items = array_map(function ($item) use ($storeId) {
            return $this->itemFactory->create([
                'url' => $this->generateUrl($item->getUrl()),
                'updatedAt' => $item->getUpdatedAt(),
                'images' => $item->getImages(),
                'priority' => $this->configReader->getPriority($storeId),
                'changeFrequency' => $this->configReader->getChangeFrequency($storeId),
            ]);
        }, $collection);

        return $items;
    }
    
    private function generateUrl($itemUrl)
    {
        return DIRECTORY_SEPARATOR . str_replace('.html', '', $itemUrl) . '?variant=0';
    }
}
