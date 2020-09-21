<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\App\Repositories\MkOsRepository::class, \App\Repositories\MkOsRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MkCompromissoRepository::class, \App\Repositories\MkCompromissoRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MkComissaoRepository::class, \App\Repositories\MkComissaoRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MkPessoaRepository::class, \App\Repositories\MkPessoaRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MkOsTipoRepository::class, \App\Repositories\MkOsTipoRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MkBairroRepository::class, \App\Repositories\MkBairroRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MkLogradouroRepository::class, \App\Repositories\MkLogradouroRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MkOsClassificacaoEncerramentoRepository::class, \App\Repositories\MkOsClassificacaoEncerramentoRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MkCompromissoPessoaRepository::class, \App\Repositories\MkCompromissoPessoaRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MkConexaoRepository::class, \App\Repositories\MkConexaoRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MkOsMobileAtuStatusRepository::class, \App\Repositories\MkOsMobileAtuStatusRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FrUsuarioRepository::class, \App\Repositories\FrUsuarioRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MkContratoRepository::class, \App\Repositories\MkContratoRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MkAtendimentoRepository::class, \App\Repositories\MkAtendimentoRepositoryEloquent::class);
        //:end-bindings:
    }
}
