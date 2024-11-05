@extends('app')


@section('title', 'Tableau de Bord')

@section('content')



    <div class="pagetitle">
        <h1>Tableau de bord</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">accueil</a></li>
                <li class="breadcrumb-item active">Tableau de bord</li>
            </ol>
        </nav>
        <h1 class="card-title"><i class="bi bi-graph-up"></i> Statistiques</h1>

    </div>



    <div class="row">
        <div class="col-md-3">
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
       
        <div class="col-md-3">
            <div class="card info-card sales-card" style="height: 150px; overflow: hidden;">
                <div class="card-body">
                    <h5 class="card-title">Produit<span></span></h5>

                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-box"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{$countproducts}}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card info-card sales-card" style="height: 150px; overflow: hidden;">
                <div class="card-body">
                    <h5 class="card-title">Total vente<span></span></h5>

                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-cash"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{number_format($countTotalVente, thousands_separator: " ")}} Fcfa</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      
        <div class="col-md-3">
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
   
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"> <i class="bi bi-clipboard"></i>Nombre de Vente par jour</h5>

                    <!-- Bar Chart -->
                    <canvas id="barChartB" style="max-height: 400px;"></canvas>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Récupération des données du backend (ventes par jour)
                    var venteDates = @json($dates);
                    var venteTotals = @json($totals);
            
                    // Création du graphe à barres pour le nombre de ventes par jour
                    var ctxB = document.getElementById('barChartB').getContext('2d');
                    var barChartB = new Chart(ctxB, {
                        type: 'bar',
                        data: {
                            labels: venteDates, // Dates des ventes
                            datasets: [{
                                label: 'Nombre de ventes',
                                data: venteTotals, // Nombre total de ventes par jour
                                backgroundColor: 'rgba(54, 162, 235, 0.7)', // Couleur de chaque barre
                                borderColor: 'rgba(54, 162, 235, 1)', // Couleur des bordures
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true // L'axe Y commence à 0
                                }
                            }
                        }
                    });
                });
            </script>
            
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-archive"></i> Produits en Stock</h5>
                    <!-- Bar Chart -->
                    <canvas id="barChartA" style="max-height: 400px;"></canvas>
                </div>
            </div>
        </div>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Récupération des données du backend (produits)
                var productNames = @json($products->pluck('name'));
                var stockQuantities = @json($products->pluck('stock_quantity'));
        
                // Fonction pour générer des couleurs aléatoires
                function getRandomColor() {
                    var r = Math.floor(Math.random() * 255);
                    var g = Math.floor(Math.random() * 255);
                    var b = Math.floor(Math.random() * 255);
                    return 'rgba(' + r + ',' + g + ',' + b + ', 0.7)'; // Couleur avec transparence
                }
        
                // Générer des couleurs aléatoires pour chaque produit
                var backgroundColors = productNames.map(function() {
                    return getRandomColor();
                });
        
                var borderColors = backgroundColors.map(function(color) {
                    return color.replace('0.7', '1'); // Pour rendre les bordures plus opaques
                });
        
                // Création du graphe à barres
                var ctx = document.getElementById('barChartA').getContext('2d');
                var barChartA = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: productNames, // Nom des produits
                        datasets: [{
                            label: 'Quantité en stock',
                            data: stockQuantities, // Quantité en stock pour chaque produit
                            backgroundColor: backgroundColors, // Couleurs aléatoires pour chaque barre
                            borderColor: borderColors, // Couleurs de bordure
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true // L'axe Y commence à 0
                            }
                        }
                    }
                });
            });
        </script>
        
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-exclamation-triangle-fill text-warning"></i> Alerte de stock</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nom du Produit</th>
                                <th>Quantité en Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lowStockProducts as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td><span class="text-danger font-weight-600">{{ $product->stock_quantity }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if($lowStockProducts->isEmpty())
                        <p>Aucun produit avec un stock inférieur ou égal à 50.</p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Produits les plus vendus</h6>
                    <!-- Pie Chart -->
                    <canvas id="pieChartTopSelling" style="max-height: 400px;"></canvas>
                </div>
            </div>
        </div>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Récupération des données du backend (produits les plus vendus)
                var topSellingProductNames = @json($topSellingProducts->pluck('name'));
                var topSellingQuantities = @json($topSellingProducts->pluck('total_sales'));
        
                // Création du Pie Chart
                var ctx = document.getElementById('pieChartTopSelling').getContext('2d');
                var pieChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: topSellingProductNames, // Nom des produits
                        datasets: [{
                            label: 'Quantité vendue',
                            data: topSellingQuantities, // Quantité vendue pour chaque produit
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.7)',
                                'rgba(54, 162, 235, 0.7)',
                                'rgba(255, 206, 86, 0.7)',
                                'rgba(75, 192, 192, 0.7)',
                                'rgba(153, 102, 255, 0.7)',
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                        },
                    }
                });
            });
        </script>
        
    </div>
@endsection

