<?php

namespace App;

use Closure;
use DirectoryIterator;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionObject;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\AbstractConfigurator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader as ContainerPhpFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symfony\Component\Routing\Loader\PhpFileLoader as RoutingPhpFileLoader;
use Symfony\Component\Routing\RouteCollection;
use function dirname;
use function is_array;

class Kernel extends BaseKernel
{
	
	protected array $configs = [];
	
	/** Подключаем имеющиеся конфиги проекта */
	private function configureContainer(ContainerConfigurator $container) : void
	{
		$configDir = $this->getConfigDir();
		$projectDir = $this->getProjectDir();
		
		$container->import($configDir.'/{packages}/*.php');
		$container->import($configDir.'/{packages}/'.$this->environment.'/*.php');
		$container->import($configDir.'/services.php');
		
		$configs = [];
		
		if(is_dir($this->getProjectDir().'/src/'))
		{
			$srcConfigs = $this->searchResources($projectDir.'/src/');
			
			if($srcConfigs)
			{
				$configs = array_merge($configs, $srcConfigs);
			}
		}
		
		if($configs)
		{
			foreach($configs as $module)
			{
				foreach(new DirectoryIterator($module) as $config)
				{
					
					if($config->isDot())
					{
						continue;
					}
					
					/* Подключаем все конфиги, кроме routes.php */
					if($config->isFile() && $config->getFilename() !== 'routes.php')
					{
						$container->import($config->getPathname());
					}
				}
			}
		}
	}
	
	/** Подключаем имеющиеся роуты проекта */
	private function configureRoutes(RoutingConfigurator $routes) : void
	{
		$configDir = $this->getConfigDir();
		$projectDir = $this->getProjectDir();
		
		$routes->import($configDir.'/{routes}/'.$this->environment.'/*.php');
		$routes->import($configDir.'/{routes}/*.php');
		
		$configs = [];
		
		if(is_dir($this->getProjectDir().'/src/'))
		{
			$srcConfigs = $this->searchResources($projectDir.'/src/');
			
			if($srcConfigs)
			{
				$configs = array_merge($configs, $srcConfigs);
			}
		}
		
		/* Подключаем роуты BaksDev */
		if(is_dir($this->getProjectDir().'/vendor/baks-dev/'))
		{
			$vendorConfigs = $this->searchResources($projectDir.'/vendor/baks-dev/');
			
			if($vendorConfigs)
			{
				$configs = array_merge($configs, $vendorConfigs);
			}
		}
		
		if($configs)
		{
			foreach($configs as $module)
			{
				$route = $module.'/routes.php';
				
				if(is_file($route))
				{
					$routes->import($route);
				}
			}
		}
	}
	
	
	/**
	 * Метод рекурсивно сканирует директории в поиске папки /Resources/config
	 */
	public function searchResources(string $path) : ?array
	{
		$configs = null;
		
		foreach(new DirectoryIterator($path) as $module)
		{
			if($module->isDot() || !$module->isDir())
			{
				continue;
			}
			
			if(is_dir($module->getRealPath().'/Resources/config'))
			{
				$configs[] = $module->getRealPath().'/Resources/config';
				continue;
			}
			
			$config = self::searchResources($module->getRealPath());
			
			if($config !== null)
			{
				$configs = $configs ? array_merge($configs, $config) : $config;
			}
			
		}
		
		return $configs;
	}
	
	/** Метод получает путь к каталогу конфигурации */
	private function getConfigDir() : string
	{
		return $this->getProjectDir().'/config';
	}
	
	/** Получает путь к файлу конфигурации пакетов */
	private function getBundlesPath() : string
	{
		return $this->getConfigDir().'/bundles.php';
	}
	
	/** Получает путь к директории кеша  */
	public function getCacheDir() : string
	{
		if(isset($_SERVER['APP_CACHE_DIR']))
		{
			return $_SERVER['APP_CACHE_DIR'].'/'.$this->environment;
		}
		
		return parent::getCacheDir();
	}
	
	/** Получает путь к директории логов  */
	public function getLogDir() : string
	{
		return $_SERVER['APP_LOG_DIR'] ?? parent::getLogDir();
	}
	
