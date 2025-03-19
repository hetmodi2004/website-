$(document).ready(function() {
    // Function to fetch bookings from the database
    function fetchBookings() {
        $.ajax({
            url: 'fetch_booking.php', // Path to your PHP script
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var bookingTableBody = $('.order-table tbody');
                bookingTableBody.empty(); // Clear the table before adding new data

                // Iterate through the fetched data and append rows to the table
                data.forEach(function(booking) {
                    var row = `
                        <tr>
                            <td>${booking.id}</td>
                            <td>${booking.customer_name}</td>
                            <td>${booking.contact_info}</td>
                            <td>${booking.package_name}</td>
                            <td>${booking.booking_date}</td>
                            <td><span class="status ${booking.status.toLowerCase()}">${booking.status}</span></td>
                            <td>$${booking.total_amount}</td>
                            <td>
                                <button class="view-btn">View</button>
                                <button class="edit-btn">Edit</button>
                                <button class="delete-btn">Delete</button>
                            </td>
                        </tr>
                    `;
                    bookingTableBody.append(row);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching booking:', error);
            }
        });
    }

    // Fetch bookings when the page loads
    fetchBookings();

    // Set an interval to fetch bookings periodically (e.g., every 10 seconds)
    setInterval(fetchBookings, 10000); // Fetch every 10 seconds

    // Filter bookings based on status
    $('#filterButton').click(function() {
        var status = $('#statusFilter').val();
        $('table tbody tr').each(function() {
            var rowStatus = $(this).find('.status').text().toLowerCase();
            if (status === 'all' || rowStatus === status) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    // Search bookings by ID or Customer Name
    $('#searchInput').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('table tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    // Handle click actions (view, edit, delete)
    $(document).on('click', '.view-btn', function() {
        alert('View Booking Details');
    });

    $(document).on('click', '.edit-btn', function() {
        alert('Edit Booking Details');
    });

    $(document).on('click', '.delete-btn', function() {
        if (confirm('Are you sure you want to delete this booking?')) {
            $(this).closest('tr').remove();
        }
    });
});
