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

class ComposeMessage implements IWizardStep
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
    return "Compose Message";
  }

  public function getDescription()
  {
    return "Compose Message";
  }

  /**
   * @return array
   */
  public function getRoutePatterns()
  {
    return ["/compose-message/(.*)",];
  }

  /**
   * @return string
   */
  public function getBaseUri()
  {
    return "/compose-message";
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
