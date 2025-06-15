<?php

/**
 * Template Name: Profil Étudiant
 * Description: Template moderne pour la gestion du profil étudiant
 */
acf_form_head();
// Security check
if (!is_user_logged_in() || !current_user_can('etudiant')) {
    wp_redirect(site_url('/connexion-etudiant'));
    exit;
}

// Get current user info
$user_id = get_current_user_id();
$post = get_posts([
    'post_type' => 'membres',
    'meta_key' => 'compte_associe',
    'meta_value' => $user_id,
    'numberposts' => 1
]);

if (!$post) {
    wp_redirect(site_url('/dashboard-etudiant'));
    exit;
}

$membre_id = $post[0]->ID;

// Lecture seule
$prenom = get_field('prenom', $membre_id);
$nom = get_field('nom', $membre_id);
$email = get_field('email', $membre_id);
$naissance_raw = get_field('date_naissance', $membre_id);
$naissance = ($naissance_raw && $dt = DateTime::createFromFormat('d/m/Y', $naissance_raw))
    ? date_i18n('j F Y', $dt->getTimestamp()) : '—';

$terms = wp_get_post_terms($membre_id, 'categories_membre', ['fields' => 'names']);
$categorie = !empty($terms) ? implode(', ', $terms) : '—';

// Extra profile fields
$phone = get_field('telephone', $membre_id);
$linkedin = get_field('linkedin', $membre_id);
$parcours = get_field('parcours_professionnel', $membre_id);
$competences = get_field('competences', $membre_id);

// Get the header
get_header('etudiant');
?>

