@extends('adminlte::page')
@section('plugins.Sweetalert2', true)
@section('plugins.Datatables', true)

@section('title', 'Mimos da Ni - Produtos')

@section('content_header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Produtos</li>
        </ol>
    </nav>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">

                    <div class="card-header">
                        <h3 class="float-left">Exibição - Produtos</h3>
                        <button type="button" class="btn btn-sm btn-default float-right" id="btnNewProduct">
                            <i class="fa fa-fw fa-plus"></i> Novo Produto
                        </button>
                    </div>
                    <div class="card-body">
                        <table class="table" id="table">
                            <thead>
                                <th width="50px">#</th>
                                <th>Produto</th>
                                <th>Categorias</th>
                                <th width="200px">Ações</th>
                            </thead>
                            <tbody id="tbodyProduct">

                            </tbody>
                        </table>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination" id="pagination">
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="newProduct">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModalLabel">Adicionar novo produto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{-- NOVO PRODUTO --}}
                <div id="newProductDiv">
                    <div class="modal-body">
                        <form id="formProduct" onsubmit="return false;">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="gridCheck" name="immediate">
                                            <label class="form-check-label" for="gridCheck">
                                                Pronta entrega
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="gridCheck" name="freeshipping">
                                            <label class="form-check-label" for="gridCheck">
                                                Frete grátis
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">

                                    <div class="form-group">
                                        <label for="productName">Título do Produto</label>
                                        <input type="text" name="name" class="form-control form-control-sm"
                                            id="productName" placeholder="Título do produto" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="productValue">Preço</label>
                                        <input type="text" name="value" class="form-control form-control-sm"
                                            id="productValue" placeholder="Preço do produto - R$ 1,00 para não exibir"
                                            required>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-12">
                                            <span><strong>Categorias</strong></span>
                                        </div>

                                        @forelse ($categories as $category)
                                            <div class="col-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="cat{{ $category->id }}" name="category[]"
                                                        value="{{ $category->id }}">
                                                    <label class="form-check-label" for="cat{{ $category->id }}">
                                                        {{ $category->name }}
                                                    </label>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-12">
                                                Não existem categorias cadastradas!
                                            </div>
                                        @endforelse
                                    </div>

                                    <div class="form-group">
                                        <label for="productDescription">Descrição</label>
                                        <textarea class="form-control" name="description" id="productDescription" rows="5" required></textarea>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
                            <i class="fa fa-fw fa-times"></i> Fechar</button>
                        <button type="button" class="btn btn-default btn-sm" id="btnSave">
                            <i class="fa fa-fw fa-save text-success"></i> Salvar</button>
                    </div>
                </div>
                {{-- MOSTRAR PRODUTO --}}
                <div id="showProductDiv">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col">
                                        <h2 id="showProductName"></h2>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <h3>Categorias</h3>
                                        <p id="showCategoriesProduct"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <h3>Descrição</h3>
                                        <p id="showDescriptionProduct"></p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
                            <i class="fa fa-fw fa-times"></i> Fechar
                        </button>
                    </div>
                </div>
                {{-- EDITAR PRODUTO --}}
                <div id="editProductDiv">
                    <div class="modal-body">
                        <form onsubmit="return false;" id="editProductForm">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="editImmediate"
                                                name="immediate">
                                            <label class="form-check-label" for="editImmediate">
                                                Pronta entrega
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="editFreeshipping"
                                                name="freeshipping">
                                            <label class="form-check-label" for="editFreeshipping">
                                                Frete grátis
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">

                                    <div class="form-group">
                                        <label for="editProductName">Título do Produto</label>
                                        <input type="text" name="name" class="form-control form-control-sm"
                                            id="editProductName" placeholder="Título do produto" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="editProductValue">Preço</label>
                                        <input type="text" name="value" class="form-control form-control-sm"
                                            id="editProductValue" placeholder="Preço do produto - R$ 1,00 para não exibir"
                                            required>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-12">
                                            <span><strong>Categorias</strong></span>
                                        </div>

                                        @forelse ($categories as $category)
                                            <div class="col-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="edtCat{{ $category->id }}" name="category[]"
                                                        value="{{ $category->id }}">
                                                    <label class="form-check-label" for="edtCat{{ $category->id }}">
                                                        {{ $category->name }}
                                                    </label>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-12">
                                                Não existem categorias cadastradas!
                                            </div>
                                        @endforelse
                                    </div>

                                    <div class="form-group">
                                        <label for="editProductDescription">Descrição</label>
                                        <textarea class="form-control" name="description" id="editProductDescription" rows="5" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
                            <i class="fa fa-fw fa-times"></i> Fechar</button>
                        <button type="button" class="btn btn-default btn-sm" id="btnUpdateProduct">
                            <i class="fa fa-fw fa-save text-success"></i> Salvar</button>
                    </div>
                </div>
                {{-- UPLOADS IMAGES --}}
                <div id="imagesProductDiv">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner" id="carouselPhotos">
                                        <div class="carousel-item active">
                                            <img src="{{ url('/storage' . '/products/6THWa3bxutCw9NxjfBjDl094Cccs9LfNTK9kpRKW.png') }}"
                                                class="d-block w-100" alt="...">
                                        </div>
                                    </div>
                                    <button class="carousel-control-prev" type="button"
                                        data-target="#carouselExampleControls" data-slide="prev">
                                        <span class="carousel-control-prev-icon text-dark" aria-hidden="true">
                                            <i class="fa fa-fw fa-chevron-left"></i>
                                        </span>
                                        <span class="sr-only">Anterior</span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                        data-target="#carouselExampleControls" data-slide="next">
                                        <span class="carousel-control-next-icon text-dark" aria-hidden="true">
                                            <i class="fa fa-fw fa-chevron-right"></i>
                                        </span>
                                        <span class="sr-only">Próximo</span>
                                    </button>
                                </div>
                            </div>
                            <div class="col-6">
                                <table class="table table-sm table-borderless">
                                    <thead class="sr-only">
                                        <th>Imagem</th>
                                        <th>Opções</th>
                                    </thead>
                                    <tbody id="tbodyImages">
                                        <tr>
                                            <td></td>
                                            <td>Botões</td>
                                        </tr>
                                        <tr>
                                            <td>Imagem 2</td>
                                            <td>Botões</td>
                                        </tr>
                                        <tr>
                                            <td>Imagem 3</td>
                                            <td>Botões</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-12 mt-4">
                                <form id="formUploadImages">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="addonInputImage">Fotos do produto</span>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="inputUploadImage"
                                                aria-describedby="addonInputImage" multiple name="image[]">
                                            <label class="custom-file-label" for="inputUploadImage">Escolher
                                                foto(s)</label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <button class="btn btn-sm btn-default" type="submit">
                                            <i class="fa fa-fw fa-save"></i> Carregar foto(s)
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
                            <i class="fa fa-fw fa-times"></i> Fechar
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

@stop

@section('css')
    <style>
        .carousel-item img {
            max-width: 100%;
            min-width: 100%;
            max-height: 300px;
            min-height: 300px;
            object-fit: contain;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8-beta.17/jquery.inputmask.min.js"></script>
    <script>
        (() => {

            $(document).ready(function() {
                bsCustomFileInput.init()
                $("#productValue").inputmask('currency', {
                    autoUnmask: true,
                    radixPoint: ",",
                    groupSeparator: ".",
                    allowMinus: false,
                    prefix: 'R$ ',
                    digits: 2,
                    digitsOptional: false,
                    rightAlign: false,
                    unmaskAsNumber: true,
                    removeMaskOnSubmit: true
                });

                $("#editProductValue").inputmask('currency', {
                    autoUnmask: true,
                    radixPoint: ",",
                    groupSeparator: ".",
                    allowMinus: false,
                    prefix: 'R$ ',
                    digits: 2,
                    digitsOptional: false,
                    rightAlign: false,
                    unmaskAsNumber: true,
                    removeMaskOnSubmit: true
                });
            })

            function btnDeleteProduct(btn) {
                let tr = btn.parentNode.parentNode;
                let id = tr.dataset.id;
                let url = `{{ route('product.destroy', ['id' => ':id']) }}`;
                url = url.replace(':id', id);
                Swal.fire({
                    title: 'Você deseja deletar o produto?',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Sim',
                    denyButtonText: `Não`,
                    cancelButtonText: `Cancelar`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.delete(url).then((response) => {
                            Swal.fire('Produto deletada com sucesso!', '', 'success');
                            populateTable();
                        }).catch((error) => {
                            Swal.fire('Erro ao deletar produto!', '', 'error');
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Nenhuma alteração feita', '', 'info')
                    }
                })
            }

            function resetModal() {
                document.querySelector('#newProductDiv').classList.add('sr-only');
                document.querySelector('#showProductDiv').classList.add('sr-only');
                document.querySelector('#editProductDiv').classList.add('sr-only');
                document.querySelector('#imagesProductDiv').classList.add('sr-only');
            }

            document.querySelector('#btnNewProduct').addEventListener('click', (event) => {
                event.preventDefault();
                resetModal();
                document.querySelector('#formModalLabel').innerHTML = `Adicionar novo produto`;
                document.querySelector('#newProductDiv').classList.remove('sr-only');
                $('#formModal').modal('show');
            });

            function btnViewProduct(btn) {
                let tr = btn.parentNode.parentNode;
                let id = tr.dataset.id;
                let url = `{{ route('product.show', ['id' => ':id']) }}`;
                url = url.replace(':id', id);
                axios.get(url).then((response) => {
                    let product = response.data;
                    document.querySelector('#formModalLabel').innerHTML =
                        `Exibindo produto: <strong>${product.name}</strong>`;
                    document.querySelector('#showProductName').innerHTML =
                        `Produto: ${product.name} - R$ ${product.value/100}`;
                    document.querySelector('#showCategoriesProduct').innerHTML = '';
                    product.categories.forEach((category) => {
                        document.querySelector('#showCategoriesProduct').innerHTML +=
                            `<span class="badge badge-primary mr-1">${category.name}</span>`;
                    })
                    document.querySelector('#showDescriptionProduct').innerHTML = product.description;
                    resetModal();
                    document.querySelector('#showProductDiv').classList.remove('sr-only');
                    $('#formModal').modal('show');
                }).catch((error) => {
                    Swal.fire('Erro ao exibir produto', '', 'error');
                });
            }

            function populatePhotos(photos) {
                let carousel = document.querySelector('#carouselPhotos');
                carousel.innerHTML = '';

                let tbodyImages = document.querySelector('#tbodyImages');
                tbodyImages.innerHTML = '';

                photos.forEach((photo, key) => {
                    let newDiv = document.createElement('div');
                    newDiv.classList.add('carousel-item');
                    if (key == 0) {
                        newDiv.classList.add('active');
                    }
                    let imgProduct = document.createElement('img');
                    imgProduct.src = `{{ url('storage/${photo.url}') }}`;
                    imgProduct.classList.add('d-block');
                    imgProduct.classList.add('w-100');

                    let newTr = document.createElement('tr');
                    newTr.innerHTML = `
                        <td>Foto ${key+1}</td>
                        <td>
                            <a href="{{ url('storage/${photo.url}') }}" target="_blank" class="btn btn-default btn-sm"><i class="fa fa-fw fa-eye"></i></a>    
                            <button class="btn btn-default btn-sm" data-id="${photo.id}" id="btnDeleteImage">
                                <i class="fa fa-fw fa-times"></i>
                            </button>    
                        </td>
                    `;
                    let btn = newTr.querySelector('#btnDeleteImage');
                    btnDeleteImage(btn);
                    tbodyImages.appendChild(newTr);
                    newDiv.appendChild(imgProduct);
                    carousel.appendChild(newDiv);
                });
            }

            function btnDeleteImage(btn) {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    let pid = btn.parentNode.parentNode.parentNode.dataset.id;
                    let id = btn.dataset.id;
                    let url = `{{ route('product.images.destroy', ['id' => ':pid', 'image' => ':id']) }}`;
                    url = url.replace(':pid', pid);
                    url = url.replace(':id', id);

                    Swal.fire({
                        title: 'Deletar foto?',
                        text: "Você tem certeza que deseja deletar a foto?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sim!',
                        confirmButtonColor: '#d33',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios.delete(url).then((response) => {
                                let photos = response.data;
                                populatePhotos(photos);
                                Swal.fire('Foto deletada com sucesso!', '', 'success');
                            }).catch((error) => {
                                Swal.fire('Algo deu errado!', '', 'error');
                            })
                        }
                    })



                });
            }

            function btnPhotoProduct(btn) {
                let tr = btn.parentNode.parentNode;
                let id = tr.dataset.id;
                let url = `{{ route('product.images.getAll', ['id' => ':id']) }}`;
                url = url.replace(':id', id);
                let formUploadImages = document.querySelector('#formUploadImages');
                formUploadImages.dataset.id = id;
                axios.get(url).then((response) => {
                    let photos = response.data;
                    resetModal();
                    populatePhotos(photos);

                    let tbody = document.querySelector('#tbodyImages');
                    tbody.dataset.id = id;
                    document.querySelector('#imagesProductDiv').classList.remove('sr-only');
                    $('#formModal').modal('show');
                }).catch((error) => {
                    console.log(error.response);
                });
            }

            let formUploadImages = document.querySelector('#formUploadImages');
            formUploadImages.addEventListener('submit', (e) => {
                e.preventDefault();
                let formData = new FormData(formUploadImages);
                let id = formUploadImages.dataset.id;
                let url = `{{ route('product.images.upload', ['id' => ':id']) }}`;
                url = url.replace(':id', id);

                Swal.fire('Carregando fotos!', '', 'info');

                axios.post(url, formData, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                }).then((response) => {
                    let photos = response.data;
                    populatePhotos(photos);
                    Swal.fire('Foto(s) carregadas com sucesso!', '', 'success');

                }).catch((error) => {
                    console.log(error)
                });
            })




            function btnEditProduct(btn) {
                let tr = btn.parentNode.parentNode;
                let id = tr.dataset.id;
                let url = `{{ route('product.show', ['id' => ':id']) }}`;
                url = url.replace(':id', id);
                axios.get(url).then((response) => {
                    let product = response.data;
                    resetModal();
                    document.querySelector('#editProductDiv').classList.remove('sr-only');
                    document.querySelector('#formModalLabel').innerHTML =
                        `Editando produto: <strong>${product.name}</strong>`;
                    document.querySelector('#btnUpdateProduct').dataset.id = product.id;
                    document.querySelector('#editProductName').value = product.name;
                    document.querySelector('#editProductValue').value = product.value / 100;
                    document.querySelector(`#editProductDescription`).value = product.description;

                    
                    if (product.immediate == 1) {
                        document.querySelector('#editImmediate').checked = true;
                    }
                    if (product.freeshipping == 1) {
                        document.querySelector('#editFreeshipping').checked = true;
                    }
                    product.categories.forEach((category) => {
                        document.querySelector(`#edtCat${category.id}`).checked = true;
                    });

                    $('#formModal').modal('show');
                }).catch((error) => {
                    console.log(error);
                    Swal.fire('Erro ao exibir produto', '', 'error');
                });
            }

            function populateTable(url = `{{ route('product.getAll') }}`) {

                axios.get(url).then((response) => {
                    let products = response.data;
                    let tbodyProduct = document.querySelector('#tbodyProduct');
                    tbodyProduct.innerHTML = '';
                    if (products.data.length > 0) {
                        products.data.forEach(product => {
                            let tr = document.createElement('tr');
                            tr.dataset.id = product.id;
                            tr.innerHTML = `<td>${product.id}</td>
                            <td>${product.name}</td>
                            <td class="categories"></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-default" id="btnEdit">
                                    <i class="fa fa-fw fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-default" id="btnView">
                                    <i class="fa fa-fw fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-default" id="btnDelete">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-default" id="btnPhoto">
                                    <i class="fa fa-fw fa-images"></i>
                                </button>
                            </td>`;
                            let tdCat = tr.querySelector('.categories');
                            let btnDelete = tr.querySelector('#btnDelete');
                            let btnView = tr.querySelector('#btnView');
                            let btnEdit = tr.querySelector('#btnEdit');
                            let btnPhoto = tr.querySelector('#btnPhoto');
                            tdCat.innerHTML = "";

                            product.categories.forEach((category) => {
                                let newBadge = document.createElement('span');
                                newBadge.classList.add('badge');
                                newBadge.classList.add('badge-primary');
                                newBadge.classList.add('mr-1');
                                newBadge.innerHTML = category.name;
                                tdCat.appendChild(newBadge);
                            });

                            btnDelete.addEventListener('click', (event) => {
                                event.preventDefault();
                                btnDeleteProduct(btnDelete);
                            });
                            btnView.addEventListener('click', (event) => {
                                event.preventDefault();
                                btnViewProduct(btnView);
                            });
                            btnEdit.addEventListener('click', (event) => {
                                event.preventDefault();
                                btnEditProduct(btnEdit);
                            });
                            btnPhoto.addEventListener('click', (event) => {
                                event.preventDefault();
                                btnPhotoProduct(btnPhoto);
                            });

                            tbodyProduct.appendChild(tr);
                        });
                        let pagination = document.querySelector('#pagination');
                        pagination.innerHTML = '';
                        products.links.forEach((link, key) => {
                            let newLi = document.createElement('li');
                            newLi.classList.add('page-item');

                            newLi.innerHTML = `<button class="page-link">${link.label}</button>`;

                            if (link.active == true) {
                                newLi.classList.add('disabled');
                            }
                            if (products.current_page == 1) {
                                if (key == 0) {
                                    newLi.classList.add('disabled');
                                    newLi.innerHTML =
                                        `<button class="page-link">&laquo; Anterior</button>`;
                                }
                            }
                            if (products.current_page == products.last_page) {
                                if (key == (products.links.length - 1)) {
                                    newLi.classList.add('disabled');
                                    newLi.innerHTML =
                                        `<button class="page-link">Próximo &raquo;</button>`;
                                }
                            }

                            newLi.querySelector('button').addEventListener('click', (e) => {
                                e.preventDefault();
                                populateTable(link.url);
                            });
                            pagination.appendChild(newLi);
                        });
                    } else {
                        tbodyProduct.innerHTML = `
                            <tr>
                                <td><i class="fa fa-fw fa-ban"></i></td>
                                <td colspan="2">Não existem produtos cadastradas.</td>
                                <td class="sr-only"></td>
                            </tr>
                        `;
                    }

                }).catch((error) => {
                    console.log(error.response);
                });
            }

            populateTable();



            let btnSave = document.querySelector('#btnSave');
            btnSave.addEventListener('click', (e) => {
                e.preventDefault();
                let url = `{{ route('product.store') }}`;
                let form = document.querySelector('#formProduct');
                let productForm = new FormData(form);

                let productName = document.querySelector('#productName');
                let productValue = document.querySelector('#productValue');
                let productDescription = document.querySelector('#productDescription');

                if (productName.value == '' || productName.value == null) {
                    Swal.fire('Digite um nome para o produto!', '', 'error');
                } else if (productValue.value == '' || productValue.value == null) {
                    Swal.fire('Digite um valor para o produto!', '', 'error');
                } else if (productDescription.value == '' || productDescription.value == null) {
                    Swal.fire('Digite uma descrição para o produto!', '', 'error');
                } else {
                    productForm.append('value', $('#productValue').inputmask('unmaskedvalue'));

                    axios.post(url, productForm).then((response) => {
                        Swal.fire('Produto adicionada com sucesso!', '', 'success');
                        populateTable();
                        $('#formModal').modal('hide');
                        productName.value = '';
                    }).catch((error) => {
                        Swal.fire('Já existe um produto com esse título!', 'Digite outro título',
                            'error');
                    });
                }
            });

            let btnUpdate = document.querySelector('#btnUpdateProduct');
            btnUpdate.addEventListener('click', (e) => {
                e.preventDefault();
                let id = btnUpdate.dataset.id;
                let url = `{{ route('product.update', ['id' => ':id']) }}`;
                url = url.replace(':id', id);
                let form = document.querySelector('#editProductForm');
                let productForm = new FormData(form);

                let productName = document.querySelector('#editProductName');
                let productValue = document.querySelector('#editProductValue');
                let productDescription = document.querySelector('#editProductDescription');

                if (productName.value == '' || productName.value == null) {
                    Swal.fire('Digite um nome para o produto!', '', 'error');
                } else if (productValue.value == '' || productValue.value == null) {
                    Swal.fire('Digite um valor para o produto!', '', 'error');
                } else if (productDescription.value == '' || productDescription.value == null) {
                    Swal.fire('Digite uma descrição para o produto!', '', 'error');
                } else {
                    productForm.append('value', $('#editProductValue').inputmask('unmaskedvalue'));
                    axios.post(url, productForm).then((response) => {
                        Swal.fire('Produto alterado com sucesso!', '', 'success');
                        populateTable();
                        $('#formModal').modal('hide');
                        productName.value = '';
                    }).catch((error) => {
                        console.log(error);
                        Swal.fire('Já existe um produto com esse título!', 'Digite outro título',
                            'error');
                    });
                }
            });

        })()
    </script>
@stop
