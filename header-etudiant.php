<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php // Styles moved to css/header-etudiant.css ?>
</head>

<body <?php body_class('etudiant-zone'); ?>>

    <header class="etudiant-header">
        <div class="header-container">
            <div class="logo-container">
                <a href="<?php echo esc_url(site_url('/dashboard-etudiant')); ?>" class="logo-link">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo.png" alt="Alumni ESG Maroc" class="logo-img">
                    <h1 class="site-title">
                        Espace Lauréats
                    </h1>
                </a>
            </div>

            <button class="mobile-menu-toggle" aria-label="Toggle menu">
                <i class="fas fa-bars"></i>
            </button>

            <?php if (is_user_logged_in() && current_user_can('etudiant')) : ?>
                <nav class="user-navigation">
                    <a href="<?php echo esc_url(site_url('/dashboard-etudiant/')); ?>" class="hover-grow dashboard-btn">
                        <i class="fas fa-tachometer-alt"></i> <span>Tableau de bord</span>
                    </a>

                    <a href="<?php echo esc_url(site_url('/mon-profil-etudiant')); ?>" class="hover-grow profile-btn">
                        <i class="fas fa-user-graduate"></i> <span>Mon Profil</span>
                    </a>

                    <a href="<?php echo esc_url(wp_logout_url(site_url('/connexion-etudiant'))); ?>" class="hover-grow logout-btn">
                        <i class="fas fa-sign-out-alt"></i> <span>Déconnexion</span>
                    </a>
                </nav>
            <?php endif; ?>
        </div>
    </header>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
        const userNavigation = document.querySelector('.user-navigation');
        
        if (mobileMenuToggle && userNavigation) {
            mobileMenuToggle.addEventListener('click', function() {
                userNavigation.classList.toggle('mobile-open');
                mobileMenuToggle.classList.toggle('active');
            });
        }
    });
    </script>
</body>
</html>