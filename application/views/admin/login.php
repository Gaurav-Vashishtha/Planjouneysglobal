<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #f8f9fa url('https://www.toptal.com/designers/subtlepatterns/uploads/cartographer.png') repeat;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            background: #fff;
            width: 350px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            overflow: hidden;
            text-align: center;
        }

        .login-header {
            background: #fff;
            padding: 25px 20px 10px;
            border-bottom: 1px solid #eee;
        }

        .login-header h2 {
            font-size: 22px;
            color: #333;
            font-weight: 600;
        }

        .login-body {
            padding: 25px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            font-size: 14px;
            font-weight: 600;
            display: block;
            margin-bottom: 6px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            background-color: #f4f8ff;
        }

        button {
            width: 100%;
            background: #2f3338;
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 5px;
            font-size: 15px;
            cursor: pointer;
            font-weight: 600;
            transition: 0.3s;
        }

        button:hover {
            background: #1d1f21;
        }

        .error {
            color: #e74c3c;
            margin-bottom: 15px;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div class="login-box">
        <div class="login-header">
            <h2>Admin Login</h2>
        </div>

        <div class="login-body">
            <?php if ($this->session->flashdata('error')): ?>
                <div class="error"><?php echo $this->session->flashdata('error'); ?></div>
            <?php endif; ?>

            <?php echo form_open('admin/login'); ?>

                <div class="form-group">
                    <label for="email">Email ID</label>
                    <input type="text" name="email" value="<?php echo set_value('email'); ?>" placeholder="username">
                    <?php echo form_error('email'); ?>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" placeholder="password">
                    <?php echo form_error('password'); ?>
                </div>

                <button type="submit">Login</button>

            <?php echo form_close(); ?>
        </div>
    </div>

</body>
</html>

