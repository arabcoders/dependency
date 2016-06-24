<?php
/**
 * This file is part of {@see \arabcoders\dependency} package.
 *
 * (c) 2016 ArabCoders.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace arabcoders\dependency;

use arabcoders\dependency\
{
    Interfaces\NormalizeNamesInterface,
    Interfaces\ParseExtensionsInterface
};
use \ReflectionExtension;

/**
 * Parse Extensions
 *
 * Prase Extentions Classes and Functions.
 *
 * @author  Abdul.Mohsen B. A. A. <admin@arabcoders.org>
 */
class ParseExtensions implements ParseExtensionsInterface
{
    /**
     * @var array
     */
    private $parsed = [ ];

    /**
     * @var array|mixed
     */
    private $extensions = [ ];

    /**
     * @var NormalizeNamesInterface
     */
    private $normalize;

    public function __construct( NormalizeNamesInterface $normalize, array $options = [ ] )
    {
        $this->normalize  = $normalize;
        $this->extensions = ( !empty( $options['extensions'] ) ) ? $options['extensions'] : get_loaded_extensions();
    }

    public function run(): ParseExtensionsInterface
    {
        foreach ( $this->extensions as $ext )
        {
            $extensionReflection = new ReflectionExtension( $ext );

            if ( ( $calls = $extensionReflection->getFunctions() ) )
            {
                foreach ( $calls as $call )
                {
                    $striStr = stristr( $call->getName(), '\\' );

                    if ( '\\' === substr( $striStr, 0, 1 ) )
                    {
                        $call = substr( $striStr, 1 );
                    }
                    else
                    {
                        $call = $call->getName();
                    }

                    $this->addToParsed( $ext, $call );
                }
            }

            if ( ( $calls = $extensionReflection->getClassNames() ) )
            {
                foreach ( $calls as $call )
                {
                    $striStr = stristr( $call, '\\' );

                    if ( '\\' === substr( $call, 0, 1 ) )
                    {
                        $call = substr( $striStr, 1 );
                    }

                    $this->addToParsed( $ext, $call );
                }
            }
        }

        return $this;
    }

    public function getParsedExtensions(): array
    {
        return $this->parsed;
    }

    /**
     * Add Extention to List.
     *
     * @param string $ext  extension.
     * @param string $call method/class/function.
     *
     * @return ParseExtensionsInterface
     */
    protected function addToParsed( string $ext, string $call ): ParseExtensionsInterface
    {
        if ( !isset( $this->parsed[$ext] ) )
        {
            $this->parsed[$ext] = [ ];
        }

        $this->parsed[$ext][$call] = 1;

        return $this;
    }
}