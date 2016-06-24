<?php
/**
 * This file is part of {@see \arabcoders\dependency} package.
 *
 * (c) 2016 Abdulmohsen B. A. A.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace arabcoders\dependency;

use arabcoders\dependency\Interfaces\NormalizeNamesInterface;

/**
 * Normalize Names.
 *
 * @package \arabcoders\CodeDependancy
 *
 * @author  Abdul.Mohsen B. A. A. <admin@arabcoders.org>
 */
class NormalizeNames implements NormalizeNamesInterface
{
    public function normalize( $name ): string
    {
        return strtolower( $name );
    }
}