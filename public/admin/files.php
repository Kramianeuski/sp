<?php
require __DIR__ . '/../../database/repository.php';
require __DIR__ . '/partials.php';

$uploadError = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    if ($file['error'] === UPLOAD_ERR_OK) {
        $filename = basename($file['name']);
        $targetPath = '/uploads/' . time() . '-' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);
        $destination = __DIR__ . '/..' . $targetPath;
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            db_execute(
                'INSERT INTO files (title, file_path, file_type, file_size) VALUES (?, ?, ?, ?)',
                [
                    $_POST['title'] ?: $filename,
                    $targetPath,
                    $file['type'],
                    (int) $file['size'],
                ]
            );
            header('Location: /admin/files.php');
            exit;
        }
        $uploadError = 'Не удалось сохранить файл.';
    } else {
        $uploadError = 'Ошибка загрузки файла.';
    }
}

$files = get_files();

admin_header('Файлы');
?>
<section class="card">
    <h2>Загрузка файлов</h2>
    <?php if ($uploadError) : ?>
        <p class="notice"><?= htmlspecialchars($uploadError) ?></p>
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data">
        <div class="form-grid">
            <div>
                <label>Название файла</label>
                <input type="text" name="title" placeholder="Паспорт SP01-0212">
            </div>
            <div>
                <label>Файл</label>
                <input type="file" name="file" required>
            </div>
        </div>
        <button class="button" type="submit">Загрузить</button>
    </form>
</section>
<section class="card">
    <h2>Файлы в системе</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Название</th>
            <th>Путь</th>
            <th>Тип</th>
            <th>Размер</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($files as $file) : ?>
            <tr>
                <td><?= htmlspecialchars($file['title']) ?></td>
                <td><?= htmlspecialchars($file['file_path']) ?></td>
                <td><?= htmlspecialchars($file['file_type']) ?></td>
                <td><?= number_format((int) $file['file_size'] / 1024, 1) ?> KB</td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>
<?php
admin_footer();
