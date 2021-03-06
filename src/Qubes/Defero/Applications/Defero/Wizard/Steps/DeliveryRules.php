<?php
/**
 * @author gareth.evans
 */

namespace Qubes\Defero\Applications\Defero\Wizard\Steps;

use Cubex\Core\Application\IController;
use Cubex\Core\Http\Request;
use Cubex\Core\Http\Response;
use Cubex\Foundation\IRenderable;
use Cubex\View\Impart;
use Qubes\Defero\Applications\Defero\Wizard\IWizardStep;
use Qubes\Defero\Applications\Defero\Wizard\IWizardStepIterator;

class DeliveryRules implements IWizardStep
{
  /**
   * If the process has request data dependencies use this method to ensure
   * they're available. If they're not, return false.
   *
   * @param array $get
   * @param array $post
   * @param array $routedData
   *
   * @return bool
   */
  public function canProcess(array $get, array $post, array $routedData)
  {
    return true;
  }

  public function getName()
  {
    return "Delivery Rules";
  }

  public function getDescription()
  {
    return "Delivery Rules";
  }

  /**
   * @return array
   */
  public function getRoutePatterns()
  {
    return ["/delivery-rules/(.*)",];
  }

  /**
   * @return string
   */
  public function getBaseUri()
  {
    return "/delivery-rules";
  }

  /**
   * @param Request             $request
   * @param Response            $response
   * @param IWizardStepIterator $steps
   * @param IController         $controller
   *
   * @return IRenderable
   */
  public function process(
    Request $request,
    Response $response,
    IWizardStepIterator $steps,
    IController $controller
  )
  {
    return new Impart($request->path());
  }
}
