<?php
/**
 * The template for displaying the footer.
 *
 * Ce footer bleu sera utilisé pour toutes les pages du site.
 *
 * @package HelloElementorChild
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<footer class="alumni-footer">
    <div class="footer-container">
        <div class="footer-top">
            <div class="footer-col footer-about">
                <h3>À propos</h3>
                <p>Alumni ESG Maroc est le réseau des anciens et actuels étudiants de l'ESG au Maroc. Notre communauté favorise les échanges professionnels et l'entraide entre tous les membres.</p>
                <div class="footer-logo">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo.png" alt="Alumni ESG Maroc">
                </div>
            </div>

            <div class="footer-col footer-links">
                <h3>Liens rapides</h3>
                <ul>
                    <li><a href="<?php echo esc_url(site_url('/')); ?>">Accueil</a></li>
                    <li><a href="<?php echo esc_url(site_url('/liste-des-evenements')); ?>">Événements</a></li>
                    <li><a href="<?php echo esc_url(site_url('/entreprises-partenaires')); ?>">Entreprises</a></li>
                    <li><a href="<?php echo esc_url(site_url('/offres-emploi')); ?>">Offres d'emploi</a></li>
                    <li><a href="<?php echo esc_url(site_url('/annuaire-alumni')); ?>">Annuaire</a></li>
                    <li><a href="<?php echo esc_url(site_url('/qui-sommes-nous')); ?>">Qui sommes-nous</a></li>
                </ul>
            </div>

            <div class="footer-col footer-contact">
                <h3>Contact</h3>
                <p><i class="fas fa-map-marker-alt"></i> 12 Rue Sabri Boujemaa, Casablanca</p>
                <p><i class="fas fa-envelope"></i> contact@esg-alumni.ma</p>
                <p><i class="fas fa-phone"></i> +212 5XX-XXXXXX</p>
            </div>
        </div>

        <div class="footer-middle">
            <div class="social-icons">
                <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="footer-legal">
                <a href="#">Mentions légales</a>
                <a href="#">Politique de confidentialité</a>
                <a href="#">Conditions d'utilisation</a>
            </div>
            <p class="copyright">&copy; <?php echo date('Y'); ?> Alumni ESG Maroc. Tous droits réservés.</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

<?php // Styles moved to css/footer-public.css ?>

</body>
</html>