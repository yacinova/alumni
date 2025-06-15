<?php

/**
 * Template Name: Liste des Offres d'Emploi
 * Description: Affiche toutes les offres d'emploi disponibles
 */

// Load appropriate header based on login status
if (is_user_logged_in()) {
    get_header('etudiant');
} else {
    get_header();
}
?>

<div class="jobs-container" style="background-color:var(--alumni-gray);min-height:calc(100vh - 200px);padding:30px 20px;">
    <div class="jobs-content" style="max-width:1200px;margin:0 auto;">

        <!-- Page Header -->
        <div class="page-header" style="background:linear-gradient(135deg, var(--alumni-navy), #1a3a6c);color:var(--alumni-white);border-radius:8px;padding:25px;margin-bottom:30px;box-shadow:0 3px 10px rgba(0,0,0,0.1);">
            <h1 style="margin-top:0;font-size:24px;font-weight:600;">
                <i class="fas fa-briefcase" style="margin-right:10px;"></i> Offres d'emploi
            </h1>
            <p style="margin-bottom:5px;opacity:0.9;">Découvrez les opportunités d'emploi proposées par nos entreprises partenaires.</p>
        </div>

        <!-- Filter Bar -->
        <div class="filter-bar" style="background:var(--alumni-white);border-radius:8px;padding:20px;margin-bottom:25px;box-shadow:0 2px 8px var(--alumni-shadow);display:flex;flex-wrap:wrap;gap:15px;align-items:center;">
            <div style="flex-grow:1;">
                <label for="job-sector" style="display:block;margin-bottom:5px;font-weight:600;color:#2c3e50;">Secteur d'activité</label>
                <select id="job-sector" style="width:100%;padding:10px;border-radius:4px;border:1px solid #ddd;">
                    <option value="">Tous les secteurs</option>
                    <?php
                    $selected_sector = isset($_GET['job_sector']) ? sanitize_text_field($_GET['job_sector']) : '';
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
                <label for="job-company" style="display:block;margin-bottom:5px;font-weight:600;color:#2c3e50;">Entreprise</label>
                <select id="job-company" style="width:100%;padding:10px;border-radius:4px;border:1px solid #ddd;">
                    <option value="">Toutes les entreprises</option>
                    <?php
                    $selected_company = isset($_GET['job_company']) ? intval($_GET['job_company']) : '';
                    $companies = get_posts([
                        'post_type' => 'entreprises',
                        'numberposts' => -1,
                        'orderby' => 'title',
                        'order' => 'ASC'
                    ]);

                    if (!empty($companies)) {
                        foreach ($companies as $company) {
                            $company_name = get_field('nom_entreprise', $company->ID);
                            if (!empty($company_name)) {
                                $selected = $selected_company == $company->ID ? 'selected' : '';
                                echo '<option value="' . esc_attr($company->ID) . '" ' . $selected . '>' . esc_html($company_name) . '</option>';
                            }
                        }
                    }
                    ?>
                </select>
            </div>

            <div style="align-self:flex-end;">
                <button id="filter-jobs" style="background:var(--alumni-navy);color:var(--alumni-white);border:none;padding:10px 15px;border-radius:4px;cursor:pointer;font-weight:500;">
                    <i class="fas fa-filter" style="margin-right:5px;"></i> Filtrer
                </button>
                <?php if (isset($_GET['job_sector']) || isset($_GET['job_company'])) : ?>
                    <a href="<?php echo get_permalink(); ?>" style="display:inline-block;margin-left:10px;padding:10px 15px;background:#e74c3c;color:white;border:none;border-radius:4px;text-decoration:none;font-weight:500;">
                        <i class="fas fa-times" style="margin-right:5px;"></i> Réinitialiser
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <?php if (isset($_GET['job_sector']) || isset($_GET['job_company'])) : ?>
            <div class="active-filters" style="background:#f8f9fa;border-radius:8px;padding:15px;margin-bottom:25px;border-left:4px solid var(--alumni-navy);">
                <h3 style="margin:0 0 10px;font-size:16px;color:#2c3e50;">Filtres actifs:</h3>
                <div style="display:flex;flex-wrap:wrap;gap:10px;">
                    <?php if (isset($_GET['job_sector']) && !empty($_GET['job_sector'])) :
                        $sector_term = get_term_by('slug', sanitize_text_field($_GET['job_sector']), 'secteurs_activite');
                        if ($sector_term) : ?>
                            <div style="background:white;border-radius:20px;padding:5px 12px;display:inline-flex;align-items:center;border:1px solid #e0e0e0;">
                                <span style="margin-right:5px;color:#2c3e50;"><strong>Secteur:</strong> <?php echo esc_html($sector_term->name); ?></span>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if (isset($_GET['job_company']) && !empty($_GET['job_company'])) :
                        $company_id = intval($_GET['job_company']);
                        $company_name = get_field('nom_entreprise', $company_id);
                        if ($company_name) : ?>
                            <div style="background:white;border-radius:20px;padding:5px 12px;display:inline-flex;align-items:center;border:1px solid #e0e0e0;">
                                <span style="margin-right:5px;color:#2c3e50;"><strong>Entreprise:</strong> <?php echo esc_html($company_name); ?></span>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Jobs List -->
        <div class="jobs-list">
            <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $today = date('Ymd'); // Today's date in YYYYMMDD format

            $meta_query = [
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
                // Filter to exclude archived jobs
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
            ];

            // Process filter parameters
            $meta_query_filters = [];

            // Get filter parameters from URL
            $job_sector = isset($_GET['job_sector']) ? sanitize_text_field($_GET['job_sector']) : '';
            $job_company = isset($_GET['job_company']) ? intval($_GET['job_company']) : '';

            // Add company filter
            if (!empty($job_company)) {
                $meta_query_filters[] = [
                    'key'     => 'entreprise_associee',
                    'value'   => $job_company,
                    'compare' => '=',
                ];
            }

            // Add sector filter
            if (!empty($job_sector)) {
                // First, find all companies in this sector
                $companies_in_sector = get_posts([
                    'post_type' => 'entreprises',
                    'numberposts' => -1,
                    'fields' => 'ids',
                    'tax_query' => [
                        [
                            'taxonomy' => 'secteurs_activite',
                            'field'    => 'slug',
                            'terms'    => $job_sector,
                        ]
                    ]
                ]);

                if (!empty($companies_in_sector)) {
                    $meta_query_filters[] = [
                        'key'     => 'entreprise_associee',
                        'value'   => $companies_in_sector,
                        'compare' => 'IN',
                    ];
                } else {
                    // If no companies found in this sector, force no results
                    $meta_query_filters[] = [
                        'key'     => 'entreprise_associee',
                        'value'   => 0, // Will match no jobs
                        'compare' => '=',
                    ];
                }
            }

            // Combine meta queries
            if (!empty($meta_query_filters)) {
                if (count($meta_query_filters) > 1) {
                    // If both sector and company filters are active, we need both conditions
                    $meta_query = [
                        'relation' => 'AND',
                        $meta_query, // Original date expiration conditions
                        [
                            'relation' => 'AND',
                            $meta_query_filters[0],
                            $meta_query_filters[1]
                        ]
                    ];
                } else {
                    // If only one filter is active
                    $meta_query = [
                        'relation' => 'AND',
                        $meta_query, // Original date expiration conditions
                        $meta_query_filters[0]
                    ];
                }
            }

            $query_args = [
                'post_type' => 'offres_emploi',
                'posts_per_page' => 10,
                'paged' => $paged,
                'meta_query' => $meta_query,
                'orderby' => 'date',
                'order' => 'DESC'
            ];

            $jobs = new WP_Query($query_args);

            if ($jobs->have_posts()) :
                while ($jobs->have_posts()) : $jobs->the_post();
                    // Get job data
                    $job_id = get_the_ID();
                    $titre = get_field('intitule_poste', $job_id);
                    $description = get_field('description_poste', $job_id);
                    $criteres = get_field('criteres', $job_id);
                    $expiration_raw = get_field('date_expiration', $job_id);
                    $expiration = $expiration_raw ? date_i18n('j F Y', strtotime($expiration_raw)) : 'Non définie';

                    // Get company info
                    $company_id = get_field('entreprise_associee', $job_id);
                    $company_name = '';
                    $company_logo = '';
                    $company_sectors = [];

                    if ($company_id) {
                        $company_name = get_field('nom_entreprise', $company_id);
                        $company_logo = get_field('logo', $company_id);
                        $company_sectors = wp_get_post_terms($company_id, 'secteurs_activite', ['fields' => 'names']);
                    }
            ?>
                    <div class="job-card" style="background:white;border-radius:8px;padding:25px;margin-bottom:20px;box-shadow:0 2px 8px rgba(0,0,0,0.05);transition:transform 0.2s ease,box-shadow 0.2s ease;">
                        <div style="display:flex;flex-wrap:wrap;gap:20px;">
                            <?php if ($company_logo) : ?>
                                <div style="flex:0 0 80px;">
                                    <img src="<?php echo esc_url($company_logo['url']); ?>" alt="<?php echo esc_attr($company_name); ?>" style="width:80px;height:80px;object-fit:contain;border-radius:4px;">
                                </div>
                            <?php endif; ?>

                            <div style="flex:1;min-width:250px;">
                                <h2 style="margin:0 0 10px;font-size:20px;color:#2c3e50;font-weight:600;"><?php echo esc_html($titre); ?></h2>

                                <div style="display:flex;flex-wrap:wrap;gap:15px;margin-bottom:15px;">
                                    <?php if ($company_name) : ?>
                                        <div style="display:flex;align-items:center;color:#7f8c8d;">
                                            <i class="fas fa-building" style="width:16px;margin-right:8px;color:var(--alumni-navy);"></i>
                                            <?php echo esc_html($company_name); ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($company_sectors)) : ?>
                                        <div style="display:flex;align-items:center;color:#7f8c8d;">
                                            <i class="fas fa-tag" style="width:16px;margin-right:8px;color:var(--alumni-navy);"></i>
                                            <?php echo esc_html(implode(', ', $company_sectors)); ?>
                                        </div>
                                    <?php endif; ?>

                                    <div style="display:flex;align-items:center;color:#7f8c8d;">
                                        <i class="fas fa-calendar-times" style="width:16px;margin-right:8px;color:var(--alumni-navy);"></i>
                                        Expire le: <?php echo $expiration; ?>
                                    </div>
                                </div>

                                <?php if ($description) : ?>
                                    <div style="color:#555;margin-bottom:15px;">
                                        <?php echo wp_trim_words($description, 30, '...'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="job-actions" style="display:flex;gap:10px;margin-top:20px;justify-content:flex-end;">
                            <a href="<?php the_permalink(); ?>" class="job-view-btn" style="display:inline-flex;align-items:center;padding:10px 20px;background:var(--alumni-navy);color:var(--alumni-white);text-decoration:none;border-radius:4px;font-weight:500;transition:all 0.3s ease;">
                                <i class="fas fa-eye" style="margin-right:8px;"></i>
                                Voir le détail
                            </a>
                            <?php if (is_user_logged_in()) : ?>
                                <a href="<?php the_permalink(); ?>#postuler" class="job-apply-btn" style="display:inline-flex;align-items:center;padding:10px 20px;background:var(--alumni-gold);color:var(--alumni-navy);text-decoration:none;border-radius:4px;font-weight:500;transition:all 0.3s ease;">
                                    <i class="fas fa-paper-plane" style="margin-right:8px;"></i>
                                    Postuler
                                </a>
                            <?php else : ?>
                                <a href="<?php echo esc_url(site_url('/connexion-etudiant')); ?>?redirect_to=<?php echo urlencode(get_permalink() . '#postuler'); ?>" class="job-login-btn" style="display:inline-flex;align-items:center;padding:10px 20px;background:var(--alumni-gold);color:var(--alumni-navy);text-decoration:none;border-radius:4px;font-weight:500;transition:all 0.3s ease;">
                                    <i class="fas fa-sign-in-alt" style="margin-right:8px;"></i>
                                    Connectez-vous pour postuler
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php
                endwhile;

                // Pagination
                echo '<div class="pagination" style="margin-top:30px;text-align:center;">';
                echo paginate_links([
                    'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                    'total' => $jobs->max_num_pages,
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
                    <i class="fas fa-briefcase" style="font-size:48px;color:#e0e0e0;margin-bottom:20px;"></i>
                    <h3 style="margin:0 0 10px;font-size:20px;color:#2c3e50;">Aucune offre d'emploi disponible</h3>
                    <p style="color:#7f8c8d;margin:0;">Revenez plus tard pour découvrir de nouvelles opportunités.</p>
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
        // Add hover effect to job cards
        const jobCards = document.querySelectorAll('.job-card');
        jobCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.boxShadow = '0 8px 16px rgba(0,0,0,0.1)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 2px 8px rgba(0,0,0,0.05)';
            });
        });

        // Add hover effects to buttons
        const buttons = document.querySelectorAll('.job-details-btn, .job-apply-btn, .job-login-btn');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                if (this.classList.contains('job-details-btn')) {
                    this.style.background = '#152a5c'; // Darker navy
                } else {
                    this.style.background = '#e9d282'; // Lighter gold
                }
                this.style.transform = 'translateY(-2px)';
            });
            button.addEventListener('mouseleave', function() {
                if (this.classList.contains('job-details-btn')) {
                    this.style.background = 'var(--alumni-navy)';
                } else {
                    this.style.background = 'var(--alumni-gold)';
                }
                this.style.transform = 'translateY(0)';
            });
        });

        // Filter functionality
        document.getElementById('filter-jobs').addEventListener('click', function() {
            const sector = document.getElementById('job-sector').value;
            const company = document.getElementById('job-company').value;

            // Build the filter URL
            let filterUrl = window.location.pathname + '?';
            if (sector) filterUrl += 'job_sector=' + sector + '&';
            if (company) filterUrl += 'job_company=' + company + '&';

            // Redirect to filtered URL
            window.location.href = filterUrl;
        });
    });
</script>

<?php
// Load appropriate footer based on login status
if (is_user_logged_in()) {
    get_footer('etudiant');
} else {
    get_footer();
}
?>