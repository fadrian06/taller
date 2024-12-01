<?php

namespace SMD;

use Illuminate\Container\Container;

final class App extends Container
{
  function terminating(): void {}

  function getNamespace(): string
  {
    return __NAMESPACE__;
  }
}
