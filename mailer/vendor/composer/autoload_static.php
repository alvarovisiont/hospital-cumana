<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbb0cb533e38f448cae0ca6549318683f
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitbb0cb533e38f448cae0ca6549318683f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitbb0cb533e38f448cae0ca6549318683f::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
