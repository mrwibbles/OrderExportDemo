<?php

namespace AlexGlover\OrderExportDemo\Block;

use Magento\Backend\Block\Template\Context;
use Magento\Framework\View\Element\Template;
use Magento\Framework\UrlInterface;
use Magento\Framework\Data\Form\FormKey;

class Export extends Template
{
    public function __construct(
        Context $context,
        UrlInterface $url,
        FormKey $formKey,
        array $data = []
    ) {
        $this->_url = $url;
        $this->formKey = $formKey;
        parent::__construct($context, $data);
    }

    public function getExportUrl()
    {
        return $this->_url->getUrl('demoorderexport/OrderExportDemo/export');
    }

    public function generateCsv()
    {
        if (!empty($_POST)) {
            var_dump('worky');
        }
    }

    public function getFormKey()
    {
        return $this->formKey->getFormKey();
    }
}
