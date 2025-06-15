<?php

/**
 * Template Name: Liste des Événements
 * Description: Affiche tous les événements disponibles
 */

if (is_user_logged_in()) {
    get_header('etudiant');
} else {
    get_header();
}
?>

<div class="events-container" style="background-color:#f5f7fa;min-height:calc(100vh - 200px);padding:30px 20px;">
    <div class="events-content" style="max-width:1200px;margin:0 auto;">

        <!-- Page Header -->
        <div class="page-header" style="background:linear-gradient(135deg, var(--alumni-navy), #1a3a6c);color:var(--alumni-white);border-radius:8px;padding:25px;margin-bottom:30px;box-shadow:0 3px 10px rgba(0,0,0,0.1);">
            <h1 style="margin-top:0;font-size:24px;font-weight:600;">
                <i class="fas fa-calendar-alt" style="margin-right:10px;"></i> Événements à venir
            </h1>
            <p style="margin-bottom:5px;opacity:0.9;">Découvrez tous les événements organisés pour les étudiants et alumni.</p>
        </div>

        <!-- Filter Bar -->
        <div class="filter-bar" style="background:white;border-radius:8px;padding:20px;margin-bottom:25px;box-shadow:0 2px 8px rgba(0,0,0,0.05);display:flex;flex-wrap:wrap;gap:15px;align-items:center;">
            <div style="flex-grow:1;">
                <label for="event-type" style="display:block;margin-bottom:5px;font-weight:600;color:#2c3e50;">Type d'événement</label>
                <select id="event-type" style="width:100%;padding:10px;border-radius:4px;border:1px solid #ddd;">
                    <option value="">Tous les types</option>
                    <?php
                    $selected_type = isset($_GET['event_type']) ? sanitize_text_field($_GET['event_type']) : '';
                    $types = get_terms(['taxonomy' => 'types_evenement', 'hide_empty' => true]);
                    if (!empty($types) && !is_wp_error($types)) {
                        foreach ($types as $type) {
                            $selected = $selected_type === $type->slug ? 'selected' : '';
                            echo '<option value="' . esc_attr($type->slug) . '" ' . $selected . '>' . esc_html($type->name) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <div style="flex-grow:1;">
                <label for="event-location" style="display:block;margin-bottom:5px;font-weight:600;color:#2c3e50;">Localisation</label>
                <select id="event-location" style="width:100%;padding:10px;border-radius:4px;border:1px solid #ddd;">
                    <option value="">Toutes les localisations</option>
                    <?php
                    $selected_location = isset($_GET['event_location']) ? sanitize_text_field($_GET['event_location']) : '';
                    $locations = get_terms(['taxonomy' => 'localisations', 'hide_empty' => true]);
                    if (!empty($locations) && !is_wp_error($locations)) {
                        foreach ($locations as $location) {
                            $selected = $selected_location === $location->slug ? 'selected' : '';
                            echo '<option value="' . esc_attr($location->slug) . '" ' . $selected . '>' . esc_html($location->name) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <div style="align-self:flex-end;">
                <button id="filter-events" style="background:var(--alumni-navy);color:var(--alumni-white);border:none;padding:10px 15px;border-radius:4px;cursor:pointer;font-weight:500;">
                    <i class="fas fa-filter" style="margin-right:5px;"></i> Filtrer
                </button>
                <?php if (isset($_GET['event_type']) || isset($_GET['event_location'])) : ?>
                    <a href="<?php echo get_permalink(); ?>" style="display:inline-block;margin-left:10px;padding:10px 15px;background:#e74c3c;color:white;border:none;border-radius:4px;text-decoration:none;font-weight:500;">
                        <i class="fas fa-times" style="margin-right:5px;"></i> Réinitialiser
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <?php if (isset($_GET['event_type']) || isset($_GET['event_location'])) : ?>
            <div class="active-filters" style="background:#f8f9fa;border-radius:8px;padding:15px;margin-bottom:25px;border-left:4px solid var(--alumni-navy);">
                <h3 style="margin:0 0 10px;font-size:16px;color:#2c3e50;">Filtres actifs:</h3>
                <div style="display:flex;flex-wrap:wrap;gap:10px;">
                    <?php if (isset($_GET['event_type']) && !empty($_GET['event_type'])) :
                        $type_term = get_term_by('slug', sanitize_text_field($_GET['event_type']), 'types_evenement');
                        if ($type_term) : ?>
                            <div style="background:white;border-radius:20px;padding:5px 12px;display:inline-flex;align-items:center;border:1px solid #e0e0e0;">
                                <span style="margin-right:5px;color:#2c3e50;"><strong>Type:</strong> <?php echo esc_html($type_term->name); ?></span>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if (isset($_GET['event_location']) && !empty($_GET['event_location'])) :
                        $location_term = get_term_by('slug', sanitize_text_field($_GET['event_location']), 'localisations');
                        if ($location_term) : ?>
                            <div style="background:white;border-radius:20px;padding:5px 12px;display:inline-flex;align-items:center;border:1px solid #e0e0e0;">
                                <span style="margin-right:5px;color:#2c3e50;"><strong>Localisation:</strong> <?php echo esc_html($location_term->name); ?></span>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Events List -->
        <div class="events-list">
            <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

            // Handle filter parameters
            $tax_query = [];

            if (isset($_GET['event_type']) && !empty($_GET['event_type'])) {
                $tax_query[] = [
                    'taxonomy' => 'types_evenement',
                    'field' => 'slug',
                    'terms' => sanitize_text_field($_GET['event_type'])
                ];
            }

            if (isset($_GET['event_location']) && !empty($_GET['event_location'])) {
                $tax_query[] = [
                    'taxonomy' => 'localisations',
                    'field' => 'slug',
                    'terms' => sanitize_text_field($_GET['event_location'])
                ];
            }

            // Build query args
            $query_args = [
                'post_type' => 'evenements',
                'posts_per_page' => 10,
                'paged' => $paged,
                'meta_key' => 'date_evenement',
                'orderby' => 'meta_value',
                'order' => 'ASC',
                'meta_query' => [
                    [
                        'key' => 'date_evenement',
                        'value' => date('Ymd'), // Today's date in YYYYMMDD format
                        'compare' => '>=', // Show events from today onwards
                        'type' => 'DATE'
                    ]
                ]
            ];

            // Add tax query if filters are set
            if (!empty($tax_query)) {
                $query_args['tax_query'] = $tax_query;
            }

            $events = new WP_Query($query_args);

            if ($events->have_posts()) :
                while ($events->have_posts()) : $events->the_post();
                    // Get event data
                    $event_id = get_the_ID();
                    $titre = get_field('titre_evenement', $event_id);
                    $date_raw = get_field('date_evenement', $event_id);
                    $date = $date_raw ? date_i18n('j F Y', strtotime($date_raw)) : '—';
                    $description = get_field('description_evenement', $event_id);
                    $inscription = get_field('lien_inscription', $event_id);

                    // Get taxonomies
                    $event_types = wp_get_post_terms($event_id, 'types_evenement', ['fields' => 'names']);
                    $event_type = !empty($event_types) ? implode(', ', $event_types) : '—';

                    $event_locations = wp_get_post_terms($event_id, 'localisations', ['fields' => 'names']);
                    $event_location = !empty($event_locations) ? implode(', ', $event_locations) : '—';
            ?>
                    <div class="event-card" style="background:white;border-radius:8px;padding:25px;margin-bottom:20px;box-shadow:0 2px 8px rgba(0,0,0,0.05);transition:transform 0.2s ease,box-shadow 0.2s ease;">
                        <div style="display:flex;flex-wrap:wrap;gap:15px;margin-bottom:15px;">
                            <div style="flex:3;min-width:300px;">
                                <h2 style="margin:0 0 10px;font-size:20px;color:#2c3e50;font-weight:600;"><?php echo esc_html($titre); ?></h2>

                                <div style="display:flex;flex-wrap:wrap;gap:15px;margin-bottom:15px;">
                                    <div style="display:flex;align-items:center;color:#7f8c8d;">
                                        <i class="fas fa-calendar" style="width:16px;margin-right:8px;color:var(--alumni-navy);"></i>
                                        <?php echo $date; ?>
                                    </div>

                                    <div style="display:flex;align-items:center;color:#7f8c8d;">
                                        <i class="fas fa-map-marker-alt" style="width:16px;margin-right:8px;color:var(--alumni-navy);"></i>
                                        <?php echo esc_html($event_location); ?>
                                    </div>

                                    <div style="display:flex;align-items:center;color:#7f8c8d;">
                                        <i class="fas fa-tag" style="width:16px;margin-right:8px;color:var(--alumni-navy);"></i>
                                        <?php echo esc_html($event_type); ?>
                                    </div>
                                </div>

                                <?php if ($description) : ?>
                                    <div style="color:#555;margin-bottom:15px;">
                                        <?php echo wp_trim_words($description, 30, '...'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div style="display:flex;justify-content:flex-end;gap:10px;">
                            <a href="<?php the_permalink(); ?>" style="display:inline-block;padding:8px 15px;background:var(--alumni-gray);color:var(--alumni-text);text-decoration:none;border-radius:4px;font-weight:500;">
                                <i class="fas fa-info-circle" style="margin-right:5px;"></i> Détails
                            </a>

                            <?php if ($inscription) : ?>
                                <?php if (is_user_logged_in()) : ?>
                                    <a href="<?php echo esc_url($inscription); ?>" target="_blank" style="display:inline-block;padding:8px 15px;background:var(--alumni-gold);color:var(--alumni-navy);text-decoration:none;border-radius:4px;font-weight:500;">
                                        <i class="fas fa-user-plus" style="margin-right:5px;"></i> S'inscrire
                                    </a>
                                <?php else : ?>
                                    <a href="<?php echo esc_url(site_url('/connexion-etudiant')); ?>" style="display:inline-block;padding:8px 15px;background:var(--alumni-gold);color:var(--alumni-navy);text-decoration:none;border-radius:4px;font-weight:500;">
                                        <i class="fas fa-sign-in-alt" style="margin-right:5px;"></i> Connectez-vous pour vous inscrire
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php
                endwhile;

                // Pagination
                echo '<div class="pagination" style="margin-top:30px;text-align:center;">';
                echo paginate_links([
                    'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                    'total' => $events->max_num_pages,
                    'current' => max(1, get_query_var('paged')),
                    'format' => '?paged=%#%',
                    'prev_text' => '<i class="fas fa-chevron-left"></i> Précédent',
                    'next_text' => 'Suivant <i class="fas fa-chevron-right"></i>',
                ]);
                echo '</div>';

                wp_reset_postdata();
            else:
                ?>
                <div style="background:white;border-radius:8px;padding:30px;text-align:center;margin-bottom:20px;box-shadow:0 2px 8px rgba(0,0,0,0.05);">
                    <i class="fas fa-calendar-times" style="font-size:48px;color:#e0e0e0;margin-bottom:20px;"></i>
                    <h3 style="margin:0 0 10px;font-size:20px;color:#2c3e50;">Aucun événement à venir</h3>
                    <p style="color:#7f8c8d;margin:0;">Revenez plus tard pour découvrir nos prochains événements.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Back Button -->
        <?php if (is_user_logged_in()) : ?>
            <div style="margin-top:30px;text-align:center;">
                <a href="<?php echo site_url('/dashboard-etudiant'); ?>" style="display:inline-block;padding:10px 20px;background:var(--alumni-navy);color:var(--alumni-white);text-decoration:none;border-radius:4px;font-weight:500;">
                    <i class="fas fa-arrow-left" style="margin-right:8px;"></i> Retour au tableau de bord
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add hover effect to event cards
        const eventCards = document.querySelectorAll('.event-card');
        eventCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.boxShadow = '0 8px 16px rgba(0,0,0,0.1)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 2px 8px rgba(0,0,0,0.05)';
            });
        });

        // Filter functionality
        document.getElementById('filter-events').addEventListener('click', function() {
            const type = document.getElementById('event-type').value;
            const location = document.getElementById('event-location').value;

            // Build the filter URL
            let filterUrl = window.location.pathname + '?';
            if (type) filterUrl += 'event_type=' + type + '&';
            if (location) filterUrl += 'event_location=' + location + '&';

            // Redirect to filtered URL
            window.location.href = filterUrl;
        });
    });
</script>

<?php
if (is_user_logged_in()) {
    get_footer('etudiant');
} else {
    get_footer();
}
?>