<script>
   function confirmModal(content, callback = function() {
       console.log('Confirm')
   }) {
       $.confirm({
           title: 'Thông báo!',
           content: content,
           animation: 'top',
           closeAnimation: 'top',
           buttons: {
               confirm: {
                   text: 'Xác nhận',
                   btnClass: 'btn btn-primary btn-sm',
                   action: function() {
                       callback();
                   }
               },
               cancel: {
                   text: 'Hủy',
                   btnClass: 'btn btn-secondary btn-sm'
               }
           }
       });
   }
   
    function chartOverViewModule(data, categories, module) {
        var options = {
                series: [{
                name: 'Lượt sử dụng: ',
                data:  data
            }],
            chart: {
                fontFamily:'Helvetica Neue',
                    height: 350,
                    type: 'bar',
                },
                plotOptions: {
                    bar: {
                    dataLabels: {
                        position: 'top', // top, center, bottom
                    },
                }
            },
            dataLabels: {
                enabled: true,
                    formatter: function (val) {
                    return val + " lần";
                    },
                    offsetY: -20,
                    style: {
                    fontSize: '12px',
                    colors: ["#304758"]
                    }
            },
            xaxis: {
                categories: categories,
                position: 'bottom',
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                },
            },
            title: {
                text: module,
                align: 'center',
                style: {
                    color: '#444',
                }
            },
            fill: {
                colors: [function({
                    value,
                    seriesIndex,
                    w
                }) {
                    return value == Math.max.apply(Math, data) ? '#ff3b30' : '#007aff';

                }]
            }
        };
       var chart = new ApexCharts(document.querySelector("#chart"), options);
       chart.render();
   }

   function chartOverViewTotal(series, categories){
    var options = {
          series: series,
          chart: {
          type: 'bar',
          height: 350
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded'
          },
        },
        dataLabels: {
          enabled: true
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
        xaxis: {
          categories: categories,
        },
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return  val + " lần"
            }
          }
        }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
   }

    function chartTransaction(data, categories) {
        var options = {
            series: [{
                name: 'Tổng thu nhập',
                data: data
            }],
            chart: {
                fontFamily: 'Helvetica Neue',
                height: 200,
                type: 'bar',
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        position: 'top', // top, center, bottom
                    },
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function(val) {
                    return val.toLocaleString('it-IT', {
                        style: 'currency',
                        currency: 'VND'
                    });
                },
                offsetY: -20,
                style: {
                    fontSize: '12px',
                    colors: ["#304758"]
                }
            },
            xaxis: {
                categories: categories,
                position: 'bottom',
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                },
            },
            yaxis: {
                labels: {
                    formatter: function(val) {
                        return val.toLocaleString('it-IT', {
                            style: 'currency',
                            currency: 'VND'
                        });
                    },
                },
            },
            fill: {
                colors: [function({
                    value,
                    seriesIndex,
                    w
                }) {
                    return value == Math.max.apply(Math, data) ? '#ff3b30' : '#007aff';

                }]
            }
        };
        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    }
</script>