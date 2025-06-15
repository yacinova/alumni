<?php
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
?>

<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

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

/* Hero Section */
.hero-section {
    position: relative;
    color: var(--alumni-white);
    overflow: hidden;
    padding: 0;
    height: 100vh;
    min-height: 400px;
    max-height: 600px;
}

.hero-slider {
    position: relative;
    height: 100%;
    width: 100%;
}

.hero-slide {
    position: relative;
    height: 100%;
    display: flex;
    align-items: center;
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, #0b1c39 0%,rgb(35, 72, 131) 65%, #42a5f5 100%);
    z-index: 1;
}

.hero-background::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="0.5" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.hero-layout {
    display: grid;
    grid-template-columns: 1fr 1fr;
    align-items: center;
    width: 100%;
    position: relative;
    z-index: 2;
    gap: 80px;
    height: 100%;
    padding: 80px 0;
}

.hero-content {
    grid-column: 1;
    text-align: left;
    max-width: 100%;
    animation: fadeInLeft 1s ease-out;
    padding-right: 40px;
}

.hero-content h2 {
    font-size: clamp(32px, 4.5vw, 56px);
    font-weight: 700;
    margin-bottom: 28px;
    color: var(--alumni-white);
    line-height: 1.1;
    text-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
    letter-spacing: -0.8px;
}

.hero-content .subtitle {
    font-size: clamp(18px, 2.5vw, 24px);
    margin-bottom: 36px;
    color: var(--alumni-white);
    opacity: 0.95;
    font-weight: 400;
    line-height: 1.5;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.hero-image {
    grid-column: 2;
    position: relative;
    max-width: 100%;
    animation: fadeInRight 1s ease-out;
    display: flex;
    justify-content: center;
    align-items: center;
}

.hero-image::before {
    content: '';
    position: absolute;
    top: -30px;
    left: -30px;
    right: -30px;
    bottom: -30px;
    background: linear-gradient(45deg, 
        rgba(212, 175, 55, 0.3) 0%, 
        rgba(255, 255, 255, 0.1) 25%, 
        rgba(0, 102, 178, 0.2) 50%, 
        rgba(255, 255, 255, 0.1) 75%, 
        rgba(212, 175, 55, 0.3) 100%);
    border-radius: 50px;
    z-index: -1;
    animation: rotate 20s linear infinite;
}

.hero-image::after {
    content: '';
    position: absolute;
    top: -15px;
    left: -15px;
    right: -15px;
    bottom: -15px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 30px;
    z-index: -1;
    backdrop-filter: blur(20px);
}

.hero-image-container {
    position: relative;
    width: 100%;
    max-width: 500px;
    aspect-ratio: 4/3;
    overflow: hidden;
    border-radius: 24px;
    box-shadow: 
        0 25px 50px rgba(0, 0, 0, 0.5),
        0 0 0 1px rgba(255, 255, 255, 0.1),
        inset 0 0 0 1px rgba(255, 255, 255, 0.1);
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
    backdrop-filter: blur(10px);
}

.hero-image-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, 
        transparent 0%, 
        rgba(255, 255, 255, 0.1) 50%, 
        transparent 100%);
    z-index: 2;
    pointer-events: none;
}

.hero-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.8s ease, filter 0.8s ease;
    position: relative;
    z-index: 1;
}

.hero-image:hover img {
    transform: scale(1.05);
    filter: brightness(1.1) contrast(1.1);
}

.hero-image-decorations {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    pointer-events: none;
    z-index: 3;
}

.hero-image-decorations::before {
    content: '';
    position: absolute;
    top: -20px;
    right: -20px;
    width: 40px;
    height: 40px;
    background: linear-gradient(45deg, var(--alumni-gold), var(--alumni-gold-light));
    border-radius: 50%;
    box-shadow: 0 4px 15px rgba(212, 175, 55, 0.4);
    animation: pulse 3s ease-in-out infinite;
}

.hero-image-decorations::after {
    content: '';
    position: absolute;
    bottom: -15px;
    left: -15px;
    width: 30px;
    height: 30px;
    background: linear-gradient(45deg, rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.4));
    border-radius: 50%;
    box-shadow: 0 4px 10px rgba(255, 255, 255, 0.3);
    animation: float 4s ease-in-out infinite;
}

.hero-image-frame {
    position: absolute;
    top: -40px;
    left: -40px;
    right: -40px;
    bottom: -40px;
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 40px;
    z-index: -2;
}

.hero-image-frame::before {
    content: '';
    position: absolute;
    top: 10px;
    left: 10px;
    right: 10px;
    bottom: 10px;
    border: 1px solid rgba(212, 175, 55, 0.3);
    border-radius: 35px;
}

.cta-buttons {
    display: flex;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;
}

.hero-section .btn {
    display: inline-flex;
    align-items: center;
    padding: 16px 32px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    font-size: 16px;
    transition: all 0.4s ease;
    border: 2px solid transparent;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.hero-section .btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.6s ease;
}

.hero-section .btn:hover::before {
    left: 100%;
}

.hero-section .btn-secondary {
    background-color: transparent;
    color: var(--alumni-white);
    border-color: var(--alumni-white);
    backdrop-filter: blur(10px);
    background: rgba(255, 255, 255, 0.1);
}

.hero-section .btn-secondary:hover {
    background-color: var(--alumni-white);
    color: var(--alumni-blue);
    border-color: var(--alumni-white);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255, 255, 255, 0.3);
}

.welcome-back {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(255, 255, 255, 0.85));
    border: 1px solid rgba(212, 175, 55, 0.3);
    padding: 24px;
    border-radius: 12px;
    margin-top: 24px;
    color: var(--alumni-navy);
    backdrop-filter: blur(10px);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

/* Enhanced Animations */
@keyframes rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

@keyframes pulse {
    0%, 100% { 
        transform: scale(1);
        opacity: 0.8;
    }
    50% { 
        transform: scale(1.2);
        opacity: 1;
    }
}

@keyframes float {
    0%, 100% { 
        transform: translateY(0px);
        opacity: 0.6;
    }
    50% { 
        transform: translateY(-10px);
        opacity: 1;
    }
}

