let _output = ".easy-numpad-output";
let _element = "#code_barre";

$(document).on('click','.numberClickMode1',function(e) {
    e.preventDefault();
    let currentValue = $(_output).html();
    let _elementValue = $(this).attr('href');
    // OutPut
    var output = currentValue+_elementValue;
    $(_output).html(output);
});

$(document).on('click','.easy_numpad_del',function(e) {
    e.preventDefault();
    let easy_numpad_output_val = $(_output).html();
    if(easy_numpad_output_val.slice(-2) !== "0." && easy_numpad_output_val.slice(-3) !== "-0."){
        var easy_numpad_output_val_deleted = easy_numpad_output_val.slice(0, -1);
        $(_output).html(easy_numpad_output_val_deleted);
    }
});

$(document).on('click','.easy_numpad_clear',function(e) {
    e.preventDefault(); $(_output).html('');
});

$(document).on('click','.easy_numpad_close',function(e) {
    e.preventDefault(); easy_numpad_close();
});

$(document).on('click','.easy_numpad_done',function(e) {
    e.preventDefault();
    let easy_numpad_output_val = $(".easy-numpad-output").html();
    $(_element).val(easy_numpad_output_val);
    $('#scan-product').trigger('submit');
    easy_numpad_close();
});

function easy_numpad_close() {
    $(".easy-numpad-frame").remove();
}

function show_easy_numpad(thisElement){
    let easy_numpad = document.createElement("div");
    easy_numpad.id = "easy-numpad-frame";
    easy_numpad.className = "easy-numpad-frame";
    easy_numpad.innerHTML = `
        <div class="easy-numpad-container" style="max-width: 390px;">
            <div class="easy-numpad-output-container">
                <p class="easy-numpad-output" id="easy-numpad-output" style="min-height: 45px;"></p>
            </div>
            <div class="easy-numpad-number-container">
                <table style="width:100%;">
                    <tr>
                        <td><button class="btn btn-primary btn-block numberClickMode1" type="button" href="7" >7</button></td>
                        <td><button class="btn btn-primary btn-block numberClickMode1" type="button" href="8" >8</button></td>
                        <td><button class="btn btn-primary btn-block numberClickMode1" type="button" href="9" >9</button></td>
                    </tr>
                    <tr>
                        <td><button class="btn btn-primary btn-block numberClickMode1" type="button" href="4" >4</button></td>
                        <td><button class="btn btn-primary btn-block numberClickMode1" type="button" href="5" >5</button></td>
                        <td><button class="btn btn-primary btn-block numberClickMode1" type="button" href="6" >6</button></td>
                    </tr>
                    <tr>
                        <td><button class="btn btn-primary btn-block numberClickMode1" type="button" href="1" >1</button></td>
                        <td><button class="btn btn-primary btn-block numberClickMode1" type="button" href="2" >2</button></td>
                        <td><button class="btn btn-primary btn-block numberClickMode1" type="button" href="3" >3</button></td>
                    </tr>
                    <tr>
                        <td><button class="btn btn-primary btn-block numberClickMode1" type="button" href="±" disabled="disabled">±</button></td>
                        <td><button class="btn btn-primary btn-block numberClickMode1" type="button" href="0">0</button></td>
                        <td><button class="btn btn-primary btn-block numberClickMode1" type="button" href="." disabled="disabled">.</button></td>
                    </tr>
                </table>
                <table style="width:100%;">
                    <tr>
                        <td/><button class="btn btn-warning btn-block btn-lg easy_numpad_del" type="button"><i class="fa fa-eraser"></i> Supprimer</button><td>
                        <td/><button class="btn btn-danger btn-block btn-lg easy_numpad_clear" type="button"><i class="fa fa-eraser"></i> Vider</button><td>
                    </tr>
                    <tr>
                        <td/><button class="btn btn-danger btn-block btn-lg easy_numpad_close" type="button"><i class="fa fa-reply"></i> Annuler</button><td>
                        <td/><button class="btn btn-success btn-block btn-lg easy_numpad_done" type="button"><i class="fa fa-check"></i> Terminer</button><td>
                    </tr>
                </table>
            </div>
        </div>
    `;

    $(document.body).append(easy_numpad);
    _outputID = thisElement.id;

    $(".easy-numpad-output").html('');
}