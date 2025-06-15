<?php

/**
 * Template pour l'affichage détaillé d'une offre d'emploi
 */
acf_form_head();

// Get appropriate header based on login status
if (is_user_logged_in()) {
    get_header('etudiant');
} else {
    get_header();
}

// Récupérer les informations de l'offre d'emploi
$job_id = get_the_ID();
$titre = get_field('intitule_poste', $job_id);
$description = get_field('description_poste', $job_id);
$criteres = get_field('criteres', $job_id);
$expiration_raw = get_field('date_expiration', $job_id);
$expiration = $expiration_raw ? date_i18n('j F Y', strtotime($expiration_raw)) : 'Non définie';
$lien_inscription = get_field('lien_inscription', $job_id);

// Get current applications count
$application_count = 0;
$args = array(
    'post_type' => 'candidatures',
    'posts_per_page' => -1,
    'meta_query' => array(
        array(
            'key' => 'offre_associee',
            'value' => $job_id,
            'compare' => '='
        )
    )
);
$applications_query = new WP_Query($args);
$application_count = $applications_query->found_posts;
wp_reset_postdata();

// Récupérer l'entreprise associée
$company_id = get_field('entreprise_associee', $job_id);
$company_name = '';
$company_logo = '';
$company_description = '';
$company_email = '';
$company_phone = '';
$company_website = '';
$company_sectors = [];
$company_locations = [];

if ($company_id) {
    $company_name = get_field('nom_entreprise', $company_id);
    $company_logo = get_field('logo', $company_id);
    $company_description = get_field('description', $company_id);
    $company_email = get_field('contact_email', $company_id);
    $company_phone = get_field('contact_tel', $company_id);
    $company_website = get_field('site_web', $company_id);
    $company_sectors = wp_get_post_terms($company_id, 'secteurs_activite', ['fields' => 'names']);
    $company_locations = wp_get_post_terms($company_id, 'localisations', ['fields' => 'names']);
}
?>

