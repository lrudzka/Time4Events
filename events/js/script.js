$( function(){
    $('.date-picker').datepicker({dateFormat: 'yy-mm-dd'});
    
    var startDate = $('.start-date');
    var endDate = $('.end-date');
    
    startDate.on('change', function(){
        if ( endDate.val() === null ) {
            endDate.val(startDate.val());
        } else if ( endDate.val() < startDate.val() ) {
            endDate.val(startDate.val());
        }
    });
    
});



