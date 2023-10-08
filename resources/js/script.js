$(document).ready(function() {
    $('form').submit(function(event) {
        event.preventDefault();

        const name = $('#name').val().trim();
        const email = $('#email').val().trim();
        const phone = $('#phone').val().trim();
        const pizzaType = $('#pizzaType').val();
        const pizzaSize = $('input[name="pizzaSize"]:checked').val();

        if (name.length < 6 || !/\s/.test(name)) {
            alert('A névnek legalább 6 karakter hosszúnak kell lennie, és tartalmaznia kell szóközt!');
            return;
        }

        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        if (!emailRegex.test(email)) {
            alert('Az email cím érvénytelen!');
            return;
        }

        if (!/^[0-9+]+$/.test(phone)) {
            alert('A telefonszám csak számokat és a "+" jelet tartalmazhatja.');
            return;
        }

        if (!name || !email || !phone || !pizzaType || !pizzaSize) {
            alert('A megrendeléshez kérjük, töltsd ki az összes mezőt, és válassz méretet!');
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
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#form-container').fadeOut(500, function() {
                        $('#successMessage').fadeIn(500);
                        $('#orderId').text(response.orderId);
                    });
                } else {
                    alert('Hiba: ' + response.error);
                }
            },
            error: function(response) {
                alert('Hiba lépett fel a megrendelés rögzítése során. Kérjük, próbálkozz újra!');
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