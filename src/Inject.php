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

use Attribute;

#[Attribute(Attribute::TARGET_PARAMETER)]
final class Inject implements ContainerInterface {

  private function __construct(public string $id) {
    
  }

}
