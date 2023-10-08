$(document).ready(function() {
    $('form').submit(function(event) {
        event.preventDefault(); // Prevent the default form submission behavior

        const name = $('#name').val().trim();
        const email = $('#email').val().trim();
        const phone = $('#phone').val().trim();
        const pizzaType = $('#pizzaType').val();
        const pizzaSize = $('input[name="pizzaSize"]:checked').val();

        if (name.length < 6 || !/\s/.test(name)) {
            alert('A névnek legalább 6 karaktert és egy szóközt kell tartalmaznia.');
            return;
        }

        if (!/^[0-9+]+$/.test(phone)) {
            alert('A megadott telefonszám érvénytelen. A telefonszám csak számokat és a "+" jelet tartalmazhatja.');
            return;
        }

        if (!name || !email || !phone || !pizzaType || !pizzaSize) {
            alert('A megrendeléshez kérjük, tölts ki minden mezőt!');
            return;
        }

        const formData = {
            pizzaType: $('#pizzaType').val(),
            pizzaSize: $('input[name="pizzaSize"]:checked').val(),
            extraCheese: $('#extraCheese').prop('checked') ? 1 : 0,
            name: $('#name').val(),
            email: $('#email').val(),
            phone: $('#phone').val()
        };

        $.ajax({
            type: 'POST',
            url: 'http://localhost:63342/PizzaApp/src/process_order.php',
            data: formData,
            success: function(response) {
                // Handle the response from the server
                alert('Köszönjük, a megrendelést rögzítettük!');
                // You can also update the UI or redirect the user after successful submission
            },
            error: function() {
                // Handle errors if the request fails
                alert('Hiba lépett fel a megrendelés rögzítése során. Kérjük, próbálja újra!');
            }
        });
    });

    $('#pizzaType').change(function() {
        if ($(this).val() === 'ham') {
            $('#extraCheese').prop('disabled', false);
        } else {
            $('#extraCheese').prop('disabled', true);
            $('#extraCheese').prop('checked', false);
        }
    });
});