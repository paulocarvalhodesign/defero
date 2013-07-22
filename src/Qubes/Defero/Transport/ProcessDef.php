<?php
/**
 * @author  brooke.bryan
 */

namespace Qubes\Defero\Transport;

class ProcessDef implements IProcessDef
{
  protected $_class;
  protected $_queueName;
  protected $_queueService;
  protected $_configuration = [];

  public function setConfiguration($config)
  {
    $this->_configuration = $config;
    return $this;
  }

  public function addConfigItem($name, $value = null)
  {
    $this->_configuration[$name] = $value;
    return $this;
  }

  /**
   * Keyed array of configuration items
   *
   * @return array
   */
  public function getConfiguration()
  {
    return $this->_configuration;
  }

  /**
   * Retrieve a single configuration item
   *
   * @param string $key     configuration key for item
   * @param null   $default Default value if config item not available
   *
   * @return mixed config value or default
   */
  public function getConfigValue($key, $default = null)
  {
    if(isset($this->_configuration[$key]))
    {
      return $this->_configuration[$key];
    }
    else
    {
      return $default;
    }
  }

  /**
   * Returns class responsible for processing
   *
   * @return string
   */
  public function getProcessClass()
  {
    return $this->_class;
  }

  /**
   * @param $class
   *
   * @return $this
   */
  public function setProcessClass($class)
  {
    $this->_class = $class;
    return $this;
  }

  public function setQueueName($name)
  {
    $this->_queueName = $name;
    return $this;
  }

  public function getQueueName()
  {
    return $this->_queueName;
  }

  public function setQueueService($name)
  {
    $this->_queueService = $name;
    return $this;
  }

  public function getQueueService()
  {
    return $this->_queueService;
  }
}
