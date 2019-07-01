// Para códigos de descuento
$('#discount_code_type').change(function(){
	if(this.value == 1)
	{
		$('#discount_code_value_label').show();
		$('#discount_code_value').show();
		$('#discount_code_value').attr('max', 100);
	}
    else if(this.value == 2)
    {
    	$('#discount_code_value_label').hide();
    	$('#discount_code_value').hide();
    }
    else
    {
    	$('#discount_code_value_label').show();
    	$('#discount_code_value').show();
    	$('#discount_code_value').removeAttr('max');
    }
});