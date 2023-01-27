<?php

/**
 * CedCommerce
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the End User License Agreement (EULA)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://cedcommerce.com/license-agreement.txt
 *
 * @category    Ced
 * @package     Ced_Fruugo
 * @author      CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright   Copyright CedCommerce (http://cedcommerce.com/)
 * @license      http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\Fruugo\Controller\Adminhtml\Order;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class FailedOrders extends \Magento\Backend\App\Action
{
    /**
     * ResultPageFactory
     * @var PageFactory
     */
    public $resultPageFactory;

    /**
     * Helper
     * @var PageFactory
     */
    public $helper;

    /**
     * FailedOrders constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param \Ced\Fruugo\Helper\Order $helper
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Ced\Fruugo\Helper\Order $helper
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->helper = $helper;
    }

    /**
     * Execute
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        if(!$this->_objectManager->create('\Ced\Fruugo\Helper\Data')->checkForConfiguration()) {
            $url = $this->getUrl('adminhtml/system_config/edit/section/fruugoconfiguration');
            $this->messageManager->addNotice(__('Fruugo API not enabled or Invalid. Please check Fruugo <a target="_blank" href="'.$url.'">Configuration</a>.'));
        }
        /*if(!$this->_objectManager->create('\Ced\Fruugo\Helper\Data')->checkForConfiguration()) {
            $this->messageManager->addNoticeMessage(__('Fruugo API not enabled or Invalid. Please check Fruugo Configuration.'));
        }*/
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Ced_Fruugo::Orders');
        $resultPage->getConfig()->getTitle()->prepend(__('Failed Orders Grid'));
        return $resultPage;
    }

    /**
     * IsALLowed
     * @return boolean
     */
    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Ced_Fruugo::Fruugo');
    }
}