<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>


<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Enter OTP</h2>
        <form action="{{ Route('verify-otp') }}" method="POST" class="flex justify-center">
            @csrf
            <div class="space-x-4">
                <input type="text" name="otp[]" maxlength="1"
                    class="w-12 h-12 text-center border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-lg"
                    required>
                <input type="text" name="otp[]" maxlength="1"
                    class="w-12 h-12 text-center border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-lg"
                    required>
                <input type="text" name="otp[]" maxlength="1"
                    class="w-12 h-12 text-center border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-lg"
                    required>
                <input type="text" name="otp[]" maxlength="1"
                    class="w-12 h-12 text-center border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-lg"
                    required>
            </div>

            <input type="hidden" value="{{ $email }}" name="email">
            <button type="submit" class="hidden"></button>
            <!-- Hidden button to allow form submission with Enter key -->
        </form>
        <p class="mt-6 text-center text-gray-600">
            Didn't receive the code?
            <a href="#" class="text-indigo-600 hover:underline">Resend</a>

        </p>

        <p class="mt-6 text-center text-gray-600">
            <a href="{{ Route('login') }}"
                class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900">back
                to Login Page</a>
        </p>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const inputs = document.querySelectorAll('input[type="text"]');

            inputs.forEach((input, index) => {
                input.addEventListener('input', () => {
                    // Move to the next input field if a digit is entered
                    if (input.value.length === 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }

                    // Automatically submit the form if all inputs are filled
                    if (index === inputs.length - 1 && input.value.length === 1) {
                        form.submit();
                    }
                });

                input.addEventListener('keydown', (event) => {
                    // Move to the previous input field if backspace is pressed and the current input is empty
                    if (event.key === 'Backspace' && input.value === '' && index > 0) {
                        inputs[index - 1].focus();
                    }
                });
            });
        });
    </script>

</body>

</html>
