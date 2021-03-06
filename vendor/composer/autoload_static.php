<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite23d8547107dc57518eb55a64d94e78d
{
    public static $prefixLengthsPsr4 = array (
        'V' => 
        array (
            'Vsd\\Mvcs\\Example\\' => 17,
            'Vsd\\Mvcs\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Vsd\\Mvcs\\Example\\' => 
        array (
            0 => __DIR__ . '/../..' . '/example',
        ),
        'Vsd\\Mvcs\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite23d8547107dc57518eb55a64d94e78d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite23d8547107dc57518eb55a64d94e78d::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
