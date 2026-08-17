@extends('layouts.master-adminDashboard')

@section('page','داشبورد')
@section('content')
@canany(['admins','superadmin'])
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-5 mx-auto text-center">
                <h5>تعداد بازدید : {{$views}}</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
</section>

<script>
   var dates='{{$dates}}';
   var dataW='{{$data}}';
   dates=JSON.parse(dates.replace(/&quot;/g,'"'))
   console.log(dates)
   dataW=JSON.parse(dataW);
   console.log(dataW)
   const labels = dates;

  const data = {
    labels: labels,
    datasets: [{
      label: 'نمودار بازدید',
      backgroundColor: 'rgb(255, 99, 132)',
      borderColor: 'rgb(255, 99, 132)',
      data:dataW ,
    }]
  };
  let delayed;
  const config = {
    type: 'line',
    data: data,
    options: {
    animation: {
      onComplete: () => {
        delayed = true;
      },
      delay: (context) => {
        let delay = 0;
        if (context.type === 'data' && context.mode === 'default' && !delayed) {
          delay = context.dataIndex * 300 + context.datasetIndex * 100;
        }
        return delay;
      },
    },
    scales: {
      x: {
        stacked: true,
      },
      y: {
        stacked: true
      }
    }
  }
  };

</script>

<script>
 $(document).ready(function(){
  const myChart = new Chart(
    document.getElementById('myChart'),
    config
  );
 })
</script>

@endcanany

@if(session()->has('string'))
   @include('layouts.alert')
@endif


@endsection