	/** Регистрирует пакеты (бандлы), указанные в файле конфигурации пакетов  bundles.php */
	public function registerBundles() : iterable
	{
		$contents = require $this->getBundlesPath();
		
		foreach($contents as $class => $envs)
		{
			if($envs[$this->environment] ?? $envs['all'] ?? false)
			{
				yield new $class();
			}
		}
	}
	
	
	public function registerContainerConfiguration(LoaderInterface $loader) : void
	{
		$loader->load(function(ContainerBuilder $container) use ($loader){
			$container->loadFromExtension('framework', [
				'router' => [
					'resource' => 'kernel::loadRoutes',
					'type' => 'service',
				],
			]);
			
			$kernelClass = false !== strpos(static::class, "@anonymous\0") ? parent::class : static::class;
			
			if(!$container->hasDefinition('kernel'))
			{
				$container->register('kernel', $kernelClass)->addTag('controller.service_arguments')->setAutoconfigured(
					true
				)->setSynthetic(true)->setPublic(true);
			}
			
			$kernelDefinition = $container->getDefinition('kernel');
			$kernelDefinition->addTag('routing.route_loader');
			
			$container->addObjectResource($this);
			$container->fileExists($this->getBundlesPath());
			
			$configureContainer = new ReflectionMethod($this, 'configureContainer');
			$configuratorClass = $configureContainer->getNumberOfParameters(
			) > 0 && ($type = $configureContainer->getParameters()[0]->getType(
			)) instanceof ReflectionNamedType && !$type->isBuiltin() ? $type->getName() : null;
			
			if($configuratorClass && !is_a(ContainerConfigurator::class, $configuratorClass, true))
			{
				$configureContainer->getClosure($this)($container, $loader);
				
				return;
			}
			
			$file = (new ReflectionObject($this))->getFileName();
			/* @var ContainerPhpFileLoader $kernelLoader */
			$kernelLoader = $loader->getResolver()->resolve($file);
			$kernelLoader->setCurrentDir(dirname($file));
			$var = Closure::bind(function &(){
				return $this->instanceof;
			}, $kernelLoader, $kernelLoader)();
			$instanceof = $var;
			
			$valuePreProcessor = AbstractConfigurator::$valuePreProcessor;
			AbstractConfigurator::$valuePreProcessor = function($value){
				return $this === $value ? new Reference('kernel') : $value;
			};
			
			try
			{
				$configureContainer->getClosure($this)(
					new ContainerConfigurator(
						$container, $kernelLoader, $instanceof, $file, $file, $this->getEnvironment()
					),
					$loader,
					$container
				);
			}
			finally
			{
				$instanceof = [];
				$kernelLoader->registerAliasesForSinglyImplementedInterfaces();
				AbstractConfigurator::$valuePreProcessor = $valuePreProcessor;
			}
			
			$container->setAlias($kernelClass, 'kernel')->setPublic(true);
		});
	}
	
	/**
	 * @internal
	 */
	public function loadRoutes(LoaderInterface $loader) : RouteCollection
	{
		$file = (new ReflectionObject($this))->getFileName();
		/* @var RoutingPhpFileLoader $kernelLoader */
		$kernelLoader = $loader->getResolver()->resolve($file, 'php');
		$kernelLoader->setCurrentDir(dirname($file));
		
		$collection = new RouteCollection();
		
		$configureRoutes = new ReflectionMethod($this, 'configureRoutes');
		$configureRoutes->getClosure($this)(
			new RoutingConfigurator(
				$collection, $kernelLoader, $file, $file, $this->getEnvironment()
			)
		);
		
		foreach($collection as $route)
		{
			$controller = $route->getDefault('_controller');
			
			if(is_array($controller) && [0, 1] === array_keys($controller) && $this === $controller[0])
			{
				$route->setDefault('_controller', ['kernel', $controller[1]]);
			}
		}
		
		return $collection;
	}
	
	protected function build(ContainerBuilder $container) : void
	{
		//$container->registerForAutoconfiguration(GameObserverInterface::class)
		//  ->addTag('game.observer');
	}
	
	public function boot(): void
	{
		parent::boot();
		date_default_timezone_set($this->getContainer()->getParameter('timezone'));
	}
}
