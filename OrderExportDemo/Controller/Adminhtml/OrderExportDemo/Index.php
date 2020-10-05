<?php
namespace AlexGlover\OrderExportDemo\Controller\Adminhtml\OrderExportDemo;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 */
class Index extends Action implements HttpGetActionInterface
{
    const MENU_ID = 'AlexGlover_OrderExportDemo::order_export_demo';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    public $export_url = 'test';

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);

        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Load the page defined in view/adminhtml/layout/alexglover_orderexportdemo_index.xml
     *
     * @return Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(static::MENU_ID);
        $resultPage->getConfig()->getTitle()->prepend(__('Order Export Demo Showcase'));

        $url = $this->_url->getUrl('demoorderexport/OrderExportDemo/export');
//        var_dump($this->_url->getCurrentUrl());


        if (isset($_POST['export_todays_orders'])) {
            $this->generateOrderExportCsv();
        }

        return $resultPage;
    }

    private function generateOrderExportCsv()
    {
        var_dump('why hello there');
        die();
    }
}
