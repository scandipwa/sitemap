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
use Magento\Sitemap\Model\ResourceModel\Catalog\CategoryFactory;
use Magento\Sitemap\Model\SitemapItemInterfaceFactory;

class Category implements ItemProviderInterface
{
    /**
     * Category factory
     *
     * @var CategoryFactory
     */
    private $categoryFactory;
    
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
     * CategorySitemapItemResolver constructor.
     *
     * @param ConfigReaderInterface $configReader
     * @param CategoryFactory $categoryFactory
     * @param SitemapItemInterfaceFactory $itemFactory
     */
    public function __construct(
        ConfigReaderInterface $configReader,
        CategoryFactory $categoryFactory,
        SitemapItemInterfaceFactory $itemFactory
    ) {
        $this->categoryFactory = $categoryFactory;
        $this->itemFactory = $itemFactory;
        $this->configReader = $configReader;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getItems($storeId)
    {
        $collection = $this->categoryFactory->create()
            ->getCollection($storeId);
        $items = array_map(function ($item) use ($storeId) {
            return $this->itemFactory->create([
                'url' => DIRECTORY_SEPARATOR . str_replace('.html', '', $item->getUrl()),
                'updatedAt' => $item->getUpdatedAt(),
                'images' => $item->getImages(),
                'priority' => $this->configReader->getPriority($storeId),
                'changeFrequency' => $this->configReader->getChangeFrequency($storeId),
            ]);
        }, $collection);
        
        return $items;
    }
}