@keyframes fadeInLeft {
    from {
        opacity: 0;
        transform: translateX(-50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes fadeInRight {
    from {
        opacity: 0;
        transform: translateX(50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Enhanced Swiper Navigation */
.heroSwiper .swiper-button-next,
.heroSwiper .swiper-button-prev {
    color: var(--alumni-white);
    background: rgba(255, 255, 255, 0.15);
    width: 60px;
    height: 60px;
    border-radius: 50%;
    margin-top: -30px;
    transition: all 0.4s ease;
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    z-index: 10;
    display: flex;
    align-items: center;
    justify-content: center;
}

.heroSwiper .swiper-button-next:hover,
.heroSwiper .swiper-button-prev:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: scale(1.1);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
}

.heroSwiper .swiper-button-next::after,
.heroSwiper .swiper-button-prev::after {
    font-size: 20px;
    font-weight: bold;
}

.heroSwiper .swiper-button-next {
    right: 40px;
}

.heroSwiper .swiper-button-prev {
    left: 40px;
}

/* Enhanced Swiper Pagination */
.heroSwiper .swiper-pagination {
    bottom: 40px;
    text-align: center;
    z-index: 3;
}

.heroSwiper .swiper-pagination-bullet {
    width: 16px;
    height: 16px;
    background-color: rgba(255, 255, 255, 0.4);
    opacity: 1;
    margin: 0 8px;
    transition: all 0.4s ease;
    border: 2px solid transparent;
    cursor: pointer;
}

.heroSwiper .swiper-pagination-bullet:hover {
    background-color: rgba(255, 255, 255, 0.7);
    transform: scale(1.1);
}

.heroSwiper .swiper-pagination-bullet-active {
    background-color: var(--alumni-white);
    border-color: rgba(255, 255, 255, 0.6);
    transform: scale(1.3);
    box-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
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

/* Enhanced Responsive Design */
@media screen and (max-width: 1200px) {
    .hero-layout {
        gap: 60px;
    }
    
    .hero-image-container {
        max-width: 450px;
    }
    
    .hero-content {
        padding-right: 30px;
    }
}

@media screen and (max-width: 1024px) {
    .hero-section {
        height: 85vh;
        min-height: 550px;
        max-height: 750px;
    }
    
    .hero-layout {
        gap: 40px;
        padding: 60px 0;
    }
    
    .hero-content h2 {
        font-size: clamp(28px, 4vw, 42px);
    }
    
    .hero-content .subtitle {
        font-size: clamp(16px, 2vw, 20px);
    }
    
    .hero-image-container {
        max-width: 400px;
    }
    
    .hero-image::before {
        top: -20px;
        left: -20px;
        right: -20px;
        bottom: -20px;
        border-radius: 40px;
    }
    
    .hero-image::after {
        top: -10px;
        left: -10px;
        right: -10px;
        bottom: -10px;
        border-radius: 25px;
    }
    
    .hero-image-frame {
        top: -30px;
        left: -30px;
        right: -30px;
        bottom: -30px;
        border-radius: 35px;
    }
    
    .heroSwiper .swiper-button-next,
    .heroSwiper .swiper-button-prev {
        width: 50px;
        height: 50px;
        margin-top: -25px;
    }
    
    .heroSwiper .swiper-button-next::after,
    .heroSwiper .swiper-button-prev::after {
        font-size: 18px;
    }
    
    .heroSwiper .swiper-button-next {
        right: 30px;
    }
    
    .heroSwiper .swiper-button-prev {
        left: 30px;
    }
}

@media screen and (max-width: 768px) {
    .hero-section {
        height: 75vh;
        min-height: 500px;
        max-height: 650px;
    }
    
    .hero-layout {
        display: flex;
        flex-direction: column;
        text-align: center;
        gap: 40px;
        padding: 40px 0;
        grid-template-columns: unset;
    }
    
    .hero-content {
        grid-column: unset;
        max-width: 100%;
        order: 2;
        text-align: center;
        padding-right: 0;
    }
    
    .hero-content h2 {
        font-size: clamp(24px, 6vw, 36px);
        margin-bottom: 20px;
    }
    
    .hero-content .subtitle {
        font-size: clamp(16px, 4vw, 18px);
        margin-bottom: 28px;
    }
    
    .hero-image {
        grid-column: unset;
        order: 1;
        max-width: 100%;
        margin: 0 auto;
        justify-self: unset;
    }
    
    .hero-image-container {
        max-width: 350px;
        margin: 0 auto;
    }
    
    .hero-image::before {
        top: -15px;
        left: -15px;
        right: -15px;
        bottom: -15px;
        border-radius: 30px;
    }
    
    .hero-image::after {
        top: -8px;
        left: -8px;
        right: -8px;
        bottom: -8px;
        border-radius: 20px;
    }
    
    .hero-image-frame {
        top: -25px;
        left: -25px;
        right: -25px;
        bottom: -25px;
        border-radius: 30px;
    }
    
    .hero-image-decorations::before {
        width: 35px;
        height: 35px;
        top: -15px;
        right: -15px;
    }
    
    .hero-image-decorations::after {
        width: 25px;
        height: 25px;
        bottom: -10px;
        left: -10px;
    }
    
    .cta-buttons {
        justify-content: center;
        gap: 15px;
    }
    
    .hero-section .btn {
        padding: 14px 28px;
        font-size: 14px;
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
        right: 20px;
    }
    
    .heroSwiper .swiper-button-prev {
        left: 20px;
    }
    
    .heroSwiper .swiper-pagination {
        bottom: 30px;
    }
    
    .heroSwiper .swiper-pagination-bullet {
        width: 14px;
        height: 14px;
        margin: 0 6px;
    }
}

@media screen and (max-width: 480px) {
    .hero-section {
        height: 65vh;
        min-height: 450px;
        max-height: 550px;
    }
    
    .hero-layout {
        padding: 30px 0;
        gap: 30px;
    }
    
    .hero-content h2 {
        font-size: clamp(20px, 7vw, 28px);
        line-height: 1.3;
        margin-bottom: 16px;
    }
    
    .hero-content .subtitle {
        font-size: clamp(14px, 4vw, 16px);
        margin-bottom: 24px;
    }
    
    .hero-image-container {
        max-width: 280px;
        aspect-ratio: 5/4;
    }
    
    .hero-image::before {
        top: -10px;
        left: -10px;
        right: -10px;
        bottom: -10px;
        border-radius: 25px;
    }
    
    .hero-image::after {
        top: -5px;
        left: -5px;
        right: -5px;
        bottom: -5px;
        border-radius: 15px;
    }
    
    .hero-image-frame {
        top: -20px;
        left: -20px;
        right: -20px;
        bottom: -20px;
        border-radius: 25px;
    }
    
    .hero-image-decorations::before {
        width: 30px;
        height: 30px;
        top: -12px;
        right: -12px;
    }
    
    .hero-image-decorations::after {
        width: 20px;
        height: 20px;
        bottom: -8px;
        left: -8px;
    }
    
    .cta-buttons {
        flex-direction: column;
        width: 100%;
    }
    
    .hero-section .btn {
        width: 100%;
        text-align: center;
        padding: 12px 24px;
        font-size: 13px;
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
        margin: 0 4px;
    }
    
    .container {
        padding: 0 15px;
    }
}

/* Touch device optimizations */
@media (hover: none) and (pointer: coarse) {
    .hero-image:hover img {
        transform: none;
        filter: none;
    }
    
    .heroSwiper .swiper-button-next:hover,
    .heroSwiper .swiper-button-prev:hover {
        transform: none;
        background: rgba(255, 255, 255, 0.15);
    }
    
    .hero-section .btn:hover {
        transform: none;
        box-shadow: none;
    }
    
    .hero-image::before {
        animation: none;
    }
    
    .hero-image-decorations::before,
    .hero-image-decorations::after {
        animation: none;
    }
}

/* Accessibility improvements */
@media (prefers-reduced-motion: reduce) {
    .hero-content,
    .hero-image {
        animation: none;
    }
    
    .hero-image img,
    .heroSwiper .swiper-button-next,
    .heroSwiper .swiper-button-prev,
    .hero-section .btn {
        transition: none;
    }
    
    .hero-image::before {
        animation: none;
    }
    
    .hero-image-decorations::before,
    .hero-image-decorations::after {
        animation: none;
    }
}

/* Loading State */
.hero-section.loading {
    opacity: 0;
    transition: opacity 0.8s ease;
}

.hero-section:not(.loading) {
    opacity: 1;
}

/* Scroll Animations */
.section {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.8s ease, transform 0.8s ease;
}

.section.animate-in {
    opacity: 1;
    transform: translateY(0);
}

/* Performance Optimizations */
.hero-image img {
    will-change: transform;
    backface-visibility: hidden;
    transform: translateZ(0);
}

/* Enhanced button interactions */
.hero-section .btn {
    position: relative;
    z-index: 1;
}

.hero-section .btn:focus {
    outline: 2px solid rgba(255, 255, 255, 0.6);
    outline-offset: 2px;
}

.hero-section .btn:active {
    transform: translateY(1px);
}

/* Swiper accessibility improvements */
.heroSwiper .swiper-button-next:focus,
.heroSwiper .swiper-button-prev:focus {
    outline: 2px solid rgba(255, 255, 255, 0.8);
    outline-offset: 2px;
}

.heroSwiper .swiper-pagination-bullet:focus {
    outline: 2px solid rgba(255, 255, 255, 0.8);
    outline-offset: 2px;
}

/* Smooth transitions for responsive changes */
.hero-layout,
.hero-content,
.hero-image {
    transition: all 0.3s ease;
}
</style>



<main id="content" class="alumni-landing-page">
    <!-- <div class="hero-section">
        <div class="hero-slider swiper heroSwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide hero-slide" style="background-image: url('assets/images/campus.jpg');">
                    <div class="container">
                        <div class="hero-content">
                            <h2>À vos agendas : cycle de réunions mensuelles</h2>
                            <p class="subtitle">Réunion du 13/03/2025</p>
                            <?php if (!is_user_logged_in()) : ?>
                            <div class="cta-buttons">
                                <a href="#" class="btn btn-secondary">En savoir plus</a>
                            </div>
                            <?php else: ?>
                            <div class="welcome-back">
                                <p>Heureux de vous revoir, <?php echo wp_get_current_user()->display_name; ?></p>
                                <a href="#" class="btn btn-primary">Mon tableau de bord</a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div> -->

    <!-- carousel Section -->
    <div class="hero-section">
        <div class="hero-slider swiper heroSwiper">
            <div class="swiper-wrapper">
                <!-- Slide 1 -->
                <div class="swiper-slide hero-slide">
                    <div class="hero-background"></div>
                    <div class="container">
                        <div class="hero-layout">
                            <div class="hero-content">
                                <h2>Soirée Louvre Abu Dhabi Roof Top Bar ESG Alumni Groupe Moyen-Orient</h2>
                                <div class="cta-buttons">
                                    <a href="#" class="btn btn-secondary">LIRE LA SUITE</a>
                                </div>
                            </div>
                            <div class="hero-image">
                                <div class="hero-image-frame"></div>
                                <div class="hero-image-container">
                                    <img src="https://images.unsplash.com/photo-1562774053-701939374585?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Soirée Louvre Abu Dhabi">
                                    <div class="hero-image-decorations"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Slide 2 -->
                <div class="swiper-slide hero-slide">
                    <div class="hero-background"></div>
                    <div class="container">
                        <div class="hero-layout">
                            <div class="hero-content">
                                <h2>À vos agendas : cycle de réunions mensuelles</h2>
                                <p class="subtitle">Réunion du 13/03/2025</p>
                                <!-- <?php if (!is_user_logged_in()) : ?>
                                <div class="cta-buttons">
                                    <a href="#" class="btn btn-secondary">EN SAVOIR PLUS</a>
                                </div>
                                <?php else: ?>
                                <div class="welcome-back">
                                    <p>Heureux de vous revoir, <?php echo wp_get_current_user()->display_name; ?></p>
                                    <a href="#" class="btn btn-primary">Mon tableau de bord</a>
                                </div>
                                <?php endif; ?> -->
                                <div class="cta-buttons">
                                    <a href="#" class="btn btn-secondary">REJOINDRE LE RÉSEAU</a>
                                </div>
                            </div>
                            <div class="hero-image">
                                <div class="hero-image-frame"></div>
                                <div class="hero-image-container">
                                    <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Réunions mensuelles">
                                    <div class="hero-image-decorations"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Slide 3 -->
                <div class="swiper-slide hero-slide">
                    <div class="hero-background"></div>
                    <div class="container">
                        <div class="hero-layout">
                            <div class="hero-content">
                                <h2>Réseau Alumni ESG</h2>
                                <p class="subtitle">Connectez-vous avec plus de 50 000 diplômés</p>
                                <div class="cta-buttons">
                                    <a href="#" class="btn btn-secondary">REJOINDRE LE RÉSEAU</a>
                                </div>
                            </div>
                            <div class="hero-image">
                                <div class="hero-image-frame"></div>
                                <div class="hero-image-container">
                                    <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Réseau Alumni">
                                    <div class="hero-image-decorations"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Pagination dots -->
            <div class="swiper-pagination"></div>
            
            <!-- Navigation arrows -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
    
    <!-- actualités et événements -->
    <div class="container row mt-5 d-flex align-items-center">
        <!-- News Section -->
        <div class="col-lg-4">
            <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 18px;">Actualités</h3>
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <!-- News Item 1 -->
                <div style="display: flex; gap: 10px; align-items: flex-start;">
                    <div style="width: 56px; height: 56px; background: #e74c3c; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                        <span style="color: #fff; font-weight: bold; font-size: 22px;">Logo</span>
                    </div>
                    <div>
                        <div style="font-size: 14px; font-weight: 600; color: #222;">Ouverture Inscriptions, concours pour la rentrée</div>
                        <div style="font-size: 12px; color: #888;">27 mars 2024</div>
                    </div>
                </div>
                <!-- News Item 2 -->
                <div style="display: flex; gap: 10px; align-items: flex-start;">
                    <div style="width: 56px; height: 56px; background: #e74c3c; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                        <span style="color: #fff; font-weight: bold; font-size: 22px;">Logo</span>
                    </div>
                    <div>
                        <div style="font-size: 14px; font-weight: 600; color: #222;">Conférence sur la transition écologique en France</div>
                        <div style="font-size: 12px; color: #888;">15 février 2024</div>
                    </div>
                </div>
                <!-- News Item 3 -->
                <div style="display: flex; gap: 10px; align-items: flex-start;">
                    <div style="width: 56px; height: 56px; background: #e74c3c; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                        <span style="color: #fff; font-weight: bold; font-size: 22px;">Logo</span>
                    </div>
                    <div>
                        <div style="font-size: 14px; font-weight: 600; color: #222;">Réhabilitation ancienne bibliothèque</div>
                        <div style="font-size: 12px; color: #888;">12 janvier 2024</div>
                    </div>
                </div>
                <!-- News Item 4 -->
                <div style="display: flex; gap: 10px; align-items: flex-start;">
                    <div style="width: 56px; height: 56px; background: #e74c3c; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                        <span style="color: #fff; font-weight: bold; font-size: 22px;">Logo</span>
                    </div>
                    <div>
                        <div style="font-size: 14px; font-weight: 600; color: #222;">Les anciens lauréats en guest lecture</div>
                        <div style="font-size: 12px; color: #888;">2 octobre 2024</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Events Section -->
        <div class="col-lg-8">
            <!-- Cyan background container -->
            <div style="position: relative; padding: 20px;">
                <!-- Cyan background positioned on the right 50% -->
                <div style="position: absolute; top: 0; right: 0; width: 60%; height: 100%; background: #0b1c39;"></div>
                <h3 style="font-size: 18px; font-weight: 600;">Événements</h3>

                <!-- Event cards positioned above the background -->
                <div class="row g-3 position-relative" style="z-index: 2;">
                    <!-- Event Card 1 -->
                    <div class="col-6">
                        <div class="position-relative rounded overflow-hidden" style="background: url('https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80') center/cover; height: 180px;">
                            <div class="position-absolute top-0 start-0 h-100 p-3 d-flex flex-column justify-content-center text-white" style="width: 50%;">
                                <div class="fs-4 fw-bold mb-1">13.03</div>
                                <div style="font-size: 12px; line-height: 1.3;">★ À vos agendas : cycle de réunions mensuelles- Réunion du...</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Event Card 2 -->
                    <div class="col-6">
                        <div class="position-relative rounded overflow-hidden" style="background: url('https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80') center/cover; height: 180px;">
                            <div class="position-absolute top-0 start-0 h-100 p-3 d-flex flex-column justify-content-center text-white" style="width: 50%;">
                                <div class="fs-4 fw-bold mb-1">13.03</div>
                                <div style="font-size: 12px; line-height: 1.3;">★ À vos agendas : cycle de réunions mensuelles- Réunion du...</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Event Card 3 -->
                    <div class="col-6">
                        <div class="position-relative rounded overflow-hidden" style="background: url('https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80') center/cover; height: 180px;">
                            <div class="position-absolute top-0 start-0 h-100 p-3 d-flex flex-column justify-content-center text-white" style="width: 50%;">
                                <div class="fs-4 fw-bold mb-1">★</div>
                                <div style="font-size: 12px; line-height: 1.3;">Mobilité de demain : Performance économique ou développement...</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Event Card 4 -->
                    <div class="col-6">
                        <div class="position-relative rounded overflow-hidden" style="background: url('https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80') center/cover; height: 180px;">
                            <div class="position-absolute top-0 start-0 h-100 p-3 d-flex flex-column justify-content-center text-white" style="width: 50%;">
                                <div class="fs-4 fw-bold mb-1">10.04</div>
                                <div style="font-size: 12px; line-height: 1.3;">★ ASSEMBLÉE RÉGIONALE de notre GR à l'occasion de la Réunion du...</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 position-relative">
        <div class="bg-secondary text-white fw-bold text-center py-5">
            <h3>Recherche Annuaire</h3>
        </div>
        
        <!-- Floating Search Bar Section -->
        <div class="position-absolute w-100 d-flex justify-content-center" style="top: 17%; transform: translateY(-50%); z-index: 10;">
            <div class="position-relative" style="width: 100%; max-width: 500px;">
                <input type="text" class="form-control pe-5 shadow" placeholder="Nom, prénom ou entreprise..." style="height: 50px; border: 2px solid #ddd; padding-left: 20px; font-size: 16px; background: white;">
                <button class="btn position-absolute top-50 end-0 translate-middle-y me-2" style="background: none; border: none; color: #666;">
                    <i class="fas fa-search" style="font-size: 18px;"></i>
                </button>
            </div>
        </div>
        
        <img style="width: 100%; height: 400px; object-fit: cover;" src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" alt="">
     
            <div style="background-color: #0b1c39">
                <div class="text-center pt-4 pb-3" style="color: #d4af37;">
                    <h3>ESG Alumni c'est...</h3>
                </div>
                <div class="container py-2">
                    <div class="row justify-content-center">
                        <!-- Statistic Circle 1 -->
                        <div class="col-6 col-md-3 text-center mb-4">
                            <div class="stat-circle mx-auto mb-3" style="width: 120px; height: 120px; border: 3px solid white; border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                <div style="font-size: 24px; font-weight: bold; color: white;">127 748</div>
                                <div style="font-size: 12px; color: white; opacity: 0.9;">diplômés</div>
                            </div>
                        </div>
                        
                        <!-- Statistic Circle 2 -->
                        <div class="col-6 col-md-3 text-center mb-4">
                            <div class="stat-circle mx-auto mb-3" style="width: 120px; height: 120px; border: 3px solid white; border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                <div style="font-size: 24px; font-weight: bold; color: white;">21 134</div>
                                <div style="font-size: 12px; color: white; opacity: 0.9;">entreprises</div>
                            </div>
                        </div>
                        
                        <!-- Statistic Circle 3 -->
                        <div class="col-6 col-md-3 text-center mb-4">
                            <div class="stat-circle mx-auto mb-3" style="width: 120px; height: 120px; border: 3px solid white; border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                <div style="font-size: 24px; font-weight: bold; color: white;">4 714</div>
                                <div style="font-size: 12px; color: white; opacity: 0.9;">étudiants</div>
                            </div>
                        </div>
                        
                        <!-- Statistic Circle 4 -->
                        <div class="col-6 col-md-3 text-center mb-4">
                            <div class="stat-circle mx-auto mb-3" style="width: 120px; height: 120px; border: 3px solid white; border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                <div style="font-size: 24px; font-weight: bold; color: white;">47</div>
                                <div style="font-size: 12px; color: white; opacity: 0.9;">pays</div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>

    <!-- Job Offers Section -->
    <div style="background-image: url('https://images.unsplash.com/photo-1521737604893-d14cc237f11d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80'); background-size: cover; background-position: center; position: relative;">
        <!-- Dark overlay -->
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.7);"></div>
        
        <div class="container position-relative" style="z-index: 2; padding: 60px 20px;">
            <!-- Section Title -->
            <div class="text-center mb-5">
                <h2 style="color: white; font-size: 32px; font-weight: 700; margin-bottom: 40px;">Offres d'emploi</h2>
            </div>
            
            <!-- Job Cards Grid -->
            <div class="row g-4 mb-5 container" style="align-items: stretch;">
                <!-- Job Card 1 -->
                <div class="col-lg-4 col-md-6 d-flex">
                    <div class="position-relative w-100">
                        <!-- Logo positioned above the card -->
                        <div style="position: absolute; top: -5px; left: 50%; transform: translateX(-50%); z-index: 10; width: 50px; height: 50px; background: linear-gradient(135deg, #4a90e2, #357abd); border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                            <span style="color: white; font-weight: bold; font-size: 9px; text-align: center; line-height: 1.2;">Éléments</span>
                        </div>
                        
                        <div class="bg-white rounded overflow-hidden h-100 d-flex flex-column" style="box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-top: 25px; min-height: 200px;">
                            <!-- Header with Date and Company -->
                            <div class="p-3 pt-4">
                                <div style="font-size: 11px; color: #888;" class="my-3">04 FÉVRIER 2025</div>
                                <div style="font-size: 13px; font-weight: 600; color: #4a90e2;">Éléments Ingénieries</div>
                            </div>
                            
                            <!-- Job Title -->
                            <div class="px-3 pb-3 flex-grow-1">
                                <h5 style="font-size: 14px; font-weight: 600; color: #333; line-height: 1.3; margin: 0;">
                                    CHEF(FE) DE PROJET ENVIRONNEMENT
                                </h5>
                            </div>
                            
                            <!-- Apply Button -->
                            <div class="p-3 pt-0 mt-auto">
                                <button class="btn w-100 text-white" style="background-color: #0b1c39; border: none; padding: 10px; font-weight: 600; font-size: 13px; border-radius: 4px;">
                                    POSTULER
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Job Card 2 -->
                <div class="col-lg-4 col-md-6 d-flex">
                    <div class="position-relative w-100">
                        <!-- Logo positioned above the card -->
                        <div style="position: absolute; top: -5px; left: 50%; transform: translateX(-50%); z-index: 10; width: 50px; height: 50px; background: linear-gradient(135deg, #e74c3c, #c0392b); border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                            <span style="color: white; font-weight: bold; font-size: 9px; text-align: center; line-height: 1.2;">A+P</span>
                        </div>
                        
                        <div class="bg-white rounded overflow-hidden h-100 d-flex flex-column" style="box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-top: 25px; min-height: 200px;">
                            <!-- Header with Date and Company -->
                            <div class="p-3 pt-4">
                                <div style="font-size: 11px; color: #888;" class="my-3">30 JANVIER 2025</div>
                                <div style="font-size: 13px; font-weight: 600; color: #4a90e2;">A+P KIEFFER OMNITEC</div>
                            </div>
                            
                            <!-- Job Title -->
                            <div class="px-3 pb-3 flex-grow-1">
                                <h5 style="font-size: 14px; font-weight: 600; color: #333; line-height: 1.3; margin: 0;">
                                    INGÉNIEUR MAINTENANCE
                                </h5>
                            </div>
                            
                            <!-- Apply Button -->
                            <div class="p-3 pt-0 mt-auto">
                                <button class="btn w-100 text-white" style="background-color: #0b1c39; border: none; padding: 10px; font-weight: 600; font-size: 13px; border-radius: 4px;">
                                    POSTULER
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Job Card 3 -->
                <div class="col-lg-4 col-md-6 d-flex">
                    <div class="position-relative w-100">
                        <!-- Logo positioned above the card -->
                        <div style="position: absolute; top: -5px; left: 50%; transform: translateX(-50%); z-index: 10; width: 50px; height: 50px; background: linear-gradient(135deg, #2c3e50, #34495e); border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                            <span style="color: white; font-weight: bold; font-size: 9px; text-align: center; line-height: 1.2;">AQUA</span>
                        </div>
                        
                        <div class="bg-white rounded overflow-hidden h-100 d-flex flex-column" style="box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-top: 25px; min-height: 200px;">
                            <!-- Header with Date and Company -->
                            <div class="p-3 pt-4">
                                <div style="font-size: 11px; color: #888;" class="my-3">30 JANVIER 2025</div>
                                <div style="font-size: 13px; font-weight: 600; color: #4a90e2;">AQUALUNG GROUP</div>
                            </div>
                            
                            <!-- Job Title -->
                            <div class="px-3 pb-3 flex-grow-1">
                                <h5 style="font-size: 14px; font-weight: 600; color: #333; line-height: 1.3; margin: 0;">
                                    STAGE INGÉNIEUR MÉCANIQUE
                                </h5>
                            </div>
                            
                            <!-- Apply Button -->
                            <div class="p-3 pt-0 mt-auto">
                                <button class="btn w-100 text-white" style="background-color: #0b1c39; border: none; padding: 10px; font-weight: 600; font-size: 13px; border-radius: 4px;">
                                    POSTULER
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- View All Offers Button -->
            <div class="text-center mt-2">
                <a href="#" class=" toutes_les_offres px-3 py-2" style="color: white; text-decoration: none; font-weight: 600;">
                    <i class="fas fa-chevron-right me-2"></i>TOUTES LES OFFRES
                </a>
            </div>
        </div>
    </div>
    
    <!-- Groups Section -->
    <div style="background-color: #0b1c39; padding: 60px 0;">
        <div class="container">
            <div class="row text-center">
                <!-- Regional Groups -->
                <div class="col-lg-4 col-md-4 mb-4">
                    <div class="text-white">
                        <div class="mb-3">
                            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2L13.09 8.26L20 9L13.09 9.74L12 16L10.91 9.74L4 9L10.91 8.26L12 2Z" stroke="#d4af37" stroke-width="2" fill="#d4af37"/>
                                <circle cx="12" cy="12" r="8" stroke="#d4af37" stroke-width="2" fill="none"/>
                            </svg>
                        </div>
                        <h4 style="font-size: 16px; font-weight: 600; margin-bottom: 10px;">GROUPES RÉGIONAUX</h4>
                    </div>
                </div>
                
                <!-- International Groups -->
                <div class="col-lg-4 col-md-4 mb-4">
                    <div class="text-white">
                        <div class="mb-3">
                            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="10" stroke="#d4af37" stroke-width="2" fill="none"/>
                                <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" stroke="#d4af37" stroke-width="2"/>
                            </svg>
                        </div>
                        <h4 style="font-size: 16px; font-weight: 600; margin-bottom: 10px;">GROUPES INTERNATIONAUX</h4>
                    </div>
                </div>
                
                <!-- Professional Groups -->
                <div class="col-lg-4 col-md-4 mb-4">
                    <div class="text-white">
                        <div class="mb-3">
                            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="2" y="3" width="20" height="14" rx="2" ry="2" stroke="#d4af37" stroke-width="2" fill="none"/>
                                <line x1="8" y1="21" x2="16" y2="21" stroke="#d4af37" stroke-width="2"/>
                                <line x1="12" y1="17" x2="12" y2="21" stroke="#d4af37" stroke-width="2"/>
                            </svg>
                        </div>
                        <h4 style="font-size: 16px; font-weight: 600; margin-bottom: 10px;">GROUPES PROFESSIONNELS</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Partners Section -->
    <div style="background-color: #f8f9fa; padding: 60px 0;">
        <div class="container">
            <div class="text-center mb-5">
                <h2 style="color: #333; font-size: 28px; font-weight: 700;">Partenaires</h2>
            </div>
            
            <!-- Partners Slider -->
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-2 col-md-3 col-6 text-center mb-4">
                    <img src="https://via.placeholder.com/150x80/e74c3c/ffffff?text=GROUPE+INSA" alt="Groupe INSA" style="max-height: 60px; width: auto;">
                </div>
                <div class="col-lg-2 col-md-3 col-6 text-center mb-4">
                    <img src="https://via.placeholder.com/150x80/2ecc71/ffffff?text=PARTNER" alt="Partner" style="max-height: 60px; width: auto;">
                </div>
                <div class="col-lg-2 col-md-3 col-6 text-center mb-4">
                    <img src="https://via.placeholder.com/150x80/e74c3c/ffffff?text=INSA+GR" alt="INSA GR" style="max-height: 60px; width: auto;">
                </div>
                <div class="col-lg-2 col-md-3 col-6 text-center mb-4">
                    <img src="https://via.placeholder.com/150x80/e74c3c/ffffff?text=AEI+INSA" alt="AEI INSA" style="max-height: 60px; width: auto;">
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="section events-section">
        <div class="container">
            <div class="section-header">
                <h2>Événements à venir</h2>
                <a href="<?php echo esc_url(site_url('/liste-des-evenements')); ?>" class="view-all">Voir tous les événements</a>
            </div>
            <div class="events-grid">
                <?php
                $events = new WP_Query([
                    'post_type' => 'evenements',
                    'posts_per_page' => 3,
                    'post_status' => 'publish',
                    'meta_query' => [
                        [
                            'key' => 'date_evenement',
                            'value' => date('Y-m-d'),
                            'compare' => '>=',
                            'type' => 'DATE'
                        ]
                    ],
                    'orderby' => 'meta_value',
                    'meta_key' => 'date_evenement',
                    'order' => 'ASC'
                ]);

                if ($events->have_posts()) :
                    while ($events->have_posts()) :
                        $events->the_post();
                        
                        // Récupérer les informations de l'événement
                        $titre = get_field('titre_evenement');
                        $date = get_field('date_evenement');
                        $lieu = get_field('lieu_evenement') ?: get_the_terms(get_the_ID(), 'localisations')[0]->name ?? '';
                        $type = get_the_terms(get_the_ID(), 'types_evenement')[0]->name ?? '';
                        
                        // Vérifier si les documents associés sont restreints
                        $is_restricted = get_field('acces_restreint');
                        
                        // Formater la date
                        $date_formatted = date_i18n('d M Y', strtotime($date));
                        ?>
                        <div class="event-card">
                            <div class="event-content">
                                <div class="event-meta">
                                    <span class="event-date"><?php echo $date_formatted; ?></span>
                                    <?php if (!empty($type)) : ?>
                                    <span class="event-type"><?php echo $type; ?></span>
                                    <?php endif; ?>
                                </div>
                                <h3 class="event-title"><?php echo $titre; ?></h3>
                                <?php if (!empty($lieu)) : ?>
                                <p class="event-location"><i class="fas fa-map-marker-alt"></i> <?php echo $lieu; ?></p>
                                <?php endif; ?>
                                <div class="event-excerpt">
                                    <?php echo wp_trim_words(get_field('description_evenement'), 20); ?>
                                </div>
                                <div class="event-actions">
                                    <a href="<?php the_permalink(); ?>" class="btn btn-outline">En savoir plus</a>
                                    <?php if (!$is_restricted || is_user_logged_in()) : ?>
                                    <a href="<?php the_permalink(); ?>#inscription" class="btn btn-primary">S'inscrire</a>
                                    <?php else : ?>
                                    <a href="<?php echo esc_url(site_url('/connexion-etudiant')); ?>?redirect_to=<?php echo urlencode(get_permalink() . '#inscription'); ?>" class="btn btn-restricted">
                                        <i class="fas fa-lock"></i> Postuler
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo '<div class="no-events"><p>Aucun événement à venir pour le moment.</p></div>';
                endif;
                ?>
            </div>
        </div>
    </div> -->

    <!-- <div class="section job-offers-section">
        <div class="container">
            <div class="section-header">
                <h2>Offres d'emploi récentes</h2>
                <a href="<?php echo esc_url(site_url('/offres-emploi')); ?>" class="view-all">Voir toutes les offres</a>
            </div>
            <div class="job-offers-grid">
                <?php
                $jobs = new WP_Query([
                    'post_type' => 'offres_emploi',
                    'posts_per_page' => 3,
                    'post_status' => 'publish',
                    'orderby' => 'date',
                    'order' => 'DESC'
                ]);

                if ($jobs->have_posts()) :
                    while ($jobs->have_posts()) :
                        $jobs->the_post();
                        
                        // Récupérer les informations de l'offre
                        $poste = get_field('intitule_poste');
                        $entreprise_id = get_field('entreprise_associee');
                        $entreprise_nom = '';
                        
                        if ($entreprise_id) {
                            $entreprise_nom = get_field('nom_entreprise', $entreprise_id);
                        }
                        
                        $type_contrat = get_field('type_contrat');
                        $lieu = get_field('lieu_poste') ?: get_the_terms($entreprise_id, 'localisations')[0]->name ?? '';
                        ?>
                        <div class="job-card">
                            <div class="job-content">
                                <h3 class="job-title"><?php echo $poste; ?></h3>
                                <?php if (!empty($entreprise_nom)) : ?>
                                <p class="job-company"><i class="fas fa-building"></i> <?php echo $entreprise_nom; ?></p>
                                <?php endif; ?>
                                <?php if (!empty($lieu)) : ?>
                                <p class="job-location"><i class="fas fa-map-marker-alt"></i> <?php echo $lieu; ?></p>
                                <?php endif; ?>
                                <?php if (!empty($type_contrat)) : ?>
                                <p class="job-type"><i class="fas fa-file-contract"></i> <?php echo $type_contrat; ?></p>
                                <?php endif; ?>
                                <div class="job-excerpt">
                                    <?php echo wp_trim_words(get_field('description_poste'), 20); ?>
                                </div>
                                <div class="job-actions">
                                    <a href="<?php the_permalink(); ?>" class="btn btn-outline">Voir le détail</a>
                                    <?php if (is_user_logged_in()) : ?>
                                    <a href="<?php the_permalink(); ?>#postuler" class="btn btn-primary">Postuler</a>
                                    <?php else : ?>
                                    <a href="<?php echo esc_url(site_url('/connexion-etudiant')); ?>?redirect_to=<?php echo urlencode(get_permalink() . '#postuler'); ?>" class="btn btn-restricted">
                                        <i class="fas fa-lock"></i> Postuler
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo '<div class="no-jobs"><p>Aucune offre d\'emploi disponible pour le moment.</p></div>';
                endif;
                ?>
            </div>
        </div>
    </div> -->

    <!-- <div class="section companies-section">
        <div class="container">
            <div class="section-header">
                <h2>Entreprises partenaires</h2>
                <a href="<?php echo esc_url(site_url('/entreprises-partenaires')); ?>" class="view-all">Voir toutes les entreprises</a>
            </div>
            
            <div style="background:white;border-radius:8px;padding:25px;margin:40px 0 30px;box-shadow:0 2px 8px rgba(0,0,0,0.05);">
                <div class="swiper partnerSlider" style="padding:10px 0;">
                    <div class="swiper-wrapper">
                        <?php
                        $companies = new WP_Query([
                            'post_type' => 'entreprises',
                            'posts_per_page' => -1,
                            'orderby' => 'title',
                            'order' => 'ASC'
                        ]);

                        if ($companies->have_posts()) :
                            while ($companies->have_posts()) : $companies->the_post();
                                $company_id = get_the_ID();
                                $nom = get_field('nom_entreprise', $company_id);
                                $logo = get_field('logo', $company_id);
                                $secteurs = wp_get_post_terms($company_id, 'secteurs_activite', ['fields' => 'names']);
                        ?>
                                <div class="swiper-slide" style="height:150px;display:flex;align-items:center;justify-content:center;">
                                    <a href="<?php echo get_permalink(); ?>" style="display:flex;flex-direction:column;align-items:center;justify-content:center;width:100%;height:100%;padding:15px;text-align:center;gap:15px;">
                                        <div style="height:80px;display:flex;align-items:center;justify-content:center;">
                                            <?php if ($logo) : ?>
                                                <img src="<?php echo esc_url($logo['url']); ?>"
                                                    alt="<?php echo esc_attr($nom); ?>"
                                                    style="width:auto;height:100%;max-width:160px;object-fit:contain;">
                                            <?php else : ?>
                                                <div style="width:80px;height:80px;background:#f8f9fa;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                                    <i class="fas fa-building" style="font-size:30px;color:#bbb;"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div style="margin-top:auto;font-size:16px;color:var(--alumni-navy);font-weight:700;">
                                            <?php echo esc_html($nom); ?>
                                        </div>
                                        <?php if (!empty($secteurs)) : ?>
                                            <div style="font-size:12px;color:#666;">
                                                <?php echo esc_html(implode(', ', $secteurs)); ?>
                                            </div>
                                        <?php endif; ?>
                                    </a>
                                </div>
                        <?php
                            endwhile;
                            wp_reset_postdata();
                        else :
                            echo '<div class="no-companies"><p>Aucune entreprise partenaire pour le moment.</p></div>';
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Include Swiper JS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add loading class initially
            const heroSection = document.querySelector('.hero-section');
            if (heroSection) {
                heroSection.classList.add('loading');
            }

            // Initialize Hero Slider with enhanced configuration
            var heroSwiper = new Swiper('.heroSwiper', {
                slidesPerView: 1,
                spaceBetween: 0,
                loop: true,
                speed: 800,
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                    dynamicBullets: false,
                    renderBullet: function (index, className) {
                        return '<span class="' + className + '" aria-label="Slide ' + (index + 1) + '"></span>';
                    },
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                keyboard: {
                    enabled: true,
                    onlyInViewport: true,
                },
                a11y: {
                    prevSlideMessage: 'Diapositive précédente',
                    nextSlideMessage: 'Diapositive suivante',
                    paginationBulletMessage: 'Aller à la diapositive {{index}}',
                },
                on: {
                    init: function() {
                        // Remove loading class when initialized
                        if (heroSection) {
                            heroSection.classList.remove('loading');
                        }
                        
                        // Add slide change animations
                        this.slides.forEach((slide, index) => {
                            const content = slide.querySelector('.hero-content');
                            const image = slide.querySelector('.hero-image');
                            
                            if (index === 0) {
                                if (content) content.style.animationDelay = '0.2s';
                                if (image) image.style.animationDelay = '0.4s';
                            }
                        });
                    },
                    slideChange: function() {
                        const activeSlide = this.slides[this.activeIndex];
                        const content = activeSlide.querySelector('.hero-content');
                        const image = activeSlide.querySelector('.hero-image');
                        
                        // Reset and trigger animations
                        if (content) {
                            content.style.animation = 'none';
                            content.offsetHeight; // Force reflow
                            content.style.animation = 'fadeInLeft 0.8s ease-out forwards';
                        }
                        
                        if (image) {
                            image.style.animation = 'none';
                            image.offsetHeight; // Force reflow
                            image.style.animation = 'fadeInRight 0.8s ease-out forwards';
                        }
                    },
                    touchStart: function() {
                        // Pause autoplay on touch
                        this.autoplay.stop();
                    },
                    touchEnd: function() {
                        // Resume autoplay after touch
                        setTimeout(() => {
                            this.autoplay.start();
                        }, 2000);
                    }
                }
            });
            
            // Initialize Partner Slider with enhanced configuration
            var partnerSwiper = new Swiper('.partnerSlider', {
                slidesPerView: 4,
                spaceBetween: 30,
                loop: true,
                speed: 600,
                autoplay: {
                    delay: 3500,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
                grabCursor: true,
                watchSlidesProgress: true,
                breakpoints: {
                    320: {
                        slidesPerView: 1,
                        spaceBetween: 20,
                    },
                    480: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 30,
                    },
                    1024: {
                        slidesPerView: 4,
                        spaceBetween: 30,
                    },
                },
                on: {
                    progress: function() {
                        // Add parallax effect to partner slides
                        for (let i = 0; i < this.slides.length; i++) {
                            const slide = this.slides[i];
                            const slideProgress = this.slides[i].progress;
                            const translate = slideProgress * 50;
                            slide.style.transform = `translateX(${translate}px)`;
                        }
                    }
                }
            });

            // Handle intersection observer for animations
            if ('IntersectionObserver' in window) {
                const observerOptions = {
                    threshold: 0.1,
                    rootMargin: '0px 0px -50px 0px'
                };

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('animate-in');
                        }
                    });
                }, observerOptions);

                // Observe sections for scroll animations
                document.querySelectorAll('.section').forEach(section => {
                    observer.observe(section);
                });
            }

            // Add performance optimizations
            // Preload next slide images
            heroSwiper.on('slideChange', function() {
                const nextIndex = (this.activeIndex + 1) % this.slides.length;
                const nextSlide = this.slides[nextIndex];
                const nextImage = nextSlide.querySelector('img');
                
                if (nextImage && !nextImage.complete) {
                    nextImage.loading = 'eager';
                }
            });

            // Handle window resize for responsive adjustments
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    if (heroSwiper) heroSwiper.update();
                    if (partnerSwiper) partnerSwiper.update();
                }, 250);
            });

            // Add smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Add loading states for images
            document.querySelectorAll('.hero-image img').forEach(img => {
                if (!img.complete) {
                    img.addEventListener('load', function() {
                        this.style.opacity = '1';
                        this.style.transform = 'scale(1)';
                    });
                    img.style.opacity = '0';
                    img.style.transform = 'scale(0.95)';
                    img.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                }
            });
        });
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