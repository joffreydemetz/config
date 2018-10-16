<?php 
/**
 * (c) Joffrey Demetz <joffrey.demetz@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace JDZ\Utils;

/**
 * Config Interface
 * 
 * @author Joffrey Demetz <joffrey.demetz@gmail.com>
 */
interface ConfigInterface 
{
  /**
   * Set a registry value
   *
   * @param  array  $properties  Key/Value pairs of properties
   * @return $this  
   */
  public function setProperties(array $properties=[]);
  
  /**
   * Set a registry value
   *
   * @param  string  $path     Property path
   * @param  mixed   $value  Value of entry
   * @return mixed   The value of the that has been set
   */
  public function set($path, $value);
  
  /**
   * Get a registry value
   *
   * @param  string  $path     Property path
   * @param  mixed   $default  Optional default value, returned if the internal value is null
   * @return mixed   Value of entry or null
   */
  public function get($path, $default=null);
  
  /**
   * Sets a default value if not already assigned
   *
   * @param  string  $path     Property path
   * @param  string  $default  An optional value for the parameter
   * @return string  The value set, or the default if the value was not previously set (or null)
   */
  public function def($path, $default='');
  
  /**
   * Check if a property exists
   *
   * @param  string  $path     Property path
   * @return bool
   */
  public function has($path);
  
  /**
   * Clears a property
   *
   * @param  string  $path  Property path
   * @return $this
   */
  public function erase($path);
  
  public function all();
}
