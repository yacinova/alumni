<?php
/**
 * The template for displaying the header
 *
 * Header blanc pour la landing page et les pages publiques
 * Le header-etudiant.php sera utilisé pour les pages d'étudiant connecté
 *
 * @package HelloElementorChild
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$viewport_content = apply_filters( 'hello_elementor_viewport_content', 'width=device-width, initial-scale=1' );
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="<?php echo esc_attr( $viewport_content ); ?>">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<?php wp_head(); ?>
    <?php // Styles moved to css/header-public.css ?>
    <!-- Add Slick Slider CSS -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
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
    background-color: var(--alumni-blue);
    color: var(--alumni-white);
    border-color: var(--alumni-blue);
}

.btn-primary:hover {
    background-color: var(--alumni-navy);
    color: var(--alumni-white);
    border-color: var(--alumni-navy);
}

.btn-secondary {
    background-color: transparent;
    color: var(--alumni-white);
    border-color: var(--alumni-white);
}

.btn-secondary:hover {
    background-color: var(--alumni-white);
    color: var(--alumni-blue);
    border-color: var(--alumni-white);
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
    border-bottom: 2px solid var(--alumni-blue);
    padding-bottom: 15px;
}

.section-header h2 {
    font-size: 28px;
    color: var(--alumni-navy);
    margin: 0;
    position: relative;
}

.view-all {
    color: var(--alumni-blue);
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.view-all:hover {
    color: var(--alumni-navy);
    text-decoration: underline;
}

/* Header & Navigation */
.insa-header {
    background-color: var(--alumni-white);
    border-bottom: 1px solid #e7e7e7;
    padding: 10px 0;
}

