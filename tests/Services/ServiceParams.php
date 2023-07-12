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

namespace OpenCore\Services;

use OpenCore\Inject;

class ServiceParams {

  public function __construct(
      public ServiceA $serviceA,
      public ServiceB $serviceB,
      public ServiceAB $serviceAB,
      #[Inject('config1')] public string $configA,
      #[Inject('config2')] public int $configB,
  ) {
    
  }

}
