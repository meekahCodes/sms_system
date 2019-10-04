@extends('layouts.app')

@section('htmlheader_title')
Home
@endsection


@section('header-content')

<h3> Analytics </h3>

@endsection




@section('main-content')


    <div class="container" >

        <div class="row" >

           <form  id="frm-filter" name="frm-filter" action="/admin/expenses/analytics?type=ajax" >

                 <div class="col-md-3"  >
                <label>From</label>
               <input type="text" id="from_date" class="timepicker form-control input-sm" name="from_date" >

            </div>

              <div class="col-md-3"  >
                <label>To</label>
               <input type="text" id="to_date" class="timepicker form-control input-sm" name="to_date" >

            </div>

            <div class="col-md-2" >
                <br>
                <button type="submit" class="btn btn-primary" >Filter</button>
            </div>

           </form>

        </div>
        <hr>
        <div class="row" >

            <div class="col-md-6" >
                  <div id="bar" style="width: 600px;height:400px;"></div>


            </div>
            <div class="col-md-6" >
                        <div id="pie" style="width: 600px;height:400px;"></div>
            </div>

        </div>

    </div>

@endsection

@section('custom-scripts')


    <script src="{{ asset('/js/echarts.common.min.js') }}" type="text/javascript"></script>


<script type="text/javascript">

		$('.timepicker').datetimepicker({});

        var category;
        var expenses;

        function getData(){

                $.ajax({
                    url:'/admin/expenses/analytics?type=ajax',
                    type:'get',
                    async:false,
                    success:function(data){
                        category=data.categories;
                        expenses=data.count;
                    }
                });

            }

         getData();


       var myChart = echarts.init(document.getElementById('bar'));

        // specify chart configuration item and data

        var option = {
            title: {
                text: 'Expenses Analytics'
            },
            tooltip: {},
            legend: {
                data:['Expenses']
            },
            xAxis: {
                data: category
            },
            yAxis: {},
            series: [{
                name: 'Expenses',
                type: 'bar',
                data: expenses
            }]
        };

        // use configuration item and data specified to show chart
        myChart.setOption(option);



        var piechart = echarts.init(document.getElementById('pie'));

        // specify chart configuration item and data
        var option = {
            title: {
                text: 'Expenses Analytics'
            },
            tooltip: {},
            legend: {
                data:['Expenses']
            },
            xAxis: {
                data:category
            },
            yAxis: {},
            series: [{
                name: 'Expenses',
                type: 'pie',
                data: expenses
            }]
        };

        // use configuration item and data specified to show chart
        piechart.setOption(option);





        $('#frm-filter').on('submit',function(){

            event.preventDefault();

              $.ajax({
                    url:'/admin/expenses/analytics?type=ajax',
                    type:'get',
                    data:{
                        from:$("#from_date").val(),
                        to:$('#to_date').val(),
                        type:'ajax'
                    },
                    async:false,
                    success:function(data){

                        myChart.clear();
                        piechart.clear();

                        var option = {
                            title: {
                                text: 'Expenses Analytics'
                            },
                            tooltip: {},
                            legend: {
                                data:['Expenses']
                            },
                            xAxis: {
                                data: data.categories
                            },
                            yAxis: {},
                            series: [{
                                name: 'Expenses',
                                type: 'bar',
                                data: data.count
                            }]
                        };


                        myChart.setOption(option);
                        piechart.setOption(option);


                        myChart.refresh();
                        piechart.refresh();

                    }
                });

        });



</script>
@endsection