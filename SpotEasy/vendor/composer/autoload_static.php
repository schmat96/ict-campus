<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit246b72b8faa08027f0cb28001d2cdf8f
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'SpotifyWebAPI\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'SpotifyWebAPI\\' => 
        array (
            0 => __DIR__ . '/..' . '/jwilsson/spotify-web-api-php/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit246b72b8faa08027f0cb28001d2cdf8f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit246b72b8faa08027f0cb28001d2cdf8f::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
