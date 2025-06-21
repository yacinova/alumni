<?php
/**
 * Template Name: Page d'inscription
 * 
 * Template pour l'inscription des membres
 */


 /**
  * Template Name: Landing Page INSA Alumni
  * Description: Template personnalisé pour la page d'accueil INSA Alumni
  */
 
 // Chargement conditionnel du header selon que l'utilisateur est connecté ou non
 if (is_user_logged_in() && current_user_can('etudiant')) {
     get_template_part('header', 'etudiant');
 } else {
     get_header();
 }


// Get taxonomy terms
$localisations = get_terms([
    'taxonomy' => 'localisations',
    'hide_empty' => false,
]);

$categories_membre = get_terms([
    'taxonomy' => 'categories_membre',
    'hide_empty' => false,
]);

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register_member'])) {
    $errors = [];
    
    // Validate required fields
    $required_fields = [
        'nom' => 'Le nom est requis',
        'prenom' => 'Le prénom est requis',
        'email' => 'L\'email est requis',
        'password' => 'Le mot de passe est requis',
        'password_confirm' => 'La confirmation du mot de passe est requise',
        'date_naissance' => 'La date de naissance est requise',
        'localisation' => 'La localisation est requise',
        'category_membre' => 'La catégorie de membre est requise',
    ];

    foreach ($required_fields as $field => $message) {
        if (empty($_POST[$field])) {
            $errors[] = $message;
        }
    }

    // Validate email
    if (!empty($_POST['email']) && !is_email($_POST['email'])) {
        $errors[] = 'L\'adresse email n\'est pas valide';
    }

    // Check if email already exists
    if (!empty($_POST['email']) && email_exists($_POST['email'])) {
        $errors[] = 'Cette adresse email est déjà utilisée';
    }

    // Validate password match
    if ($_POST['password'] !== $_POST['password_confirm']) {
        $errors[] = 'Les mots de passe ne correspondent pas';
    }

    // If no errors, create the member and user
    if (empty($errors)) {
        // Create member post
        $member_data = [
            'post_type' => 'membres',
            'post_status' => 'publish',
        ];

        $member_id = wp_insert_post($member_data);

        if (!is_wp_error($member_id)) {
            // Update member fields
            update_field('nom', sanitize_text_field($_POST['nom']), $member_id);
            update_field('prenom', sanitize_text_field($_POST['prenom']), $member_id);
            update_field('email', sanitize_email($_POST['email']), $member_id);
            update_field('date_naissance', sanitize_text_field($_POST['date_naissance']), $member_id);
            update_field('telephone', sanitize_text_field($_POST['telephone']), $member_id);
            update_field('linkedin', esc_url($_POST['linkedin']), $member_id);

            // Set taxonomies
            if (!empty($_POST['localisation'])) {
                wp_set_object_terms($member_id, (int)$_POST['localisation'], 'localisations');
            }
            if (!empty($_POST['category_membre'])) {
                wp_set_object_terms($member_id, (int)$_POST['category_membre'], 'categories_membre');
            }

            // Create WP User
            $username = sanitize_user($_POST['prenom'] . '.' . $_POST['nom']);
            $counter = 1;
            $base_username = $username;
            
            while (username_exists($username)) {
                $username = $base_username . $counter;
                $counter++;
            }

            $user_id = wp_create_user(
                $username,
                $_POST['password'],
                sanitize_email($_POST['email'])
            );

            if (!is_wp_error($user_id)) {
                // Set user role
                $user = new WP_User($user_id);
                $user->set_role('etudiant');

                // Update user meta
                wp_update_user([
                    'ID' => $user_id,
                    'first_name' => sanitize_text_field($_POST['prenom']),
                    'last_name' => sanitize_text_field($_POST['nom'])
                ]);

                // Link user to member
                update_field('compte_associe', $user_id, $member_id);

                // Redirect to login page
                wp_redirect(home_url('/connexion-etudiant'));
                exit;
            }
        }
    }
}
?>

