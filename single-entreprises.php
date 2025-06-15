<?php

/**
 * Template pour l'affichage détaillé d'une entreprise
 */
acf_form_head();
// Security check
if (!is_user_logged_in() || !current_user_can('etudiant')) {
    wp_redirect(site_url('/connexion-etudiant'));
    exit;
}

get_header('etudiant');

// Récupérer les informations de l'entreprise
$company_id = get_the_ID();
$nom = get_field('nom_entreprise', $company_id);
$logo = get_field('logo', $company_id);
$description = get_field('description', $company_id);
$email = get_field('contact_email', $company_id);
$telephone = get_field('contact_tel', $company_id);
$adresse = get_field('adresse', $company_id);
$site_web = get_field('site_web', $company_id);

// Récupérer les taxonomies
$sectors = wp_get_post_terms($company_id, 'secteurs_activite', ['fields' => 'names']);
$sector_list = !empty($sectors) ? implode(', ', $sectors) : '—';

$locations = wp_get_post_terms($company_id, 'localisations', ['fields' => 'names']);
$location_list = !empty($locations) ? implode(', ', $locations) : '—';

// Récupérer les offres d'emploi liées à cette entreprise
$jobs = new WP_Query([
    'post_type' => 'offres_emploi',
    'posts_per_page' => -1,
    'meta_query' => [
        [
            'key' => 'entreprise_associee',
            'value' => $company_id,
            'compare' => '='
        ]
    ]
]);
?>

