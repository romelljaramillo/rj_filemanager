<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit070138d55050590b9fa78153674715fe
{
    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'Roanja\\Rjfilesmanager\\' => 22,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Roanja\\Rjfilesmanager\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Rj_Filesmanager' => __DIR__ . '/../..' . '/rj_filesmanager.php',
        'Roanja\\Rjfilesmanager\\Controller\\Admin\\RjfileController' => __DIR__ . '/../..' . '/src/Controller/Admin/RjfileController.php',
        'Roanja\\Rjfilesmanager\\Database\\RjfileInstaller' => __DIR__ . '/../..' . '/src/Database/RjfileInstaller.php',
        'Roanja\\Rjfilesmanager\\Entity\\Rjfile' => __DIR__ . '/../..' . '/src/Entity/Rjfile.php',
        'Roanja\\Rjfilesmanager\\Form\\RjFileType' => __DIR__ . '/../..' . '/src/Form/RjFileType.php',
        'Roanja\\Rjfilesmanager\\Form\\RjfileFormDataHandler' => __DIR__ . '/../..' . '/src/Form/RjfileFormDataHandler.php',
        'Roanja\\Rjfilesmanager\\Form\\RjfileFormDataProvider' => __DIR__ . '/../..' . '/src/Form/RjfileFormDataProvider.php',
        'Roanja\\Rjfilesmanager\\Grid\\Definition\\Factory\\RjfileGridDefinitionFactory' => __DIR__ . '/../..' . '/src/Grid/Definition/Factory/RjfileGridDefinitionFactory.php',
        'Roanja\\Rjfilesmanager\\Grid\\Filters\\RjfileFilters' => __DIR__ . '/../..' . '/src/Grid/Filters/RjfileFilters.php',
        'Roanja\\Rjfilesmanager\\Grid\\Query\\RjfileQueryBuilder' => __DIR__ . '/../..' . '/src/Grid/Query/RjfileQueryBuilder.php',
        'Roanja\\Rjfilesmanager\\Repository\\RjfileRepository' => __DIR__ . '/../..' . '/src/Repository/RjfileRepository.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit070138d55050590b9fa78153674715fe::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit070138d55050590b9fa78153674715fe::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit070138d55050590b9fa78153674715fe::$classMap;

        }, null, ClassLoader::class);
    }
}
