<?php
namespace TYPO3\Surf\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerInterface;

interface ContainerAwareInterface
{
    /**
     * Sets the container.
     *
     * @return void
     */
    public function setContainer(?ContainerInterface $container);
}
