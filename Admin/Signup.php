<?php
require_once("database.php");

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_POST["signup"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $fullname = isset($_POST["fullname"]) ? trim($_POST["fullname"]) : null;
    $email = isset($_POST["email"]) ? filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL) : null;
    $password = isset($_POST["password"]) ? trim($_POST["password"]) : null;
    $confirmPassword = isset($_POST["confirmpassword"]) ? trim($_POST["confirmpassword"]) : null;
    $error = null;
    function validatePassword($password)
    {
        if (strlen($password) < 8) {
            return "Password must be at least 8 characters long and must contain at least one number and one special character.";
        }
        if (!preg_match('/\d/', $password)) {
            return "Password must be at least 8 characters long and must contain at least one number and one special character.";
        }
        if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
            return "Password must be at least 8 characters long and must contain at least one number and one special character.";
        }
        return null;
    }
    // Validate input
    if (empty($fullname) || empty($email) || empty($password) || empty($confirmPassword)) {
        $error = "All fields are required.";
    } elseif (!$email) {
        $error = "Invalid email format.";
    } elseif ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        // Validate password using the function
        $error = validatePassword($password);
    }

    // Check for existing email
    if (!$error) {
        try {
            $checkEmailQuery = "SELECT user_id FROM users WHERE email = :email";
            $checkStmt = $conn->prepare($checkEmailQuery);
            $checkStmt->bindParam(":email", $email);
            $checkStmt->execute();

            if ($checkStmt->rowCount() > 0) {
                $error = "Email already exists. Please use a different email.";
            }
        } catch (PDOException $e) {
            $error = "Error checking email: " . $e->getMessage();
        }
    }

    // Proceed with registration if no errors
    if (!$error) {
        try {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            

            $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":name", $username);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $hashedPassword);
            $status = $stmt->execute();

            if ($status) {
                $_SESSION['signupSuccess'] = "User $username has been registered successfully.";
                header("Location: loginform.php");
                exit;
            } else {
                $error = "Failed to register. Please try again.";
            }
        } catch (PDOException $e) {
            $error = "Error registering user: " . $e->getMessage();
        }
    }

    // Display error if any
    if ($error) {
        echo "<p>Error: $error</p>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Sign up Form</title>
</head>

<body>
    <section class="bg-gray-50 min-h-screen flex items-center justify-center bg-[url('../images/Athle.png')] bg-cover bg-center">
        <div>
            <div class="bg-slate-800 border-slate-400 rounded-md p-8 shadow-lg backdrop-filter backdrop-blur-sm bg-opacity-30 relative">
                <h1 class="text-4xl text-whitefront-bold text-center mb-6 text-white">Sign up</h1>
                <form action="#" method="POST" enctype="multipart/form-data">
                    <div class="relative my-4 pb-3">
                        <input name="fullname" type="text" class="block w-72 py-2.3 px-0 text-sm text-white bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:foucs:border-blue-500 focus:outline-none focus:ring-0 focus:text-white focus:border-red-600 peer" placeholder="">
                        <label for="" class="text-gray-400 absolute text-sm duration-300 transform -translate-y-6 scale-75 top-0 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-red-500 peer-focus:dark:text-red-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Full Name</label>
                    </div>
                    <!-- <div class="relative my-4 pb-3">
                    <input type="text" class="block w-72 py-2.3 px-0 text-sm text-white bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:foucs:border-blue-500 focus:outline-none focus:ring-0 focus:text-white focus:border-red-600 peer" placeholder="">
                    <label for="" class="text-gray-400 absolute text-sm duration-300 transform -translate-y-6 scale-75 top-0  -z-10 origin-[0] peer-focus:left-0 peer-focus:text-red-500 peer-focus:dark:text-red-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Last Name</label>
                </div> -->
                    <div class="relative my-4 pb-3">
                        <input type="email" name="email" class="block w-72 py-2.3 px-0 text-sm text-white bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:foucs:border-blue-500 focus:outline-none focus:ring-0 focus:text-white focus:border-red-600 peer" placeholder="">
                        <label for="" class="text-gray-400 absolute text-sm duration-300 transform -translate-y-6 scale-75 top-0  -z-10 origin-[0] peer-focus:left-0 peer-focus:text-red-500 peer-focus:dark:text-red-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Your Email</label>
                    </div>
                    <div class="relative my-4 pb-3">
                        <input type="password" name="password" class="block w-72 py-2.3 px-0 text-sm text-white bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:foucs:border-blue-500 focus:outline-none focus:ring-0 focus:text-white focus:border-red-600 peer" placeholder="">
                        <label for="" class="text-gray-400 absolute text-sm duration-300 transform -translate-y-6 scale-75 top-0  -z-10 origin-[0] peer-focus:left-0 peer-focus:text-red-500 peer-focus:dark:text-red-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Password</label>
                    </div>
                    <div class="relative my-4 pb-3">
                        <input type="password" name="confirmpassword" class="block w-72 py-2.3 px-0 text-sm text-white bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:foucs:border-blue-500 focus:outline-none focus:ring-0 focus:text-white focus:border-red-600 peer" placeholder="">
                        <label for="" class="text-gray-400 absolute text-sm duration-300 transform -translate-y-6 scale-75 top-0  -z-10 origin-[0] peer-focus:left-0 peer-focus:text-red-500 peer-focus:dark:text-red-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Confrim Password</label>
                    </div>
                    <div>
                        <span class="text-gray-400">Already have an account? <a href="loginform.php">Login</a></span>
                        <button name="signup" type="submit" class="w-full mb-4 text-[18px] mt-6 rounded-full bg-white text-red-500 hover:bg-red-800 hover:text-gray-300 py-2 transition-colors duration-400">Sign up</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>

</html>