.insa-header-inner {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.header-left {
    display: flex;
    align-items: center;
    gap: 20px;
}

.social-icons {
    display: flex;
    gap: 15px;
}

.social-icons a {
    color: var(--alumni-navy);
    font-size: 16px;
}

.header-links a {
    color: var(--alumni-navy);
    text-decoration: none;
    font-size: 12px;
    font-weight: 500;
}

.header-links a:hover {
    text-decoration: underline;
}

.header-right {
    display: flex;
    align-items: center;
    gap: 15px;
}

.search-bar {
    position: relative;
}

.search-bar input {
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

.search-bar button {
    position: absolute;
    right: 5px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    color: #777;
}

.action-buttons {
    display: flex;
    gap: 10px;
}

.action-buttons .btn {
    padding: 8px 15px;
    font-size: 14px;
}





.btn-adhere {
    background-color: var(--alumni-white);
    color: #0b1c39;
    border: 1px solid #0b1c39;
}

.btn-connect {
    background-color: #0b1c39;
    color: var(--alumni-white);
    border: 1px solid #0b1c39;
}

/* Logo section */
.insa-logo-section {
    padding: 20px 0;
    background-color: #0b1c39;
}

.insa-logo-section .container {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.insa-logo-section .logo {
    display: block;
}

.insa-logo-section .logo img {
    max-height: 60px;
    width: auto;
}

.insa-logo-section .tagline {
    font-size: 18px;
    color: white;
    font-weight: 500;
}

.insa-logo-section .tagline .highlight {
    color: #d4af37;
    font-weight: bold;
}

.insa-navigation {
    border-top: 2px solid #d4af37;
    background-color: #0b1c39;
    padding: 0;
}

.nav-menu {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
}

.nav-menu li {
    position: relative;
}

.nav-menu li a {
    display: block;
    color: var(--alumni-white);
    text-decoration: none;
    padding: 15px 20px;
    font-weight: 500;
    font-size: 14px;
    transition: background-color 0.3s ease;
}

.nav-menu li a:hover {
    background-color: rgba(255, 255, 255, 0.1);
}


/* Dropdown Styles */
.dropdown {
    position: relative;
}

.dropdown-content {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background-color: var(--alumni-white);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    border-top: 2px solid var(--alumni-gold);
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
    min-width: 250px;
}

.dropdown.active .dropdown-content {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.full-width-dropdown {
    width: 100vw;
    position: relative;
    left: 50%;
    transform: translateX(-50%);
}

.dropdown-inner {
    padding: 20px;
}

.dropdown-column {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.dropdown-column a {
    color: var(--alumni-navy);
    text-decoration: none;
    padding: 10px 15px;
    border-radius: 4px;
    transition: all 0.3s ease;
    font-size: 14px;
    font-weight: 500;
}

.dropdown-column a:hover {
    background-color: var(--alumni-gray);
    color: var(--alumni-blue);
    transform: translateX(5px);
}

.dropdown-toggle::after {
    content: '\f107';
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    margin-left: 8px;
    transition: transform 0.3s ease;
    text-decoration: none;
    border: none;
    vertical-align: baseline;
}

.dropdown.active .dropdown-toggle::after {
    transform: rotate(180deg);
}

/* Hero Section */
.hero-section {
    position: relative;
    color: var(--alumni-white);
    overflow: hidden;
    padding: 0;
    height: 500px;
}

.hero-slider {
    position: relative;
    height: 100%;
    width: 100%;
}

.hero-slide {
    position: relative;
    height: 500px;
    display: flex;
    align-items: center;
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, #0066b2 0%, #1e88e5 50%, #42a5f5 100%);
    z-index: 1;
}

.hero-layout {
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    align-items: center;
    width: 100%;
    position: relative;
    z-index: 2;
    gap: 40px;
    height: 100%;
}

.hero-content {
    grid-column: 1;
    text-align: left;
    padding-right: 20px;
}

.hero-content h2 {
    font-size: 36px;
    font-weight: 700;
    margin-bottom: 30px;
    color: var(--alumni-white);
    line-height: 1.2;
}

.hero-content .subtitle {
    font-size: 18px;
    margin-bottom: 30px;
    color: var(--alumni-white);
    opacity: 0.9;
}

.hero-image {
    grid-column: 2;
    text-align: center;
    max-width: 300px;
    justify-self: center;
}

.hero-image img {
    width: 100%;
    height: auto;
    max-height: 280px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}

.cta-buttons {
    display: flex;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;
}

.welcome-back {
    background-color: rgba(255, 255, 255, 0.9);
    border: 1px solid rgba(212, 175, 55, 0.3);
    padding: 20px;
    border-radius: 5px;
    margin-top: 20px;
    color: var(--alumni-navy);
}

/* Swiper Navigation Styles */
.heroSwiper .swiper-button-next,
.heroSwiper .swiper-button-prev {
    color: var(--alumni-white);
    background-color: rgba(255, 255, 255, 0.2);
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-top: -25px;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    z-index: 10;
    display: flex;
    align-items: center;
    justify-content: center;
}

.heroSwiper .swiper-button-next:hover,
.heroSwiper .swiper-button-prev:hover {
    background-color: rgba(255, 255, 255, 0.4);
    transform: scale(1.1);
}

.heroSwiper .swiper-button-next::after,
.heroSwiper .swiper-button-prev::after {
    font-size: 18px;
    font-weight: bold;
}

.heroSwiper .swiper-button-next {
    right: 50px;
}

.heroSwiper .swiper-button-prev {
    left: 50px;
}

/* Swiper Pagination Styles */
.heroSwiper .swiper-pagination {
    bottom: 40px;
    text-align: center;
    z-index: 3;
}

.heroSwiper .swiper-pagination-bullet {
    width: 14px;
    height: 14px;
    background-color: rgba(255, 255, 255, 0.6);
    opacity: 1;
    margin: 0 8px;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.heroSwiper .swiper-pagination-bullet-active {
    background-color: var(--alumni-white);
    border-color: rgba(255, 255, 255, 0.8);
    transform: scale(1.2);
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
    @media screen and (max-width: 1024px) {
    .hero-layout {
        gap: 20px;
        grid-template-columns: 1fr auto 1fr;
    }
    
    .hero-content {
        padding-right: 15px;
    }
    
    .hero-content h2 {
        font-size: 28px;
    }
    
    .hero-content .subtitle {
        font-size: 16px;
    }
    
    .hero-image {
        max-width: 250px;
    }
    
    .hero-image img {
        max-height: 220px;
    }
    
    .heroSwiper .swiper-button-next,
    .heroSwiper .swiper-button-prev {
        width: 45px;
        height: 45px;
        margin-top: -22.5px;
    }
    
    .heroSwiper .swiper-button-next::after,
    .heroSwiper .swiper-button-prev::after {
        font-size: 16px;
    }
    
    .heroSwiper .swiper-button-next {
        right: 30px;
    }
    
    .heroSwiper .swiper-button-prev {
        left: 30px;
    }
    
    /* Mobile dropdown adjustments */
    .full-width-dropdown {
        width: 100%;
        left: 0;
        transform: none;
    }
    
    .dropdown-content {
        position: fixed;
        top: auto;
        left: 0;
        right: 0;
        width: 100%;
        max-height: 70vh;
        overflow-y: auto;
    }
}

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
    
    /* Mobile navigation styles */
    .insa-header-inner {
        flex-direction: column;
        gap: 15px;
    }
    
    .header-left, .header-right {
        width: 100%;
        justify-content: center;
    }
    
    .search-bar {
        width: 100%;
        max-width: 300px;
    }
    
    .search-bar input {
        width: 100%;
    }
    
    .action-buttons {
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .nav-menu {
        flex-direction: column;
    }
    
    .nav-menu li {
        width: 100%;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .nav-menu li:last-child {
        border-bottom: none;
    }
    
    .dropdown-content {
        position: static;
        opacity: 1;
        visibility: visible;
        transform: none;
        transition: none;
        box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.1);
        border-top: none;
        border-left: 3px solid var(--alumni-gold);
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
    }
    
    .dropdown.active .dropdown-content {
        max-height: 500px;
    }
    
    .dropdown-inner {
        padding: 15px 20px;
    }
    
    .dropdown-column a {
        padding: 8px 15px;
        font-size: 13px;
    }
    
    .hero-section {
        height: 400px;
    }
    
    .hero-slide {
        height: 400px;
    }
    
    .hero-layout {
        display: flex;
        flex-direction: column;
        text-align: center;
        gap: 20px;
    }
    
    .hero-content {
        grid-column: unset;
        max-width: 100%;
        order: 2;
        padding-right: 0;
    }
    
    .hero-content h2 {
        font-size: 24px;
    }
    
    .hero-content .subtitle {
        font-size: 14px;
    }
    
    .hero-image {
        grid-column: unset;
        order: 1;
        max-width: 200px;
        margin: 0 auto;
        justify-self: unset;
    }
    
    .hero-image img {
        max-height: 180px;
    }
    
    .cta-buttons {
        justify-content: center;
    }
    
    .heroSwiper .swiper-button-next,
    .heroSwiper .swiper-button-prev {
        width: 40px;
        height: 40px;
        margin-top: -20px;
    }
    
    .heroSwiper .swiper-button-next::after,
    .heroSwiper .swiper-button-prev::after {
        font-size: 14px;
    }
    
    .heroSwiper .swiper-button-next {
        right: 15px;
    }
    
    .heroSwiper .swiper-button-prev {
        left: 15px;
    }
    
    .heroSwiper .swiper-pagination {
        bottom: 20px;
    }
    
    .heroSwiper .swiper-pagination-bullet {
        width: 12px;
        height: 12px;
        margin: 0 5px;
    }
    
    .event-actions, .job-actions {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
        text-align: center;
    }

    
}

@media screen and (max-width: 480px) {
    .hero-section {
        height: 350px;
    }
    
    .hero-slide {
        height: 350px;
    }
    
    .hero-content {
        padding: 30px 0;
    }
    
    .hero-content h2 {
        font-size: 24px;
        line-height: 1.3;
    }
    
    .hero-content .subtitle {
        font-size: 14px;
    }
    
    .container {
        padding: 0 15px;
    }
}

.toutes_les_offres{
    background-color:rgb(129, 129, 129);
    color: white;
}
</style>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="insa-header">
    <div class="container insa-header-inner">
        <div class="header-left">
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>
            <div class="header-links">
            | &nbsp;<a href="#">CONTACTEZ-NOUS</a> &nbsp;
            </div>
        </div>
        <div class="header-right">
            <div class="search-bar">
                <input type="text" placeholder="Rechercher...">
                <button><i class="fas fa-search"></i></button>
            </div>
            <div class="action-buttons">
                <a href="#" class="btn btn-adhere"><i class="fas fa-user-plus"></i> Adhérer</a>
                <a href="connexion-etudiant" class="btn btn-connect"><i class="fas fa-sign-in-alt"></i> Se connecter</a>
            </div>
        </div>
    </div>
</header>

<div class="insa-logo-section">
    <div class="container">
        <a href="/" class="ldogo">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo.png" alt="Alumni ESG Maroc" style="height: 150px; object-fit: cover;">
        </a>
        <div class="tagline">
            UN RÉSEAU EN ACTION <span class="highlight">PARTOUT DANS LE MONDE</span>
        </div>
    </div>
</div>

<nav class="insa-navigation">
    <div class="container">
        <ul class="nav-menu">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle">ESG alumni</a>
                <div class="dropdown-content">
                    <div class="container full-width-dropdown">
                        <div class="dropdown-inner">
                            <div class="dropdown-column">
                                <a href="/qui-sommes-nous">Qui sommes-nous ?</a>
                                <a href="/statuts">Les statuts</a>
                                <!-- <a href="/reglement-interieur">Le règlement intérieur</a> -->
                                <a href="/comite-de-gouvernance">Le comité de gouvernance</a>
                                <a href="/lassemble-generale">L'assemblée générale</a>
                                <a href="/coordonnees">Les coordonnées</a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <!-- <li class="dropdown">
                <a href="#" class="dropdown-toggle">Réseau</a>
                <div class="dropdown-content">
                    <div class="container full-width-dropdown">
                        <div class="dropdown-inner">
                            <div class="dropdown-column">
                                <a href="#">INSA cvl alumni</a>
                                <a href="#">Alumni INSA Lyon</a>
                                <a href="#">INSA Alumni Rennes</a>
                                <a href="#">A2IN - Rouen</a>
                                <a href="#">A&I - Strasbourg</a>
                                <a href="#">INSA Alumni Toulouse</a>
                                <a href="#">Groupes géographiques</a>
                                <a href="#">Groupes professionnels</a>
                                <a href="#">lesf</a>
                                <a href="#">Alumni for the Planet</a>
                            </div>
                        </div>
                    </div>
                </div>
            </li> -->
            <li class="dropdown">
                <a href="#" class="dropdown-toggle">Annuaire</a>
                <div class="dropdown-content">
                    <div class="container full-width-dropdown">
                        <div class="dropdown-inner">
                            <div class="dropdown-column">
                                <a href="#">Trouver un diplômé</a>
                                <a href="#">Trouver une entreprise partenaire</a>
                                <a href="#">CGU</a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle">Carrière</a>
                <div class="dropdown-content">
                    <div class="container full-width-dropdown">
                        <div class="dropdown-inner">
                            <div class="dropdown-column">
                                <!-- <a href="#">Offres d’emploi</a> -->
                                <a href="#">Proposer une offre d’emploi ou un stage</a>
                                <a href="#">Déposer un CV</a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle">Communication</a>
                <div class="dropdown-content">
                    <div class="container full-width-dropdown">
                        <div class="dropdown-inner">
                            <div class="dropdown-column">
                                <!-- <a href="/actualites">Actualités</a> -->
                                <a href="#">Agenda</a>
                                <a href="#">Newsletter</a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const mainNavigation = document.querySelector('.main-navigation');
    
    if (mobileMenuToggle && mainNavigation) {
        mobileMenuToggle.addEventListener('click', function() {
            mainNavigation.classList.toggle('mobile-open');
            mobileMenuToggle.classList.toggle('active');
        });
    }
    
    // Dropdown functionality
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    const dropdowns = document.querySelectorAll('.dropdown');
    
    // Function to close all dropdowns
    function closeAllDropdowns() {
        dropdowns.forEach(dropdown => {
            dropdown.classList.remove('active');
        });
    }
    
    // Add click handlers to dropdown toggles
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const parent = this.parentElement;
            const isCurrentlyActive = parent.classList.contains('active');
            
            // Close all dropdowns first
            closeAllDropdowns();
            
            // If the clicked dropdown wasn't active, open it
            if (!isCurrentlyActive) {
                parent.classList.add('active');
            }
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            closeAllDropdowns();
        }
    });
    
    // Close dropdowns when pressing Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAllDropdowns();
        }
    });
    
    // Close dropdowns when scrolling
    window.addEventListener('scroll', function() {
        closeAllDropdowns();
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        closeAllDropdowns();
    });
});
</script>

<?php wp_footer(); ?>
</body>
</html>