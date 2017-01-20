<?php
/**
 * This index is going to use GA class and show the
 * response and draw the chart
 *
 * Created by PhpStorm.
 * User: ali
 * Date: 1/20/2017
 * Time: 13:39:58
 */

require_once "GeneticAlgorithm.php";

$ga = new GeneticAlgorithm();
echo "<br>";
$result = $ga->maxFitness();
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Math Genetic Algorithm</title>
    <link href="./assets/examples.css" rel="stylesheet" type="text/css">
    <script language="javascript" type="text/javascript" src="./assets/jquery.js"></script>
    <script language="javascript" type="text/javascript" src="./assets/jquery.flot.js"></script>
    <script type="text/javascript">

        $(function() {
            var view_data = [
                <?php for ($i=0;$i<count($result);$i++)
                    echo "[ $i , $result[$i] ] ,";
                ?>
            ];

            var plot = $.plot($("#placeholder"), [
                {
                    data: view_data,
                    lines: { show: true, fill: 1 },
                    label: "مقدار", stack: true, color: '#D11919'
                }
            ], {
                series: {shadowSize: 0, curvedLines: {apply: true, active: true, monotonicFit: true}, lines: {show: false, lineWidth: 0}},
                grid: {show : true, borderWidth: 0, labelMargin:10, hoverable: true, clickable: true, mouseActiveRadius:6,},
                legend: {show: false},
                colors: ["#fff", "#fff"],
                xaxis: {ticks: [
                    <?php for ($i=0;$i<count($result);$i++)
                    echo "[ $i , $i ] ,";
                    ?>
                ],font: {size: 12,variant: "small-caps",color: "#333"}},
                yaxis: {ticks: 3,tickDecimals: 0,font: {size: 12, color: "#333"}}
            });
        });

    </script>
</head>
<body>
<div id="content">
    <div class="demo-container">
        <div id="placeholder" class="demo-placeholder"></div>
    </div>
</div>
</body>
</html>

