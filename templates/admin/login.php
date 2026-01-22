<?php
ob_start();
?>
<div class="admin-card">
    <h1>Admin login</h1>
    <?php if ($error) : ?>
        <p class="admin-error">Invalid credentials</p>
    <?php endif; ?>
    <form method="post">
        <label>
            Username
            <input type="text" name="username" required>
        </label>
        <label>
            Password
            <input type="password" name="password" required>
        </label>
        <button type="submit">Sign in</button>
    </form>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
