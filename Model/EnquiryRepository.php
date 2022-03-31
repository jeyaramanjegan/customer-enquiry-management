<?php
/**
 * @copyright   Copyright 2022 © Jegan, Inc. All rights reserved.
 * @license     See COPYING.txt for license details.
 * @category    Customer Enquiry
 * @package     Jegan_Enquiry
 * @author      jegan <jeganjeyaraman.yt@gmail.com>
 */
namespace Jegan\Enquiry\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Exception\ValidatorException;
use Magento\Framework\Exception\NoSuchEntityException;
use Jegan\Enquiry\Api\EnquiryRepositoryInterface;
use Jegan\Enquiry\Api\Data\EnquiryInterface;
use Jegan\Enquiry\Api\Data\EnquiryInterfaceFactory;
use Jegan\Enquiry\Model\ResourceModel\Enquiry as ResourceEnquiry;
use Jegan\Enquiry\Model\ResourceModel\Enquiry\CollectionFactory as EnquiryCollectionFactory;
use Magento\Framework\Model\AbstractModel;

/**
 * Class EnquiryRepository
 *
 * @package Jegan\Enquiry\Model
 */
class EnquiryRepository implements EnquiryRepositoryInterface
{
    /**
     * @var array
     */
    protected array $instances = [];
    /**
     * @var ResourceEnquiry
     */
    protected ResourceEnquiry $resource;

    /**
     * @var EnquiryCollectionFactory
     */
    protected EnquiryCollectionFactory $enquiryCollectionFactory;

    /**
     * @var EnquiryInterfaceFactory
     */
    protected EnquiryInterfaceFactory $enquiryInterfaceFactory;

    /**
     * @var DataObjectHelper
     */
    protected DataObjectHelper $dataObjectHelper;

    /**
     * EnquiryRepository constructor.
     *
     * @param ResourceEnquiry $resource
     * @param EnquiryCollectionFactory $enquiryCollectionFactory
     * @param EnquiryInterfaceFactory $enquiryInterfaceFactory
     * @param DataObjectHelper $dataObjectHelper
     */

    public function __construct(
        ResourceEnquiry $resource,
        EnquiryCollectionFactory $enquiryCollectionFactory,
        EnquiryInterfaceFactory $enquiryInterfaceFactory,
        DataObjectHelper $dataObjectHelper
    ) {
        $this->resource = $resource;
        $this->enquiryCollectionFactory = $enquiryCollectionFactory;
        $this->enquiryInterfaceFactory = $enquiryInterfaceFactory;
        $this->dataObjectHelper = $dataObjectHelper;
    }

    /**
     * @param EnquiryInterface $enquiry
     * @return EnquiryInterface|AbstractModel
     * @throws CouldNotSaveException
     */
    public function save(EnquiryInterface $enquiry)
    {
        try {
            /** @var EnquiryInterface|AbstractModel $enquiry */
            $this->resource->save($enquiry);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the enquiry: %1',
                $exception->getMessage()
            ));
        }
        return $enquiry;
    }

    /**
     * Get enquiry record
     *
     * @param $enquiryId
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getById($enquiryId)
    {
        if (!isset($this->instances[$enquiryId])) {
            /** @var EnquiryInterface|AbstractModel $enquiry */
            $enquiry = $this->enquiryInterfaceFactory->create();
            $this->resource->load($enquiry, $enquiryId);
            if (!$enquiry->getId()) {
                throw new NoSuchEntityException(__('Requested enquiry doesn\'t exist'));
            }
            $this->instances[$enquiryId] = $enquiry;
        }
        return $this->instances[$enquiryId];
    }

    /**
     * @param EnquiryInterface $enquiry
     * @return bool
     * @throws CouldNotSaveException
     * @throws StateException
     */
    public function delete(EnquiryInterface $enquiry)
    {
        /** @var EnquiryInterface|AbstractModel $enquiry */
        $id = $enquiry->getId();
        try {
            unset($this->instances[$id]);
            $this->resource->delete($enquiry);
        } catch (ValidatorException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new StateException(
                __('Unable to remove enquiry %1', $id)
            );
        }
        unset($this->instances[$id]);
        return true;
    }

    /**
     * @param $enquiryId
     * @return bool
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     * @throws StateException
     */
    public function deleteById($enquiryId)
    {
        $enquiry = $this->getById($enquiryId);
        return $this->delete($enquiry);
    }
}
