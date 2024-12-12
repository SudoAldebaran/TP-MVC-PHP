<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="View/style/general.css" rel="stylesheet" type="text/css">
    <title>Liste des utilisateurs</title>
    <style>
        .edit-form input,
        .edit-form select {
            width: 100%;
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <section id="main-section">
        <div>
            <h2 class="center">List of Users</h2>
            <table class="user-list-table">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Admin</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users) && is_array($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <?php if ($_SESSION['user']['admin'] == 1 && $user['email'] !== $_SESSION['user']['email']): ?>
                                    <form action="index.php?ctrl=user&action=editUser" method="POST" class="edit-form">
                                        <input type="hidden" name="originalEmail" value="<?= htmlspecialchars($user['email']) ?>">
                                        <td>
                                            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                                        </td>
                                        <td>
                                            <input type="text" name="firstName" value="<?= htmlspecialchars($user['firstName']) ?>" required>
                                        </td>
                                        <td>
                                            <input type="text" name="lastName" value="<?= htmlspecialchars($user['lastName']) ?>" required>
                                        </td>
                                        <td>
                                            <select name="admin" style="width: 100px;">
                                                <option value="1" <?= (int)$user['admin'] === 1 ? 'selected' : '' ?>>Yes</option>
                                                <option value="0" <?= (int)$user['admin'] === 0 ? 'selected' : '' ?>>No</option>
                                            </select>
                                        </td>
                                        <td>
                                            <button type="submit">Modifier</button>
                                            <form action="index.php?ctrl=user&action=deleteUser" method="POST" style="display:inline;">
                                                <input type="hidden" name="userEmail" value="<?= htmlspecialchars($user['email']) ?>">
                                                <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">Supprimer</button>
                                            </form>
                                        </td>
                                    </form>
                                <?php else: ?>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td><?= htmlspecialchars($user['firstName']) ?></td>
                                    <td><?= htmlspecialchars($user['lastName']) ?></td>
                                    <td><?= $user['admin'] ? 'Yes' : 'No' ?></td>
                                    <td>
                                        <?php if ($_SESSION['user']['admin'] == 1 && $user['email'] !== $_SESSION['user']['email']): ?>
                                            <form action="index.php?ctrl=user&action=deleteUser" method="POST">
                                                <input type="hidden" name="userEmail" value="<?= htmlspecialchars($user['email']) ?>">
                                                <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">Supprimer</button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="center">No users found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</body>

</html>