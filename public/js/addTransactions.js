let entryRecord = {},
    totalRow = 0,
    counter = 1;

$(document).ready(function () {

    $("#addrow").on("click", function (e) {
        e.preventDefault();
        var newRow = $("<tr class='table'>");
        var cols = "";
        var headSelect = $('.coa_category').clone();

        cols += '<td>'+ headSelect.html() +'</td>';
        cols += '<td><input type="number" required class="form-control input-debit" value="0" name="debit' + counter + '"/></td>';
        cols += '<td><input type="number" required class="form-control input-credit" value="0" name="credit' + counter + '"/></td>';
        cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>';

        newRow.append(cols);

        $("table.voucher-table").append(newRow);

        $(".js-example-basic-single").select2();

        $('.selection').last().hide();

        let dynamicDebitInputClass = `input-debit${counter}`;

        let dynamicCreditInputClass = `input-credit${counter}`;

        $('.input-debit').last().addClass(dynamicDebitInputClass);

        $('.input-credit').last().addClass(dynamicCreditInputClass);

        $('.head-select').last().attr('name',`coa_parent${counter}`);

        bindKeyUpFunctionality(dynamicDebitInputClass, dynamicCreditInputClass);

        totalRow++;

        $('#totalRow').val(totalRow);

        counter++;

    });



    $("table.voucher-table").on("click", ".ibtnDel", function (event) {

        $(this).closest("tr").remove();

        totalRow--;

        $('#totalRow').val(totalRow);
    });


    bindKeyUpFunctionality();

    // This block of code get executed on form submit

    $( "#voucher-form" ).submit(function( event ) {

        event.preventDefault();

        if($('.debit-total').val() !== $('.credit-total').val()) {

            alert('Amount is not balanced');

        } 

        else {

            this.submit();
        }
    });

});

// After input is given to debit or credit field this get executed

function bindKeyUpFunctionality(dynamicDebitInputClass, dynamicCreditInputClass) {

    let debitClassName = dynamicDebitInputClass || 'debit-input',
        creditClassName = dynamicCreditInputClass || 'credit-input';

        $("."+debitClassName).blur(function(e) {

            let addingAmount = getAddingAmount(e.target);

            let totalDebit = Number(addingAmount) + Number($(".debit-total").val());

            $(".debit-total").val(totalDebit);

        });
        $("."+creditClassName).blur(function(e) {

            let addingAmount = getAddingAmount(e.target);

            let totalCredit = Number(addingAmount) + Number($(".credit-total").val());
            $(".credit-total").val(totalCredit);

        });

}

// Determine and add the amount to the total

function getAddingAmount(target) {

    let returningAmount = 100;

    let classes = target.className.split(/\s+/) || [],
        className = '';

    classes.forEach((singleClass) => {

        if(singleClass.indexOf('debit') >= 0 || singleClass.indexOf('credit') >= 0) className = singleClass;

    });

    if(entryRecord.hasOwnProperty(className)) {

        let amountToAdd =  Number(target.value) - Number(entryRecord[className]);

        entryRecord[className] = amountToAdd;

        returningAmount = amountToAdd;

    } else {

        entryRecord[className] = Number(target.value);

        returningAmount = target.value;

    }

    return returningAmount;

}

