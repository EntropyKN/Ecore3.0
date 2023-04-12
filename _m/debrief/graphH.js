am5.ready(function() {

// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
var root = am5.Root.new("chartdiv");


// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
root.setThemes([
  am5themes_Animated.new(root)
]);


// Create chart
// https://www.amcharts.com/docs/v5/charts/xy-chart/
var chart = root.container.children.push(am5xy.XYChart.new(root, {
 /* panX: true,
  panY: true,
  wheelX: "panX",
  wheelY: "zoomX",
  pinchZoomX:true*/
}));

// Add cursor
// https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
cursor.lineY.set("visible", false);


// Create axes
// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
var xRenderer = am5xy.AxisRendererX.new(root, { minGridDistance: 30 });
xRenderer.labels.template.setAll({
  rotation: 0,
  //centerY: am5.p50,
  //centerX: am5.p100,
  //paddingRight: 15
});

var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
  //maxDeviation: 0.3,
  categoryField: "name",
  renderer: xRenderer,
  tooltip: am5.Tooltip.new(root, {})
}));

var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
  //maxDeviation: 0.3,
  renderer: am5xy.AxisRendererY.new(root, {})
}));


// Create series
// https://www.amcharts.com/docs/v5/charts/xy-chart/series/     https://www.amcharts.com/docs/v5/concepts/common-elements/labels/
var series = chart.series.push(am5xy.ColumnSeries.new(root, {
  name: "Series 1",
  xAxis: xAxis,
  yAxis: yAxis,
  valueYField: "steps",
  //sequencedInterpolation: true,
  categoryXField: "name",
  tooltip: am5.Tooltip.new(root, {
    labelText:"[bold fontSize: 20px]{valueY}%[/]\n[fontSize: 12px]{Q}[/]",    //https://www.amcharts.com/docs/v5/concepts/formatters/text-styling/
    //width:160,
   // maxWidth:200,
   // height: 160,
    //oversizedBehavior: "hide", //
   // fontSize: 30,
    //textAlign: "center"

  })
}));

series.columns.template.setAll({ cornerRadiusTL: 5, cornerRadiusTR: 5 });
/*series.columns.template.adapters.add("fill", function(fill, target) {
  return chart.get("colors").getIndex(series.columns.indexOf(target));
});
*/
series.columns.template.adapters.add("stroke", function(stroke, target) {
  return chart.get("colors").getIndex(series.columns.indexOf(target));
});


// Set data manually
/*
var data = [{
  name: "1",
  Q: "Arrediamo insieme questo posto?",
  steps: 18
}, {
  name: "2",
  Q: "aosdkalskjdals dajlkasd asldkj asldkj asdlkasklj das",
  steps: 50
}, {
  name: "3",
  Q: "aosdkalskjdals dajlkasd asldkj asldkj asdlkasklj das",
  steps: 100
}, {
  name  : "4",
  Q: "aosdkalskjdals dajlkasd asldkj asldkj asdlkasklj das",
  steps: 70
}
, {
  name  : "5",
  Q: "aosdkalskjdals dajlkasd asldkj asldkj asdlkasklj das",
  steps: 30
}
, {
  name  : "6",
  Q: "aosdkalskjdals dajlkasd asldkj asldkj asdlkasklj das",
  steps: 85
}

];
*/
var i
var winningPercStart=data[0]["winningPercStart"]
if (!winningPercStart) winningPercStart=50.00

for (i = 0; i < data.length; i++) {
    data[i]["steps"]=parseFloat(data[i]["steps"])
    //console.log(data[i]["steps"]);
} 

series.set("heatRules", [{
  target: series.columns.template,
  dataField: "valueY",
  customFunction: function(sprite, min, max, value) {
  /*
#L1{background-color:#dc3912;height: 55px;}
#L2{background-color:#eb4821;height: 44px;}
#L3{background-color:#fb5831;height: 35px;}
#L4{background-color:#ff7a53;height: 25px;}

#W1{background-color:#27A727;height: 25px;}
#W2{background-color:#139313;height: 35px;}
#W3{background-color:#178A17;height: 45px;}
#W4{background-color:#008000;height: 55px;}

  */
    if (winningPercStart==50.00) {
        if (value < 12.5) sprite.set("fill", am5.color(0xdc3912));
        if (value >= 12.5 && value < 25) sprite.set("fill", am5.color(0xeb4821));
        if (value >= 25 && value < 37.5) sprite.set("fill", am5.color(0xfb5831));
        if (value >= 37.5 && value < 50) sprite.set("fill", am5.color(0xff7a53));

        if (value >= 50 && value < 62.5) sprite.set("fill", am5.color(0x27A727));
        if (value >= 62.5 && value < 75) sprite.set("fill", am5.color(0x139313));
        if (value >= 75 && value < 87.5) sprite.set("fill", am5.color(0x178A17));
        if (value >= 87.5) sprite.set("fill", am5.color(0x008000));
    }else{

        if (value < winningPercStart) 
            sprite.set("fill", am5.color(0xDC3912));
        else
            sprite.set("fill", am5.color(0x008000));
    
    }
  }
}])
xAxis.data.setAll(data);
series.data.setAll(data);


// Make stuff animate on load
// https://www.amcharts.com/docs/v5/concepts/animations/
series.appear(1000);
chart.appear(1000, 100);

}); // end am5.ready()