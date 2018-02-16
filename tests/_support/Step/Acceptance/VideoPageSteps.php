<?php
/**
 * Created by PhpStorm.
 * User: Vadim
 * Date: 16.02.2018
 */

namespace Step\Acceptance;

use AcceptanceTester;
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
     * @Then I see video trailer for the found video during :arg1 seconds
     * @param $timeout
     */
    public function iSeeVideoTrailerForTheFoundVideoDuringSeconds($timeout)
    {

        $currentVideoTrailerImage = $this->I->grabAttributeFrom(VideoPage::getFoundVideoPreviewImgByIndex($this->rand_index), "src");

        while ($timeout / 2 > 0) {
            $this->I->wait(2);

            $updatedVideoTrailerImage = $this->I->grabAttributeFrom(VideoPage::getFoundVideoPreviewImgByIndex($this->rand_index), "src");
            $this->I->assertNotEquals($currentVideoTrailerImage, $updatedVideoTrailerImage);

            $currentVideoTrailerImage = $updatedVideoTrailerImage;
            $timeout--;
        }
    }
}