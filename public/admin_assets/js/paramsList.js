$(document).ready(function () {
    
    $('.addparams').click(function(){
        var name = $(this).data('name');
        var $table = $(this).parent().next('.paramstabl');
        var num = getMaxParam($table);
        
        var str = '<tr class="paramrow" data-num="'+num+'">'
            +'<td>'
            +'    <input type="text" class="form-control"  name="'+name+'['+num+']" value="">'
            +'</td>'
            +'<td>'
            +'    <a href="javascript:;" class="btn default btn-sm delparam" >'
            +'        <i class="fa fa-times"></i> Удалить </a>'
            +'</td>'
        +'</tr>'; 

        $table.children('tbody').prepend(str);
        return false;
    });
    
    
    $(document).on('click', '.delparam', function(){
        var $obj = $(this).parents('tr').eq(0);
        $obj.remove();

        return false;
    });

   
});

function getMaxParam($table)
{
    var max = 0;
    $table.find('.paramrow').each(function(){
        var num = parseInt($(this).data('num'));
        if(max < num){
            max = num;
        }
    });
    
    return max + 1;
}


