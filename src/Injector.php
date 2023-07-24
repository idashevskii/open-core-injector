<?php

declare(strict_types=1);

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
  private array $cache = [];
  private array $aliases = [];

  private function __construct() {
    
  }

  public static function create() {
    return new Injector();
  }

  private static function mapParamsToIds(string $class, \ReflectionMethod $method) {
    $ret = [];
    foreach ($method->getParameters() as $rParam) {
      /* @var $rParam \ReflectionParameter */
      $attrs = $rParam->getAttributes(Inject::class);
      if ($attrs) {
        $id = $attrs[0]->getArguments()[0];
      } else {
        $rType = $rParam->getType();
        if (!$rType) {
          throw new InjectorInvalidParamException("Can not instantiate $class: type for param $rParam not specified");
        }
        $id = (string) $rType;
      }
      $ret[] = $id;
    }
    return $ret;
  }

  public function instantiate(string $class, bool $noCache = false) {
    if ($class === self::class) {
      return $this;
    }
    if (!class_exists($class)) {
      throw new InjectorNotFoundException("Can not find class $class");
    }
    if ($noCache) {
      $rClass = new \ReflectionClass($class);
      $rConstr = $rClass->getConstructor();
      if ($rConstr) {
        $params = [];
        foreach (self::mapParamsToIds($class, $rConstr) as $id) {
          $params[] = $this->get($id);
        }
        return $rClass->newInstanceArgs($params);
      } else {
        return $rClass->newInstance();
      }
    } else {
      if (!isset($this->cache[$class])) {
        $rClass = new \ReflectionClass($class);
        $rConstr = $rClass->getConstructor();
        $paramIds = $rConstr ? self::mapParamsToIds($class, $rConstr) : null;
        $this->cache[$class] = [$rClass, $rConstr, $paramIds];
      }
      list($rClass, $rConstr, $paramIds) = $this->cache[$class];
      if ($rConstr) {
        $params = [];
        foreach ($paramIds as $id) {
          $params[] = $this->get($id);
        }
        return $rClass->newInstanceArgs($params);
      } else {
        return $rClass->newInstance();
      }
    }
  }

  public function alias(string $fromId, string $toId) {
    $this->aliases[$fromId] = $toId;
  }

  public function get(string $id) {
    if (!isset($this->map[$id])) {
      $this->map[$id] = isset($this->aliases[$id]) ?
          $this->get($this->aliases[$id]) : // recursively resolve alias
          $this->instantiate($this->aliases[$id] ?? $id, noCache: true); // no needs in cache for singletons
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
