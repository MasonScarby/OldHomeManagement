<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    @vite(['resources/js/app.js'])

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        input[type="text"] {
            width: 70%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 8px 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
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