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

use arabcoders\dependency\
{
    Interfaces\ParseTokenInterface,
    Interfaces\NormalizeNamesInterface
};

/**
 * Parse Token
 *
 * @package \arabcoders\CodeDependancy
 *
 * @author  Abdul.Mohsen B. A. A. <admin@arabcoders.org>
 */
class ParseToken implements ParseTokenInterface
{
    /**
     * @var bool
     */
    private $bufferStart = false;

    /**
     * @var string
     */
    private $functionCurrent = '';

    /**
     * @var bool
     */
    private $functionStart = false;

    /**
     * @var bool
     */
    private $newOperator = false;

    /**
     * @var array
     */
    private $calls = [ ];

    /**
     * @var NormalizeNamesInterface
     */
    private $normalize;

    public function __construct( NormalizeNamesInterface $normalize, array $options = [ ] )
    {
        $this->normalize = $normalize;
    }

    public function tokenArray( array $token ): ParseTokenInterface
    {
        list ( $id, $string ) = $token;

        if ( $id == T_STRING )
        {
            $this->bufferStart = true;

            $this->functionCurrent = $string;

            if ( $this->functionStart )
            {
                $this->functionStart = false;
            }

            if ( $this->newOperator )
            {
                $this->newOperator = false;
            }
        }
        elseif ( $id == T_FUNCTION || $id == T_OBJECT_OPERATOR )
        {
            $this->newOperator = false;

            $this->functionStart = true;
        }
        elseif ( $id == T_NEW || $id == T_EXTENDS )
        {
            $this->newOperator = true;
        }
        elseif ( $id == T_WHITESPACE )
        {
            // ignore whitespace
        }
        else
        {
            $this->bufferStart = false;
            $this->newOperator = false;
        }

        return $this;
    }

    public function tokenString( string $token ): ParseTokenInterface
    {
        if ( $token == '(' )
        {
            if ( $this->bufferStart )
            {
                $callName = $this->normalize->normalize( $this->functionCurrent );

                if ( !isset( $this->calls[$callName] ) )
                {
                    $this->calls[$callName] = 1;

                }
                else
                {
                    $this->calls[$callName]++;

                }
                $this->bufferStart = false;
            }
        }
        elseif ( $token == ')' )
        {
            $this->bufferStart = false;
        }

        return $this;
    }

    public function getCalls(): array
    {
        return $this->calls;
    }

    public function reset(): ParseTokenInterface
    {
        $this->calls           = [ ];
        $this->functionCurrent = '';
        $this->bufferStart     = false;
        $this->functionStart   = false;
        $this->newOperator     = false;

        return $this;
    }

}