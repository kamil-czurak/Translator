<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1ee04b898ddafffb7bd77fcd3d7f164a
{
    public static $prefixLengthsPsr4 = array (
        'Y' => 
        array (
            'Yandex\\Translate\\' => 17,
        ),
        'S' => 
        array (
            'Stidges\\CountryFlags\\' => 21,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Yandex\\Translate\\' => 
        array (
            0 => __DIR__ . '/..' . '/yandex/translate-api/src',
        ),
        'Stidges\\CountryFlags\\' => 
        array (
            0 => __DIR__ . '/..' . '/stidges/country-flags/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1ee04b898ddafffb7bd77fcd3d7f164a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1ee04b898ddafffb7bd77fcd3d7f164a::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
