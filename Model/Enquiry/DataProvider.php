<?php
/**
 * @copyright   Copyright 2022 © Jegan, Inc. All rights reserved.
 * @license     See COPYING.txt for license details.
 * @category    Customer Enquiry
 * @package     Jegan_Enquiry
 * @author      jegan <jeganjeyaraman.yt@gmail.com>
 */
namespace Jegan\Enquiry\Model\Enquiry;

use Magento\Framework\Api\Filter;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Jegan\Enquiry\Model\ResourceModel\Enquiry\Collection;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * Class DataProvider
 *
 * @package Jegan\Enquiry\Model\Enquiry
 */
class DataProvider extends AbstractDataProvider
{

    /**
     * @var Collection
     */
    protected Collection $_enquiryCollectionFactory;

    /**
     * @var DataPersistorInterface
     */
    protected DataPersistorInterface $_dataPersistor;

    /**
     * DataProvider constructor.
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param Collection $enquiryCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(string $name,
                                string $primaryFieldName,
                                string $requestFieldName,
                                Collection $enquiryCollectionFactory,
                                DataPersistorInterface $dataPersistor,
                                array $meta = [],
                                array $data = [])
    {
        $this->_enquiryCollectionFactory = $enquiryCollectionFactory;
        $this->_dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     *  Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->_enquiryCollectionFactory->getItems();

        /** @var Enquiry $enquiry */
        foreach ($items as $enquiry) {
            $this->loadedData[$enquiry->getId()] = $enquiry->getData();
        }
        return $this->loadedData;
    }

    /**
     * @param Filter $filter
     * @return null
     */
    public function addFilter(Filter $filter)
    {
        return null;
    }
}
