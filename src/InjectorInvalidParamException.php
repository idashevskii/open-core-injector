<?php declare(strict_types=1);

namespace OpenCore;

use RuntimeException;
use Psr\Container\ContainerExceptionInterface;

class InjectorInvalidParamException extends RuntimeException implements ContainerExceptionInterface {}
