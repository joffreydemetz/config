<?php 
/**
 * (c) Joffrey Demetz <joffrey.demetz@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace JDZ\Utils;

/**
 * Config
 * 
 * @author Joffrey Demetz <joffrey.demetz@gmail.com>
 */
class Config implements ConfigInterface
{
  /**
   * Config data
   *
   * @var    object
   */
  protected $data;
  
  /**
   * Constructor
   *
   * @param  array  $properties  Key/Value pairs of properties
   */
  public function __construct(array $properties=[])
  {
    $this->data = [];
    
    if ( $properties ){
      $this->setProperties($properties);
    }
  }
  
  /**
   * Set a registry value
   *
   * @param  array  $properties  Key/Value pairs of properties
   * @return $this  
   */
  public function setProperties(array $properties=[])
  {
    foreach($properties as $key => $value){
      $this->set($key, $value);
    }
    return $this;
  }
  
  /**
   * Set a registry value
   *
   * @param  string  $path     Property path
   * @param  mixed   $value  Value of entry
   * @return mixed   The value of the that has been set
   */
  public function set($path, $value)
  {
    if ( $nodes = explode('.', $path) ){
      $node =& $this->data;
      
      for($i=0, $n=count($nodes)-1; $i<$n; $i++){
        if ( !isset($node[$nodes[$i]]) ){
          $node[$nodes[$i]] = [];
        }
        $node =& $node[$nodes[$i]];
      }
      
      $node[$nodes[$i]] = $value;
    }
    else {
      $node[$path] = $value;
    }
    
    return $this;
  }
  
  /**
   * Get a registry value
   *
   * @param  string  $path     Property path
   * @param  mixed   $default  Optional default value, returned if the internal value is null
   * @return mixed   Value of entry or null
   */
  public function get($path, $default=null)
  {
    $result = null;
    
    $node = $this->data;
    
    if ( strpos($path, '.') ){
      $nodes = explode('.', $path);
      
      for($i=0, $n=count($nodes)-1; $i<$n; $i++){
        if ( !isset($node[$nodes[$i]]) ){
          $node = null;
          break;
        }
        
        $node = $node[$nodes[$i]];
      }
      
      if ( $node && isset($node[$nodes[$i]]) ){
        $result = $node[$nodes[$i]];
      }
    }
    else {
      if ( isset($node[$path]) ){
        $result = $node[$path];
      }
    }
    
    if ( !$result ){
      $result = $default;
    }
    
    return $result;
  }
  
  /**
   * Sets a default value if not already assigned
   *
   * @param  string  $path     Property path
   * @param  string  $default  An optional value for the parameter
   * @return string  The value set, or the default if the value was not previously set (or null)
   */
  public function def($path, $default='')
  {
    $value = $this->get($path, (string) $default);
    $this->set($path, $value);
    return $this;
  }
  
  /**
   * Check if a property exists
   *
   * @param  string  $path  Property path
   * @return bool
   */
  public function has($path)
  {
    $node = $this->data;
    
    if ( strpos($path, '.') ){
      $nodes = explode('.', $path);
      
      for($i=0, $n=count($nodes)-1; $i<$n; $i++){
        if ( !isset($node[$nodes[$i]]) ){
          $node = null;
          break;
        }
        
        $node = $node[$nodes[$i]];
      }
      
      if ( $node && isset($node[$nodes[$i]]) ){
        return true;
      }
    }
    else {
      if ( isset($node[$path]) ){
        return true;
      }
    }
    
    return false;
  }
  
  /**
   * Clears a property
   *
   * @param  string  $path  Property path
   * @return $this
   */
  public function erase($key)
  {
    $node = $this->data;
    
    if ( strpos($path, '.') ){
      $nodes = explode('.', $path);
      
      for($i=0, $n=count($nodes)-1; $i<$n; $i++){
        if ( !isset($node[$nodes[$i]]) ){
          $node = null;
          break;
        }
        
        $node = $node[$nodes[$i]];
      }
      
      if ( $node && isset($node[$nodes[$i]]) ){
        unset($node[$nodes[$i]]);
      }
    }
    else {
      if ( isset($node[$path]) ){
        unset($node[$path]);
      }
    }
    
    return $this;
  }
  
  public function all()
  {
    return $this->data;
  }
  
  
  // deprecated
  
  public function exists($path)
  {
    return $this->has($path);
  }
  
  public function getProperties()
  {
    return $this->all();
  }
}
