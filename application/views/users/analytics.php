<!-- jqPlot -->
<link href="<?php echo base_url('public/jqplot/1.0.8/jquery.jqplot.min.css'); ?>" type="text/css" rel="stylesheet" />
<script src="<?php echo base_url('public/jqplot/1.0.8/jquery.jqplot.min.js'); ?>"></script>
<script src="<?php echo base_url('public/jqplot/1.0.8/excanvas.min.js'); ?>"></script>
<script src="<?php echo base_url('public/jqplot/1.0.8/plugins/jqplot.pieRenderer.min.js'); ?>"></script>
<script src="<?php echo base_url('public/jqplot/1.0.8/plugins/jqplot.barRenderer.min.js'); ?>"></script>
<script src="<?php echo base_url('public/jqplot/1.0.8/plugins/jqplot.categoryAxisRenderer.min.js'); ?>"></script>
<script src="<?php echo base_url('public/jqplot/1.0.8/plugins/jqplot.pointLabels.min.js'); ?>"></script>
<script src="<?php echo base_url('public/jqplot/1.0.8/plugins/jqplot.canvasTextRenderer.min.js'); ?>"></script>
<script src="<?php echo base_url('public/jqplot/1.0.8/plugins/jqplot.canvasAxisLabelRenderer.min.js'); ?>"></script>

<div class="col-md-4">
    <div id="pie_amounts"></div>
</div>

<div class="col-md-4">
    <div id="bar_comparison"></div>
</div>

<div class="col-md-4">
    <div id="line_days"></div>
</div>

<?php
    $income=$_SESSION['income'];
    $amount_paid=0;

    if(!empty($bills)){
        $amounts=array();
        $days=array();
        foreach($bills as $row){
            //Set day to blank if one has not been set yet.
            if(!isset($days[$row['day']])) $days[$row['day']]=0;
            
            //Only count the day of the month if a month is not specified (meanining it occurs every month) or if this is the specified month.
            if($row['month']!='Y' or ($row['month']=="Y" and $row['month'.date('n')]=="CHECKED")){
                $amounts[$row['name']]=$row['amount'];
                
                $days[$row['day']]+=$row['amount'];
                
                $amount_paid+=$row['amount'];
            }
            
        }
    }
?>

<script>
    $(document).ready(function(){
        
        /* Compare each bill amount */
        $.jqplot ('pie_amounts', [[
            <?php
                if(empty($amounts)){
                    echo "['','']";
                }else{
                    foreach($amounts as $key=>$val){
                        echo "['".$key."', ".$val."],";
                    }
                }
            ?>
            ]],{
            animate: !$.jqplot.use_excanvas,
            title: "Amount Comparison",
            seriesDefaults: {
                // Make this a pie chart.
                renderer: $.jqplot.PieRenderer,
                rendererOptions: {
                    // Put data labels on the pie slices.
                    // By default, labels show the percentage of the slice.
                    showDataLabels: true,
                    sliceMargin: 4
                },
                shadow: false,
            },
            legend: { show:true, location: 'e' }
        });
        
        /* Compare the user's income to the amount they spent on their bills */
        var s1 = [<?php echo $income; ?>, <?php echo $amount_paid; ?>];
        var ticks = ['Income', 'Amount Paid'];
         
        $.jqplot('bar_comparison', [s1], {
            animate: !$.jqplot.use_excanvas,
            title: "Income / Amount Paid Comparison",
            seriesDefaults: {
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true },
                rendererOptions: {
                    varyBarColor: true
                }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks
                }
            }
        });
  
        /* Compare amounts spent each day */
        $.jqplot ('line_days', [[
            <?php
                if(empty($days)){
                    echo "[0,0]";
                }else{
                    foreach($days as $key=>$val){
                        echo "[".$key.", ".$val."],";
                    }
                }
            ?>
            ]],{
            animate: !$.jqplot.use_excanvas,
            title: "Amount Paid Per Day of the Month",
            axesDefaults: {
                //Allows vertical text for labels on Y axis
                labelRenderer: $.jqplot.CanvasAxisLabelRenderer
            },
            seriesDefaults: {
                rendererOptions: {
                    smooth: true
                }
            },
            axes: {
                xaxis: {
                    //Specify a label for the X axis.
                    label: 'Day of the Month',
                    //Allow data to start at the edges of the grid.
                    pad: 0
                },
                yaxis: {
                    //Specify a label for the Y axis.
                    label: 'Amount Paid'
                }
            }
        });
        
    });
</script>