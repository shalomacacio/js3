	<!-- Header -->
	<header class="header shop ">
		<div class="custom-middle-inner">
			<div class="container">
				<div class="row">
					<div class="col-lg-2 col-md-2 col-12">
						<!-- Logo -->
						<div class="logo">
							<a href="{{route('site.home')}}"><img src="{{asset('site/images/logo.png')}}" alt="logo"></a>
						</div>
						<!--/ End Logo -->
						<!-- Search Form -->
						<div class="search-top">
							<div class="top-search"><a href="#0"><i class="ti-search"></i></a></div>
							<!-- Search Form -->
							<div class="search-top">
								<form class="search-form">
									<input type="text" placeholder="Search here..." name="search">
									<button value="search" type="submit"><i class="ti-search"></i></button>
								</form>
							</div>
							<!--/ End Search Form -->
						</div>
						<!--/ End Search Form -->
						<div class="mobile-nav"></div>
					</div>
					<div class="col-lg-8 col-md-7 col-12">
						<div class="search-bar-top">
							<div class="search-bar">
								<select>
									<option selected="selected">All Category</option>
									<option>watch</option>
									<option>mobile</option>
									<option>kid’s item</option>
								</select>
								<div class="nice-select" tabindex="0"><span class="current">All Category</span><ul class="list"><li data-value="All Category" class="option focus selected">All Category</li><li data-value="watch" class="option">watch</li><li data-value="mobile" class="option">mobile</li><li data-value="kid’s item" class="option">kid’s item</li></ul></div>
								<form>
									<input name="search" placeholder="Search Products Here....." type="search">
									<button class="btnn"><i class="ti-search"></i></button>
								</form>
							</div>
						</div>
          </div>

          <div class="col-lg-2 col-md-2 col-12">
            <div class="right-bar">
                <ul class="list-main">
                    {{-- <li><i class="ti-alarm-clock"></i>Ofertas</li> --}}
                    <li><i class="ti-headphone-alt"></i><a href="{{route('site.contato')}}">Central de Vendas</a></li>
                </ul>
            </div>
          </div>

				</div>
			</div>
		</div>
		@include('layouts.site-partials.menu')
	</header>
	<!--/ End Header -->
