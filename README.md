# Code Dependency

Find function and class dependencies in PHP source code

This class can determine all classes and functions used by one or more PHP scripts,
This is useful to determine if scripts can be run in certain environments.

## Install

Via Composer

```bash
$ composer require arabcoders/dependency
```

## Usage Example.

```php
<?php

require __DIR__ . '/../../autoload.php';

$normalize  = new \arabcoders\dependency\NormalizeNames();
$extentions = new \arabcoders\dependency\ParseExtensions( $normalize );
$parser     = new \arabcoders\dependency\ParseToken( $normalize );

$files = new RegexIterator(
    new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator( __DIR__ . '/dummydata' )
    ),
    '/^.+\.php$/i',
    RecursiveRegexIterator::GET_MATCH
);

$dependency = new \arabcoders\dependency\Dependency( $normalize, $extentions->run(), $parser, $files, [ ] );

print PHP_EOL . PHP_EOL . 'Get count for each extension call';

$dependency->run();

foreach ( $dependency->getCountPerExtensionCalls() as $extention => $calls )
{
    print sprintf( PHP_EOL . PHP_EOL . '** Extention ( %s ) **' . PHP_EOL . PHP_EOL, $extention );
    foreach ( $calls as $call => $count )
    {
        print sprintf( '* %s: %d' . PHP_EOL, $call, $count );
    }
}

print PHP_EOL . PHP_EOL . 'Get count for each extension' . PHP_EOL . PHP_EOL;

foreach ( $dependency->getCountPerExtention() as $extention => $count )
{
    print sprintf( '** %s: %d **' . PHP_EOL, $extention, $count );
}
```
