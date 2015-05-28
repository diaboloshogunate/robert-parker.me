<?php namespace Sonata;

use Silex\Application;
use Silex\Provider;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class Sonata extends Application
{
    use Application\MonologTrait;
    use Application\TwigTrait;
    use Application\UrlGeneratorTrait;
    use Application\TranslationTrait;
    use Application\FormTrait;
    use Application\SwiftmailerTrait;
    use Application\SecurityTrait;
    use \Silex\Route\SecurityTrait;

    public function __construct(array $values = [])
    {
        parent::__construct($values);

        $this['config_cache'] = '../var/config';

        $this['parser'] = $this->share(function(){
            return new Parser();
        });

        $this->register(new Provider\MonologServiceProvider());
        $this->register(new Provider\HttpCacheServiceProvider());
        $this->register(new Provider\SerializerServiceProvider());
        $this->register(new Provider\SessionServiceProvider());
        $this->register(new Provider\DoctrineServiceProvider());
        $this->register(new Provider\TranslationServiceProvider());
        // @TODO allow external links http://h4cc.tumblr.com/post/56874277802/generate-external-urls-from-a-symfony2-route
        $this->register(new Provider\UrlGeneratorServiceProvider());
        $this->register(new Provider\TwigServiceProvider());
        $this->register(new Provider\HttpFragmentServiceProvider());
        $this->register(new Provider\FormServiceProvider());
        $this->register(new Provider\ValidatorServiceProvider());
        $this->register(new Provider\SwiftmailerServiceProvider());
        //$this->register(new Provider\SecurityServiceProvider());
        //$this->register(new Provider\RememberMeServiceProvider());
        $this->register(new Provider\ServiceControllerServiceProvider());
        //$this->register(new Provider\WebProfilerServiceProvider());

        $this->extend('twig.loader', function(\Twig_Loader_Chain $twig_loader_chain, $app){
            if(!isset($app['twig.paths']))
            {
                return $twig_loader_chain;
            }

            $filesystem_loader = new \Twig_Loader_Filesystem();
            foreach($app['twig.paths'] as $namespace => $path)
            {
                $filesystem_loader->addPath($path, $namespace);
            }
            $twig_loader_chain->addLoader($filesystem_loader);

            return $twig_loader_chain;
        });

        $this->apply($values);
    }

    public function load($file, $cache = true)
    {
        if($cache == null)
        {
            $cache = isset($this['debug']) ? $this['debug'] : true;
        }

        if($cache)
        {
            $cache_file_name = md5($file);
            $cache_file_path = $this['config_cache'] . '/' . $cache_file_name;
            if(file_exists($cache_file_path))
            {
                $cached_contents = file_get_contents($cache_file_path);
                return unserialize($cached_contents);
            }
        }

        $contents = $this->parse($file);

        if($cache)
        {
            $cached_contents = serialize($contents);
            file_put_contents($cache_file_path, $cached_contents);
        }

        return $contents;
    }

    public function parse($file)
    {
        if(!file_exists($file))
        {
            throw new FileNotFoundException();
        }
        $contents = file_get_contents($file);
        return $this['parser']->parse($contents);
    }

    public function apply($values)
    {
        foreach($values as $setting => $value)
        {
            $this[$setting] = $value;
        }
    }
}