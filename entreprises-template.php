<?php

/**
 * Template Name: Liste des Entreprises
 * Description: Affiche toutes les entreprises partenaires
 */

if (is_user_logged_in()) {
    get_header('etudiant');
} else {
    get_header();
}
?>

<div class="companies-container" style="background-color:#f5f7fa;min-height:calc(100vh - 200px);padding:30px 20px;">
    <div class="companies-content" style="max-width:1200px;margin:0 auto;">

        <!-- Page Header -->
        <div class="page-header" style="background:linear-gradient(135deg, var(--alumni-navy), #1a3a6c);color:var(--alumni-white);border-radius:8px;padding:25px;margin-bottom:30px;box-shadow:0 3px 10px rgba(0,0,0,0.1);">
            <h1 style="margin-top:0;font-size:24px;font-weight:600;">
                <i class="fas fa-building" style="margin-right:10px;"></i> Entreprises partenaires
            </h1>
            <p style="margin-bottom:5px;opacity:0.9;">Découvrez les entreprises qui collaborent avec notre établissement.</p>
        </div>

        <!-- Filter Bar -->
        <div class="filter-bar" style="background:white;border-radius:8px;padding:20px;margin-bottom:25px;box-shadow:0 2px 8px rgba(0,0,0,0.05);display:flex;flex-wrap:wrap;gap:15px;align-items:center;">
            <div style="flex-grow:1;">
                <label for="company-sector" style="display:block;margin-bottom:5px;font-weight:600;color:#2c3e50;">Secteur d'activité</label>
                <select id="company-sector" style="width:100%;padding:10px;border-radius:4px;border:1px solid #ddd;">
                    <option value="">Tous les secteurs</option>
                    <?php
                    $selected_sector = isset($_GET['company_sector']) ? sanitize_text_field($_GET['company_sector']) : '';
                    $sectors = get_terms(['taxonomy' => 'secteurs_activite', 'hide_empty' => true]);
                    if (!empty($sectors) && !is_wp_error($sectors)) {
                        foreach ($sectors as $sector) {
                            $selected = $selected_sector === $sector->slug ? 'selected' : '';
                            echo '<option value="' . esc_attr($sector->slug) . '" ' . $selected . '>' . esc_html($sector->name) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <div style="flex-grow:1;">
                <label for="company-location" style="display:block;margin-bottom:5px;font-weight:600;color:#2c3e50;">Localisation</label>
                <select id="company-location" style="width:100%;padding:10px;border-radius:4px;border:1px solid #ddd;">
                    <option value="">Toutes les localisations</option>
                    <?php
                    $selected_location = isset($_GET['company_location']) ? sanitize_text_field($_GET['company_location']) : '';
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
                <button id="filter-companies" style="background:var(--alumni-navy);color:var(--alumni-white);border:none;padding:10px 15px;border-radius:4px;cursor:pointer;font-weight:500;">
                    <i class="fas fa-filter" style="margin-right:5px;"></i> Filtrer
                </button>
                <?php if (isset($_GET['company_sector']) || isset($_GET['company_location'])) : ?>
                    <a href="<?php echo get_permalink(); ?>" style="display:inline-block;margin-left:10px;padding:10px 15px;background:#e74c3c;color:white;border:none;border-radius:4px;text-decoration:none;font-weight:500;">
                        <i class="fas fa-times" style="margin-right:5px;"></i> Réinitialiser
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <?php if (isset($_GET['company_sector']) || isset($_GET['company_location'])) : ?>
            <div class="active-filters" style="background:#f8f9fa;border-radius:8px;padding:15px;margin-bottom:25px;border-left:4px solid var(--alumni-navy);">
                <h3 style="margin:0 0 10px;font-size:16px;color:#2c3e50;">Filtres actifs:</h3>
                <div style="display:flex;flex-wrap:wrap;gap:10px;">
                    <?php if (isset($_GET['company_sector']) && !empty($_GET['company_sector'])) :
                        $sector_term = get_term_by('slug', sanitize_text_field($_GET['company_sector']), 'secteurs_activite');
                        if ($sector_term) : ?>
                            <div style="background:white;border-radius:20px;padding:5px 12px;display:inline-flex;align-items:center;border:1px solid #e0e0e0;">
                                <span style="margin-right:5px;color:#2c3e50;"><strong>Secteur:</strong> <?php echo esc_html($sector_term->name); ?></span>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if (isset($_GET['company_location']) && !empty($_GET['company_location'])) :
                        $location_term = get_term_by('slug', sanitize_text_field($_GET['company_location']), 'localisations');
                        if ($location_term) : ?>
                            <div style="background:white;border-radius:20px;padding:5px 12px;display:inline-flex;align-items:center;border:1px solid #e0e0e0;">
                                <span style="margin-right:5px;color:#2c3e50;"><strong>Localisation:</strong> <?php echo esc_html($location_term->name); ?></span>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Companies List -->
        <div class="companies-list" style="display:grid;grid-template-columns:repeat(auto-fill, minmax(300px, 1fr));gap:25px;">
            <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

            // Handle filter parameters
            $tax_query = [
                'relation' => 'AND' // Ensures both filters must match
            ];

            if (isset($_GET['company_sector']) && !empty($_GET['company_sector'])) {
                $tax_query[] = [
                    'taxonomy' => 'secteurs_activite',
                    'field' => 'slug',
                    'terms' => sanitize_text_field($_GET['company_sector'])
                ];
            }

            if (isset($_GET['company_location']) && !empty($_GET['company_location'])) {
                $tax_query[] = [
                    'taxonomy' => 'localisations',
                    'field' => 'slug',
                    'terms' => sanitize_text_field($_GET['company_location'])
                ];
            }

            // Build query args
            $query_args = [
                'post_type' => 'entreprises',
                'posts_per_page' => 12,
                'paged' => $paged,
                'orderby' => 'title',
                'order' => 'ASC'
            ];

            // Add tax query if filters are set
            if (!empty($tax_query)) {
                $query_args['tax_query'] = $tax_query;
            }

            $companies = new WP_Query($query_args);

            if ($companies->have_posts()) :
                while ($companies->have_posts()) : $companies->the_post();
                    // Get company data
                    $company_id = get_the_ID();
                    $nom = get_field('nom_entreprise', $company_id);
                    $logo = get_field('logo', $company_id);
                    $description = get_field('description', $company_id);
                    $site = get_field('site_web', $company_id);

                    // Limit description length to 20 words
                    $description = $description ? wp_trim_words($description, 30, '...') : '';

                    // Get taxonomies
                    $sectors = get_the_terms($company_id, 'secteurs_activite');
                    $sector_list = !empty($sectors) && !is_wp_error($sectors) ? implode(', ', array_map(function($term) {
                        return $term->name;
                    }, $sectors)) : '—';

                    $locations = get_the_terms($company_id, 'localisations');
                    $location_list = !empty($locations) && !is_wp_error($locations) ? implode(', ', array_map(function($term) {
                        return $term->name;
                    }, $locations)) : '—';
            ?>
                    <div class="company-card" style="background:white;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.05);transition:transform 0.2s ease,box-shadow 0.2s ease;height:100%;display:flex;flex-direction:column;">
                        <div style="background:#f9f9f9;padding:25px;text-align:center;height:150px;display:flex;align-items:center;justify-content:center;">
                            <?php if ($logo) : ?>
                                <img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($nom); ?>" style="max-width:100%;max-height:120px;object-fit:contain;">
                            <?php else : ?>
                                <div style="width:100px;height:100px;background:#eee;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                    <i class="fas fa-building" style="font-size:40px;color:#bbb;"></i>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div style="padding:20px;flex-grow:1;display:flex;flex-direction:column;">
                            <h2 style="margin:0 0 15px;font-size:18px;color:#2c3e50;font-weight:600;text-align:center;"><?php echo esc_html($nom); ?></h2>

                            <div style="margin-bottom:15px;color:#7f8c8d;flex-grow:1;">
                                <?php if ($description) : ?>
                                    <div style="margin-bottom:15px;">
                                        <?php echo wp_trim_words($description, 30, '...'); ?>
                                    </div>
                                <?php endif; ?>

                                <div style="display:flex;align-items:center;margin-bottom:8px;">
                                    <i class="fas fa-tag" style="width:16px;margin-right:8px;color:#e67e22;"></i>
                                    <span><?php echo esc_html($sector_list); ?></span>
                                </div>

                                <?php if (!empty($locations)) : ?>
                                    <div style="display:flex;align-items:center;margin-bottom:8px;">
                                        <i class="fas fa-map-marker-alt" style="width:16px;margin-right:8px;color:#e67e22;"></i>
                                        <span><?php echo esc_html($location_list); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div style="text-align:center;">
                                <a href="<?php the_permalink(); ?>" style="display:inline-block;padding:8px 15px;background:var(--alumni-gray);color:var(--alumni-text);text-decoration:none;border-radius:4px;font-weight:500;margin-right:5px;">
                                    <i class="fas fa-info-circle" style="margin-right:5px;"></i> Détails
                                </a>

                                <?php if ($site) : ?>
                                    <a href="<?php echo esc_url($site); ?>" target="_blank" style="display:inline-block;padding:8px 15px;background:var(--alumni-gold);color:var(--alumni-navy);text-decoration:none;border-radius:4px;font-weight:500;">
                                        <i class="fas fa-external-link-alt" style="margin-right:5px;"></i> Site web
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>

                <!-- Pagination -->
                <?php
                echo paginate_links([
                    'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                    'total' => $companies->max_num_pages,
                    'current' => max(1, get_query_var('paged')),
                    'format' => '?paged=%#%',
                    'prev_text' => '<i class="fas fa-chevron-left"></i> Précédent',
                    'next_text' => 'Suivant <i class="fas fa-chevron-right"></i>',
                ]);

                wp_reset_postdata();
            else:
                ?>
                <div style="grid-column:1/-1;background:white;border-radius:8px;padding:30px;text-align:center;margin-bottom:20px;box-shadow:0 2px 8px rgba(0,0,0,0.05);">
                    <i class="fas fa-building" style="font-size:48px;color:#e0e0e0;margin-bottom:20px;"></i>
                    <h3 style="margin:0 0 10px;font-size:20px;color:#2c3e50;">Aucune entreprise partenaire</h3>
                    <p style="color:#7f8c8d;margin:0;">Revenez plus tard pour découvrir nos partenaires.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Back Button (only for logged-in users) -->
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
        // Add hover effect to company cards
        const companyCards = document.querySelectorAll('.company-card');
        companyCards.forEach(card => {
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
        document.getElementById('filter-companies').addEventListener('click', function() {
            const sector = document.getElementById('company-sector').value;
            const location = document.getElementById('company-location').value;

            // Build the filter URL
            let filterUrl = window.location.pathname + '?';
            if (sector) filterUrl += 'company_sector=' + sector + '&';
            if (location) filterUrl += 'company_location=' + location + '&';

            // Remove trailing '&' if present
            filterUrl = filterUrl.replace(/[&?]$/, '');

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