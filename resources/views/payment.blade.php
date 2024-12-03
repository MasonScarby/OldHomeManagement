<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    @vite(['resources/js/app.js'])


    <style>
        body {
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .form-container {
            width: 350px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .form-container h3 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .form-container label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
            color: #555;
        }
        .form-container input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-container button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .form-container button.submit {
            background-color: #4CAF50;
            color: #fff;
        }
        .form-container button.pay {
            background-color: #007BFF;
            color: #fff;
            margin-top: 10px;
        }
        .form-container button:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    @include('navbar')

    <div class="form-container">
        <h3>Payment Management</h3>
        
        <!-- Form to store payment -->
        <form action="{{ route('payments.store') }}" method="POST" id="paymentForm">
            @csrf
            <label for="patient_id">Patient ID:</label>
            <input type="text" id="patient_id" name="user_id" placeholder="Enter Patient ID" required>
            
            <label for="total_due">Total Due:</label>
            <input type="text" id="total_due" name="total_due" placeholder="Auto-calculated" readonly>
            
            <button type="submit" class="submit">Submit</button>
        </form>

        <!-- Form to handle new payment -->
        <form action="{{ route('payments.pay') }}" method="POST" id="paymentPayForm">
            @csrf
            <label for="new_payment">New Payment:</label>
            <input type="text" id="new_payment" name="new_payment" placeholder="Enter Payment Amount" required>
            
            <button type="submit" class="pay">Submit Payment</button>
        </form>
    </div>
</body>
</html>
