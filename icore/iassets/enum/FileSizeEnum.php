<?php

use MyCLabs\Enum\Enum;

class FileSizeEnum extends Enum
{
    private const SizeAdminProfile = array(250 * 1024 * 1024, 1024);
    private const SizeUserProfile = array(250 * 1024 * 1024, 1024);
    private const SizeLogo = array(250 * 1024 * 1024, 1600);
    private const SizeBanner = array(250 * 1080 * 1024, 1920);
    private const SizeSlider = array(250 * 1024 * 1024, 1600);
    private const SizeAttachedImage = array(250 * 1024 * 1024, 1400);
    private const SizeDownload = array(1500 * 1024 * 1024, 1600);
    private const SizeMovie = array(1500 * 1024 * 1024, 1600);
    private const SizeVRFile = array(5000 * 1024 * 1024, 1600);
    private const SizeIcon = array(250 * 1024 * 1024, 1600);
    private const ExtImage = array('jpg', 'jpeg', 'png', 'gif', 'webp');
    private const ExtMulti = array('swf');
    private const ExtSound = array('mp3', 'ogg', 'wav', 'midi', 'amr', 'wma');
    private const ExtTxt = array('txt', 'text', 'doc', 'docx', 'pdf', 'ppt', 'pptx');
    private const ExtMovie = array('mp4', 'flv', 'mpeg', 'wmv');
    private const ExtDownload = array('iso', 'tar', 'ar', 'bz2', 'gz', '7z', 'rar', 'zip', 'zipx', 'ace');
    private const ExtVRFile = array('obj', 'fbx');
    private const ExtAttached = array('gz', '7z', 'rar', 'zip', 'txt', 'text', 'doc', 'docx', 'pdf', 'ppt', 'pptx', 'mp4', 'flv', 'mpeg', 'wmv', 'jpg', 'jpeg', 'png', 'gif', 'mp3', 'ogg', 'wav', 'midi', 'amr', 'wma');

}