@extends('adminlte::page')
@section('plugins.Sweetalert2', true)
@section('plugins.Datatables', true)

@section('title', 'Mimos da Ni - Mensagens')

@section('content_header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Mensagens</li>
        </ol>
    </nav>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">

                    <div class="card-header">
                        <h3 class="float-left">Exibição - Mensagens</h3>
                    </div>
                    <div class="card-body">
                        <table class="table" id="table">
                            <thead>
                                <th width="50px">#</th>
                                <th>De</th>
                                <th>Telefone</th>
                                <th width="200px">Ações</th>
                            </thead>
                            <tbody id="tbodyMessage">

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
                    <h5 class="modal-title" id="formModalLabel">Mensagem de: </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{-- MOSTRAR CATEGORIA --}}
                <div id="showCategoryDiv">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <p id="messageName"></p>
                                <p id="messagePhone"></p>
                                <p id="messageMsg"></p>
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

@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script>
        (() => {

            

            function populateTable(url = `{{ route('message.getAll') }}`) {
                axios.get(url).then((response) => {
                    let messages = response.data;
                    let tbodyMessage = document.querySelector('#tbodyMessage');
                    tbodyMessage.innerHTML = '';
                    if (messages.data.length > 0) {
                        messages.data.forEach(message => {
                            let tr = document.createElement('tr');
                            tr.dataset.id = message.id;
                            
                            tr.innerHTML = `
                            <td>${message.id}</td>
                            <td id="msgStatus">${message.name}</td>
                            <td>${message.phone}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-default" id="btnView">
                                    <i class="fa fa-fw fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-default" id="btnDelete">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                                <a href="http://wa.me/55${message.phone}" class="btn btn-default btn-sm" target="_blank">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </td>`;

                            if(message.status == 'unread'){
                                tr.querySelector('#msgStatus').innerHTML += ` <span class="badge badge-primary ml-1">Não lido</span>`;
                            }
                            let btnDelete = tr.querySelector('#btnDelete');
                            let btnView = tr.querySelector('#btnView');
                            

                            btnDelete.addEventListener('click', (event) => {
                                event.preventDefault();
                                btnDeleteMessage(btnDelete);
                            });
                            btnView.addEventListener('click', (event) => {
                                event.preventDefault();
                                btnViewMessage(btnView);
                            });
                            

                            tbodyMessage.appendChild(tr);
                        });

                        let pagination = document.querySelector('#pagination');
                        pagination.innerHTML = '';
                        messages.links.forEach((link, key) => {
                            let newLi = document.createElement('li');
                            newLi.classList.add('page-item');
                            newLi.innerHTML = `<button class="page-link">${link.label}</button>`;
                            

                            if (link.active == true) {
                                newLi.classList.add('disabled');
                            }
                            if (messages.current_page == 1) {
                                if (key == 0) {
                                    newLi.classList.add('disabled');
                                    newLi.innerHTML = `<button class="page-link">&laquo; Anterior</button>`;
                                }
                            }
                            if (messages.current_page == messages.last_page) {
                                if (key == (messages.links.length - 1)) {
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
                        tbodyMessage.innerHTML = `
                            <tr>
                                <td><i class="fa fa-fw fa-ban"></i></td>
                                <td colspan="2">Não existem mensagens cadastradas.</td>
                                <td class="sr-only"></td>
                            </tr>
                        `;
                    }

                }).catch((error) => {
                    console.log(error.response);
                });
            }

            function btnViewMessage(btn) {
                let tr = btn.parentNode.parentNode;
                let id = tr.dataset.id;
                let url = `{{ route('message.get', ['id' => ':id']) }}`;
                url = url.replace(':id', id);
                axios.get(url).then((response) => {
                    let message = response.data;
                    document.querySelector('#formModalLabel').innerHTML =`Exibindo mensagem de: <strong>${message.name}</strong>`;
                    document.querySelector('#messageName').innerHTML = `<p><strong>Nome:</strong> ${message.name}</p>`;
                    document.querySelector('#messagePhone').innerHTML = `<p><strong>Telefone:</strong> ${message.phone}</p>`;
                    document.querySelector('#messageMsg').innerHTML = `<p><strong>Mensagem:</strong> ${message.message}</p>`;
                    populateTable();
                    $('#formModal').modal('show');
                }).catch((error) => {
                    Swal.fire('Erro ao exibir produto', '', 'error');
                });
            }

            populateTable();

        })()
    </script>
@stop
