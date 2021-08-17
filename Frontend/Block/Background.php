<?php
namespace Magenest\Frontend\Block;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Background extends Template
{
    protected $config;
    public function __construct(
        Context $context,
        ScopeConfigInterface $config,
        array $data = []
    ) {
        $this->config = $config;
        parent::__construct($context, $data);
    }

    public function getColor()
    {
        try {
            $color = $this->config->getValue('colors/color/option');
        } catch (LocalizedException $e) {
            $color = null;
        }

        return $color;
    }
}
