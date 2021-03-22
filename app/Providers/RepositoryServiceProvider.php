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
        $this->app->bind(\App\Repositories\MkAtendimentoProcessoRepository::class, \App\Repositories\MkAtendimentoProcessoRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MkAtendimentoSubProcessoRepository::class, \App\Repositories\MkAtendimentoSubProcessoRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\FinanceiroRelatorioRepository::class, \App\Repositories\FinanceiroRelatorioRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\VendasControllerRepository::class, \App\Repositories\VendasControllerRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\GrupoPessoasRepository::class, \App\Repositories\GrupoPessoasRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\GrupoServicosRepository::class, \App\Repositories\GrupoServicosRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MkAtendimentoClassificacaoRepository::class, \App\Repositories\MkAtendimentoClassificacaoRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RadacctRepository::class, \App\Repositories\RadacctRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MkEstoqueRepository::class, \App\Repositories\MkEstoqueRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MkConexoesAcctRepository::class, \App\Repositories\MkConexoesAcctRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MkAnaliseAuthRepository::class, \App\Repositories\MkAnaliseAuthRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MkOsItensRepository::class, \App\Repositories\MkOsItensRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MkAgendaGrupoRepository::class, \App\Repositories\MkAgendaGrupoRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MkApiRepository::class, \App\Repositories\MkApiRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MkWsPerfilRepository::class, \App\Repositories\MkWsPerfilRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MkPlanoAcessoRepository::class, \App\Repositories\MkPlanoAcessoRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MkCidadeRepository::class, \App\Repositories\MkCidadeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MkMovimentacaoCaixaRepository::class, \App\Repositories\MkMovimentacaoCaixaRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MkMovimentacaoBancariaRepository::class, \App\Repositories\MkMovimentacaoBancariaRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MkFaturaRepository::class, \App\Repositories\MkFaturaRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MkContaRepository::class, \App\Repositories\MkContaRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\MkPlanoContaRepository::class, \App\Repositories\MkPlanoContaRepositoryEloquent::class);
        //:end-bindings:
    }
}