<div class="company-single-container" style="background-color:#f5f7fa;min-height:calc(100vh - 200px);padding:30px 20px;">
    <div class="company-single-content" style="max-width:900px;margin:0 auto;">

        <!-- Bouton Retour -->
        <div style="margin-bottom:20px;">
            <a href="<?php echo site_url('/entreprises-partenaires'); ?>" style="display:inline-flex;align-items:center;color:#7f8c8d;text-decoration:none;font-size:14px;">
                <i class="fas fa-arrow-left" style="margin-right:6px;"></i> Retour à la liste des entreprises
            </a>
        </div>

        <!-- Carte Principale -->
        <div class="company-card" style="background:white;border-radius:12px;padding:30px;margin-bottom:25px;box-shadow:0 4px 15px rgba(0,0,0,0.08);">

            <!-- En-tête avec logo et infos principales -->
            <div style="margin-bottom:30px;padding-bottom:25px;border-bottom:1px solid #f0f0f0;display:flex;flex-wrap:wrap;gap:25px;">
                <?php if ($logo) : ?>
                    <div style="flex:0 0 120px;">
                        <div style="background:#f8f9fa;width:120px;height:120px;border-radius:8px;display:flex;align-items:center;justify-content:center;padding:15px;box-sizing:border-box;">
                            <img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($nom); ?>" style="max-width:100%;max-height:100%;object-fit:contain;">
                        </div>
                    </div>
                <?php endif; ?>

                <div style="flex:1;min-width:300px;">
                    <h1 style="margin:0 0 15px;font-size:28px;color:var(--alumni-navy);font-weight:700;"><?php echo esc_html($nom); ?></h1>

                    <div style="display:flex;flex-wrap:wrap;gap:20px;margin-bottom:15px;">
                        <?php if (!empty($sectors)) : ?>
                            <div style="display:flex;align-items:center;color:#7f8c8d;">
                                <i class="fas fa-tag" style="width:16px;margin-right:8px;color:var(--alumni-gold);"></i>
                                <?php echo esc_html($sector_list); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($locations)) : ?>
                            <div style="display:flex;align-items:center;color:#7f8c8d;">
                                <i class="fas fa-map-marker-alt" style="width:16px;margin-right:8px;color:var(--alumni-gold);"></i>
                                <?php echo esc_html($location_list); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Contact rapide -->
                    <div style="display:flex;flex-wrap:wrap;gap:10px;margin-top:15px;">
                        <?php if ($email) : ?>
                            <a href="mailto:<?php echo esc_attr($email); ?>" style="display:inline-flex;align-items:center;padding:6px 12px;background:#f8f9fa;border-radius:4px;color:var(--alumni-navy);text-decoration:none;font-size:14px;transition:all 0.2s ease;">
                                <i class="fas fa-envelope" style="margin-right:6px;color:var(--alumni-gold);"></i>
                                Contact
                            </a>
                        <?php endif; ?>

                        <?php if ($site_web) : ?>
                            <a href="<?php echo esc_url($site_web); ?>" target="_blank" style="display:inline-flex;align-items:center;padding:6px 12px;background:#f8f9fa;border-radius:4px;color:var(--alumni-navy);text-decoration:none;font-size:14px;transition:all 0.2s ease;">
                                <i class="fas fa-globe" style="margin-right:6px;color:var(--alumni-gold);"></i>
                                Site web
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Informations détaillées -->
            <div class="company-details" style="margin-bottom:30px;">
                <h2 style="font-size:20px;color:var(--alumni-navy);margin-bottom:20px;">Informations</h2>

                <div style="display:flex;flex-wrap:wrap;gap:25px;">
                    <div style="flex:1;min-width:250px;">
                        <?php if ($email || $telephone || $adresse) : ?>
                            <div style="background:#f8f9fa;border-radius:8px;padding:20px;">
                                <h3 style="margin:0 0 15px;font-size:16px;color:var(--alumni-navy);">Coordonnées</h3>

                                <?php if ($email) : ?>
                                    <div style="margin-bottom:12px;display:flex;align-items:flex-start;">
                                        <div style="width:24px;margin-right:10px;color:var(--alumni-gold);">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                        <div>
                                            <div style="font-weight:600;margin-bottom:4px;color:var(--alumni-navy);">Email</div>
                                            <a href="mailto:<?php echo esc_attr($email); ?>" style="color:#7f8c8d;text-decoration:none;">
                                                <?php echo esc_html($email); ?>
                                            </a>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ($telephone) : ?>
                                    <div style="margin-bottom:12px;display:flex;align-items:flex-start;">
                                        <div style="width:24px;margin-right:10px;color:var(--alumni-gold);">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                        <div>
                                            <div style="font-weight:600;margin-bottom:4px;color:var(--alumni-navy);">Téléphone</div>
                                            <a href="tel:<?php echo esc_attr($telephone); ?>" style="color:#7f8c8d;text-decoration:none;">
                                                <?php echo esc_html($telephone); ?>
                                            </a>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ($adresse) : ?>
                                    <div style="display:flex;align-items:flex-start;">
                                        <div style="width:24px;margin-right:10px;color:var(--alumni-gold);">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <div>
                                            <div style="font-weight:600;margin-bottom:4px;color:var(--alumni-navy);">Adresse</div>
                                            <div style="color:#7f8c8d;">
                                                <?php echo nl2br(esc_html($adresse)); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div style="flex:1;min-width:250px;">
                        <?php if ($site_web) : ?>
                            <div style="background:#f8f9fa;border-radius:8px;padding:20px;">
                                <h3 style="margin:0 0 15px;font-size:16px;color:var(--alumni-navy);">Liens utiles</h3>

                                <div style="margin-bottom:12px;display:flex;align-items:flex-start;">
                                    <div style="width:24px;margin-right:10px;color:var(--alumni-gold);">
                                        <i class="fas fa-globe"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight:600;margin-bottom:4px;color:var(--alumni-navy);">Site web</div>
                                        <a href="<?php echo esc_url($site_web); ?>" target="_blank" style="color:#7f8c8d;text-decoration:none;word-break:break-all;">
                                            <?php echo esc_html($site_web); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Description de l'entreprise -->
            <?php if ($description) : ?>
                <div class="company-description" style="margin-bottom:30px;">
                    <h2 style="font-size:20px;color:var(--alumni-navy);margin-bottom:15px;">À propos de <?php echo esc_html($nom); ?></h2>
                    <div style="color:#34495e;line-height:1.6;">
                        <?php echo wpautop($description); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Offres d'emploi associées -->
            <?php if ($jobs->have_posts()) : ?>
                <div class="company-jobs" style="margin-top:40px;padding-top:30px;border-top:1px solid #f0f0f0;">
                    <h2 style="font-size:20px;color:var(--alumni-navy);margin-bottom:20px;">
                        Offres d'emploi (<?php echo $jobs->post_count; ?>)
                    </h2>

                    <div style="display:flex;flex-direction:column;gap:15px;">
                        <?php while ($jobs->have_posts()) : $jobs->the_post();
                            $job_id = get_the_ID();
                            $titre = get_field('intitule_poste', $job_id);
                            $expiration_raw = get_field('date_expiration', $job_id);
                            $expiration = $expiration_raw ? date_i18n('j F Y', strtotime($expiration_raw)) : 'Non définie';
                        ?>
                            <a href="<?php the_permalink(); ?>" style="display:flex;justify-content:space-between;align-items:center;padding:15px;background:#f8f9fa;border-radius:8px;text-decoration:none;color:var(--alumni-navy);transition:all 0.2s ease;">
                                <div>
                                    <div style="font-weight:600;margin-bottom:5px;"><?php echo esc_html($titre); ?></div>
                                    <div style="font-size:13px;color:#7f8c8d;">
                                        <?php if ($expiration_raw) : ?>
                                            <span><i class="fas fa-calendar-times" style="margin-right:5px;color:var(--alumni-gold);"></i> Expire le <?php echo $expiration; ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div style="color:var(--alumni-gold);">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </a>
                        <?php endwhile;
                        wp_reset_postdata(); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Bouton d'action -->
        <div style="margin-top:30px;text-align:center;">
            <a href="<?php echo site_url('/entreprises-partenaires'); ?>" style="display:inline-block;padding:10px 20px;background:var(--alumni-navy);color:white;text-decoration:none;border-radius:6px;font-weight:500;">
                <i class="fas fa-arrow-left" style="margin-right:8px;"></i> Retour aux entreprises
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ajouter des effets hover aux boutons
        const buttons = document.querySelectorAll('a[style*="background:#34495e"], a[style*="background:#e67e22"]');
        buttons.forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-3px)';
                this.style.boxShadow = '0 4px 8px rgba(0,0,0,0.15)';
            });
            btn.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = 'none';
            });
        });

        // Ajouter des effets hover aux liens de contact rapide
        const contactLinks = document.querySelectorAll('a[style*="background:#f8f9fa"]');
        contactLinks.forEach(link => {
            link.addEventListener('mouseenter', function() {
                this.style.background = '#f0f2f5';
            });
            link.addEventListener('mouseleave', function() {
                this.style.background = '#f8f9fa';
            });
        });

        // Ajouter des effets hover aux offres d'emploi
        const jobLinks = document.querySelectorAll('.company-jobs a');
        jobLinks.forEach(link => {
            link.addEventListener('mouseenter', function() {
                this.style.background = '#f0f2f5';
                this.style.transform = 'translateX(5px)';
            });
            link.addEventListener('mouseleave', function() {
                this.style.background = '#f8f9fa';
                this.style.transform = 'translateX(0)';
            });
        });
    });
</script>

<?php get_footer('etudiant'); ?>