am5.ready(function() {

// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
var root = am5.Root.new("chartdiv");

// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
root.setThemes([
  am5themes_Animated.new(root)
]);

  /*
var data = [
  {
    name: "1",
    Q: "domanda...1",
    steps: 10,
    pictureSettings: {
      src: "/data/scenarios/62_640.jpg"
    }
  },
  {
    name: "2",
    Q: "domanda...2",
    steps: 30,
    pictureSettings: {
      src: "/data/scenarios/62_640.jpg"
    }
  },
  {
    name: "3",
    Q: "domanda...3",
    steps: 48,
    pictureSettings: {
      src: "/data/scenarios/62_640.jpg"
    }
  },

  {
    name: "4",
    steps: 52,
    pictureSettings: {
      src: "/data/scenarios/62_640.jpg"
    }
  },   {
    name: "5",
    steps: 70,
    pictureSettings: {
      src: "/data/scenarios/62_640.jpg"
    }
    
  },
    {
    name: "6",
    steps: 78,
    pictureSettings: {
      src: "/data/scenarios/62_640.jpg"
    }
  },  
  
    {
    name: "7",
    steps: 90,
    pictureSettings: {
      src: "/data/scenarios/62_640.jpg"
    }
  }
  
  ]
*/
var i

for (i = 0; i < data.length; i++) {
    data[i]["steps"]=parseFloat(data[i]["steps"])
    //console.log(data[i]["steps"]);
} 

// Create chart
// https://www.amcharts.com/docs/v5/charts/xy-chart/
var chart = root.container.children.push(
  am5xy.XYChart.new(root, {
    panX: false,
    panY: false,
    wheelX: "none",
    wheelY: "none",
    paddingLeft: 0,
    paddingRight: 100,
    paddingTop: 50
  })
);

// Create axes
// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/

var yRenderer = am5xy.AxisRendererY.new(root, {});
yRenderer.grid.template.set("visible", false);


var yAxis = chart.yAxes.push(
  am5xy.CategoryAxis.new(root, {
    categoryField: "name",
    renderer: yRenderer,
    paddingRight:5,paddingLeft:5,
    font:"thaoma"
  })
);
// valueLabel.label.text = "{value}";
var xRenderer = am5xy.AxisRendererX.new(root, {
 //   labelText: "{valueX}%",
//    label: {text: "{valueX}%",},

});  
//xRenderer.grid.template.set("strokeDasharray", [3]);


var xAxis = chart.xAxes.push(
  am5xy.ValueAxis.new(root, {
    min: 0,max: 100,labelText: "{valueX}%",
      //label: {text: "{valueX}%",},
    renderer: xRenderer
  })
);

// Add series
// https://www.amcharts.com/docs/v5/charts/xy-chart/series/
var series = chart.series.push(
  am5xy.ColumnSeries.new(root, {
    name: "Match",
    xAxis: xAxis,
    yAxis: yAxis,
    Q: "Q",
    valueXField: "steps",
    categoryYField: "name",
    sequencedInterpolation: false,
    calculateAggregates: false,
    maskBullets: false,
    tooltip: am5.Tooltip.new(root, {
      dy: -10,
      pointerOrientation: "vertical",
      labelText: "{valueX}% \n\r{Q}"
    })
  })
);

series.columns.template.setAll({
  strokeOpacity: 0,
/*  cornerRadiusBR: 10,
  cornerRadiusTR: 10,
  cornerRadiusBL: 10,
  cornerRadiusTL: 10,*/
  maxHeight: 50,
  fillOpacity: 0.9
});

var currentlyHovered;

series.columns.template.events.on("pointerover", function(e) {
 
    //console.log (e.target.dataItem)console.log('domanda', e.target.dataItem.dataContext.Q)
  handleHover(e.target.dataItem);
});

series.columns.template.events.on("pointerout", function(e) {
  
  handleOut();
});

function handleHover(dataItem) {
    // show question
    
  if (dataItem && currentlyHovered != dataItem) {
    handleOut();
    currentlyHovered = dataItem;
    var bullet = dataItem.bullets[0];
    bullet.animate({
      key: "locationX",
      to: 1,
      duration: 600,
      easing: am5.ease.out(am5.ease.cubic)
    });
  }
}

function handleOut() {
// hide question

  if (currentlyHovered) {
    var bullet = currentlyHovered.bullets[0];
    bullet.animate({
      key: "locationX",
      to: 0,
      duration: 600,
      easing: am5.ease.out(am5.ease.cubic)
    });
  }
}


var circleTemplate = am5.Template.new({});

series.bullets.push(function(root, series, dataItem) {
  var bulletContainer = am5.Container.new(root, {});
  var circle = bulletContainer.children.push(
    am5.Circle.new(
      root,
      {
        radius: 1
      },
     circleTemplate
    )
  );

  var maskCircle = bulletContainer.children.push(
    am5.Circle.new(root, 
    { radius: 1 }
    )
  );
/*
  draw: function(display) {
    display.drawRect(0, 0, 50, 50)
  }
*/
  // only containers can be masked, so we add image to another container
  var imageContainer = bulletContainer.children.push(
    am5.Container.new(root, {
     // mask: maskCircle
    })
  );

  // not working
  var image = imageContainer.children.push(
    am5.Picture.new(root, {
  //stroke: am5.color(0xFF0000),strokeWidth: 300,
      templateField: "pictureSettings",
      //centerX: am5.p55,
      centerX: am5.percent(-4),
      centerY: am5.p50, // 107 50     89x50  81.7
      width: (46/9*16),height: 46,

    })
  );

  return am5.Bullet.new(root, {
    locationX: 0,
    sprite: bulletContainer
  });
});

// heatrule
/*
series.set("heatRules", [
  {
    dataField: "valueX",
    min: am5.color(0xff0000),  //0xe5dc36           verde 
    max: am5.color(0x008000),//0x5faa46

//   min: am5.color(0x000000),  //0xe5dc36           verde 
//    max: am5.color(0xFFFFFF),//0x5faa46


minValue: 0, maxValue: 100,    
    
    target: series.columns.template,
    key: "fill"
  },
{
    dataField: "valueX",
    min: am5.color(0x000000),
    max: am5.color(0xFFFFFF),
    target: circleTemplate,
    minValue: 0, maxValue: 100,    
    key: "fill"
  }
]);
*/

series.set("heatRules", [{
  target: series.columns.template,
  dataField: "valueX",
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

  
  0-12.5 dc3912
  */
  if (value < 12.5) sprite.set("fill", am5.color(0xdc3912));
  if (value >= 12.5 && value < 25) sprite.set("fill", am5.color(0xeb4821));
  if (value >= 25 && value < 37.5) sprite.set("fill", am5.color(0xfb5831));
  if (value >= 37.5 && value < 50) sprite.set("fill", am5.color(0xff7a53));
  
  if (value >= 50 && value < 62.5) sprite.set("fill", am5.color(0x27A727));
  if (value >= 62.5 && value < 75) sprite.set("fill", am5.color(0x139313));
  if (value >= 75 && value < 87.5) sprite.set("fill", am5.color(0x178A17));
  if (value >= 87.5) sprite.set("fill", am5.color(0x008000));
  
   /* if (value < 50) {
      sprite.set("fill", am5.color(0xDC3912));
    }
    else {
      sprite.set("fill", am5.color(0x008000));
    }
    */
  }
}])

series.data.setAll(data);
yAxis.data.setAll(data);

var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
cursor.lineX.set("visible", false);
cursor.lineY.set("visible", false);

cursor.events.on("cursormoved", function() {
  var dataItem = series.get("tooltip").dataItem;
  if (dataItem) {
    handleHover(dataItem)
  }
  else {
    handleOut();
  }
})

// Make stuff animate on load
// https://www.amcharts.com/docs/v5/concepts/animations/
series.appear();
chart.appear(1000, 100);

}); // end am5.ready()