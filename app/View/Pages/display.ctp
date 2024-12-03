<?php echo $this->Html->css('/app-assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css', array('inline' => false)); ?>
<?php $admins = $this->Session->read('admins'); ?>
<?php $this->start('page-bar') ?>
<div class="content-header-left col-lg-6 mb-2">
    <div class="row breadcrumbs-top">
        <div class="col-12">
            <div class="breadcrumb-wrapper">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?php echo $this->Html->url('/') ?>">
                            <i class="fa fa-line-chart"></i>
                            <span class="title">Tableau de bord</span>
                        </a>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="content-header-right text-md-right col-lg-6 d-md-block d-none">
    <div class="form-group breadcrumb-right">
        <?php if ( in_array($role_id, $admins) ): ?>
            <div id="dashboard-report-range" class="pull-right btn btn-fit-height grey-salt btn-sm" data-placement="top">
                <i class="icon-calendar"></i>&nbsp;
                <span class="thin uppercase visible-lg-inline-block"> 
                    <?php echo date('d F Y', strtotime($date['start'])) . ' - ' . date('d F Y', strtotime($date['end'])) ?> 
                </span>&nbsp;
                <i class="fa fa-angle-down"></i>
            </div>
            <div class="btn-group pull-right">
                <div class="btnGroup">
                    <a class="pull-right btn btn-fit-height blue btn-sm" href="<?php echo $this->Html->url('/') ?>"> <i class="fa fa-refresh"></i> </a>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>
<?php $this->end() ?>


   


<div class="hr"></div>
<?php if ( in_array($role_id, $admins) ): ?>
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 blue" href="<?php echo $this->Html->url(['controller'=>'bonlivraisons','action'=>'index']) ?>">
            <div class="visual">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?php echo $nbr_bonlivraisons ?>"><?php echo $nbr_bonlivraisons ?></span>
                </div>
                <div class="desc"> Total des livraison(s) </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 red" href="<?php echo $this->Html->url(['controller'=>'factures','action'=>'index']) ?>">
            <div class="visual">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?php echo $nbr_factures ?>"><?php echo $nbr_factures ?></span>
                </div>
                <div class="desc"> Total des facture(s) </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 green" href="<?php echo $this->Html->url(['controller'=>'clients','action'=>'index']) ?>">
            <div class="visual">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?php echo $nbr_clients ?>"><?php echo $nbr_clients ?></span>
                </div>
                <div class="desc"> Total des client(s) </div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <a class="dashboard-stat dashboard-stat-v2 purple" href="<?php echo $this->Html->url(['controller'=>'fournisseurs','action'=>'index']) ?>">
            <div class="visual">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?php echo $nbr_fournisseurs ?>"><?php echo $nbr_fournisseurs ?></span>
                </div>
                <div class="desc"> Total des fournisseur(s) </div>
            </div>
        </a>
    </div>
</div> 

