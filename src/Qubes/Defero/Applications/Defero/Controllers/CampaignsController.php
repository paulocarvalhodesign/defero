<?php
/**
 * @author gareth.evans
 */

namespace Qubes\Defero\Applications\Defero\Controllers;

use Cubex\Data\Transportable\TransportMessage;
use Cubex\Form\Form;
use Cubex\Mapper\Database\RecordCollection;
use Cubex\Routing\Templates\ResourceTemplate;
use Cubex\Facade\Redirect;
use Cubex\Facade\Session;
use Qubes\Defero\Applications\Defero\Forms\CampaignForm;
use Qubes\Defero\Applications\Defero\Helpers\RecordCollectionPagination;
use Qubes\Defero\Applications\Defero\Views\CampaignsView;
use Qubes\Defero\Applications\Defero\Views\CampaignView;
use Qubes\Defero\Components\Campaign\Mappers\Campaign;

class CampaignsController extends BaseDeferoController
{
  /**
   * Show a blank campaign form
   *
   * @return CampaignView
   */
  public function renderNew()
  {
    return new CampaignView($this->_buildCampaignForm());
  }

  /**
   * Show a pre-populated campaign form
   *
   * @param int          $id
   * @param CampaignForm $campaignForm
   *
   * @return CampaignView
   */
  public function renderEdit($id, CampaignForm $campaignForm = null)
  {
    return new CampaignView($campaignForm ? : $this->_buildCampaignForm($id));
  }

  /**
   * Update an existing campaign
   *
   * @param int $id
   *
   * @return CampaignView
   */
  public function actionUpdate($id)
  {
    return $this->_updateCampaign($id);
  }

  /**
   * Delete a campaign
   *
   * @param int $id
   *
   * @return \Cubex\Core\Http\Redirect
   */
  public function actionDestroy($id)
  {
    $campaign = new Campaign($id);
    $campaign->forceLoad();
    $campaign->delete();

    echo "Campaign {$id} deleted";
    return Redirect::to('/campaigns')->with(
      'msg',
      new TransportMessage('info', "Campaign '{$campaign->name}' deleted.")
    );
  }

  /**
   * Output a single campaign
   *
   * @param int $id
   *
   * @return string
   */
  public function renderShow($id)
  {
    if(Session::getFlash('msg'))
    {
      echo Session::getFlash('msg');
      echo nl2br(json_pretty(new Campaign($id)));
      die;
    }

    return nl2br(json_pretty(new Campaign($id)));
  }

  /**
   * Create a new campaign
   *
   * @return CampaignView
   */
  public function postCreate()
  {
    return $this->_updateCampaign();
  }

  /**
   * Show a paginated list of campaigns
   *
   * @param int $page
   */
  public function renderIndex($page = 1)
  {
    $campaigns = new RecordCollection(new Campaign());

    $pagination = new RecordCollectionPagination(
      $campaigns, $page
    );
    $pagination->setUri("/campaigns/page");

    return new CampaignsView($campaigns, $pagination);
  }

  /**
   * Helper method to handle create and update of campaigns. Will redirect to
   * the specific campaign on success with a message. If there are any
   * validation or CSRF errors we render the form again with information.
   *
   * @param null|int $id
   *
   * @return CampaignView
   */
  private function _updateCampaign($id = null)
  {
    $form = $this->_buildCampaignForm($id);
    $form->hydrate($this->request()->postVariables());

    if($form->isValid() && $form->csrfCheck(true))
    {
      $form->saveChanges();

      Redirect::to("/campaigns/{$form->getMapper()->id()}")
        ->with("msg", "boo ya")
        ->now();
    }

    return $this->renderEdit($id, $form);
  }

  /**
   * Instantiates the form and binds the mapper. Also sets up the action based
   * on an id existing or not.
   *
   * @param null|int $id
   *
   * @return CampaignForm
   */
  private function _buildCampaignForm($id = null)
  {
    $action = $id ? "/campaigns/{$id}" : "/campaigns";

    return (new CampaignForm("campaign", $action))
      ->bindMapper(new Campaign($id));
  }

  public function getRoutes()
  {
    return ResourceTemplate::getRoutes();
  }
}
