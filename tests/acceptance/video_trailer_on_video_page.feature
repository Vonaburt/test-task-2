Feature: Video trailer on video page

  Scenario: video trailer for video search results is correctly work on mouse move
    Given I am on video page

    When Page is loaded during "30" seconds
    And I search video "ураган"
    Then I see search results form


    When I move mouse on any of the first "5" found video
    Then I see video trailer for the found video during "3" seconds