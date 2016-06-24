<?php
/**
 * This file is part of {@see \arabcoders\dependency} package.
 *
 * (c) 2016 Abdulmohsen B. A. A.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace arabcoders\dependency\Interfaces;

/**
 * Parse Token Interface.
 *
 * @package \arabcoders\CodeDependancy
 *
 * @author  Abdul.Mohsen B. A. A. <admin@arabcoders.org>
 */
Interface ParseTokenInterface
{
    /**
     *  constructor.
     *
     * @param NormalizeNamesInterface $normalize normal text.
     * @param array                   $options
     */
    public function __construct( NormalizeNamesInterface $normalize, array $options = [ ] );

    /**
     * Parse PHP Token.
     *
     * @param array $token
     *
     * @return ParseTokenInterface
     */
    public function tokenArray( array $token ): ParseTokenInterface;

    /**
     * Parse PHP String.
     *
     * @param string $token
     *
     * @return ParseTokenInterface
     */
    public function tokenString( string $token ): ParseTokenInterface;

    /**
     * Get Calls.
     *
     * @return array
     */
    public function getCalls(): array;

    /**
     * Reset Counters.
     *
     * @return ParseTokenInterface
     */
    public function reset():ParseTokenInterface;
}