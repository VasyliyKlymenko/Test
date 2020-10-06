<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Calls History Upload Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /*to block input during form processing*/
        .disable {
            cursor: not-allowed;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <form id="calls-report-form" action="/get-calls-report" method="post" enctype="multipart/form-data">
        <input id="file-select-button" type="file" name="file" required>
        <button id="submit-button" type="submit" class="button-load">
            Submit
        </button>
    </form>
    <script>
        // Error handling part should be in base template for real
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);

        if (urlParams.has('error')) {
            alert (urlParams.get('error'))
        }

        document.getElementById("calls-report-form").addEventListener("submit", addSpinner);

        // Disable file select button, disable submit button and add spinner
        function addSpinner() {
            let submitButton = document.getElementById("submit-button");
            let fileSelectButton = document.getElementById("file-select-button");

            submitButton.innerHTML = '<i class="fa fa-refresh fa-spin"></i> Submit';
            submitButton.disabled = true;
            fileSelectButton.classList.add("disable");
        }
    </script>
</body>
</html>
