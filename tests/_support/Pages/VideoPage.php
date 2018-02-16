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

    public static $searchField = "input.input__control[type='search']";
    public static $searchButton = "button[type='submit']";

    public static $searchResultsDiv = "div.page-layout_page_search";

    public static function getFoundVideoPreviewImgByIndex($index)
    {
        return "div.serp-item[role=listitem]:nth-child(" . $index . ") img";
    }
}