<?php

class IPanelViewUnity
{
    private $PanelName;
    private $BrandName;
    private $FullAddressFavicon;
    private $PanelDirection;
    private $PanelLanguage;
    private $PanelMainStyleName;
    private $PanelTitle;

    public function __construct($PanelName, $BrandName, $FullAddressFavicon, $PanelDirection, $PanelLanguage, $PanelMainStyleName, $PanelTitle)
    {
        $this->PanelName = $PanelName;
        $this->BrandName = $BrandName;
        $this->FullAddressFavicon = $FullAddressFavicon;
        $this->PanelDirection = $PanelDirection;
        $this->PanelLanguage = $PanelLanguage;
        $this->PanelMainStyleName = $PanelMainStyleName;
        $this->PanelTitle = $PanelTitle;

    }

    public function tagHtmlPart()
    {
        return '<html lang="' . $this->PanelLanguage . '" dir="' . $this->PanelDirection . '">';
    }

    public function tagTitlePart()
    {
        $strTilePart = '<title>' . $this->PanelTitle . '</title>';
        $strTilePart .= '<meta name="author" content="Mehdi Imeni"/>';
        return $strTilePart;
    }

    public function tagFavicon( $ThemeColor, $TileColor)
    {
        $strFavicon = '<link rel="apple-touch-icon" sizes="57x57" href="' . $this->FullAddressFavicon .  'apple-icon-57x57.png">';
        $strFavicon .= '<link rel="apple-touch-icon" sizes="60x60" href="' . $this->FullAddressFavicon .  'apple-icon-60x60.png">';
        $strFavicon .= '<link rel="apple-touch-icon" sizes="72x72" href="' . $this->FullAddressFavicon .  'apple-icon-72x72.png">';
        $strFavicon .= '<link rel="apple-touch-icon" sizes="76x76" href="' . $this->FullAddressFavicon .  'apple-icon-76x76.png">';
        $strFavicon .= '<link rel="apple-touch-icon" sizes="114x114" href="' . $this->FullAddressFavicon . 'apple-icon-114x114.png">';
        $strFavicon .= '<link rel="apple-touch-icon" sizes="120x120" href="' . $this->FullAddressFavicon . 'apple-icon-120x120.png">';
        $strFavicon .= '<link rel="apple-touch-icon" sizes="144x144" href="' . $this->FullAddressFavicon . 'apple-icon-144x144.png">';
        $strFavicon .= '<link rel="apple-touch-icon" sizes="152x152" href="' . $this->FullAddressFavicon . 'apple-icon-152x152.png">';
        $strFavicon .= '<link rel="apple-touch-icon" sizes="180x180" href="' . $this->FullAddressFavicon . 'apple-icon-180x180.png">';
        $strFavicon .= '<link rel="icon" type="image/png" sizes="192x192"  href="' . $this->FullAddressFavicon . 'android-icon-192x192.png">';
        $strFavicon .= '<link rel="icon" type="image/png" sizes="32x32" href="' . $this->FullAddressFavicon . 'favicon-32x32.png">';
        $strFavicon .= '<link rel="icon" type="image/png" sizes="96x96" href="' . $this->FullAddressFavicon . 'favicon-96x96.png">';
        $strFavicon .= '<link rel="icon" type="image/png" sizes="16x16" href="' . $this->FullAddressFavicon . 'favicon-16x16.png">';
        $strFavicon .= '<link rel="manifest" href="' . $this->FullAddressFavicon . 'manifest.ijson">';
        $strFavicon .= '<meta name="msapplication-TileColor" content="' . $TileColor . '">';
        $strFavicon .= '<meta name="msapplication-TileImage" content="' . $this->FullAddressFavicon . 'ms-icon-144x144.png">';
        $strFavicon .= '<meta name="theme-color" content="' . $ThemeColor . '">';
        return $strFavicon;
    }
}
