<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    @vite(['resources/js/app.js'])

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        /* General Page Styling */
body {
    background-color: whitesmoke;
    font-family: Arial, sans-serif;
    color: #303030;
    margin: 0;
    padding: 0;
}

.form-container {
    max-width: 600px;
    margin: 30px auto;
    padding: 20px;
    background-color: whitesmoke;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

h3 {
    color: #303030;
    text-align: center;
    margin-bottom: 20px;
    font-weight: bold;
    border-bottom: 2px solid #E4C297;
    padding-bottom: 10px;
}


form {
    margin-bottom: 20px;
}

form .row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 15px;
    gap: 10px;
}

form label {
    font-weight: bold;
    color: #303030;
    flex: 1;
    text-align: right;
}

form input[type="text"] {
    flex: 2;
    padding: 8px;
    font-size: 14px;
    border: 1px solid #E4C297;
    border-radius: 4px;
    background-color: whitesmoke;
    color: #303030;
}

form input[type="text"]:read-only {
    background-color: #f9f9f9;
}

form button {
    padding: 8px 15px;
    font-size: 14px;
    border: none;
    border-radius: 4px;
    background-color: #E4C297;
    color: whitesmoke;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

form button:hover {
    background-color: #d1a679;
}


.alert {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid #E4C297;
    border-radius: 4px;
    background-color: #E4C297;
    color: whitesmoke;
    text-align: center;
}


@media (max-width: 600px) {
    form .row {
        flex-direction: column;
        align-items: flex-start;
    }

    form label {
        text-align: left;
        margin-bottom: 5px;
    }

    form input[type="text"], form button {
        width: 100%;
    }
}
    </style>
</head>
<body>
    @include('navbar')

    <div class="form-container">
        <h3>Payment Management</h3>

        <form id="paymentForm">
            @csrf
            <div class="row">
                <label for="patient_id">Patient ID:</label>
                <input type="text" id="patient_id" name="patient_id" placeholder="Enter Patient ID" required>
                <button type="button" id="fetchAdmissionDate">Fetch & Calculate</button>
            </div>

            <label for="admission_date"></label>
            <input type="hidden" id="admission_date" name="admission_date" placeholder="Auto-fetched" readonly>

            <label for="total_due">Total Due:</label>
            <input type="text" id="total_due" name="total_due" placeholder="Auto-calculated" readonly>

        </form>

        <form id="pay">
            @csrf
            <div class="row">
                <label for="payment_amount">Payment Amount:</label>
                <input type="text" id="payment_amount" name="payment_amount" placeholder="Enter Payment Amount" required>
                <button type="button" id="processPayment">Pay</button>
            </div>

            <label for="remaining_amount">Remaining Amount:</label>
            <input type="text" id="remaining_amount" name="remaining_amount" placeholder="Auto-calculated" readonly>
        </form>

    </div>

    @include('footer')

    <script>
        document.getElementById('fetchAdmissionDate').addEventListener('click', function () {
            const patientId = document.getElementById('patient_id').value;
            const admissionDateField = document.getElementById('admission_date');
            const totalDueField = document.getElementById('total_due');

            if (!patientId) {
                alert('Please enter the patient ID.');
                return;
            }

            // Make an AJAX request to fetch or insert payment
            fetch('/fetch-payment', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ patient_id: patientId }),
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        throw new Error(err.error || 'Server error.');
                    });
                }
                return response.json();
            })
            .then(data => {
                admissionDateField.value = data.admission_date;
                totalDueField.value = `$${data.total_due}`;
            })
            .catch(error => {+
                alert(error.message);
                admissionDateField.value = '';
                totalDueField.value = '';
            });
        });

        document.getElementById('processPayment').addEventListener('click', function () {
    const patientId = document.getElementById('patient_id').value;
    const paymentAmount = document.getElementById('payment_amount').value;
    const remainingAmountField = document.getElementById('remaining_amount');

    if (!patientId || !paymentAmount) {
        alert('Please enter both patient ID and payment amount.');
        return;
    }

    if (isNaN(paymentAmount) || parseFloat(paymentAmount) <= 0) {
        alert('Please enter a valid payment amount.');
        return;
    }

    // Make an AJAX request to process the payment
    fetch('/process-payment', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({
            patient_id: patientId,
            payment_amount: parseFloat(paymentAmount),
        }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.remaining_amount !== undefined) {
            remainingAmountField.value = `$${data.remaining_amount}`;
        } else {
            alert(data.error || 'An error occurred');
        }
    })
    .catch(error => {
        alert(error.message);
        remainingAmountField.value = '';
    });
});
    </script>
</body>
</html>