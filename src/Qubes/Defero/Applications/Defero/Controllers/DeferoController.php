<?php
/**
 * @author gareth.evans
 */

namespace Qubes\Defero\Applications\Defero\Controllers;

use Qubes\Defero\Applications\Defero\Views\Index;

class DeferoController extends BaseDeferoController
{
  public function renderIndex()
  {
    return new Index();
  }

  public function getRoutes()
  {
    return ["(.*)" => "index",];
  }
}
