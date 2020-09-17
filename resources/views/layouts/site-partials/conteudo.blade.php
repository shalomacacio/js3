	<!-- Start Blog Single -->
  <section class="blog-single section">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-12">
          <div class="blog-single-main">
            <div class="row">
              <div class="col-12">
                <div class="embed-responsive embed-responsive-16by9">
                  <iframe class="embed-responsive-item" src="{{ $empreendimento->url_video }}" allowfullscreen></iframe>
                </div>

                <div class="blog-detail">
                  <h2 class="blog-title">{{ $empreendimento->nome_fantasia}}</h2>
                  <div class="blog-meta">
                    <span class="author">
                      <a href="#"><i class="fa fa-calendar"></i>Aprovação: {{ $empreendimento->dt_aprovacao}}</a>
                      <a href="#"><i class="fa fa-book"></i>CNPJ: {{ $empreendimento->cnpj}}</a>
                    </span>
                  </div>

                  <div class="content">
                    <p>{{ $empreendimento->texto_descritivo}}.</p>
                    @isset($empreendimento->texto_destaque) <blockquote> <i class="fa fa-quote-left"></i> {{ $empreendimento->texto_destaque}}</blockquote>  @endisset
                  </div>
                </div>

              </div>
              <div class="col-12">
                <div class="comments">
                  <h3 class="comment-title">Commentários (3)</h3>
                  <!-- Single Comment -->
                  <div class="single-comment">
                    <img src="https://via.placeholder.com/80x80" alt="#">
                    <div class="content">
                      <h4>Alisa harm <span>At 8:59 pm On Feb 28, 2018</span></h4>
                      <p>Enthusiastically leverage existing premium quality vectors with enterprise-wide innovation collaboration Phosfluorescently leverage others enterprisee  Phosfluorescently leverage.</p>
                      <div class="button">
                        <a href="#" class="btn"><i class="fa fa-reply" aria-hidden="true"></i>Reply</a>
                      </div>
                    </div>
                  </div>
                  <!-- End Single Comment -->
                  <!-- Single Comment -->
                  <div class="single-comment left">
                    <img src="https://via.placeholder.com/80x80" alt="#">
                    <div class="content">
                      <h4>john deo <span>Feb 28, 2018 at 8:59 pm</span></h4>
                      <p>Enthusiastically leverage existing premium quality vectors with enterprise-wide innovation collaboration Phosfluorescently leverage others enterprisee  Phosfluorescently leverage.</p>
                      <div class="button">
                        <a href="#" class="btn"><i class="fa fa-reply" aria-hidden="true"></i>Reply</a>
                      </div>
                    </div>
                  </div>
                  <!-- End Single Comment -->
                  <!-- Single Comment -->
                  <div class="single-comment">
                    <img src="https://via.placeholder.com/80x80" alt="#">
                    <div class="content">
                      <h4>megan mart <span>Feb 28, 2018 at 8:59 pm</span></h4>
                      <p>Enthusiastically leverage existing premium quality vectors with enterprise-wide innovation collaboration Phosfluorescently leverage others enterprisee  Phosfluorescently leverage.</p>
                      <div class="button">
                        <a href="#" class="btn"><i class="fa fa-reply" aria-hidden="true"></i>Reply</a>
                      </div>
                    </div>
                  </div>
                  <!-- End Single Comment -->
                </div>
              </div>


              <div class="col-12">
                <div class="reply">
                  <div class="reply-head">
                    <h2 class="reply-title">Faça um Comentário</h2>
                    <!-- Comment Form -->
                    <form class="form" action="#">
                      <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                          <div class="form-group">
                            <label>Seu Nome<span>*</span></label>
                            <input type="text" name="name" placeholder="" required="required">
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                          <div class="form-group">
                            <label> Email<span>*</span></label>
                            <input type="email" name="email" placeholder="" required="required">
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="form-group">
                            <label>Menssagem<span>*</span></label>
                            <textarea name="message" placeholder=""></textarea>
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="form-group button">
                            <button type="submit" class="btn">Post comment</button>
                          </div>
                        </div>
                      </div>
                    </form>
                    <!-- End Comment Form -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-12">
          <div class="main-sidebar">
            <!-- Single Widget -->
            <div class="single-widget recent-post">
              <h3 class="title">Lotes Disponíveis</h3>
              @foreach ($empreendimento->lotes as $lote)
              <!-- Single Post -->
              <div class="single-post">
                <div class="image">
                  <img src="https://via.placeholder.com/100x100" alt="#">
                </div>
                <div class="content">
                <h5><a href="#">Lot: {{ $lote->lote}} Quad: {{ $lote->quadra}}</a></h5>
                  <ul class="comment">
                    <li><i class="fa fa-dollar" aria-hidden="true"></i>{{ $lote->valor}}</li>
                    <li><p>{{ $lote->descricao}}</p> </li>
                  </ul>
                </div>
              </div>
              <!-- End Single Post -->
              @endforeach
            </div>
            <!--/ End Single Widget -->
            <!-- Single Widget -->
            <!--/ End Single Widget -->

            <!-- Single Widget -->
            {{-- <div class="single-widget newsletter">
              <h3 class="title">Newslatter</h3>
              <div class="letter-inner">
                <h4>Subscribe & get news <br> latest updates.</h4>
                <div class="form-inner">
                  <input type="email" placeholder="Enter your email">
                  <a href="#">Submit</a>
                </div>
              </div>
            </div> --}}
            <!--/ End Single Widget -->

          </div>
        </div>
      </div>
    </div>
  </section>
  <!--/ End Blog Single -->
