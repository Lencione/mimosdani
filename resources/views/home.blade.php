@extends('adminlte::page')
@section('plugins.Sweetalert2', true)

@section('title', 'Admin - Index')

@section('content_header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Informações úteis</li>
        </ol>
    </nav>
@stop

@section('content')
    <div class="col">
        <div class="card">
            <div class="card-header">
                Acessos
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ count($counter) }}</h3>
                                <p>Acessos ao site</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-fw fa-eye"></i>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ count($clicks) }}</h3>
                                <p>Cliques</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-fw fa-mouse"></i>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')

@stop
