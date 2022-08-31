<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <meta name="keywords" content="crochê ateliê boneco bolsa bonecos bolsas amigurumi linha lã" />
    <meta name="description" content="Vitrine Mimos da Ni" />
    <meta name="author" content="lencione.com.br" />
    <link rel="shortcut icon" href="{{ url('favicons/favicon.ico') }}" type="">

    <title> Mimos da Ni </title>

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="{{ url('css/template/bootstrap.css') }}">

    <!--owl slider stylesheet -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <!-- nice select  -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" />
    <!-- font awesome style -->
    <link href="{{ url('css/template/font-awesome.min.css') }}" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="{{ url('css/template/style.css') }}" rel="stylesheet" />
    <!-- responsive style -->
    <link href="{{ url('css/template/responsive.css') }}" rel="stylesheet" />


</head>

<body class="sub_page">

    <div class="hero_area">
        <div class="bg-box">

        </div>
        <!-- header section strats -->
        <header class="header_section">
            <div class="container">
                <nav class="navbar navbar-expand-lg custom_nav-container ">
                    <a class="navbar-brand" onclick="return 0;">
                        <img src="{{ url('/images/mimosdani.png') }}" width="50" class="d-inline-block align-top"
                            alt="">
                        <span>Mimos da Ni</span>
                    </a>
                </nav>
            </div>
        </header>
        <!-- end header section -->
    </div>

    <!-- food section -->

    <section class="food_section layout_padding">
        <div class="container">
            <div class="heading_container heading_center">
                <h2>
                    Vitrine
                </h2>
            </div>

            <ul class="filters_menu">
                <li class="active" data-filter="*">Todos</li>
                @forelse ($categories as $category)
                    <li data-filter=".{{ $category->slug }}">{{ $category->name }}</li>
                @empty
                    <li data-filter="*">N/a</li>
                @endforelse

            </ul>

            <div class="filters-content">
                <div class="row grid">
                    @forelse ($categories as $category)
                        @forelse ($category->products as $product)
                            <div class="col-sm-6 col-lg-4 all {{ $category->slug }}">
                                <div class="box">
                                    <div>
                                        <div class="img-box">
                                            <div id="carouselExampleControls" class="carousel slide"
                                                data-ride="carousel">
                                                <div class="carousel-inner">
                                                    @forelse ($product->images as $image)
                                                        <div
                                                            class="carousel-item @if ($loop->first) active @endif">
                                                            <a onclick="showImageModal(event)">
                                                                <img src="{{ url('storage/' . $image->url) }}"
                                                                    class="d-block w-100" style="object-fit: contain">
                                                            </a>

                                                        </div>
                                                    @empty
                                                    @endforelse
                                                </div>
                                                <a class="carousel-control-prev" href="#carouselExampleControls"
                                                    role="button" data-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Anterior</span>
                                                </a>
                                                <a class="carousel-control-next" href="#carouselExampleControls"
                                                    role="button" data-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Próximo</span>
                                                </a>
                                            </div>

                                        </div>
                                        <div class="detail-box">
                                            <h5>
                                                {{ $product->name }}
                                            </h5>
                                            <div class="row">
                                                <div class="col">
                                                    @if ($product->immediate == 1)
                                                        <span class="badge badge-pill badge-success float-right">
                                                            <i class="fa fa-star"></i> Pronta entrega
                                                        </span>
                                                    @endif
                                                    @if ($product->freeshipping == 1)
                                                        <span class="ml-1 badge badge-pill badge-success float-right">
                                                            <i class="fa fa-star"></i> Frete grátis
                                                        </span>
                                                    @endif
                                                </div>

                                            </div>

                                            <p>
                                                {!! nl2br(e($product->description)) !!}
                                            </p>
                                            <div class="options">
                                                <h6>
                                                    @if ($product->value / 100 == 1)
                                                    @else
                                                        R$ {{ $product->value / 100 }}
                                                        {{ $product->freeshipping ? '' : '+ frete' }}
                                                    @endif
                                                </h6>
                                                <a href="https://api.whatsapp.com/send?phone=5515974010904&text=Olá, gostei do produto {{ $product->name }} {{ $product->value / 100 == 1 ? '' : 'de R$' . $product->value / 100 }}"
                                                    target="_blank" id="whatsappclick">
                                                    <i class="fa fa-whatsapp" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                        @endforelse
                    @empty

                    @endforelse
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" id="btnCloseModal" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i></button>
                        <img src="" alt="" class="img-fluid w-100" id="imageModal">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- end food section -->

    <!-- footer section -->
    <footer class="footer_section">
        <div class="container">
            <div class="row">
                <div class="col-md-4 footer-col">
                    <div class="footer_contact">
                        <h4>
                            Contato
                        </h4>
                        <div class="contact_link_box">
                            <a href="http://wa.me/5515974010904" target="_blank">
                                <i class="fa fa-phone" aria-hidden="true"></i>
                                <span>
                                    Ligue (15) 97401-0904<br />
                                </span>
                            </a>
                            <p>
                                Faça seu orçamento sem compromisso!
                            </p>
                            <form id="formContact">
                                <div class="form-group">
                                    <label for="inputName">Nome</label>
                                    <input type="text" class="form-control form-control-sm" id="inputName"
                                        name="name" required placeholder="Digite seu nome">
                                </div>
                                <div class="form-group">
                                    <label for="inputPhone">Telefone</label>
                                    <input type="text" class="form-control form-control-sm" id="inputPhone"
                                        name="phone" required placeholder="Digite seu telefone">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mensagem</label>
                                    <textarea name="message" id="message form-control-sm" rows="3" class="form-control" required
                                        placeholder="Digite sua mensagem"></textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="fa fa-paper-plane"></i> Enviar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 footer-col">
                    <div class="footer_detail">
                        <p class="footer-logo">
                            <img src="{{ url('/images/mimosdani.png') }}" width="40" height="40"
                                class="d-inline-block align-top" alt=""> Mimos da ni
                        </p>
                        <p>
                            Crochês com amor e carinho!
                        </p>
                        <div class="footer_social">
                            <a href="https://www.facebook.com/rodanim.reginadossantos" target="_blank">
                                <i class="fa fa-facebook" aria-hidden="true"></i>
                            </a>
                            <a href="https://www.instagram.com/mimosdanii/" target="_blank">
                                <i class="fa fa-instagram" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 footer-col">
                    <h4>
                        Enviamos para todo o Brasil
                    </h4>
                </div>
            </div>
            <div class="footer-info">
                <p>
                    &copy; <span id="displayYear"></span> Todos os direitos reservados
                    <a href="https://lencione.com.br" target="_blank">Wesley Lencione</a><br><br>
                </p>
            </div>
        </div>
    </footer>
    <!-- footer section -->

    <!-- jQery -->
    <script src="{{ url('js/template/jquery-3.4.1.min.js') }}"></script>
    <!-- popper js -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <!-- bootstrap js -->
    <script src="{{ url('js/template/bootstrap.js') }}"></script>
    <!-- owl slider -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <!-- isotope js -->
    <script src="https://unpkg.com/isotope-layout@3.0.4/dist/isotope.pkgd.min.js"></script>
    <!-- nice select -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>
    {{-- AXIOS --}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- custom js -->
    <script src="{{ url('js/template/custom.js') }}"></script>
    {{-- SWEET ALERT --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- INPUTMASK --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8-beta.17/jquery.inputmask.min.js"></script>

    <script>
        (() => {
            $('document').ready(() => {
                let data = [];
                axios.post(`{{ route('site.counter') }}`, data).then((response) => {
                    console.log(response.data);
                });
                $('#inputPhone').inputmask("(99) 9 9999-9999")
            });

            btnwpp = document.querySelectorAll('#whatsappclick');

            btnwpp.forEach(btn => {
                btn.addEventListener('click', (event) => {
                    let data = [];
                    axios.post(`{{ route('site.clickCounter') }}`, data).then((response) => {
                        console.log(response.data);
                    });
                });
            });

            formContact = document.querySelector('#formContact');
            formContact.addEventListener('submit', (event) => {
                event.preventDefault();
                let data = new FormData(formContact);
                let url = `{{ route('site.contact') }}`;
                data.append('phone', $("#inputPhone").inputmask('unmaskedvalue'));
                axios.post(url, data).then((response) => {
                    Swal.fire('Mensagem enviada com sucesso!', '', 'success');
                    formContact.reset();
                })

            });
        })();
    </script>

</body>

</html>
