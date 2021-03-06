<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6eca4cf0968d210be0b73a3c21efbd5e
{
    public static $prefixLengthsPsr4 = array (
        'I' => 
        array (
            'Inggo\\WordPress\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Inggo\\WordPress\\' => 
        array (
            0 => __DIR__ . '/../..' . '/wp',
        ),
    );

    public static $classMap = array (
        'Inggo\\WordPress\\PSBADRM\\Theme' => __DIR__ . '/../..' . '/wp/PSBADRM/Theme.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6eca4cf0968d210be0b73a3c21efbd5e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6eca4cf0968d210be0b73a3c21efbd5e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit6eca4cf0968d210be0b73a3c21efbd5e::$classMap;

        }, null, ClassLoader::class);
    }
}
