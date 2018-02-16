<?php
/**
 * Created by PhpStorm.
 * User: Vadim
 * Date: 16.02.2018
 */

namespace Pages;

class VideoPage
{
    public static $url = "/video";

    public static $searchField = "input[type='search']";
    public static $searchButton = "button[type='submit']";

    public static $searchResultsDiv = "div.page-layout_page_search";

    public static function getFoundVideoPreviewImgByIndex($index)
    {
        return "div.serp-list_type_search div:nth-child(" . $index . ") img";
    }
}