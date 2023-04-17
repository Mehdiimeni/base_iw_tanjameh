<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita382ff37f63409228bc502095e7dd032
{
    public static $prefixLengthsPsr4 = array (
        'c' => 
        array (
            'conf\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'conf\\' => 
        array (
            0 => __DIR__ . '/../..' . '/idefine/conf',
        ),
    );

    public static $classMap = array (
        'ACLTools' => __DIR__ . '/../..' . '/iassets/classes/ACLTools.php',
        'APIConnectionInterface' => __DIR__ . '/../..' . '/iassets/interfaces/APIConnectionInterface.php',
        'AsosAssets' => __DIR__ . '/../..' . '/iassets/classes/AsosAssets.php',
        'AsosConnections' => __DIR__ . '/../..' . '/iassets/classes/AsosConnections.php',
        'BoolEnum' => __DIR__ . '/../..' . '/iassets/enum/BoolEnum.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'ConfigTools' => __DIR__ . '/../..' . '/iassets/classes/ConfigTools.php',
        'DBConnect' => __DIR__ . '/../..' . '/iassets/classes/DBConnect.php',
        'DBConnectionInterface' => __DIR__ . '/../..' . '/iassets/interfaces/DBConnectionInterface.php',
        'DBORM' => __DIR__ . '/../..' . '/iassets/classes/DBORM.php',
        'FileCaller' => __DIR__ . '/../..' . '/iassets/classes/FileCaller.php',
        'FileSizeEnum' => __DIR__ . '/../..' . '/iassets/enum/FileSizeEnum.php',
        'FileTools' => __DIR__ . '/../..' . '/iassets/classes/FileTools.php',
        'GlobalVarTools' => __DIR__ . '/../..' . '/iassets/classes/GlobalVarTools.php',
        'IPGEnum' => __DIR__ . '/../..' . '/iassets/enum/IPGEnum.php',
        'IPTools' => __DIR__ . '/../..' . '/iassets/classes/IPTools.php',
        'IPanelViewUnity' => __DIR__ . '/../..' . '/iassets/classes/IPanelViewUnity.php',
        'IWCheckTools' => __DIR__ . '/../..' . '/iassets/classes/IWCheckTools.php',
        'InitTools' => __DIR__ . '/../..' . '/iassets/classes/InitTools.php',
        'JavaTools' => __DIR__ . '/../..' . '/iassets/classes/JavaTools.php',
        'KMNConnection' => __DIR__ . '/../..' . '/iassets/classes/KMNConnection.php',
        'ListTools' => __DIR__ . '/../..' . '/iassets/classes/ListTools.php',
        'MSSQLDBConnection' => __DIR__ . '/../..' . '/iassets/classes/MSSQLDBConnection.php',
        'MakeDirectory' => __DIR__ . '/../..' . '/iassets/classes/MakeDirectory.php',
        'MariaDBConnection' => __DIR__ . '/../..' . '/iassets/classes/MariaDBConnection.php',
        'MySQLConnection' => __DIR__ . '/../..' . '/iassets/classes/MySQLConnection.php',
        'PdfTools' => __DIR__ . '/../..' . '/iassets/classes/PdfTools.php',
        'PinEnum' => __DIR__ . '/../..' . '/iassets/enum/PinEnum.php',
        'PositionEnum' => __DIR__ . '/../..' . '/iassets/enum/PositionEnum.php',
        'PricingTools' => __DIR__ . '/../..' . '/iassets/classes/PricingTools.php',
        'RNLS2Connection' => __DIR__ . '/../..' . '/iassets/classes/RNLS2Connection.php',
        'Regularization' => __DIR__ . '/../..' . '/iassets/classes/Regularization.php',
        'Router' => __DIR__ . '/../..' . '/iassets/classes/Router.php',
        'SamanPayment' => __DIR__ . '/../..' . '/iassets/classes/SamanPayment.php',
        'Sanitize' => __DIR__ . '/../..' . '/iassets/classes/Sanitize.php',
        'SessionTools' => __DIR__ . '/../..' . '/iassets/classes/SessionTools.php',
        'ShippingTools' => __DIR__ . '/../..' . '/iassets/classes/ShippingTools.php',
        'ShowFile' => __DIR__ . '/../..' . '/iassets/classes/ShowFile.php',
        'SmsConnections' => __DIR__ . '/../..' . '/iassets/classes/SmsConnections.php',
        'StorageTools' => __DIR__ . '/../..' . '/iassets/classes/StorageTools.php',
        'TimeTools' => __DIR__ . '/../..' . '/iassets/classes/TimeTools.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita382ff37f63409228bc502095e7dd032::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita382ff37f63409228bc502095e7dd032::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInita382ff37f63409228bc502095e7dd032::$classMap;

        }, null, ClassLoader::class);
    }
}
