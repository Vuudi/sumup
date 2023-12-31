<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1c7ba12908e1004f270bd94af6a2c357
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'SumUp\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'SumUp\\' => 
        array (
            0 => __DIR__ . '/..' . '/sumup/sumup-ecom-php-sdk/src/SumUp',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1c7ba12908e1004f270bd94af6a2c357::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1c7ba12908e1004f270bd94af6a2c357::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit1c7ba12908e1004f270bd94af6a2c357::$classMap;

        }, null, ClassLoader::class);
    }
}
