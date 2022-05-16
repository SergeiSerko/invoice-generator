<?php


namespace App\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Compiler pass to register services tagged with "order_handler" as handler in chain-of-responsibility.
 * Top priority handler is aliased, so we can use it in services configuration.
 */
class OrderResolverPass implements CompilerPassInterface
{
    const CHAINED_SERVICES_TAG = 'order_handler';
    const FIRST_HANDLER_TAG = 'app.order_handler';
    const PRIORITY_FIELD = 'priority';

    public function process(ContainerBuilder $container): void
    {
        $invoiceHandlers = $container->findTaggedServiceIds(self::CHAINED_SERVICES_TAG);
        if ($invoiceHandlers) {
            $sortedHandlers = $this->sortHandlers($invoiceHandlers);

            $firstHandlerServiceName = array_shift($sortedHandlers);

            $firstHandler = new Alias($firstHandlerServiceName);
            $firstHandler->setPublic(false);
            $container->setAlias(self::FIRST_HANDLER_TAG, $firstHandler);
            $handlerDefinition = $container->getDefinition($firstHandlerServiceName);

            foreach ($sortedHandlers as $handler) {
                $handler = $container->getDefinition($handler);
                $handlerDefinition->addMethodCall('setSuccessor', [$handler]);
                $handlerDefinition = $handler;
            }
        }
    }

    /**
     * @param array $invoiceHandlers
     * @return string[]
     */
    private function sortHandlers(array $invoiceHandlers): array
    {
        $handlersByPriority = [];
        foreach ($invoiceHandlers as $id => $attributes) {
            $priority = (int)($attributes[0][self::PRIORITY_FIELD] ?? 0);

            $handlersByPriority[$priority][] = $id;
        }
        \krsort($handlersByPriority);
        return array_merge(...$handlersByPriority);
    }
}