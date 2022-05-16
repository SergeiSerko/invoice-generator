<?php

namespace App\Controller\REST;

use App\Repository\OrderRepositoryInterface;
use App\Service\Order\DTO\Order;
use App\Service\Order\DTO\OrderPlacement;
use App\Service\Order\Resolver\ChainedOrderResolver;
use App\Service\Order\Resolver\OrderResolverInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/orders")
 */
class OrderController extends AbstractFOSRestController
{
    private OrderRepositoryInterface $orderRepository;
    private ChainedOrderResolver $orderResolver;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        OrderResolverInterface $orderResolver
    )
    {
        $this->orderRepository = $orderRepository;
        $this->orderResolver = $orderResolver;;
    }

    /**
     * @Route("", name="placeOrder", methods={"POST"})
     * @ParamConverter("orderPlacement", converter="fos_rest.request_body")
     */
    public function placeOrder(OrderPlacement $orderPlacement = null): View
    {
        $order = new Order($orderPlacement);
        try {
            $this->orderResolver->resolve($order);

            $view = View::create();
            $view->setData($order->getInvoice());
            $view->setFormat($order->getOrderPlacement()->getInvoiceFormat());
        } catch (\Exception $e) {
            $view = View::create();
            $view->setData($e);
            $view->setStatusCode(400);
            $view->setFormat('json');
        }
        return $view;

    }

    /**
     * @Route("", name="getOrders", methods={"GET"})
     * @Rest\View(serializerGroups={"Order"})
     */
    public function getOrders(): array
    {
        return $this->orderRepository->findAll();
    }
}