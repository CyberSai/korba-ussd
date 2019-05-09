<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2b07cfbc016303a51aceb3f94f93a6fc
{
    public static $classMap = array (
        'Korba\\Collection' => __DIR__ . '/../..' . '/src/Collection.php',
        'Korba\\Generator' => __DIR__ . '/../..' . '/src/Generator.php',
        'Korba\\Param' => __DIR__ . '/../..' . '/src/Param.php',
        'Korba\\Util' => __DIR__ . '/../..' . '/src/Util.php',
        'Korba\\View' => __DIR__ . '/../..' . '/src/View.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit2b07cfbc016303a51aceb3f94f93a6fc::$classMap;

        }, null, ClassLoader::class);
    }
}
