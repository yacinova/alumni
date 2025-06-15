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
    text-align: center;
    position: relative;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><circle cx="2" cy="2" r="1" fill="%23d4af37" opacity="0.15"/></svg>');
    background-size: 20px 20px;
    opacity: 0.5;
}

.hero-content {
    position: relative;
    max-width: 800px;
    margin: 0 auto;
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


</style>

<main id="content" class="alumni-landing-page">
    <!-- Chiffres Clés Section -->
    <section class="section key-stats-section">
        <div class="container">
            <h2 class="section-title text-center" style="color: #0b65a0; text-align: center; margin-bottom: 40px; font-size: 32px;">Chiffres Clés</h2>
            
            <div class="stats-wrapper" style="display: flex; justify-content: space-around; text-align: center; margin-bottom: 50px;">
                <div class="stat-item">
                    <h3 style="color: #00a651; font-size: 42px; font-weight: bold; margin-bottom: 5px;">11532</h3>
                    <p style="color: #0b65a0; font-size: 16px;">Etudiants/Lauréats inscrits</p>
                </div>
                
                <div class="stat-item">
                    <h3 style="color: #00a651; font-size: 42px; font-weight: bold; margin-bottom: 5px;">40</h3>
                    <p style="color: #0b65a0; font-size: 16px;">Associations inscrites</p>
                </div>
                
                <div class="stat-item">
                    <h3 style="color: #00a651; font-size: 42px; font-weight: bold; margin-bottom: 5px;">4</h3>
                    <p style="color: #0b65a0; font-size: 16px;">Partenaires inscrits</p>
                </div>
            </div>
            
            <div class="image-wrapper" style="text-align: center; margin-bottom: 50px;">
                <img src="/wp-content/uploads/2025/my_photos/mainSommesNous.png" alt="AMCI Event" style="max-width: 100%; height: auto; border-radius: 8px;">
            </div>
        </div>
    </section>
    
    <!-- Morocco Alumni & AMCI Info Section -->
    <section class="section info-section" style="background-color: #f9f9f9; padding: 60px 0;">
        <div class="container">
            <div style="display: flex; flex-wrap: wrap; gap: 30px;">
                <div style="flex: 1; min-width: 300px;">
                    <h3 style="color: #333; font-size: 24px; margin-bottom: 20px;">Morocco alumni</h3>
                    <p style="font-size: 14px; line-height: 1.6; color: #666;">
                        Morocco Alumni est une plateforme créée par l'Agence Marocaine de 
                        Coopération Internationale qui a pour vocation de rassembler et connecter 
                        l'ensemble des étudiants, lauréats et anciens étudiants étrangers à 
                        l'échelle mondiale de notre de notre pays.
                    </p>
                    <p style="font-size: 14px; line-height: 1.6; color: #666;">
                        Grâce à ce fut dispositif d'une base de données de 20000 acteurs, 
                        étudiants et futurs diplômés, cette plateforme offre toute plusieurs 
                        services à forte valeur ajoutée à travers de ses utilisateurs, offres 
                        d'emplois et de stages, accès à une médiathèque organisation 
                        événementielle professionnelle, solutions accès à l'actualité des 
                        associations partenaires de l'AMCI.
                    </p>
                    <p style="font-size: 14px; line-height: 1.6; color: #666;">
                        L'Agence Marocaine de Coopération Internationale (AMCI) a été créée en 
                        1986 pour contribuer à renforcer la Coopération Internationale du 
                        Royaume du Maroc, avec une forte orientation pour la promotion de la 
                        Coopération Sud-Sud prônée par Sa Majesté Le Roi Mohammed VI Que Dieu 
                        l'Assiste.
                    </p>
                </div>
                
                <div style="flex: 1; min-width: 300px;">
                    <h3 style="color: #333; font-size: 24px; margin-bottom: 20px;">Découvrir L'AMCI</h3>
                    <p style="font-size: 14px; line-height: 1.6; color: #666;">
                        L'AMCI a pour mission de développer la coopération entre les peuples en 
                        contribuant à l'élargissement et au renforcement de la coopération 
                        culturelle, scientifique, économique et technique entre le Royaume du 
                        Maroc et les pays auxquels l'unissent des liens d'amitié et de coopération.
                    </p>
                    <p style="font-size: 14px; line-height: 1.6; color: #666;">
                        L'AMCI agit en étroite coordination avec le Ministère des Affaires 
                        Etrangères, de la Coopération Africaine et des Marocains Résidant à 
                        l'Etranger dans la mise en œuvre des actions menées en partenariat 
                        avec les différents départements ministériels nationaux et les 
                        partenaires institutionnels étrangers.
                    </p>
                    <p style="font-size: 14px; line-height: 1.6; color: #666;">
                        Elle reflète la position du Royaume du Maroc comme acteur de référence 
                        de la coopération Sud-Sud du Royaume du Maroc, en mettant à profit le 
                        savoir-faire et l'expertise du Royaume du Maroc dans plusieurs domaines, 
                        pour fournir aux pays ses partenaires en voie de développement, principalement en 
                        Afrique.
                    </p>
                    <p>
                        <a href="https://www.amci.ma" target="_blank" style="color: #0b65a0; text-decoration: none;">www.amci.ma</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Témoignages Section -->
    <section class="section testimonials-section">
        <div class="container">
            <h2 class="section-title text-center" style="color: #0b65a0; text-align: center; margin-bottom: 40px; font-size: 32px;">Témoignages</h2>
            
            <div style="display: flex; flex-wrap: wrap; gap: 30px; justify-content: center;">
                <div style="flex: 1; min-width: 300px; max-width: 450px; background-color: #ffb74d; border-radius: 8px; padding: 20px; color: #333;">
                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px;">
                        <img src="/wp-content/themes/hello-elementor-child/assets/images/dilberto.jpg" alt="Dilberto Jau" style="width: 60px; height: 60px; border-radius: 50%;">
                        <div>
                            <h4 style="margin: 0; font-size: 18px;">Dilberto Jau</h4>
                            <p style="margin: 0; font-size: 14px;">Agent de Travail responsable pour l'Elaboration Forestière de la Direction Générale des Forêts et Faune, Bissau</p>
                        </div>
                    </div>
                </div>
                
                <div style="flex: 1; min-width: 300px; max-width: 450px; background-color: #ffb74d; border-radius: 8px; padding: 20px; color: #333;">
                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px;">
                        <img src="/wp-content/themes/hello-elementor-child/assets/images/abdo.jpg" alt="Abdo MOHAMADOU" style="width: 60px; height: 60px; border-radius: 50%;">
                        <div>
                            <h4 style="margin: 0; font-size: 18px;">Abdo MOHAMADOU</h4>
                            <p style="margin: 0; font-size: 14px;"></p>
                        </div>
                    </div>
                </div>
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