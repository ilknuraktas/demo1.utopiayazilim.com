/**
 * eCommerce Dashboard
 */

'use strict';
(function () {
  let cardColor, headingColor, axisColor, borderColor, shadeColor;

  if (isDarkStyle) {
    cardColor = config.colors_dark.cardColor;
    headingColor = config.colors_dark.headingColor;
    axisColor = config.colors_dark.axisColor;
    borderColor = config.colors_dark.borderColor;
    shadeColor = 'dark';
  } else {
    cardColor = config.colors.white;
    headingColor = config.colors.headingColor;
    axisColor = config.colors.axisColor;
    borderColor = config.colors.borderColor;
    shadeColor = 'light';
  }

  // Visits - Multi Radial Bar Chart
  // --------------------------------------------------------------------
  const visitsRadialChartEl = document.querySelector('#visitsRadialChart'),
    visitsRadialChartConfig = {
      chart: {
        height: 270,
        type: 'radialBar'
      },
      colors: [config.colors.primary, config.colors.danger, config.colors.warning],
      series: [75, 80, 85],
      plotOptions: {
        radialBar: {
          offsetY: -10,
          hollow: {
            size: '45%'
          },
          track: {
            margin: 10,
            background: cardColor
          },
          dataLabels: {
            name: {
              fontSize: '15px',
              colors: [config.colors.secondary],
              fontFamily: 'IBM Plex Sans',
              offsetY: 25
            },
            value: {
              fontSize: '2rem',
              fontFamily: 'Rubik',
              fontWeight: 500,
              color: headingColor,
              offsetY: -15
            },
            total: {
              show: true,
              label: 'Total Visits',
              fontSize: '15px',
              fontWeight: 400,
              fontFamily: 'IBM Plex Sans',
              color: config.colors.secondary
            }
          }
        }
      },
      grid: {
        padding: {
          top: -10,
          bottom: -10
        }
      },
      stroke: {
        lineCap: 'round'
      },
      labels: ['Target', 'Mart', 'Ebay'],
      legend: {
        show: true,
        position: 'bottom',
        horizontalAlign: 'center',
        labels: {
          colors: axisColor,
          useSeriesColors: false
        },
        itemMargin: {
          horizontal: 15
        },
        markers: {
          width: 10,
          height: 10,
          offsetX: -3
        }
      }
    };

  if (typeof visitsRadialChartEl !== undefined && visitsRadialChartEl !== null) {
    const visitsRadialChart = new ApexCharts(visitsRadialChartEl, visitsRadialChartConfig);
    visitsRadialChart.render();
  }

  // Revenue Growth - Bar Chart
  // --------------------------------------------------------------------
  const revenueGrowthChartEl = document.querySelector('#revenueGrowthChart'),
    revenueGrowthChartConfig = {
      chart: {
        height: 90,
        type: 'bar',
        stacked: true,
        toolbar: {
          show: false
        }
      },
      grid: {
        show: false,
        padding: {
          left: 0,
          right: 0,
          top: -20,
          bottom: -20
        }
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '20%',
          borderRadius: 2,
          startingShape: 'rounded',
          endingShape: 'flat'
        }
      },
      legend: {
        show: false
      },
      dataLabels: {
        enabled: false
      },
     // colors: [config.colors.info, config.colors_label.primary],
      series: (typeof revenueSeries != 'undefined'?revenueSeries:[]),
      xaxis: {
        categories: (typeof revenueCategories != 'undefined'?revenueCategories:[]),
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
        labels: {
          style: {
            colors: axisColor
          },
          offsetY: -5
        }
      },
      yaxis: {
        show: false,
        floating: true
      },
      tooltip: {
        x: {
          show: false
        }
      }
    };
  if (typeof revenueGrowthChartEl !== undefined && revenueGrowthChartEl !== null) {
    const revenueGrowthChart = new ApexCharts(revenueGrowthChartEl, revenueGrowthChartConfig);
    revenueGrowthChart.render();
  }

  // Order Summary - Area Chart
  // --------------------------------------------------------------------
  const orderSummaryEl = document.querySelector('#orderSummaryChart'),
    orderSummaryConfig = {
      chart: {
        height: 280,
        type: 'area',
        toolbar: false,
        dropShadow: {
          enabled: true,
          top: 18,
          left: 2,
          blur: 3,
          color: config.colors.primary,
          opacity: 0.15
        }
      },
      series: (typeof orderSummarySeries != 'undefined'?orderSummarySeries:[]),
      dataLabels: {
        enabled: false
      },
      stroke: {
        curve: 'smooth',
        lineCap: 'round'
      },
      colors: [config.colors.primary],
      fill: {
        type: 'gradient',
        gradient: {
          shade: shadeColor,
          shadeIntensity: 0.8,
          opacityFrom: 0.7,
          opacityTo: 0.25,
          stops: [0, 95, 100]
        }
      },
      grid: {
        show: true,
        borderColor: borderColor,
        padding: {
          top: -15,
          bottom: -10,
          left: 15,
          right: 10
        }
      },
      xaxis: {
        categories: (typeof orderSummaryCategories != 'undefined'?orderSummaryCategories:[]),
        labels: {
          offsetX: 0,
          style: {
            colors: axisColor,
            fontSize: '13px'
          }
        },
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
        lines: {
          show: false
        }
      },
      yaxis: {
        labels: {
          offsetX: 7,
          formatter: function (val) {
            return  val;
          },
          style: {
            fontSize: '13px',
            colors: axisColor
          }
        },
       // min: 0,
       // max: 40,
        tickAmount: 4
      }
    };
  if (typeof orderSummaryEl !== undefined && orderSummaryEl !== null) {
    orderSummary = new ApexCharts(orderSummaryEl, orderSummaryConfig);
    orderSummary.render();
  }

  // 1

   // Order Summary - Area Chart
  // --------------------------------------------------------------------
  const orderSummaryEl1 = document.querySelector('#orderSummaryChart1'),
    orderSummaryConfig1 = {
      chart: {
        animations: {
          enabled: false,
          easing: 'easeinout',
          speed: 800,
          animateGradually: {
              enabled: true,
              delay: 150
          },
          dynamicAnimation: {
              enabled: false,
              speed: 350
          }
      },
        height: 280,
        type: 'area',
        toolbar: false,
        dropShadow: {
          enabled: true,
          top: 18,
          left: 2,
          blur: 3,
          color: config.colors.primary,
          opacity: 0.15
        }
      },
      series: (typeof orderSummarySeries1 != 'undefined'?orderSummarySeries1:[]),
      dataLabels: {
        enabled: false
      },
      stroke: {
        curve: 'smooth',
        lineCap: 'round'
      },
      colors: [config.colors.primary],
      fill: {
        type: 'gradient',
        gradient: {
          shade: shadeColor,
          shadeIntensity: 0.8,
          opacityFrom: 0.7,
          opacityTo: 0.25,
          stops: [0, 95, 100]
        }
      },
      grid: {
        show: true,
        borderColor: borderColor,
        padding: {
          top: -15,
          bottom: -10,
          left: 15,
          right: 10
        }
      },
      xaxis: {
        categories: (typeof orderSummaryCategories1 != 'undefined'?orderSummaryCategories1:[]),
        labels: {
          offsetX: 0,
          style: {
            colors: axisColor,
            fontSize: '13px'
          }
        },
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
        lines: {
          show: false
        }
      },
      yaxis: {
        labels: {
          offsetX: 7,
          formatter: function (val) {
            return  val;
          },
          style: {
            fontSize: '13px',
            colors: axisColor
          }
        },
       // min: 0,
       // max: 40,
        tickAmount: 4
      }
    };
  if (typeof orderSummaryEl1 !== undefined && orderSummaryEl1 !== null) {
    orderSummary1 = new ApexCharts(orderSummaryEl1, orderSummaryConfig1);
    orderSummary1.render();
  }


  // 2


   // Order Summary - Area Chart
  // --------------------------------------------------------------------
  const orderSummaryEl2 = document.querySelector('#orderSummaryChart2'),
    orderSummaryConfig2 = {
      chart: {
        animations: {
          enabled: false,
          easing: 'easeinout',
          speed: 800,
          animateGradually: {
              enabled: true,
              delay: 150
          },
          dynamicAnimation: {
              enabled: false,
              speed: 350
          }
      },
        height: 280,
        type: 'area',
        toolbar: false,
        dropShadow: {
          enabled: true,
          top: 18,
          left: 2,
          blur: 3,
          color: config.colors.primary,
          opacity: 0.15
        }
      },
      series: (typeof orderSummarySeries2 != 'undefined'?orderSummarySeries2:[]),
      dataLabels: {
        enabled: false
      },
      stroke: {
        curve: 'smooth',
        lineCap: 'round'
      },
      colors: [config.colors.warning],
      fill: {
        type: 'gradient',
        gradient: {
          shade: shadeColor,
          shadeIntensity: 0.8,
          opacityFrom: 0.7,
          opacityTo: 0.25,
          stops: [0, 95, 100]
        }
      },
      grid: {
        show: true,
        borderColor: borderColor,
        padding: {
          top: -15,
          bottom: -10,
          left: 15,
          right: 10
        }
      },
      xaxis: {
        categories: (typeof orderSummaryCategories2 != 'undefined'?orderSummaryCategories2:[]),
        labels: {
          offsetX: 0,
          style: {
            colors: axisColor,
            fontSize: '13px'
          }
        },
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
        lines: {
          show: false
        }
      },
      yaxis: {
        labels: {
          offsetX: 7,
          formatter: function (val) {
            return  val;
          },
          style: {
            fontSize: '13px',
            colors: axisColor
          }
        },
       // min: 0,
       // max: 40,
        tickAmount: 4
      }
    };
  if (typeof orderSummaryEl2 !== undefined && orderSummaryEl2 !== null) {
    orderSummary2 = new ApexCharts(orderSummaryEl2, orderSummaryConfig2);
    orderSummary2.render();
  }


    // 3


   // Order Summary - Area Chart
  // --------------------------------------------------------------------
  const orderSummaryEl3 = document.querySelector('#orderSummaryChart3'),
    orderSummaryConfig3 = {
      chart: {
        animations: {
          enabled: false,
          easing: 'easeinout',
          speed: 800,
          animateGradually: {
              enabled: true,
              delay: 150
          },
          dynamicAnimation: {
              enabled: false,
              speed: 350
          }
      },
        height: 280,
        type: 'area',
        toolbar: false,
        dropShadow: {
          enabled: true,
          top: 18,
          left: 2,
          blur: 3,
          color: config.colors.primary,
          opacity: 0.15
        }
      },
      series: (typeof orderSummarySeries3 != 'undefined'?orderSummarySeries3:[]),
      dataLabels: {
        enabled: false
      },
      stroke: {
        curve: 'smooth',
        lineCap: 'round'
      },
      colors: [config.colors.success],
      fill: {
        type: 'gradient',
        gradient: {
          shade: shadeColor,
          shadeIntensity: 0.8,
          opacityFrom: 0.7,
          opacityTo: 0.25,
          stops: [0, 95, 100]
        }
      },
      grid: {
        show: true,
        borderColor: borderColor,
        padding: {
          top: -15,
          bottom: -10,
          left: 15,
          right: 10
        }
      },
      xaxis: {
        categories: (typeof orderSummaryCategories3 != 'undefined'?orderSummaryCategories3:[]),
        labels: {
          offsetX: 0,
          style: {
            colors: axisColor,
            fontSize: '13px'
          }
        },
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
        lines: {
          show: false
        }
      },
      yaxis: {
        labels: {
          offsetX: 7,
          formatter: function (val) {
            return  val;
          },
          style: {
            fontSize: '13px',
            colors: axisColor
          }
        },
       // min: 0,
       // max: 40,
        tickAmount: 4
      }
    };
  if (typeof orderSummaryEl3 !== undefined && orderSummaryEl3 !== null) {
    orderSummary3 = new ApexCharts(orderSummaryEl3, orderSummaryConfig3);
    orderSummary3.render();
  }

  // Marketing Campaign - Donut Chart 1
  // --------------------------------------------------------------------
  const marketingCampaignChart1El = document.querySelector('#marketingCampaignChart1'),
    marketingCampaignChart1Config = {
      chart: {
        height: 55,
        width: 55,
        fontFamily: 'IBM Plex Sans',
        type: 'donut'
      },
      dataLabels: {
        enabled: false
      },
      grid: {
        padding: {
          top: -5,
          bottom: -5,
          left: -2,
          right: 0
        }
      },
      series: [60, 45, 60],
      stroke: {
        width: 3,
        lineCap: 'round',
        colors: cardColor
      },
      colors: [config.colors.primary, config.colors.warning, config.colors.success],
      plotOptions: {
        pie: {
          donut: {
            size: '65%',
            labels: {
              show: false,
              value: {
                show: false
              },
              total: {
                show: false
              }
            }
          }
        }
      },
      legend: {
        show: false
      },
      states: {
        active: {
          filter: {
            type: 'none'
          }
        }
      }
    };

  if (typeof marketingCampaignChart1El !== undefined && marketingCampaignChart1El !== null) {
    const marketingCampaignChart1 = new ApexCharts(marketingCampaignChart1El, marketingCampaignChart1Config);
    marketingCampaignChart1.render();
  }

  // Marketing Campaign - Donut Chart 2
  // --------------------------------------------------------------------
  const marketingCampaignChart2El = document.querySelector('#marketingCampaignChart2'),
    marketingCampaignChart2Config = {
      chart: {
        height: 55,
        width: 55,
        fontFamily: 'IBM Plex Sans',
        type: 'donut'
      },
      dataLabels: {
        enabled: false
      },
      grid: {
        padding: {
          top: -5,
          bottom: -5,
          left: -2,
          right: 0
        }
      },
      series: [60, 30, 30],
      stroke: {
        width: 3,
        lineCap: 'round',
        colors: cardColor
      },
      colors: [config.colors.danger, config.colors.secondary, config.colors.primary],
      plotOptions: {
        pie: {
          donut: {
            size: '65%',
            labels: {
              show: false,
              value: {
                show: false
              },
              total: {
                show: false
              }
            }
          }
        }
      },
      legend: {
        show: false
      },
      states: {
        active: {
          filter: {
            type: 'none'
          }
        }
      }
    };

  if (typeof marketingCampaignChart2El !== undefined && marketingCampaignChart2El !== null) {
    const marketingCampaignChart2 = new ApexCharts(marketingCampaignChart2El, marketingCampaignChart2Config);
    marketingCampaignChart2.render();
  }
})();
