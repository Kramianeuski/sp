<?php
require __DIR__ . '/../../database/repository.php';
require __DIR__ . '/partials.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'create') {
        db_execute('INSERT INTO redirects (source, target, status_code) VALUES (?, ?, ?)', [
            $_POST['source'],
            $_POST['target'],
            (int) $_POST['status_code'],
        ]);
    }

    if ($_POST['action'] === 'update') {
        foreach ($_POST['redirects'] as $id => $row) {
            db_execute('UPDATE redirects SET source = ?, target = ?, status_code = ? WHERE id = ?', [
                $row['source'],
                $row['target'],
                (int) $row['status_code'],
                (int) $id,
            ]);
        }
    }

    header('Location: /admin/redirects.php');
    exit;
}

$redirects = db_fetch_all('SELECT id, source, target, status_code FROM redirects ORDER BY id ASC');

admin_header('Редиректы');
?>
<section class="card">
    <h2>Правила редиректов</h2>
    <form method="post">
        <input type="hidden" name="action" value="update">
        <table class="table">
            <thead>
            <tr>
                <th>Source</th>
                <th>Target</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($redirects as $redirect) : ?>
                <tr>
                    <td><input type="text" name="redirects[<?= (int) $redirect['id'] ?>][source]" value="<?= htmlspecialchars($redirect['source']) ?>"></td>
                    <td><input type="text" name="redirects[<?= (int) $redirect['id'] ?>][target]" value="<?= htmlspecialchars($redirect['target']) ?>"></td>
                    <td><input type="number" name="redirects[<?= (int) $redirect['id'] ?>][status_code]" value="<?= (int) $redirect['status_code'] ?>"></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <button class="button" type="submit">Сохранить</button>
    </form>
</section>
<section class="card">
    <h2>Добавить редирект</h2>
    <form method="post">
        <input type="hidden" name="action" value="create">
        <div class="form-grid">
            <div>
                <label>Source</label>
                <input type="text" name="source" placeholder="/ru/old-page/">
            </div>
            <div>
                <label>Target</label>
                <input type="text" name="target" placeholder="/ru/new-page/">
            </div>
            <div>
                <label>Status code</label>
                <input type="number" name="status_code" value="301">
            </div>
        </div>
        <button class="button" type="submit">Добавить</button>
    </form>
</section>
<?php
admin_footer();
