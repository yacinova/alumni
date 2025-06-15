<?php

/**
 * Template Name: Dashboard Étudiant
 */
acf_form_head();
// Security check
if (!is_user_logged_in() || !current_user_can('etudiant')) {
    wp_redirect(site_url('/connexion-etudiant'));
    exit;
}

// Get current user info
$user = wp_get_current_user();
$user_id = $user->ID;

// Get student's name
$membre = get_posts([
    'post_type' => 'membres',
    'meta_key' => 'compte_associe',
    'meta_value' => $user_id,
    'numberposts' => 1
]);
$membre_id = $membre ? $membre[0]->ID : 0;
$prenom = get_field('prenom', $membre_id) ?: $user->first_name;

get_header('etudiant');
?>
<!-- Ajouter Swiper CSS et JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<div class="dashboard-container" style="background-color:#f5f7fa;min-height:calc(100vh - 200px);padding:30px 20px;">
    <div class="dashboard-content" style="max-width:1200px;margin:0 auto;">

        <!-- Welcome Banner -->
        <div class="welcome-card" style="background:linear-gradient(135deg, var(--alumni-navy), #194069);color:white;border-radius:8px;padding:25px;margin-bottom:30px;box-shadow:0 3px 10px rgba(0,0,0,0.1);">
            <h1 style="margin-top:0;font-size:24px;font-weight:600;color:var(--alumni-gold);">👋 Bienvenue, <?php echo esc_html($prenom); ?></h1>
            <p style="margin-bottom:5px;opacity:0.9;">Votre espace personnel pour suivre votre parcours et accéder aux ressources de l'ESG.</p>
        </div>



        <!-- Dashboard Grid -->
        <div class="dashboard-grid" style="display:grid;grid-template-columns:repeat(auto-fit, minmax(350px, 1fr));gap:25px;">

            <!-- Jobs Card -->
            <div class="dashboard-card" style="background:white;border-radius:8px;padding:25px;box-shadow:0 2px 8px rgba(0,0,0,0.05);transition:transform 0.2s ease,box-shadow 0.2s ease;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:15px;">
                    <h2 style="margin:0;font-size:18px;color:var(--alumni-navy);font-weight:600;">
                        <i class="fas fa-briefcase" style="color:var(--alumni-gold);margin-right:8px;"></i> Offres d'emploi
                    </h2>
                    <span style="background:var(--alumni-navy);color:white;font-size:12px;padding:3px 10px;border-radius:20px;font-weight:500;">Nouveau</span>
                </div>

                <div class="job-list" style="margin-bottom:15px;">
                    <?php
                    // Récupération des offres d'emploi avec requête personnalisée
                    $today = date('Ymd'); // Date du jour au format YYYYMMDD
                    $jobs = new WP_Query([
                        'post_type' => 'offres_emploi',
                        'posts_per_page' => 3,
                        'meta_query' => [
                            'relation' => 'AND',
                            [
                                'relation' => 'OR',
                                [
                                    'key' => 'date_expiration',
                                    'value' => $today,
                                    'compare' => '>=',
                                    'type' => 'DATE'
                                ],
                                [
                                    'key' => 'date_expiration',
                                    'compare' => 'NOT EXISTS'
                                ]
                            ],
                            // Exclude archived jobs
                            [
                                'relation' => 'OR',
                                [
                                    'key' => 'archive_status',
                                    'value' => 'archived',
                                    'compare' => '!='
                                ],
                                [
                                    'key' => 'archive_status',
                                    'compare' => 'NOT EXISTS'
                                ]
                            ]
                        ],
                        'orderby' => 'date',
                        'order' => 'DESC'
                    ]);

                    if ($jobs->have_posts()) :
                        echo '<ul style="list-style:none;padding:0;margin:0;">';
                        while ($jobs->have_posts()) : $jobs->the_post();
                            $job_id = get_the_ID();
                            $titre = get_field('intitule_poste', $job_id);
                            $expiration_raw = get_field('date_expiration', $job_id);
                            $expiration = $expiration_raw ? date_i18n('j F Y', strtotime($expiration_raw)) : 'Non définie';

                            // Informations de l'entreprise
                            $company_id = get_field('entreprise_associee', $job_id);
                            $company_name = '';
                            $company_logo = '';

                            if ($company_id) {
                                $company_name = get_field('nom_entreprise', $company_id);
                                $company_logo = get_field('logo', $company_id);
                            }

                            echo '<li style="padding:12px 0;border-bottom:1px solid #eee;display:flex;align-items:center;gap:12px;">';

                            // Logo de l'entreprise
                            echo '<div style="flex-shrink:0;width:40px;height:40px;display:flex;align-items:center;justify-content:center;background:#f8f9fa;border-radius:4px;overflow:hidden;">';
                            if ($company_logo) {
                                echo '<img src="' . esc_url($company_logo['url']) . '" alt="' . esc_attr($company_name) . '" style="max-width:100%;max-height:100%;object-fit:contain;">';
                            } else {
                                echo '<i class="fas fa-building" style="color:#bbb;font-size:16px;"></i>';
                            }
                            echo '</div>';

                            // Informations de l'offre
                            echo '<div style="flex-grow:1;">';
                            echo '<a href="' . get_permalink() . '" style="color:var(--alumni-navy);text-decoration:none;font-weight:500;display:block;">' . esc_html($titre) . '</a>';
                            echo '<div style="font-size:12px;color:#7f8c8d;margin-top:4px;display:flex;align-items:center;gap:8px;">';
                            if ($company_name) {
                                echo '<span>' . esc_html($company_name) . '</span>';
                                echo '<span style="display:inline-block;width:4px;height:4px;background:#ddd;border-radius:50%;"></span>';
                            }
                            echo '<span><i class="fas fa-calendar-times" style="margin-right:4px;"></i> Expire le ' . $expiration . '</span>';
                            echo '</div>';
                            echo '</div>';

                            echo '</li>';
                        endwhile;
                        echo '</ul>';
                        wp_reset_postdata();
                    else:
                        echo '<p style="color:#7f8c8d;font-style:italic;">Aucune offre disponible actuellement.</p>';
                    endif;
                    ?>
                </div>

                <a href="<?php echo site_url('/offres-emploi'); ?>" style="display:inline-block;color:var(--alumni-navy);text-decoration:none;font-weight:500;">
                    Voir toutes les offres <i class="fas fa-arrow-right" style="font-size:12px;margin-left:5px;"></i>
                </a>
            </div>

            <!-- Events Card -->
            <div class="dashboard-card" style="background:white;border-radius:8px;padding:25px;box-shadow:0 2px 8px rgba(0,0,0,0.05);transition:transform 0.2s ease,box-shadow 0.2s ease;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:15px;">
                    <h2 style="margin:0;font-size:18px;color:var(--alumni-navy);font-weight:600;">
                        <i class="fas fa-calendar-alt" style="color:var(--alumni-gold);margin-right:8px;"></i> Événements à venir
                    </h2>
                </div>

                <div class="events-list" style="margin-bottom:15px;">
                    <?php
                    // Récupération des événements avec requête personnalisée
                    $today = date('Ymd'); // Date du jour au format YYYYMMDD
                    $events = new WP_Query([
                        'post_type' => 'evenements',
                        'posts_per_page' => 3,
                        'meta_key' => 'date_evenement',
                        'orderby' => 'meta_value',
                        'order' => 'ASC',
                        'meta_query' => [
                            [
                                'key' => 'date_evenement',
                                'value' => $today,
                                'compare' => '>=',
                                'type' => 'DATE'
                            ]
                        ]
                    ]);

                    if ($events->have_posts()) :
                        echo '<ul style="list-style:none;padding:0;margin:0;">';
                        while ($events->have_posts()) : $events->the_post();
                            $event_id = get_the_ID();
                            $titre = get_field('titre_evenement', $event_id);
                            $date_raw = get_field('date_evenement', $event_id);
                            $date = $date_raw ? date_i18n('j F Y', strtotime($date_raw)) : '—';

                            // Récupération du type d'événement
                            $event_types = wp_get_post_terms($event_id, 'types_evenement', ['fields' => 'names']);
                            $event_type = !empty($event_types) ? implode(', ', $event_types) : '';

                            echo '<li style="padding:12px 0;border-bottom:1px solid #eee;display:flex;align-items:center;gap:12px;">';

                            // Icône de date
                            echo '<div style="flex-shrink:0;width:40px;height:40px;display:flex;flex-direction:column;align-items:center;justify-content:center;background:#f8f8ff;border-radius:4px;overflow:hidden;border:1px solid var(--alumni-gold-light);">';
                            if ($date_raw) {
                                $day = date_i18n('d', strtotime($date_raw));
                                $month = date_i18n('M', strtotime($date_raw));
                                echo '<span style="font-size:14px;font-weight:bold;color:var(--alumni-navy);line-height:1.2;">' . $day . '</span>';
                                echo '<span style="font-size:10px;text-transform:uppercase;color:var(--alumni-navy);line-height:1.2;">' . $month . '</span>';
                            } else {
                                echo '<i class="fas fa-calendar-alt" style="color:var(--alumni-gold);font-size:16px;"></i>';
                            }
                            echo '</div>';

                            // Informations de l'événement
                            echo '<div style="flex-grow:1;">';
                            echo '<a href="' . get_permalink() . '" style="color:var(--alumni-navy);text-decoration:none;font-weight:500;display:block;">' . esc_html($titre) . '</a>';
                            echo '<div style="font-size:12px;color:#7f8c8d;margin-top:4px;display:flex;align-items:center;gap:8px;">';
                            echo '<span><i class="fas fa-calendar-day" style="margin-right:4px;"></i> ' . $date . '</span>';
                            if ($event_type) {
                                echo '<span style="display:inline-block;width:4px;height:4px;background:#ddd;border-radius:50%;"></span>';
                                echo '<span><i class="fas fa-tag" style="margin-right:4px;"></i> ' . esc_html($event_type) . '</span>';
                            }
                            echo '</div>';
                            echo '</div>';

                            echo '</li>';
                        endwhile;
                        echo '</ul>';
                        wp_reset_postdata();
                    else:
                        echo '<p style="color:#7f8c8d;font-style:italic;">Aucun événement prévu actuellement.</p>';
                    endif;
                    ?>
                </div>

                <a href="<?php echo site_url('/liste-des-evenements'); ?>" style="display:inline-block;color:var(--alumni-navy);text-decoration:none;font-weight:500;">
                    Voir tous les événements <i class="fas fa-arrow-right" style="font-size:12px;margin-left:5px;"></i>
                </a>
            </div>

            <!-- Companies Card -->
            <div class="dashboard-card" style="background:white;border-radius:8px;padding:25px;box-shadow:0 2px 8px rgba(0,0,0,0.05);transition:transform 0.2s ease,box-shadow 0.2s ease;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:15px;">
                    <h2 style="margin:0;font-size:18px;color:var(--alumni-navy);font-weight:600;">
                        <i class="fas fa-building" style="color:var(--alumni-gold);margin-right:8px;"></i> Entreprises partenaires
                    </h2>
                </div>

                <div class="companies-list" style="margin-bottom:15px;">
                    <?php
                    // Récupération des entreprises avec requête personnalisée
                    $companies = new WP_Query([
                        'post_type' => 'entreprises',
                        'posts_per_page' => 3,
                        'orderby' => 'title',
                        'order' => 'ASC'
                    ]);

                    if ($companies->have_posts()) :
                        echo '<ul style="list-style:none;padding:0;margin:0;">';
                        while ($companies->have_posts()) : $companies->the_post();
                            $company_id = get_the_ID();
                            $nom = get_field('nom_entreprise', $company_id);
                            $logo = get_field('logo', $company_id);

                            // Récupération du secteur d'activité
                            $sectors = wp_get_post_terms($company_id, 'secteurs_activite', ['fields' => 'names']);
                            $sector_list = !empty($sectors) ? implode(', ', $sectors) : '';

                            echo '<li style="padding:12px 0;border-bottom:1px solid #eee;display:flex;align-items:center;gap:12px;">';

                            // Logo de l'entreprise
                            echo '<div style="flex-shrink:0;width:40px;height:40px;display:flex;align-items:center;justify-content:center;background:#f8f9fa;border-radius:4px;overflow:hidden;">';
                            if ($logo) {
                                echo '<img src="' . esc_url($logo['url']) . '" alt="' . esc_attr($nom) . '" style="max-width:100%;max-height:100%;object-fit:contain;">';
                            } else {
                                echo '<i class="fas fa-building" style="color:#bbb;font-size:16px;"></i>';
                            }
                            echo '</div>';

                            // Informations de l'entreprise
                            echo '<div style="flex-grow:1;">';
                            echo '<a href="' . get_permalink() . '" style="color:var(--alumni-navy);text-decoration:none;font-weight:500;display:block;">' . esc_html($nom) . '</a>';
                            if ($sector_list) {
                                echo '<div style="font-size:12px;color:#7f8c8d;margin-top:4px;display:flex;align-items:center;gap:8px;">';
                                echo '<span><i class="fas fa-tag" style="margin-right:4px;"></i> ' . esc_html($sector_list) . '</span>';
                                echo '</div>';
                            }
                            echo '</div>';

                            echo '</li>';
                        endwhile;
                        echo '</ul>';
                        wp_reset_postdata();
                    else:
                        echo '<p style="color:#7f8c8d;font-style:italic;">Aucune entreprise partenaire pour le moment.</p>';
                    endif;
                    ?>
                </div>

                <a href="<?php echo site_url('/entreprises-partenaires'); ?>" style="display:inline-block;color:var(--alumni-navy);text-decoration:none;font-weight:500;">
                    Voir toutes les entreprises <i class="fas fa-arrow-right" style="font-size:12px;margin-left:5px;"></i>
                </a>
            </div>

            <!-- Profile Card -->
            <div class="dashboard-card" style="background:white;border-radius:8px;padding:25px;box-shadow:0 2px 8px rgba(0,0,0,0.05);transition:transform 0.2s ease,box-shadow 0.2s ease;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:15px;">
                    <h2 style="margin:0;font-size:18px;color:var(--alumni-navy);font-weight:600;">
                        <i class="fas fa-user-graduate" style="color:var(--alumni-gold);margin-right:8px;"></i> Mon profil
                    </h2>
                </div>

                <div class="profile-preview" style="margin-bottom:15px;">
                    <?php if ($membre_id): ?>
                        <div style="display:flex;flex-direction:column;gap:12px;">
                            <div style="display:flex;align-items:center;gap:10px;">
                                <i class="fas fa-user" style="width:18px;color:#7f8c8d;"></i>
                                <span><?php echo esc_html(get_field('prenom', $membre_id) . ' ' . get_field('nom', $membre_id)); ?></span>
                            </div>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <i class="fas fa-envelope" style="width:18px;color:#7f8c8d;"></i>
                                <span><?php echo esc_html(get_field('email', $membre_id)); ?></span>
                            </div>
                            <?php if (get_field('telephone', $membre_id)): ?>
                                <div style="display:flex;align-items:center;gap:10px;">
                                    <i class="fas fa-phone" style="width:18px;color:#7f8c8d;"></i>
                                    <span><?php echo esc_html(get_field('telephone', $membre_id)); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <p style="color:#7f8c8d;font-style:italic;">Complétez votre profil pour accéder à toutes les fonctionnalités.</p>
                    <?php endif; ?>
                </div>

                <a href="<?php echo site_url('/mon-profil-etudiant'); ?>" style="display:inline-block;color:var(--alumni-navy);text-decoration:none;font-weight:500;">
                    Modifier mon profil <i class="fas fa-arrow-right" style="font-size:12px;margin-left:5px;"></i>
                </a>
            </div>
        </div>

        <!-- Add new sections for user's events and applications -->
        <div style="background:white;border-radius:8px;padding:25px;margin:40px 0 30px;box-shadow:0 2px 8px rgba(0,0,0,0.05);">
            <h2 style="margin:0 0 20px;font-size:20px;color:var(--alumni-navy);font-weight:600;">
                <i class="fas fa-calendar-check" style="color:var(--alumni-gold);margin-right:8px;"></i> Mes événements
            </h2>

            <div class="my-events">
                <?php
                // Get user's events from evenements_lies field
                $user_events = [];
                if ($membre_id) {
                    $user_events = get_field('evenements_lies', $membre_id);
                }

                if (!empty($user_events) && is_array($user_events)) {
                    echo '<div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(300px, 1fr));gap:15px;">';
                    
                    foreach ($user_events as $event_id) {
                        $titre = get_field('titre_evenement', $event_id);
                        $date_raw = get_field('date_evenement', $event_id);
                        $date = $date_raw ? date_i18n('j F Y', strtotime($date_raw)) : '—';
                        
                        // Check if event exists and is not archived
                        if (get_post_status($event_id) !== 'publish' || get_post_meta($event_id, 'archive_status', true) === 'archived') {
                            continue;
                        }
                        
                        // Get event location
                        $locations = wp_get_post_terms($event_id, 'localisations', ['fields' => 'names']);
                        $location = !empty($locations) ? implode(', ', $locations) : '—';
                        
                        echo '<div style="background:#f8f8ff;border-radius:6px;padding:15px;border-left:3px solid var(--alumni-gold);">';
                        echo '<h3 style="margin:0 0 10px;font-size:16px;font-weight:600;color:var(--alumni-navy);">' . esc_html($titre) . '</h3>';
                        echo '<div style="font-size:13px;color:#6c757d;">';
                        echo '<div><i class="fas fa-calendar-day" style="width:16px;margin-right:5px;color:var(--alumni-gold);"></i> ' . $date . '</div>';
                        echo '<div><i class="fas fa-map-marker-alt" style="width:16px;margin-right:5px;color:var(--alumni-gold);"></i> ' . esc_html($location) . '</div>';
                        echo '</div>';
                        echo '<a href="' . get_permalink($event_id) . '" style="display:inline-block;margin-top:10px;font-size:13px;color:var(--alumni-navy);text-decoration:none;">Voir les détails <i class="fas fa-arrow-right" style="font-size:10px;"></i></a>';
                        echo '</div>';
                    }
                    
                    echo '</div>';
                } else {
                    echo '<p style="color:#7f8c8d;font-style:italic;">Vous n\'êtes inscrit(e) à aucun événement actuellement.</p>';
                }
                ?>
            </div>
        </div>
        
        <div style="background:white;border-radius:8px;padding:25px;margin:40px 0 30px;box-shadow:0 2px 8px rgba(0,0,0,0.05);">
            <h2 style="margin:0 0 20px;font-size:20px;color:var(--alumni-navy);font-weight:600;">
                <i class="fas fa-clipboard-list" style="color:var(--alumni-gold);margin-right:8px;"></i> Mes candidatures
            </h2>

            <div class="my-applications">
                <?php
                // Get user's job applications
                $applications = new WP_Query([
                    'post_type' => 'candidatures',
                    'posts_per_page' => -1,
                    'author' => $user_id,
                    'orderby' => 'date',
                    'order' => 'DESC'
                ]);

                if ($applications->have_posts()) {
                    echo '<table style="width:100%;border-collapse:collapse;font-size:14px;">';
                    echo '<thead>';
                    echo '<tr style="border-bottom:2px solid #eee;">';
                    echo '<th style="padding:8px 12px;text-align:left;color:var(--alumni-navy);">Offre</th>';
                    echo '<th style="padding:8px 12px;text-align:left;color:var(--alumni-navy);">Entreprise</th>';
                    echo '<th style="padding:8px 12px;text-align:left;color:var(--alumni-navy);">Date</th>';
                    echo '<th style="padding:8px 12px;text-align:left;color:var(--alumni-navy);">Statut</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                    
                    while ($applications->have_posts()) {
                        $applications->the_post();
                        $application_id = get_the_ID();
                        
                        // Get job details
                        $job_id = get_field('offre_associee', $application_id);
                        $job_title = $job_id ? get_field('intitule_poste', $job_id) : '—';
                        
                        // Get company details
                        $company_name = '—';
                        if ($job_id) {
                            $company_id = get_field('entreprise_associee', $job_id);
                            if ($company_id) {
                                $company_name = get_field('nom_entreprise', $company_id);
                            }
                        }
                        
                        // Get application date and status
                        $date = get_the_date('j F Y');
                        $status = get_field('statut_candidature', $application_id);
                        
                        // Define status information
                        $status_labels = [
                            'pending' => 'À traiter',
                            'reviewing' => 'En cours d\'examen',
                            'interview' => 'Entretien',
                            'accepted' => 'Accepté',
                            'rejected' => 'Refusé'
                        ];
                        
                        $status_colors = [
                            'pending' => '#6c757d',
                            'reviewing' => '#007bff',
                            'interview' => '#fd7e14',
                            'accepted' => '#28a745',
                            'rejected' => '#dc3545'
                        ];
                        
                        $status_label = isset($status_labels[$status]) ? $status_labels[$status] : 'À traiter';
                        $status_color = isset($status_colors[$status]) ? $status_colors[$status] : '#6c757d';
                        
                        echo '<tr style="border-bottom:1px solid #eee;">';
                        echo '<td style="padding:12px;">';
                        if ($job_id && get_post_status($job_id) === 'publish') {
                            echo '<a href="' . get_permalink($job_id) . '" style="color:var(--alumni-navy);text-decoration:none;font-weight:500;">' . esc_html($job_title) . '</a>';
                        } else {
                            echo esc_html($job_title);
                        }
                        echo '</td>';
                        echo '<td style="padding:12px;">' . esc_html($company_name) . '</td>';
                        echo '<td style="padding:12px;">' . $date . '</td>';
                        echo '<td style="padding:12px;"><span style="display:inline-block;padding:4px 8px;border-radius:4px;font-size:12px;background:' . $status_color . ';color:white;">' . $status_label . '</span></td>';
                        echo '</tr>';
                    }
                    
                    echo '</tbody>';
                    echo '</table>';
                    wp_reset_postdata();
                } else {
                    echo '<p style="color:#7f8c8d;font-style:italic;">Vous n\'avez soumis aucune candidature actuellement.</p>';
                }
                ?>
            </div>
        </div>

        <!-- Partner Companies Slider -->
        <div style="background:white;border-radius:8px;padding:25px;margin:40px 0 30px;box-shadow:0 2px 8px rgba(0,0,0,0.05);">
            <h2 style="margin:0 0 20px;font-size:20px;color:var(--alumni-navy);font-weight:600;">
                <i class="fas fa-building" style="color:var(--alumni-gold);margin-right:8px;"></i> Nos entreprises partenaires
            </h2>

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
                                </a>
                            </div>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add hover effect to cards
        const cards = document.querySelectorAll('.dashboard-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.boxShadow = '0 8px 16px rgba(0,0,0,0.1)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 2px 8px rgba(0,0,0,0.05)';
            });
        });

        // Initialize Swiper
        var swiper = new Swiper('.partnerSlider', {
            slidesPerView: 4,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                640: {
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
            }
        });
    });
</script>

<?php get_footer('etudiant'); ?>