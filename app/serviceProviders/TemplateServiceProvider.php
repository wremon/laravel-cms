<?php namespace Template;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class TemplateServiceProvider extends ServiceProvider {
    public function register()
    {
        $this->app['template'] = $this->app->share(function($app)
        {
            return new Template;
        });

        $this->app->booting(function()
        {
            $loader = AliasLoader::getInstance();
            $loader->alias('Template', 'Template\Facades\TemplateFacade');
        });
    }
}