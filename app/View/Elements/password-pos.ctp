<?php $element = ( isset($element) ) ? '#'.$element : '#code_barre' ; ?>
<?php $output = ( isset($output) ) ? '.'.$output : '.output' ; ?>
<script type="text/javascript">


$(document).on('click','.numberClickMode2',function(e) {
    e.preventDefault();
    let currentValue = $(_output).html();
    let _elementValue = $(this).attr('href');
    // OutPut
    var output = currentValue+_elementValue;
    $(_output).html(output);
});

$(document).on('click','.index_numpad_del',function(e) {
    e.preventDefault();
    let index_numpad_output_val = $(_output).html();
    if(index_numpad_output_val.slice(-2) !== "0." && index_numpad_output_val.slice(-3) !== "-0."){
        var index_numpad_output_val_deleted = index_numpad_output_val.slice(0, -1);
        $(_output).html(index_numpad_output_val_deleted);
    }
});

$(document).on('click','.index_numpad_clear',function(e) {
    e.preventDefault(); $(_output).html('');
});

$(document).on('click','.index_numpad_close',function(e) {
    e.preventDefault(); index_numpad_close();
});

$(document).on('click','.index_numpad_done2',function(e) {
    e.preventDefault();
    let index_numpad_output_val = $(".easy-numpad-output").html();
    $("#passw").val(index_numpad_output_val);
  
    index_numpad_close();
});

function index_numpad_close() {
    $(".easy-numpad-frame").remove();
}

function show_index_numpad2(thisElement){
    let index_numpad = document.createElement("div");
    index_numpad.id = "easy-numpad-frame";
    index_numpad.className = "easy-numpad-frame";
    index_numpad.innerHTML = `
        <div class="easy-numpad-container" style="max-width: 390px;">
            <div class="easy-numpad-output-container">
                <p class="easy-numpad-output" id="easy-numpad-output" style="min-height: 45px;"></p>
            </div>
            <div class="easy-numpad-number-container">
                <table style="width:100%;">
                    <tr>
                        <td><button class="btn btn-primary btn-block numberClickMode2" type="button" href="7" >7</button></td>
                        <td><button class="btn btn-primary btn-block numberClickMode2" type="button" href="8" >8</button></td>
                        <td><button class="btn btn-primary btn-block numberClickMode2" type="button" href="9" >9</button></td>
                    </tr>
                    <tr>
                        <td><button class="btn btn-primary btn-block numberClickMode2" type="button" href="4" >4</button></td>
                        <td><button class="btn btn-primary btn-block numberClickMode2" type="button" href="5" >5</button></td>
                        <td><button class="btn btn-primary btn-block numberClickMode2" type="button" href="6" >6</button></td>
                    </tr>
                    <tr>
                        <td><button class="btn btn-primary btn-block numberClickMode2" type="button" href="1" >1</button></td>
                        <td><button class="btn btn-primary btn-block numberClickMode2" type="button" href="2" >2</button></td>
                        <td><button class="btn btn-primary btn-block numberClickMode2" type="button" href="3" >3</button></td>
                    </tr>
                    <tr>
                        <td><button class="btn btn-primary btn-block numberClickMode2" type="button" href="±" disabled="disabled">±</button></td>
                        <td><button class="btn btn-primary btn-block numberClickMode2" type="button" href="0">0</button></td>
                        <td><button class="btn btn-primary btn-block numberClickMode2" type="button" href="." disabled="disabled">.</button></td>
                    </tr>
                </table>
                <table style="width:100%;">
                    <tr>
                        <td/><button class="btn btn-warning btn-block btn-lg index_numpad_del" type="button"><i class="fa fa-eraser"></i> Supprimer</button><td>
                        <td/><button class="btn btn-danger btn-block btn-lg index_numpad_clear" type="button"><i class="fa fa-eraser"></i> Vider</button><td>
                    </tr>
                    <tr>
                        <td/><button class="btn btn-danger btn-block btn-lg index_numpad_close" type="button"><i class="fa fa-reply"></i> Annuler</button><td>
                        <td/><button class="btn btn-success btn-block btn-lg index_numpad_done2" type="button"><i class="fa fa-check"></i> Terminer</button><td>
                    </tr>
                </table>
            </div>
        </div>
    `;

    $(document.body).append(index_numpad);
    $(".easy-numpad-output").html('');
}
</script>