<style>
    /* Modern Profile Page Styles */
    :root {
        /* Brand Colors */
        --alumni-navy: #0b1c39;
        --alumni-gold: #d4af37;
        --alumni-white: #ffffff;
        --alumni-shadow: rgba(0, 0, 0, 0.2);

        /* Extended Color Palette based on brand colors */
        --alumni-navy-light: #243a5e;
        --alumni-navy-lighter: #edf0f5;
        --alumni-gold-light: #e9d982;
        --alumni-gray: #f5f7fa;
        --alumni-text-dark: #0b1c39;
        --alumni-text-medium: #546785;
        --alumni-text-light: #8992a9;
        --alumni-success: #27ae60;
        --alumni-success-hover: #2ecc71;

        /* Layout Variables */
        --alumni-radius-sm: 4px;
        --alumni-radius-md: 8px;
        --alumni-radius-lg: 20px;
        --alumni-radius-circle: 50%;
        --alumni-transition-fast: 0.2s ease;
        --alumni-transition-normal: 0.3s ease;
        --alumni-shadow-sm: 0 2px 5px rgba(0, 0, 0, 0.05);
        --alumni-shadow-md: 0 4px 10px var(--alumni-shadow);
    }

    /* Main container */
    .profile-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    /* Header styles */
    .profile-header {
        background: linear-gradient(135deg, var(--alumni-navy), var(--alumni-navy-light));
        color: var(--alumni-white);
        padding: 25px;
        border-radius: var(--alumni-radius-md) var(--alumni-radius-md) 0 0;
        margin-bottom: 0;
        box-shadow: var(--alumni-shadow-md);
        position: relative;
        overflow: hidden;
    }

    .profile-header::after {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 100%;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" opacity="0.05"><path d="M0 0 L100 0 L100 100 Z" fill="white"/></svg>');
        z-index: 1;
    }

    .profile-header h1 {
        margin: 0;
        font-size: 24px;
        display: flex;
        align-items: center;
        position: relative;
        z-index: 2;
    }

    .profile-header p {
        margin: 10px 0 0;
        opacity: 0.9;
        position: relative;
        z-index: 2;
    }

    .profile-header h1 i {
        margin-right: 15px;
        font-size: 28px;
        color: var(--alumni-gold);
    }

    /* Content area styles */
    .profile-content {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        padding: 30px;
        background: var(--alumni-gray);
        border-radius: 0 0 var(--alumni-radius-md) var(--alumni-radius-md);
        box-shadow: var(--alumni-shadow-md);
    }

    /* Card styles */
    .profile-card {
        background: var(--alumni-white);
        padding: 25px;
        border-radius: var(--alumni-radius-md);
        box-shadow: var(--alumni-shadow-sm);
        transition: transform var(--alumni-transition-fast), box-shadow var(--alumni-transition-fast);
    }

    .profile-card:hover {
        box-shadow: var(--alumni-shadow-md);
    }

    .profile-summary {
        flex: 1;
        min-width: 300px;
    }

    .profile-form {
        flex: 2;
        min-width: 450px;
    }

    /* Section headers */
    .section-header {
        margin-top: 0;
        color: var(--alumni-text-dark);
        font-size: 20px;
        font-weight: 600;
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid var(--alumni-navy-lighter);
    }

    .section-header i {
        color: var(--alumni-gold);
        margin-right: 10px;
    }

    /* Profile photo */
    .profile-photo {
        width: 100px;
        height: 100px;
        background: var(--alumni-navy-lighter);
        border-radius: var(--alumni-radius-circle);
        margin: 0 auto 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 40px;
        color: var(--alumni-navy);
        box-shadow: var(--alumni-shadow-sm);
        text-transform: uppercase;
        border: 2px solid var(--alumni-gold);
    }

    /* Profile info */
    .info-group {
        margin-bottom: 20px;
    }

    .info-center {
        text-align: center;
        margin-bottom: 25px;
    }

    .info-center h3 {
        margin: 0;
        font-size: 20px;
        color: var(--alumni-navy);
    }

    .category-badge {
        display: inline-block;
        background: var(--alumni-gold);
        color: var(--alumni-navy);
        font-size: 12px;
        padding: 3px 10px;
        border-radius: var(--alumni-radius-lg);
        margin-top: 8px;
        font-weight: 600;
    }

    .info-row {
        display: flex;
        margin-bottom: 15px;
        align-items: flex-start;
        color: var(--alumni-text-medium);
    }

    .info-row i {
        width: 20px;
        margin-right: 15px;
        color: var(--alumni-gold);
        margin-top: 4px;
    }

    .info-row p {
        margin: 0;
        font-size: 15px;
    }

    .info-row span {
        font-size: 12px;
        color: var(--alumni-text-light);
    }

    .info-row a {
        color: var(--alumni-navy);
        text-decoration: none;
        transition: color var(--alumni-transition-fast);
    }

    .info-row a:hover {
        color: var(--alumni-gold);
        text-decoration: underline;
    }

    /* Skills container styling */
    .skills-container {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 4px;
    }

    .skill-tag {
        display: inline-block;
        background: var(--alumni-navy-lighter);
        color: var(--alumni-navy);
        font-size: 12px;
        padding: 4px 10px;
        border-radius: var(--alumni-radius-sm);
        font-weight: 500;
        border: 1px solid rgba(11, 28, 57, 0.1);
    }

    /* Button styles */
    .btn {
        display: inline-block;
        padding: 10px 20px;
        border-radius: var(--alumni-radius-sm);
        text-decoration: none;
        font-weight: 500;
        transition: all var(--alumni-transition-fast);
        border: none;
        cursor: pointer;
        text-align: center;
    }

    .btn i {
        margin-right: 8px;
    }

    .btn-primary {
        background: var(--alumni-navy);
        color: var(--alumni-white);
    }

    .btn-primary:hover {
        background: var(--alumni-navy-light);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px var(--alumni-shadow);
    }

    .button-container {
        margin-top: 30px;
        text-align: center;
    }

    /* ACF Form styling */
    .acf-form .acf-label label {
        font-weight: 600 !important;
        color: var(--alumni-text-dark) !important;
        margin-bottom: 12px !important;
        font-size: 16px !important;
        display: block !important;
    }

    .acf-form .acf-input-wrap {
        position: relative;
    }

    .acf-form input[type="text"],
    .acf-form input[type="email"],
    .acf-form input[type="tel"],
    .acf-form input[type="url"],
    .acf-form textarea {
        padding: 12px 15px !important;
        border: 1px solid #ddd !important;
        border-radius: var(--alumni-radius-sm) !important;
        width: 100% !important;
        font-size: 15px !important;
        transition: all var(--alumni-transition-normal) !important;
    }

    .acf-form input[type="text"]:focus,
    .acf-form input[type="email"]:focus,
    .acf-form input[type="tel"]:focus,
    .acf-form input[type="url"]:focus,
    .acf-form textarea:focus {
        border-color: var(--alumni-gold);
        outline: none;
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
    }

    .acf-form textarea {
        min-height: 120px;
        resize: vertical;
    }

    /* Checkbox field styling */
    .acf-checkbox-list {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 5px;
    }

    .acf-checkbox-list li {
        margin-right: 0 !important;
    }

    .acf-checkbox-list label {
        display: flex !important;
        align-items: center;
        padding: 6px 12px;
        background: var(--alumni-gray);
        border-radius: var(--alumni-radius-sm);
        transition: all var(--alumni-transition-fast);
        border: 1px solid var(--alumni-navy-lighter);
        cursor: pointer;
    }

    .acf-checkbox-list label:hover {
        background: rgba(212, 175, 55, 0.1);
        border-color: var(--alumni-gold);
    }

    .acf-checkbox-list label input {
        margin-right: 6px !important;
    }

    .acf-form input[type="submit"],
    .acf-form-submit input[type="submit"],
    .acf-form .acf-button.button-primary,
    .form-modif-membre input[type="submit"].acf-button {
        background: var(--alumni-gold) !important;
        color: var(--alumni-navy) !important;
        border: none !important;
        padding: 14px 24px !important;
        font-size: 16px !important;
        font-weight: 600 !important;
        border-radius: var(--alumni-radius-sm) !important;
        cursor: pointer !important;
        margin-top: 20px !important;
        transition: all var(--alumni-transition-fast) !important;
        position: relative !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 100% !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
    }

    .acf-form input[type="submit"]:hover,
    .acf-form-submit input[type="submit"]:hover,
    .acf-form .acf-button.button-primary:hover,
    .form-modif-membre input[type="submit"].acf-button:hover {
        background: var(--alumni-gold-light) !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 8px var(--alumni-shadow) !important;
    }

    .acf-form .acf-fields {
        border: none !important;
        background: transparent !important;
    }

    .acf-form .acf-field {
        padding: 20px 0;
        border-top: none !important;
    }

    .acf-form .acf-field:not(:last-child) {
        border-bottom: 1px solid var(--alumni-navy-lighter);
    }

    .acf-notice.-success {
        background: #d4edda;
        color: #155724;
        border: none;
        border-radius: var(--alumni-radius-sm);
        padding: 15px 15px 15px 45px;
        margin-bottom: 20px;
        position: relative;
        animation: fadeIn 0.5s ease;
    }

    .acf-notice.-success:before {
        content: "\f058";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 18px;
        color: #155724;
    }

    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .profile-content {
            padding: 20px;
        }

        .profile-form,
        .profile-summary {
            min-width: 100%;
        }

        .profile-header h1 {
            font-size: 20px;
        }

        .profile-header h1 i {
            font-size: 24px;
        }
    }

    /* Improved form styling - Added more specific selectors */
    /* Label styling */
    .acf-form .acf-label label,
    .acf-form-container .acf-label label,
    .form-modif-membre .acf-label label,
    .profile-form .acf-form .acf-label label {
        font-weight: 700 !important;
        color: var(--alumni-navy) !important;
        margin-bottom: 15px !important;
        font-size: 16px !important;
        display: block !important;
        line-height: 1.4 !important;
    }

    /* Placeholder styling */
    .acf-form input::placeholder,
    .form-modif-membre input::placeholder {
        color: var(--alumni-text-light) !important;
        opacity: 0.7 !important;
        font-style: italic !important;
    }

    /* Input fields styling */
    .acf-form input[type="text"],
    .acf-form input[type="email"],
    .acf-form input[type="tel"],
    .acf-form input[type="url"],
    .acf-form textarea,
    .form-modif-membre input[type="text"],
    .form-modif-membre input[type="email"],
    .form-modif-membre input[type="tel"],
    .form-modif-membre input[type="url"],
    .form-modif-membre textarea,
    .profile-form .acf-input-wrap input,
    .profile-card .acf-input-wrap input,
    .profile-form .acf-input-wrap textarea {
        padding: 15px !important;
        height: auto !important;
        line-height: 1.4 !important;
        border: 1px solid #ddd !important;
        border-radius: var(--alumni-radius-sm) !important;
        box-shadow: none !important;
        width: 100% !important;
        font-size: 15px !important;
        background-color: #fff !important;
        transition: all var(--alumni-transition-normal) !important;
        margin-bottom: 5px !important;
    }

    /* Focus state for inputs */
    .acf-form input[type="text"]:focus,
    .acf-form input[type="email"]:focus,
    .acf-form input[type="tel"]:focus,
    .acf-form input[type="url"]:focus,
    .acf-form textarea:focus,
    .form-modif-membre input:focus,
    .form-modif-membre textarea:focus,
    .profile-form .acf-input-wrap input:focus,
    .profile-form .acf-input-wrap textarea:focus {
        border-color: var(--alumni-gold) !important;
        outline: none !important;
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1) !important;
    }

    /* Wrapper for fields */
    .acf-fields>.acf-field {
        padding: 20px 0 !important;
        margin-bottom: 10px !important;
    }

    /* Force new styles with additional CSS injection */
    .acf-form-submit {
        margin-top: 25px !important;
    }
