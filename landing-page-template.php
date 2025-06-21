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

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/landing-page.css">



<main id="content" class="alumni-landing-page">

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
        <!-- Events Section -->
        <div class="col-lg-9 mx-auto mt-4">
            <div class="news-card" style="background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden; display: flex; flex-direction: row;">
                <div style="flex: 1; padding: 24px; min-width: 0;">
                    <h4 style="font-size: 20px; font-weight: 700; color: #0b1c39; margin-bottom: 16px;">
                        Chers anciens de l'ESG, Préparez-vous à raviver les souvenirs !
                    </h4>
                    <div style="color: #666; font-size: 15px; line-height: 1.6; margin-bottom: 20px;">
                        <p><strong>📅 Date :</strong> Vendredi 20 juin 2025</p>
                        <p><strong>🕖 Heure :</strong> À partir de 19h</p>
                        <p><strong>📍 Lieu :</strong> Hôtel Sofitel Casablanca</p>
                        <p>Parce qu'il est temps de retrouver ceux avec qui on a (presque) révisé, ri, stressé, fêté… et surtout partagé des années inoubliables !</p>
                        <ul style="list-style: none; padding-left: 0;">
                            <li>🔹 Replongez dans l'ambiance d'antan – sans les partiels, mais avec les cocktails.</li>
                            <li>🔹 Anecdotes croustillantes fortement encouragées.</li>
                            <li>🔹 Bonne humeur obligatoire !</li>
                        </ul>
                        <p>🎉 Une soirée placée sous le signe de la convivialité et des retrouvailles.</p>
                        <p>👉 Bloquez la date, alertez les copains et retrouvez vos vieilles photos de classe !</p>
                        <p><em>Plus d'informations à venir très bientôt…</em></p>
                    </div>
                    <a href="connexion-etudiant" class="btn" style="background: #0b1c39; color: white; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: 600; display: inline-block;">
                        Je m'inscris
                    </a>
                </div>
                <div style="position: relative; width: 40%; min-width: 300px; max-width: 500px;">
                    <img src="https://esg-alumni.ma/wp-content/uploads/2025/06/soire-evenement.jpg" 
                         alt="Event Image" 
                         style="width: 100%; height: 100%; object-fit: cover;">
                    <div style="position: absolute; top: 16px; left: 16px; background: #0b1c39; color: white; padding: 8px 16px; border-radius: 4px; font-weight: 600;">
                        Soirée Alumni
                    </div>
                </div>
            </div>

            <style>
            </style>
        </div>
    </div>

    <div class="mt-5 position-relative">        
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
                                <div style="font-size: 24px; font-weight: bold; color: white;">
                                    <div class="counter" data-target="<?php
                                        $etudiant_query = new WP_Query([
                                            'post_type' => 'membres',
                                            'post_status' => 'publish',
                                            'tax_query' => [
                                                [
                                                    'taxonomy' => 'categories_membre',
                                                    'field'    => 'slug',
                                                    'terms'    => 'etudiant',
                                                ],
                                            ],
                                            'posts_per_page' => -1,
                                            'fields' => 'ids',
                                        ]);
                                        $diplomes_count = $etudiant_query->found_posts;
                                        echo number_format($diplomes_count);
                                        wp_reset_postdata();
                                        ?>">0</div>
                                </div>
                                <div style="font-size: 12px; color: white; opacity: 0.9;">diplômés</div>
                            </div>
                        </div>
                        
                        <!-- Statistic Circle 2 -->
                        <div class="col-6 col-md-3 text-center mb-4">
                            <div class="stat-circle mx-auto mb-3" style="width: 120px; height: 120px; border: 3px solid white; border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                <div style="font-size: 24px; font-weight: bold; color: white;">
                                    <div class="counter" data-target="<?php
                                        $entreprises_count = wp_count_posts('entreprises')->publish;
                                        echo number_format($entreprises_count);
                                        ?>">0</div>
                                </div>
                                <div style="font-size: 12px; color: white; opacity: 0.9;">entreprises</div>
                            </div>
                        </div>
                        
                        <!-- Statistic Circle 3 -->
                        <div class="col-6 col-md-3 text-center mb-4">
                            <div class="stat-circle mx-auto mb-3" style="width: 120px; height: 120px; border: 3px solid white; border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                <div style="font-size: 24px; font-weight: bold; color: white;">
                                    <div class="counter" data-target="<?php
                                        $etudiant_query = new WP_Query([
                                            'post_type' => 'membres',
                                            'post_status' => 'publish',
                                            'tax_query' => [
                                                [
                                                    'taxonomy' => 'categories_membre',
                                                    'field'    => 'slug',
                                                    'terms'    => 'Lauréat',
                                                ],
                                            ],
                                            'posts_per_page' => -1,
                                            'fields' => 'ids',
                                        ]);
                                        $diplomes_count = $etudiant_query->found_posts;
                                        echo number_format($diplomes_count);
                                        wp_reset_postdata();
                                        ?>">0</div>
                                </div>
                                <div style="font-size: 12px; color: white; opacity: 0.9;">étudiants</div>
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
    <div style=" padding: 60px 0;">
        <div class="container">
            <div class="row text-center">
                <!-- Regional Groups -->
                <div class="col-lg-4 col-md-4 mb-4">
                    <div class="text-white">
                        <div class="mb-3">
                            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2L13.09 8.26L20 9L13.09 9.74L12 16L10.91 9.74L4 9L10.91 8.26L12 2Z" stroke="#0b1c39" stroke-width="2" fill="#0b1c39"/>
                                <circle cx="12" cy="12" r="8" stroke="#0b1c39" stroke-width="2" fill="none"/>
                            </svg>
                        </div>
                        <h4 style="color: #0b1c39; font-size: 16px; font-weight: 600; margin-bottom: 10px;">GROUPES RÉGIONAUX</h4>
                    </div>
                </div>
                
                <!-- International Groups -->
                <div class="col-lg-4 col-md-4 mb-4">
                    <div class="text-white">
                        <div class="mb-3">
                            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="10" stroke="#0b1c39" stroke-width="2" fill="none"/>
                                <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" stroke="#0b1c39" stroke-width="2"/>
                            </svg>
                        </div>
                        <h4 style="color: #0b1c39; font-size: 16px; font-weight: 600; margin-bottom: 10px;">GROUPES INTERNATIONAUX</h4>
                    </div>
                </div>
                
                <!-- Professional Groups -->
                <div class="col-lg-4 col-md-4 mb-4">
                    <div class="text-white">
                        <div class="mb-3">
                            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="2" y="3" width="20" height="14" rx="2" ry="2" stroke="#0b1c39" stroke-width="2" fill="none"/>
                                <line x1="8" y1="21" x2="16" y2="21" stroke="#0b1c39" stroke-width="2"/>
                                <line x1="12" y1="17" x2="12" y2="21" stroke="#0b1c39" stroke-width="2"/>
                            </svg>
                        </div>
                        <h4 style="color: #0b1c39; font-size: 16px; font-weight: 600; margin-bottom: 10px;">GROUPES PROFESSIONNELS</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Partners Section -->
    <!-- <div style="background-color: #f8f9fa; padding: 60px 0;">
        <div class="container">
            <div class="text-center mb-5">
                <h2 style="color: #333; font-size: 28px; font-weight: 700;">Partenaires</h2>
            </div>
            
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
    </div> -->

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

<!-- Add this before the closing </body> tag -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('.counter');
    
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        const duration = 2000; // 2 seconds
        const step = target / (duration / 16); // 60fps
        let current = 0;
        
        const updateCounter = () => {
            current += step;
            if (current < target) {
                counter.textContent = Math.floor(current).toLocaleString();
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target.toLocaleString();
            }
        };
        
        updateCounter();
    });
});
</script>