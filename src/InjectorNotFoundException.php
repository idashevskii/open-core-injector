<?php declare(strict_types=1);

namespace OpenCore;

use RuntimeException;
use Psr\Container\NotFoundExceptionInterface;

class InjectorNotFoundException extends RuntimeException implements NotFoundExceptionInterface {}
