<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="View/style/general.css" rel="stylesheet" type="text/css">
    <title>Liste des utilisateurs</title>
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
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['firstName']) ?></td>
                            <td><?= htmlspecialchars($user['lastName']) ?></td>
                            <td><?= $user['admin'] ? 'Yes' : 'No' ?></td>
                            <td>
                                <?php 
                                // Vérifier si l'utilisateur connecté est admin 
                                // ET que le compte à supprimer n'est pas le sien
                                if ($_SESSION['user']['admin'] == 1 && 
                                    $user['email'] !== $_SESSION['user']['email']): 
                                ?>
                                    <form action="index.php?ctrl=user&action=deleteUser" method="POST">
                                        <input type="hidden" name="userEmail" value="<?= htmlspecialchars($user['email']) ?>">
                                        <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">Supprimer</button>
                                    </form>
                                <?php endif; ?>
                            </td>
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