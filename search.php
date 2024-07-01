<?php
require_once("loginProcedure.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TickEX - Wszystkie bilety w jednym miejscu!</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/datatables.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="css/searchstyles.css">
</head>

<body data-bs-theme="dark">
    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/jquery-3.7.0.min.js"></script>
    <script src="js/datatables.min.js"></script>
    <script src="js/datatables.bootstrap5.js"></script>

    <?php
    require_once("navbar.php");
    ?>
    <div class="container">
        <hr>
        <table id="EventsDatabase" class="cards table table-sm table-hover" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th></th>
                    <th>Nazwa</th>
                    <th>Miasto</th>
                    <th>Cena</th>
                    <th>Data</th>
                    <th>Dostępne miejsca</th>
                    <th>Kategoria</th>
                </tr>
            </thead>
        </table>
        <hr>
    </div>
    <?php
    require_once("footer.php");
    ?>
    <script>
        var table = $('#EventsDatabase').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/pl.json',
                },
                //ustalamy strukturę w html, używając bootstrapa
                'dom': "<'row'p<'col-sm-12 col-md-3'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'l><'col-sm-12 col-md-7'p>>",
                //Bierzemy dane z bazy danych w postaci json
                'ajax': 'jsonGetEvents.php',
                'buttons': [, {

                }],
                'select': 'single',
                'columns': [{
                        'orderable': false,
                        'data': null,
                        'className': 'text-center',
                        'render': function(data, type, full, meta) {
                            if (type === 'display') {
                                var eventId = data.EventID;
                                var imageUrl = 'src/EventImages/' + eventId + '.webp';
                                data = '<a href="events?id=' + eventId + '">';
                                data += '<i class="fa fa-user fa-fw"></i>';
                                data += '<img src="' + imageUrl + '" class="avatar">';
                                data += '</a>';
                            }

                            return data;
                        }
                    },
                    {
                        'data': 'EventName'
                    },
                    {
                        'data': 'EventCity'
                    },
                    {
                        'data': 'TicketPrice',
                        'class': 'text-right',
                        //Formatujemy cenę jako polskiego złocisza
                        'render': function(data, type, full, meta) {
                            if (type === 'display') {
                                data = formatCurrency(data, 'PLN');
                            }

                            return data;
                        }
                    },
                    {
                        'data': 'DateOfEvent',
                        'class': 'text-right'
                    },
                    {
                        'data': 'AvailabeSpots'
                    },
                    {
                        'data': 'Category'
                    }
                ],
                'drawCallback': function(settings) {
                    var api = this.api();
                    var $table = $(api.table().node());

                    if ($table.hasClass('cards')) {

                        var labels = [];
                        $('thead th', $table).each(function() {
                            labels.push($(this).text());
                        });

                        $('tbody tr', $table).each(function() {
                            $(this).find('td').each(function(column) {
                                $(this).attr('data-label', labels[column]);
                            });
                        });

                        var max = 0;
                        $('tbody tr', $table).each(function() {
                            max = Math.max($(this).height(), max);
                        }).height(max);

                    } else {
                        $('tbody td', $table).each(function() {
                            $(this).removeAttr('data-label');
                        });

                        $('tbody tr', $table).each(function() {
                            $(this).height('auto');
                        });
                    }

                }
            })
            .on('click', 'tbody tr', function() {
                var data = table.row(this).data();
                var eventId = data.EventID;
                window.location.href = 'events?id=' + eventId;
            });


        function formatCurrency(amount, currency) {
            return new Intl.NumberFormat('pl-PL', {
                style: 'currency',
                currency: currency
            }).format(amount);
        }
        table.on('init', function() {
            $('*[type="search"][class="form-control form-control-sm"]')
                .removeClass('form-control-sm')
                .addClass('form-control-lg')
                .attr("id", "SearchBox")
                .css({
                    'display': 'inline-block',
                });

        });
        var filterValue = '';
        <?php
        if (isset($_POST['filterValue'])) {
            echo "filterValue = '" . $_POST['filterValue'] . "';";
        }
        ?>

        if (filterValue !== '') {
            table.search(filterValue).draw();
        }
    </script>

</body>

</html>