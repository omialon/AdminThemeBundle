<?php
/**
 * EmitterController.php
 * symfony3
 * Date: 13.06.16
 */

namespace Avanzu\AdminThemeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\Event;

class EmitterController extends AbstractController
{

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher){
        parent::__construct();
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Will look for a method of the format "on<CamelizedEventName>" and call it with the event as argument.
     *
     *
     * Then it will dispatch the event as normal via the event dispatcher.
     *
     * @param       $eventName
     * @param       $event
     *
     * @return Event
     */
    protected function triggerMethod($eventName, $event)
    {
        $method = sprintf('on%s', Container::camelize(str_replace('.', '_', $eventName)));

        if(is_callable([$this, $method])) {
            call_user_func_array([$this, $method], [$event]);
        }

        if($event->isPropagationStopped()){
            return $event;
        }

        $this->eventDispatcher->dispatch($event, $eventName);
        return $event;
    }
}
