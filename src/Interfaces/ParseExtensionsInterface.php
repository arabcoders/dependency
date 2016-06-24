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

/**
 * Parse Extensions Interface.
 *
 * @package \arabcoders\CodeDependancy\Interfaces
 *
 * @author  Abdul.Mohsen B. A. A. <admin@arabcoders.org>
 */
Interface ParseExtensionsInterface
{
    /**
     * ParseExtensionsInterface constructor.
     *
     * @param NormalizeNamesInterface $normalize
     * @param array                   $options
     */
    public function __construct( NormalizeNamesInterface $normalize, array $options = [ ] );

    /**
     * Run Parsing on Extensions.
     *
     * @return ParseExtensionsInterface
     */
    public function run(): ParseExtensionsInterface;

    /**
     * Get Parsed Extensions.
     *
     * @return array
     */
    public function getParsedExtensions(): array;
}