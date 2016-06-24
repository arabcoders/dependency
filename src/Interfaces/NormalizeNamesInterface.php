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
 * Normalize Names Interface.
 *
 * @package \arabcoders\CodeDependancy\Interfaces
 *
 * @author  Abdul.Mohsen B. A. A. <admin@arabcoders.org>
 */
Interface NormalizeNamesInterface
{
    public function normalize( $name ): string;
}