<?php

namespace App\Tests\Controller\Contact;

use App\Factory\ContactFactory;
use App\Tests\Support\ControllerTester;

class IndexCest
{
    public function TitleIsCorrect(ControllerTester $I): void
    {
        $I->amOnPage('/contact');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle('Liste des contacts');
    }

    public function H1IsPresent(ControllerTester $I): void
    {
        $I->amOnPage('/contact');
        $I->seeResponseCodeIsSuccessful();
        $I->see('Liste des contacts', 'h1');
    }

    public function NewContactsAreListed(ControllerTester $I): void
    {
        ContactFactory::createMany(5);
        $I->amOnPage('/contact');
        $I->seeResponseCodeIsSuccessful();
        $I->seeNumberOfElements('li[class=contacts]', 5);
        $I->seeNumberOfElements('a[class=select_contact]', 5);
        $I->click('a[class=select_contact]');
        $I->seeCurrentRouteIs('app_contact_show');
    }

    public function TestClickFirstContact(ControllerTester $I): void
    {
        ContactFactory::createOne(['firstname' => 'Joe', 'lastname' => 'Aaaaaaaaaaaaaaa']);
        ContactFactory::createMany(5);
        $I->amOnPage('/contact');
        $I->click('Aaaaaaaaaaaaaaa, Joe');
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentRouteIs('app_contact_show');
    }

    public function ContactListIsSorted(ControllerTester $I): void
    {
        ContactFactory::createSequence(
            [
                ['firstname' => 'Zoé', 'lastname' => 'Zèbre'],
                ['firstname' => 'Armand', 'lastname' => 'Argent'],
                ['firstname' => 'Marie', 'lastname' => 'Database'],
                ['firstname' => 'Simon', 'lastname' => 'Belmont'],
            ]
        );
        $I->amOnPage('/contact');
        $Sample = $I->grabMultiple('span[class="lastname"], span[class="firstname"]');
        $I->assertEquals(
            ['Argent', 'Armand', 'Belmont', 'Simon', 'Database', 'Marie', 'Zèbre', 'Zoé'],
            $Sample, 'La liste n\'est pas triée dans l\'ordre alphabétique pour du lastname');
    }

    public function SearchWorks(ControllerTester $I): void
    {
        ContactFactory::createSequence(
            [
                ['firstname' => 'DN2561VD5R6', 'lastname' => 'Test'],
                ['firstname' => 'M', 'lastname' => 'Pasdinspi'],
                ['firstname' => 'Expérience', 'lastname' => 'DN2561VD5R6'],
                ['firstname' => 'Jean', 'lastname' => 'Nez-marre'],
            ]
        );
        $I->amOnPage('/contact?search=DN2561VD5R6');
        $Sample = $I->grabMultiple('span.lastname, span.firstname');
        $I->assertEquals(
            ['DN2561VD5R6', 'Expérience', 'Test', 'DN2561VD5R6'],
            $Sample, 'La liste n\'est pas triée dans l\'ordre alphabétique pour du lastname');
    }
}
