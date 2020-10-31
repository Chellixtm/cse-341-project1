$(document).ready(() => {
    let i = $('input.rowcount').length ? $('input.rowcount').attr('id') : 1;
    $('#addInput').click(() => {
        try {
            i++;
            $('#ingredientsTable').append(`
            <tr id="row${i}">
                <td>Ingredient: <input type="text" name="ingredient[${i}][name]"></td>
                <td>Quantity: <input type="number" name="ingredient[${i}][amount]"></td>
                <td>Measurement: <input type="text" name="ingredient[${i}][measurement]"></td>
                <td><button name="remove" id="${i}" class="btn btn-danger btnRemove">X</button></td>
            </tr>`);
        } catch (err) {
            console.log(err);
        }
    });

    $(document).on('click', 'button.btnRemove', function() {
        try {
            let buttonId = $(this).attr("id");
            console.log(buttonId);
            $("#row" + buttonId).remove();
        } catch (err) {
            console.log(err);
        }
    });
});