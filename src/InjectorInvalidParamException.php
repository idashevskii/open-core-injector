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

use RuntimeException;
use Psr\Container\ContainerExceptionInterface;

class InjectorInvalidParamException extends RuntimeException implements ContainerExceptionInterface {
  
}
