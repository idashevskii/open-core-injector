<?php declare(strict_types=1);

namespace OpenCore;

use Attribute;

#[Attribute(Attribute::TARGET_PARAMETER)]
final class Inject {
  public function __construct(public string $id) {}
}
