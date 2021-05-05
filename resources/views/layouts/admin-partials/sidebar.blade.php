<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="{{ asset('vendor/adminlte/dist/img/logo.jpg') }}" alt="logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">JSERVICES JS3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('vendor/adminlte/dist/img/profile.png') }}"  class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"> {{ Auth::user()->name }}  </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user-shield"></i>
              <p>OPERACIONAL <i class="fa fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('mkCompromissos.agenda') }}" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>AGENDA</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('atendimentos.abertos') }}" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>ATEND ABERTOS</p>
                </a>
              </li>
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link"><i class="nav-icon fas fa-circle"></i>
                    <p>SUPORTE<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                  <a href="{{ route('dash.suporte') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p> DASHBOARD </p>
                    </a>
                  </li>
                </ul>
              </li>
              {{-- <li class="nav-item has-treeview">
                <a href="#" class="nav-link"><i class="nav-icon fas fa-circle"></i>
                    <p>INSTALAÇÃO<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                  {{-- <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>AGENDA</p>
                    </a>
                  </li> 
                </ul>
              </li> 
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link"><i class="nav-icon fas fa-circle"></i>
                    <p>INFRA<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                  {{-- <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>AGENDA</p>
                    </a>
                  </li> 
                </ul>
              </li>--}}
              {{-- fim banner-prinicipal  --}}
            </ul>
          </li>
          {{-- <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-line"></i>
              <p>COMERCIAL <i class="fa fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>VENDAS DASH</p>
                </a>
              </li>
            </ul>
          </li> --}}
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-dollar-sign"></i>
              <p>FINANCEIRO <i class="fa fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('financeiro.inadimplencias')}}" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Inadimplências</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('financeiro.receitas')}}" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Receitas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('financeiro.renovacoes')}}" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Renovações</p>
                </a>
              </li>
              {{-- <li class="nav-item has-treeview">
                <a href="#" class="nav-link"><i class="nav-icon fas fa-hand-holding-usd"></i>
                    <p>COMISSÕES<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>COMISSÕES AUTORIZAR </p>
                    </a>
                  </li>
                </ul>
              </li> --}}
            </ul>
          </li> 
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-warehouse"></i>
              <p>ESTOQUE <i class="fa fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('estoque.fiscalizar')}}" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>O.S X ÍTENS</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-list-ul"></i>
              <p>RELATORIOS <i class="fa fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('relatorio.atendimentos')}}" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Atendimentos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('relatorio.contratos')}}" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Contratos</p>
                </a>
              </li>
              <li>
                <a href="{{ route('relatorio.servicos')}}" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Serviços</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('relatorio.radacct')}}" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Clientes X Nasport</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('relatorio.sla')}}" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>S.L.A</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('relatorio.slagarantia')}}" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>S.L.A GARANTIA</p>
                </a>
              </li>
              {{-- <li class="nav-item has-treeview">
                <a href="#" class="nav-link"><i class="nav-icon fas fa-hand-holding-usd"></i>
                    <p>COMISSÕES<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>COMISSÕES AUTORIZAR </p>
                    </a>
                  </li>
                </ul>
              </li> 
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
              <p>CONFIGURAÇOES <i class="fa fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
              <a href="#" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Grupo Pessoas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Grupo Serviços</p>
                </a>
              </li>
            </ul>
          </li>--}}
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
