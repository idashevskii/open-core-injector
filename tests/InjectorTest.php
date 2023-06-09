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

use PHPUnit\Framework\TestCase;
use OpenCore\Services\{
  InvalidParamService,
  NoConstructorService,
  ServiceA,
  ServiceB,
  ServiceAB,
  ServiceParams,
};

final class InjectorTest extends TestCase {

  private Injector $injector;

  protected function setUp(): void {
    $this->injector = Injector::create();
  }

  public function testInjectServiceWithInvalidParam() {
    $this->expectException(InjectorInvalidParamException::class);
    $this->injector->get(InvalidParamService::class);
  }

  public function testNotFoundClass() {
    $this->expectException(InjectorNotFoundException::class);
    $this->injector->get('Not\Existsing\Class');
  }

  public function testInjectService() {

    $service = $this->injector->get(ServiceA::class);

    $this->assertInstanceOf(ServiceA::class, $service);
  }

  public function testInjectInjector() {

    $injector = $this->injector->get(Injector::class);

    $this->assertTrue($injector === $this->injector);
  }

  public function testNoConstructorService() {
    $service = $this->injector->get(NoConstructorService::class);

    $this->assertInstanceOf(NoConstructorService::class, $service);
  }

  public function testSingletones() {

    $serviceA = $this->injector->get(ServiceA::class);
    $serviceB = $this->injector->get(ServiceB::class);
    $serviceAB = $this->injector->get(ServiceAB::class);

    $this->assertInstanceOf(ServiceA::class, $serviceA);
    $this->assertInstanceOf(ServiceB::class, $serviceB);
    $this->assertInstanceOf(ServiceAB::class, $serviceAB);

    $this->assertTrue($serviceA === $serviceAB->serviceA);
    $this->assertTrue($serviceB === $serviceAB->serviceB);
  }

  public function testSettingArbitraryObject() {
    $service = new NoConstructorService();
    $id = 'my-service';
    $this->injector->set($id, $service);

    $this->assertTrue($service === $this->injector->get($id));
  }

  public function testInjectScalars() {
    $config1 = 'str';
    $config2 = 1023;
    $this->injector->set('config1', $config1);
    $this->injector->set('config2', $config2);

    $service = $this->injector->get(ServiceParams::class);

    $this->assertTrue($service->configA === $config1);
    $this->assertTrue($service->configB === $config2);
  }

  public function testInjectMissingScalars() {
    $this->expectException(InjectorNotFoundException::class);
    $config1 = 'str';
    $this->injector->set('config1', $config1);
    $this->injector->get(ServiceParams::class);
  }

}
