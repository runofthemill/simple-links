<?php
/**
 * @var $scenario \Codeception\Scenario
 */
$I = new WebGuy( $scenario );
$helper = new AcceptanceTester( $scenario );
$helper->login( 'test', 'test' );

$I->amOnPage("/wp-admin/post.php?post=2&action=edit");
$I->click("#mceu_27");

// switch to iframe
$I->waitForElementVisible( '#mceu_59-body > iframe:nth-child(1)' );
$I->executeJS( 'jQuery("iframe[tabindex=\'-1\']").attr("name", "links-form")' );

$I->switchToIframe( 'links-form' );

$I->waitForElement( "#display_links_by_category", 5 );

$I->click("#display_links_by_category");
$I->click("#display_category_title");
$I->click("#display_category_description");
$I->click("#generate" );
$I->switchToWindow();

//$I->waitForElement( '#content_ifr', 5 );

$I->switchToIframe( 'content_ifr' );
$I->waitForElementVisible( ".simple-links-category-links", 8 );

$helper->canSeeElement(".simple-links-list" );
