@extends('opticien.app')


@section('title', 'Tableau de Bord')

@section('content')



    <div class="pagetitle">
        <h1>Tableau de bord</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">accueil</a></li>
                <li class="breadcrumb-item active">Opticien</li>
            </ol>
        </nav>
        <h1 class="card-title"><i class="bi bi-graph-up"></i> Statistiques</h1>

    </div>



    <div class="row">
        <div class="col-md-6">
            <div class="card info-card sales-card" style="height: 150px; overflow: hidden;">
                <div class="card-body">
                    <h5 class="card-title">Client <span></span></h5>

                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-person"></i>
                        </div>
                        <div class="ps-3">
                         <h6>{{$clients}}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
        <div class="col-md-6">
            <div class="card info-card sales-card" style="height: 150px; overflow: hidden;">
                <div class="card-body">
                    <h5 class="card-title">Prescription<span></span></h5>

                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-journal-check"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{$countPrescription}}</h6>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@endsection

