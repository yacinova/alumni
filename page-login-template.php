<?php

/**
 * Template Name: Login Page
 * Description: Page de connexion personnalisée pour les étudiants.
 */
acf_form_head();

// Add authentication filter to check user activation
add_filter('authenticate', function ($user, $username, $password) {
    if ($user instanceof WP_User) {
        // Get associated member post
        $args = array(
            'post_type' => 'membres',
            'meta_query' => array(
                array(
                    'key' => 'compte_associe',
                    'value' => $user->ID,
                    'compare' => '='
                )
            ),
            'posts_per_page' => 1
        );

        $member_query = new WP_Query($args);

        if ($member_query->have_posts()) {
            $member_query->the_post();
            $is_active = get_field('active', get_the_ID());
            wp_reset_postdata();

            if (!$is_active) {
                return new WP_Error('account_inactive', 'Votre compte n\'est pas encore activé. Veuillez contacter l\'administration.');
            }
        }

        // Return the user object if everything is okay
        return $user;
    }

    // Return the original value if it's not a WP_User object
    return $user;
}, 20, 3);

// Empêcher l'accès si l'utilisateur est déjà connecté
if (is_user_logged_in()) {
    wp_redirect(site_url('/dashboard-etudiant'));
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <!-- Back to Home Button -->
    <a href="<?php echo home_url('/'); ?>" class="back-home-btn">
        <span class="arrow">←</span>
        <span>Retourner à l'accueil</span>
    </a>

    <style>
        /* Modern Login Page Styles with Alumni ESG Brand Colors */
        :root {
            --alumni-navy: #0b1c39;
            --alumni-gold: #d4af37;
            --alumni-gold-light: #e9d282;
            --alumni-white: #ffffff;
            --alumni-gray: #f5f5f5;
            --alumni-text: #333333;
            --alumni-border: #eaeaea;
            --alumni-shadow: rgba(0, 0, 0, 0.05);
            --error-color: #e74c3c;
            --shadow-sm: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 6px 15px rgba(0, 0, 0, 0.15);
            --radius-sm: 6px;
            --radius-md: 8px;
            --transition-normal: 0.3s ease;
        }

        body {
            background: linear-gradient(135deg, var(--alumni-navy), #1d3462);
            margin: 0;
            padding: 0;
            font-family: 'Montserrat', Arial, sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-page {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        .login-container {
            max-width: 420px;
            width: 100%;
            margin: 0 auto;
            padding: 35px;
            background: var(--alumni-white);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-md);
            position: relative;
            overflow: hidden;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: var(--alumni-gold);
        }

        .login-container h1 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 30px;
            color: var(--alumni-navy);
            font-weight: 600;
            position: relative;
            padding-bottom: 15px;
        }

        .login-container h1::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: var(--alumni-gold);
        }

        .login-container .login-error {
            color: var(--alumni-white);
            background: var(--error-color);
            padding: 12px 15px;
            border-radius: var(--radius-sm);
            margin-bottom: 25px;
            text-align: center;
            font-weight: 500;
            box-shadow: var(--shadow-sm);
        }

        .login-container form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .login-container p {
            margin: 0;
            position: relative;
        }

        .login-container label {
            font-weight: 600;
            color: var(--alumni-navy);
            display: block;
            margin-bottom: 8px;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            padding: 12px 15px;
            border: 1px solid var(--alumni-border);
            border-radius: var(--radius-sm);
            font-size: 15px;
            width: 100%;
            transition: all var(--transition-normal);
        }

        .login-container input[type="text"]:focus,
        .login-container input[type="password"]:focus {
            border-color: var(--alumni-gold);
            outline: none;
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2);
        }

        .login-container input[type="submit"] {
            background: var(--alumni-gold);
            color: var(--alumni-navy);
            border: 2px solid var(--alumni-gold);
            padding: 14px;
            border-radius: var(--radius-sm);
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition-normal);
            margin-top: 10px;
        }

        .login-container input[type="submit"]:hover {
            background: var(--alumni-navy);
            color: var(--alumni-gold);
            border-color: var(--alumni-gold);
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
        }

        .login-container .login-remember {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 5px;
        }

        .login-container .login-remember input {
            margin: 0;
            width: 16px;
            height: 16px;
        }

        .login-container .login-remember label {
            font-weight: normal;
            color: var(--alumni-text);
            margin: 0;
        }

        /* Create Account Button Styles */
        .create-account-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: transparent;
            color: var(--alumni-navy);
            text-decoration: underline;
            padding: 10px 0;
            font-size: 14px;
            font-weight: 500;
            border: none;
            transition: all var(--transition-normal);
            margin-top: 20px;
            width: 100%;
            box-sizing: border-box;
        }

        .create-account-btn:hover {
            background: transparent;
            color: var(--alumni-gold);
            text-decoration: underline;
            transform: none;
            box-shadow: none;
        }

        .create-account-btn i {
            font-size: 14px;
        }

        .create-account-btn span {
            font-weight: 500;
        }

        /* Back to Home Button Styles */
        .back-home-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--alumni-white);
            color: var(--alumni-navy);
            text-decoration: none;
            padding: 10px 15px;
            border-radius: var(--radius-sm);
            font-size: 14px;
            font-weight: 600;
            border: 2px solid var(--alumni-white);
            transition: all var(--transition-normal);
            box-shadow: var(--shadow-sm);
            z-index: 10;
        }

        .back-home-btn:hover {
            background: var(--alumni-navy);
            color: var(--alumni-white);
            border-color: var(--alumni-navy);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            text-decoration: none;
        }

        .back-home-btn i {
            font-size: 14px;
        }

        .back-home-btn .arrow {
            font-size: 16px;
            font-weight: bold;
        }

        /* Mobile-Friendly Adjustments */
        @media (max-width: 768px) {
            .login-container {
                padding: 25px;
                width: 100%;
            }

            .login-container h1 {
                font-size: 24px;
            }

            .login-container input[type="text"],
            .login-container input[type="password"] {
                font-size: 16px;
                padding: 14px;
            }

            .login-container input[type="submit"] {
                padding: 15px;
                font-size: 16px;
            }
        }
    </style>

    <div class="login-page">
        <div class="login-container">
            <h1>Espace Lauréat</h1>

            <?php
            // Affiche les erreurs s'il y en a
            if (isset($_GET['login']) && $_GET['login'] === 'failed') {
                echo '<div class="login-error">⚠️ Identifiants incorrects. Veuillez réessayer.</div>';
            }

            // Display custom error for inactive account
            if (isset($_GET['account_inactive'])) {
                echo '<div class="login-error">⚠️ Votre compte n\'est pas encore activé. Veuillez contacter l\'administration.</div>';
            }

            // Affiche le formulaire de connexion
            wp_login_form([
                'redirect' => site_url('/dashboard-etudiant'),
                'label_username' => 'Email',
                'label_password' => 'Mot de passe',
                'label_log_in'   => 'Se connecter',
                'remember' => true
            ]);
            ?>

            <!-- Si vous n'avez pas de compte, vous pouvez vous inscrire ici -->
            <a href="<?php echo home_url('/adherer'); ?>" class="create-account-btn">
                <i class="fas fa-user-plus"></i>
                <span>Créer un compte</span>
            </a>
        </div>
    </div>

    <?php wp_footer(); ?>
</body>

</html>