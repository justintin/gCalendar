(function($){
            $(document).ready(function(){
        $('#datechoose').submit(function(){
        if($('#datechoose').find('input[name=date]').val() != ""){
            return true;
        }
        else{
            alert('Please Choose a Date!');
            return false;
        }
    });
            });
})(jQuery);