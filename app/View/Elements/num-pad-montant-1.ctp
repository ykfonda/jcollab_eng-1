<script type="text/javascript">
$(function() {

    let _element = "#Montant1";
    let _container = "#Mode1Container";
    let _btnNumber = ".numberClickMode1";
    let _btnDelete = ".easy_numpad_del_mode1";
    let _btnClear = ".easy_numpad_clear_mode1";
    let _minValue = $(_element).attr('min');
    let _maxValue = $(_element).attr('max');
    let _isInRange = true;

    $('#edit').on('click',_btnNumber,function(e) {
        e.preventDefault();
        let currentValue = $(_container).find(_element).val();
        let _elementValue = $(this).attr('href');
        switch(_elementValue)
        {
            case "±":
                if(currentValue.startsWith("-")) $(_element).val( currentValue.substring(1,currentValue.length) );
                else $(_element).val("-" + currentValue).trigger('change');
            break;
            case ".":
                if(_isInRange) {
                    if(currentValue.length === 0 ) $(_element).val("0.").trigger('change');
                    else if(currentValue.length === 1 && currentValue === "-") $(_element).val(currentValue + "0.").trigger('change');
                    else {
                        var output = currentValue+= ".";
                        $(_element).val( output.toString() ).trigger('change');
                    }
                }
            break;
            case "0":
                if(_isInRange)
                {
                    if( currentValue.length === 0  ) $(_element).val("0").trigger('change');
                    else if(currentValue.length === 1 && currentValue === "-") $(_element).val(currentValue + "0.").trigger('change');
                    else {
                        var output = currentValue+_elementValue;
                        $(_element).val(output).trigger('change');
                    }
                }
            break;
            default:
                if(_isInRange){   
                    var output = parseFloat(currentValue+_elementValue);
                    $(_element).val(output).trigger('change');
                }
            break;
        }

        let newValue = Number($(_element).val());
        easy_numpad_check_range(newValue);
    });

    $('#edit').on('click',_btnDelete,function(e) {
        e.preventDefault();
        let easy_numpad_output_val = $(_element).val();
        if(easy_numpad_output_val.slice(-2) !== "0." && easy_numpad_output_val.slice(-3) !== "-0.")
        {
            var easy_numpad_output_val_deleted = easy_numpad_output_val.slice(0, -1);
            $(_element).val(easy_numpad_output_val_deleted).trigger('change');
            easy_numpad_check_range(Number(easy_numpad_output_val_deleted));
        }
    });

    $('#edit').on('click',_btnClear,function(e) {
        e.preventDefault();
        $(_element).val("").trigger('change');
    });

    function easy_numpad_check_range(value)
    {
        let outputElement = $(_element);
        if(_maxValue != null && _minValue != null)
        {
            if(value <= _maxValue && value >= _minValue)
            {
                outputElement.css('color',"black");
                _isInRange = true;
            }
            else
            {
                outputElement.css('color',"red");
                _isInRange = false;
            }
        }
        else if(_maxValue != null)
        {
            if(value <= _maxValue)
            {
                outputElement.css('color',"black");
                _isInRange = true;
            }
            else
            {
                outputElement.css('color',"red");
                _isInRange = false;
            }
        }
        else if (_minValue != null)
        {
            if(value >= _minValue)
            {
                outputElement.css('color',"black");
                _isInRange = true;
            }
            else
            {
                outputElement.css('color',"red");
                _isInRange = false;
            }
        }
        else
        {
            outputElement.css('color',"black");
            _isInRange = true;
        }
    }

});
</script>