<div class="row">
    <div class="col-lg-12">
    	<h3 style="font-weight: bold;">Chiffre d'affaire</h3>
    	<div class="hr"></div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat dashboard-stat-v2 blue" >
            <div class="visual">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?php echo $ChiffreAffaireValide ?>"><?php echo number_format($ChiffreAffaireValide, 2, ',', ' ') ?> Dhs</span>
                </div>
                <div class="desc"> Chiffre d'affaire validé </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat dashboard-stat-v2 red">
            <div class="visual">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?php echo $ChiffreAffaireEnCours ?>"><?php echo number_format($ChiffreAffaireEnCours, 2, ',', ' ') ?> Dhs</span>
                </div>
                <div class="desc"> Chiffre d'affaire en cours </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat dashboard-stat-v2 green">
            <div class="visual">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?php echo $ChiffreAffaireTotal ?>"><?php echo number_format($ChiffreAffaireTotal, 2, ',', ' ') ?> Dhs</span>
                </div>
                <div class="desc"> Chiffre d'affaire total (TTC) </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat dashboard-stat-v2 purple">
            <div class="visual">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?php echo $ChiffreAffaireTotalHt ?>"><?php echo number_format($ChiffreAffaireTotalHt, 2, ',', ' ') ?> Dhs</span>
                </div>
                <div class="desc"> Chiffre d'affaire total (HT) </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
              <h4 class="card-title">Chiffre d'affaire par mois </h4>
              <div class="heading-elements">
                  <ul class="list-inline mb-0">
                    <!-- li actions -->
                  </ul>
              </div>
            </div>
            <div class="card-content collapse show">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12" id="ChiffreAffaireChart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
              <h4 class="card-title">Top 10 des clients par chiffre d'affaire </h4>
              <div class="heading-elements">
                  <ul class="list-inline mb-0">
                    <!-- li actions -->
                  </ul>
              </div>
            </div>
            <div class="card-content collapse show">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12" id="clientPie"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <h3 style="font-weight: bold;">Dépence</h3>
        <div class="hr"></div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat dashboard-stat-v2 red" >
            <div class="visual">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="details">
                <div class="number">
                    <span data-counter="counterup" data-value="<?php echo $chiffre_affaire_depence ?>"><?php echo number_format($chiffre_affaire_depence, 2, ',', ' ') ?> Dhs</span>
                </div>
                <div class="desc"> Total des dépences </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
              <h4 class="card-title">Dépence par mois </h4>
              <div class="heading-elements">
                  <ul class="list-inline mb-0">
                    <!-- li actions -->
                  </ul>
              </div>
            </div>
            <div class="card-content collapse show">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12" id="DepenceChart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
              <h4 class="card-title">Dépence par catégorie</h4>
              <div class="heading-elements">
                  <ul class="list-inline mb-0">
                    <!-- li actions -->
                  </ul>
              </div>
            </div>
            <div class="card-content collapse show">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12" id="DepencePie"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">



   






    </div>
    <div class="col-md-6">

        <div class="card">
            <div class="card-header">
              <h4 class="card-title">Produits en rupture</h4>
              <div class="heading-elements">
                  <ul class="list-inline mb-0">
                    <!-- li actions -->
                  </ul>
              </div>
            </div>
            <div class="card-content collapse show">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12" style="max-height: 350px;overflow-y: scroll;">
                            <div class="table-scrollable" style="height: 300px;">
                                <table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th nowrap="">Référence</th>
                                            <th nowrap="">Libellé</th>
                                            <th nowrap="">Stock actuel</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($produitsalerts as $dossier): ?>
                                            <tr>
                                                <td nowrap="">
                                                    <a target="_blank" href="<?php echo $this->Html->url(['controller'=>'produits','action'=>'view',$dossier['Produit']['id']]) ?>"><?php echo h($dossier['Produit']['reference']); ?></a>
                                                </td>
                                                <td nowrap="">
                                                    <a target="_blank" href="<?php echo $this->Html->url(['controller'=>'produits','action'=>'view',$dossier['Produit']['id']]) ?>"><?php echo h($dossier['Produit']['libelle']); ?></a>
                                                </td>
                                                <td nowrap="" style="color: red;font-weight: bold;"><?php echo $dossier['Depotproduit']['quantite']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php else: ?>
	<div class="row">
		<div class="col-lg-12 text-center">
			<h2><strong>Bienvenu sur la plateforme</strong></h2><hr/>
            <img src="<?php echo $this->Html->url('/img/jcollab.png') ?>"  width="40%"/>
		</div>
	</div>
<?php endif ?>
<?php $this->start('js') ?>

<?php echo $this->Html->script('/app-assets/plugins/bootstrap-daterangepicker/moment.min.js') ?>
<?php echo $this->Html->script('/app-assets/plugins/bootstrap-daterangepicker/daterangepicker.js') ?>
<?php echo $this->Html->script('/app-assets/plugins/highcharts/highcharts.js') ?>

<script type="text/javascript">
	
