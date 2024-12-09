<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Report</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite(['resources/js/app.js'])
    <style>
body {
    background-color: whitesmoke; 
    color: whitesmoke; 
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
}


.page-container {
    max-width: 90%;
    margin: 30px auto;
    padding: 20px;
    background-color: #ffffff; 
    border-radius: 8px;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1); 
}


h1 {
    text-align: center;
    font-size: 2rem;
    font-weight: bold;
    color: #303030; 
    margin-bottom: 20px;
}


h3 {
    text-align: center;
    font-size: 1.5rem;
    color: #E4C297; 
    margin-bottom: 20px;
}


form {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 15px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

form label {
    font-weight: bold;
    font-size: 1rem;
    color: #303030; 
}

form input {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: whitesmoke; 
    color: #303030; 
    font-size: 1rem;
    width: 100%;
    max-width: 250px;
    box-sizing: border-box;
}

form input::placeholder {
    color: #cccccc; 
}

form button {
    background-color: #E4C297; 
    color: #ffffff; 
    font-weight: bold;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    cursor: pointer;
    font-size: 1rem;
    transition: background-color 0.3s ease;
}

form button:hover {
    background-color: #d2a67b; 
}

/* Error message styling */
#errorMessage {
    text-align: center;
    color: #d9534f; 
    font-size: 1rem;
    margin-top: 15px;
}

/* Table styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background-color: #ffffff; 
    border-radius: 8px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); 
    overflow: hidden;
    text-align: left;
}

thead {
    background-color: whitesmoke; 
    color: #303030; 
}

thead th {
    padding: 12px;
    font-weight: bold;
    text-align: center;
}

tbody tr {
    border-bottom: 1px solid #ccc;
}

tbody tr:nth-child(odd) {
    background-color: #f9f9f9; 
}

tbody tr:nth-child(even) {
    background-color: #ffffff; 
}

tbody td {
    padding: 10px;
    text-align: center;
    color: #303030; 
}

tbody td[colspan] {
    font-style: italic;
    color: #d9534f; 
    text-align: center;
}


@media (max-width: 768px) {
    h1 {
        font-size: 1.5rem;
    }

    h3 {
        font-size: 1.2rem;
    }

    form {
        flex-direction: column;
        gap: 10px;
    }

    table {
        font-size: 0.9rem;
    }
}

    </style>
</head>
<body>
    @include('navbar')
    <div class='page-container'>
    <h1>Admin Report</h1>

    <h3>Search missed activity by date</h3>

    <form id="searchForm" class=form>
        <label for="date">Date</label>
        <input type="date" id="date" name="date" required>

        <button type="submit">Search</button>
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
                                tbody.append(`
                                    <tr>
                                        <td>${log.patient.user.first_name} ${log.patient.user.last_name}</td>
                                        <td>${doctorName}</td>
                                        <td>${log.caregiver.first_name} ${log.caregiver.last_name}</td>
                                        <td>${log.morning_med_status ? 'Completed' : 'Missed'}</td>
                                        <td>${log.afternoon_med_status ? 'Completed' : 'Missed'}</td>
                                        <td>${log.night_med_status ? 'Completed' : 'Missed'}</td>
                                        <td>${log.breakfast_status ? 'Completed' : 'Missed'}</td>
                                        <td>${log.lunch_status ? 'Completed' : 'Missed'}</td>
                                        <td>${log.dinner_status ? 'Completed' : 'Missed'}</td>
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
    </script>
</div>
    @include('footer')
</body>
</html>
