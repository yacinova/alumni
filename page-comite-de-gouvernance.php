<?php
/**
 * Template Name: Landing Page Alumni ESG
 * Description: Template personnalisé pour la page d'accueil Alumni ESG Maroc
 */

// Chargement conditionnel du header selon que l'utilisateur est connecté ou non
if (is_user_logged_in() && current_user_can('etudiant')) {
    get_template_part('header', 'etudiant');
} else {
    get_header();
}

?>


<main class="container py-5">
    <h1 class="mb-4 border-bottom pb-2">Comité de gouvernance</h1>

    <!-- Président -->
    <section class="mb-5">
        <h2 class="h4 mb-3">Président</h2>
        <div class="row justify-content-center">
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <img src="/wp-admin/images/Karim.jpg" alt="Karim MENJOUR" class="rounded-circle mb-3" style="width:90px; height:90px; object-fit:cover;">
                        <h5 class="card-title mb-1">Monsieur Karim <br><strong>MENJOUR</strong></h5>
                        <p class="text-muted mb-0">Président</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Vice-Président -->
    <section class="mb-5">
        <h2 class="h4 mb-3">Vice-Président</h2>
        <div class="row justify-content-center">
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <img src="/wp-admin/images/Issam.jpg" alt="Issam BENJELLOUN" class="rounded-circle mb-3" style="width:90px; height:90px; object-fit:cover;">
                        <h5 class="card-title mb-1">Monsieur Issam <br><strong>BENJELLOUN</strong></h5>
                        <p class="text-muted mb-0">Vice-Président</p>
                    </div>
                </div>
            </div>
            <!-- Add more Vice-Président cards here if needed -->
        </div>
    </section>

    <!-- Trésorier -->
    <section class="mb-5">
        <h2 class="h4 mb-3">Trésorier</h2>
        <div class="row justify-content-center">
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <img src="/assets/images/members/youness-lamarti.jpg" alt="Youness LAMARTI" class="rounded-circle mb-3" style="width:90px; height:90px; object-fit:cover;">
                        <h5 class="card-title mb-1">Monsieur Youness <br><strong>LAMARTI</strong></h5>
                        <p class="text-muted mb-0">Trésorier</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Secrétaire Général & Adjoint -->
    <section class="mb-5">
        <h2 class="h4 mb-3">Secrétaire Général &amp; Secrétaire Général Adjoint</h2>
        <div class="row justify-content-center">
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <img src="/wp-admin/images/Ikram.jpg" alt="Ikram DOUADI" class="rounded-circle mb-3" style="width:90px; height:90px; object-fit:cover;">
                        <h5 class="card-title mb-1">Madame Ikram <br><strong>DOUADI</strong></h5>
                        <p class="text-muted mb-0">Secrétaire Général</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <img src="/wp-admin/images/Anas%20.jpg" alt="Anas CHORFI" class="rounded-circle mb-3" style="width:90px; height:90px; object-fit:cover;">
                        <h5 class="card-title mb-1">Monsieur Anas <br><strong>CHORFI</strong></h5>
                        <p class="text-muted mb-0">Secrétaire Général Adjoint</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Bootstrap JS (optional, for interactivity) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php 
// Chargement conditionnel du footer selon que l'utilisateur est connecté ou non
if (is_user_logged_in() && current_user_can('etudiant')) {
    get_template_part('footer', 'etudiant');
} else {
    get_footer();
}
?>