$(document).ready(function() {

	// Radialize the colors
	Highcharts.setOptions({
        lang: {
            noData: "Aucune donnée disponible sur la période sélectionnée"
        },
	    colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
	        return {
	            radialGradient: {
	                cx: 0.5,
	                cy: 0.3,
	                r: 0.7
	            },
	            stops: [
	                [0, color],
	                [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
	            ]
	        };
	    })
	});

    $('#dashboard-report-range').flatpickr({
        dateFormat: "d-m-Y",
        allowInput: false,
        mode: "range",
        locale: "fr",
        defaultDate: [
            "<?php echo date('d-m-Y', strtotime($date['start'])) ?>",
            "<?php echo date('d-m-Y', strtotime($date['end'])) ?>"
        ],
        onClose: function(selectedDates, dateStr, instance){
            var start = moment(new Date(selectedDates[0])); 
            var end = moment(new Date(selectedDates[1])); 
            $('#RangeDateStart').val(start.format('YYYY-MM-DD'));
            $('#RangeDateEnd').val(end.format('YYYY-MM-DD'));
            $('#RangeDate').submit();
        }
    });

    $('#DepenceChart').highcharts({
        chart: {
            type: 'spline'
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin','Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre']
        },
        yAxis: {
            title: {
                text: 'Chiffre d\'affaire des dépences (Dhs)'
            },
            labels: {
                formatter: function () {
                    return this.value;
                }
            }
        },
        tooltip: {
            crosshairs: true,
            shared: true
        },
        plotOptions: {
            spline: {
                marker: {
                    radius: 4,
                    lineColor: '#666666',
                    lineWidth: 1
                }
            }
        },
        credits: {
          enabled: false
        },
        lang: {
            noData: "Aucune donnée disponible sur la période sélectionnée"
        },
        series: [
            <?php echo ( !empty( $depenceChart ) ) ? json_encode( $depenceChart ) : json_encode( [] ) ; ?>,
        ]
    });

    $('#ChiffreAffaireChart').highcharts({
        chart: {
            type: 'spline'
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin','Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre']
        },
        yAxis: {
            title: {
                text: 'Chiffre d\'affaire (Dhs)'
            },
            labels: {
                formatter: function () {
                    return this.value;
                }
            }
        },
        tooltip: {
            crosshairs: true,
            shared: true
        },
        plotOptions: {
            spline: {
                marker: {
                    radius: 4,
                    lineColor: '#666666',
                    lineWidth: 1
                }
            }
        },
        credits: {
          enabled: false
        },
        lang: {
            noData: "Aucune donnée disponible sur la période sélectionnée"
        },
        series: [
            <?php echo ( !empty( $ChiffreAffaireChart['Valide'] ) ) ? json_encode( $ChiffreAffaireChart['Valide'] ) : json_encode( [] ) ; ?>,
            <?php echo ( !empty( $ChiffreAffaireChart['EnCours'] ) ) ? json_encode( $ChiffreAffaireChart['EnCours'] ) : json_encode( [] ) ; ?>,
        ]
    });

    $('#DepencePie').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: ''
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y:.0f} Dhs <br/> {point.percentage:.1f}%</b>'
        },
        credits: {
          enabled: false
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f}%',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    },
                    connectorColor: 'silver'
                },
                showInLegend: true,
            }
        },
        lang: {
            noData: "Aucune donnée disponible sur la période sélectionnée"
        },
        series: [{
            name: 'Dépence ',
            data: <?php echo ( ( !empty( $depencePie ) ) ? json_encode( array_values( $depencePie ) ) : json_encode( array_values( [] ) ) ) ?>
        }]
    });

    $('#clientPie').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: ''
        },
        xAxis: {
            type: 'category',
            labels: {
                rotation: -90,
                style: {
                    fontSize: '10px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Chiffre d\'affaire'
            }
        },
        legend: {
            enabled: false
        },
        tooltip: {
            pointFormat: 'Chiffre d\'affaire : <b>{point.y:.0f} Dhs</b>'
        },
        credits: {
          enabled: false
        },
        lang: {
            noData: "Aucune donnée disponible sur la période sélectionnée"
        },
        series: [{
            colorByPoint: true,
            name: "Chiffre d'affaire",
            data: <?php echo ( !empty( $clientPie ) ) ? json_encode( array_values( $clientPie ) ) : json_encode( array_values( [] ) ) ;  ?> ,
            dataLabels: {
                enabled: false,
                format: '{point.y:.0f} Dhs',
                style: {
                    fontSize: '10px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        }]
    });

});

</script>
<?php $this->end() ?>