<?php

namespace Drupal\showalter\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;


class ShowalterSubscriber implements EventSubscriberInterface {
  static function getSubscribedEvents() {
    $events[KernelEvents::REQUEST][] = array('checkIfAuthenticated');
    return $events;
  }

  public function checkIfAuthenticated(GetResponseEvent $event) {
    if (! \Drupal::currentUser()->isAuthenticated()) {
      $request_uri = $event->getRequest()->getRequestUri();
      switch ($request_uri) {
        case '/user/login':
        case '/user/password':
        case '/user/register':
          break;

        default:
        $event->setResponse(new RedirectResponse('/user/login'));
      }
    }
  }
}


