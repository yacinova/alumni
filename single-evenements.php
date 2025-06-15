<?php

/**
 * Template pour l'affichage détaillé d'un événement
 */
acf_form_head();

if (is_user_logged_in()) {
    get_header('etudiant');
} else {
    get_header();
}

// Récupérer les informations de l'événement
$event_id = get_the_ID();
$titre = get_field('titre_evenement', $event_id);
$date_raw = get_field('date_evenement', $event_id);
$date = $date_raw ? date_i18n('j F Y', strtotime($date_raw)) : '—';
$description = get_field('description_evenement', $event_id);
$inscription = get_field('lien_inscription', $event_id);
$documents = get_field('documents_associes', $event_id);
$orateurs = get_field('orateurs_evenement', $event_id);

// Taxonomies
$event_types = wp_get_post_terms($event_id, 'types_evenement', ['fields' => 'names']);
$event_type = !empty($event_types) ? implode(', ', $event_types) : '—';

$event_locations = wp_get_post_terms($event_id, 'localisations', ['fields' => 'names']);
$event_location = !empty($event_locations) ? implode(', ', $event_locations) : '—';

// Check if user is registered for this event using ACF fields only
$user_id = get_current_user_id();
$member_id = null;
$is_registered = false;

if ($user_id) {
    // Get current user's member post using ACF relationship field
    $membres = get_posts(array(
        'post_type' => 'membres',
        'posts_per_page' => 1,
        'fields' => 'ids',
        'meta_key' => 'compte_associe',
        'meta_value' => $user_id
    ));
    
    if (!empty($membres)) {
        $member_id = $membres[0];
        
        // Get events linked to this member using ACF field
        $events_linked = get_field('evenements_lies', $member_id);
        
        // Check if current event is in the linked events
        if (is_array($events_linked) && !empty($events_linked)) {
            $is_registered = in_array($event_id, $events_linked);
        }
    }
}
?>

