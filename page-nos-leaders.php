<?php
/**
 * Template Name: Landing Page Alumni ESG
 * Description: Template personnalisé pour la page d'accueil Alumni ESG Maroc
 */

// Chargement conditionnel du header selon que l'utilisateur est connecté ou non
if (is_user_logged_in() && current_user_can('etudiant')) {
    get_template_part('header', 'etudiant');
} else {
    get_header();
}
?>


<style>
    :root {
    --alumni-navy: #0b1c39;
    --alumni-gold: #d4af37;
    --alumni-gold-light: #e9d282;
    --alumni-white: #ffffff;
    --alumni-gray: #f5f5f5;
    --alumni-text: #333333;
    --alumni-border: #eaeaea;
    --alumni-shadow: rgba(0, 0, 0, 0.05);
}

/* Global Styles */
.alumni-landing-page {
    font-family: 'Montserrat', Arial, sans-serif;
    color: var(--alumni-text);
    line-height: 1.6;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.btn {
    display: inline-block;
    padding: 12px 24px;
    border-radius: 4px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    border: 2px solid transparent;
    cursor: pointer;
}

.btn-primary {
    background-color: var(--alumni-gold);
    color: var(--alumni-navy);
    border-color: var(--alumni-gold);
}

.btn-primary:hover {
    background-color: var(--alumni-navy);
    color: var(--alumni-gold);
    border-color: var(--alumni-gold);
}

.btn-secondary {
    background-color: var(--alumni-navy);
    color: var(--alumni-gold);
    border-color: var(--alumni-navy);
}

.btn-secondary:hover {
    background-color: transparent;
    color: var(--alumni-navy);
    border-color: var(--alumni-navy);
}

.btn-outline {
    background-color: transparent;
    color: var(--alumni-navy);
    border-color: var(--alumni-navy);
}

.btn-outline:hover {
    background-color: var(--alumni-navy);
    color: var(--alumni-white);
}

.btn-restricted {
    background-color: #e9e9e9;
    color: #777;
    border-color: #d5d5d5;
}

.btn-restricted:hover {
    background-color: #f2f2f2;
}

.section {
    padding: 60px 0;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 40px;
    border-bottom: 2px solid var(--alumni-gold);
    padding-bottom: 15px;
}

.section-header h2 {
    font-size: 28px;
    color: var(--alumni-navy);
    margin: 0;
    position: relative;
}

.view-all {
    color: var(--alumni-gold);
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.view-all:hover {
    color: var(--alumni-navy);
    text-decoration: underline;
}

/* Hero Section */
.hero-section {
    background-color: var(--alumni-navy);
    color: var(--alumni-white);
    padding: 100px 0;
    position: relative;
    display: flex;
    justify-content: center;  /* centre horizontalement */
    align-items: center;      /* centre verticalement */
    min-height: 100vh;        /* hauteur de la section = 100% de l'écran */
    text-align: center;
}

.hero-content {
    max-width: 800px;
}


.alumni-logo {
    max-width: 200px;
    margin: 0 auto 30px;
}

.alumni-logo img {
    max-width: 100%;
    height: auto;
}

.hero-section h1 {
    font-size: 42px;
    font-weight: 700;
    margin-bottom: 20px;
    color: var(--alumni-gold);
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
}

.hero-section .subtitle {
    font-size: 18px;
    margin-bottom: 40px;
}

.cta-buttons {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.cta-separator {
    color: var(--alumni-gold);
    margin: 0 5px;
}

.welcome-back {
    background-color: rgba(212, 175, 55, 0.1);
    border: 1px solid rgba(212, 175, 55, 0.3);
    padding: 20px;
    border-radius: 5px;
    margin-top: 20px;
}

/* Events Section */
.events-section {
    background-color: var(--alumni-white);
}

.events-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 30px;
}

.event-card {
    background-color: var(--alumni-white);
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 5px 15px var(--alumni-shadow);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.event-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.event-content {
    padding: 25px;
}

.event-meta {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
}

.event-date {
    font-weight: 600;
    color: var(--alumni-navy);
}

.event-type {
    display: inline-block;
    padding: 3px 10px;
    background-color: var(--alumni-navy);
    color: var(--alumni-white);
    font-size: 12px;
    border-radius: 20px;
}

.event-title {
    font-size: 20px;
    color: var(--alumni-navy);
    margin-bottom: 10px;
}

.event-location {
    font-size: 14px;
    color: #555;
    margin-bottom: 15px;
}

.event-location i {
    margin-right: 5px;
    color: var(--alumni-gold);
}

.event-excerpt {
    margin-bottom: 20px;
    font-size: 14px;
    color: var(--alumni-text);
}

.event-actions {
    display: flex;
    gap: 10px;
    margin-top: auto;
}

.no-events {
    text-align: center;
    padding: 40px 0;
    color: #999;
    grid-column: 1 / -1;
}

/* Job Offers Section */
.job-offers-section {
    background-color: var(--alumni-gray);
}

.job-offers-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 30px;
}

.job-card {
    background-color: var(--alumni-white);
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 5px 15px var(--alumni-shadow);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.job-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.job-content {
    padding: 25px;
}

.job-title {
    font-size: 20px;
    color: var(--alumni-navy);
    margin-bottom: 15px;
}

.job-company, .job-location, .job-type {
    font-size: 14px;
    color: #555;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
}

.job-company i, .job-location i, .job-type i {
    margin-right: 8px;
    color: var(--alumni-gold);
    width: 16px;
}

.job-excerpt {
    margin: 20px 0;
    font-size: 14px;
}

.job-actions {
    display: flex;
    gap: 10px;
    margin-top: auto;
}

.no-jobs {
    text-align: center;
    padding: 40px 0;
    color: #999;
    grid-column: 1 / -1;
}

/* Companies Section */
.companies-section {
    background-color: var(--alumni-white);
}

.companies-slider {
    display: flex;
    overflow: hidden;
}

.company-slide {
    flex: 0 0 25%;
    box-sizing: border-box;
    padding: 0 15px;
}

.company-card {
    background-color: var(--alumni-white);
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 5px 15px var(--alumni-shadow);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    text-align: center;
}

.company-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.company-content {
    padding: 25px;
}

.company-logo {
    height: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
}

.company-logo img {
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
}

.company-name {
    font-size: 18px;
    color: var(--alumni-navy);
    margin-bottom: 10px;
}

.company-sector {
    font-size: 14px;
    color: #666;
    margin-bottom: 20px;
}

.company-excerpt {
    margin-bottom: 20px;
    font-size: 14px;
    color: var(--alumni-text);
}

.company-actions {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 20px;
}

.no-companies {
    text-align: center;
    padding: 40px 0;
    color: #999;
    grid-column: 1 / -1;
}

/* Responsive Styles */
@media screen and (max-width: 768px) {
    .section {
        padding: 40px 0;
    }
    
    .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .events-grid, .job-offers-grid, .companies-grid {
        grid-template-columns: 1fr;
    }
    
    .hero-section h1 {
        font-size: 32px;
    }
    
    .hero-section .subtitle {
        font-size: 16px;
    }
    
    .event-actions, .job-actions {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
        text-align: center;
    }
}

.btn-green {
    background-color: #009640;
    color: #fff;
    border-radius: 4px;
    padding: 8px 18px;
    font-size: 15px;
    border: none;
    transition: background 0.2s;
}
.btn-green:hover {
    background-color: #007d33;
    color: #fff;
}
.page-numbers {
    display: inline-block;
    margin: 0 3px;
    padding: 6px 12px;
    color: #009640;
    border: 1px solid #009640;
    border-radius: 3px;
    text-decoration: none;
    font-weight: 600;
}
.page-numbers.current, .page-numbers:hover {
    background: #009640;
    color: #fff;
}

.events-grid {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.actualite-row {
    display: flex;
    align-items: flex-start;
    gap: 24px;
    margin-bottom: 30px;
    background: #fff;
    border-radius: 8px;
    padding: 16px 0;
}
.actualite-img-link {
    flex-shrink: 0;
    width: 220px;
    display: block;
}
.actualite-img {
    width: 100%;
    height: 140px;
    object-fit: cover;
    border-radius: 8px;
    display: block;
}
.actualite-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
}
.actualite-title a {
    font-weight: bold;
    color: #0b65a0;
    font-size: 20px;
    text-decoration: none;
}
.actualite-excerpt {
    margin: 10px 0 15px 0;
    color: #333;
    font-size: 15px;
}
.actualite-btn {
    color: #009640;
    text-decoration: none;
    font-weight: 600;
    margin-top: auto;
}
@media (max-width: 700px) {
    .actualite-row {
        flex-direction: column;
        gap: 10px;
    }
    .actualite-img-link {
        width: 100%;
    }
    .actualite-img {
        height: 45vw;
        max-height: 220px;
    }
}

/* Pagination horizontale stylée */
.actualites-pagination {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 32px 0 32px 0;
    border: none;
    background: none;
    box-shadow: none;
}
.actualites-pagination ul.page-numbers {
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    gap: 0;
    padding-left: 0;
    margin: 0 auto;
    list-style: none;
    border: none;
    background: none;
    box-shadow: none;
}
.actualites-pagination ul.page-numbers li {
    margin: 0;
    border: none;
    background: none;
    box-shadow: none;
}
.actualites-pagination .page-numbers {
    display: inline-block;
    min-width: 38px;
    padding: 6px 12px;
    margin: 0 2px;
    color: #009640;
    border: 1px solid #009640;
    border-radius: 3px;
    text-decoration: none;
    font-weight: 600;
    background: #fff;
    transition: background 0.2s, color 0.2s;
    text-align: center;
    font-size: 15px;
    box-shadow: none;
}
 .page-numbers.current,
 .page-numbers:hover {
    background: #009640;
    color: #fff;
    border-color: #009640;
}
.actualites-pagination .page-numbers.dots {
    border: none;
    background: none;
    color: #009640;
    cursor: default;
}
</style>

<main id="content" class="alumni-landing-page">
<section class="section key-stats-section">
    <div class="container">
        <h2 class="section-title text-center" style="color: #0b65a0; text-align: center; margin-bottom: 40px; font-size: 32px;">Nos Leaders</h2>
        <div class="events-grid">
<?php
$leaders_query = new WP_Query([
    'post_type' => 'leader',
    'posts_per_page' => -1,
    'post_status' => 'publish'
]);
if ($leaders_query->have_posts()) :
    while ($leaders_query->have_posts()) : $leaders_query->the_post(); ?>
        <div class="actualite-row">
            <a class="actualite-img-link">
                <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('large', ['class' => 'actualite-img', 'alt' => get_the_title()]); ?>
                <?php else : ?>
                    <img src="https://via.placeholder.com/220x140" alt="<?php the_title(); ?>" class="actualite-img">
                <?php endif; ?>
            </a>
            <div class="actualite-content">
                <div class="actualite-title" style="color:#0b65a0;font-weight:bold;font-size:18px;">
                    <?php the_title(); ?>
                </div>
                <div class="actualite-excerpt">
                    <?php
                    // Affiche le contenu principal (éditeur WordPress)
                    the_content();

                    // Affiche les champs personnalisés si ACF est installé
                    if (function_exists('get_field')) {
                        echo get_field('fonction') ? get_field('fonction') . '<br>' : '';
                        echo get_field('pays') ? get_field('pays') : '';
                    }
                    ?>
                </div>
            </div>
        </div>
    <?php endwhile;
    wp_reset_postdata();
else : ?>
    <div>Aucun leader trouvé.</div>
<?php endif; ?>
        </div>
    </div>
</section>
   
    
    
   
    <!-- Include Swiper JS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
    <script>
       
    </script>
</main>

<?php 
// Chargement conditionnel du footer selon que l'utilisateur est connecté ou non
if (is_user_logged_in() && current_user_can('etudiant')) {
    get_template_part('footer', 'etudiant');
} else {
    get_footer();
}
?>