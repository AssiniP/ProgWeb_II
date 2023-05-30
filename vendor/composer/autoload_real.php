<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitb2467d20d1b8cac21c54c7be3f86e6c9
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInitb2467d20d1b8cac21c54c7be3f86e6c9', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitb2467d20d1b8cac21c54c7be3f86e6c9', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitb2467d20d1b8cac21c54c7be3f86e6c9::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}