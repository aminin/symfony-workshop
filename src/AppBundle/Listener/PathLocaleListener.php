<?php

namespace AppBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\Routing\RouterInterface;

class PathLocaleListener
{
    private $session;
    private $securityContext;
    private $router;

    public function __construct($session, $securityContext, RouterInterface $router)
    {
        $this->session = $session;
        $this->securityContext = $securityContext;
        $this->router = $router;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (HttpKernel::MASTER_REQUEST != $event->getRequestType()) {
            return;
        }

        $matchRe = sprintf('~^/(%s)~', implode('|', $this->getValidLocales()));

        $request = $event->getRequest();

        if (preg_match($matchRe, $request->getPathInfo(), $m)) {
            $locale = $m[1];
            $this->injectProperty($request, 'pathInfo', preg_replace($matchRe, '', $request->getPathInfo()));
            $this->router->getContext()->setPathInfo($request->getPathInfo());
            $request->attributes->set('_locale', $locale);
        }
    }

    public function getValidLocales()
    {
        return ['ru', 'by', 'en', 'cz', 'ua'];
    }

    private function injectProperty($object, $propertyName, $propertyValue)
    {
        $reflectionClass = new \ReflectionClass($object);
        $reflectionProperty = $reflectionClass->getProperty($propertyName);
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($object, $propertyValue);
        $reflectionProperty->setAccessible(false);
    }
}