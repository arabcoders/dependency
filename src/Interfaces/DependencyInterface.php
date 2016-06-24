<?php
/**
 * This file is part of {@see \arabcoders\dependency} package.
 *
 * (c) 2016 ArabCoders.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace arabcoders\dependency\Interfaces;

use Traversable;

/**
 * Dependency Interface.
 *
 * @package \arabcoders\CodeDependancy\Interfaces
 *
 * @author  Abdul.Mohsen B. A. A. <admin@arabcoders.org>
 */
Interface DependencyInterface
{
    public function __construct( NormalizeNamesInterface $normalize,
                                 ParseExtensionsInterface $extentions,
                                 ParseTokenInterface $parser,
                                 Traversable $files,
                                 array $options = [ ]
    );

    /**
     * Parse Files extensions usage.
     *
     * @return DependencyInterface
     */
    public function run(): DependencyInterface;

    /**
     * Get Count Per Extension Calls.
     *
     * @return array
     */
    public function getCountPerExtensionCalls(): array;

    /**
     * Get Calls Per Extention.
     *
     * @return array
     */
    public function getCountPerExtention(): array;

    /**
     * Get Parsed Extensions, Classes And Functions.
     *
     * @return array
     */
    public function getExtensions(): array;
}