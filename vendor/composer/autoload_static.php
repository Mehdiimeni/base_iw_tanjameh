<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit13b00999f3a21499952f46dee59739a9
{
    public static $prefixLengthsPsr4 = array (
        'c' => 
        array (
            'conf\\' => 5,
        ),
        'T' => 
        array (
            'Tx\\' => 3,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
            'Pasargad\\' => 9,
        ),
        'M' => 
        array (
            'MyCLabs\\Enum\\' => 13,
        ),
        'D' => 
        array (
            'Dpsoft\\Parsian\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'conf\\' => 
        array (
            0 => __DIR__ . '/../..' . '/icore/idefine/conf',
        ),
        'Tx\\' => 
        array (
            0 => __DIR__ . '/..' . '/txthinking/mailer/src',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Pasargad\\' => 
        array (
            0 => __DIR__ . '/..' . '/pepco-api/php-rest-sdk/src',
        ),
        'MyCLabs\\Enum\\' => 
        array (
            0 => __DIR__ . '/..' . '/myclabs/php-enum/src',
        ),
        'Dpsoft\\Parsian\\' => 
        array (
            0 => __DIR__ . '/..' . '/dpsoft/parsian-payment/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'C' => 
        array (
            'Curl' => 
            array (
                0 => __DIR__ . '/..' . '/curl/curl/src',
            ),
        ),
    );

    public static $classMap = array (
        'ACLTools' => __DIR__ . '/../..' . '/icore/iassets/classes/ACLTools.php',
        'APIConnectionInterface' => __DIR__ . '/../..' . '/icore/iassets/interfaces/APIConnectionInterface.php',
        'AsosAssets' => __DIR__ . '/../..' . '/icore/iassets/classes/AsosAssets.php',
        'AsosConnections' => __DIR__ . '/../..' . '/icore/iassets/classes/AsosConnections.php',
        'BoolEnum' => __DIR__ . '/../..' . '/icore/iassets/enum/BoolEnum.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'ConfigTools' => __DIR__ . '/../..' . '/icore/iassets/classes/ConfigTools.php',
        'Curl\\Curl' => __DIR__ . '/..' . '/curl/curl/src/Curl/Curl.php',
        'DBConnect' => __DIR__ . '/../..' . '/icore/iassets/classes/DBConnect.php',
        'DBConnectionInterface' => __DIR__ . '/../..' . '/icore/iassets/interfaces/DBConnectionInterface.php',
        'DBORM' => __DIR__ . '/../..' . '/icore/iassets/classes/DBORM.php',
        'Datamatrix' => __DIR__ . '/..' . '/tecnickcom/tcpdf/include/barcodes/datamatrix.php',
        'Dpsoft\\Parsian\\Exception\\ParsianException' => __DIR__ . '/..' . '/dpsoft/parsian-payment/src/Exception/ParsianException.php',
        'Dpsoft\\Parsian\\Parsian' => __DIR__ . '/..' . '/dpsoft/parsian-payment/src/Parsian.php',
        'FileCaller' => __DIR__ . '/../..' . '/icore/iassets/classes/FileCaller.php',
        'FileSizeEnum' => __DIR__ . '/../..' . '/icore/iassets/enum/FileSizeEnum.php',
        'FileTools' => __DIR__ . '/../..' . '/icore/iassets/classes/FileTools.php',
        'GlobalVarTools' => __DIR__ . '/../..' . '/icore/iassets/classes/GlobalVarTools.php',
        'IPGEnum' => __DIR__ . '/../..' . '/icore/iassets/enum/IPGEnum.php',
        'IPTools' => __DIR__ . '/../..' . '/icore/iassets/classes/IPTools.php',
        'IPanelViewUnity' => __DIR__ . '/../..' . '/icore/iassets/classes/IPanelViewUnity.php',
        'IWCheckTools' => __DIR__ . '/../..' . '/icore/iassets/classes/IWCheckTools.php',
        'InitTools' => __DIR__ . '/../..' . '/icore/iassets/classes/InitTools.php',
        'JavaTools' => __DIR__ . '/../..' . '/icore/iassets/classes/JavaTools.php',
        'KMNConnection' => __DIR__ . '/../..' . '/icore/iassets/classes/KMNConnection.php',
        'ListTools' => __DIR__ . '/../..' . '/icore/iassets/classes/ListTools.php',
        'MSSQLDBConnection' => __DIR__ . '/../..' . '/icore/iassets/classes/MSSQLDBConnection.php',
        'MakeDirectory' => __DIR__ . '/../..' . '/icore/iassets/classes/MakeDirectory.php',
        'MariaDBConnection' => __DIR__ . '/../..' . '/icore/iassets/classes/MariaDBConnection.php',
        'MyCLabs\\Enum\\Enum' => __DIR__ . '/..' . '/myclabs/php-enum/src/Enum.php',
        'MyCLabs\\Enum\\PHPUnit\\Comparator' => __DIR__ . '/..' . '/myclabs/php-enum/src/PHPUnit/Comparator.php',
        'MySQLConnection' => __DIR__ . '/../..' . '/icore/iassets/classes/MySQLConnection.php',
        'PDF417' => __DIR__ . '/..' . '/tecnickcom/tcpdf/include/barcodes/pdf417.php',
        'Pasargad\\BossIPG' => __DIR__ . '/..' . '/pepco-api/php-rest-sdk/src/BossIPG.php',
        'Pasargad\\Classes\\AbstractBossIPG' => __DIR__ . '/..' . '/pepco-api/php-rest-sdk/src/Classes/AbstractBossIPG.php',
        'Pasargad\\Classes\\AbstractPayment' => __DIR__ . '/..' . '/pepco-api/php-rest-sdk/src/Classes/AbstractPayment.php',
        'Pasargad\\Classes\\PaymentItem' => __DIR__ . '/..' . '/pepco-api/php-rest-sdk/src/Classes/PaymentItem.php',
        'Pasargad\\Classes\\RSA\\RSA' => __DIR__ . '/..' . '/pepco-api/php-rest-sdk/src/Classes/RSA/RSA.php',
        'Pasargad\\Classes\\RSA\\RSAProcessor' => __DIR__ . '/..' . '/pepco-api/php-rest-sdk/src/Classes/RSA/RSAProcessor.php',
        'Pasargad\\Classes\\RequestBuilder' => __DIR__ . '/..' . '/pepco-api/php-rest-sdk/src/Classes/RequestBuilder.php',
        'Pasargad\\Pasargad' => __DIR__ . '/..' . '/pepco-api/php-rest-sdk/src/Pasargad.php',
        'PdfTools' => __DIR__ . '/../..' . '/icore/iassets/classes/PdfTools.php',
        'PinEnum' => __DIR__ . '/../..' . '/icore/iassets/enum/PinEnum.php',
        'PositionEnum' => __DIR__ . '/../..' . '/icore/iassets/enum/PositionEnum.php',
        'PricingTools' => __DIR__ . '/../..' . '/icore/iassets/classes/PricingTools.php',
        'Psr\\Log\\AbstractLogger' => __DIR__ . '/..' . '/psr/log/Psr/Log/AbstractLogger.php',
        'Psr\\Log\\InvalidArgumentException' => __DIR__ . '/..' . '/psr/log/Psr/Log/InvalidArgumentException.php',
        'Psr\\Log\\LogLevel' => __DIR__ . '/..' . '/psr/log/Psr/Log/LogLevel.php',
        'Psr\\Log\\LoggerAwareInterface' => __DIR__ . '/..' . '/psr/log/Psr/Log/LoggerAwareInterface.php',
        'Psr\\Log\\LoggerAwareTrait' => __DIR__ . '/..' . '/psr/log/Psr/Log/LoggerAwareTrait.php',
        'Psr\\Log\\LoggerInterface' => __DIR__ . '/..' . '/psr/log/Psr/Log/LoggerInterface.php',
        'Psr\\Log\\LoggerTrait' => __DIR__ . '/..' . '/psr/log/Psr/Log/LoggerTrait.php',
        'Psr\\Log\\NullLogger' => __DIR__ . '/..' . '/psr/log/Psr/Log/NullLogger.php',
        'Psr\\Log\\Test\\DummyTest' => __DIR__ . '/..' . '/psr/log/Psr/Log/Test/DummyTest.php',
        'Psr\\Log\\Test\\LoggerInterfaceTest' => __DIR__ . '/..' . '/psr/log/Psr/Log/Test/LoggerInterfaceTest.php',
        'Psr\\Log\\Test\\TestLogger' => __DIR__ . '/..' . '/psr/log/Psr/Log/Test/TestLogger.php',
        'QRcode' => __DIR__ . '/..' . '/tecnickcom/tcpdf/include/barcodes/qrcode.php',
        'RNLS2Connection' => __DIR__ . '/../..' . '/icore/iassets/classes/RNLS2Connection.php',
        'Regularization' => __DIR__ . '/../..' . '/icore/iassets/classes/Regularization.php',
        'SamanPayment' => __DIR__ . '/../..' . '/icore/iassets/classes/SamanPayment.php',
        'Sanitize' => __DIR__ . '/../..' . '/icore/iassets/classes/Sanitize.php',
        'SessionTools' => __DIR__ . '/../..' . '/icore/iassets/classes/SessionTools.php',
        'ShippingTools' => __DIR__ . '/../..' . '/icore/iassets/classes/ShippingTools.php',
        'ShowFile' => __DIR__ . '/../..' . '/icore/iassets/classes/ShowFile.php',
        'SmsConnections' => __DIR__ . '/../..' . '/icore/iassets/classes/SmsConnections.php',
        'StorageTools' => __DIR__ . '/../..' . '/icore/iassets/classes/StorageTools.php',
        'Stringable' => __DIR__ . '/..' . '/myclabs/php-enum/stubs/Stringable.php',
        'TCPDF' => __DIR__ . '/..' . '/tecnickcom/tcpdf/tcpdf.php',
        'TCPDF2DBarcode' => __DIR__ . '/..' . '/tecnickcom/tcpdf/tcpdf_barcodes_2d.php',
        'TCPDFBarcode' => __DIR__ . '/..' . '/tecnickcom/tcpdf/tcpdf_barcodes_1d.php',
        'TCPDF_COLORS' => __DIR__ . '/..' . '/tecnickcom/tcpdf/include/tcpdf_colors.php',
        'TCPDF_FILTERS' => __DIR__ . '/..' . '/tecnickcom/tcpdf/include/tcpdf_filters.php',
        'TCPDF_FONTS' => __DIR__ . '/..' . '/tecnickcom/tcpdf/include/tcpdf_fonts.php',
        'TCPDF_FONT_DATA' => __DIR__ . '/..' . '/tecnickcom/tcpdf/include/tcpdf_font_data.php',
        'TCPDF_IMAGES' => __DIR__ . '/..' . '/tecnickcom/tcpdf/include/tcpdf_images.php',
        'TCPDF_IMPORT' => __DIR__ . '/..' . '/tecnickcom/tcpdf/tcpdf_import.php',
        'TCPDF_PARSER' => __DIR__ . '/..' . '/tecnickcom/tcpdf/tcpdf_parser.php',
        'TCPDF_STATIC' => __DIR__ . '/..' . '/tecnickcom/tcpdf/include/tcpdf_static.php',
        'TimeTools' => __DIR__ . '/../..' . '/icore/iassets/classes/TimeTools.php',
        'Tx\\Mailer' => __DIR__ . '/..' . '/txthinking/mailer/src/Mailer.php',
        'Tx\\Mailer\\Exceptions\\CodeException' => __DIR__ . '/..' . '/txthinking/mailer/src/Mailer/Exceptions/CodeException.php',
        'Tx\\Mailer\\Exceptions\\CryptoException' => __DIR__ . '/..' . '/txthinking/mailer/src/Mailer/Exceptions/CryptoException.php',
        'Tx\\Mailer\\Exceptions\\SMTPException' => __DIR__ . '/..' . '/txthinking/mailer/src/Mailer/Exceptions/SMTPException.php',
        'Tx\\Mailer\\Exceptions\\SendException' => __DIR__ . '/..' . '/txthinking/mailer/src/Mailer/Exceptions/SendException.php',
        'Tx\\Mailer\\Message' => __DIR__ . '/..' . '/txthinking/mailer/src/Mailer/Message.php',
        'Tx\\Mailer\\SMTP' => __DIR__ . '/..' . '/txthinking/mailer/src/Mailer/SMTP.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit13b00999f3a21499952f46dee59739a9::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit13b00999f3a21499952f46dee59739a9::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit13b00999f3a21499952f46dee59739a9::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit13b00999f3a21499952f46dee59739a9::$classMap;

        }, null, ClassLoader::class);
    }
}
