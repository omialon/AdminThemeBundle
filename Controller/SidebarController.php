<?php
/**
 * SidebarController.php
 * avanzu-admin
 * Date: 23.02.14
 */

namespace Avanzu\AdminThemeBundle\Controller;

use Avanzu\AdminThemeBundle\Event\ShowUserEvent;
use Avanzu\AdminThemeBundle\Event\SidebarMenuEvent;
use Avanzu\AdminThemeBundle\Event\ThemeEvents;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class SidebarController extends AbstractController
{
    /**
     * Block used in macro avanzu_sidebar_user
     *
     * @param EventDispatcherInterface $eventDispatcher
     * @return Response
     */
    public function userPanelAction(EventDispatcherInterface $eventDispatcher): Response
    {
        if (!$eventDispatcher->hasListeners(ThemeEvents::THEME_SIDEBAR_USER)) {
            return new Response();
        }
        $userEvent = $eventDispatcher->dispatch(new ShowUserEvent(), ThemeEvents::THEME_SIDEBAR_USER);

        return $this->render(
                    '@AvanzuAdminTheme/Sidebar/user-panel.html.twig',
                        [
                            'user' => $userEvent->getUser(),
                        ]
        );
    }

    /**
     * Block used in macro avanzu_sidebar_search
     * 
     * @return Response
     */
    public function searchFormAction(): Response
    {
        return $this->render('@AvanzuAdminTheme/Sidebar/search-form.html.twig', []);
    }

    public function menuAction(Request $request, EventDispatcherInterface $eventDispatcher): Response
    {
        if (!$eventDispatcher->hasListeners(ThemeEvents::THEME_SIDEBAR_SETUP_MENU)) {
            return new Response();
        }

        $event = $eventDispatcher->dispatch(new SidebarMenuEvent($request), ThemeEvents::THEME_SIDEBAR_SETUP_MENU);

        $eventItems = $event->getItems();
        
        return $this->render(
                    '@AvanzuAdminTheme/Sidebar/menu.html.twig',
                        [
                            'menu' => $eventItems,
                        ]
        );
    }
}
