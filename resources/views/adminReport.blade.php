<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Report</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite(['resources/js/app.js'])
</head>
<body class="adminReport">
    @include('navbar')
    <div class='page-container'>
    <h1>Admin Report</h1>

    <h3>Search missed activity by date</h3>

    <form id="searchForm" class="form">
        <label for="date">Date</label>
        <input type="date" id="date" name="date" required>

        <button type="submit">Search</button>
        <button type="reset" onclick="resetForm()" class="cancel">Clear</button>
    </form>

    <div id="errorMessage" style="color: red; display: none;">
    </div>

    <table id="activityTable" style="display: none;" class='table'>
        <thead>
            <tr>
                <th>Patient's Name</th>
                <th>Doctor's Name</th>
                <th>Caregiver's Name</th>
                <th>Morning Medicine</th>
                <th>Afternoon Medicine</th>
                <th>Night Medicine</th>
                <th>Breakfast</th>
                <th>Lunch</th>
                <th>Dinner</th>
            </tr>
        </thead>
        <tbody id="logResults">
            <tr>
                <td colspan="8">No results found</td>
            </tr>
        </tbody>
    </table>

    <script>
        $(document).ready(function () {
        $('#searchForm').on('submit', function (e) {
            e.preventDefault();

            const date = $('#date').val();
            const errorMessageDiv = $('#errorMessage');
            errorMessageDiv.hide(); // Hide error message container initially
            errorMessageDiv.empty(); // Clear any previous error messages

            if (date) {
                $.ajax({
                    url: "{{ route('admin-report.search') }}",
                    method: "GET",
                    data: { date: date },
                    success: function (response) {
                        const results = response.missedLogs; // Access the missedLogs array
                        const tbody = $('#logResults');
                        const table = $('#activityTable');
                        tbody.empty(); // Clear previous results

                        if (results.length > 0) {
                            table.show(); // Show the table if there are results
                            results.forEach(log => {
                            const doctorName = log.doctor ? log.doctor.first_name + ' ' + log.doctor.last_name : 'No doctor assigned';
                            
                            // Add classes based on status
                            const morningMedClass = log.morning_med_status ? 'completed' : 'missed';
                            const afternoonMedClass = log.afternoon_med_status ? 'completed' : 'missed';
                            const nightMedClass = log.night_med_status ? 'completed' : 'missed';
                            const breakfastClass = log.breakfast_status ? 'completed' : 'missed';
                            const lunchClass = log.lunch_status ? 'completed' : 'missed';
                            const dinnerClass = log.dinner_status ? 'completed' : 'missed';
                            
                            tbody.append(`
                                <tr>
                                    <td>${log.patient.user.first_name} ${log.patient.user.last_name}</td>
                                    <td>${doctorName}</td>
                                    <td>${log.caregiver.first_name} ${log.caregiver.last_name}</td>
                                    <td class="${morningMedClass}">${log.morning_med_status ? 'Completed' : 'Missed'}</td>
                                    <td class="${afternoonMedClass}">${log.afternoon_med_status ? 'Completed' : 'Missed'}</td>
                                    <td class="${nightMedClass}">${log.night_med_status ? 'Completed' : 'Missed'}</td>
                                    <td class="${breakfastClass}">${log.breakfast_status ? 'Completed' : 'Missed'}</td>
                                    <td class="${lunchClass}">${log.lunch_status ? 'Completed' : 'Missed'}</td>
                                    <td class="${dinnerClass}">${log.dinner_status ? 'Completed' : 'Missed'}</td>
                                </tr>
                            `);
                        });
                        } else {
                            table.hide(); // Hide the table if no results are found
                            errorMessageDiv.text('No missed activities found for this date.').show(); // Show the error message on the page
                        }
                    },
                    error: function () {
                        errorMessageDiv.text('Error occurred while fetching data.').show(); // Show error message if the AJAX request fails
                    }
                });
            } else {
                errorMessageDiv.text('Please select a date to search.').show(); // Display error if date is not selected
            }
        });
    });

    function resetForm() {
    // Clear the date field
    $('#date').val('');

    // Hide the table
    $('#activityTable').hide();

    // Hide the error message
    $('#errorMessage').hide();

    // Clear any existing table results
    $('#logResults').empty().append(`
        <tr>
            <td colspan="8">No results found</td>
        </tr>
    `);
}
    </script>
</div>
    @include('footer')
</body>
</html>
