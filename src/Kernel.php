<?php

namespace Skeleton;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\RouteCollectionBuilder;
use Symfony\Component\Yaml\Yaml;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    private const CONFIG_EXTS = '.{php,xml,yaml,yml}';

    public function registerBundles(): iterable
    {
        $contents = require $this->getProjectDir() . '/config/bundles.php';
        foreach ($contents as $class => $envs) {
            if ($envs[$this->environment] ?? $envs['all'] ?? false) {
                yield new $class();
            }
        }
    }

    public function getProjectDir(): string
    {
        return \dirname(__DIR__);
    }

    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
    {
        $container->addResource(new FileResource($this->getProjectDir() . '/config/bundles.php'));
        $container->setParameter('container.dumper.inline_class_loader', true);
        $confDir = $this->getProjectDir() . '/config';

        $loader->load($confDir . '/{packages}/*' . self::CONFIG_EXTS, 'glob');
        $loader->load($confDir . '/{packages}/' . $this->environment . '/**/*' . self::CONFIG_EXTS, 'glob');
        $loader->load($confDir . '/{services}' . self::CONFIG_EXTS, 'glob');
        $loader->load($confDir . '/{services}_' . $this->environment . self::CONFIG_EXTS, 'glob');

        $loader->load($this->getProjectDir() . '/src/*/Infrastructure/*/Application/{command_handlers}' . self::CONFIG_EXTS, 'glob');
        $loader->load($this->getProjectDir() . '/src/*/Infrastructure/Application/{command_handlers}' . self::CONFIG_EXTS, 'glob');
        $loader->load($this->getProjectDir() . '/src/*/Infrastructure/*/Application/{query_handlers}' . self::CONFIG_EXTS, 'glob');
        $loader->load($this->getProjectDir() . '/src/*/Infrastructure/Application/{query_handlers}' . self::CONFIG_EXTS, 'glob');

        $loader->load($this->getProjectDir() . '/src/*/Infrastructure/*/Domain/Service/{services}' . self::CONFIG_EXTS, 'glob');
        $loader->load($this->getProjectDir() . '/src/*/Infrastructure/Domain/Service/{services}' . self::CONFIG_EXTS, 'glob');

        $loader->load($this->getProjectDir() . '/src/*/Infrastructure/*/UI/Messaging/Consumers/{consumers}' . self::CONFIG_EXTS, 'glob');
        $loader->load($this->getProjectDir() . '/src/*/Infrastructure/UI/Messaging/Consumers/{consumers}' . self::CONFIG_EXTS, 'glob');

        $loader->load($this->getProjectDir() . '/src/*/Infrastructure/*/UI/Messaging/Subscribers/{subscribers}' . self::CONFIG_EXTS, 'glob');
        $loader->load($this->getProjectDir() . '/src/*/Infrastructure/UI/Messaging/Subscribers/{subscribers}' . self::CONFIG_EXTS, 'glob');

        if ('prod' === $this->environment || 'dev' === $this->environment) {
            $loader->load($this->getProjectDir() . '/src/*/Infrastructure/*/Domain/QueryModel/{queries}' . self::CONFIG_EXTS, 'glob');
            $loader->load($this->getProjectDir() . '/src/*/Infrastructure/Domain/QueryModel/{queries}' . self::CONFIG_EXTS, 'glob');

            $loader->load($this->getProjectDir() . '/src/*/Infrastructure/*/Persistence/{repositories}' . self::CONFIG_EXTS, 'glob');
            $loader->load($this->getProjectDir() . '/src/*/Infrastructure/Persistence/{repositories}' . self::CONFIG_EXTS, 'glob');
        }

        if ('test' === $this->environment) {
            $loader->load($this->getProjectDir() . '/src/*/Infrastructure/*/Domain/QueryModel/{queries_test}' . self::CONFIG_EXTS, 'glob');
            $loader->load($this->getProjectDir() . '/src/*/Infrastructure/Domain/QueryModel/{queries_test}' . self::CONFIG_EXTS, 'glob');

            $loader->load($this->getProjectDir() . '/src/*/Infrastructure/*/Persistence/{repositories_test}' . self::CONFIG_EXTS, 'glob');
            $loader->load($this->getProjectDir() . '/src/*/Infrastructure/Persistence/{repositories_test}' . self::CONFIG_EXTS, 'glob');
        }

        $this->loadMappingsDoctrine($container);
        $this->loadRabbitMQConfiguration($container);
    }

    protected function configureRoutes(RouteCollectionBuilder $routes): void
    {
        $confDir = $this->getProjectDir() . '/config';

        $routes->import($confDir . '/{routes}/' . $this->environment . '/**/*' . self::CONFIG_EXTS, '/', 'glob');
        $routes->import($confDir . '/{routes}/*' . self::CONFIG_EXTS, '/', 'glob');
        $routes->import($confDir . '/{routes}' . self::CONFIG_EXTS, '/', 'glob');
        $routes->import($this->getProjectDir() . '/src/*/Infrastructure/UI/*/Controller/{routing}' . self::CONFIG_EXTS, '/', 'glob');
        $routes->import($this->getProjectDir() . '/src/*/Infrastructure/*/UI/*/Controller/{routing}' . self::CONFIG_EXTS, '/', 'glob');
    }

    private function loadMappingsDoctrine(ContainerBuilder $container)
    {
        $finder = new Finder();
        $mappings = array();
        $alias = array();

        // BOUNDED CONTEXT
        $finder->directories()->in(__DIR__);
        $finder->depth('== 0');
        foreach ($finder as $dir) {
            $path = $dir->getRealpath() . '/Infrastructure';
            if (strpos($dir->getRealpath(), 'Bundle') === false && file_exists($path)) {
                $pathMapping = $path . '/Persistence/Doctrine/Mapping';
                if (file_exists($pathMapping)) {
                    list($mappings, $alias) = $this->addMappingsDirectoriesHexagonal($pathMapping, $dir, $mappings, $alias);
                }
                $finderChild = new Finder();
                $finderChild->directories()->in($path);
                $finderChild->depth('== 0');
                foreach ($finderChild as $dirChild) {
                    $pathMapping = $dirChild->getRealpath() . '/Persistence/Doctrine/Mapping';
                    if (file_exists($pathMapping)) {
                        list($mappings, $alias) = $this->addMappingsDirectoriesHexagonal($pathMapping, $dir, $mappings, $alias, $dirChild->getFilename());
                    }
                }
            }
        }

        $ormCompilerClass = 'Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass';
        if (class_exists($ormCompilerClass)) {
            $container->addCompilerPass(
                DoctrineOrmMappingsPass::createYamlMappingDriver(
                    $mappings,
                    array(),
                    false,
                    $alias
                )
            );
        }
    }

    private function addMappingsDirectoriesHexagonal(string $path, $dir, array $mappings, array $alias, ?string $prefix = null): array
    {
        $namespaceRoot = "Skeleton\\";
        $namespaceRoot .= ($prefix) ? $dir->getFilename() . '\Domain\\' . $prefix . '\Model' : $dir->getFilename() . '\Domain\Model';
        $aliasRoot = "DDD_" . $dir->getFilename();
        $mappings[$path] = $namespaceRoot;
        $alias[$aliasRoot] = $namespaceRoot;
        // SUBDIRECTORIES
        $finderAux = new Finder();
        $finderAux->directories()->in($path);
        foreach ($finderAux as $dirAux) {
            $pathDir = $dirAux->getRealpath();
            $subdir = substr(
                $dirAux->getRealpath(),
                strlen($path),
                (strlen($pathDir) - strlen($path))
            );
            $namespace = $namespaceRoot;
            if ($subdir !== '') {
                $namespace .= $subdir;
                $namespace = str_replace('/', '\\', $namespace);
            }
            $mappings[$pathDir] = $namespace;
        }
        return array($mappings, $alias);
    }

    private function loadRabbitMQConfiguration(ContainerBuilder $container): void
    {
        $finder = new Finder();
        $finder->directories()->in(__DIR__);
        $finder->depth('== 0');

        foreach ($finder as $dir) {
            $path = $dir->getRealpath().'/Infrastructure';
            if (strpos($path, 'Bundle') === false && file_exists($path)) {

                $pathMapping = $path.'/UI/Messaging';
                if (file_exists($pathMapping . '/rabbitmq.yaml')) {
                    $serializer = Yaml::parse(file_get_contents($pathMapping . '/rabbitmq.yaml'));
                    $container->prependExtensionConfig('old_sound_rabbit_mq', $serializer['old_sound_rabbit_mq']);
                }


                $finder = new Finder();
                $finder->directories()->in(__DIR__ . '/*/');
                $finder->depth('== 0');

                foreach ($finder as $dir) {
                    $path = $dir->getRealpath();
                    $parsePath = explode("/", $path);
                    if (strpos($path, 'Bundle') === false && end($parsePath) === "Infrastructure") {

                        $finderChild = new Finder();
                        $finderChild->directories()->in($path);
                        $finderChild->depth('== 0');

                        foreach ($finderChild as $dirChild) {
                            $pathMapping = $dirChild->getRealpath().'/UI/Messaging';
                            if (file_exists($pathMapping . '/rabbitmq.yaml')) {
                                $serializer = Yaml::parse(file_get_contents($pathMapping . '/rabbitmq.yaml'));
                                $container->prependExtensionConfig('old_sound_rabbit_mq', $serializer['old_sound_rabbit_mq']);
                            }
                        }
                    }
                }

            }
        }
    }
}
