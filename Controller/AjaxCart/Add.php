<?php
/**
 * @category    M2Commerce Enterprise
 * @package     M2Commerce_BulkAddToCart
 * @copyright   Copyright (c) 2023 M2Commerce Enterprise
 * @author      dawoodgondaldev@gmail.com
 */

namespace M2Commerce\BulkAddToCart\Controller\AjaxCart;

use Magento\Checkout\Model\Cart;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Data\Form\FormKey;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\UrlInterface;
use Psr\Log\LoggerInterface;

/**
 * Bulk Add to Cart Action Class
 */
class Add implements HttpPostActionInterface
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var ManagerInterface
     */
    private $messageManager;

    /**
     * @var ResultFactory
     */
    private $resultFactory;

    /**
     * @var FormKey
     */
    private $formKey;

    /**
     * @var Cart
     */
    private $cart;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var UrlInterface
     */
    private $url;

    /**
     * @param RequestInterface $request
     * @param ManagerInterface $messageManager
     * @param FormKey $formKey
     * @param Cart $cart
     * @param ResultFactory $resultFactory
     * @param LoggerInterface $logger
     * @param UrlInterface $url
     */
    public function __construct(
        RequestInterface $request,
        ManagerInterface $messageManager,
        FormKey $formKey,
        Cart $cart,
        ResultFactory $resultFactory,
        LoggerInterface $logger,
        UrlInterface $url
    ) {
        $this->request = $request;
        $this->messageManager = $messageManager;
        $this->formKey = $formKey;
        $this->cart = $cart;
        $this->resultFactory = $resultFactory;
        $this->logger = $logger;
        $this->url = $url;
    }

    /**
     * @return ResponseInterface|ResultInterface
     */
    public function execute()
    {
        $productsToAdd = $this->request->getParam('productsToAdd');
        $status = false;
        if ($productsToAdd) {
            try {
                $count = 0;
                foreach ($productsToAdd as $item) {
                    $params = [
                        'form_key' => $this->formKey->getFormKey(),
                        'product_id' => $item['id'],
                        'qty' => $item['qty']
                    ];

                    if (isset($item['options'])){
                        $params['super_attribute'] = $item['options'];
                    }

                    $this->cart->addProduct($item['id'], $params);
                    $count++;
                }
                $this->cart->save();
                $status = true;
                $this->messageManager->addComplexSuccessMessage(
                    'addCartSuccessMessage',
                    [
                        'product_name' => $count . " products",
                        'cart_url' => $this->getCartUrl(),
                    ]
                );
            } catch (LocalizedException | \Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->logger->error($e->getMessage());
            }
        } else {
            $this->messageManager->addErrorMessage("Invalid request, try again!");
        }
        $result = [];
        $result['status'] = $status;
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData($result);
        return $resultJson;
    }

    /**
     * Returns cart url
     *
     * @return string
     */
    private function getCartUrl(): string
    {
        return $this->url->getUrl('checkout/cart', ['_secure' => true]);
    }
}