<div class="job-single-container" style="background-color:#f5f7fa;min-height:calc(100vh - 200px);padding:30px 20px;">
    <div class="job-single-content" style="max-width:900px;margin:0 auto;">

        <!-- Bouton Retour -->
        <div style="margin-bottom:20px;">
            <a href="<?php echo site_url('/offres-emploi'); ?>" style="display:inline-flex;align-items:center;color:#0F2454;text-decoration:none;font-size:14px;">
                <i class="fas fa-arrow-left" style="margin-right:6px;"></i> Retour à la liste des offres
            </a>
        </div>

        <!-- Carte Principale -->
        <div class="job-card" style="background:white;border-radius:12px;padding:30px;margin-bottom:25px;box-shadow:0 4px 15px rgba(0,0,0,0.08);">

            <!-- En-tête -->
            <div style="margin-bottom:25px;padding-bottom:20px;border-bottom:1px solid #f0f0f0;">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:15px;">
                    <div>
                        <h1 style="margin:0 0 10px;font-size:28px;color:#0F2454;font-weight:700;"><?php echo esc_html($titre); ?></h1>
                        <?php if ($company_name) : ?>
                            <div style="display:flex;align-items:center;">
                                <?php if ($company_logo) : ?>
                                    <img src="<?php echo esc_url($company_logo['url']); ?>" alt="<?php echo esc_attr($company_name); ?>" style="width:24px;height:24px;object-fit:contain;margin-right:8px;">
                                <?php endif; ?>
                                <span style="color:#D4AB39;font-weight:500;"><?php echo esc_html($company_name); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if ($expiration_raw) : ?>
                        <div style="background:#f8f9fa;padding:10px 15px;border-radius:6px;font-size:14px;color:#0F2454;">
                            <i class="fas fa-calendar-times" style="margin-right:6px;color:#D4AB39;"></i>
                            Expire le <?php echo $expiration; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Détails de l'offre -->
            <div style="margin-bottom:30px;">
                <?php if ($company_sectors && !empty($company_sectors)) : ?>
                    <div style="margin-bottom:15px;display:flex;align-items:flex-start;">
                        <div style="width:24px;margin-right:10px;color:#D4AB39;">
                            <i class="fas fa-tag"></i>
                        </div>
                        <div>
                            <div style="font-weight:600;margin-bottom:4px;color:#0F2454;">Secteur d'activité</div>
                            <div style="color:#0F2454;opacity:0.8;"><?php echo esc_html(implode(', ', $company_sectors)); ?></div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($company_locations && !empty($company_locations)) : ?>
                    <div style="margin-bottom:15px;display:flex;align-items:flex-start;">
                        <div style="width:24px;margin-right:10px;color:#D4AB39;">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <div style="font-weight:600;margin-bottom:4px;color:#0F2454;">Localisation</div>
                            <div style="color:#0F2454;opacity:0.8;"><?php echo esc_html(implode(', ', $company_locations)); ?></div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Description du poste -->
            <?php if ($description) : ?>
                <div class="job-description" style="margin-bottom:30px;">
                    <h2 style="font-size:20px;color:#0F2454;margin-bottom:15px;">Description du poste</h2>
                    <div style="color:#0F2454;opacity:0.9;line-height:1.6;">
                        <?php echo wpautop($description); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Critères -->
            <?php if ($criteres) : ?>
                <div class="job-criteria" style="margin-bottom:30px;">
                    <h2 style="font-size:20px;color:#0F2454;margin-bottom:15px;">Critères</h2>
                    <div style="color:#0F2454;opacity:0.9;line-height:1.6;">
                        <?php echo wpautop($criteres); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Informations de l'entreprise -->
            <?php if ($company_id) : ?>
                <div class="company-info" style="margin-top:40px;padding-top:30px;border-top:1px solid #f0f0f0;">
                    <h2 style="font-size:20px;color:#0F2454;margin-bottom:20px;">À propos de l'entreprise</h2>

                    <div style="display:flex;flex-wrap:wrap;gap:20px;align-items:center;margin-bottom:20px;">
                        <?php if ($company_logo) : ?>
                            <div style="flex:0 0 80px;">
                                <img src="<?php echo esc_url($company_logo['url']); ?>" alt="<?php echo esc_attr($company_name); ?>" style="width:80px;height:80px;object-fit:contain;">
                            </div>
                        <?php endif; ?>

                        <div style="flex:1;">
                            <h3 style="margin:0 0 10px;font-size:18px;color:#0F2454;"><?php echo esc_html($company_name); ?></h3>
                            <div style="display:flex;flex-wrap:wrap;gap:15px;">
                                <?php if ($company_email) : ?>
                                    <a href="mailto:<?php echo esc_attr($company_email); ?>" style="display:inline-flex;align-items:center;color:#D4AB39;text-decoration:none;font-size:14px;">
                                        <i class="fas fa-envelope" style="margin-right:6px;"></i>
                                        <?php echo esc_html($company_email); ?>
                                    </a>
                                <?php endif; ?>

                                <?php if ($company_phone) : ?>
                                    <a href="tel:<?php echo esc_attr($company_phone); ?>" style="display:inline-flex;align-items:center;color:#D4AB39;text-decoration:none;font-size:14px;">
                                        <i class="fas fa-phone" style="margin-right:6px;"></i>
                                        <?php echo esc_html($company_phone); ?>
                                    </a>
                                <?php endif; ?>

                                <?php if ($company_website) : ?>
                                    <a href="<?php echo esc_url($company_website); ?>" target="_blank" style="display:inline-flex;align-items:center;color:#D4AB39;text-decoration:none;font-size:14px;">
                                        <i class="fas fa-globe" style="margin-right:6px;"></i>
                                        Site web
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <?php if ($company_description) : ?>
                        <div style="color:#0F2454;opacity:0.9;line-height:1.6;">
                            <?php echo wpautop(wp_trim_words($company_description, 50, '...')); ?>
                            <a href="<?php echo get_permalink($company_id); ?>" style="color:#D4AB39;text-decoration:none;display:inline-block;margin-top:10px;">
                                En savoir plus sur <?php echo esc_html($company_name); ?> <i class="fas fa-arrow-right" style="font-size:12px;margin-left:5px;"></i>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Boutons d'action -->
        <div style="display:flex;justify-content:space-between;margin-top:30px;">
            <div>
                <a href="<?php echo site_url('/offres-emploi'); ?>" class="button button-secondary" style="background-color:#f5f5f5;color:#0F2454;border:1px solid #ddd;padding:10px 20px;border-radius:5px;text-decoration:none;font-size:14px;font-weight:500;">
                    Retour aux offres
                </a>
            </div>

            <div>
                <?php if (!is_user_logged_in()) : ?>
                    <a href="<?php echo esc_url(site_url('/connexion-etudiant')); ?>?redirect_to=<?php echo urlencode(get_permalink() . '#postuler'); ?>" class="button button-primary" style="background-color:#D4AB39;color:white;border:none;padding:10px 20px;border-radius:5px;text-decoration:none;font-size:14px;font-weight:500;">
                        <i class="fas fa-sign-in-alt" style="margin-right:6px;"></i> Connectez-vous pour postuler
                    </a>
                    <?php else :
                    // Vérifier si l'utilisateur a déjà postulé
                    $user_id = get_current_user_id();
                    $has_applied = false;

                    // Query pour vérifier si une candidature existe déjà
                    $args = array(
                        'post_type' => 'candidatures',
                        'posts_per_page' => 1,
                        'author' => $user_id,
                        'meta_query' => array(
                            array(
                                'key' => 'offre_associee',
                                'value' => $job_id,
                                'compare' => '='
                            )
                        )
                    );
                    $existing_application = new WP_Query($args);
                    $has_applied = $existing_application->have_posts();
                    wp_reset_postdata();

                    if ($has_applied) :
                    ?>
                        <button disabled style="background-color:#f5f5f5;color:#0F2454;border:none;padding:10px 20px;border-radius:5px;font-size:14px;font-weight:500;cursor:not-allowed;">
                            <i class="fas fa-check" style="margin-right:6px;"></i> Vous avez déjà postulé
                        </button>
                    <?php elseif ($lien_inscription) : ?>
                        <a href="<?php echo esc_url($lien_inscription); ?>" target="_blank" class="button button-primary" style="background-color:#D4AB39;color:white;border:none;padding:10px 20px;border-radius:5px;text-decoration:none;font-size:14px;font-weight:500;">
                            <i class="fas fa-external-link-alt" style="margin-right:6px;"></i> Postuler (lien externe)
                        </a>
                    <?php else : ?>
                        <a href="#" id="apply-button" class="button button-primary" style="background-color:#D4AB39;color:white;border:none;padding:10px 20px;border-radius:5px;text-decoration:none;font-size:14px;font-weight:500;">
                            <i class="fas fa-paper-plane" style="margin-right:6px;"></i> Postuler via le site
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Formulaire de candidature (caché par défaut) -->
        <?php if (is_user_logged_in() && !$has_applied && !$lien_inscription) : ?>
            <div id="application-form" style="margin-top:30px;display:none;" class="application-form-container">
                <div style="background:white;border-radius:12px;padding:30px;box-shadow:0 4px 15px rgba(0,0,0,0.08);">
                    <h2 style="font-size:20px;color:#0F2454;margin-bottom:20px;">Postuler à cette offre</h2>

                    <div id="application-response" style="display:none;margin-bottom:20px;padding:15px;border-radius:5px;"></div>

                    <form id="job-application-form" method="post" enctype="multipart/form-data">
                        <?php wp_nonce_field('submit_job_application', 'job_application_nonce'); ?>
                        <input type="hidden" name="action" value="submit_job_application">
                        <input type="hidden" name="job_id" value="<?php echo esc_attr($job_id); ?>">

                        <!-- Message complémentaire -->
                        <div class="form-field" style="margin-bottom:20px;">
                            <label for="application_message" style="display:block;margin-bottom:8px;font-weight:500;color:#0F2454;">
                                <i class="fas fa-comment" style="margin-right:5px;color:#D4AB39;"></i> Message (optionnel)
                            </label>
                            <textarea name="application_message" id="application_message" rows="5" style="width:100%;padding:12px;border:1px solid #ddd;border-radius:5px;"></textarea>
                            <p class="description" style="margin-top:5px;font-size:13px;color:#666;">Ajoutez des informations complémentaires pour votre candidature.</p>
                        </div>

                        <!-- CV -->
                        <div class="form-field" style="margin-bottom:20px;">
                            <label for="application_cv" style="display:block;margin-bottom:8px;font-weight:500;color:#0F2454;">
                                <i class="fas fa-file-pdf" style="margin-right:5px;color:#D4AB39;"></i> CV (PDF ou DOCX) <span style="color:red;">*</span>
                            </label>
                            <input type="file" name="application_cv" id="application_cv" accept=".pdf,.docx,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document" required style="width:100%;padding:12px;border:1px solid #ddd;border-radius:5px;">
                            <p class="description" style="margin-top:5px;font-size:13px;color:#666;">Formats acceptés : PDF ou DOCX (maximum 5 Mo)</p>
                        </div>

                        <!-- Lettre de motivation -->
                        <div class="form-field" style="margin-bottom:20px;">
                            <label for="application_cover_letter" style="display:block;margin-bottom:8px;font-weight:500;color:#0F2454;">
                                <i class="fas fa-file-alt" style="margin-right:5px;color:#D4AB39;"></i> Lettre de motivation (PDF ou DOCX)
                            </label>
                            <input type="file" name="application_cover_letter" id="application_cover_letter" accept=".pdf,.docx,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document" style="width:100%;padding:12px;border:1px solid #ddd;border-radius:5px;">
                            <p class="description" style="margin-top:5px;font-size:13px;color:#666;">Formats acceptés : PDF ou DOCX (maximum 5 Mo)</p>
                        </div>

                        <!-- Bouton d'envoi -->
                        <div class="form-submit" style="margin-top:30px;">
                            <button type="submit" id="submit-application" class="button button-primary" style="background-color:#D4AB39;color:white;border:none;padding:12px 20px;border-radius:5px;font-size:16px;font-weight:500;cursor:pointer;width:100%;">
                                <i class="fas fa-paper-plane" style="margin-right:10px;"></i> Envoyer ma candidature
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    // Define ajaxurl for frontend
    var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";

    document.addEventListener('DOMContentLoaded', function() {
        const applyButton = document.getElementById('apply-button');
        const applicationForm = document.getElementById('application-form');

        if (applyButton && applicationForm) {
            applyButton.addEventListener('click', function(e) {
                e.preventDefault();
                applicationForm.style.display = 'block';
                // Scroll to the form
                applicationForm.scrollIntoView({
                    behavior: 'smooth'
                });
            });
        }

        // Handle form submission
        const jobApplicationForm = document.getElementById('job-application-form');
        const responseDiv = document.getElementById('application-response');

        if (jobApplicationForm) {
            jobApplicationForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(jobApplicationForm);
                const submitButton = document.getElementById('submit-application');

                // Add AJAX action
                formData.append('action', 'submit_job_application');

                // Disable submit button and show loading state
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Envoi en cours...';
                }

                // Clear previous response
                if (responseDiv) {
                    responseDiv.style.display = 'none';
                    responseDiv.innerHTML = '';
                }

                // Log form data for debugging (you can remove this in production)
                console.log('Submitting form...');

                // Send AJAX request
                fetch(ajaxurl, {
                        method: 'POST',
                        body: formData,
                        credentials: 'same-origin'
                    })
                    .then(response => {
                        console.log('Response received:', response);
                        return response.json();
                    })
                    .then(data => {
                        console.log('Data received:', data);

                        if (responseDiv) {
                            responseDiv.style.display = 'block';
                        }

                        if (data.success) {
                            // Show success message
                            if (responseDiv) {
                                responseDiv.innerHTML = '<div style="background-color:#d4edda;color:#155724;padding:15px;border-radius:5px;">' +
                                    '<i class="fas fa-check-circle" style="margin-right:10px;"></i>' +
                                    data.data.message + '</div>';
                            }

                            // Disable form inputs
                            const inputs = jobApplicationForm.querySelectorAll('input, textarea, button');
                            inputs.forEach(input => {
                                input.disabled = true;
                            });

                            // Redirect after a short delay if a redirect URL was provided
                            if (data.data && data.data.redirect) {
                                setTimeout(() => {
                                    window.location.href = data.data.redirect;
                                }, 2000);
                            }
                        } else {
                            // Show error message
                            if (responseDiv) {
                                responseDiv.innerHTML = '<div style="background-color:#f8d7da;color:#721c24;padding:15px;border-radius:5px;">' +
                                    '<i class="fas fa-exclamation-circle" style="margin-right:10px;"></i>' +
                                    (data.data ? data.data.message : 'Une erreur est survenue lors de l\'envoi de votre candidature.') + '</div>';
                            }

                            // Re-enable submit button
                            if (submitButton) {
                                submitButton.disabled = false;
                                submitButton.innerHTML = '<i class="fas fa-paper-plane" style="margin-right:10px;"></i> Envoyer ma candidature';
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);

                        // Show error message
                        if (responseDiv) {
                            responseDiv.innerHTML = '<div style="background-color:#f8d7da;color:#721c24;padding:15px;border-radius:5px;">' +
                                '<i class="fas fa-exclamation-circle" style="margin-right:10px;"></i>' +
                                'Une erreur s\'est produite. Veuillez réessayer.</div>';
                            responseDiv.style.display = 'block';
                        }

                        // Re-enable submit button
                        if (submitButton) {
                            submitButton.disabled = false;
                            submitButton.innerHTML = '<i class="fas fa-paper-plane" style="margin-right:10px;"></i> Envoyer ma candidature';
                        }
                    });
            });
        }

        // Display success message if redirected back after successful application
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('application') === 'success') {
            const container = document.querySelector('.job-single-content');
            if (container) {
                const successMessage = document.createElement('div');
                successMessage.style.cssText = 'background-color:#d4edda;color:#155724;padding:15px;border-radius:5px;margin-bottom:20px;';
                successMessage.innerHTML = '<i class="fas fa-check-circle" style="margin-right:10px;"></i> Votre candidature a été soumise avec succès.';
                container.insertBefore(successMessage, container.firstChild);
            }
        }
    });
</script>

<?php
if (is_user_logged_in()) {
    get_footer('etudiant');
} else {
    get_footer();
}
?>