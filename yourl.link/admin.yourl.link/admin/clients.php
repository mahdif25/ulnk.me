<?php
include 'main.php';

// Prepare accounts query
$stmt = $pdo->prepare('SELECT * FROM clients');
$stmt->execute();
// Retrieve query results
$accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Delete account
if (isset($_GET['delete'])) {
    // Delete the account
    $stmt = $pdo->prepare('DELETE FROM accounts WHERE id = ?');
    $stmt->execute([ $_GET['delete'] ]);
    header('Location: accounts.php?success_msg=3');
    exit;
}
// Handle success messages
if (isset($_GET['success_msg'])) {
    if ($_GET['success_msg'] == 1) {
        $success_msg = 'Account created successfully!';
    }
    if ($_GET['success_msg'] == 2) {
        $success_msg = 'Account updated successfully!';
    }
    if ($_GET['success_msg'] == 3) {
        $success_msg = 'Account deleted successfully!';
    }
}
// Create URL
$url = 'accounts.php?search=' . $search . '&status=' . $status . '&activation=' . $activation . '&role=' . $role;
?>
<?=template_admin_header('Accounts', 'accounts', 'view')?>

<h2>Accounts</h2>

<?php if (isset($success_msg)): ?>
<div class="msg success">
    <i class="fas fa-check-circle"></i>
    <p><?=$success_msg?></p>
    <i class="fas fa-times"></i>
</div>
<?php endif; ?>

<div class="content-header links responsive-flex-column">
    <a href="client.php">Create Account</a>

</div>

<div class="content-block">
    <div class="table">
        <table>
            <thead>
                <tr>
                    <td>#</td>
                    <td>Client</td>
                    <td class="responsive-hidden">Brand</td>
                    <td class="responsive-hidden">Api Key</td>
                    <td class="responsive-hidden">Products</td>
                    <td class="responsive-hidden">Deals</td>
                    <td class="responsive-hidden">Created</td>
					<td class="responsive-hidden">Option</td>
                </tr>
            </thead>
            <tbody>
                <?php if (!$accounts): ?>
                <tr>
                    <td colspan="8" style="text-align:center;">There are no accounts</td>
                </tr>
                <?php endif; ?>
                <?php foreach ($accounts as $account): ?>
                <tr>
					<td><?=$account['id']?></td>
                    <td><?=$account['name']?></td> 
                    <td class="responsive-hidden"><a href="<?=$account['logo']?>">Logo</a></td>
                    <td class="responsive-hidden"><?=substr($account['api_key'], 0, 9)?>....</td>
                    <td class="responsive-hidden"><?=$account['num_of_products']?></td>
                    <td class="responsive-hidden"><?=$account['num_of_deals']?></td>
                    <td class="responsive-hidden"><?=date('m/d/Y H:i:s', $account['time_'])?></td>
                    <td>
                        <a href="client.php?id=<?=$account['id']?>">Edit</a>
                        <a href="client.php?delete=<?=$account['id']?>" onclick="return confirm('Are you sure you want to delete this account?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<br>

<?=template_admin_footer()?>