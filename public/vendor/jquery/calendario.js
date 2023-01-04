

var $j = jQuery.noConflict();


$j(function() {

  $j('input[id="calendario"]').daterangepicker({
      autoUpdateInput: false,
      locale: {
          cancelLabel: 'Clear',
          separator: ' - ',
        showCustonRangeLabel: false,
        monthNames: ["Janeiro",
            "Fevereiro",
            "Março",
            "Abril",
            "Maio",
            "Junho",
            "Julho",
            "Agosto",
            "Setembro",
            "Outubro",
            "Novembro",
            "Dezembro"],
         daysOfWeek: ["D",
            "S",
            "T",
            "Q",
            "Q",
            "S",
            "S"]
        
      }
  });

  $j('input[id="calendario"]').on('apply.daterangepicker', function(ev, picker) {
      $j(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
  });

  $j('input[id="calendario"]').on('cancel.daterangepicker', function(ev, picker) {
      $j(this).val('');
  });

});

