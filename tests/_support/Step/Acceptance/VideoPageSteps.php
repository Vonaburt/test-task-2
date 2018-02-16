<?php
/**
 * Created by PhpStorm.
 * User: Vadim
 * Date: 16.02.2018
 */

namespace Step\Acceptance;

use AcceptanceTester;
use Facebook\WebDriver\WebDriverElement;
use Pages\VideoPage;

class VideoPageSteps
{

    protected $I;

    function __construct(AcceptanceTester $I)
    {
        $this->I = $I;
    }

    private $rand_index = null;

    /**
     * @Given I am on video page
     */
    public function iAmOnVideoPage()
    {
        $this->I->amOnPage(VideoPage::$url);
        $this->I->maximizeWindow();
    }


    /**
     * @When Page is loaded during :arg1 seconds
     * @param $timeout
     */

    public function pageIsLoadedDuringSeconds($timeout)
    {
        $this->I->waitForJS("return document.readyState == 'complete'", $timeout);
    }

    /**
     * @When I search video :arg1
     * @param $videoName
     * @throws \Exception
     */
    public function iSearchVideo($videoName)
    {
        $this->I->waitForElementVisible(VideoPage::$searchField);
        $this->I->fillField(VideoPage::$searchField, $videoName);
        $this->I->click(VideoPage::$searchButton);
    }

    /**
     * @Then I see search results form
     * @throws \Exception
     */
    public function iSeeSearchResultsForm()
    {
        $this->I->waitForElementVisible(VideoPage::$searchResultsDiv, 30);
    }


    /**
     * @When I move mouse on any of the first :arg1 found video
     * @param $random_range
     */
    public function iMoveMouseOnFoundRandomVideo($random_range)
    {
        $this->rand_index = rand(1, $random_range);
        $this->I->moveMouseOver(VideoPage::getFoundVideoPreviewImgByIndex($this->rand_index));
    }


    /**
     * @Then I see video trailer image change :arg1 times with an interval of less than :arg2 seconds
     * @param $changes_count
     * @param $image_change_timeout
     */
    public function iSeeVideoTrailerImageChangeTimesWithAnIntervalOfLessThanSeconds($changes_count, $image_change_timeout)
    {
        $this->waitTrailerImagesChanges(VideoPage::getFoundVideoPreviewImgByIndex($this->rand_index), $changes_count, $image_change_timeout);
    }

    /**
     * Функция, позволяющая проверить работу трейлера видео
     *
     * Для переданного элемента $element выполняется число проверок, равное $changes_count.
     * В каждой проверке выполняется функция waitForElementChange, ожидающая в течении времени $image_change_timeout
     * изменение атрибута "src".
     *
     * Пример: при $changes_count = 3 и $image_change_timeout = 1, будет проверено, что атрибут src (картинка) изменится
     * 3 раза, причем каждое изменение должно происходить не более чем за 1 секунду
     *
     * @param $element
     * @param $changes_count
     * @param $image_change_timeout
     */
    private function waitTrailerImagesChanges($element, $changes_count, $image_change_timeout)
    {

        while ($changes_count > 0) {

            $current_src_attribute_value = $this->I->grabAttributeFrom($element, "src");

            $this->I->waitForElementChange(VideoPage::getFoundVideoPreviewImgByIndex($this->rand_index),
                function (WebDriverElement $el) use ($current_src_attribute_value, $changes_count) {
                    $updated_src_attribute_value = $el->getAttribute("src");
                    print_r("\nupdated src attribute value: " . $updated_src_attribute_value);

                    if ($current_src_attribute_value !== $updated_src_attribute_value) {
                        print_r("\ntrailer image was changed!\nold value: " . $current_src_attribute_value
                            . "\nnew value: " . $updated_src_attribute_value . "\n");
                        return true;
                    }

                    print_r("\ntrailer remains the same");
                    return false;
                }, $image_change_timeout);

            $changes_count--;
        }
    }
}