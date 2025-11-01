<?php
include_once './utils/header.php';
?>

<main class="content-padding py-5">
    <section class="CTA py-5 content-padding d-flex flex-column align-items-center gap-3">
        <h1 class="fs-custom-1 fw-medium mb-3 text-center">Ready To Swap?</h1>
    </section>

    <section class="choice py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <ul class="d-flex list-unstyled p-0 m-0">
                        <li class="w-50"><button class="btn w-100 border rounded-0 btn-hover btn-primary" id="login-btn" onclick="showLogin()">Login</button></li>
                        <li class="w-50"><button class="btn w-100 border rounded-0 btn-hover" id="register-btn" onclick="showRegister()">Register</button></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <div class="form">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <form action="auth.php" method="post" id="login-form">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label fs-4">Email address</label>
                            <input type="email" class="form-control py-2" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter your email">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label fs-4">Password</label>
                            <input type="password" class="form-control py-2" id="exampleInputPassword1" placeholder="Enter your password">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-1 fs-3">Login</button>
                    </form>

                    <form action="auth.php" method="post" id="register-form" style="display: none;">
                        <div class="mb-3">
                            <label for="registerEmail" class="form-label fs-4">Email address</label>
                            <input type="email" class="form-control py-2" id="registerEmail" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="registerPassword1" class="form-label fs-4">Password</label>
                            <input type="password" class="form-control py-2" id="registerPassword1">
                        </div>
                        <div class="mb-3">
                            <label for="registerPassword2" class="form-label fs-4">Confirm Password</label>
                            <input type="password" class="form-control py-2" id="registerPassword2">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-1 fs-3">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
include_once './utils/footer.php';
?>