</style>

<div class="profile-container">
    <div class="profile-header">
        <h1>
            <i class="fas fa-user-graduate"></i>
            Mon Profil
        </h1>
        <p>Gérez vos informations personnelles et professionnelles</p>
    </div>

    <div class="profile-content">
        <!-- LEFT COLUMN: Profile Summary -->
        <div class="profile-summary profile-card">
            <h2 class="section-header">
                <i class="fas fa-id-card"></i>
                Informations personnelles
            </h2>

            <div class="info-group">
                <div class="profile-photo">
                    <?php echo substr($prenom, 0, 1) . substr($nom, 0, 1); ?>
                </div>

                <div class="info-center">
                    <h3><?php echo esc_html($prenom . ' ' . $nom); ?></h3>
                    <span class="category-badge"><?php echo esc_html($categorie); ?></span>
                </div>
            </div>

            <div class="info-row">
                <i class="fas fa-envelope"></i>
                <div>
                    <p><?php echo esc_html($email); ?></p>
                    <span>Email</span>
                </div>
            </div>

            <div class="info-row">
                <i class="fas fa-birthday-cake"></i>
                <div>
                    <p><?php echo $naissance; ?></p>
                    <span>Date de naissance</span>
                </div>
            </div>

            <?php if (!empty($phone)): ?>
                <div class="info-row">
                    <i class="fas fa-phone"></i>
                    <div>
                        <p><?php echo esc_html($phone); ?></p>
                        <span>Téléphone</span>
                    </div>
                </div>
            <?php endif; ?>
            

            <?php if (!empty($linkedin)): ?>
                <div class="info-row">
                    <i class="fab fa-linkedin"></i>
                    <div>
                        <p>
                            <a href="<?php echo esc_url($linkedin); ?>" target="_blank">
                                Profil LinkedIn
                            </a>
                        </p>
                        <span>Réseau professionnel</span>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($competences)): ?>
                <div class="info-row">
                    <i class="fas fa-tools"></i>
                    <div>
                        <div class="skills-container">
                            <?php
                            // Handle both array and string cases for competences
                            if (is_array($competences)) {
                                foreach ($competences as $skill) {
                                    echo '<span class="skill-tag">' . trim($skill) . '</span>';
                                }
                            } else {
                                // If it's a string, split by comma
                                $skills = explode(',', $competences);
                                foreach ($skills as $skill) {
                                    if (!empty(trim($skill))) {
                                        echo '<span class="skill-tag">' . trim($skill) . '</span>';
                                    }
                                }
                            }
                            ?>
                        </div>
                        <span>Compétences clés</span>
                    </div>
                </div>
            <?php endif; ?>

            <div class="button-container">
                <a href="<?php echo esc_url(site_url('/dashboard-etudiant')); ?>" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Retour au tableau de bord
                </a>
            </div>
        </div>

        <!-- RIGHT COLUMN: Edit Form -->
        <div class="profile-form profile-card">
            <h2 class="section-header">
                <i class="fas fa-edit"></i>
                Modifier mes informations
            </h2>

            <div class="acf-form-container">
                <?php

                acf_form([
                    'post_id' => $membre_id,
                    'fields' => [
                        'telephone',
                        'promotion',
                        'adresse',
                        'parcours_professionnel',
                        'competences',
                        'linkedin',
                        'cv',
                        'visibilite'
                    ],
                    'submit_value' => 'Enregistrer les modifications',
                    'updated_message' => 'Profil mis à jour avec succès.',
                    'form_attributes' => ['class' => 'form-modif-membre']
                ]);
                ?>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Add Save icon to submit button
                        const submitButton = document.querySelector('.acf-form-submit input[type="submit"]');
                        if (submitButton) {
                            const icon = document.createElement('i');
                            icon.className = 'fas fa-save';
                            icon.style.marginRight = '8px';
                            submitButton.prepend(icon);
                        }

                        // Fix field labels with proper names and icons
                        const labelMap = {
                            'telephone': {
                                text: 'Téléphone',
                                icon: 'fas fa-phone'
                            },
                            'promotion': {
                                text: 'Promotion',
                                icon: 'fas fa-graduation-cap'
                            },
                            'adresse': {
                                text: 'Adresse',
                                icon: 'fas fa-map-marker-alt'
                            },
                            'parcours_professionnel': {
                                text: 'Parcours professionnel',
                                icon: 'fas fa-briefcase'
                            },
                            'competences': {
                                text: 'Compétences',
                                icon: 'fas fa-tools'
                            },
                            'linkedin': {
                                text: 'Profil LinkedIn',
                                icon: 'fab fa-linkedin'
                            },
                            'cv': {
                                text: 'Document (PDF ou DOCX)',
                                icon: 'fas fa-file-pdf'
                            },
                            'visibilite': {
                                text: 'Visibilité du profil',
                                icon: 'fas fa-eye'
                            }
                        };

                        // Apply fixes to all field labels
                        document.querySelectorAll('.acf-field').forEach(field => {
                            const fieldName = field.getAttribute('data-name');
                            if (labelMap[fieldName]) {
                                const label = field.querySelector('.acf-label label');
                                if (label) {
                                    label.innerHTML = `<i class="${labelMap[fieldName].icon}" style="color:var(--alumni-gold);margin-right:8px;"></i>${labelMap[fieldName].text}`;
                                }
                            }
                        });

                        // Add hover effects to cards
                        const cards = document.querySelectorAll('.profile-card');
                        cards.forEach(card => {
                            card.addEventListener('mouseenter', function() {
                                this.style.transform = 'translateY(-5px)';
                            });
                            card.addEventListener('mouseleave', function() {
                                this.style.transform = 'translateY(0)';
                            });
                        });

                        // Indicate required fields with asterisk
                        const requiredLabels = document.querySelectorAll('.acf-required .acf-label label');
                        requiredLabels.forEach(label => {
                            const asterisk = document.createElement('span');
                            asterisk.textContent = ' *';
                            asterisk.style.color = '#e74c3c';
                            label.appendChild(asterisk);
                        });

                        // Amélioration du champ Promotion avec retry
                        function addPromotionPlaceholder() {
                            const promotionField = document.querySelector('.acf-field[data-name="promotion"]');
                            if (promotionField) {
                                const input = promotionField.querySelector('input[type="text"]') || 
                                             promotionField.querySelector('input[type="number"]') ||
                                             promotionField.querySelector('input');
                                if (input) {
                                    input.setAttribute('placeholder', 'exemple : 2025');
                                    input.style.fontStyle = 'normal';
                                    console.log('Placeholder added to promotion field');
                                    return true;
                                }
                            }
                            return false;
                        }

                        // Try immediately, then retry every 500ms for up to 5 seconds
                        if (!addPromotionPlaceholder()) {
                            let retryCount = 0;
                            const maxRetries = 10;
                            const retryInterval = setInterval(() => {
                                if (addPromotionPlaceholder() || retryCount >= maxRetries) {
                                    clearInterval(retryInterval);
                                }
                                retryCount++;
                            }, 500);
                        }

                        // Amélioration du champ CV
                        const cvField = document.querySelector('.acf-field[data-name="cv"]');
                        if (cvField) {
                            // Ajouter un message d'aide
                            const description = document.createElement('p');
                            description.className = 'description';
                            description.innerHTML = '<small>Formats acceptés : PDF ou DOCX uniquement. Taille maximale : 5MB.</small>';
                            description.style.color = 'var(--alumni-text-medium)';
                            description.style.marginTop = '6px';
                            cvField.querySelector('.acf-input').appendChild(description);

                            // Ajouter une validation pour les types de fichiers
                            const fileInput = cvField.querySelector('input[type="file"]');
                            if (fileInput) {
                                fileInput.setAttribute('accept', '.pdf,.docx,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document');

                                fileInput.addEventListener('change', function(e) {
                                    const file = this.files[0];
                                    if (file) {
                                        // Vérifier l'extension
                                        const extension = file.name.split('.').pop().toLowerCase();
                                        const allowedTypes = ['pdf', 'docx'];

                                        if (!allowedTypes.includes(extension)) {
                                            alert('Format de fichier non accepté. Veuillez sélectionner un fichier PDF ou DOCX.');
                                            this.value = '';
                                            return false;
                                        }

                                        // Vérifier la taille (5MB max)
                                        if (file.size > 5 * 1024 * 1024) {
                                            alert('Le fichier est trop volumineux. La taille maximale autorisée est de 5MB.');
                                            this.value = '';
                                            return false;
                                        }
                                    }
                                });
                            }

                            // Améliorer l'affichage du fichier actuel
                            const currentFile = cvField.querySelector('.acf-file-uploader.has-value .file-info');
                            if (currentFile) {
                                const fileName = currentFile.querySelector('a').textContent;
                                const extension = fileName.split('.').pop().toLowerCase();

                                // Ajouter une icône selon le type de fichier
                                const icon = document.createElement('i');
                                icon.className = extension === 'pdf' ? 'fas fa-file-pdf' : 'fas fa-file-word';
                                icon.style.marginRight = '8px';
                                icon.style.color = extension === 'pdf' ? '#e74c3c' : '#3498db';
                                icon.style.fontSize = '16px';

                                currentFile.querySelector('a').prepend(icon);
                            }
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<?php get_footer('etudiant'); ?>