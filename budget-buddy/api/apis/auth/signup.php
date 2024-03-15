<?php
// Function to handle signup process
function signupHandler()
{
    global $this;
    if (
        $this->get_request_method() == "POST" and
        isset($this->_request["username"]) and
        isset($this->_request["email"]) and
        isset($this->_request["password"])
    ) {
        $username = $this->_request["username"];
        $email = $this->_request["email"];
        $password = $this->_request["password"];

        try {
            $s = new Signup($username, $password, $email);
            $userid = $s->getInsertID();
            return "<h1>Login Successful!</h1><p>Your user ID is: $userid</p>";
        } catch (Exception $e) {
            return "<h1>Login Failed</h1><p>Error: " .
                $e->getMessage() .
                "</p>";
        }
    } else {
        return "<h1>Bad Request</h1><p>Error: Bad request</p>";
    }
}

// Call the signup handler function
$htmlResponse = signupHandler();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Response</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Signup Response
                    </div>
                    <div class="card-body">
                        <?php echo $htmlResponse; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
