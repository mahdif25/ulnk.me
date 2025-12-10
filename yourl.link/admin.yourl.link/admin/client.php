<?php
include 'main.php';
// Default input product values
// name,desc,logo,api,
$account = [
    'username' => '',
    'password' => '',
    'email' => '',
    'activation_code' => '',
    'rememberme' => '',
    'role' => 'Member',
    'registered' => date('Y-m-d\TH:i:s'),
    'last_seen' => date('Y-m-d\TH:i:s')
];
// If editing an account
if (isset($_GET['id'])) {
    // Get the account from the database
    $stmt = $pdo->prepare('SELECT * FROM clients WHERE id = ?');
    $stmt->execute([ $_GET['id'] ]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);
    // ID param exists, edit an existing account
    $page = 'Edit';
    if (isset($_POST['submit'])) {
        // Update the account
        $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $account['password'];
        $stmt = $pdo->prepare('UPDATE clients SET username = ?, password = ?, email = ?, activation_code = ?, rememberme = ?, role = ?, registered = ?, last_seen = ? WHERE id = ?');
        $stmt->execute([ $_POST['username'], $password, $_POST['email'], $_POST['activation_code'], $_POST['rememberme'], $_POST['role'], $_POST['registered'], $_POST['last_seen'], $_GET['id'] ]);
        header('Location: accounts.php?success_msg=2');
        exit;
    }
    if (isset($_POST['delete'])) {
        // Redirect and delete the account
        header('Location: accounts.php?delete=' . $_GET['id']);
        exit;
    }
} else {
    // Create a new account
	// name,desc,logo,api,
    $page = 'Create';
	$timo = time() ;
	if (isset($_POST['submit'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('INSERT IGNORE INTO clients 
(name, Description, logo, api_key, num_of_products, num_of_deals, time_	) VALUES (?,?,?,?,?,?,?)');
        $stmt->execute([ $_POST['name'], $_POST['desc'], $_POST['logo'], $_POST['api'], 0, 0, $timo ]);
        header('Location: accounts.php?success_msg=1');
        exit;
    }
}
?>
<?=template_admin_header($page . ' Account', 'accounts', 'manage')?>

<h2><?=$page?> Client</h2>

<div class="content-block">

    <form action="" method="post" class="form responsive-width-100">

        <label for="username">Client name</label>
        <input type="text" id="name" name="name" placeholder="Client" value="<?=$account['name']?>" required>

		<label for="rememberme">Description</label>
        <input type="text" id="desc" name="desc" placeholder="short note" value="<?=$account['Description']?>"  required>

        <label for="rememberme">Logo</label>
        <input type="text" id="logo" name="logo" placeholder="logo url" value="<?=$account['logo']?>"  required>

        <label for="rememberme">Api Key</label>
        <input type="text" id="api" name="api" placeholder="api" value="<?=$account['api_key']?>"  required>

        <div class="submit-btns">
            <input type="submit" name="submit" value="Submit">
            <?php if ($page == 'Edit'): ?>
            <input type="submit" name="delete" value="Delete" class="delete" onclick="return confirm('Are you sure you want to delete this account?')">
            <?php endif; ?>
        </div>

    </form>

</div>

<?=template_admin_footer()?>