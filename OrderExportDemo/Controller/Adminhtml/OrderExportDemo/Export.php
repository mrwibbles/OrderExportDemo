<?php

namespace AlexGlover\OrderExportDemo\Controller\Adminhtml\OrderExportDemo;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;

/**
 * Class Export
 */
class Export extends Action implements HttpPostActionInterface
{
    protected $_orderCollectionFactory;

    /**
     * Index constructor.
     *
     * @param CollectionFactory $orderCollectionFactory
     * @param Context $context
     */
    public function __construct(
        CollectionFactory $orderCollectionFactory,
        Context $context
    ) {
        $this->_orderCollectionFactory = $orderCollectionFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $to = date("Y-m-d h:i:s", strtotime('tomorrow'));
        $from = date("Y-m-d h:i:s", strtotime('-1 day'));
        $collection = $this->getOrderCollectionByDate($to, $from);
        $data = [];

        foreach ($collection as $order) {
            $data[] = [
                'order_id' => $order->getId(),
                'name' => $order->getCustomerName(),
                'billing_street' => $order->getBillingAddress()->getStreet()[0],
                'billing_city' => $order->getBillingAddress()->getCity(),
                'billing_postcode' => $order->getBillingAddress()->getPostcode(),
                'billing_country' => $order->getBillingAddress()->getCountryId(),
                'shipping_street' => $order->getShippingAddress()->getStreet()[0],
                'shipping_city' => $order->getShippingAddress()->getCity(),
                'shipping_postcode' => $order->getShippingAddress()->getPostcode(),
                'shipping_country' => $order->getShippingAddress()->getCountryId(),
                'grand_total' => $order->getGrandTotal(),
                'tax' => $order->getTaxAmount(),
                'shipping_total' => $order->getShippingInclTax(),
                'created_at' => $order->getCreatedAt()
            ];
        }

        $date = gmdate("d-M-Y-H:i:s");
        $this->download_send_headers($date . '-orders.csv');
        echo $this->array2csv($data);
    }

    public function getOrderCollectionByDate($to, $from)
    {
        $collection = $this->_orderCollectionFactory->create()
            ->addFieldToSelect('*')
            ->addFieldToFilter('created_at', [
                'from' => $from,
                'to' => $to
            ])
            ->setOrder(
                'created_at',
                'desc'
            );

        return $collection;
    }

    private function array2csv(array &$array)
    {
        if (count($array) == 0) {
            return null;
        }
        ob_start();
        $df = fopen("php://output", 'w');
        fputcsv($df, [
            'order_id',
            'name',
            'billing_street',
            'billing_city',
            'billing_postcode',
            'billing_country',
            'shipping_street',
            'shipping_city',
            'shipping_postcode',
            'shipping_country',
            'grand_total',
            'tax',
            'shipping_total'
        ]);
        foreach ($array as $row) {
            fputcsv($df, $row);
        }
        fclose($df);
        return ob_get_clean();
    }

    private function download_send_headers($filename)
    {
        // disable caching
        $now = gmdate("D, d M Y H:i:s");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {$now} GMT");

        // force download
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");

        // disposition / encoding on response body
        header("Content-Disposition: attachment;filename={$filename}");
        header("Content-Transfer-Encoding: binary");
    }
}
