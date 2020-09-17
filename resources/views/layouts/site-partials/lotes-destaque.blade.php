<!-- Start Most Popular -->
<div class="product-area most-popular section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>EMPREENDIMENTOS EM DESTAQUE</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="owl-carousel popular-slider">
                  @foreach ($empreendimentosDestaque as $empreendimento)
                  <!-- Start Single Product -->
                    <div class="single-product">
                        <div class="product-img">
                            <a   href="{{ route('site.empreendimento.show', $empreendimento->empreendimento->id) }}" >
                                <img class="default-img" src="{{ url("storage/{$empreendimento->img}") }}" alt="#">
                              @isset($empreendimento->span) <span class="out-of-stock">{{ $empreendimento->span }}</span> @endisset
                            </a>
                            <div class="button-head">
                                <div class="product-action">
                                    <a data-toggle="modal" data-target="#exampleModal" title="Quick View" href="#"><i class=" ti-eye"></i><span>Quick Shop</span></a>
                                    <a title="Wishlist" href="#"><i class=" ti-heart "></i><span>Add to Wishlist</span></a>
                                    <a title="Compare" href="#"><i class="ti-bar-chart-alt"></i><span>Add to Compare</span></a>
                                </div>
                                <div class="product-action-2">
                                  <a title="Add to cart" href="{{ route('empreendimentos.show', $empreendimento->id) }} ">Saiba Mais</a>
                                </div>
                            </div>
                        </div>
                        <div class="product-content">
                            <h3><a href="product-details.html">Black Sunglass For Women</a></h3>
                            <div class="product-price">
                                <span class="old">$60.00</span>
                                <span>$50.00</span>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Product -->
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Most Popular Area -->
