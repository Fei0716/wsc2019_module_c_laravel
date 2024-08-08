@extends('layout.main')
@include('layout.nav')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('layout.sideNav')
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="border-bottom mb-3 pt-3 pb-2">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                        <h1 class="h2">{{$event->name}}</h1>
                    </div>
                    <span class="h6">{{date('M d,Y',strtotime($event->date))}}</span>
                </div>

                <div class="mb-3 pt-3 pb-2">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                        <h2 class="h4">Room Capacity</h2>
                    </div>
                </div>

                <!-- TODO create chart here -->
                <canvas id="report">
                </canvas>
            </main>
        </div>
    </div>
@endsection


@section('script')
    <script src="{{Asset('assets/Chart.js-2.8.0/dist/Chart.min.js')}}"></script>
    <script>
        const data = @json($data);
        const ctx = document.getElementById('report').getContext('2d');
        let title = [];
        let datasetsC = [];
        let datasetsA = [];
        let colors = [];

        // generate the label for chart
        function generateLabels() {
            for (let i of data) {
                title.push(i.title);
                if (i.capacity < i.attendee) {
                    colors.push('rgb(255, 99, 132)');
                } else {
                    colors.push('rgb(100,255,95)');
                }
                datasetsC.push(i.capacity);
                datasetsA.push(i.attendee);
            }
        }

        generateLabels();
        var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'bar',

            // The data for our dataset
            data: {
                labels: title,
                datasets: [
                    {
                        label: 'Attendees',
                        backgroundColor: colors,
                        data: datasetsA,
                    },
                    {
                        label: 'Capacity',
                        backgroundColor: 'rgb(128,217,255)',
                        data: datasetsC,
                    }
                ]
            },

            // Configuration options go here
            options: {
                "scales": {
                    "yAxes": [{
                        "ticks": {
                            "beginAtZero": true
                        },
                        scaleLabel: {
                            display: true,
                            labelString: "Capacity",
                        }
                    }],
                    "xAxes": [{
                        "ticks": {
                            "beginAtZero": true
                        },
                        scaleLabel: {
                            display: true,
                            labelString: "Session",
                        }
                    }]
                }
            }
        });
    </script>
@endsection
