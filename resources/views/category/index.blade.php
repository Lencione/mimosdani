@extends('adminlte::page')
@section('plugins.Sweetalert2', true)
@section('plugins.Datatables', true)

@section('title', 'Mimos da Ni - Categorias')

@section('content_header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Categorias</li>
        </ol>
    </nav>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">

                    <div class="card-header">
                        <h3 class="float-left">Exibição - Categorias</h3>
                        <button type="button" class="btn btn-sm btn-default float-right" id="btnNewCategory">
                            <i class="fa fa-fw fa-plus"></i> Nova categoria
                        </button>
                    </div>
                    <div class="card-body">
                        <table class="table" id="table">
                            <thead>
                                <th width="50px">#</th>
                                <th>Categoria</th>
                                <th width="200px">Ações</th>
                            </thead>
                            <tbody id="tbodyCategory">

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
            <div class="modal-content" id="newCategory">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModalLabel">Adicionar nova categoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{-- NOVA CATEGORIA --}}
                <div id="newCategoryDiv">
                    <div class="modal-body">
                        <form id="formCategory" onsubmit="return false;">
                            <input class="form-control form-control-sm" type="text" placeholder="Título da categoria"
                                id="categoryName">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
                            <i class="fa fa-fw fa-times"></i> Fechar</button>
                        <button type="button" class="btn btn-default btn-sm" id="btnSave">
                            <i class="fa fa-fw fa-save text-success"></i> Salvar</button>
                    </div>
                </div>
                {{-- MOSTRAR CATEGORIA --}}
                <div id="showCategoryDiv">
                    <div class="modal-body">
                        <table class="table table-sm">
                            <thead>
                                <th>Imagem</th>
                                <th>Produto</th>
                                <th>Preço</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Imagem 1</td>
                                    <td>Etzinho</td>
                                    <td>R$ 60,00</td>
                                </tr>
                                <tr>
                                    <td>Imagem 2</td>
                                    <td>Boneca</td>
                                    <td>R$ 80,00</td>
                                </tr>
                                <tr>
                                    <td>Imagem 3</td>
                                    <td>Bolsa</td>
                                    <td>R$ 200,00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
                            <i class="fa fa-fw fa-times"></i> Fechar
                        </button>
                    </div>
                </div>
                {{-- EDITAR CATEGORIA --}}
                <div id="editCategoryDiv">
                    <div class="modal-body">
                        <form onsubmit="return false;">
                            <div class="form-group">
                                <label for="editCategoryName">Título da categoria</label>
                                <input class="form-control form-control-sm" type="text" placeholder="Título da categoria"
                                id="editCategoryName">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
                            <i class="fa fa-fw fa-times"></i> Fechar</button>
                        <button type="button" class="btn btn-default btn-sm" id="btnUpdateCategory">
                            <i class="fa fa-fw fa-save text-success"></i> Salvar</button>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

@stop

@section('css')

@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        (() => {

            function btnDeleteCategory(btn) {
                let tr = btn.parentNode.parentNode;
                let id = tr.dataset.id;
                let url = `{{ route('category.destroy', ['id' => ':id']) }}`;
                url = url.replace(':id', id);
                Swal.fire({
                    title: 'Você deseja deletar a categoria?',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Sim',
                    denyButtonText: `Não`,
                    cancelButtonText: `Cancelar`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.delete(url).then((response) => {
                            Swal.fire('Categoria deletada com sucesso!', '', 'success');
                            populateTable();
                        }).catch((error) => {
                            Swal.fire('Erro ao deletar categoria!', '', 'error');
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Nenhuma alteração feita', '', 'info')
                    }
                })
            }

            function resetModal(){
                document.querySelector('#newCategoryDiv').classList.add('sr-only');
                document.querySelector('#showCategoryDiv').classList.add('sr-only');
                document.querySelector('#editCategoryDiv').classList.add('sr-only');
            }

            document.querySelector('#btnNewCategory').addEventListener('click', (event)=>{
                event.preventDefault();
                resetModal();
                document.querySelector('#formModalLabel').innerHTML = `Adicionar nova categoria`;
                document.querySelector('#newCategoryDiv').classList.remove('sr-only');
                $('#formModal').modal('show');
            });

            function btnViewCategory(btn) {
                let tr = btn.parentNode.parentNode;
                let id = tr.dataset.id;
                let url = `{{ route('category.show', ['id' => ':id']) }}`;
                url = url.replace(':id', id);
                axios.get(url).then((response)=>{
                    let category = response.data;
                    document.querySelector('#formModalLabel').innerHTML = `Exibindo categoria: <strong>${category.name}</strong>`;
                    resetModal();
                    document.querySelector('#showCategoryDiv').classList.remove('sr-only');
                    $('#formModal').modal('show');
                }).catch((error)=>{
                    Swal.fire('Erro ao exibir categoria', '', 'error');
                });
            }

            function btnEditCategory(btn) {
                let tr = btn.parentNode.parentNode;
                let id = tr.dataset.id;
                let url = `{{ route('category.show', ['id' => ':id']) }}`;
                url = url.replace(':id', id);
                axios.get(url).then((response)=>{
                    let category = response.data;
                    resetModal();
                    document.querySelector('#formModalLabel').innerHTML = `Editando categoria: <strong>${category.name}</strong>`;
                    document.querySelector('#editCategoryDiv').classList.remove('sr-only');
                    document.querySelector('#btnUpdateCategory').dataset.id = category.id;
                    let editCategoryName = document.querySelector('#editCategoryName');
                    editCategoryName.value = category.name;
                    $('#formModal').modal('show');
                }).catch((error)=>{
                    Swal.fire('Erro ao exibir categoria', '', 'error');
                });
            }

            function populateTable(url = `{{ route('category.getAll') }}`) {

                axios.get(url).then((response) => {
                    let categories = response.data;
                    let tbodyCategory = document.querySelector('#tbodyCategory');
                    tbodyCategory.innerHTML = '';
                    if (categories.data.length > 0) {
                        categories.data.forEach(category => {
                            let tr = document.createElement('tr');
                            tr.dataset.id = category.id;
                            tr.innerHTML = `<td>${category.id}</td><td>${category.name}</td>
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
                            </td>`;
                            let btnDelete = tr.querySelector('#btnDelete');
                            let btnView = tr.querySelector('#btnView');
                            let btnEdit = tr.querySelector('#btnEdit');

                            btnDelete.addEventListener('click', (event) => {
                                event.preventDefault();
                                btnDeleteCategory(btnDelete);
                            });
                            btnView.addEventListener('click', (event) => {
                                event.preventDefault();
                                btnViewCategory(btnView);
                            });
                            btnEdit.addEventListener('click', (event) => {
                                event.preventDefault();
                                btnEditCategory(btnEdit);
                            });

                            tbodyCategory.appendChild(tr);
                        });
                        let pagination = document.querySelector('#pagination');
                        pagination.innerHTML = '';
                        categories.links.forEach((link, key) => {
                            let newLi = document.createElement('li');
                            newLi.classList.add('page-item');

                            
                            newLi.innerHTML = `<button class="page-link">${link.label}</button>`;
                            

                            if (link.active == true) {
                                newLi.classList.add('disabled');
                            }
                            if (categories.current_page == 1) {
                                if (key == 0) {
                                    newLi.classList.add('disabled');
                                    newLi.innerHTML = `<button class="page-link">&laquo; Anterior</button>`;
                                }
                            }
                            if (categories.current_page == categories.last_page) {
                                if (key == (categories.links.length - 1)) {
                                    newLi.classList.add('disabled');
                                    newLi.innerHTML = `<button class="page-link">Próximo &raquo;</button>`;
                                }
                            }

                            newLi.querySelector('button').addEventListener('click', (e) => {
                                e.preventDefault();
                                populateTable(link.url);
                            });
                            pagination.appendChild(newLi);
                        });
                    } else {
                        tbodyCategory.innerHTML = `
                            <tr>
                                <td><i class="fa fa-fw fa-ban"></i></td>
                                <td colspan="2">Não existem categorias cadastradas.</td>
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
                let url = `{{ route('category.store') }}`;
                let categoryName = document.querySelector('#categoryName');
                if (categoryName.value == '' || categoryName.value == null) {
                    Swal.fire('Digite um nome para a categoria!', '', 'error');
                } else {
                    axios.post(url, {
                        name: `${categoryName.value}`,
                    }).then((response) => {
                        Swal.fire('Categoria adicionada com sucesso!', '', 'success');
                        populateTable();
                        $('#formModal').modal('hide');
                        categoryName.value = '';
                    }).catch((error) => {
                        Swal.fire('Já existe uma categoria com esse título!', 'Digite outra', 'error');
                    });
                }
            });

            let btnUpdate = document.querySelector('#btnUpdateCategory');
            btnUpdate.addEventListener('click', (e) => {
                e.preventDefault();
                let id = btnUpdate.dataset.id;
                let url = `{{ route('category.update', ['id' => ':id']) }}`;
                let categoryName = document.querySelector('#editCategoryName');

                url = url.replace(':id', id);
                if (categoryName.value == '' || categoryName.value == null) {
                    Swal.fire('Digite um nome para a categoria!', '', 'error');
                } else {
                    axios.put(url, {
                        name: `${categoryName.value}`,
                    }).then((response) => {
                        Swal.fire('Categoria alterada com sucesso!', '', 'success');
                        populateTable();
                        $('#formModal').modal('hide');
                        categoryName.value = '';
                    }).catch((error) => {
                        Swal.fire('Já existe uma categoria com esse título!', 'Digite outra', 'error');
                    });
                }
            });

        })()
    </script>
@stop
