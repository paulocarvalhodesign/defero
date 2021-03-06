<?php
/**
 * @author  brooke.bryan
 */

namespace Qubes\Defero\Cli\Campaign;

use Cubex\Cli\CliCommand;
use Cubex\FileSystem\FileSystem;
use Qubes\Defero\Components\Campaign\Enums\CampaignType;
use Qubes\Defero\Components\Campaign\Mappers\Campaign;
use Qubes\Defero\Components\Campaign\Mappers\CampaignContact;
use Qubes\Defero\Components\Contact\Mappers\Contact;

class SampleData extends CliCommand
{
  /**
   * @return int
   */
  public function execute()
  {

    /*$campaignContact = new CampaignContact();
    $campaignContact->campaignId = rand(1,9);
    $campaignContact->language = array_rand(
      ["en" => "en", "es" => "es", "de" => "de",]
    );
    $campaignContact->contactId = rand(1,9);
    $campaignContact->saveChanges();


    return 0;*/

    $contact              = new Contact();
    $contact->name        = "John Smith";
    $contact->description = "John the test monkey";
    $contact->email       = "john@example.com";
    $contact->jobTitle    = "Test Monkey";
    $contact->reference   = "johnsmith";
    $contact->signature   = '
Kind Regards

John Smith
Test Monkey
Cubex Tester
0123-456-789';
    $contact->saveChanges();

    $campaign              = new Campaign();
    $campaign->reference   = "testcampaign:" .
      FileSystem::readRandomCharacters(3);
    $campaign->name        = "Test Campaign";
    $campaign->description = "A test created with sample data";
    $campaign->active      = true;
    $campaign->contactId   = $contact->id();
    $campaign->type        = CampaignType::ACTION;
    $campaign->saveChanges();

    $message = $campaign->message();

    $message->setLanguage('en');
    $message->subject = "This is my subject";
    $message->plainText = "Hello {{name}}. how are you today?";
    $message->saveAsNew();

    $message->setLanguage('es');
    $message->subject = "Este es mi tema";
    $message->plainText = "Hola {{name}}. ¿Cómo estás hoy?";
    $message->saveAsNew();

    $message->setLanguage('de');
    $message->subject = "Dies ist mein Thema";
    $message->plainText = "Hallo {{name}}. Wie geht es Ihnen heute?";
    $message->saveAsNew();
  }
}
