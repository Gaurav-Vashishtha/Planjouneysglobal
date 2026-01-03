<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Change Password</title>
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
        
        .success {
            color: #27ae60;
            margin-bottom: 15px;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div class="login-box">
        <div class="login-header">
            <h2>Change Password</h2>
        </div>

        <div class="login-body">

            <?php if ($this->session->flashdata('success')): ?>
                <div class="success"><?php echo $this->session->flashdata('success'); ?></div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="error"><?php echo $this->session->flashdata('error'); ?></div>
            <?php endif; ?>

            <?php echo form_open('admin/changePassword'); ?>

                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" name="current_password" id="current_password" placeholder="Current Password">
                    <?php echo form_error('current_password', '<div class="error">', '</div>'); ?>
                </div>

                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" name="new_password" id="new_password" placeholder="New Password">
                    <?php echo form_error('new_password', '<div class="error">', '</div>'); ?>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm New Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm New Password">
                    <?php echo form_error('confirm_password', '<div class="error">', '</div>'); ?>
                </div>

                <button type="submit">Change Password</button>

            <?php echo form_close(); ?>
        </div>
    </div>

</body>
</html>
