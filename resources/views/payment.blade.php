<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    @vite(['resources/js/app.js'])

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="payment">
    @include('navbar')


    <div class="page-container">
        <h1>Payment</h1>


        <div class="main-box">
            <div id="error-message" style="color: red; display: none;" class="error"></div>

            <form id="paymentForm" class="form">
                @csrf
                <div class="row">
                    <label for="patient_id">Patient ID:</label>
                    <input type="number" id="patient_id" name="patient_id" placeholder="Enter Patient ID" required>
                    <button type="button" id="fetchAdmissionDate" class="btn-action">Fetch & Calculate</button>
                </div>
    
                <label for="admission_date"></label>
                <input type="hidden" id="admission_date" name="admission_date" placeholder="Auto-fetched" readonly>
    
                <label for="total_due">Total Due:</label>
                <input type="text" id="total_due" name="total_due" placeholder="Auto-calculated" readonly required>
    
            </form>
    
            <form id="pay">
                @csrf
                <div class="row">
                    <label for="payment_amount">Payment Amount:</label>
                    <input type="text" id="payment_amount" name="payment_amount" placeholder="Enter Payment Amount" required>
                    <button type="button" id="processPayment" class="btn-action">Pay</button>
                </div>
    
                <label for="remaining_amount">Remaining Amount:</label>
                <input type="text" id="remaining_amount" name="remaining_amount" placeholder="Auto-calculated" readonly>
            </form>
        </div>
    </div>

    @include('footer')

    <script>
        function showError(message) {
            const errorMessageDiv = document.getElementById('error-message');
            errorMessageDiv.textContent = message;
            errorMessageDiv.style.display = 'block';
        }

        document.getElementById('fetchAdmissionDate').addEventListener('click', function () {
            const patientId = document.getElementById('patient_id').value;
            const admissionDateField = document.getElementById('admission_date');
            const totalDueField = document.getElementById('total_due');
            const errorMessageDiv = document.getElementById('error-message');

            // Hide previous error message
            errorMessageDiv.style.display = 'none';

            if (!patientId) {
                showError('Please enter the patient ID.');
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
                totalDueField.value = `$${data.total_due}`;  // Ensure total_due is set in the input field
            })
            .catch(error => {
                showError(error.message);
                admissionDateField.value = '';
                totalDueField.value = '';
            });
        });

        document.getElementById('processPayment').addEventListener('click', function () {
            const patientId = document.getElementById('patient_id').value;
            const paymentAmount = document.getElementById('payment_amount').value;
            const totalDue = document.getElementById('total_due').value;
            const remainingAmountField = document.getElementById('remaining_amount');
            const errorMessageDiv = document.getElementById('error-message');

            // Hide previous error message
            errorMessageDiv.style.display = 'none';

            if (!patientId || !paymentAmount || !totalDue) {
                showError('Please enter both patient ID, payment amount, and ensure total due is calculated.');
                return;
            }

            if (isNaN(paymentAmount) || parseFloat(paymentAmount) <= 0) {
                showError('Please enter a valid payment amount.');
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
                    showError(data.error || 'An error occurred');
                }
            })
            .catch(error => {
                showError(error.message);
                remainingAmountField.value = '';
            });
        });
    </script>
</body>
</html>
