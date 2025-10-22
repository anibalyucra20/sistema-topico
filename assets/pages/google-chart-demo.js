/*
 Template Name: Xeloro - Admin & Dashboard Template
 Author: Angel Chocca
 File: Google Charts
*/


$(function () {
  'use strict';
    
  // Cargar el paquete de Google Charts
  google.charts.load("current", {packages:["corechart"]});
  google.charts.setOnLoadCallback(drawCharts);

  function drawCharts() {
    drawChart1();
    drawChart2();
  }

  // Primera tabla
  function drawChart1() {
    var data1 = google.visualization.arrayToDataTable([
      ['Task', 'Hours per Day'],
      ['Buen Estado',  50],
      ['Vencido', 2],
      ['Por Vencer',    7]
    ]);

    var options1 = {
      title: 'Automático',
      is3D: true,
      fontName: 'inherit',
      height: 310,
      fontSize: 13,
      colors: ['#23b5e2', '#e83e8c', '#f8ac5a']
    };

    var chart1 = new google.visualization.PieChart(document.getElementById('piechart-3d-chart-1'));
    chart1.draw(data1, options1);
  }

  // Segunda tabla
  function drawChart2() {
    var data2 = google.visualization.arrayToDataTable([
      ['Task', 'Hours per Day'],
      ['En Stock',  30],
      ['Poco Stock', 5],
      ['Sin Stock',    10]
    ]);

    var options2 = {
      title: 'Automático',
      is3D: true,
      fontName: 'inherit',
      height: 310,
      fontSize: 13,
      colors: ['#23b5e2', '#e83e8c', '#f8ac5a']
    };

    var chart2 = new google.visualization.PieChart(document.getElementById('piechart-3d-chart-2'));
    chart2.draw(data2, options2);
  }
});
