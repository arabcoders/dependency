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

use Traversable;
use arabcoders\dependency\
{
    Interfaces\DependencyInterface,
    Interfaces\ParseTokenInterface,
    Interfaces\NormalizeNamesInterface,
    Interfaces\ParseExtensionsInterface
};

/**
 * Find function and class dependencies in PHP source code
 *
 * This class can determine all classes and functions used by one or more PHP scripts.
 * This is useful to determine if scripts can be run in certain environments.
 *
 * @package \arabcoders\CodeDependancy
 *
 * @author  Abdul.Mohsen B. A. A. <admin@arabcoders.org>
 */
class Dependency implements DependencyInterface
{
    /**
     * @var array
     */
    private $extensions = [ ];

    /**
     * @var array
     */
    private $calls = [ ];

    /**
     * @var ParseTokenInterface
     */
    private $parser;

    /**
     * @var NormalizeNamesInterface
     */
    private $normalize;

    /**
     * @var Traversable
     */
    private $files;

    /**
     * @var array
     */
    private $flipArray = [ ];

    public function __construct( NormalizeNamesInterface $normalize,
                                 ParseExtensionsInterface $extentions,
                                 ParseTokenInterface $parser,
                                 Traversable $files,
                                 array $options = [ ]
    )
    {
        $this->files      = $files;
        $this->extensions = $extentions->getParsedExtensions();
        $this->normalize  = $normalize;
        $this->parser     = $parser;

        foreach ( $this->extensions as $extention => $calls )
        {
            if ( is_array( $calls ) )
            {
                foreach ( $calls as $call => $count )
                {
                    $this->flipArray[$call] = $extention;
                }
            }
            else
            {
                $this->flipArray[$calls] = $extention;
            }
        }
    }

    public function run(): DependencyInterface
    {
        foreach ( $this->files as $file )
        {
            $this->parser->reset();

            foreach ( token_get_all( file_get_contents( $file[0] ) ) as $token )
            {
                if ( is_array( $token ) )
                {
                    $this->parser->tokenArray( $token );
                }
                else
                {
                    $this->parser->tokenString( $token );
                }
            }

            $calls = $this->parser->getCalls();

            foreach ( $calls as $call => $count )
            {
                $call = $this->normalize->normalize( $call );

                if ( !array_key_exists( $call, $this->flipArray ) )
                {
                    continue;
                }

                $key = $this->flipArray[$call];

                if ( isset( $this->calls[$key][$call] ) )
                {
                    $this->calls[$key][$call] = $this->calls[$key][$call] + $count;
                }
                else
                {
                    $this->calls[$key][$call] = $count;
                }
            }
        }

        return $this;
    }

    public function getCountPerExtensionCalls(): array
    {
        return $this->calls;
    }

    public function getCountPerExtention(): array
    {
        $calls = [ ];

        foreach ( $this->calls as $extention => $call )
        {
            if ( is_array( $call ) )
            {
                foreach ( $call as $method => $count )
                {
                    if ( !isset( $calls[$extention] ) )
                    {
                        $calls[$extention] = 0;
                    }

                    $calls[$extention] = $calls[$extention] + $count;
                }
            }
        }

        return $calls;
    }

    public function getExtensions(): array
    {
        return $this->extensions;
    }

}