<div class="event-single-container" style="background-color:#f5f7fa;min-height:calc(100vh - 200px);padding:30px 20px;">
    <div class="event-single-content" style="max-width:900px;margin:0 auto;">

        <!-- Bouton Retour -->
        <div style="margin-bottom:20px;">
            <a href="<?php echo site_url('/liste-des-evenements'); ?>" style="display:inline-flex;align-items:center;color:#7f8c8d;text-decoration:none;font-size:14px;">
                <i class="fas fa-arrow-left" style="margin-right:6px;"></i> Retour à la liste des événements
            </a>
        </div>

        <!-- Carte Principale -->
        <div class="event-card" style="background:white;border-radius:12px;padding:30px;margin-bottom:25px;box-shadow:0 4px 15px rgba(0,0,0,0.08);">

            <!-- En-tête -->
            <div style="margin-bottom:25px;padding-bottom:20px;border-bottom:1px solid #f0f0f0;">
                <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:15px;">
                    <h1 style="margin:0;font-size:28px;color:var(--alumni-navy);font-weight:700;"><?php echo esc_html($titre); ?></h1>

                    <?php if ($inscription) : // Check if inscription link exists ?>
                        <?php if (is_user_logged_in()) : // User is logged in ?>
                            <a href="<?php echo esc_url($inscription); ?>" target="_blank" class="btn-inscription" style="display:inline-block;padding:10px 20px;background:var(--alumni-navy);color:white;text-decoration:none;border-radius:6px;font-weight:500;transition:all 0.2s ease;">
                                <i class="fas fa-user-plus" style="margin-right:8px;"></i> S'inscrire
                            </a>
                        <?php else : // User is logged out ?>
                            <a href="<?php echo esc_url(site_url('/connexion-etudiant')); ?>" class="btn-inscription" style="display:inline-block;padding:10px 20px;background:var(--alumni-navy);color:white;text-decoration:none;border-radius:6px;font-weight:500;transition:all 0.2s ease;">
                                <i class="fas fa-sign-in-alt" style="margin-right:8px;"></i> Connectez-vous pour vous inscrire
                            </a>
                        <?php endif; ?>
                    <?php else : // No inscription link - use internal registration ?>
                        <?php
                        // Show registration status messages
                        if (isset($_GET['registration'])) {
                            if ($_GET['registration'] === 'success') {
                                echo '<div class="registration-message success">Inscription réussie !</div>';
                            } elseif ($_GET['registration'] === 'unregistered') {
                                echo '<div class="registration-message info">Désinscription effectuée.</div>';
                            }
                        }

                        if (is_user_logged_in()) {
                            if (!$is_registered) {
                                ?>
                                <form method="post" class="event-registration-form">
                                    <?php wp_nonce_field('register_for_event', 'event_registration_nonce'); ?>
                                    <input type="hidden" name="event_id" value="<?php echo get_the_ID(); ?>">
                                    <button type="submit" class="register-button" style="display:inline-block;padding:12px 25px;background:var(--alumni-gold);color:var(--alumni-navy);text-decoration:none;border-radius:6px;font-weight:600;border:none;cursor:pointer;transition:all 0.3s ease;box-shadow:0 2px 5px rgba(0,0,0,0.1);">
                                        <i class="fas fa-user-plus" style="margin-right:8px;"></i> S'inscrire à l'événement
                                    </button>
                                </form>
                                <?php
                            } else {
                                ?>
                                <form method="post" class="event-unregistration-form">
                                    <?php wp_nonce_field('event_registration', 'event_registration_nonce'); ?>
                                    <input type="hidden" name="event_id" value="<?php echo get_the_ID(); ?>">
                                    <input type="hidden" name="action" value="unregister">
                                    <button type="submit" class="unregister-button" style="display:inline-block;padding:12px 25px;background:#f44336;color:white;text-decoration:none;border-radius:6px;font-weight:600;border:none;cursor:pointer;transition:all 0.3s ease;box-shadow:0 2px 5px rgba(0,0,0,0.1);">
                                        <i class="fas fa-user-minus" style="margin-right:8px;"></i> Se désinscrire
                                    </button>
                                </form>
                                <?php
                            }
                        } else {
                            echo '<p>Veuillez vous <a href="' . wp_login_url(get_permalink()) . '">connecter</a> pour vous inscrire à cet événement.</p>';
                        }
                        ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Métadonnées -->
            <div style="display:flex;flex-wrap:wrap;gap:20px;margin-bottom:30px;">
                <div style="display:flex;align-items:center;margin-right:20px;">
                    <div style="width:42px;height:42px;border-radius:50%;background:var(--alumni-navy);display:flex;align-items:center;justify-content:center;margin-right:10px;">
                        <i class="fas fa-calendar-alt" style="color:white;font-size:18px;"></i>
                    </div>
                    <div>
                        <div style="font-weight:600;color:#2c3e50;"><?php echo $date; ?></div>
                        <div style="font-size:12px;color:#7f8c8d;">Date</div>
                    </div>
                </div>

                <div style="display:flex;align-items:center;margin-right:20px;">
                    <div style="width:42px;height:42px;border-radius:50%;background:var(--alumni-navy);display:flex;align-items:center;justify-content:center;margin-right:10px;">
                        <i class="fas fa-map-marker-alt" style="color:white;font-size:18px;"></i>
                    </div>
                    <div>
                        <div style="font-weight:600;color:#2c3e50;"><?php echo esc_html($event_location); ?></div>
                        <div style="font-size:12px;color:#7f8c8d;">Lieu</div>
                    </div>
                </div>

                <div style="display:flex;align-items:center;">
                    <div style="width:42px;height:42px;border-radius:50%;background:var(--alumni-navy);display:flex;align-items:center;justify-content:center;margin-right:10px;">
                        <i class="fas fa-tag" style="color:white;font-size:18px;"></i>
                    </div>
                    <div>
                        <div style="font-weight:600;color:#2c3e50;"><?php echo esc_html($event_type); ?></div>
                        <div style="font-size:12px;color:#7f8c8d;">Type d'événement</div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div style="margin-bottom:25px;">
                <h3 style="font-size:18px;color:var(--alumni-navy);margin-bottom:15px;font-weight:600;">Description</h3>
                <div style="line-height:1.6;color:#333;">
                    <?php echo $description; ?>
                </div>
            </div>

            <!-- Contenu principal -->
            <div style="margin-bottom:25px;">
                <?php the_content(); ?>
            </div>

            <!-- Orateur(s) -->
            <?php if ($orateurs) : ?>
            <div style="margin-bottom:25px;padding-top:20px;border-top:1px solid #f0f0f0;">
                <h3 style="font-size:18px;color:var(--alumni-navy);margin-bottom:15px;font-weight:600;">Intervenant(s)</h3>
                <div style="display:flex;flex-wrap:wrap;gap:20px;">
                    <?php foreach ($orateurs as $orateur) : ?>
                        <div style="display:flex;align-items:center;background:#f8f9fa;padding:15px;border-radius:8px;width:100%;max-width:300px;">
                            <?php if (!empty($orateur['photo'])) : ?>
                                <img src="<?php echo esc_url($orateur['photo']); ?>" alt="<?php echo esc_attr($orateur['nom']); ?>" style="width:60px;height:60px;border-radius:50%;object-fit:cover;margin-right:15px;">
                            <?php else : ?>
                                <div style="width:60px;height:60px;border-radius:50%;background:var(--alumni-navy);display:flex;align-items:center;justify-content:center;margin-right:15px;">
                                    <i class="fas fa-user" style="color:white;font-size:24px;"></i>
                                </div>
                            <?php endif; ?>
                            <div>
                                <div style="font-weight:600;color:#2c3e50;"><?php echo esc_html($orateur['nom']); ?></div>
                                <?php if (!empty($orateur['fonction'])) : ?>
                                    <div style="font-size:13px;color:#7f8c8d;"><?php echo esc_html($orateur['fonction']); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Documents Associés -->
            <?php if (!empty($documents)) : ?>
                <div class="event-documents">
                    <h2 style="font-size:20px;color:#2c3e50;margin-bottom:15px;">Documents</h2>
                    <div style="display:flex;flex-wrap:wrap;gap:15px;">
                        <?php
                        // Filtrer les documents avec accès restreint si nécessaire
                        $displayed_docs = 0;
                        foreach ($documents as $document) :
                            $doc_title = get_field('titre_document', $document->ID);
                            $doc_file = get_field('fichier', $document->ID);
                            $doc_version = get_field('version', $document->ID);
                            $doc_categorie = get_field('categorie', $document->ID);
                            $doc_restreint = get_field('acces_restreint', $document->ID);

                            // Récupérer les termes de la taxonomie types_documents
                            $doc_types = wp_get_post_terms($document->ID, 'types_documents', ['fields' => 'names']);
                            $doc_type = !empty($doc_types) ? implode(', ', $doc_types) : '';

                            // Vérifier si le document est accessible
                            // Skip if restricted AND user is not logged in
                            if ($doc_restreint && !is_user_logged_in()) {
                                continue;
                            }

                            // Vérifier que le fichier existe
                            if (!$doc_file) continue;

                            $displayed_docs++;

                            // Déterminer le type de fichier et l'icône adaptée
                            $file_extension = pathinfo($doc_file['url'], PATHINFO_EXTENSION);
                            $icon_class = 'fa-file';
                            $icon_color = '#7f8c8d';

                            switch (strtolower($file_extension)) {
                                case 'pdf':
                                    $icon_class = 'fa-file-pdf';
                                    $icon_color = '#e74c3c';
                                    break;
                                case 'doc':
                                case 'docx':
                                    $icon_class = 'fa-file-word';
                                    $icon_color = '#3498db';
                                    break;
                                case 'xls':
                                case 'xlsx':
                                    $icon_class = 'fa-file-excel';
                                    $icon_color = '#27ae60';
                                    break;
                                case 'ppt':
                                case 'pptx':
                                    $icon_class = 'fa-file-powerpoint';
                                    $icon_color = '#e67e22';
                                    break;
                                case 'jpg':
                                case 'jpeg':
                                case 'png':
                                case 'gif':
                                    $icon_class = 'fa-file-image';
                                    $icon_color = '#9b59b6';
                                    break;
                                case 'zip':
                                case 'rar':
                                case '7z':
                                    $icon_class = 'fa-file-archive';
                                    $icon_color = '#f39c12';
                                    break;
                            }

                            // Taille du fichier formatée
                            $file_size = '';
                            if (isset($doc_file['filesize'])) {
                                $size_in_kb = $doc_file['filesize'] / 1024;
                                if ($size_in_kb < 1024) {
                                    $file_size = round($size_in_kb, 1) . ' KB';
                                } else {
                                    $file_size = round($size_in_kb / 1024, 1) . ' MB';
                                }
                            }

                            // Date de mise à jour du document
                            $updated_date = get_the_modified_date('d/m/Y', $document->ID);
                        ?>
                            <div style="width:calc(50% - 8px);min-width:250px;">
                                <a href="<?php echo esc_url($doc_file['url']); ?>" target="_blank" style="display:flex;align-items:center;padding:15px;background:#f8f9fa;border-radius:6px;text-decoration:none;color:#2c3e50;border:1px solid #e9ecef;transition:all 0.2s ease;height:100%;">
                                    <div style="width:40px;height:40px;background:rgba(0,0,0,0.03);border-radius:4px;display:flex;align-items:center;justify-content:center;margin-right:15px;flex-shrink:0;">
                                        <i class="fas <?php echo $icon_class; ?>" style="color:<?php echo $icon_color; ?>;font-size:20px;"></i>
                                    </div>
                                    <div style="flex-grow:1;">
                                        <div style="font-weight:600;margin-bottom:3px;"><?php echo esc_html($doc_title ?: basename($doc_file['url'])); ?></div>

                                        <div style="font-size:12px;color:#7f8c8d;margin-bottom:5px;">
                                            <?php if ($doc_type) : ?>
                                                <span class="doc-type" style="display:inline-block;background:#e8f4fd;color:#3498db;padding:2px 6px;border-radius:3px;font-size:10px;margin-right:6px;">
                                                    <?php echo esc_html($doc_type); ?>
                                                </span>
                                            <?php endif; ?>

                                            <?php if ($doc_categorie) : ?>
                                                <span class="doc-categorie"><?php echo esc_html($doc_categorie); ?></span>
                                            <?php endif; ?>
                                        </div>

                                        <div style="display:flex;align-items:center;font-size:11px;color:#95a5a6;margin-top:4px;">
                                            <span style="text-transform:uppercase;"><?php echo esc_html(strtoupper($file_extension)); ?></span>

                                            <?php if ($file_size) : ?>
                                                <span style="margin:0 6px;">•</span>
                                                <span><?php echo esc_html($file_size); ?></span>
                                            <?php endif; ?>

                                            <?php if ($doc_version) : ?>
                                                <span style="margin:0 6px;">•</span>
                                                <span>v<?php echo esc_html($doc_version); ?></span>
                                            <?php endif; ?>

                                            <span style="margin:0 6px;">•</span>
                                            <span>Mis à jour le <?php echo $updated_date; ?></span>
                                        </div>
                                    </div>
                                    <div style="margin-left:10px;">
                                        <i class="fas fa-download" style="color:#95a5a6;font-size:14px;"></i>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>

                        <?php if ($displayed_docs === 0) : ?>
                            <p style="width:100%;padding:15px;background:#f8f9fa;border-radius:6px;color:#7f8c8d;font-style:italic;margin:0;">
                                Aucun document accessible pour cet événement<?php echo (!is_user_logged_in() ? ' (certains documents peuvent nécessiter une connexion)' : ''); ?>.
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Boutons d'action -->
        <div style="display:flex;justify-content:space-between;margin-top:30px;">
            <a href="<?php echo site_url('/liste-des-evenements'); ?>" style="display:inline-block;padding:10px 20px;background:#34495e;color:white;text-decoration:none;border-radius:6px;font-weight:500;">
                <i class="fas fa-arrow-left" style="margin-right:8px;"></i> Retour aux événements
            </a>

            <?php if ($inscription) : // Check if inscription link exists ?>
                <?php if (is_user_logged_in()) : // User is logged in ?>
                    <a href="<?php echo esc_url($inscription); ?>" target="_blank" style="display:inline-block;padding:10px 20px;background:#9b59b6;color:white;text-decoration:none;border-radius:6px;font-weight:500;">
                        <i class="fas fa-user-plus" style="margin-right:8px;"></i> S'inscrire
                    </a>
                <?php else : // User is logged out ?>
                    <a href="<?php echo esc_url(site_url('/connexion-etudiant')); ?>" style="display:inline-block;padding:10px 20px;background:#9b59b6;color:white;text-decoration:none;border-radius:6px;font-weight:500;">
                        <i class="fas fa-sign-in-alt" style="margin-right:8px;"></i> Connectez-vous pour vous inscrire
                    </a>
                <?php endif; ?>
            <?php else : // No inscription link - use internal registration ?>
                <?php if (is_user_logged_in()) : ?>
                    <?php if (!$is_registered) : ?>
                        <form method="post" class="event-registration-form">
                            <?php wp_nonce_field('register_for_event', 'event_registration_nonce'); ?>
                            <input type="hidden" name="event_id" value="<?php echo get_the_ID(); ?>">
                            <button type="submit" class="register-button" style="display:inline-block;padding:12px 25px;background:var(--alumni-gold);color:var(--alumni-navy);text-decoration:none;border-radius:6px;font-weight:600;border:none;cursor:pointer;transition:all 0.3s ease;box-shadow:0 2px 5px rgba(0,0,0,0.1);">
                                <i class="fas fa-user-plus" style="margin-right:8px;"></i> S'inscrire à l'événement
                            </button>
                        </form>
                    <?php else : ?>
                        <form method="post" class="event-unregistration-form">
                            <?php wp_nonce_field('event_registration', 'event_registration_nonce'); ?>
                            <input type="hidden" name="event_id" value="<?php echo get_the_ID(); ?>">
                            <input type="hidden" name="action" value="unregister">
                            <button type="submit" class="unregister-button" style="display:inline-block;padding:12px 25px;background:#f44336;color:white;text-decoration:none;border-radius:6px;font-weight:600;border:none;cursor:pointer;transition:all 0.3s ease;box-shadow:0 2px 5px rgba(0,0,0,0.1);">
                                <i class="fas fa-user-minus" style="margin-right:8px;"></i> Se désinscrire
                            </button>
                        </form>
                    <?php endif; ?>
                <?php else : ?>
                    <p>Veuillez vous <a href="<?php echo wp_login_url(get_permalink()); ?>">connecter</a> pour vous inscrire à cet événement.</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ajouter des effets hover aux boutons
        const buttons = document.querySelectorAll('.btn-inscription, a[style*="background:#34495e"], a[style*="background:#9b59b6"]');
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

        // Ajouter des effets hover aux documents
        const docLinks = document.querySelectorAll('.event-documents a');
        docLinks.forEach(link => {
            link.addEventListener('mouseenter', function() {
                this.style.background = '#f0f2f5';
                this.style.borderColor = '#d0d7de';
            });
            link.addEventListener('mouseleave', function() {
                this.style.background = '#f8f9fa';
                this.style.borderColor = '#e9ecef';
            });
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