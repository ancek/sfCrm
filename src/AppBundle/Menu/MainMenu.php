<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Description of Menu
 */
class MainMenu extends ContainerAware
{
   public function menu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('Panel', [
            'route' => 'homepage'
        ]);


        $menu->addChild('agreement_list', [
            'label' => 'Lista umów'
        ]);
        
        $menu['agreement_list']->addChild(
            'Umowy na życie', [
                'route' => 'agreement_life_list'
            ]
        );

        $menu->addChild('agreement_add', [
            'label' => 'Nowa umowa'
        ]);
        $menu['agreement_add']->addChild(
            'Umowa na życie', [
                'route' => 'agreement_life_add'
            ]
        );

        return $menu;
    }
}
