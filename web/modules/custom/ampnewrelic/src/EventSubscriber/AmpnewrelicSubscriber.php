<?php

namespace Drupal\ampnewrelic\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Class AmpnewrelicSubscriber.
 *
 * @package Drupal\ampnewrelic
 */
class AmpnewrelicSubscriber implements EventSubscriberInterface {

  /**
   * Constructs a new AmpnewrelicSubscriber object.
   */
  public function __construct() {

  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events['kernel.request'] = ['disableNewRelic'];

    return $events;
  }

  /**
   * This method is called whenever the kernel.request event is
   * dispatched.
   *
   * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
   */
  public function disableNewRelic(GetResponseEvent $event) {
    if (extension_loaded('newrelic') && $this->isAmpRequest($event)) {
      newrelic_disable_autorum();
      newrelic_ignore_transaction();
    }
  }

  /**
   *
   */
  private function isAmpRequest(GetResponseEvent $event) {
    return $event->getRequest()->query->get('amp');
  }

}
