<?php declare(strict_types=1);

/**
 * @license   MIT
 *
 * @author    Ilya Dashevsky
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace OpenCore;

use Psr\Container\ContainerInterface;

final class Injector implements ContainerInterface {

  private array $map = [];

  private function __construct() {}

  public static function create() {
    return new Injector();
  }

  private function instantiate(string $class) {
    if ($class === self::class) {
      return $this;
    }
    if (!class_exists($class)) {
      throw new InjectorNotFoundException("Can not find class $class");
    }
    $rClass = new \ReflectionClass($class);
    $rConstr = $rClass->getConstructor();
    if ($rConstr) {
      $params = [];
      foreach ($rConstr->getParameters() as $rParam) {
        /* @var $rParam \ReflectionParameter */
        $attrs=$rParam->getAttributes(Inject::class);
        if($attrs){
          $id=$attrs[0]->getArguments()[0];
        }else{
          $rType = $rParam->getType();
          if (!$rType) {
            throw new InjectorInvalidParamException("Can not instantiate $class: type for param $rParam not specified");
          }
          $id=(string) $rType;
        }
        $params[] = $this->get($id);
      }
      return $rClass->newInstanceArgs($params);
    } else {
      return $rClass->newInstance();
    }
  }

  public function get(string $id) {
    if (!isset($this->map[$id])) {
      $this->map[$id] = $this->instantiate($id);
    }
    return $this->map[$id];
  }

  public function set(string $id, mixed $value) {
    $this->map[$id] = $value;
  }

  public function has(string $id): bool {
    return isset($this->map[$id]);
  }

}