<style>
    :root {
    --alumni-navy: #0b1c39;
    --alumni-blue: #0066b2;
    --alumni-gold: #d4af37;
    --alumni-gold-light: #e9d282;
    --alumni-white: #ffffff;
    --alumni-gray: #f5f5f5;
    --alumni-text: #333333;
    --alumni-border: #eaeaea;
    --alumni-shadow: rgba(0, 0, 0, 0.05);
}

    .registration-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 30px;
        background: var(--alumni-white);
        box-shadow: 0 3px 10px var(--alumni-shadow);
        border-radius: 8px;
        border-top: 3px solid var(--alumni-gold);
    }

    .registration-container h1 {
        color: var(--alumni-navy);
        margin-bottom: 30px;
        text-align: center;
        font-size: 2rem;
    }

    .registration-form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .form-row {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .form-group {
        flex: 1;
        min-width: 250px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: var(--alumni-navy);
        font-weight: 600;
    }

    .form-group input {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        transition: all 0.3s ease;
    }

    .form-group input:focus {
        border-color: var(--alumni-gold);
        box-shadow: 0 0 5px rgba(212, 175, 55, 0.3);
        outline: none;
    }

    .form-group select {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        transition: all 0.3s ease;
        background-color: var(--alumni-white);
    }

    .form-group select:focus {
        border-color: var(--alumni-gold);
        box-shadow: 0 0 5px rgba(212, 175, 55, 0.3);
        outline: none;
    }

    .error-messages {
        background: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 4px;
    }

    .error-messages ul {
        margin: 0;
        padding-left: 20px;
    }

    .submit-button {
        background: var(--alumni-navy);
        color: var(--alumni-white);
        padding: 14px 28px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-top: 10px;
        width: 100%;
    }

    .submit-button:hover {
        background: var(--alumni-gold);
        transform: translateY(-2px);
    }

    .login-link {
        text-align: center;
        margin-top: 25px;
    }

    .login-link a {
        color: var(--alumni-gold);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .login-link a:hover {
        color: var(--alumni-navy);
    }

    /* Mobile-friendly styles */
    @media (max-width: 767px) {
        .registration-container {
            margin: 20px auto;
            padding: 20px 15px;
            width: 95%;
        }

        .registration-container h1 {
            font-size: 1.6rem;
        }

        .form-row {
            flex-direction: column;
            gap: 15px;
        }

        .form-group {
            width: 100%;
        }

        .submit-button {
            margin-top: 20px;
        }
    }
</style>

<div class="registration-container">
    <h1>Inscription Alumni ESG</h1>

    <?php if (!empty($errors)): ?>
        <div class="error-messages">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo esc_html($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="" class="registration-form">
        <div class="form-row">
            <div class="form-group">
                <label for="prenom">Prénom *</label>
                <input type="text" name="prenom" id="prenom" required 
                    value="<?php echo isset($_POST['prenom']) ? esc_attr($_POST['prenom']) : ''; ?>">
            </div>
            <div class="form-group">
                <label for="nom">Nom *</label>
                <input type="text" name="nom" id="nom" required
                    value="<?php echo isset($_POST['nom']) ? esc_attr($_POST['nom']) : ''; ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" name="email" id="email" required
                value="<?php echo isset($_POST['email']) ? esc_attr($_POST['email']) : ''; ?>">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="password">Mot de passe *</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-group">
                <label for="password_confirm">Confirmer le mot de passe *</label>
                <input type="password" name="password_confirm" id="password_confirm" required>
            </div>
        </div>

        <div class="form-group">
            <label for="date_naissance">Date de naissance *</label>
            <input type="date" name="date_naissance" id="date_naissance" required
                value="<?php echo isset($_POST['date_naissance']) ? esc_attr($_POST['date_naissance']) : ''; ?>">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="localisation">Localisation *</label>
                <select name="localisation" id="localisation" required>
                    <option value="">Sélectionnez votre localisation</option>
                    <?php foreach ($localisations as $loc): ?>
                        <option value="<?php echo esc_attr($loc->term_id); ?>" <?php selected(isset($_POST['localisation']) ? $_POST['localisation'] : '', $loc->term_id); ?>>
                            <?php echo esc_html($loc->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="category_membre">Catégorie de membre *</label>
                <select name="category_membre" id="category_membre" required>
                    <option value="">Sélectionnez votre catégorie</option>
                    <?php foreach ($categories_membre as $cat): ?>
                        <option value="<?php echo esc_attr($cat->term_id); ?>" <?php selected(isset($_POST['category_membre']) ? $_POST['category_membre'] : '', $cat->term_id); ?>>
                            <?php echo esc_html($cat->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="telephone">Téléphone</label>
            <input type="tel" name="telephone" id="telephone"
                value="<?php echo isset($_POST['telephone']) ? esc_attr($_POST['telephone']) : ''; ?>">
        </div>

        <div class="form-group">
            <label for="linkedin">Profil LinkedIn</label>
            <input type="url" name="linkedin" id="linkedin"
                value="<?php echo isset($_POST['linkedin']) ? esc_attr($_POST['linkedin']) : ''; ?>">
        </div>

        <div class="form-group">
            <button type="submit" name="register_member" class="submit-button">
                S'inscrire
            </button>
        </div>
    </form>

    <div class="login-link">
        <p>Déjà inscrit ? <a href="https://esg-alumni.ma/connexion-etudiant/">Connectez-vous</a></p>
    </div>
</div>


<?php 
// Chargement conditionnel du footer selon que l'utilisateur est connecté ou non
if (is_user_logged_in() && current_user_can('etudiant')) {
    get_template_part('footer', 'etudiant');
} else {
    get_footer();
}
?>
