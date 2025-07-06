/**
 * Created by admin on 19/08/2017.
 */
function validate()
{
    var flag=true;
    $(".rec").each(function () {

        if($(this).val()=="")
        {
            $(this).parent().parent().addClass('has-error');
            flag=false;
        }
    });
    return flag;
}