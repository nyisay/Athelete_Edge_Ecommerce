<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once "database.php";

if (isset($_POST["login"]) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $email = isset($_POST["email"]) ? filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL) : null;
    $password = isset($_POST["password"]) ? trim($_POST["password"]) : null;

    if (!$email || empty($password)) {
        $error = "Please provide a valid email and password.";
    } else {
        try {
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if (password_verify($password, $user['password'])) {
                    session_start();
                    $_SESSION['logged_in'] = true;
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['role'] = $user['role'];
                    if ($user['role'] == "admin") {
                        $_SESSION['adminLoginSuccess'] = "Admin Login Success!";
                        $_SESSION['logged_in'] = true;
                        header("Location: ../Admin/viewproduct.php");
                        exit;
                    } else {
                        $_SESSION['userLoginSuccess'] = "Login Success!";
                        header("Location: home.php");
                        exit;
                    }
                } else {
                    $error = "Invalid email or password.";
                }
            } else {
                $error = "Invalid email or password.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?> 

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login Form</title>
</head>

<body>
    <section class="bg-gray-50 min-h-screen flex items-center justify-center bg-[url('../images/Athle.png')] bg-cover bg-center">
        <!-- login container -->
        <div class="bg-gray-100 bg-opacity-50 backdrop-blur-sm flex rounded-2xl shadow-lg max-w-3xl p-5 items-center">

            <!-- form -->
            <div class="md:w-1/2 px-14">
                <h2 class="font-bold text-2xl">Login</h2>
                <!-- <p class="text-sm mt-4">If you already a member, log in.</p> -->

                <form action="#" method="POST" class="flex flex-col gap-4">
                    <input class="p-2 mt-8 rounded-2xl border" type="text" name="email" placeholder="Email" id="">
                    <div class="relative">
                        <input class="p-2 rounded-2xl border w-full" type="password" name="password" placeholder="Password" id="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" class="bi bi-eye absolute top-1/2 right-3 -translate-y-1/2" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 
                            s8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                        </svg>
                    </div>
                    <button name="login" class="bg-[red] rounded-xl text-white py-2">Log in</button>
                </form>

                <!-- <div class="mt-10 grid grid-cols-3 items-center text-gray-400">
                    <hr class="border-gray-400">
                    <p class="text-center text-sm">Or</p>
                    <hr class="border-gray-400">
                </div> -->

                <p class="mt-5 text-xs border-b border-gray-400 py-4">Forgot your password?</p>

                <div class="mt-3 text-md flex justify-between items-center">
                    <p>Don't have an account?</p>
                    <button class="py-2 px-5 bg-white border rounded-r-xl text-red-500 hover:bg-red-800 hover:text-gray-300 transition-colors duration-400"><a href="Signup.php">Register</a></button>
                </div>
                
            </div>

            <!-- image -->
            <div class="w-1/2 p-5">
                <img class="rounded-2xl shadow-lg from-blue-400 via-purple-500 to-pink-500 
                transform hover:scale-105 transition-all duration-300" src="/images/poster.jpg" alt="">
            </div>

        </div>

    </section>
</body>

</html>