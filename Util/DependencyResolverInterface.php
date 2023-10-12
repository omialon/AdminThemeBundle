<?php
/**
 * DependencyResolverInterface.php
 * publisher
 * Date: 18.04.14
 */

namespace Avanzu\AdminThemeBundle\Util;

interface DependencyResolverInterface
{
    /**
     * @param $items
     *
     * @return $this
     */
    public function register($items): self;

    /**
     * @return array
     */
    public function resolveAll(): array;
}
