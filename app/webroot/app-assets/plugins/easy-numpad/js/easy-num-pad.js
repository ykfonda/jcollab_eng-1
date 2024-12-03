let _outputID = "";
let _minValue = null;
let _maxValue = null;
let _isInRange = true;

function easy_numpad_close() {
    let elementToRemove = document.querySelectorAll("div.easy-numpad-frame")[0];
    elementToRemove.parentNode.removeChild(elementToRemove);
}

$('.numberClick').on('click',function(e) {
    e.preventDefault();
    let currentValue = $("#easy-numpad-output").val();
    let elementValue = $(this).attr('href');

    switch(elementValue)
    {
        case "±":
            if(currentValue.startsWith("-"))
            {
                $("#easy-numpad-output").val() = currentValue.substring(1,currentValue.length);
            }
            else
            {
                $("#easy-numpad-output").val() = "-" + currentValue;
            }
        break;
        case ".":
            if(_isInRange) {
                if(currentValue.length === 0) {
                    $("#easy-numpad-output").val() = "0.";
                }
                else if(currentValue.length === 1 && currentValue === "-") {
                    $("#easy-numpad-output").val() = currentValue + "0.";
                }
                else {
                    if(currentValue.indexOf(".") < 0)
                    {
                        $("#easy-numpad-output").val() += ".";
                    }
                }
            }
        break;
        case "0":
            if(_isInRange)
            {
                if(currentValue.length === 0) $("#easy-numpad-output").val("0");
                else if(currentValue.length === 1 && currentValue === "-") $("#easy-numpad-output").val(currentValue + "0.");
                else {
                    var output = currentValue+elementValue;
                    $("#easy-numpad-output").val(output);
                }
            }
        break;
        default:
            if(_isInRange){   
                var output = currentValue+elementValue;
                $("#easy-numpad-output").val(output);
            }
        break;
    }

    let newValue = Number($("#easy-numpad-output").val());
    easy_numpad_check_range(newValue);
});

function easy_numpad_del()
{
    event.preventDefault();
    let easy_numpad_output_val = $("#easy-numpad-output").val();
    if(easy_numpad_output_val.slice(-2) !== "0." && easy_numpad_output_val.slice(-3) !== "-0.")
    {
        var easy_numpad_output_val_deleted = easy_numpad_output_val.slice(0, -1);
        $("#easy-numpad-output").val(easy_numpad_output_val_deleted);
        easy_numpad_check_range(Number(easy_numpad_output_val_deleted));
    }
}

function easy_numpad_clear()
{
    event.preventDefault();
    $("#easy-numpad-output").val("");
}

function easy_numpad_cancel()
{
    event.preventDefault();
    if(_isInRange) easy_numpad_close();
}

function easy_numpad_done() 
{
    event.preventDefault();

    if(_isInRange)
    {
        let easy_numpad_output_val = $("#easy-numpad-output").val();

        if(easy_numpad_output_val.indexOf(".") === (easy_numpad_output_val.length - 1))
        {
            easy_numpad_output_val = easy_numpad_output_val.substring(0,easy_numpad_output_val.length - 1);
        }

        if ( easy_numpad_output_val == '' ) easy_numpad_output_val = 0;
        $("#easy-numpad-output").val(easy_numpad_output_val);
        $("#easy-numpad-output").trigger('change');
        easy_numpad_close();
    }
}

function easy_numpad_check_range(value)
{
    let outputElement = $("#easy-numpad-output");
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