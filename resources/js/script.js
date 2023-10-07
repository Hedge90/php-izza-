$(document).ready(function() {
    $('form').submit(function(event) {
        event.preventDefault(); // Prevent the default form submission behavior

        // Gather form data
        const formData = {
            pizzaType: $('#pizzaType').val(),
            pizzaSize: $('input[name="pizzaSize"]:checked').val(),
            extraCheese: $('#extraCheese').prop('checked'),
            name: $('#name').val(),
            email: $('#email').val(),
            phone: $('#phone').val()
        };

        // Send data to the server using AJAX
        $.ajax({
            type: 'POST',
            url: '../../src/process_order.php', // Replace this with your backend PHP script
            data: formData,
            success: function(response) {
                // Handle the response from the server
                alert('Order submitted successfully!');
                // You can also update the UI or redirect the user after successful submission
            },
            error: function() {
                // Handle errors if the request fails
                alert('Error submitting order.');
            }
        });
    });
    $('#pizzaType').change(function() {
        if ($(this).val() === 'ham') {
            $('#extraCheese').prop('disabled', false);
        } else {
            $('#extraCheese').prop('disabled', true);
            $('#extraCheese').prop('checked', false); // Uncheck the checkbox if pizza type is not Margherita
        }
    });
});