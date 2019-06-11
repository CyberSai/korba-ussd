<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2b07cfbc016303a51aceb3f94f93a6fc
{
    public static $classMap = array (
        'Korba\\API' => __DIR__ . '/../..' . '/src/API.php',
        'Korba\\AirtimeNetNum' => __DIR__ . '/../..' . '/src/service/airtime/AirtimeNetNum.php',
        'Korba\\Collection' => __DIR__ . '/../..' . '/src/Collection.php',
        'Korba\\Generator' => __DIR__ . '/../..' . '/src/Generator.php',
        'Korba\\Menu' => __DIR__ . '/../..' . '/src/service/Menu.php',
        'Korba\\Param' => __DIR__ . '/../..' . '/src/Param.php',
        'Korba\\SubMenu' => __DIR__ . '/../..' . '/src/service/SubMenu.php',
        'Korba\\Util' => __DIR__ . '/../..' . '/src/Util.php',
        'Korba\\View' => __DIR__ . '/../..' . '/src/View.php',
        'Korba\\XChangeV1' => __DIR__ . '/../..' . '/src/XChangeV1.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit2b07cfbc016303a51aceb3f94f93a6fc::$classMap;

        }, null, ClassLoader::class);
    }
}
